<?php

	class lk extends _user {
		
		public $db;
		public $dbs = array();
		public $user = array();
		public $cfg = array();
		public $tpl = array();
		public $req = array();
		public $path;
		
		function __construct( $config_lk, $user__ = false )
		{
			$this->cfg = $config_lk;
			$this->DB_connect();
			
			if ( !$user__ )
			{	
				$userid_ses = $this->get_session();
				
				if ( $userid_ses == -1 || $userid_ses == 0 )
				{
					die (' Необходима авторизация! ');
					
				} else if ( $userid_ses == -2 ) {
				
					include( ROOT_LK_DIR . '/auth.php' );
					exit();
					
				} else {
				
					$this->init($this->init_user( $userid_ses ));	
					
				}
			}
			
			if ( $this->cfg['insite'] ) {
				$this->path = substr(str_replace($_SERVER['DOCUMENT_ROOT'], "", str_replace('\\', '/', ROOT_LK_DIR)), 1) . '/';
			} else $this->path = '';
			
			$this->req_filter( $_REQUEST );
			
			if ( $this->cfg['selectTpl'] && $this->getReq('tpl') != 0 ) {
				
				$tpl_name = $this->getReq('tpl');
				
				if ( preg_match('/^[a-z0-9_]{0,30}$/si', $tpl_name) && file_exists(ROOT_LK_DIR . '/templates/' . $tpl_name) ) {
					
					$this->cfg['template'] = $tpl_name;
					
				} else {
					die ( 'Ошибка: шаблон не найден!' );
				}
			}
			
			//$this->setEntity( $this->getServerDB(0), 0, $this->user['name'], 4, 10 );
			//var_dump($this->getEntity( $this->getServerDB(0), 0, $this->user['name'] ));
			//$this->setStatus( $this->getServerDB(0), 0, $this->user['name'], 0 );
			//$arr = $this->getPrefix( $this->getServerDB(0), 0, $this->user['name'] );
			//$this->setPrefix( $this->getServerDB(0), 0, $this->user['name'], '&2[admin]&3', '&6' );
			//$this->deletePrefix( $this->getServerDB(0), 0, $this->user['name'] );
			//$this->setWarp( $this->getServerDB(0), 0, $this->user['name'], Array('warpik', -1, 'world', 3.5, 6.9, 1.1, 1, 'Hi!') );
			//$this->deleteWarpByName( $this->getServerDB(0), 0, 'warpik' );
			
			//$this->AddVaucher( 'eval' );
			
			header("Content-type: text/html; charset=".$this->cfg['charset']);
		}
		
		public function init( $userinfo )
		{
			$this->user = $userinfo;
			$this->user['id'] 		= $this->user[ $this->cfg['cms']['c_userid'] ];
			$this->user['name'] 	= $this->user[ $this->cfg['cms']['c_name'] ];
			$this->user['money'] 	= $this->user[ $this->cfg['cms']['c_money'] ];
			
			for( $i = 0, $Max = count($this->cfg['rights']['right']); $i < $Max; $i ++ ) {
				$right = $this->cfg['rights']['right'][$i];
				if ( $right[4] ) {
					$this->user['right'][$right[1]] = (bool)$this->user[ $right[2] ];
				}
			}
			
			if ( $this->cfg['exchange']['iconomy']['ic_money_viem'] ) {
				$this->user['icmoney'] = $this->get_money_ic( $this->db, 0, $this->user['name'] );
			} else $this->user['icmoney'] = false;
			
			if ( $this->cfg['other']['unban']['unban_all'] ) {
				$this->user['ban'] = $this->getBan( $this->db, 0, $this->user['name'] );
			} else $this->user['ban'] = Array(false, false, false, false);
			
			if ( !isset($_SESSION['csrf_key']) )
				$_SESSION['csrf_key'] = $this->generateKeyCSRF();
			$this->user['key'] = $_SESSION['csrf_key'];
			
			if ( count($this->cfg['server']) > 3 ) {
				exit ('В бесплатной версии может быть не больше 3 серверов!');
			}
			
			if ( count($this->cfg['status']) > 3 ) {
				exit ('В бесплатной версии может быть не больше 3 статусов!');
			}
			
			for( $i = 0, $Max = count($this->cfg['server']); $i < $Max; $i ++ ) {
				$info = $this->getInfo($i);
				
				if ( $info[0] != 0 )
				{
					$this->user['status'][$i] = explode('/', $info[0]);
					$this->user['prefix'][$i] = explode('/', $info[1]);
					$this->user['unban_count'][$i] = (int)$info[2];
				} else {
					$this->user['status'][$i] = Array(0, 0);
					$this->user['prefix'][$i] = Array(1, 'Player', 1, 1);
					$this->user['unban_count'][$i] = 0;
				}
			}
		}
		
		public function connectTo()
		{
			for( $i = 0, $Max = count($this->cfg['server']); $i < $Max; $i ++ ) {
				$this->dbs[$i] = $this->getServerDB( $i );
			}
		}
		
		private function DB_connect()
		{
			$this->db = new PDO('mysql:host='.$this->cfg['db']['host'].';dbname='.$this->cfg['db']['name'], $this->cfg['db']['user'], $this->cfg['db']['pass']);
			$this->db->query("SET NAMES '".$this->cfg['db']['char']."'");
		}
		
		public function DB_server_connect( $server_id )
		{
			$_db = new PDO('mysql:host='.$this->cfg['server'][$server_id]['db']['host'].';dbname='.$this->cfg['server'][$server_id]['db']['name'], $this->cfg['server'][$server_id]['db']['user'], $this->cfg['server'][$server_id]['db']['pass']);
			$_db->query("SET NAMES '".$this->cfg['server'][$server_id]['db']['char']."'");
			return $_db;
		}
		
		public function getServerDB( $server_id )
		{
			if ( $this->cfg['server'][$server_id]['db'] != false ) {
				return $this->DB_server_connect( $server_id );
			} else {
				return $this->db;
			}
		}
		
		private function req_filter( $_REQ )
		{
			foreach( $_REQ as $key=>$val )
			{
				if ( !is_array( $val ) )
				{
					$this->req[$key] = strip_tags( $val );
				} else {
					$this->req[$key] = array();
					
					foreach( $val as $key2=>$val2 )
					{
						$this->req[$key][$key2] = strip_tags( $val2 );
					}	
				}		
			}
		}
		
		public function getReq( $index )
		{
			return (isset( $this->req[ $index ] ) ? $this->req[ $index ] : 0);
		}
		
		public function getNameCur( $price )
		{
			if ( $price % 100 > 9 && $price % 100 < 21 ) return $this->cfg['cur'][2];
			
			$price = $price % 10;
			
			if ( $price == 1 )
				return $this->cfg['cur'][4];
			else if ( $price > 1 && $price < 5 )
				return $this->cfg['cur'][3];
			else
				return $this->cfg['cur'][2];
		}
		
		public function isMultiServers()
		{
			return ($this->cfg['server'][0]['name'] != 'all');
		}
		
		public function isUUIDServer( $server_id )
		{
			return ($this->cfg['server'][$server_id]['uuid']);
		}
		
		public function isNum( $num )
		{
			return ((int)$num + '' == $num);
		}
		
		public function isNumIn( $num, $min, $max )
		{
			return ( is_numeric($num) && $num >= $min && $num <= $max );
		}
		
		public function logWrite( $message )
		{
			return 1;
		}
		
		public function addVaucher( $vaucher, $eval, $message )
		{
			$sth = $this->db->prepare("INSERT INTO `lk_vauchers` VALUES(NULL, :vaucher, :eval, :message)");
			$sth->bindParam(':vaucher', $vaucher, PDO::PARAM_STR);
			$sth->bindParam(':eval', $eval, PDO::PARAM_STR);
			$sth->bindParam(':message', $message, PDO::PARAM_STR);
			return $sth->execute();
		}
		
		public function deleteVaucher( $id )
		{
			$sth = $this->db->prepare("DELETE FROM `lk_vauchers` WHERE `id` = :id");
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			return $sth->execute();
		}
		
		public function getVaucher( $vaucher )
		{
			$sth = $this->db->prepare("SELECT * FROM `lk_vauchers` WHERE `name` = :vaucher");
			$sth->bindParam(':vaucher', $vaucher, PDO::PARAM_STR);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_ASSOC);
		}
		
		public function outputServers( $filename )
		{
			if ( $this->cfg['server'] == false ) return 0;
			
			$output = '';
			
			for( $i = 0, $Max = count($this->cfg['server']); $i < $Max; $i ++ ) {
				if ( $this->cfg['server'][$i]['enable'] )
				{
					$this->tpl['server_info'] = $this->cfg['server'][$i];
					
					if ( $this->user['server_' . $i] != '' )
					{
						$this->tpl['status'] = $this->cfg['status'][$this->user['status'][$i][0]];
						$this->tpl['end_time'] = $this->user['status'][$i][1];
					} else {
						$this->tpl['status'] = $this->cfg['status'][0];
						$this->tpl['end_time'] = 0;
					}
					
					ob_start();
					include(ROOT_LK_DIR . '/templates/'.$this->cfg['template'].'/output_'. $filename .'.tpl');
					$output .= ob_get_clean();
				}
			}

			return $output;
		}
		
		public function outputStatuses( $filename )
		{
			$output = '';
			
			for( $i = 0, $Max = count($this->cfg['status']); $i < $Max; $i ++ ) {
				if ( $this->cfg['status'][$i]['enable'] )
				{
					$this->tpl['status_info'] = $this->cfg['status'][$i];
					ob_start();
					include(ROOT_LK_DIR . '/templates/'.$this->cfg['template'].'/output_'. $filename .'.tpl');
					$output .= ob_get_clean();
				}
			}

			return $output;
		}
		
		public function outputServerAsOption()
		{
			$output = '';
			
			for( $i = 0, $Max = count($this->cfg['server']); $i < $Max; $i ++ ) {
				if ( $this->cfg['status'][$i]['enable'] )
				{
					$output .= '<option value="'. $i .'">Сервер '. $this->cfg['server'][$i]['name'] .'</option>';
				}
			}

			return $output;
		}
		
		public function outputWarps( $filename )
		{
			$output = '';
			
			$list = $this->listWarps( $this->db, 0, $this->user['name'] );
			
			foreach ( $list as $row )
			{
				$this->tpl['info'] = $row;
				ob_start();
				include(ROOT_LK_DIR . '/templates/'.$this->cfg['template'].'/output_'. $filename .'.tpl');
				$output .= ob_get_clean();
			}

			return $output;
		}
		
		public function outputRights( $filename )
		{
			$output = '';
			$right = $this->cfg['rights']['right'];
			
			for( $i = 0, $Max = count($right); $i < $Max; $i ++ ) {
				if ( $right[$i][4] )
				{
					$this->tpl['info'] = $right[$i];
					
					ob_start();
					include(ROOT_LK_DIR . '/templates/'.$this->cfg['template'].'/output_'. $filename .'.tpl');
					$output .= ob_get_clean();
				}
			}

			return $output;
		}
	}


?>