<div id="create_obj">
    <form class="obj_form" name="add_adm_mess" action="functions.php" method="post">
        <ul id="obj_ul">
            <li>
                <h2>Добавление нового сообщения</h2>
                <span class="required_notification">* Обязательные поля</span>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="title">
                            <label for="title">Заголовок</label>
                            <input size="40" name="title" id="title" type="text" required/>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="mess">
                            <label for="desc">Содержимое сообщения</label>
                            <textarea name="desc" id="editor1" rows="10" cols="80">

            </textarea>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'editor1' );
                            </script>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="short_desc">
                            <label for="short_desc">Кратное описание</label>
                            <textarea style="width: 100%" name="short_desc" id="short_desc" rows="5" cols="80"></textarea>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                        <label for="type">Тип сообщения</label>
                        <select name="type" class="easydropdown">
                            <option value="normal">Обычное</option>
                            <option value="attention">Важное</option>
                            <option value="ok">Успешное</option>
                            <option value="warning">Внимание</option>
                        </select>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="submit">
                    <input class="submit" type="submit" name="create_adm_message" value="Добавить">
                </div>
            </li>
        </ul>
    </form>
</div>