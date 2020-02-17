<!DOCTYPE html>
<html lang="<?= LANG?>" dir="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= $g_config['charset']?>" />
        <title><?= L('m_title')?></title>
        <link rel="icon" href="<?= Root('favicon.ico')?>" type="image/x-icon" />
        <link rel="shortcut icon" href="<?= Root('favicon.ico')?>" type="image/x-icon" />
        <meta http-equiv="cleartype" content="on">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?= Root('i/css/dev/funcs.less')?>" />
        <?php IncludeCom('dev/bootstrap3')?>
        <!-- extraPacker -->
        <meta name="robots" content="noindex, nofollow">
    </head>
    <body>
        <?php IncludeCom('admin/admin_menu', array('menu' => $menu, 'logo' => $logo))?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?= $content?>
                </div>
            </div>
        </div>
    </body>
</html>
