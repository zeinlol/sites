<div class="block">
<div class="block-head">Админ-панель шопа</div>
<div class="block-body">
    <div class="sh_desc_serv">
            <button class="sh_desc_serv_pre">
                Добавление товаров на сервер:
            </button>
            <button class="sh_desc_serv_name">
                {msg_server}
            </button>
    </div>
<form method="post" action="" enctype="multipart/form-data">
	<div class="adm_block_textfields">
	<input class="adm_block-tf" type="text" name="name" value="" placeholder="Название" required>
	<input class="adm_block-tf" type="text" min="1" name="desc" value="" placeholder="Описание" required>
	<input class="adm_block-tf" type="number" min="1" name="price" value="" placeholder="Цена" required>
	<input class="adm_block-tf" type="text" name="mine_id" value="" placeholder="ID в Minecraft" required>
	<input class="adm_block-tf" type="number" min="1" max="64" name="amount" value="" placeholder="Кол-во" required>
	<input class="adm_block-tf" type="hidden" name="server" value="{server}">
	</div>
	<hr>
	Иконка товара <br>
	<div style="/*border: 5px ridge #3498db;*/" class="shop-adm-image-block">
		{img}
    </div>
	<hr>
	<div class="adm_block_textfields">
	<div class="adm_block-options-desc">Можно зачаровать?</div> <select class="adm_block-options-select" name="enchant">
		<option value="1">Да</option>
		<option value="0">Нет</option>
	</select>
	<br><br>
	<div class="adm_block-options-desc">Категория</div> <select class="adm_block-options-select" name="category">{category}</select>
	<hr>
	<input class="adm_block_add_but" type="submit" value="Добавить">
	</div>
</form>