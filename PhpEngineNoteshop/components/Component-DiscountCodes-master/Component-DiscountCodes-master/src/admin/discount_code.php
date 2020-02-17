<?php

    $discnt = new DiscountCodeModel(NULL, true);

    $discnt_id = intval(Get('code_id'));
    $discnt    = new DiscountCodeModel($discnt_id);

    $back = Get("back", NULL, M_HTML_FILTER_OFF | M_XSS_FILTER_OFF);
    $back = empty($back) ? SiteRoot("admin/discount_codes") : $back;
    
    if ($discnt_id && !$discnt->IsExists())
    {
        trigger_error("Invalid discnt id.", E_USER_ERROR);
    }

    $code          = trim(Post('code',          $discnt_id ? $discnt->code          : NULL));
    $discount      = trim(Post('discount',      $discnt_id ? $discnt->discount      : NULL));
    $can_use_count = trim(Post('can_use_count', $discnt_id ? $discnt->can_use_count : 99999));
    //$expired       = trim(Post('expired',       $discnt_id ? $discnt->expired       : (time() + 60 * 60 * 24 * 365)));

    $expired = $discnt_id ? $discnt->expired : 0;
    $expired = Post('expired', $expired > 0 ? 
                                   date('Y-m-d', $expired) : 
                                   NULL);
    if ($expired == "1970-01-01")
    {
        $expired = 0;
    }
    else
    {
        $expired = strtotime($expired);
    }

    $discount      = str_replace(",", ".", $discount);
    $discount      = floatval($discount);
    $can_use_count = intval($can_use_count);

    $flashParam = new FlashParam();
    $msg = $flashParam->Get('msg');

    if (Post('is_apply'))
    {
        $errs = array();
        if (empty($code))
        {
            $errs[] = "Код не может быть пустым";
        }
        if (!$discnt_id && $discnt->IsCodeBusy($code))
        {
            $errs[] = "Данный код уже используется";
        }
        if ($discnt_id && $discnt->code != $code && $discnt->IsCodeBusy($code))
        {
            $errs[] = "Данный код уже используется";
        }

        if (empty($discount) || $discount < 0.0 || $discount > 100.0)
        {
            $errs[] = "Некорректная скидка";
        }

        //if ($expired == 0)
        //{
        //    $errs[] = "Некорректная дата истечения";
        //}

        if (empty($errs))
        {
            if (!$discnt_id)
            {
                $discnt->added = time();
            }
            $discnt->code          = $code;
            $discnt->expired       = $expired == 0 ? (time() + 5 * 24 * 60 * 60 * 365) : $expired; // По умолчанию 5 лет до истечения от текущей даты
            $discnt->discount      = $discount;
            $discnt->can_use_count = $can_use_count;
            $id                    = $discnt->Flush();

            if ($id)
            {
                $msg = MsgOK($discnt_id ? "Код успешно изменен" : "Код успешно добавлен");
                $flashParam->Set('msg', $msg);
                Header("Location: {$back}&edited_id={$id}#aid{$id}");
                exit(0);
                //$_POST = array();
            }
            else
            {
                $errs[] = "Ошибка регистрации";
            }
        }
        $msg = empty($errs) ? $msg : MsgErr(implode('<br>', $errs));
    }
    /*
    for ($i = 0; $i < 10; ++$i)
    {
            $discnt = new DiscountCodeModel();
            $discnt->added         = time();
            $discnt->code          = "ALL-CODE-" . mt_rand() . "-" . $i;
            $discnt->expired       = time() - $i * 10000;
            $discnt->discount      = 1 + mt_rand(0, 10);
            $discnt->can_use_count = mt_rand(1, 10);
            $discnt->Flush();
    }//*/
?>
