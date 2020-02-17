
    <?php IncludeCom('dev/bootstrap3')?>
    <head>
        <script type="text/javascript" src="<?= Root('i/js/admin/discount_code.js')?>"></script>
    </head>


    <?php if ($discnt_id):?>
        <h1>Редактирование кода скидки</h1>
    <?php else:?>
        <h1>Добавление кода скидки</h1>
    <?php endif;?>
    <br>
    <form action="<?= GetCurUrl()?>" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <div class="col-lg-offset-4 col-lg-6">
                <?= $msg?>
            </div>
        </div>
        <input type="hidden" name="is_apply" value="1">
              
        <div class="form-group">
            <label for="inputCode" class="col-lg-4 control-label">Код *</label>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="inputCode" autocomplete="on" name="code" value="<?= $code?>">
                <p class="help-block">
                    <a href="" class="btn btn-default btn-sm" id="gen-dscnt-code" style="display: none;"> 
                        <span class="glyphicon glyphicon-refresh"></span>
                        Сгенерировать
                    </a>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label for="inputDisc" class="col-lg-4 control-label">Размер скидки процентов *</label>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="inputDisc" autocomplete="on" name="discount" value="<?= $discount?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputUseCount" class="col-lg-4 control-label">Осталось число использований *</label>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="inputUseCount" autocomplete="on" name="can_use_count" value="<?= $can_use_count?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputExpired" class="col-lg-4 control-label">Дата истечения</label>
            <div class="col-lg-6">
                <input type="date" class="form-control" id="inputExpired" autocomplete="on" name="expired" value="<?= $expired ? date('Y-m-d', $expired) : ""?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-4 col-lg-6">
                <button type="submit" class="btn btn-primary"><?= $discnt_id ? "Сохранить" : "Добавить"?></button>
            </div>
        </div>
    </form>