<div class="info_warning">
<b>Скин</b> - это внешний вид Вашего песонажа в игре на наших серверах. Именно тот скин, который Вы установите будет отображаться в игре. 
Скин отображается на всех серверах нашего проекта и изменить его для конкретного сервера невозможно, таковы правила.
</div>
<br/>
<div class="info_access" style="display: none;">
У Вас есть возможность сменить свой скин на другой, и все, что вам для этого нужно, это нажать на кнопку ниже. Однако, чтобы установить 
<b>HD-скин</b> нужно иметь статус не ниже Premium, тоже дело обстоит и с <b>HD-плащами</b>, но установить обычный плащ можно только игрокам, имеющим минимум VIP-статус.
Также плащ выдается как приз в некоторых мероприятиях нашего проекта.
</div>
<div class="lk_cont_title">Просмотр персонажа в 2D-плоскости</div>
<br/>
<div class="lk_skin_body">
<div class="lk_skin_body_img">
<img src="/engine/modules/lk/skin2d.php?skinpath={name}&mode=1">
<img src="/engine/modules/lk/skin2d.php?skinpath={name}&mode=2">
</div>
<div style="clear: left;"></div>
</div>
<br/>
<div class="lk_cont_title">Загрузка и удаление скина\плаща для персонажа</div>
	<div class="lk_person_line" style="height: 60px !important;">
	Загрузка скина\плаща <span style="color: red;">(Учитывайте размеры!)</span><br/>
	<span class="lk_person_desc"> Скин - 64x32px. Плащ - 22x17px. HD-Cкин: 1024x512px.</span>
		<form method="post" action="" enctype="multipart/form-data">
			<div class="lk_block_button">
			<select name="type">
				<option selected disabled>Выберите опцию...</option>
				<option value="skin">Загрузить скин</option>
				<option value="cloak">Загрузить плащ</option>
			</select>
			<input type="submit" name="upload" value="Загрузить" class="lk_button lk_person_sub">
			</div>
			<div class="lk_person_upload">
			<input type="file" name="upload" value="" class="lk_person_upload_button">
			</div>
		</form>
	<div style="clear: right;"></div>
	</div><br/>

