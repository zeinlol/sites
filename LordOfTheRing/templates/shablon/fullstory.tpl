{poll}
<div class="block" style="	margin-bottom: 0px !important;">
		<div class="block-head">{title limit="60"}</div>
		<div class="block-body">
		<div class="img_post">
		<!--[xfvalue_izobrazhenie]-->
		</div>
		<div class="cont_post">
		{full-story}
		</div>
	<div class="post-info">
	Новость опубликованна {date=d F Y}, в {date=H:i} <span>•</span> Оставлено {comments-num} коммент.
	</div></div>
</div>

	[group=5]
	<div class="warn_block">
		Вы не авторизированы на сайте, поэтому не сможете оставить комментарий. Чтобы оставить комментарий и получить полный доступ к возможностям сайта необходимов <a href="/index.php?do=register">зарегистрироваться</a> или войти в свой аккаунт.
	</div>
	[/group]
<div class="block">
	[not-group=5]
	<div class="block-head">
	Написать комментарий
	{addcomments}
	</div>
	[/not-group]
	<div class="block-body">
	{navigation}
	{comments}
	</div>
	</div>
	
