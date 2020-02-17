<?php

    $defConfig = array
    (
        'showSiteOrWebChecker'  => true,
        'showContentSearchType' => true
    );

    $config = isset($config) ? array_merge($defConfig, $config) : $defConfig;

    if (Post('is_google_search'))
    {
        header("Location: http://www.google.ru/search?q=" . urlencode("site:{$siteUrl} " . Post('search')));
        exit(0);
    }
?>
