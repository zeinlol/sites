
<tr>
	<td width="100">
		<b><?php echo $row['name']?></b>
	</td>
	<td width="100">
		<?php echo $row['publicAll'] ? 'Публичный' : 'Приватный'?>
	</td>
	<td width="50" title="Посещения">
		<?php echo $row['visits']?>
	</td>
	<td width="150">
		<?php echo $row['welcomeMessage']?>
	</td>
	<td width="100">
		<button class="lk-button-1" onclick="lk.warpAlert({create: false, <?php echo 'id: '. $row['id'] .', name: \'' . $row['name'] . '\', public: ' . $row['publicAll'] . ', msg: \'' . str_replace("'", '*', $row['welcomeMessage']) . '\', pos: {x: '. $row['x'] .', y: '. $row['y'] .', z:'. $row['z'] .'}'?>})">Редактировать</button>
	</td>
</tr>