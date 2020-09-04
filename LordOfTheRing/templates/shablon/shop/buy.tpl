<div class="block">
<div class="block-head">{server} / Покупка товара: {name}</div>
<div class="block-prebody">
        <div id="menu" class="lk_menu">
			<a class="lk_menu_button" style="float: right; margin: 7px 7px 7px 0px; width: 45px; padding: 0px;" href="/?do=logs">
			<span class="icon-clock lk_icon"></span></a>
			<a class="lk_menu_button-link" style="float: right; margin: 7px 7px 7px 0px;" href="javascript:history.back()">Назад</a>
        </div>
    </div>
<div class="block-body">
    <script type="text/javascript" >
        function getvalue(num) {
			var element = num;
			var element2 = 'value'+num;
			var element3 = 'price'+num;
			var element4 = 'pricevalue'+num;
			size = document.getElementById(element).value; 
            document.getElementById(element2).value = size;
			size2 = document.getElementById(element3).value; 
            document.getElementById(element4).value = size*size2;
            var sum = 0, price = {price};
            size4 = parseInt(document.getElementById('amount_product').value);
            {enchantjs}
            sum = price + sum;
            sum = sum * size4;
            document.getElementById('result_number').innerHTML = size4*{number};
            document.getElementById('inline').innerHTML = sum;
        }
        function getvalue2(num) {
            var sum = 0, price = {price};
            size4 = parseInt(document.getElementById('amount_product').value);
            {enchantjs}
            sum = price + sum;
            if (num==1 && size4!=1) {
            	size4=size4-1;
            } else if (num==2) {
            	size4=size4+1;
            }
            sum = sum * size4;
            document.getElementById('result_number').innerHTML = size4*{number};
            document.getElementById('inline').innerHTML = sum;
        }
        $(document).ready(function() {
            $('.minus').click(function () {var $input = $(this).parent().find('input[id="amount_product"]');
                var count = parseInt($input.val()) - 1; count = count < 1 ? 1 : count; $input.val(count); $input.change(); return false;
            });
            $('.plus').click(function () {var $input = $(this).parent().find('input[id="amount_product"]');
                $input.val(parseInt($input.val()) + 1); $input.change(); return false;
                getvalue2(2);
            });
        });
	</script>
	<table cellspacing="0" class="shop-buy-desc-table">
		<tr class="shop-buy-desc-table-string">
			<td class="shop-buy-desc-table-string-title" width="30%">Название товара</td>
			<td class="shop-buy-desc-table-string-info" width="70%">{name} <div class="right shop-buy-desc-information inline">ID предмета: {id}</div></td>
		</tr>
		<tr class="shop-buy-desc-table-string">
			<td class="shop-buy-desc-table-string-title">Категория товара</td>
			<td class="shop-buy-desc-table-string-info">{category}</td>
		</tr>
		<tr class="shop-buy-desc-table-string">
			<td class="shop-buy-desc-table-string-title">Описание товара</td>
			<td class="shop-buy-desc-table-string-info-description">{description}</td>
		</tr>
		<tr class="shop-buy-desc-table-string">
			<td class="shop-buy-desc-table-string-title">Стоимость товара</td>
			<td class="shop-buy-desc-table-string-info">[discount]<span class="shop-products-table-discount hint cursor" data-original-title="Цена с учетом скидки в {discount}%">[/discount]{price}.00 руб.[discount]</span> <span class="shop-products-table-nodiscount">{nodis}.00 руб</span>[/discount] за {number} шт.</td>
		</tr>
		[enchant]
		<tr class="shop-buy-desc-table-string">
			<td class="shop-buy-desc-table-string-title">Зачарование товара</td>
			<td class="shop-buy-desc-table-string-info"><span class="shop-products-table-string-enchant">Этот предмет можно зачаровать</span></td>
		</tr>
		[/enchant]
	</table>
	<img class="shop-buy-img" src="{img}" width="96px" height="96px">
	<div style="clear: right;"></div>
	<form method="post" action="">
		<input type="hidden" name="id_product" value="{id_product}">
		<input type="hidden" name="type" value="{type}">
		<div style="clear: left;"></div><br>
		
        [enchant]
		<dl class="accordion">
		<dt class="acc-trigger">
		<div class="acc-title">Зачарование этого предмета <div class="right acc-icons"><span class="icon-arrow-up4 open-icon"></span><span class="icon-arrow-down5 close-icon"></span></div></div></dt>
		<dd class="acc-content">
		<table cellspacing="0" class="shop-producst-enchant-table">
		{enchant}
		</table>
		</dd>
		</dl>
		[/enchant]

	<div class="post-cont-title">Приобретение товара</div><br>
			<div class="center">
			При покупке данного товара [discount]<span style="color: #da4b3e;">с учетом скидки</span> [/discount]вы заплатите <b><div id="inline" class="inline">{price}</div></b> руб. с вашего счета[enchant], с учетом зачарования[/enchant] <br>
			и получите <b><div id="result_number" class="inline">{number}</div></b> шт. предмета "{name}" на сервере <b style="text-transform: capitalize;">{server}</b>.
			</div>
			<div class="lk_balance_line">
				Ник-нейм получателя подарка<br>
				<span class="lk_balance_desc">Введите, если Вы хотите купить это другому игроку.</span>
				<div class="lk_block_button">
					<input style="width: 270px !important;" class="lottery-tf" type="text" name="nik" placeholder="Ник игрока" oninput="getvalue2(3)" maxleight="20">
				</div>
			</div>	
			<div class="lk_balance_line">
				Выберите количество товара (1 ед. = {number} шт.)<br>
				<span class="lk_balance_desc">Т.е. выбранное кол-во будет умножено на {number}.</span>
				<div class="lk_block_button">
                    <input type="button" class="shop-buy-product-amount-change-bt-minus cursor minus" onclick="getvalue2(1)" value="-">
					<input style="width: 115px !important;" readonly="readonly" id="amount_product" class="lottery-tf-not-select"  name="number" type="number" value="1" placeholder="1" max="256" min="1">
					<input type="button" class="shop-buy-product-amount-change-bt-plus cursor plus" onclick="getvalue2(2)" value="+">
					<a class="promo_code_info hint cursor" data-original-title="Зависимость от этого значения вы можете наблюдать выше."><span class="icon-info"></span></a>
					<input type="submit" name="buy_enchant_product" value="Приобрести" class="lk_button lk_opt-buy_sub">
				</div>
			</div>				
    </form>
</div>
</div>
<script>
$('.acc-trigger').click(
function(){
	$(this).toggleClass('trigger-selected');
	$(this).next('.acc-content').slideToggle();
});
</script>