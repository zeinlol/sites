[infoBox]
<div class="treeTitl infoBox">
	<div class="infoIcon"><span class="icon-megaphone"></span></div>
	<div class="inertBox">
		<p>{infoTitl}</p>
		<div class="treeDesc">{infoText}</div>
	</div>
</div>
[/infoBox]
<h3 class="treeNameList">{treeName}</h3>
<div id="desTtee">{treeDescription}{treeOption}{treeRss}</div>
<div class="contentBoxTopicList">
  <ol class="listTopicBlock" id="contentBoxAppendTo">
    {listTopic}
  </ol>
</div>
<div class="paginationForum_block">
{optionList}{navigation}
<div style="clear:right;"></div>
</div>
<!--IMPORTANT listTopicBlock, class span sortXXX-->
<script language="javascript" type="text/javascript">
function MenuBuild(m_id) {
  var menu = new Array()
  menu[0] = '<a onclick="topicConfigure(\'clozed\'); return false;" href="#"><div class="option-menu">Закрыть темы</div></a>';
  menu[1] = '<a onclick="topicConfigure(\'open\'); return false;" href="#"><div class="option-menu">Открыть темы</div></a>';
  menu[2] = '<a onclick="topicConfigure(\'pin\'); return false;" href="#"><div class="option-menu">Прикрепить темы</div></a>';
  menu[3] = '<a onclick="topicConfigure(\'unpin\'); return false;" href="#"><div class="option-menu">Открепить темы</div></a>';
  menu[4] = '<a onclick="topicConfigure(\'move\'); return false;" href="#"><div class="option-menu">Переместить темы</div></a>';
  menu[5] = '<a onclick="topicConfigure(\'merge\'); return false;" href="#"><div class="option-menu">Объединить темы</div></a>';  
  menu[6] = '<a onclick="topicConfigure(\'delete\'); return false;" href="#"><div class="option-menu">Удалить темы</div></a>';  
  return menu;
}
</script>