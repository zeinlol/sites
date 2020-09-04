<link rel="stylesheet" href="{THEME}/css/register.css" />
<script type="text/javascript" src="{THEME}/js/rega.js"></script>
[registration]
<div id="reg_main">
    <div id="reg_left_side">
        <div id="reg_container">
            <hgroup>
                <h3 style="margin: 0">Приветствуем вас на нашем сайте!</h3><br>
                <p style="margin: 0">Пожалуйста, укажите данные для авторизации</p>
            </hgroup>
            <article id="article">
                <reg_form class="reg_form">
                    <fieldset>
                        <h4>
                            <!--<span>1</span>-->Данные вашего аккаунта:</h4>

                        <div class="row">
                            <div class="item">
                                <label for="Username">Логин:<em>*</em></label>
                                <input type="text" name="name" id="name" onblur="check_login(this); return false;" />
                                <div id="result-registration"></div>
                                <p class="hint">Логин не должен содержать спец. символы</p>
                            </div>
                            <div class="item last">
                                <label for="Email">E-mail адрес:<em>*</em></label>
                                <input type="text" name="email" onblur="check_mail(this)" />
                                <div id="result-mail"></div>
                                <p class="hint">
                                    <!--Требуется для подтверждения аккаунта-->
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="item">
                                <label for="Password">Пароль:<em>*</em></label>
                                <input type="password" name="password1" id="password1" onblur="check_first( this )" />
                                <div id="result-first"></div>
                                <p class="hint">Не менее 6 символов</p>
                            </div>
                            <div class="item last">
                                <label for="Password2">Повторите пароль:<em>*</em></label>
                                <input type="password" name="password2" id="password2" onblur="check_password()" />
                                <div id="result-pass"></div>
                            </div>
                        </div>
                    </fieldset>
                    <!--<fieldset>	
				[question]
					<div class="row">
						<div class="item">
					<label for="question">Вопрос:<em>*</em></label>
					{question}
						</div>
						<div class="item last">
					<label for="answer">Ответ:<em>*</em></label>
					<input type="text" name="question_answer" value="" />
						</div>
					</div>
				[/question]
			</fieldset>-->
                    <fieldset>
                        [sec_code]
                        <label for="answer">Введите код с картинки:<em>*</em></label>
                        <div>{reg_code}</div>
                        <div><input type="text" name="sec_code" style="width:115px; margin-top: 10px" class="f_input" /></div>
                        [/sec_code]

                        [recaptcha]
                        Введите два слова, показанных на изображении:<span class="impot">*</span>
                        <div>{recaptcha}</div>
                        [/recaptcha]
                        <div class="submit">
                            <input type="submit" value="Зарегистрироваться" />
                        </div>
                    </fieldset>
                </reg_form>
            </article>
        </div>
    </div>


    <!-- <aside>
			<h5>Why sign up?</h5>
			<div class="item">
				<h6>It`s free and easy</h6>
				<p>Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentes.</p>
			</div>
			<div class="item">
				<h6>No Credit Card required</h6>
				<p>Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentes.</p>
			</div>
			<div class="item">
				<h6>Professional support</h6>
				<p>Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentes.</p>
			</div>
			<div class="item">
				<h6>Interesting content</h6>
				<p>Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentes.</p>
			</div>
</aside> -->

</div>
[/registration]


[validation]
<div id="main">
    <div id="left_side">
        <div id="reg_main">
            <hgroup>
                <h2 style="margin: 0">Завершение регистрации</h2><br>
                <h3 style="margin: 0">Укажите дополнительные данные:</h3>
            </hgroup>

            <article id="article">
                <reg_form class="reg_form">
                    <fieldset>
                        <h4>
                            <!--<span>2</span>-->Личные данные:</h4>
                        <div class="row">
                            <div class="item">
                                <label for="FirstName">Имя:</label>
                                <input type="text" name="fullname" id="fullname" value="" />
                            </div>
                            <!--<div class="item last">
									<label for="LastName">Фамилия:</label>
									<input type="text" name="xfield[last_name]" id="xfield[last_name]" value="" />
								</div>-->
                        </div>

                        <div class="row">
                            <div class="item">
                                <label for="City">Город:</label>
                                <input type="text" name="land" value="" />
                            </div>
                            <!--<div class="item last">
									<label for="Country">Страна:</label>
									<select name="xfield[country]" id="xfield[country]">
										<option>Беларусь</option>
										<option>Россия</option>
										<option>Украина</option>
										<option>Другие страны СНГ</option>
										<option>Страны Европы</option>
										<option>Страна не твоих собачьих дел</option>
										<option>Другие</option>
									</select>
								</div>-->
                        </div>

                        <!--<div class="row">
								<div class="item">
									<label for="icq">ВК ID:</label>
									<input type="text" name="icq" value="" />
								</div>
							</div>-->
                    </fieldset>

                    <fieldset>
                        <h4>
                            <!--<span>3</span>-->Несколько слов о себе:</h4>
                        <div class="row">
                            <textarea name="info"></textarea>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="submit">
                            <input type="submit" style="align-content: center" value="Завершить" />
                        </div>
                    </fieldset>
                </reg_form>
            </article>
        </div>
    </div>
</div>
<!--{xfields} -->
[/validation]
