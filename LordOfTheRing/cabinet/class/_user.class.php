<?php


	class _user {
		
		public function init_user( $user_id )
		{
			$sth = $this->db->prepare("SELECT * FROM {$this->cfg['cms']['t_users']} WHERE {$this->cfg['cms']['c_userid']} = :id");
			$sth->bindParam(':id', $user_id, PDO::PARAM_INT);						
			$sth->execute();
			
			return $sth->fetch(PDO::FETCH_ASSOC);
		}
		
		public function init_user_byname( $user_name )
		{
			$sth = $this->db->prepare("SELECT * FROM {$this->cfg['cms']['t_users']} WHERE {$this->cfg['cms']['c_name']} = :name");
			$sth->bindParam(':name', $user_name, PDO::PARAM_STR);						
			$sth->execute();
			
			return $sth->fetch(PDO::FETCH_ASSOC);
		}
		
		public function get_session()
		{
			if ( $this->cfg['cms']['s_userid'] != false )
			{
				if ( isset( $_SESSION[ $this->cfg['cms']['s_userid'] ] ) )
				{
					return $_SESSION[ $this->cfg['cms']['s_userid'] ];
				} else
					return -1;	
			} else if ( isset( $_SESSION[ $this->cfg['s_name'] ] ) ) {
				
				return $_SESSION[ $this->cfg['s_name'] ];
				
			}
			
			return -2;
		}
		
		public function generateKeyCSRF()
		{
			return md5( $_SERVER['REMOTE_ADDR'] . time() . rand(0, 100) );
		}
		
		public function isKeyCSRF( $key )
		{
			return ( $this->user['key'] == $key );
		}
		
		public function give_money( $money )
		{
			$sth = $this->db->prepare("UPDATE {$this->cfg['cms']['t_users']} SET {$this->cfg['cms']['c_money']} = {$this->cfg['cms']['c_money']} + :money WHERE {$this->cfg['cms']['c_userid']} = :id");
			$sth->bindParam(':id', $this->user['id'], PDO::PARAM_INT);
			$sth->bindParam(':money', $money, PDO::PARAM_INT);					
			
			return $sth->execute();
		}
		
		public function give_money_ic( $serverDB, $server_id, $name, $money )
		{
			$sth = $serverDB->prepare("UPDATE `{$this->cfg['server'][$server_id]['tables'][TABLE_ICONOMY]}` SET `balance` = balance + :balance WHERE `username` = :name");
			$sth->bindParam(':name', $name, PDO::PARAM_STR);
			$sth->bindParam(':balance', $money, PDO::PARAM_INT);					
			
			return $sth->execute();
		}
		
		public function get_money_ic( $serverDB, $server_id, $name )
		{
			$sth = $serverDB->prepare("SELECT `balance` FROM `{$this->cfg['server'][$server_id]['tables'][TABLE_ICONOMY]}` WHERE `username` = :name");
			$sth->bindParam(':name', $name, PDO::PARAM_STR);				
			$sth->execute();
			$res = $sth->fetch(PDO::FETCH_ASSOC);
			return $res['balance'];
		}
		
		public function setPrefix( $serverDB, $server_id, $name, $prefix, $suffix )
		{	
			if ( $this->isUUIDServer($server_id) )
			{
				$table = $this->cfg['server'][$server_id]['tables'][TABLE_PERMISSION];
				
				if ( count ( $this->getPrefix( $serverDB, $server_id, $name ) ) )
				{
					$sth = $serverDB->prepare("UPDATE `{$table}` SET `value` = :prefix WHERE `name` = :uuid AND `permission` = 'prefix'");
					$name = $this->getUUID($name);
					$sth->bindParam(':uuid', $name, PDO::PARAM_STR);
					$sth->bindParam(':prefix', $prefix, PDO::PARAM_STR);
					$sth->execute();
					
					$sth = $serverDB->prepare("UPDATE `{$table}` SET `value` = :suffix WHERE `name` = :uuid AND `permission` = 'suffix'");
					$sth->bindParam(':uuid', $name, PDO::PARAM_STR);
					$sth->bindParam(':suffix', $suffix, PDO::PARAM_STR);
					$sth->execute();
				} else
				{
					$name = $this->getUUID($name);
					$sth = $serverDB->prepare("INSERT INTO `{$table}` VALUES(NULL, :uuid, 1, 'prefix', '', :prefix)");
					$sth->bindParam(':uuid', $name, PDO::PARAM_STR);
					$sth->bindParam(':prefix', $prefix, PDO::PARAM_STR);
					$sth->execute();
					
					$sth = $serverDB->prepare("INSERT INTO `{$table}` VALUES(NULL, :uuid, 1, 'suffix', '', :suffix)");
					$sth->bindParam(':uuid', $name, PDO::PARAM_STR);
					$sth->bindParam(':suffix', $suffix, PDO::PARAM_STR);
					$sth->execute();
				}
			} else
			{
				$table = $this->cfg['server'][$server_id]['tables'][TABLE_PERMISSION_ENTITY];
				
				if ( count ( $this->getPrefix( $serverDB, $server_id, $name ) ) ) {
					$sth = $serverDB->prepare("UPDATE `{$table}` SET `prefix` = :prefix, `suffix` = :suffix WHERE `name` = :name AND `type` = 1");
				} else {
					$sth = $serverDB->prepare("INSERT INTO `{$table}` VALUES(NULL, :name, 1, :prefix, :suffix, '')");
				}
				
				$sth->bindParam(':name', $name, PDO::PARAM_STR);
				$sth->bindParam(':prefix', $prefix, PDO::PARAM_STR);
				$sth->bindParam(':suffix', $suffix, PDO::PARAM_STR);
				$sth->execute();
			}
		}
		
		public function deletePrefix( $serverDB, $server_id, $name )
		{
			if ( $this->isUUIDServer($server_id) )
			{
				$name = $this->getUUID($name);
				$sth = $serverDB->prepare("DELETE FROM `{$this->cfg['server'][$server_id]['tables'][TABLE_PERMISSION]}` WHERE `name` = :uuid AND (`permission` = 'prefix' OR `permission` = 'suffix')");
				$sth->bindParam(':uuid', $name, PDO::PARAM_STR);
			} else
			{
				$sth = $serverDB->prepare("DELETE FROM `{$this->cfg['server'][$server_id]['tables'][TABLE_PERMISSION_ENTITY]}` WHERE `name` = :name AND `type` = 1");
				$sth->bindParam(':name', $name, PDO::PARAM_STR);
			}
			
			return $sth->execute();
		}
		
		public function getPrefix( $serverDB, $server_id, $name )
		{
			if ( $this->isUUIDServer($server_id) ) {
				$table = $this->cfg['server'][$server_id]['tables'][TABLE_PERMISSION];
				$name = $this->getUUID($name);
				$sth = $serverDB->prepare("SELECT `value` FROM `{$table}` WHERE `name` = :uuid AND (`permission` = 'prefix' OR `permission` = 'suffix') ORDER BY `permission` ASC LIMIT 2");
				$sth->bindParam(':uuid', $name, PDO::PARAM_STR);
				$sth->execute();
				return $sth->fetchAll(PDO::FETCH_COLUMN);
			} else {
				$table = $this->cfg['server'][$server_id]['tables'][TABLE_PERMISSION_ENTITY];
				
				$sth = $serverDB->prepare("SELECT `prefix`, `suffix` FROM `{$table}` WHERE `name` = :name AND `type` = 1 LIMIT 1");
				$sth->bindParam(':name', $name, PDO::PARAM_STR);
				$sth->execute();
				return $sth->fetch(PDO::FETCH_NUM);
			}
		}
		
		public function setEntity( $serverDB, $server_id, $name, $type = 1, $default = 0 )
		{
			$table = $this->cfg['server'][$server_id]['tables'][TABLE_PERMISSION_ENTITY];
			
			if ( $default != -1 ) {
				$sth = $serverDB->prepare("INSERT INTO `{$table}` VALUES(NULL, :name, :type, :default)");
				$sth->bindParam(':default', $default, PDO::PARAM_INT);
			} else {
				$sth = $serverDB->prepare("INSERT INTO `{$table}` VALUES(NULL, :name, :type)");
			}
			$sth->bindParam(':type', $type, PDO::PARAM_INT);
			$name = $this->isUUIDServer($server_id) ? $this->getUUID($name) : $name;
			$sth->bindParam(':name', $name, PDO::PARAM_STR);
			
			return $sth->execute();
		}
		
		public function getEntity( $serverDB, $server_id, $name )
		{
			$table = $this->cfg['server'][$server_id]['tables'][TABLE_PERMISSION_ENTITY];
			
			$sth = $serverDB->prepare("SELECT * FROM `{$table}` WHERE `name` = :name LIMIT 1");
			$name = $this->isUUIDServer($server_id) ? $this->getUUID($name) : $name;
			$sth->bindParam(':name', $name, PDO::PARAM_STR);
			$sth->execute();
			
			return $sth->fetch(PDO::FETCH_ASSOC);
		}
		
		public function setStatus( $serverDB, $server_id, $name, $statusid )
		{
			$table = $this->cfg['server'][$server_id]['tables'][TABLE_PERMISSION_INHERITANCE];
			
			if ( $statusid == 0 ) {
				$sth = $serverDB->prepare("DELETE FROM `{$table}` WHERE `child` = :name AND `type` = 1");
			} else if ( $this->getStatus( $serverDB, $server_id, $name ) != false ) {
				$sth = $serverDB->prepare("UPDATE `{$table}` SET `parent` = :status WHERE `child` = :name");
				$sth->bindParam(':status', $this->cfg['status'][$statusid]['name_pex'], PDO::PARAM_STR);
			} else {
				$sth = $serverDB->prepare("INSERT INTO `{$table}` VALUES(NULL, :name, :status, 1, NULL)");
				$sth->bindParam(':status', $this->cfg['status'][$statusid]['name_pex'], PDO::PARAM_STR);
			}
			
			$name = $this->isUUIDServer($server_id) ? $this->getUUID($name) : $name;
			$sth->bindParam(':name', $name, PDO::PARAM_STR);
			return $sth->execute();
		}
		
		public function setStatusUser( $user_id, $server_id, $statusid, $time, $prefix, $unban_count )
		{
			$status = $statusid . '/' . $time . '_' . $prefix[0] . '/' . $prefix[1] . '/' . $prefix[2] . '/' . $prefix[3] . '_' . $unban_count;
			
			$sth = $this->db->prepare("UPDATE `{$this->cfg['cms']['t_users']}` SET `server_{$server_id}` = :status WHERE `{$this->cfg['cms']['c_userid']}` = :userid");
			$sth->bindParam(':userid', $user_id, PDO::PARAM_INT);
			$sth->bindParam(':status', $status, PDO::PARAM_STR);
			return $sth->execute();
		}
		
		public function getStatus( $serverDB, $server_id, $name )
		{
			$table = $this->cfg['server'][$server_id]['tables'];
			
			if ( $this->isUUIDServer($server_id) ) {
				
				$name = $this->getUUID($name);
				$sth = $serverDB->prepare("SELECT `parent` FROM `{$table[TABLE_PERMISSION_INHERITANCE]}` WHERE `child` = :uuid LIMIT 1");
				$sth->bindParam(':uuid', $name, PDO::PARAM_STR);
				$sth->execute();
				$result = $sth->fetch(PDO::FETCH_NUM);
				return empty ( $result[0] ) ? false : $result[0];	
			} else {
				
				$sth = $serverDB->prepare("SELECT `parent` FROM `{$table[TABLE_PERMISSION_INHERITANCE]}` WHERE `child` = :name LIMIT 1");
				$sth->bindParam(':name', $name, PDO::PARAM_STR);
				$sth->execute();
				$result = $sth->fetch(PDO::FETCH_NUM);
				return empty ( $result[0] ) ? false : $result[0];
			}
		}
		
		public function unban( $serverDB, $server_id, $name )
		{
			$sth = $serverDB->prepare("DELETE FROM `{$this->cfg['server'][$server_id]['tables'][TABLE_BANLIST]}` WHERE `{$this->cfg['other']['unban']['table']['name']}` = :name");
			$name = $this->isUUIDServer($server_id) && $this->cfg['other']['unban']['uuid'] ? $this->getUUID($name) : $name;
			$sth->bindParam(':name', $name, PDO::PARAM_STR);
			return $sth->execute();
		}
		
		public function getBan( $serverDB, $server_id, $name )
		{
			$table = $this->cfg['other']['unban']['table'];
			$sth = $serverDB->prepare("SELECT `{$table['name']}`, `{$table['admin']}`, `{$table['time']}`, `{$table['reason']}` FROM `{$this->cfg['server'][$server_id]['tables'][TABLE_BANLIST]}` WHERE `{$table['name']}` = :name LIMIT 1");
			$name = $this->isUUIDServer($server_id) && $this->cfg['other']['unban']['uuid'] ? $this->getUUID($name) : $name;
			$sth->bindParam(':name', $name, PDO::PARAM_STR);						
			$sth->execute();
			$res = $sth->fetch(PDO::FETCH_ASSOC);
			foreach( $table as $key=>$val ) {
				if ( $key != $val ) {
					$res[$key] = $res[$val];
					unset($res[$val]);
				}
			}	
			return $res;
		}
		
		public function listWarps( $serverDB, $server_id, $name )
		{
			$sth = $this->db->prepare("SELECT * FROM `{$this->cfg['server'][$server_id]['tables'][TABLE_WARPS]}` WHERE `creator` = :name");
			$sth->bindParam(':name', $name, PDO::PARAM_STR);						
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_ASSOC);
		}
		
		public function isStatus( $status_id )
		{
			for( $i = 0, $Max = count($this->cfg['server']); $i < $Max; $i ++ ) {
				if ( $this->user['status'][$i][0] == $status_id )
				{
					return true;
				}
			}
			
			return false;
		}
		
		public function isHaveRight( $right )
		{
			for( $i = 0, $Max = count($this->cfg['server']); $i < $Max; $i ++ ) {
				if ( $this->cfg['status'][$this->user['status'][$i][0]]['right'][$right] )
				{
					return true;
				}
			}
			
			return isset($this->user['right'][$right]) ? $this->user['right'][$right] : false;
		}
		
		public function setRight( $user_id, $right_name, $right_value )
		{
			$sth = $this->db->prepare("UPDATE `{$this->cfg['cms']['t_users']}` SET `{$right_name}` = :value WHERE `{$this->cfg['cms']['c_userid']}` = :userid");
			$sth->bindParam(':userid', $user_id, PDO::PARAM_INT);
			$sth->bindParam(':value', $right_value, PDO::PARAM_BOOL);
			return $sth->execute();
		}
		
		public function getInfo( $server_id )
		{
			if ( $this->user['server_' . $server_id] != '' ) {
				return explode('_', $this->user['server_' . $server_id]);
			} else return Array(0, 0);
		}
		
		public function getIdStatusByName( $status_name )
		{
			for( $i = 0, $Max = count($this->cfg['status']); $i < $Max; $i ++ ) {
				if ( $this->cfg['status'][$i]['name_pex'] == $status_name )
				{
					return $i;
				}
			}
			
			return 0;
		}
		
		public function getUnbanPrice( $server_id )
		{
			return ($this->cfg['other']['unban']['price'] + $this->cfg['other']['unban']['price_next'] * $this->user['unban_count'][$server_id]);
		}
		
		public function getCountUnbanAll()
		{
			$res = 0;
			for( $i = 0, $Max = count($this->cfg['server']); $i < $Max; $i ++ ) {
				$res += $this->user['unban_count'][$i];
			}
			return $res;
		}
		
		function getUUID( $name )
		{
			if ( !$this->cfg['uuid']['table']['enable'] ) {
				$uuid = $this->cfg['uuid']['generate'] ? $this->uuidFromString("OfflinePlayer:" . $name) : $this->user[$this->cfg['uuid']['column']];
			} else {
				$sth = $this->db->prepare("SELECT `{$this->cfg['uuid']['column']}` FROM `{$this->cfg['uuid']['table']['tablename']}` WHERE `{$this->cfg['uuid']['table']['c_username']}` = :name");
				$sth->bindParam(':name', $this->user[$this->cfg['uuid']['table']['byfind']], PDO::PARAM_STR);						
				$sth->execute();
				$data = $sth->fetch(PDO::FETCH_ASSOC);
				$uuid = $data[$this->cfg['uuid']['column']];
			}
			
			if ( $this->cfg['uuid']['underline'] ) {
				return $uuid;
			} else {
				return str_replace('-', '', $uuid);
			}
		}
		
		function uuidFromString($string)
		{
			$val = md5($string, true);
			$byte = array_values(unpack('C16', $val));
		 
			$tLo = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
			$tMi = ($byte[4] << 8) | $byte[5];
			$tHi = ($byte[6] << 8) | $byte[7];
			$csLo = $byte[9];
			$csHi = $byte[8] & 0x3f | (1 << 7);
		 
			if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
				$tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8) | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
				$tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
				$tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
			}
		 
			$tHi &= 0x0fff;
			$tHi |= (3 << 12);
		   
			$uuid = sprintf(
				'%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
				$tLo, $tMi, $tHi, $csHi, $csLo,
				$byte[10], $byte[11], $byte[12], $byte[13], $byte[14], $byte[15]
			);
			return $uuid;
		}
		
	}
?>