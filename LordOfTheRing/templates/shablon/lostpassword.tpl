<div class="block">
<div class="block-head">Восстановление забытого пароля</div>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tbody style="vertical-align: top;">
<tr><td class="block-body" style="height: 352px;">  
<div  class="info_error">
Восстанавливайте пароль только в случае острой необходимости, если окончательно забыли его.
Частое использование функции восстановления пароля заблокирует эту возможность.
</div>
<br/>
<table width="100%">
<tr>
			<td width="43%" class="label">
				<span class="reg_info">Ваш игровой ник</span><br/><span class="reg_info2">Который вы использовали при регистрации</span>
			</td>
			<td>
				<span class="icon-tf icon-user"></span><input placeholder="Например: Sample" autocomplete="off" type="text" name="name" style="margin-right: 6px;" class="reg_tf" />
				<div id='result-registration'></div>
			</td>
		</tr>
		<tr>
			<td class="label">
				<span class="reg_info">Ваша почта (E-mail)<br/><span class="reg_info2">Которую вы использовали при регистрации</span>
			</td>
			<td><span class="icon-tf icon-mail"></span><input placeholder="Например: sample@yandex.ru" autocomplete="off" name="lostname" class="reg_tf" /></td>
		</tr>
		[sec_code]
		<tr>
			<td class="label">
				{code}
			</td>
			<td>
				<span class="icon-tf icon-arrow2"></span><input placeholder="Введите код с картинки" type="text" name="sec_code" class="reg_tf" />
			</td>
		</tr>
		[/sec_code]
<tr>
<td style="text-align:center; vertical-align: top;">
[recaptcha]
<div class="regix">
Код безопасности:
<div class="subreg" style="padding-bottom:10px;">Введите два слова, показанных на изображении:</div>
{recaptcha}
</div>
[/recaptcha]</td></tr></table>
<center><input type="submit" name="submit" class="bbcodes" style="width:100%;margin:47px 0 0px 0;" value="Отправить запрос на восстановление пароля" /></center>
</td></tr>
</tbody>
</table>
</div>