<div id="create_obj">
    <form class="obj_form" name="edit_adm_mess" action="functions.php" method="post">
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
                            <input size="40" name="title" id="title" value="%title%" type="text" required/>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <div id="mess">
                            <label for="desc">Содержимое сообщения</label>
                            <textarea name="desc" id="editor1" rows="10" cols="80">%content%</textarea>
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
                            <textarea style="width: 100%" name="short_desc" id="short_desc" rows="5" cols="80">%short_content%</textarea>
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
                                %type%
                            </select>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="submit">
                    <input name="id" value="%id%" hidden>
                    <input class="submit" type="submit" name="edit_adm_message" value="Редактировать">
                </div>
            </li>
        </ul>
    </form>
</div>