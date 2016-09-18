<html>
<head>
    <title>%title%</title>
    <meta charset="utf-8">
    <meta name="description" content="%meta_desc%" />
    <meta name="keywords" content="%meta_key%" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="%address%favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="%address%favicon.ico" type="image/x-icon">
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
    <script src="//api-maps.yandex.ru/2.0/?lang=ru-RU&load=package.full" type="text/javascript"></script>
    <script src="../js/search_address.js" type="text/javascript"></script>
    <script src="../gallery/js/lightgallery.min.js"></script>
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="../gallery/css/lightgallery.css" />
    <link rel="stylesheet" href="../css/main.css" type="text/css">
</head>
<body>

<style type="text/css">

    #YMapsID {
        width: 100%;
        height: 400px;
        margin-top: 25px;
        border: 1px solid #ccc;;
    }
</style>
<div class="container" id="main_container">
    <div class="row">
        <div class="col-md-12 header">
            <div id="header-mid">
                <div class="col-md-3">
                    <img src="../images/login-logo.png" class="logo">
                </div>
                <div class="col-md-6 block_contact">
                    <i class="fa fa-mobile fa-2x" style="float: left;"></i><p class="contact">+7 987 654 32 10</p>
                    <i class="fa fa-home fa-2x" style="float: left;"></i><p class="contact">г. Волжский, б-р Профсоюзов, 1б, офис 220</p>
                </div>
                <div class="col-md-3">
                    <div class="block_hello block_content">
                        <p class="block_title">Личный кабинет</p>
                        <a class="block_register">Регистрация</a>
                        <a class="nl_btn_green enter">Вход</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="menu"></div>
        </div>
    </div>
    %top%
    %middle%
    %bottom%
    </div>
<div class="container" id="footer">
    <div class="row">
        <div class="col-md-4">
            <div class="block_obj_comfort_title">Специальное предложение</div>
        </div>
        <div class="col-md-4">
            <div class="block_obj_comfort_title">Последнии новости</div>
        </div>
        <div class="col-md-4">
            <div class="block_obj_comfort_title">Контакты</div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        $("#lightgallery").lightGallery();
    });
</script>
<!-- lightgallery plugins -->
<script src="../gallery/js/lg-thumbnail.min.js"></script>
<script src="../gallery/js/lg-fullscreen.min.js"></script>
</body>
</html>