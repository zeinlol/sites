<li class="msg">
  <div class="msgAutorInfo">
    <div class="boxInert">
      <div class="avatar">[popupUserCard]<img src="{foto}" alt="" />[/popupUserCard]</div>
      [online]<span class="online"><span></span>Онлайн</span>[/online]
      [offline]<span class="offline"><span></span>Оффлайн</span>[/offline]
      <div class="autorInfo">
        <p>[popupUserCard]{autorName}[/popupUserCard]</p>
        [titleUser]
        <p>Звание: {titleUser}</p>
        [/titleUser]
        <p>{userGroup}</p>
        <p class="msgUserCount">Сообщений: {forumPostNum}</p>
        [isUserTrophies]
        <p class="trophiesCount">Трофеев: [userTrophies]{countTrophies}[/userTrophies]</p>
        [/isUserTrophies]
        [isAccessWarning]
        <p>Предупреждений: {countWarning}</p>
        [/isAccessWarning] </div>
    </div>
  </div>
  <div class="msgText">{messageText} 
    [signatureBox]
    <p class="signature">{signature}</p>
    [/signatureBox] </div>
  <div class="msgInfo">
    <div>{messageDate}</div>
  </div>
</li>
