<?php
	session_start();
	
	define ( 'ROOT_LK_DIR', dirname ( __FILE__ ) );
	
	include(ROOT_LK_DIR . '/config.php');
	include(ROOT_LK_DIR . '/class/_user.class.php');
	include(ROOT_LK_DIR . '/class/lk.class.php');
	
	$lk = new lk( $config_lk );
	
	$json_permission = '{
		"status": "error",
		"message": "У вас нет прав для совершения данного действия."
	}';
	
	$json = '{
		"status": "error",
		"message": "Произошла ошибка."
	}';
	
	if ( !$lk->isKeyCSRF( $lk->getReq('key') ) ) {
		die( '{
			"status": "error",
			"message": "Неверный ключ."
		}' );
	}
	
	if ( $lk->cfg['anti_ddos'] != false && $lk->getReq('type') != 'showSkins' )
	{
		$time = time();
		$time_ = isset($_SESSION['lk_antiddos']) ? $_SESSION['lk_antiddos'] : 0;
		
		if ( $time - $time_ < $lk->cfg['anti_ddos'] ) {
			die('{
				"status": "error",
				"message": "Пожалуйста, подождите '.($lk->cfg['anti_ddos'] - ($time - $time_) + 1).' секунд..."
			}');
		} else
			$_SESSION['lk_antiddos'] = $time;
	}
	
	switch ( $lk->getReq('type') )
	{
		case 'upload': {
			if ( is_uploaded_file($_FILES['file']['tmp_name']) )
			{
				$size = getimagesize($_FILES['file']['tmp_name']);
				
				if ( $_FILES['file']['size'] <= $lk->cfg['skin']['max_size_mb'] * 1024 * 1024 && $_FILES['file']['type'] == 'image/png' ) 
				{
					if ( $lk->getReq('type_upload') == 1 )
					{	
						$path = ROOT_LK_DIR . $lk->cfg['skin']['path_to_skin'] . $lk->user['name'] . '.png';
						
						if ( $size[0] == 64 && ($size[1] == 32 || $size[1] == 64) )
						{
							if ( !$lk->isHaveRight( 'upload_skin' ) ) die( $json_permission );
							
							if ( move_uploaded_file($_FILES['file']['tmp_name'], $path) )
							{
								$json = '{
									"status": "success",
									"message": "Скин загружен."
								}';
								
							} else
								$json = '{
									"status": "error",
									"message": "Ошибка загрузки скина."
								}';
						} else if ( !($size[0] % 256) && !($size[1] % 128) /*$size[0] == 256 && $size[1]== 128 || $size[0] == 1024 && $size[1] == 512*/)
						{
							if ( !$lk->isHaveRight( 'upload_hd_skin' ) ) die( $json_permission );
							
							if ( move_uploaded_file($_FILES['file']['tmp_name'], $path) )
							{
								$json = '{
									"status": "success",
									"message": "HD скин загружен."
								}';
								
							}
						} else
							$json = '{
								"status": "error",
								"message": "Неверные размеры скина."
							}';
					} else {
						$path = ROOT_LK_DIR . $lk->cfg['skin']['path_to_cloak'] . $lk->user['name'] . '.png';
						
						if ( $size[0] == 64 && $size[1] == 32 || $size[0] == 22 && $size[1] == 17) 
						{
							if ( !$lk->isHaveRight( 'upload_cloak' ) ) die( $json_permission );
							
							if ( move_uploaded_file($_FILES['file']['tmp_name'], $path) )
							{
								$json = '{
									"status": "success",
									"message": "Плащ загружен."
								}';
								
							}
						} else if ( !($size[0] % 256) && !($size[1] % 128) /*$size[0] == 512 && $size[1] == 256 || $size[0] == 1024 && $size[1] == 512*/)
						{
							if ( !$lk->isHaveRight( 'upload_hd_cloak' ) ) die( $json_permission );
							
							if ( move_uploaded_file($_FILES['file']['tmp_name'], $path) )
							{
								$json = '{
									"status": "success",
									"message": "HD плащ загружен."
								}';
								
							}
						} else
							$json = '{
								"status": "error",
								"message": "Неверные размеры плаща."
							}';
					}
				} else
					$json = '{
						"status": "error",
						"message": "Файл должен быть формата png!"
					}';
			}
			break;
		}
		
		case 'buy_status': {
			
			$serverid = (int)$lk->getReq('serverid');
			$statusid = (int)$lk->getReq('statusid');
			$time_day = (int)$lk->getReq('time_day');
			
			if ( is_numeric($serverid) && is_numeric($statusid) && is_numeric($time_day) )
			{
				$status_info = $lk->cfg['status'][$statusid];
				
				if ( $lk->cfg['server'][$serverid]['enable'] && $status_info['enable'] && $statusid < 3 && $lk->cfg['status'][$lk->user['status'][$serverid][0]]['right']['buy_status'] && $lk->cfg['server'][$serverid]['right']['buy_status'] )
				{
					if ( $lk->cfg['server'][$serverid]['status'][$statusid] ) {
						if ( $status_info['set_days'] && $time_day > 0 ) {
							$price = round($status_info['price'] / $status_info['buy_days'] * $time_day);
						} else {
							$time_day = $status_info['buy_days'];
							$price = $status_info['price'];
						}
						
						if ( $lk->user['money'] >= $price )
						{
							$_db = $lk->getServerDB($serverid);
							
							$lk->setStatus($_db, $serverid, $lk->user['name'], $statusid);
							$lk->setStatusUser($lk->user['id'], $serverid, $statusid, time() + $time_day * 86400, $lk->user['prefix'][$serverid], $lk->user['unban_count'][$serverid]);
							$lk->give_money(-$price);
							
							$entity_info = $lk->cfg['server'][$serverid]['entity'];
							if ( $entity_info != false ) {
								$entity = $lk->getEntity( $_db, $serverid, $lk->user['name'] );
								
								if ( !isset( $entity['id'] ) ) {
									$lk->setEntity( $_db, $serverid, $lk->user['name'], $entity_info['type'], $entity_info['default'] );
								}
							}
							
							$json = '{
								"status": "success"
							}';
							$lk->logWrite('купил статус '. $status_info['name'] .' на '. $time_day .' дней');
						}
					} else
						$json = '{
							"status": "error",
							"message": "Данный статус не покупается на выбранный сервер!"
						}';
				}
			}
			
			break;
		}
		
		case 'extend_status': {
			
			$serverid = (int)$lk->getReq('serverid');
			$time_day = (int)$lk->getReq('time_day');
			
			if ( is_numeric($serverid) && is_numeric($time_day) && $lk->cfg['server'][$serverid]['enable'] && $serverid < 3 && $lk->cfg['server'][$serverid]['right']['extend_status'] )
			{
				$status = $lk->user['status'][$serverid];
				
				if ( $status[0] > 0 )
				{
					$status_info = $lk->cfg['status'][$status[0]];
					
					if ( $status_info['set_days'] && $time_day > 0 ) {
						$price = round($status_info['price'] / $status_info['buy_days'] * $time_day);
					} else {
						$time_day = $status_info['buy_days'];
						$price = $status_info['price'];
					}
					
					if ( $lk->user['money'] >= $price )
					{
						$lk->setStatusUser($lk->user['id'], $serverid, $status[0], $status[1] + $time_day * 86400, $lk->user['prefix'][$serverid], $lk->user['unban_count'][$serverid]);
						$lk->give_money(-$price);
						
						$json = '{
							"status": "success"
						}';
						$lk->logWrite('продлил статус '. $status_info['name'] .' на '. $time_day .' дней');
					}
				}
			}
			
			break;
		}
		
		case 'set_prefix': {
			$serverid = (int)$lk->getReq('serverid');
			$color_prefix = (int)$lk->getReq('color_prefix');
			$color_nickname = (int)$lk->getReq('color_nickname');
			$color_message = (int)$lk->getReq('color_message');
			$name_prefix = $lk->getReq('name_prefix');
			
			if ( !$lk->cfg['server'][$serverid]['enable']
				|| !$lk->isNumIn($color_prefix, 0, 15)
				|| !$lk->isNumIn($color_nickname, 0, 15)
				|| !$lk->isNumIn($color_message, 0, 15)
				|| !preg_match('/^[a-z0-9]{'. $lk->cfg['prefix']['prefix_min_len'] .','. $lk->cfg['prefix']['prefix_max_len'] .'}$/si', $name_prefix)
				|| !$lk->cfg['status'][$lk->user['status'][$serverid][0]]['right']['set_prefix']
				|| !$serverid >= 3
				|| !$lk->cfg['server'][$serverid]['right']['set_prefix']
			)
			{
				die('{
					"status": "error",
					"message": "Неверный формат префикса или у вас нет прав для установки префикса."
				}');
			}
			
			$colors = array('f', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e');
			$format = $lk->cfg['prefix']['prefix_format'];
			$prefix = $format[0] . '&'.$colors[$color_prefix] . $name_prefix . $format[1] . '&'.$colors[$color_nickname];
			$suffix = $format[2] . '&'.$colors[$color_message] . $format[3];
			
			$lk->setPrefix( $lk->getServerDB($serverid), $serverid, $lk->user['name'], $prefix, $suffix );
			$lk->setStatusUser($lk->user['id'], $serverid, $lk->user['status'][$serverid][0], $lk->user['status'][$serverid][1], Array($color_prefix, $name_prefix, $color_nickname, $color_message), $lk->user['unban_count'][$serverid]);
			
			$json = '{
				"status": "success"
			}';
			$lk->logWrite('установил префикс ' . $prefix . $suffix);
			
			break;
		}
		
		case 'exchange_iconomy': {
			if ( !$lk->cfg['exchange']['iconomy']['enable'] ) die( $json );
			
			$serverid = $lk->user['icmoney'] ? 0 : (int)$lk->getReq('serverid');
			$value = (int)$lk->getReq('value');
			
			if ( !$lk->cfg['server'][$serverid]['enable'] || !$lk->isNumIn($value, 1, 50000) || $serverid >= 3 || !$lk->cfg['server'][$serverid]['right']['exchange'] ) die( $json );
			
			if ( $lk->getReq('type_exchange') != '0' )
			{
				$price = ceil($value * $lk->cfg['exchange']['iconomy']['price_u_cur']);
				$_db = !$lk->cfg['exchange']['iconomy']['ic_money_viem'] ? $lk->getServerDB($serverid) : $lk->db;
				
				if ( $lk->get_money_ic( $_db, $serverid, $lk->user['name'] ) >= $price )
				{
					$lk->give_money_ic( $_db, $serverid, $lk->user['name'], -$price );
					$lk->give_money($value);
					$lk->logWrite('совершил обмен на '.$price.' монет за '.$value.$lk->cfg['cur'][1]);
				} else
					die( $json );
					
				$money = $value;
				$icmoney = -$price;
			}
			
			$json = '{
				"status": "success",
				"money": '.$money.',
				"icmoney": '.$icmoney .'
			}';
			
			break;
		}
		
		case 'unban': {
			if ( !$lk->cfg['other']['unban']['enable'] ) die( $json );
			$cfg_unban = $lk->cfg['other']['unban'];
			
			$serverid = !$cfg_unban['unban_all'] ? (int)$lk->getReq('serverid') : 0;
			
			if ( $lk->cfg['server'][$serverid]['enable'] && $lk->cfg['server'][$serverid]['right']['unban'] && $serverid < 3 )
			{
				$price = $lk->getUnbanPrice($serverid);
				
				if ( $lk->user['money'] >= $price )
				{
					$_db = !$lk->cfg['other']['unban']['unban_all'] ? $lk->getServerDB($serverid) : $lk->db;
					
					if ( $cfg_unban['unban_all'] ) {
						$ban = $lk->user['ban'];
					} else {
						$ban = $lk->getBan( $_db, $serverid, $lk->user['name'] );
					}
					
					if ( !empty( $ban['name'] ) )
					{
						$lk->unban( $_db, $serverid, $lk->user['name'] );
						$lk->give_money(-$price);
						$lk->setStatusUser($lk->user['id'], $serverid, $lk->user['status'][$serverid][0], $lk->user['status'][$serverid][1], $lk->user['prefix'][$serverid], ++ $lk->user['unban_count'][$serverid]);
						
						$json = '{
							"status": "success",
							"money": '.$price.'
						}';
						
						$lk->logWrite('разбанился за ' . $price . $lk->cfg['cur'][1]);
					} else
						$json = '{
							"status": "error",
							"message": "Вы не забанены."
						}';
				} else
					$json = '{
						"status": "error",
						"message": "Нет денег."
					}';
			}
			
			break;
		}
		
		case 'vaucher': {
			$vaucher_cfg = $lk->cfg['other']['vaucher'];
			if ( !$vaucher_cfg['enable'] ) die( $json );
			
			$name = $lk->getReq('name');
			
			if ( preg_match('/^\w{'. $vaucher_cfg['len'][0] .','. $vaucher_cfg['len'][1] .'}$/si', $name) ) {
				
				$vaucher = $lk->getVaucher( $name );
				
				if ( $vaucher['id'] ) {
					$lk->deleteVaucher( $vaucher['id'] );
					
					if ( empty($vaucher['eval']) ) $vaucher['eval'] = $vaucher_cfg['eval'];
					
					$evals = explode('/', $vaucher['eval']);
					for ( $i = 0, $Max = count($evals); $i < $Max; $i ++ ) {
						eval( '$lk->' . $evals[$i] . ';' );
					}
					
					$json = '{
						"status": "success",
						"message": "'. $vaucher['message'] .'"
					}';
				} else
					$json = '{
						"status": "error",
						"message": "Ваучер не действителен!"
					}';
			}
			
			break;
		}
		
		case 'buyright': {
			if ( !$lk->cfg['rights']['enable'] ) die( $json );
			
			$right_id = (int)$lk->getReq('right_id');
			
			if ( $lk->isNumIn($right_id, 0, count($lk->cfg['rights']['right'])) ) {
				
				$right = $lk->cfg['rights']['right'][$right_id];
				
				if ( $right[4] && $lk->user['money'] >= $right[3] ) {
					$lk->setRight( $lk->user['id'], $right[2], true );
					$lk->give_money(-$right[3]);
					
					$json = '{
						"status": "success",
						"money": '. $right[3] .'
					}';
				} else
					$json = '{
						"status": "error",
						"message": "Не хватает денег для покупки данного права!"
					}';
			}
			
			break;
		}
	}
	
	echo $json;
?>