
<?php if ( $this->isHaveRight($this->tpl['info'][1]) ) { ?>
	
	<div class="lk-right lk-right_on">Вы можете <?php echo $this->tpl['info'][0]?></div>
	
<?php } else { ?>
	
	<div>
		<div class="lk-right lk-right_on" style="display: none">Вы можете <?php echo $this->tpl['info'][0]?></div>
		<div class="lk-right lk-right_off">Вы <b>не</b> можете <?php echo $this->tpl['info'][0]?>. <a onclick="lk.buyRight(<?php echo $i?>)">Купить</a> за <?php echo '<b>' . $this->tpl['info'][3] . '</b> ' . $this->cfg['cur'][1]?>.</div>
	</div>
	
<?php } ?>