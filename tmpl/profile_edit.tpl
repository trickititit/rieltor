<div id="edit_obj">
    <form class="obj_form" name="edit_profile" action="functions.php" method="post">
        <ul id="obj_ul">
            <li>
                <h2>Редактирование польвозателя</h2>
                <span class="required_notification">* Обязательные поля</span>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="login">
                            <label for="edit_login">Логин</label>
                            <input size="40" name="edit_login" id="reg_login" type="text" readonly/>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="password">
                            <label for="edit_password">Новый пароль</label>
                            <input size="40" name="edit_password" id="reg_password" type="password"/>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="name">
                            <label for="edit_name">Имя</label>
                            <input size="40" name="edit_name" id="reg_name" type="text" required/>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="email">
                            <label for="edit_email">Email</label>
                            <input size="40" name="edit_email" id="reg_email" type="text" required/>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="contact">
                            <label for="edit_contact">Контактный</label>
                            <input size="40" name="edit_contact" id="edit_contact" type="text" required/>
                        </div>
                    </div>
                </div>
            </li>
            %submit%
        </ul>
    </form>
</div>
<script type="text/javascript">
    %script%
</script>