<h1>Удобства</h1>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Название</th>
        <th>Описание</th>
        <th>Ярлык</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody>
    %comforts%
    </tbody>
</table>
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
                <h4 class="modal-title" id="myModalLabel">Добавить новое удобство</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="functions.php">
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="title" placeholder="Введите название" name="title">
                    </div>
                    <div class="form-group">
                        <label for="desc">Описание</label>
                        <input type="text" class="form-control" id="desc" placeholder="Введите описание" name="desc">
                    </div>
                    <div class="form-group">
                        <label for="_label">Ярлык</label>
                        <input type="text" class="form-control" id="_label" placeholder="Введите название ярлыка" name="label">
                    </div>
                    <input name="create_comfort" type="submit" class="btn btn-success" value="Добавить">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
</div>