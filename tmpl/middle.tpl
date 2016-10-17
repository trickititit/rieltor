<div class="table-responsive">
<table class="table table-hover">
    <thead>
    <tr>
        <th>Фото</th>
        <th>Вид сделки</th>
        <th>Обьект</th>
        <th>Адрес</th>
        <th>Цена</th>
        <th>Описание</th>
        <th>Доплата</th>
        <th>Комментарий</th>
        <th>Контакты</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    %post_table%
    </tbody>
</table>
</div>
<script>
    $(document).ready(function() {
        $('.table tr').hover(function () {
            $(this).find('.tab_content').stop(true).animate({ height: "200px"}, 300)
        },
                function () {
                    $(this).find('.tab_content').stop(true).animate({ height: "58px"}, 300)
                })

    });
</script>
