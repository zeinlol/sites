
    <?php IncludeCom('dev/jquery')?>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= Root('i/css/dev/google_search.css')?>" />
        <script type="text/javascript">
            var g_googleSearchConfig =
            {
                siteURL     : '<?= $siteUrl?>', // Сайт, на котором используется поиск
                divId       : '<?= $divId?>',
                searchSite  : true,
                type        : 'web',
                append      : false,
                perPage     : 8, // Google допускает использовать максимум 8
                page        : 0, // Первая страница
                searchHead  : '<?= $g_lang['searchHead']?>',
                emptyResult : '<?= $g_lang['emptyResult']?>'
            };
        </script>
        <script type="text/javascript" src="<?= Root('i/js/dev/google_search.js')?>"></script>
    </head>


    <form action="<?= GetCurUrl()?>" method="post" class="google-search" onsubmit="return false">
        <fieldset>
            <?php if ( ! empty($g_lang['legent'])):?>
                <legend><?= $g_lang['legent']?></legend>
            <?php endif?>

                <input type="hidden" name="is_google_search" value="1" />
                <input id="s" type="text" name="search" value="<?= $g_lang['default_search_text']?>" />
                <input type="submit" value="<?= $g_lang['search_button']?>" id="submitButton" />

                <?php if ($config['showSiteOrWebChecker'] || $config['showContentSearchType']):?>
                    <div class="spacer-for-panels"></div>
                <?php endif?>

                <?php if ($config['showSiteOrWebChecker']):?>
                    <div id="searchInContainer">
                        <input type="radio" name="check" value="site" id="searchSite" checked />
                        <label for="searchSite" id="siteNameLabel"><?= $g_lang['search_site']?></label>

                        <input type="radio" name="check" value="web" id="searchWeb" />
                        <label for="searchWeb"><?= $g_lang['search_web']?></label>
                    </div>
                <?php endif?>

                <?php if ($config['showContentSearchType']):?>
                    <ul class="icons">
                        <li class="web" title="<?= $g_lang['search_type_web']?>" data-searchType="web"><?= $g_lang['search_type_web']?></li>
                        <li class="images" title="<?= $g_lang['search_type_images']?>" data-searchType="images"><?= $g_lang['search_type_images']?></li>
                        <li class="news" title="<?= $g_lang['search_type_news']?>" data-searchType="news"><?= $g_lang['search_type_news']?></li>
                        <li class="videos" title="<?= $g_lang['search_type_video']?>" data-searchType="video"><?= $g_lang['search_type_video']?></li>
                    </ul>
                <?php endif?>
        </fieldset>
    </form>
