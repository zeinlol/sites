    <h1>Редактирование страниц сайта</h1>
    <p>
        Если кнопка редактирования страницы на нужном языке отсутствует, 
        то нужно выбрать редактирование этой страницы на языке по умолчанию (или другом доступном языке),
        заполнить её нужным текстом и в выпадающем списке "Сохранять для языка" выбрать нужный язык.
    </p>
    <?= $msg?>
    <form action="<?= GetCurUrl()?>" method="post">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
                <?php foreach($all as $path => $pageLangs):?>
                    <tr>
                        <td class="path">
                            <?php for ($i = 0; $i < substr_count(substr($path, 0, -1), '/'); ++$i):?>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php endfor?>
       
                            <?php if (substr($path, -1) == "/"):?>
                                <span class="glyphicon glyphicon-folder-open"></span> &nbsp;
                                <em><?= basename($path)?></em>
                            <?php else:?>
                                <span class="glyphicon glyphicon-file"></span> &nbsp;
                                <strong><?= str_replace(".php", "", basename($path))?></strong>
                            <?php endif?>
       
                            <?php if (isset($g_config['page_editor']['labels'][$path])):?>
                                &nbsp; <span class="label label-default"><?= $g_config['page_editor']['labels'][$path]?></span>
                            <?php endif?>
                        </td>
                        <td width=1>
                            <?php if (count($g_arrLangs) == 1):?>
                                <a href="<?= SiteRoot("admin/page_editor_page&lang=" . DEF_LANG . "&page=" . urlencode($path))?>" class="btn btn-sm btn-primary" title="Редактировать страницу">
                                    <?= $g_arrLangs[DEF_LANG]['name']?>
                                </a>
                            <?php else:?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        Править <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach ($g_arrLangs as $lang => $langInfo):?>
                                            <?php if (substr($path, -1) != "/" && in_array($lang, $pageLangs)):?>
                                                <li>
                                                    <a href="<?= SiteRoot("admin/page_editor_page&lang=" . $lang . "&page=" . urlencode($path))?>">
                                                        <?= $langInfo['name']?>
                                                    </a>
                                                </li>
                                            <?php endif?>
                                        <?php endforeach?>
                                    </ul>
                                </div>
                            <?php endif?>
                        </td>
                        <td width=1> <!-- @todo Добавить защиту от дурака (запрет на удаление файлов в dev, autoload и т.д.) -->
                            <button class="btn btn-sm btn-danger" name="remove_page" value="<?= str_replace(".php", "", $path)?>" onclick="return confirm('Удалить данную страницу?')">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach?>
            </table>
        </div>
    </form>
