
<div class="lk-status" id="lk-status-<?php echo $i?>">
	Статус <i><?php echo $this->tpl['status_info']['name']?></i>
	<?php if ( $i ) { ?><button onclick="lk.selStatus(<?php echo $i?>)" style="float: right; position: relative; bottom: 7px;" class="lk-button-1">Купить</button><?php } ?>
	
	<?php $a = $this->tpl['status_info']['price'] . ' ' . $this->getNameCur($this->tpl['status_info']['price']) ?>
</div>