<div class="block">
<div class="block-head">[pmlist]Список сообщений[/pmlist]
[newpm]Новое сообщение[/newpm]
[readpm]Ваши сообщения[/readpm]<span style="float:right;">[new_pm]Создать сообщение[/new_pm]</span></div>
<div class="block-body"><table border="0" width="100%" cellspacing="1" cellpadding="2">
		<tr><td>
<center><div class="pm_menu"><div class="pm_menu_nav"><span class="icon-forward"></span> [inbox]Входящие сообщения[/inbox]</div><div class="pm_menu_nav"><span class="icon-reply"></span> [outbox]Отправленные сообщения[/outbox]</div></div></center><br/>

<div style="z-index: -1;border-bottom: 1px solid #ececec; margin: 5px 0px 15px 0px;"></div>
[pmlist]
<div class="dpad">{pmlist}</div>
[/pmlist]
[newpm]
	<table class="tableform" style="margin: 0px auto;">
		<tr>
			<td><input type="text" name="name" value="{author}" placeholder="Ник получателя" class="post_tf" /></td>
		</tr>
		<tr>
			<td><input type="text" name="subj" value="{subj}" placeholder="Тема соообщения" class="post_tf" /></td>
		</tr>
		<tr>
			<td class="editorcomm">
			{editor}<br />
			<div class="checkbox"><input type="checkbox" id="outboxcopy" name="outboxcopy" value="1" /> <label for="outboxcopy">Сохранить сообщение в папке "Отправленные"</label></div>
			</td>
		</tr>
		[sec_code]
		<tr>
			<td class="label">
				Код:<span class="impot">*</span>
			</td>
			<td>
				<div>{sec_code}</div>
				<div><input type="text" name="sec_code" id="sec_code" style="width:115px" class="post_tf" /></div>
			</td>
		</tr>
		[/sec_code]
		[recaptcha]
		<tr>
			<td class="label">
				Введите два слова, показанных на изображении:<span class="impot">*</span>
			</td>
			<td>
				<div>{recaptcha}</div>
			</td>
		</tr>
		[/recaptcha]
		[question]
			<tr>
				<td class="label">
					Вопрос:
				</td>
				<td>
					<div>{question}</div>
				</td>
			</tr>
			<tr>
				<td class="label">
					Ответ:<span class="impot">*</span>
				</td>
				<td>
					<div><input type="text" name="question_answer" id="question_answer" class="f_input" /></div>
				</td>
			</tr>
		[/question]
	</table>
	<div class="fieldsubmit" style="margin: 0px auto; width: 315px;margin-top: 10px;">
		<button type="submit" name="add" class="bbcodes"><span>Отправить</span></button>
		<input type="button" class="bbcodes" onclick="dlePMPreview()" title="Просмотр" value="Просмотр" />
	</div>	
[/newpm]
[readpm]
<div class="pm_read">
	<div class="pm_read_author">
	<center>
	<a href="/user/{usertitle}"><img src="/engine/modules/avatar.php?s=50&u={usertitle}" /></a><br/>
	<a href="/user/{usertitle}">{usertitle}</a>
	</center>
	</div>
	<div class="pm_read_text">
	<span class="pm_read_date">{date}</span> 
	<span class="pm_read_reply_b">
	<div class="pm_read_nav prompt" data-original-title="Добавить данного пользователя в список игнорируемых">[ignore]Игнорировать[/ignore]</div> 
	<div class="pm_read_nav">[del]Удалить[/del]</div> 
	<div class="pm_read_nav">[reply]Ответить[/reply]</div></span>
	<div style="clear: right;margin-bottom: 10px;"></div>
	{text}
</div>

[/readpm]
</div>
</td></tr></table></div></div>