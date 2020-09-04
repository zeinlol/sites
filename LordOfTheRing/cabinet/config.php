<?php
	/*
		Личный Кабинет (UUID, Мультисерверность, AJAX)
		
		Автор: Fleynaro
		Версия: v1.3
		Тип версии: Платная
	*/

	$config_lk = array(
	
		/*_________ПОДКЛЮЧЕНИЕ К БД_________*/
		'db' =>	array (
		
			'host'	=> 'localhost',
			'name'	=> 'lotr_db',
			'user'	=> 'lotr_db_admin',
			'pass'	=> 'Fylhtqc0cbgbc0c',
			'char'	=> 'utf8'
		
		),
		
		/*_________НАСТРОЙКА СОВМЕСТИМОСТИ С ДВИЖКОМ_________*/
		'cms' => array (
		
			's_userid'		=> 'dle_user_id',
			't_users' 		=> 'dle_users',
			'c_userid'		=> 'user_id',
			'c_name'		=> 'name',
			'c_userpass'	=> 'password',
			'c_money'		=> 'money',
			'h_pass'		=> 'hash_dle'
			
		),
		
		/*_________НАСТРОЙКА ЛК_________*/
		//Имя сессии в ЛК
		's_name'	=>	'lk_user_id',
		//Шаблон ЛК
		'template'	=>	'default',
		//Валюта в ЛК
		'cur'		=> 	array('RUB', 'руб', 'рублей', 'рубля', 'рубль', 'р'),
		//Стоимость 1 единицы валюты ЛК
		'cur_price'	=>	1, //RUB/USD. По умолчанию курс такой: 1 рубль ЛК = 1 RUB
		//Тип отображения ЛК. Если он будет встраиваться в шаблон вашего сайта, то ставьте true.
		'insite'	=>	true,
		//КОДИРОВКА ВАШЕГО САЙТА. utf-8 или windows-1251
		'charset'	=>	'utf-8',
		//Антиддос. Сильно не защитит, но нагрузку снизит. Указывать время в сек, которое придется ждать между запросами. false - выкл.
		'anti_ddos'	=>	3,
		//Выбор шаблона через GET запрос ?tpl=[Имя папки с шаблоном] (Полезно, если Вы хотите предоставить пользователю выбор шаблона ЛК)
		'selectTpl'	=>	false,
		
		/*_________СКИНЫ И ПЛАЩИ_________*/
		'skin'		=> array(
				//Путь до скинов
				'path_to_skin'	=> '/upload/skins/',
				//Путь до плащей
				'path_to_cloak'	=> '/upload/cloaks/',
				//Увеличение скинов
				'zoom_k'		=> 1,
				//Макс. размер загружаемого скина
				'max_size_mb'	=> 3
		),
		
		/*_________ПРАВА_________*/
		'rights'		=> array(
				//Включить возможность покупки прав
				'enable'		=> true,
				//Права
				'right'			=> array(
					
					//    Возможность           Название права       колонка           цена    включить
					array('загрузить HD скин', 	'upload_hd_skin',	'lk_hdskin',		30,		true),
					array('загрузить HD плащ', 	'upload_hd_cloak',	'lk_hdcloak',		35,		true)
					
				)
		),
		
		/*_________ПРЕФИКС_________*/
		'prefix'	=> array(
				
				//Минимальная длина префикса
				'prefix_min_len'	=> 3,
				//Максимальная длина префикса
				'prefix_max_len'	=> 10,
				//Формат префикса
				'prefix_format'		=> array(
					
					'&0[ ', /* ПРЕФИКС */  ' &0] ', 	'', /* НИК */ '' 	/* СООБЩЕНИЕ */
					
					//Например: &0[ &2Admin &0] &6Fleynaro&3: hello, world!
				)
			
		),
		
		/*_________ДРУГОЕ_________*/
		'other'	=> array(
				
				'unban'	=>	array(
					
					//Вкл/Выкл систему разбана в ЛК
					'enable'		=>	true,
					//Начальная цена разбана в ЛК
					'price'			=>	100,
					//На сколько дороже будет начальная цена разбана при след. разбане
					'price_next'	=>	50,
					//Как использовать систему разбанов: false - бан на каждом сервере по отдельности, true - бан на всех серверах.
					'unban_all'		=>	true,
					//UUID - true/false. Чтобы uuid было активно, сервер в конфиге должен содержать параметр uuid со значением true.
					'uuid'			=> 	false,
					//Инфо таблицы с банами. По умолчанию настроено на UltraBans MC v1.4.7
					'table'			=>	array(
						//Колонка с ником забаненного
						'name'		=>	'name',
						//Колонка с ником того, кто забанил(админ)
						'admin'		=>	'admin',
						//Колонка с временем, когда забанили
						'time'		=>	'time',
						//Колонка с причиной бана
						'reason'	=>	'reason'
					)
				),
				
				'vaucher' =>	array(
					
					//Вкл/Выкл систему ваучеров
					'enable'		=>	true,
					//Длина ваучера. Мин и Макс
					'len'			=>	array(3, 10)
				)
			
		),
		
		/*_________ОБМЕНЫ_________*/
		'exchange'	=> array(
				
				//iConomy 		до v7.0 включительно
				'iconomy'	=>	array(
					//Вкл/Выкл обмен валюты iConomy в ЛК 
					'enable'		=>	true,
					//Сколько стоит 1 единица вашей валюты в ЛК. 0 - выкл. обмен
					'price_u_cur'	=> 	5,
					//Если iConomy талица находится в общей БД(сайт), то true
					'ic_money_viem'	=>	true
				)
			
		),
		
		/*_________ПЛАТЕЖНАЯ СИСТЕМА_________*/
		'payment'	=> array(
				//Если вы собираетесь использовать платежную ситему в магазине, то вам необходимо настроить также конфиг файл payment/config.php
				
				//Включить ли платежную система в ЛК?
				'enable'	=>	true,
				//Платежная ситема. 1 - InterKassa
				'type'	=>	1,
				//Путь к файлу payment.php
				'path'			=> 'payment/payment.php',
				//Укажите валюту (RUB|USD) или оставьте пустое поле
				'cur'			=> 'RUB',
				//Имя валюты (руб.|$)
				'curname'		=> 'руб.',
				//Описание
				'desc'			=> 'payment!',
				//Метод отправки данных файлу payment.php: GET или POST
				'method'		=> 'GET',
				 //GET запросы с индексами. Настраивать ничего не нужно.
				'params'		=> array (
			
					array ( //INTERKASSA
						'sum' => 'ik_am',
						'desc' => 'ik_desc',
						'user' => 'ik_pm_no',
						'cur' => 'ik_cur'
					)
				)	
			
		),
		
		/*_________UUID_________*/
		'uuid'	=> array(
				
				//Палочки у UUID (true: 86a3fe83-9cc5-3b97-8309-e518da73e725  или  false: 86a3fe839cc53b978309e518da73e725)
				'underline'	=>	true,
				//Генерировать стандартным методом. Если false, то будет брать UUID из колонки в      таблице с пользователями/указанной внизу таблице
				'generate'	=>	true,
				//Имя колонки UUID в    таблице с пользователями/указанной внизу таблице
				'column'	=>	'uuid',
				//Таблица
				'table'		=>	array(
					
					'enable'		=>	false,		// Вкл\Выкл взятие UUID из другой таблицы, а не из users(или dle_users, accounts и т.д)
					'tablename'		=>	'userUUID',	//Имя таблицы с UUID пользователей
					'c_username'	=>	'username',	//Имя колонки с никами/ID пользователей
					'byfind'		=>	'name'		//Искать UUID в таблице по нику(name) или ID(id)
				)
			
		),
		
		/*_________СЕРВЕРА. МУЛЬТИСЕРВЕРНОСТЬ_________*/
		'server'	=> array( //Для отключения мультисерверности поставьте первому серверу параметру name значение All
						
				//Сервер Classic
				array
				(
					//Вкл/Выкл данный сервер в ЛК
					'enable'	=> true,
					//Наименование сервера
					'name'		=>	'Classic',
					//UUID 		1.7.9 +
					'uuid'		=> 	true,
					//Добавлять записи при покупке статусов
					'entity'	=>	array('type' => 1, 'default' => -1),
					//Данные для подключения к БД. false - использовать общую БД.
					'db'		=>	array (
						
						'host'	=> 'localhost',
						'name'	=> 'lk',
						'user'	=> 'root',
						'pass'	=> '',
						'char'	=> 'cp1251'
						
					),
					//Таблицы
					'tables'	=> array( 'permissions', 'permissions_entity', 'permissions_inheritance', 'iconomy', 'warptable', 'banlist' ),
					//Статусы(Вкл/Выкл)  Первый true - первый статус.
					'status'	=> array( true, true, true, true ),
					//Возможности
					'right'		=>	array (
						
						'buy_status'	=>	true,	//Покупка статуса на данном сервере
						'set_prefix'	=>	true,	//Установка префикса на данном сервере
						'extend_status'	=>	true,	//Продление статуса на данном сервере
						'exchange'		=>	true,	//Обмен валютой на данном сервере
						'warp'			=>	true,	//Создать/Редактировать варпы на данном сервере
						'unban'			=>	true	//Разбан на данном сервере
						
					)
				),
				
				//Сервер HiTech
				array
				(
					//Вкл/Выкл данный сервер в ЛК
					'enable'	=> true,
					//Наименование сервера
					'name'		=>	'HiTech',
					//UUID		1.7.9 +
					'uuid'		=> 	true,
					//Добавлять записи при покупке статусов
					'entity'	=>	array('type' => 1, 'default' => -1),
					//Данные для подключения к БД. false - использовать общую БД.
					'db'		=>	false,
					//Таблицы
					'tables'	=> array( 'permissions', 'permissions_entity', 'permissions_inheritance', 'iconomy', 'warptable', 'banlist' ),
					//Статусы(Вкл/Выкл)  Первый true - первый статус.
					'status'	=> array( true, true, true, true ),
					//Возможности
					'right'		=>	array (
						
						'buy_status'	=>	true,	//Покупка статуса на данном сервере
						'set_prefix'	=>	true,	//Установка префикса на данном сервере
						'extend_status'	=>	true,	//Продление статуса на данном сервере
						'exchange'		=>	true,	//Обмен валютой на данном сервере
						'warp'			=>	true,	//Создать/Редактировать варпы на данном сервере
						'unban'			=>	true	//Разбан на данном сервере
						
					)
				),
				
				//Сервер Magic
				array
				(
					//Вкл/Выкл данный сервер в ЛК
					'enable'	=> true,
					//Наименование сервера
					'name'		=>	'Magic',
					//UUID		1.7.9 +
					'uuid'		=> 	true,
					//Добавлять записи при покупке статусов
					'entity'	=>	array('type' => 1, 'default' => -1),
					//Данные для подключения к БД. false - использовать общую БД.
					'db'		=>	false,
					//Таблицы
					'tables'	=> array( 'permissions', 'permissions_entity', 'permissions_inheritance', 'iconomy', 'warptable', 'banlist' ),
					//Статусы(Вкл/Выкл)  Первый true - первый статус.
					'status'	=> array( true, true, true, true ),
					//Возможности
					'right'		=>	array (
						
						'buy_status'	=>	true,	//Покупка статуса на данном сервере
						'set_prefix'	=>	true,	//Установка префикса на данном сервере
						'extend_status'	=>	true,	//Продление статуса на данном сервере
						'exchange'		=>	true,	//Обмен валютой на данном сервере
						'warp'			=>	true,	//Создать/Редактировать варпы на данном сервере
						'unban'			=>	true	//Разбан на данном сервере
						
					)
				)
		
		),
		
		/*_________СТАТУСЫ_________*/
		'status'	=> array(
						
				//Группа ИГРОКИ
				array
				(
					//Вкл/Выкл статус
					'enable'	=> true,
					//Наименование статуса
					'name' 		=>	'Игрок',
					//Описание статуса
					'desc'		=>	'Группа игроки выдается всем игрокам, принявших участие в проекте.',
					//Наименование статуса в пермишенс
					'name_pex' 	=>	'default',
					//Возможности группы
					'right'		=> 	array (
										
						'upload_skin'		=>	true,	//Загрузка скина
						'upload_hd_skin'	=>	false,	//Загрузка HD скина
						'upload_cloak'		=> 	false,	//Загрузка плаща
						'upload_hd_cloak'	=> 	false,	//Загрузка HD плаща
						'set_prefix'		=> 	false,	//Установка префикса
						'buy_status'		=> 	true,	//Покупка статусов
						'create_warp'		=> 	false,	//Создание варпа
						'buy_unban'			=>	true	//Покупка разбана
										
					),
					//Покупка осуществляется на (в днях)
					'buy_days'	=>	0,
					//Возможность указать кол-во дней
					'set_days'	=> true,
					//Цена
					'price'		=>	0
				),
				
				//Группа VIP
				array
				(
					//Вкл/Выкл статус
					'enable'	=> true,
					//Наименование статуса
					'name' 		=>	'VIP игрок',
					//Описание статуса
					'desc'		=>	'Группа ВИП покупается и дает больше возможностей и привилегий по сравнению с обчной группой "Игроки"',
					//Наименование статуса в пермишенс
					'name_pex' 	=>	'vip',
					//Возможности группы
					'right'		=> 	array (
										
						'upload_skin'		=>	true,	//Загрузка скина
						'upload_hd_skin'	=>	false,	//Загрузка HD скина
						'upload_cloak'		=> 	true,	//Загрузка плаща
						'upload_hd_cloak'	=> 	false,	//Загрузка HD плаща
						'set_prefix'		=> 	false,	//Установка префикса
						'buy_status'		=> 	true,	//Покупка статусов
						'create_warp'		=> 	false,	//Создание варпа
						'buy_unban'			=>	true	//Покупка разбана
										
					),
					//Покупка осуществляется на (в днях)
					'buy_days'	=>	30,
					//Возможность указать кол-во дней
					'set_days'	=> true,
					//Цена
					'price'		=>	150
				),
				
				//Группа Premium
				array
				(
					//Вкл/Выкл статус
					'enable'	=> true,
					//Наименование статуса
					'name' 		=>	'Premium игрок',
					//Описание статуса
					'desc'		=>	'Группа Premium является высшей привелегией для игрока.',
					//Наименование статуса в пермишенс
					'name_pex' 	=>	'premium',
					//Возможности группы
					'right'		=> 	array (
										
						'upload_skin'		=>	true,	//Загрузка скина
						'upload_hd_skin'	=>	true,	//Загрузка HD скина
						'upload_cloak'		=> 	true,	//Загрузка плаща
						'upload_hd_cloak'	=> 	true,	//Загрузка HD плаща
						'set_prefix'		=> 	true,	//Установка префикса
						'buy_status'		=> 	true,	//Покупка статусов
						'create_warp'		=> 	true,	//Создание варпа
						'buy_unban'			=>	true	//Покупка разбана
										
					),
					//Покупка осуществляется на (в днях)
					'buy_days'	=>	30,
					//Возможность указать кол-во дней
					'set_days'	=> true,
					//Цена
					'price'		=>	350
				)
						
		)
	
	);

	define('TABLE_PERMISSION', 0);
	define('TABLE_PERMISSION_ENTITY', 1);
	define('TABLE_PERMISSION_INHERITANCE', 2);
	define('TABLE_ICONOMY', 3);
	define('TABLE_WARPS', 4);
	define('TABLE_BANLIST', 5);

?>