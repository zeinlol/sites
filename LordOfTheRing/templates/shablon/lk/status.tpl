<div class="lk_status_line">
	<div class="lk_status_title">
		{status}
		<div class="lk_status_cost">{price} <small>руб.</small></div>
	</div>
	<div class="lk_status_desc">{desc}</div>
	<div class="lk_status_serv">
	<form method="post" action="">
		<input type="hidden" name="id_status" value="{id_status}">
			<select class="select_serv" name="id_server">
				<option selected disabled>Выберите сервер...</option>
				{options}
			</select>
		<div class="lk_status_buy_amo" style="display: none;">Рейтинг данного статуса: <br/>{rating}.</div>
		<div class="lk_status_buy_amo">
		{write}
		</div>
		<input class="lk_status_pay" type="submit" value="Приобрести">
	</form>
    </div>
</div>