<li class="msg" id="message-{messageId}">
  <div class="msgAutorInfo">
    <div class="boxInert">
	<div class="message_avatar">
	<img src="/engine/modules/avatar.php?s=80&u={autorName}" alt=""/>
	[online]<div class="message_user_online">Онлайн</div>[/online]
	[offline]<div class="message_user_offline">Не в сети</div>[/offline]	
	</div>
      <div class="autorInfo">
        <p>[profile]{autorName}[/profile]</p>
        [titleUser]
        <p>Звание: {titleUser}</p>
        [/titleUser]
        <p>{userGroup}</p>
        <p class="msgUserCount">Сообщений: {forumPostNum}</p>
        [isUserTrophies]
        <p class="trophiesCount">Трофеев: [userTrophies]{countTrophies}[/userTrophies]</p>
        [/isUserTrophies]
	  </div>
    </div>
  </div>
  <div class="msgText">{messageText}</div>
  
  <div class="msgInfoBlock">
  <div class="msgInfo"><div class="clr"></div>
    <div>{moderatorOptionInput}{messageDate} / {messageLinck} </div>
  </div>
  [not-group=5] 
  <div class="controlMsgBox msgIControl">
    [deleteMsg]Удалить[/deleteMsg] 
    [msgEdit]Редактировать[/msgEdit] 
    [fast]Ответить[/fast]{like} </div>
  [/not-group] 
  </div>
</li>
