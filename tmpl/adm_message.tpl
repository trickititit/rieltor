<h1>Сообщения</h1>
<div class="row">
<div class="col-md-8 col-md-offset-2 clearfix">
<ul id="message_ul">
    %adm_messages%
</ul>
</div>
</div>
<br />
<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Добавить новое
</button>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить новое сообщение</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="functions.php">
                    <div class="form-group">
                        <label for="title">Заголовок</label>
                        <input type="text" class="form-control" id="title" placeholder="Введите Заголовок" name="title">
                    </div>
                    <div class="form-group">
                        <label for="desc">Сообщение</label>
                        <textarea class="form-control" placeholder="Введите текст сообщения" cols="40" rows="3" name="desc"></textarea>
                    </div>
            <textarea name="editor1" id="editor1" rows="10" cols="80">
                This is my textarea to be replaced with CKEditor.
            </textarea>
                        <script>
                            // Replace the <textarea id="editor1"> with a CKEditor
                            // instance, using default configuration.
                            CKEDITOR.replace( 'editor1' );
                        </script>

                    <div class="form-group">
                        <label for="type">Тип сообщения</label>
                        <select name="type" class="form-control">
                            <option value="normal">Обычное</option>
                            <option value="attention">Важное</option>
                            <option value="ok">Успешное</option>
                            <option value="warning">Внимание</option>
                        </select>
                    </div>
                    <input name="create_adm_message" type="submit" class="btn btn-success" value="Добавить">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
</div>