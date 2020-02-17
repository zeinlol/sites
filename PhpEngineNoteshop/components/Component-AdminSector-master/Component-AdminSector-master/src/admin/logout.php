<?php

    $admin = new AdminModel(NULL, true);
    $admin->DoLogout();

    header("Location: " . SiteRoot($g_config['admin_sector']['after_logout_page']));
    exit();
?>
