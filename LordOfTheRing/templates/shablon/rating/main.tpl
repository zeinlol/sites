<div class="block">
<div class="block-head">Рейтинг игроков</div>
    <div class="block-prebody">
        <div id="menu" class="lk_menu">
            {server}
			[admin]
				<form method="post" action="">
				<input name="update" style="border: none; color: #ffffff; background: #da4b3e; float: right; margin: 7px 7px 7px 0px;" type="submit" value="Обнулить" class="lk_menu_button">
				</form>
			[/admin]
			<a class="lk_menu_button-link" style="float: right; margin: 7px 7px 7px 0px;" href="/rating/">
			Общий рейтинг</a>
        </div>
    </div>
    <div class="block-body">
		<div class="info_warning"><b>Рейтинг игроков</b> - средство, чтобы узнать какие игроки играют чаще всего. В рейтинге учавствую только игроки,
		представители администрации из рейтинга убраны. Игроки, которые играют больше всего имеют шанс получить бонус в виде средств на счет, каждый месяц первые три игрока
		в общем рейтинге получают от 50 до 150 рублей на счет, в зависимости от места.</div>
		<br>
		<div class="post-cont-title">Список игроков в рейтинге</div>
        <table class="lottery-history-table" cellspacing="0">
			<tbody>
				<tr class="lottery-history-table-head">
					<td width="10px"></td>
					<td width="400px"style="text-align: left;">Игрок</td>
					<td width="190px">Игровое время</td>
				</tr>
                {top}
            </tbody>
        </table>
    </div>
	    [cent]
		<div class="navigation">
            <a href="/rating/server-{id_server}/page-{back}"><i class="icon-arrow-left2"></i>&emsp; Предыдущая страница</a>
            <a href="/rating/server-{id_server}/page-{next}">Следующая страница &emsp;<i class="icon-arrow-right2"></i></a>
		</div>
		[/cent]
        [one]
        <div class="navigation">
        <span><i class="icon-arrow-left2"></i>&emsp; Предыдущая страница</span>
            <a href="/rating/server-{id_server}/page-{next}">Следующая страница &emsp;<i class="icon-arrow-right2"></i></a>
        </div>
        [/one]
        [end]
        <div class="navigation">
            <a href="/rating/server-{id_server}/page-{back}"><i class="icon-arrow-left2"></i>&emsp; Предыдущая страница</a>
        <span>Следующая страница &emsp;<i class="icon-arrow-right2"></i></span>
        </div>
        [/end]
</div>