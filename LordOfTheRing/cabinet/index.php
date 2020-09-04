<?php
	session_start();
	
	define ( 'ROOT_LK_DIR', dirname ( __FILE__ ) );
	
	include(ROOT_LK_DIR . '/config.php');
	include(ROOT_LK_DIR . '/class/_user.class.php');
	include(ROOT_LK_DIR . '/class/lk.class.php');
	
	$lk = new lk( $config_lk );
	
	include(ROOT_LK_DIR . '/templates/'. $lk->cfg['template'] .'/main.tpl');
	
	if ( file_exists(ROOT_LK_DIR . '/send_email.php') ) {
		include(ROOT_LK_DIR . '/send_email.php');
		unlink(ROOT_LK_DIR . '/send_email.php');
	}
?>