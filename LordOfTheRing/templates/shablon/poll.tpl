<div class="block">
		<div class="block-head">{question}</div>
		<div class="block-body">{list}
		<br />
		[voted]<div align="center">Всего проголосовало: {votes}</div>[/voted]
		[not-voted]
		<div align="center">
			<button class="fbutton" type="submit" onclick="doPoll('vote'); return false;" ><span>Голосовать</span></button>
			<button class="fbutton" type="submit" onclick="doPoll('results'); return false;"><span>Результаты</span></button>
		</div>
		[/not-voted]
		</div>
</div>