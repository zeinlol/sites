
<div class="contentBoxTopicList treeBox createTopic"> [rulesText]
  <div class="treeTitl infoBox">
    <div class="inertBox">
      <div class="treeDesc">{rulesText}</div>
    </div>
  </div>
  [/rulesText]
  <ol>
   
    <li class="treeItem">
      <dl class="ListParam">
        <dd>
          <input style="position:relative;margin:0px 0 0px 125px;width:787px;" placeholder="Заголовок создаваемой темы" type="text" class="post_tf" autocomplete="off" maxlength="200" size="50" value="{topicName}" name="topic_name">
        </dd>
      </dl>
      <dl class="ListParam">
        <dd>
          <textarea style="position:relative;margin:0px 0 0px 125px;width:787px;height: 36px;" placeholder="Описание создаваемой темы" class="post_tf" style="height:36px"  name="topic_descr" rows="5" cols="60">{topicDescription}</textarea>
        </dd>
      </dl>
      [vote]
      <dl class="ListParam">
        <dd>
          <input style="position:relative;margin:10px 0 8px 125px!important;" type="checkbox" value="1" id="news_fixed" onclick="blockCase('isvote','vote_block_topic')" name="isvote"> Создание опроса в данной теме
        </dd>
      </dl>
      <dl id="vote_block_topic" style="display:none" class="ListParam">
        <dd>
          <input style="position:relative;margin:0 0 5px 125px;width:787px;" placeholder="Название вашего вопроса" type="text" autocomplete="off" name="vote_titl" value="" size="50" maxlength="200" class="post_tf">
        </dd>
        <dd>
          <input style="position:relative;margin:0px 0 0px 125px;width:787px;" placeholder="Вариант ответа" type="text" autocomplete="off" name="vote_replic[]" value="" size="50" maxlength="100" class="forum_input">
        </dd>
        <dt class="insert_belov">&nbsp;</dt>
        <dd>
          <input onclick="addReplicVote()" type="button" value="Добавить вариант ответа"  class="bbcodes" id="news_fixed" name="vote_multi">
        </dd>
        <dt>&nbsp;</dt>
        <dd>
          <input type="checkbox" value="1" id="news_fixed" name="vote_multi">
          Разрешить выбор нескольких вариантов </dd>
        <dt>&nbsp;</dt>
        <dd>
          <input type="checkbox" value="1" id="news_fixed" name="vote_visible_poll">
          Разрешить видеть, кто как проголосовал </dd>
      </dl>
      [/vote]
      <dl class="ListParam">
        <dt>&nbsp;</dt>
        <dd>
          <div class="topicBoxAdd"> {Bbcode}{Form} </div>
        </dd>
      </dl>
      <dl class="ListParam">
        <dt>&nbsp;</dt>
        <dd id="uploaderSwf" style="position:relative;margin:5px 0 5px 123px">
          <button class="bbcodes" value="create" type="submit" name="add">Создать тему</button>
          <button class="bbcodes" value="preview" type="button" name="rev" onclick="doPreview('topic'); return false;">Предварительный просмотр</button>
		</dd>
        <!--id uploaderSwf important-->
      </dl>
    </li>
  </ol>
</div>
