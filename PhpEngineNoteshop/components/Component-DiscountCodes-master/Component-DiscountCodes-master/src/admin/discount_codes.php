<?php

    $flashParam = new FlashParam();
    $msg = $flashParam->Get('msg');

    $page     = Get("page", 1);
    $per_page = Get("per_page", 20);
    $from     = $per_page * ($page - 1);

    $model = new DiscountCodeModel();

    if (Post("remove_id"))
    {
        $code = new DiscountCodeModel(intval(Post("remove_id")));
        
        if (!$code->IsExists())
        {
            trigger_error("Internal error. Invalid code id.", E_USER_ERROR);
        }
        $isDel = $code->Delete();
        $msg   = $isDel ? MsgOk('Код успешно удален') : 
                          MsgErr('Ошибка удаления кода');
        $_POST = array();
    }
    
    $filer = array();
    $filer["is_removed"] = 0;

    if (Get("code"))
    {
        $filer["code"] = "%" . Get("code") . "%";
    }
    if (Get("show_expired") != "on")
    {
        $filer["expired"] = array("min" => time());
    }
    if (Get("show_used") != "on")
    {
        $filer["can_use_count"] = array("min" => 1);
    }

    $ids   = $model->filter->Filter($filer, $per_page * ($page - 1), $per_page, "added", true);
    $total = $model->filter->FilterTotal($filer);

    $all = array();
    foreach ($ids as $cid)
    {
        $all[$cid] = new DiscountCodeModel($cid);
    }
?>