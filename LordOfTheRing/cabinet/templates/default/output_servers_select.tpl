
<div class="lk-server-select" id="lk-server-select-<?php echo $i?>" onclick="lk.selectServer(this, <?php echo $i?>)">
	<b>Сервер <?php echo $this->tpl['server_info']['name']?></b>
	<span style="float: right; margin-right: 5px;">
		<?php echo '<span>' . $this->tpl['status']['name'] . '</span>' . ($this->tpl['end_time'] ? ' <span style="font-size: 12px">(Закончится ' . date('d.m.Y', $this->tpl['end_time']) . ')</span>' : ' <span style="font-size: 12px"></span>')?>
	</span>
</div>