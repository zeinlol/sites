<li class="treeItem {status}">
  <div class="boxTreeItem"><span id="treeId_{treeId}" class="treeIcon" title="{statusTitl}"></span>
    <div class="treeInfoBox">
	  <div class="categoryInfo">
	     <strong>{topic}</strong> Тем<br/>
         <strong>{message}</strong> Сообщений 
	  </div>
      <h4>[linckTree]{nameTree}[/linckTree]</h4>
      [blockInfo]
      <div class="countBox">
		{description}{TreeChild}{rssTree}
      </div>
      [/blockInfo]
      [LastMessage]
	  <div class="replyAvatar_block">
	  		<div class="replyAvatar"><img src="/engine/modules/avatar.php?s=32&u={lastAutorName}" alt=""/></div></div>
      <div class="replyLast">
        <p title="Перейти к последнему сообщению">Последнее: <a href="{lastTopicLinck}">{lastTopicName} </a></p>
        <p><a class="autor_post" href="/user/{lastAutorName}">{lastAutorName}</a>, <i>{lastMessageDate}</i></p>
      </div>
      [/LastMessage]</div>
  </div>
</li>