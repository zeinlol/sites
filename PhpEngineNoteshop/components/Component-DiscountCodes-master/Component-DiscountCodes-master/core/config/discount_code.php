<?php

    require_once BASEPATH . 'core/config/admin_menu.php';

    GetQuery(); // Чтобы фунция SiteRoot корректно заработала нужно проинициализировать LANG в функции GetQuery
    $g_config['admin_menu'][]   = array
                        (
                            'link'  => 'javascript:void(0)',
                            'name'  => 'Скидки',
                            'label' => 'Коды скидок',
                            'css'   => '',
                            'list'  => array
                                       (
                                           array('link' => SiteRoot('admin/discount_codes'), 'name' => 'Список кодов', 'label' => 'Показать список кодов на скидку'),
                                           array('link' => SiteRoot('admin/discount_code'),  'name' => 'Добавить код', 'label' => 'Добавить новый код на скидку')
                                       )
                        );
?>
