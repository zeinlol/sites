<?php

	define ( 'ROOT_LK_DIR', dirname ( __FILE__ ) );
	
	include(ROOT_LK_DIR . '/config.php');
	include(ROOT_LK_DIR . '/class/_user.class.php');
	include(ROOT_LK_DIR . '/class/lk.class.php');
	
	$lk = new lk( $config_lk, true );
	
	$cms = $lk->cfg['cms'];
	$time = time();
	
	for( $i = 0, $Max = count($lk->cfg['server']); $i < $Max; $i ++ ) {
		$serv_info = $lk->cfg['server'][$i];
		$users = $lk->db->query("SELECT `{$cms['c_userid']}`, `{$cms['c_name']}`, `server_{$i}` FROM {$cms['t_users']} WHERE `server_{$i}` != ''")->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ( $users as $row ) {
			$user_id = $row[$cms['c_userid']];
			$user_name = $row[$cms['c_name']];
			$server = explode('_', $row['server_' . $i]);
			$status = explode('/', $server[0]);
			
			if ( $status[0] > 0 && $status[1] <= $time ) {
				$_db = $lk->getServerDB( $i );
				
				$lk->setStatusUser( $user_id, $i, 0, 0, array(0, 0, 0, 0), $server[2] );
				$lk->deletePrefix( $_db, $i, $user_name );
				$lk->setStatus( $_db, $i, $user_name, 0 );
				
				$lk->user['name'] = $user_name;
				$lk->logWrite('был убран из группы "'. $lk->cfg['status'][$status[0]]['name'] .'" cron системой.');
			}
		}
	}
?>