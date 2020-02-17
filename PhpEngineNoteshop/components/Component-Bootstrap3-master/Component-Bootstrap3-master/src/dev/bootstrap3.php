<?php

    $isAdminSector = (stripos(strtolower(GetQuery()), 'admin/') === 0 || GetQuery() === 'admin');
    if (!$isAdminSector)
    {
        // Дополнительно проверяем что у нас удалён стандартный ресеттер и стандартные базовые стили (они конфликтуют с bootstrap3)
        $path1 = 'i/css/main.less';
        $path2 = 'i/css/normalize.css';
        if (is_file(BASEPATH . $path1) || is_file(BASEPATH . $path2))
        {
            $str = array();
            $str[] = "Пожалуйста удалите файлы '{$path1}' и '{$path2}' и из файла 'tpl/main_tpl.php' удалите следующие строки:";
            $str[] = '<link rel="stylesheet" type="text/css" href="<' . "?= Root('i/css/normalize.css')?" . '>" />';
            $str[] = '<link rel="stylesheet" type="text/css" href="<' . "?= Root('i/css/main.less')?" . '>" />';
            $str[] = 'Это необходимо так как эти стандартные файлы фреймворка конфликтуют с Bootstrap 3.';
            $str[] = "После этого очистите папку '/tmp' (просто удалите из неё все файлы).";

            xmp(implode("\n", $str));
            trigger_error("Remove '{$path1}' and '{$path2}' files!", E_USER_ERROR);
        }
    }
?>
