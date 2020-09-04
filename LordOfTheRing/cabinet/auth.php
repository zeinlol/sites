<?php
	$cms = $config_lk['cms'];
	
	if ( !isset($_SESSION['shop_attempt_login']) ) {
		$_SESSION['shop_attempt_login'] = 0;
	}
	
	if ( $cms['s_userid'] != false || isset($_SESSION[$config_lk['s_name']]) || $_SESSION['shop_attempt_login'] >= 5 )
		die ();
	
	if ( isset($_POST['input']) )
	{
		$db = new PDO('mysql:host='.$config_lk['db']['host'].';dbname='.$config_lk['db']['name'], $config_lk['db']['user'], $config_lk['db']['pass']);
		$db->query("SET NAMES '".$config_lk['db']['char']."'");
		
		$login = $db->quote($_POST['login']);
		$pass = $_POST['pass'];
		
		if ( strlen($login) < 20 && strlen($pass) < 30 )
		{
			$_user = $db->query("SELECT `{$cms['c_userid']}`, `{$cms['c_name']}`,`{$cms['c_userpass']}` FROM {$cms['t_users']} WHERE `{$cms['c_name']}` = {$login}")->fetch(PDO::FETCH_ASSOC);
			$real_pass = $_user[$cms['c_userpass']];
			
			if ( $real_pass == hashPass($cms['h_pass'], $pass, $real_pass) )
			{
				
				$_SESSION[$config_lk['s_name']] = $_user[$cms['c_userid']];
				unset($_SESSION['shop_attempt_login']);
				header('Location: index.php');
				
			} else
			{
				
				$msg = 'Неверный логин/пароль. Осталось '.(5 - $_SESSION['shop_attempt_login'] ++).' попыток.';
				
			}	
		}
	}
	
	function hashPass($hash, $password, $real_pass)
	{
		switch ( $hash )
		{
			
			case 'hash_dle' : {
				
				return md5(md5($password));
				
			}
			
			case 'hash_webmcr' : {
				
				return md5($password);     
				
			}
			
			case 'hash_drupal' : {
				
				$cryptPass = '';
				$setting = substr($real_pass, 0, 12);
				$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
				$count_log2 = strpos($itoa64, $setting[3]);
				$salt = substr($setting, 4, 8);
				$count = 1 << $count_log2;
				$input = hash('sha512', $salt . $password, TRUE);
				do $input = hash('sha512', $input . $password, TRUE);
				while (--$count);

				$count = strlen($input);
				$i = 0;
		  
				do {
						$value = ord($input[$i++]);
						$cryptPass .= $itoa64[$value & 0x3f];
						if ($i < $count) $value |= ord($input[$i]) << 8;
						$cryptPass .= $itoa64[($value >> 6) & 0x3f];
						if ($i++ >= $count) break;
						if ($i < $count) $value |= ord($input[$i]) << 16;
						$cryptPass .= $itoa64[($value >> 12) & 0x3f];
						if ($i++ >= $count) break;
						$cryptPass .= $itoa64[($value >> 18) & 0x3f];
				} while ($i < $count);
				
				return substr($setting . $cryptPass, 0, 55);
				
			}
			
			case 'hash_joomla' : { // v1.6 - v1.7
				
				$parts = explode( ':', $real_pass);
				$salt = $parts[1];
				return md5($password . $salt) . ":" . $salt;
				
			}
			
			case 'hash_new_joomla' :
			//case 'hash_xf' :
			case 'hash_wp' : {
				
				$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
				$cryptPass = '*0';
				if (substr($real_pass, 0, 2) == $cryptPass)
					$cryptPass = '*1';

				$id = substr($real_pass, 0, 3);
				
				if ($id != '$P$' && $id != '$H$')
					return crypt($password, $real_pass);

				$count_log2 = strpos($itoa64, $real_pass[3]);
				if ($count_log2 < 7 || $count_log2 > 30)
					return crypt($password, $real_pass);

				$count = 1 << $count_log2;

				$salt = substr($real_pass, 4, 8);
				if ( strlen($salt) != 8 )
					return crypt($password, $real_pass);

					$hash = md5($salt . $password, TRUE);
					do {
						$hash = md5($hash . $password, TRUE);
					} while (--$count);

				$cryptPass = substr($real_pass, 0, 12);
				
				$encode64 = '';
				$i = 0;
				do {
					$value = ord($hash[$i++]);
					$encode64 .= $itoa64[$value & 0x3f];
					if ($i < 16)
						$value |= ord($hash[$i]) << 8;
					$encode64 .= $itoa64[($value >> 6) & 0x3f];
					if ($i++ >= 16)
						break;
					if ($i < 16)
						$value |= ord($hash[$i]) << 16;
					$encode64 .= $itoa64[($value >> 12) & 0x3f];
					if ($i++ >= 16)
						break;
					$encode64 .= $itoa64[($value >> 18) & 0x3f];
				} while ($i < 16);
				
				$cryptPass .= $encode64;

				if ($cryptPass[0] == '*')
					return crypt($password, $real_pass);
				else return $cryptPass;
				
			}
			
			case 'hash_myhash' : {
				
				//Ваш хеш паролей
				return 'hashpass';
				
			}
			
			default : {
				
				$msg = 'Не найден алгоритм хеширования паролей.';
				
			}
			
		}
	}
?>

<h2>Войти в Личный кабинет</h2>
<?php echo(isset($msg) ? '<h3>'.$msg.'</h3>' : '' )?>

<form method="POST">
	Логин:<br/>
	<input type="text" name="login" placeholder="Введите свой логин" class="input"/><br/>
	Пароль:<br/>
	<input type="password" name="pass" placeholder="Введите свой пароль" class="input"/><br/><br/>
	<input type="submit" name="input" class="button" value="Войти в магазин"/>
</form>

<style>
	
	body {
		font-family: tahoma;
	}
	
	.input {
		outline: 0;
		width: 200px;
		padding: 5px;
		border: 1px solid #D4D4D4;
	}
	
	.button {
		padding: 5px;
	}
	
</style>