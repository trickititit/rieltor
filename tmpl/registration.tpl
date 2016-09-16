<div id="create_obj">
    <form class="obj_form" name="reg_user" action="functions.php" method="post">
        <ul id="obj_ul">
        <li>
            <h2>Добавление нового польвозателя</h2>
            <span class="required_notification">* Обязательные поля</span>
        </li>
        <li>
            <div class="row">
                <div class="col-md-12">
                    <div id="login">
                        <label for="reg_login">Логин</label>
                        <input size="40" name="reg_login" id="reg_login" type="text" required/>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="row">
                <div class="col-md-12">
                    <div id="password">
                        <label for="reg_password">Пароль</label>
                        <input size="40" name="reg_password" id="reg_password" type="password" required/>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="row">
                <div class="col-md-12">
                    <div id="name">
                        <label for="reg_name">Имя</label>
                        <input size="40" name="reg_name" id="reg_name" type="text" required/>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="row">
                <div class="col-md-12">
                    <div id="email">
                        <label for="reg_email">Email</label>
                        <input size="40" name="reg_email" id="reg_email" type="text" required/>
                    </div>
                </div>
            </div>
        </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="contact">
                            <label for="reg_contact">Контактный</label>
                            <input size="40" name="reg_contact" id="reg_contact" type="text" required/>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="submit">
                    <input class="submit" type="submit" name="reg" value="Зарегистрировать">
                </div>
            </li>
        </ul>
    </form>
</div>