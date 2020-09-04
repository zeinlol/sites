<div class="contentBoxTopicList treeBox searchBox">
  <ol>
    <li class="treeItem">
      <dl class="ListParam">
        <dt>Ключевые слова:</dt>
        <dd>
          <input autocomplete="off" type="text" class="forum_input" maxlength="200" size="50" value="{keyValue}" name="query">
        </dd>
        <dd class="margLeft">
          <label for="search_titl">
            <input type="checkbox" {keyOnliTitle} value="1" id="search_titl" name="search_titl">
            Искать только в заголовках тем</label>
        </dd>
      </dl>
      <dl class="ListParam">
        <dt>Сообщения пользователя:</dt>
        <dd>
          <input type="text" autocomplete="off" class="forum_input" maxlength="200" size="50" value="{keyUser}" name="user">
        </dd>
        <dd class="margLeft">Имена участников (разделяйте запятой)</dd>
      </dl>
      <dl class="ListParam">
        <dt>Поиск по дате:</dt>
        <dd>
          <input id="datepicker_o" autocomplete="off" style="width:162px" type="text" class="forum_input" maxlength="200" size="50" value="{keyDate}" name="date">
          -
          <input id="datepicker_e" autocomplete="off" style="width:162px" type="text" class="forum_input" maxlength="200" size="50" value="{keyDateOut}" name="date_end">
        </dd>
      </dl>
      <dl class="ListParam">
        <dt>Зона поиска:</dt>
        <dd><select id="treeSelectSearch" name="tree" multiple="multiple" style="min-height:150px">{tree}</select></dd>
      </dl>
      <dl class="ListParam">
        <dt>Критерий сортировки:</dt>
        <dd  class="margLeft" style="margin-top:5px">
          <select name="sort">
             <option {keyRelSort} value="2">Наиболее подходящие</option>
              <option {keyReplySort} value="0">По количеству ответов</option>
            <option {keyDateSort} value="1">По дате создания темы</option>
          
          </select>
        </dd>
      </dl>
      <dl class="ListParam">
        <dt>Расположить результаты:</dt>
        <dd  class="margLeft" style="margin-top:3px">
          <select name="order">
            <option {sortDesc} value="0">По убыванию</option>
            <option {sortAsc} value="1">По возрастанию</option>
          </select>
        </dd>
      </dl>
      <dl class="ListParam">
        <dd>
          <div style="margin:5px 0 5px 170px">
            <button class="b01" value="new_search" type="submit" name="search">Поиск</button>
          </div>
        </dd>
      </dl>
    </li>
  </ol>
</div>
