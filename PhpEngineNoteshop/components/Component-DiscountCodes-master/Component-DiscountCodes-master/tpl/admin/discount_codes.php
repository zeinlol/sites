
    <?php IncludeCom('dev/bootstrap3')?>


    <h1>Управление кодами скидок</h1>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title">Параметры поиска</h2>
        </div>
        <div class="panel-body">
            <form action="<?= GetCurUrl()?>" method="get" role="form">
                <input type="hidden" name="q" value="admin/discount_codes">
                <div class="row">
                   <div class="col-lg-4">
                      <div class="form-group">
                          <label for="inputSearch" class="control-label">Код или часть кода</label>
                          <input type="text" class="form-control" id="inputSearch" autocomplete="on" name="code" value="<?= Get("code")?>">
                      </div>
                   </div>
                   <div class="col-lg-4">
                       <div class="checkbox">
                           <label>
                               <input type="checkbox" name="show_expired" <?= Get("show_expired") == "on" ? "checked" : ""?>> Показывать просроченые
                           </label>
                       </div>
                       <div class="checkbox">
                           <label>
                               <input type="checkbox" name="show_used" <?= Get("show_used") == "on" ? "checked" : ""?>> Показывать использованые
                           </label>
                       </div>
                   </div>
                </div>
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Выполнить поиск</button>
            </form>
        </div>
    </div>

    <?= $msg?>
    <form action="<?= GetCurUrl()?>" method="post">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Код</th>
                        <th>Добавлен</th>
                        <th>Истекает</th>
                        <th>Можно использовать раз</th>
                        <th width=1></th>
                        <th width=1></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($all)):?>
                        <?php foreach($all as $a):?>
                            <tr id="aid<?= $a->code_id?>" class="<?= Get("edited_id") == $a->code_id ? "success" : ""?>">
                                <td>
                                    <?= $a->code_id?>
                                </td>
                                <td>
                                    <?= $a->code?>
                                </td>
                                <td>
                                    <?= date("d.m.Y", $a->added)?>
                                </td>
                                <td>
                                    <?= date("d.m.Y", $a->expired)?>
                                </td>
                                <td>
                                    <?= $a->can_use_count?>
                                </td>
                                <td>
                                    <a href="<?= SiteRoot("admin/discount_code&code_id={$a->code_id}" . 
                                                                               "&back=" . urlencode(GetCurUrl("edited_id=" . M_DELETE_PARAM)))
                                                      ?>" 

                                      class="btn btn-sm btn-info">
                                        <span class="glyphicon glyphicon-wrench"></span>
                                    </a>
                                </td>
                                <td>
                                    <button href="#" class="btn btn-sm btn-danger" name="remove_id" value="<?= $a->code_id?>" onclick="return confirm('Удалить данную запись?')" title="Удалить запись">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr>
                            <td colspan="99">
                                По запросу ничего не найдено
                            </td>
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </form>
    <?php IncludeCom("dev/paginator", array
    (
        "pageUrl"      => GetCurUrl('page=' . M_PAGINATOR_PAGE),
        "firstPageUrl" => GetCurUrl('page=' . M_DELETE_PARAM),
        "total"        => $total,
        "perPage"      => $per_page,
        "curPage"      => $page
    ))?>
