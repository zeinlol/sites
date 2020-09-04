<?php
	
	
	$cfg = array(
		'payments'	=> array(
						
							//INTERKASSA
							array (
									
									'enable'	=> true, //Вкл/Выкл
									
									'name'		=>	'interkassa',
									
									'prefix'	=>	'ik_',
									
									
									'id'		=>	'14142',	//ID кассы
									
									'key'		=>	'',	//Ключ
									
									'test_key'	=>	''	//Тестовый ключ
							)
						
					),
					
		'db'	=> array(//Подключение к ДБ
					
					'host'	=>	'localhost',
					'name'	=>	'',
					'user'	=>	'',
					'pass'	=>	'',
					'charset'=>	'cp1251', //utf8 или cp1251
					
					//таблица
					'trans'	=>	'shop_trans',
					
					//таблица с пользователями и колонки
					'users'	=>	'dle_users',
					'money'	=> 	'money',
					'userid'=>	'user_id'
			
		),
		
		
		'redirect_s'=> 'http://site.ru/success.html',	//Укажите ссылку, на которую попадет клиент после успешной оплаты на платежной системе
		
		'redirect_f'=> 'http://site.ru/fail.html',	//Укажите ссылку, на которую попадет клиент после неудачной оплаты на платежной системе
		
		
		
		//тут не нужно настраивать ничего
		'req'		=>	array(	//Список запросов, отправляемых файлу payment.php
							
							'key'		=>	array( 'pay_key' ),			//Ключ для проверки запроса, исходящего именно от вашего сайта
							
							'system'	=> 	array( 'pay_system' )		//Платежная система
		
						),
						
						
		'use_key'	=>	false,	//Использовать ли ключ для проверки исходящего запроса от вашего сайта.
		
		'key'		=> 'web_shop_key'
	);
	
	define ( 'ID_IK', 1 );
	define ( 'ID_UP', 2 );
	define ( 'ID_RK', 3 );
?>