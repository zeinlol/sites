<div class="block">
    <div class="block-head">Профиль {group} {usertitle} <div style="float: right;">{edituser}</div>
    </div>
    <!--<div class="user_background" style="background: url({foto}) 50% 50% rgba(0,0,0,0.4);"></div>-->
    <div class="block-body">
        <!--<div class="user_mInfo_body">
<div class="user_mInfo_block">
<div class="user_mInfo_avatar"><img src="/engine/modules/avatar.php?s=100&u={usertitle}" alt=""/><div class="user_mInfo_group" data-original-title="Является {group}ом">{group-icon}</div></div>
{signature}
<ul class="user_mInfo_options">
	[not-group=5]
	<li class="user_bar_option"><a href="/index.php?do=pm&doaction=newpm&username={usertitle}">Отправить сообщение</a></li>
	[icq]<li class="user_bar_option"><a href="http://vk.com/{icq}">Страница ВКонтакте</a></li>[/icq]
	[not-icq]<li class="user_bar_option" data-original-title="Страница ВК не указана" style="opacity: 0.4;">Страница ВКонтакте</li>[/not-icq]
	[/not-group]
	[group=5]
	<li class="user_bar_option" data-original-title="Неактивированным участникам не разрешено отправлять сообщения" style="opacity: 0.4;">Отправить сообщение</li>
	<li class="user_bar_option" data-original-title="Для просмотра страницы авторизируетесь на сайте" style="opacity: 0.4;">Страница ВКонтакте</li>
	[/group]
</ul>
</div>
</div>-->

        [not-group=5]
        <table class="profview" width="100%">
            <tr>
                <td style="border: none !important;" rowspan="14" valign="top" width="115px">[online]<div class="user_mInfo_online">Онлайн</div>[/online][offline]<div class="user_mInfo_offline">Не в сети</div>
                    <div class="user_mInfo_offline_lastdate">Последний раз в сети:<br />{lastdate}</div>[/offline]
                </td>
                <td colspan="1" width="50%" class="user_mInfo_title_head">Общая информация</td>
            </tr>
            <tr>
                <td class="user_mInfo_title">Имя</td>
                <td class="user_mInfo_text">{fullname}[not-fullname]<span class="not_specified">имя не указано</span>[/not-fullname]</td>
            </tr>
            <tr>
                <td class="user_mInfo_title">Город</td>
                <td class="user_mInfo_text">{land}[not-land]<span class="not_specified">имя не указано</span>[/not-land]</td>
            </tr>
            <tr>
                <td class="user_mInfo_title" style="border: none !important;">Дата регистрации</td>
                <td class="user_mInfo_text" style="border: none !important;">{registration}</td>
            </tr>
            <td colspan="1" width="50%" class="user_mInfo_title_head">Активность</td>
            <tr>
                <td class="user_mInfo_title">Количество комментариев</td>
                <td class="user_mInfo_text">{comm-num}</td>
            </tr>
            <!--<tr><td class="user_mInfo_title">Количество сообщений на форуме</td><td class="user_mInfo_text">{countMessage}</td></tr>
<tr><td class="user_mInfo_title">Количество трофеев</td><td class="user_mInfo_text">{countTrophies}</td></tr>
<tr><td class="user_mInfo_title" style="border: none !important;">Количество оценок на форуме</td><td class="user_mInfo_text" style="border: none !important;">{like}</td></tr>-->
            <!--<td colspan="1" width="50%" class="user_mInfo_title_head">Статистика на серверах</td>
<tr><td class="user_mInfo_title">Отыграно на сервере Envandoom</td><td class="user_mInfo_text">{envandoom_playtime}</td></tr>
<tr><td class="user_mInfo_title">Отыграно на сервере Quinterum</td><td class="user_mInfo_text">{quinterum_playtime}</td></tr>
<tr><td class="user_mInfo_title">Отыграно на сервере Destbolum</td><td class="user_mInfo_text">{destbolum_playtime}</td></tr>-->
        </table>
        [/not-group]

        [group=5]
        <div class="info_error">
            Вы не можете просматривать профили участников проекта пока не <a href="/register/first-step/">зарегистрируетесь</a> или не авторизируетесь.
            В профилях можно найти контактную и статистическую информацию, связанную с активностью игрока, поэтому мы не разрешаем просматривать это неактивированным участникам.
        </div>
        [/group]
        <script type="text/javascript" src="{THEME}/js/rega.js"></script>
    </div>
</div>
[not-logged]
<div id="options" style="z-index: 99; width: 100%;display:none; padding: 10px 0px 0px 0px;">
    <div class="block">
        <div class="block-head">Настройки профиля <div style="float: right;"><a href="javascript:ShowOrHide('options')">Закрыть</a></div>
        </div>
        <div class="block-body">
            <div class="baseform">
                <table class="user_edit_profile">
                    <!--<tr><td width="59%">E-mail</td><td>{hidemail}</td></tr>
		<tr><td>Адрес E-Mail</td><td><input autocomplete="off" placeholder="Ваш Email-адрес (почта)" type="text" name="email" value="{editmail}" class="post_tf" /><br />-->
                    <tr>
                        <td>Имя</td>
                        <td><input id="fullname" autocomplete="off" placeholder="Ваше имя в реальной жизни" type="text" name="fullname" value="" class="post_tf" /></td>
                    </tr>
                    <tr>
                        <td>Город</td>
                        <td><input autocomplete="off" placeholder="Укажите город, деревню, поселок и т.п." type="text" name="land" value="" class="post_tf" /></td>
                    </tr>
                    <!--<tr><td>Cтраница Вконтакте</td><td><input autocomplete="off" placeholder="Укажите ID своей страницы" type="text" name="icq" value="{icq}" class="post_tf" /></td></tr>-->
                    <tr>
                        <td>Старый пароль</td>
                        <td><input autocomplete="off" placeholder="Введите свой пароль" type="password" name="altpass" class="post_tf" /></td>
                    </tr>
                    <tr>
                        <td>Новый пароль</td>
                        <td><input id="password1" autocomplete="off" placeholder="Введите новый пароль" type="password" name="password1" class="post_tf" onblur="check_first( this )" /></td>
                        <div id="result-first"></div>
                    </tr>
                    <tr>
                        <td>Повторите</td>
                        <td><input id="password2" autocomplete="off" placeholder="Повторите новый пароль" type="password" name="password2" class="post_tf" onblur="check_password()" /></td>
                        <div id="result-pass"></div>
                    </tr>
                    <!--<tr><td>Допустимые IP</td><td><textarea resize="none" placeholder="Впишите сюда IP, с которых будет разрешен вход в ваш профиль" width="188px" name="allowed_ip" rows="2" class="post_tf ">{allowed-ip}</textarea></td></tr>
		<tr><td colspan="2"><div style="color:red;font-size:11px;">* Внимание! Будьте бдительны при изменении данной настройки. Доступ к Вашему аккаунту будет доступен только с того IP-адреса или подсети, который Вы укажете. Вы можете указать несколько IP адресов, по одному адресу на каждую строчку.
		Пример: 192.48.25.71 или 129.42.*.*</div></td></tr>-->
                    <!--<tr><td>Ваш статус</td><td><textarea maxlength="70" width="188px" name="signature" placeholder="Кратко опишите свое настроение, ваши мысли" rows="2" class="post_tf">{editsignature}</textarea></td></tr>
		<tr><td style="height: 100px;">Фон профиля<br/><br/><span class="user_mInfo_edit_desc ">макс.: 800x480<br/>идеал.: 690x200</span></td><td><input type="file" name="image" class="" /><br /><div class="checkbox"><input type="checkbox" name="del_foto" id="del_foto" value="yes" /> <label for="del_foto">Удалить бекграунд</label></div></td></tr>-->
                    <!--<tr><td></td><td>{twofactor-auth}</td></tr>-->
                </table>
                <div class="fieldsubmit submit">
                    <input style="width: 100% !important;margin-top: 40px;" class="bbcodes" type="submit" name="submit" value="Применить" />
                </div>
            </div>
        </div>
        
    </div>
</div>
[/not-logged]
