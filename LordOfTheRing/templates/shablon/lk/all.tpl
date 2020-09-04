<div class="info_warning">
Обратите внимание, что в комплект статуса уже входят некоторые из этих опций. Внимательно изучите входящие в комплект статуса, если 
вы имеете приобретенный. В противном случае, за ошибки перевода средств и повторные покупки деньги не возвращаются.
</div>
<br/>
<div class="lk_cont_title">Дополнительные приобретаемые опции</div>

	<div class="lk_opt-buy_line">
	Возможность установки HD-скина<br/>
	<span class="lk_opt-buy_desc">Дает 30 дней использования возможности установки HD-скина.</span>
		<form method="post" action="" class="lk_block_button">
			<div class="lk_opt-buy_price">{price_hd_skin} РУБ.</div>
			<input type="hidden" name="action" value="hd_skin">
			<input type="submit" value="Приобрести" class="lk_button lk_opt-buy_sub">
		</form>
	<div style="clear: right;"></div>
	</div>
	
	<div class="lk_opt-buy_line">
	Возможность установки HD-плаща<br/>
	<span class="lk_opt-buy_desc">Дает 30 дней использования возможности установки HD-плаща.</span>
		<form method="post" action="" class="lk_block_button">
			<div class="lk_opt-buy_price">{price_hd_cloak} РУБ.</div>
			<input type="hidden" name="action" value="hd_cloak">
			<input type="submit" value="Приобрести" class="lk_button lk_opt-buy_sub">
		</form>
	<div style="clear: right;"></div>
	</div>
	
	<div class="lk_opt-buy_line">
	Возможность установки плаща<br/>
	<span class="lk_opt-buy_desc">Дает 30 дней использования возможности установки плаща.</span>
		<form method="post" action="" class="lk_block_button">
			<div class="lk_opt-buy_price">{price_cloak} РУБ.</div>
			<input type="hidden" name="action" value="cloak">
			<input type="submit" value="Приобрести" class="lk_button lk_opt-buy_sub">
		</form>
	<div style="clear: right;"></div>
	</div>

	<div class="lk_opt-buy_line">
	Возможность смены префикса<br/>
	<span class="lk_opt-buy_desc">Дает 10 дней использования возможности изм. префикса в чате.</span>
		<form method="post" action="" class="lk_block_button">
			<div class="lk_opt-buy_price">{price_prefix} РУБ.</div>
			<input type="hidden" name="action" value="prefix">
			<input type="submit" value="Приобрести" class="lk_button lk_opt-buy_sub">
		</form>
	<div style="clear: right;"></div>
	</div>
	
<div class="lk_cont_title">Удаление статусов на серверах</div>	

	<div class="lk_person_line">
	Удаление статуса на сервере<br/>
	<span class="lk_person_desc">Возвращается {perset}% от оставшегося времени.</span>
		<form method="post" action="">
			<div class="lk_block_button">
			<input type="hidden" name="action" value="delstatus">
			<select name="id_server">
				<option selected disabled>Выберите сервер...</option>
				{options}
			</select>
			<input type="submit" value="Удалить" class="lk_button lk_person_sub">
			</div>
		</form>
	<div style="clear: right;"></div>
	</div>	
