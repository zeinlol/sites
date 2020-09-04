<div class="block">
    <div class="block-head">Управление: Бонус-коды \ Добавление бонус-кода</div>
    <div class="block-body">
		<div class="fox-bonus-adm-block-info"><span class="masha_index masha_index2" rel="2"></span>
			Чтобы не ругался браузер в пустые поля ставьте 0, тогда скрипт их проигнорирует.
		</div>
		<form method="post" action="" class="center">
			<a class="fox-bonus-adm-block-bt" href="http://www.cy-pr.com/tools/time/" target="_blank">Я помогу тебе перевести время в UNIX</a><br />
			<select name="keytype" class="fox-bonus-adm-block-select">
                <option value="" selected disabled>Выберите то, что будет получать игрок</option>
				<option value="1">Деньги(сайт)</option>
                <option value="2">Предмет</option>
                <option value="3">Статус</option>
                <option value="4">Монеты(сервер)</option>
			</select>
			<select name="server" class="fox-bonus-adm-block-select">
                <option value="" selected disabled>Выберите сервер (для предмета, статуса и монет)</option>
				{server}
			</select><br />
			<input class="fox-bonus-adm-block-tf" type="text" name="key" value="" placeholder="Бонус-Код" required><br />
            <input class="fox-bonus-adm-block-tf" type="text" name="bonus" value="" placeholder="Сумма денег/ID предмета/Статус/Кол-во монет (PEX)" required><br />
            <input class="fox-bonus-adm-block-tf"" type="text" name="endkey" value="" placeholder="Дата окончания действия кода(в UNIX), 0 = неограниченно" required><br />
			<input class="fox-bonus-adm-block-tf" type="text" name="endcount" value="" placeholder="Кол-во активаций кода, 0 = неограниченно" required><br />
            <input class="fox-bonus-adm-block-tf" type="text" name="count" value="" placeholder="Для предмета кол-во/Для статуса время действия в секундах с момента активации, 0 = неограниченно" required><br />
            <input class="fox-bonus-adm-block-tf" type="text" name="des" value="" placeholder="Для предмета Название предмета/Для статуса название статуса" required><br />
            <div class="fox-bonus-separator"></div>
			<input class="fox-bonus-adm-block-bt" type="submit" value="Добавить">
		</form>
    </div>
</div>