[prefix]
<div class="lk_cont_title">Установка префикса в чате</div>
</br>
<div class="info_warning">Будьте внимательны, правилами нашего проекта установлено, что префикс должен состоять из одного символа.
Если символов будет больше одного, то они будут обрезаны.</div>
</br>
<div class="info_error">Правилами нашего проекта также запрещена установка префиксов, схожими с префиксами администрации. (буквы "А", "М" и "С")</div>
<div class="lk_person_line">
<form method="post" action="">

	<select name="color_prefix">
		<option style="background:#ffffff;" value="f">#f</option>
		<option style="background:#0000bf;" value="1">#1</option>
		<option style="background:#00bf00;" value="2">#2</option>
		<option style="background:#00bfbf;" value="3">#3</option>
		<option style="background:#bf0000;" value="4">#4</option>
		<option style="background:#bf00bf;" value="5">#5</option>
		<option style="background:#bfbf00;" value="6">#6</option>
		<option style="background:#bfbfbf;" value="7">#7</option>
		<option style="background:#404040;" value="8">#8</option>
		<option style="background:#4040ff;" value="9">#9</option>
		<option style="background:#40ff40;" value="a">#a</option>
		<option style="background:#40ffff;" value="b">#b</option>
		<option style="background:#ff4040;" value="c">#c</option>
		<option style="background:#ff40ff;" value="d">#d</option>
		<option style="background:#ffff40;" value="e">#e</option>
	</select>
	
	<input type="text" name="text_prefix" maxlength="1" placeholder="Символ" required class="lk_tf">
	
	<select name="color_nick">
		<option style="background:#ffffff;" value="f">#f</option>
		<option style="background:#0000bf;" value="1">#1</option>
		<option style="background:#00bf00;" value="2">#2</option>
		<option style="background:#00bfbf;" value="3">#3</option>
		<option style="background:#bf0000;" value="4">#4</option>
		<option style="background:#bf00bf;" value="5">#5</option>
		<option style="background:#bfbf00;" value="6">#6</option>
		<option style="background:#bfbfbf;" value="7">#7</option>
		<option style="background:#404040;" value="8">#8</option>
		<option style="background:#4040ff;" value="9">#9</option>
		<option style="background:#40ff40;" value="a">#a</option>
		<option style="background:#40ffff;" value="b">#b</option>
		<option style="background:#ff4040;" value="c">#c</option>
		<option style="background:#ff40ff;" value="d">#d</option>
		<option style="background:#ffff40;" value="e">#e</option>
	</select>
	
	<select name="color_chat">
		<option style="background:#ffffff;" value="f">#f</option>
		<option style="background:#0000bf;" value="1">#1</option>
		<option style="background:#00bf00;" value="2">#2</option>
		<option style="background:#00bfbf;" value="3">#3</option>
		<option style="background:#bf0000;" value="4">#4</option>
		<option style="background:#bf00bf;" value="5">#5</option>
		<option style="background:#bfbf00;" value="6">#6</option>
		<option style="background:#bfbfbf;" value="7">#7</option>
		<option style="background:#404040;" value="8">#8</option>
		<option style="background:#4040ff;" value="9">#9</option>
		<option style="background:#40ff40;" value="a">#a</option>
		<option style="background:#40ffff;" value="b">#b</option>
		<option style="background:#ff4040;" value="c">#c</option>
		<option style="background:#ff40ff;" value="d">#d</option>
		<option style="background:#ffff40;" value="e">#e</option>
	</select>
	<div style="float: right;">
	<select name="server">
		{options}
	</select>
	
	<input type="submit" name="prefix" value="Изменить" class="lk_button">
	</div>
</form>
</div>
[/prefix]

[no_prefix]
<div class="lk_cont_title">Установка префикса в чате</div>
<br/>
<div class="info_error">Вы не можете менять свой префикс, у вас нет данной превилегии. Но вы можете приобрести ее в разделе "Дополнения"</div>
[/no_prefix]