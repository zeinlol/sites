<?php
	
	include( realpath( 'config.php' ) );
	
	
	foreach ( $cfg['req'] as $key => $val )
	{
		$_REQ[$key] = isset($_REQUEST[$val[0]]) ? $_REQUEST[$val[0]] : 0;
	}
	
	if ( ( !$cfg['use_key'] || $_REQ['key'] == $cfg['key'] ) && ( is_numeric($_REQ['system']) && $_REQ['system'] > 0 && $_REQ['system'] <= 3 ) )
	{
		
		require( realpath( 'payment.class.php' ) );
		
		if ( !$cfg['payments'][$_REQ['system'] - 1]['enable'] ) die('Ошибка: данная пл. система не принимается!');
		
		switch ( $_REQ['system'] )
		{
			
			case ID_IK:	//INTERKASSA
			{
				$payment = new payment_ik;
				$_REQUEST['ik_co_id'] = $cfg['payments'][ID_IK - 1]['id'];
				header('Location: https://sci.interkassa.com/' . $payment->create_req($_REQUEST, $cfg['payments'][ID_IK - 1]['prefix']));
				break;
			}
			
		}
		
	}
?>