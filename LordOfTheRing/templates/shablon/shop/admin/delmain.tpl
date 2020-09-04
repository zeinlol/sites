<div class="block">
    <div class="block-head">
        Админ-панель шопа</div>
    <div class="block-body">
		<div class="sh_serv_list">
		<center>
            {server}
        </center>
		</div>
        <hr>
        <div class="sh_desc_serv">
            <button class="sh_desc_serv_pre">
                В данный момент Вы в магазине сервера:
            </button>
            <button class="sh_desc_serv_name">
                {msg_server}
            </button>
        </div>
		<br/>
		<form class="sh_search" method="post" action="">
			<input type="text" placeholder="Введите название товара для поиска" name="search" value="" class="sh_search_tf">
			<button type="submit" class="sh_search_but">Искать</button>
		</form>
        <hr>
		<div class="sh_cat_block">
        {category}
		</div>
        <div>