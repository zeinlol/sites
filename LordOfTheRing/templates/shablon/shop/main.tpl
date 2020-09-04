<div class="block">
    <div class="block-head">Онлайн - магазин сервера {msg_server}
	</div>
	    <div class="block-prebody">
        <div id="menu" class="lk_menu">
            {server}
			<a class="lk_menu_button" style="float: right; margin: 7px 7px 7px 0px; width: 45px; padding: 0px;" href="/shop/logs/">
			<span class="icon-clock lk_icon"></span></a>
			[group=1]<a class="lk_menu_button" style="color: #ffffff; background: #da4b3e; float: right; margin: 7px 7px 7px 0px; width: 45px; padding: 0px;" href="/?do=shopadmin">
			<span class="icon-cog lk_icon"></span></a>[/group]
        </div>
    </div>
    <div class="block-body">
        [not-group=5]
        <div class="right">
		<form class="shop-search-block" method="post" action="">
			<input type="text" placeholder="Искать товар..." name="search" value="" class="shop-search-tf">
		</form>
		</div>
		<div class="shop-category-list">
		<ul>
			<li>Категории товаров магазина
				<ul>
					{category}
				</ul>
			</li>
		</ul>
		</div>
		<br>
        <table class="shop-products-table">
		<tr class="shop-products-table-string-head">
			<td width="40px"></td>
			<td width="182px"></td>
			<td width="170px"></td>
			<td width="130px"></td>
			<td width="110px"></td>
		</tr>
            
      [/not-group]