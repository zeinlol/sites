<li class="topicList {status}" id="topic_item-{id}">
  <div class="boxTopic avatarMini"><span class="treeIcon" title="{statusTitl}"></span></div>
  <div class="boxTopic topicInfo">
    <h3>{unreadLinck}{uniqueStatusTopic}[linck]{title}[/linck]</h3>{pageList}
    <div class="icon">{icon}</div>
    <div class="topicPublicInfo">Создано {topicPostDate}</div>
    <div class="topicControl">{edit}</div>
  </div>
  <div class="boxTopic statistic">
    <p>{replyCount} <strong>Ответов</strong></p>
    <p>{viewCount} <strong>Просмотров</strong></p>
  </div>
  [LastMessage]
  <div class="boxTopic topicLastPost">
    [popupUserCard]<img class="userPost_avatar" src="/engine/modules/avatar.php?s=32&u={lastAutorName}" alt=""/>[/popupUserCard] 
    <p>{lastAutorName}</p>
    <p title="Перейти к последнему сообщению"><strong>[lastMessageLinck]{lastMessageDate}[/lastMessageLinck]</strong></p>
  </div>
  [/LastMessage]
</li>