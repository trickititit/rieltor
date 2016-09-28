<div id="create_obj">
    <form class="obj_form" name="create_obj" action="functions.php" method="post">
        %message%
        <ul id="obj_ul">
            <li>
                <h2>Добавление нового обьекта</h2>
                <span class="required_notification">* Обязательные поля</span>
            </li>
            <li>
        <div class="row">
            <div class="col-md-12">
                <div id="type_">
                    <label for="obj_type">Вид Недвижимости</label><span class="obz">*</span>
                    <select name="obj_type" class="easydropdown"required>
                        <option value="1">Квартира</option>
                        <option value="2">Дом, Дача, Таунхаус</option>
                        <option value="3">Комната</option>
                    </select>
                </div>
                <div id="deal">
                    <label for="obj_deal">Вид сделки</label><span class="obz">*</span>
                    <select name="obj_deal" class="easydropdown" required>
                        <option value="Продажа">Продажа</option>
                        <option selected value="Обмен">Обмен</option>
                    </select>
                </div>
                <div id="form">
                    <div id="obj_form_1">
                    <label for="obj_form_1">Тип обьекта</label><span class="obz">*</span>
                    <select name="obj_form_1" class="easydropdown" >
                        <option value="Вторичка">Вторичка</option>
                        <option value="Новостройка">Новостройка</option>
                    </select>
                    </div>
                    <div id="obj_form_2" hidden>
                        <label for="obj_form_2">Тип обьекта</label><span class="obz">*</span>
                        <select name="obj_form_2" class="easydropdown">
                            <option value="Дом">Дом</option>
                            <option value="Дача">Дача</option>
                            <option value="Коттедж">Коттедж</option>
                            <option value="Таунхаус">Таунхаус</option>
                        </select>
                    </div>
                    <div id="obj_form_3" hidden>
                        <label for="obj_form_3">Тип обьекта</label><span class="obz">*</span>
                        <select name="obj_form_3" class="easydropdown">
                            <option value="Гостиничного">Гостиничного</option>
                            <option value="Коридорного">Коридорного</option>
                            <option value="Секционного">Секционного</option>
                            <option value="Коммунальная">Коммунальная</option>
                        </select>
                    </div>
                </div>
                <div id="city_">
                    <label for="obj_city">Город</label><span class="obz">*</span>
                    <select name="obj_city" class="easydropdown" required>
                        <option value="Волгоград">Волгоград</option>
                        <option selected value="Волжский">Волжский</option>
                    </select>
                </div>
                <div id="area">
                    <div id="obj_area_1" hidden>
                    <label for="obj_area_1">Район города</label><span class="obz">*</span>
                    <select name="obj_area_1" class="easydropdown bottom">
                        <option value="Кировский">Кировский</option>
                        <option value="Ворошиловский">Ворошиловский</option>
                        <option value="Центральный">Центральный</option>
                        <option value="Дзержинский">Дзержинский</option>
                        <option value="Красноармейский">Красноармейский</option>
                        <option value="Краснооктябрьский">Краснооктябрьский</option>
                        <option value="Советский">Советский</option>
                        <option value="Тракторозаводский">Тракторозаводский</option>
                    </select>
                    </div>
                    <div id="obj_area_2">
                        <label for="obj_area_2">Район города</label><span class="obz">*</span>
                        <select name="obj_area_2" class="easydropdown" >
                            <option value="Квартал 1">Квартал 1</option>
                            <option value="Квартал 1а">Квартал 1а</option>
                            <option value="Квартал 2">Квартал 2</option>
                            <option value="Квартал 2а">Квартал 2а</option>
                            <option value="Квартал 3">Квартал 3</option>
                            <option value="Квартал 4">Квартал 4</option>
                            <option value="Квартал 5">Квартал 5</option>
                            <option value="Квартал 6">Квартал 6</option>
                            <option value="Квартал 7">Квартал 7</option>
                            <option value="Квартал 8">Квартал 8</option>
                            <option value="Квартал 9">Квартал 9</option>
                            <option value="Квартал 10">Квартал 10</option>
                            <option value="Квартал 11">Квартал 11</option>
                            <option value="Квартал 12">Квартал 12</option>
                            <option value="Квартал 13">Квартал 13</option>
                            <option value="Квартал 14">Квартал 14</option>
                            <option value="Квартал 15">Квартал 15</option>
                            <option value="Квартал 16">Квартал 16</option>
                            <option value="Квартал 17">Квартал 17</option>
                            <option value="Квартал 18">Квартал 18</option>
                            <option value="Квартал 19">Квартал 19</option>
                            <option value="Квартал 20">Квартал 20</option>
                            <option value="Квартал 21">Квартал 21</option>
                            <option value="Квартал 22">Квартал 22</option>
                            <option value="Квартал 23">Квартал 23</option>
                            <option value="Квартал 24">Квартал 24</option>
                            <option value="Квартал 25">Квартал 25</option>
                            <option value="Квартал 26">Квартал 26</option>
                            <option value="Квартал 27">Квартал 27</option>
                            <option value="Квартал 28">Квартал 28</option>
                            <option value="Квартал 29">Квартал 29</option>
                            <option value="Квартал 30">Квартал 30</option>
                            <option value="Квартал 31">Квартал 31</option>
                            <option value="Квартал 32">Квартал 32</option>
                            <option value="Квартал 33">Квартал 33</option>
                            <option value="Квартал 34">Квартал 34</option>
                            <option value="Квартал 35">Квартал 35</option>
                            <option value="Квартал 36">Квартал 36</option>
                            <option value="Квартал 37">Квартал 37</option>
                            <option value="Квартал 38">Квартал 38</option>
                            <option value="Квартал 39">Квартал 39</option>
                            <option value="Квартал 40">Квартал 40</option>
                            <option value="Квартал 41">Квартал 41</option>
                            <option value="Квартал 42">Квартал 42</option>
                            <option value="Квартал 100">Квартал 100</option>
                            <option value="Квартал 101">Квартал 101</option>
                            <option value="Квартал 102">Квартал 102</option>
                            <option value="Квартал А">Квартал А</option>
                            <option value="Квартал Б">Квартал Б</option>
                            <option value="Квартал В">Квартал В</option>
                            <option value="Квартал Г">Квартал Г</option>
                            <option value="Квартал Д">Квартал Д</option>
                            <option value="Квартал Е">Квартал Е</option>
                            <option value="1 микрорайон">1 микрорайон</option>
                            <option value="2 микрорайон">2 микрорайон</option>
                            <option value="3 микрорайон">3 микрорайон</option>
                            <option value="4 микрорайон">4 микрорайон</option>
                            <option value="5 микрорайон">5 микрорайон</option>
                            <option value="6 микрорайон">6 микрорайон</option>
                            <option value="7 микрорайон">7 микрорайон</option>
                            <option value="8 микрорайон">8 микрорайон</option>
                            <option value="9 микрорайон">9 микрорайон</option>
                            <option value="10 микрорайон">10 микрорайон</option>
                            <option value="10/16 микрорайон">10/16 микрорайон</option>
                            <option value="11 микрорайон">11 микрорайон</option>
                            <option value="12 микрорайон">12 микрорайон</option>
                            <option value="13 микрорайон">13 микрорайон</option>
                            <option value="14 микрорайон">14 микрорайон</option>
                            <option value="15 микрорайон">15 микрорайон</option>
                            <option value="16 микрорайон">16 микрорайон</option>
                            <option value="17 микрорайон">17 микрорайон</option>
                            <option value="18 микрорайон">18 микрорайон</option>
                            <option value="19 микрорайон">19 микрорайон</option>
                            <option value="20 микрорайон">20 микрорайон</option>
                            <option value="21 микрорайон">21 микрорайон</option>
                            <option value="22 микрорайон">22 микрорайон</option>
                            <option value="23 микрорайон">23 микрорайон</option>
                            <option value="24 микрорайон">24 микрорайон</option>
                            <option value="25 микрорайон">25 микрорайон</option>
                            <option value="26 микрорайон">26 микрорайон</option>
                            <option value="27 микрорайон">27 микрорайон</option>
                            <option value="28 микрорайон">28 микрорайон</option>
                            <option value="29 микрорайон">29 микрорайон</option>
                            <option value="30 микрорайон">30 микрорайон</option>
                            <option value="31 микрорайон">31 микрорайон</option>
                            <option value="32 микрорайон">32 микрорайон</option>
                            <option value="33 микрорайон">33 микрорайон</option>
                            <option value="34 микрорайон">34 микрорайон</option>
                            <option value="35 микрорайон">35 микрорайон</option>
                            <option value="36 микрорайон">36 микрорайон</option>
                            <option value="37 микрорайон">37 микрорайон</option>
                            <option value="38 микрорайон">38 микрорайон</option>
                            <option value="Металлург">Металлург</option>
                            <option value="Металлург-1">Металлург-1</option>
                            <option value="Металлург-2">Металлург-2</option>
                            <option value="ЛПК">ЛПК</option>
                            <option value="Второй поселок">Второй поселок</option>
                            <option value="Станция трубная">Станция трубная</option>
                            <option value="Паромный">Паромный</option>
                            <option value="Тещино">Тещино</option>
                            <option value="Погромное">Погромное</option>
                            <option value="Зеленый">Зеленый</option>
                            <option value="Уральский">Уральский</option>
                            <option value="Краснооктябрьский">Краснооктябрьский</option>
                            <option value="Рабочий">Рабочий</option>
                            <option value="Средняя Ахтуба">Средняя Ахтуба</option>
                            <option value="Южный">Южный</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
            </li>
            <li>
        <div class="row">
            <div class="col-md-12">
                <div class="hero-unit">
                    <div class="container-fluid">
                        <div class="row-fluid">

                        </div>
                        <div class="row-fluid">
                            <div id="adr-search" class="form-search">
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-append">
                                            <input type="text" class="input-xlarge search-query" placeholder="Введите улицу" data-provide="typeahead">
                                            <button type="submit" id="search-map" class="btn">Найти</button>
                                        </div>
                                        <span class="help-inline invisible">Пожалуйста исправьте ошибку в этом поле</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div id="YMapsID" class="span8"></div>
                        </div>
                    </div>
                </div>
                <input name="obj_geo" id="obj_geo" type="text" readonly hidden/>
                <div id="address">
                    <label for="obj_address">Адрес</label>
                    <input name="obj_address" size="40" id="obj_address" type="text"/>
                </div>
            </div>
        </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Button trigger modal -->
                        <button id="mod" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Загрузить изображения
                        </button>
                </div>
            </div>
            </li>
            <li>
        <div class="row">
            <div class="col-md-12">
                <div id="room">
                    <label for="obj_room">Количество комнат</label><span class="obz">*</span>
                    <select name="obj_room" class="easydropdown">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="9+">9+</option>
                    </select>
                </div>
                <div id="home_floors_2" hidden>
                    <label for="obj_home_floors_2">Этажей в доме</label><span class="obz">*</span>
                    <select name="obj_home_floors_2" class="easydropdown">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5+</option>
                    </select>
                </div>
                <div id="build_type">
                    <div id="build_type_1">
                    <label for="obj_build_type_1">Тип дома</label><span class="obz">*</span>
                    <select name="obj_build_type_1" class="easydropdown">
                        <option value="Кирпичный">Кирпичный</option>
                        <option value="Панельный">Панельный</option>
                        <option value="Блочный">Блочный</option>
                        <option value="Монолитный">Монолитный</option>
                        <option value="Деревянный">Деревянный</option>
                    </select>
                    </div>
                    <div id="build_type_2" hidden>
                        <label for="obj_build_type_2">Материал стен</label><span class="obz">*</span>
                        <select name="obj_build_type_2" class="easydropdown">
                            <option value="Кирпич">Кирпич</option>
                            <option value="Брус">Брус</option>
                            <option value="Бревно">Бревно</option>
                            <option value="Металл">Металл</option>
                            <option value="Пеноблоки">Пеноблоки</option>
                            <option value="Сендвич-панели">Сендвич-панели</option>
                            <option value="Ж/б панели">Ж/б панели</option>
                            <option value="Экспериментальные материалы">Экспериментальные материалы</option>
                        </select>
                    </div>
                </div>
                <div id="floor">
                    <label for="obj_floor">Этаж</label><span class="obz">*</span>
                    <select name="obj_floor" class="easydropdown">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div id="distance" hidden>
                    <label for="obj_distance">Расстояние до города</label><span class="obz">*</span>
                    <select name="obj_distance" class="easydropdown">
                        <option value="0">В черте города</option>
                        <option value="10">10 км</option>
                        <option value="20">20 км</option>
                        <option value="30">30 км</option>
                        <option value="50">50 км</option>
                        <option value="70+">70+ км</option>
                    </select>
                </div>
                <div id="home_floors_1">
                    <label for="obj_home_floors_1">Этажей в доме</label><span class="obz">*</span>
                    <select name="obj_home_floors_1" class="easydropdown">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
            </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                <div id="square">
                    <label for="obj_square">Площадь в м²</label>
                    <input size="40" name="obj_square" type="text"/>
                </div>
                        <div id="house_square" hidden>
                            <label for="obj_house_square">Площадь дома в м²</label>
                            <input size="40" name="obj_house_square" type="text"/>
                        </div>
                        <div id="earth_square" hidden>
                            <label for="obj_earth_square">Площадь участка в сот.</label>
                            <input size="40" name="obj_earth_square" type="text"/>
                        </div>
            </div>
        </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-md-12">
                        <p><b>Удобства</b></p>
                        <div id="comforts">
                            %comforts%
                        </div>
                    </div>
                </div>
            </li>
            <li>
        <div class="row">
            <div class="col-md-12">
                <div id="desc">
                    <label for="obj_desc">Описание объявления</label>
                    <textarea cols="40" rows="6" name="obj_desc"></textarea>
                </div>
                <div id="comment">
                    <label for="obj_comment">Комментарий</label>
                    <textarea cols="40" rows="3" name="obj_comment"></textarea>
                </div>
            </div>
        </div>
             </li>
            <li>
        <div class="row">
            <div class="col-md-12">
                <div id="price_square">
                    <label for="obj_price_square">Цена за м²</label>
                    <input size="40" name="obj_price_square" type="text" readonly/>
                </div>
                <div id="price" >
                    <label for="obj_price">Цена в руб.</label>
                    <input size="40" name="obj_price" type="text"  required/>
                </div>
                <div id="doplata">
                    <label for="obj_doplata">Доплата в руб.</label>
                    <input size="40" name="obj_doplata" type="text"  required/>
                </div>
            </div>
        </div>
            </li>
            <li>
        <div class="row">
            <div class="col-md-12">
                <div id="client_contact">
                    <label for="obj_client_contact">Контакты владельца</label>
                    <input size="40" name="obj_client_contact" type="text" required/>
                </div>
            </div>
        </div>
            </li>

        <li>
        <div class="submit">
            <input class="submit" type="submit" name="create" value="Создать">
        </div>
            </li>
        </ul>
        <input id="obj_id" name="obj_id" type="text" hidden >
    </form>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Загрузка изображений</h4>
                </div>
                <div class="modal-body">
                    <form action="upload.php" class="dropzone" id="my-dropzone">
                        <input id="obj-id" name="objid" type="text" hidden >
                        <input id="tmp-img" name="tmp-img" type="text" hidden >
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    %script%
</script>

<script>
    Dropzone.options.myDropzone = {
        acceptedFiles: "image/*",
        maxFilesize: 100,
        addRemoveLinks: true,
        maxFiles: 20,
        removedfile: function(file) {
            var id = $('#obj-id').val();
            var name = file.name;
            var tmp_img = $('#tmp-img').val();
            $.ajax({
                type: 'POST',
                url: 'delete.php',
                data: "file="+name+"&objid="+id+"&tmp-img="+tmp_img,
                dataType: 'html'
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        init: function () {
            thisDropzone = this;
            <!-- 4 -->
            $.get('upload.php', function (data) {

                <!-- 5 -->
                $.each(data, function (index, item) {
                    //// Create the mock file:
                    var mockFile = {
                        name: item.name,
                        size: item.size,
                        status: Dropzone.ADDED,
                        accepted: true
                    };

                    // Call the default addedfile event handler
                    thisDropzone.emit("addedfile", mockFile);

                    // And optionally show the thumbnail of the file:
                    //thisDropzone.emit("thumbnail", mockFile, "uploads/"+item.name);

                    thisDropzone.createThumbnailFromUrl(mockFile, "uploads/"+"%obj_id%/"+item.name);

                    thisDropzone.emit("complete", mockFile);

                    thisDropzone.files.push(mockFile);

                });

            });
        }
    };

    ymaps.ready(function () {
        var myMap = window.map = new ymaps.Map('YMapsID', {
                    center: [48.7979,44.7462],
                    zoom: 16,
                    behaviors: ['default']
                }),
                searchControl = new SearchAddress(myMap, $('form'));
        myMap.controls.add(
                new ymaps.control.ZoomControl()
        );
        myMap.controls.add('typeSelector')
    });
</script>
<style type="text/css">
    #YMapsID {
        width: 900px;
        height: 400px;
    }
</style>
