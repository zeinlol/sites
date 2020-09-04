<div class="block">
<div class="block-head">Реферальная система</div>
<div class="block-body">
[parent]
<div class="info_access">
Вы являетесь игроком, которого пригласил <b><a href="/user/{parent}/">{parent}</a></b>, поэтому он получает бонусы от Вашего пополнения счета.
</div><br>
[/parent]
<div class="info_warning">
<b>Реферальная система</b> является еще одной возможностью получения бонусов для игроков нашего проекта. Если Вы пригласили друга или знакомого и при регистрации своего аккаунта
он укажет Ваш ник в соответствующем поле, то он отобразится в таблице ниже. Как только приглашенный игрок пополнит свой личный счет Вы получите 5% от его
пополнения.
</div>
<br>
<div class="post-cont-title">Список приглашенных игроков</div>
<table width="100%" cellspacing="0" class="lottery-history-table">
    <tr class="lottery-history-table-head">
        <td></td>
        <td style="text-align: left;">Игрок</td>
		<td width="150px">Дата регистрации</td>
		<td width="150px">Полученный бонус</td>
    </tr>
    [child]
   	{refchild}
    [/child]
    [no_child]
		<tr class="lottery-history-table-list">
		    <td colspan="4"><div class="no-comments">
			Вы еще не приглашали игроков на наш проект, а если и приглашали, 
			то Ваш ник они не указывали при регистрации своего аккаунта.</div>
			</td>
		</tr>
    [/no_child]
</table>

</div>
</div>