<div class="lk_cont_title">Пополнение и обмен средств счета</div>
<div class="lk_balance_line">
	Пополнение баланса Вашего счета (InterKassa)<br/>
	<span class="lk_balance_desc">Внимательно выполняйте все шаги пополнения.</span>
	<div class="lk_block_button">
	<form method="post" action="">
		<input type="hidden" name="addmoney" value="1">
		<input type="number" name="money" value="" placeholder="Сумма в руб." class="lk_tf" required> руб.
		<input type="submit" value="Пополнить" class="lk_button">
	</form>
	</div>
	<div style="clear: right;"></div>
</div>
<div class="lk_balance_line">
	Пополнение баланса Вашего счета (WebMoney)<br/>
	<span class="lk_balance_desc">Внимательно выполняйте все шаги пополнения.</span>
	<div class="lk_block_button">
	<form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST">
        <input type="hidden" name="LMI_PAYEE_PURSE" value="R409285583423">
		<input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="0J/QvtC/0L7Qu9C90LXQvdC40LUg0YHRh9GR0YLQsCDQvdCwIE1DIFNNQVJU">
 		<input type="hidden" name="LMI_PAYMENT_NO" value="{id}">
		<input type="number" name="LMI_PAYMENT_AMOUNT" value="" placeholder="Сумма в руб." class="lk_tf" required> руб.
		<input type="submit" value="Пополнить" class="lk_button">
	</form>
	</div>
	<div style="clear: right;"></div>
</div>
<div class="lk_balance_line">
	Передача средств др. игроку<br/>
	<span class="lk_balance_desc">Внимательно указывайте данные.</span>
	<div class="lk_block_button">
	<form method="post" action="">
		<input type="hidden" name="sendmoney" value="1">
		<input type="text" name="nick" value="" placeholder="Ник игрока" class="lk_tf" required>
		<input type="number" name="send" value="" placeholder="Сумма в руб." class="lk_tf" required> руб.
		<input type="submit" value="Пополнить" class="lk_button">
	</form>
	</div>
	<div style="clear: right;"></div>
</div>