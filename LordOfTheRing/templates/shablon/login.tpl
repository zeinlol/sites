[not-group=5]
		<div class="auth">
		<div class="auth_pad">
		</div>
		<div class="login_head">
		ПРОФИЛЬ
		</div>
		<div class="prof_cont">
		<div class="avatar">
		<a href="{profile-link}"><img src="/engine/modules/avatar.php?s=50&u={login}" alt=""/></a>
		<div>Привет, {login}!<!--<br/>-->
		<!--<span style="color: #8b8b8b;"><a href="/message/">Твои сообщения</a></span><span class="num_mes">{new-pm}</span>--></div></div>
		<div class="profcontent">
			<ul class="proflist">
			[admin-link]<li class="login_pane__admin"><a href="{admin-link}" target="_blank">Админпанель</a></li>[/admin-link] 
			<li><span class="icon-vcard"></span><a href="{profile-link}">Профиль игрока</a></li>
			<!--<li><span class="icon-tools"></span><a href="/lk.tpl">Личный кабинет</a></li>-->
			<!--<li><span class="icon-cart"></span><a href="/shop/">Онлайн-магазин</a></li>
			<li><span class="icon-ticket"></span><a href="/lottery/">Лотерея</a></li>
			<li><span class="icon-cycle"></span><a href="/referal/">Реферальная система</a></li>
			<li><span class="icon-tag"></span><a href="/promo/">Активация промо-кодов</a></li>
			<li><span class="icon-bars"></span><a href="/rating/">Рейтинг игроков</a></li>-->
			<li><span class="icon-logout"></span><a href="{logout-link}">Выход</a></li>
			</ul>
		</div>
		<div class="balance">
			<!--<div class="bal_text">ВАШ БАЛАНС</div>
			<div class="bal_amou">{real_money} руб.</br> {prem_money} куб.</div>
			<div style="clear: right;"></div>
			<a href="/index.php?do=lk&module=money">
			<input class="balance_but" value="ПОПОЛНИТЬ СЧЕТ" type="button"/>
			</a>-->
		</div>
		</div>
		<div class="prof_foot">
		</div>
		</div>
[/not-group]
[group=5]
		<div class="auth">
		<div class="auth_pad">
		</div>
		<div class="login_head">
		АВТОРИЗАЦИЯ		
		</div>
		<div class="auth_cont">
		<form method="post" action="">
		<div class="auth_desc"><span>Добро Пожаловать!</span> </br>Чтобы полноценно пользоваться всеми функциями сайта вам необходимо войти в свой аккаунт или зарегистрироваться.</div>
		<input for="login_name" placeholder="Логин" type="text" class="auth_tf " name="login_name" id="login_name" /></br>
		<input for="login_password" placeholder="Пароль" type="password" class="auth_tf " name="login_password" id="login_password" /></br>
		<div class="auth_pi"><a href="{lostpassword-link}">(Забыли пароль?)</a></div>
		<button class="cursor auth_ok" onclick="submit();" type="submit" title="Войти"><span>Войти</span></button>
		<div class="line_or">ИЛИ</div>
		<input class="cursor auth_reg" value="ЗАРЕГИСТРИРОВАТЬСЯ" onClick="location.href='{registration-link}'" type="button"/>
		<input name="login" type="hidden" id="login" value="submit" />
		</form>
		</div>
		<div class="auth_foot">
		</div>
		</div>
[/group]