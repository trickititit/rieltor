<!DOCTYPE html>
<html>
<head>
    <title>%title%</title>
    <meta charset="utf-8">
    <meta name="description" content="%meta_desc%" />
    <meta name="keywords" content="%meta_key%" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
    <script src="//yandex.st/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
    <!--<script src="%address%js/jquery.js"></script>-->
    <!--<script type="text/javascript" src="%address%js/bootstrap.min.js"></script>-->
    <script src="%address%js/dropzone.js"></script>
    <script src="//yandex.st/bootstrap/2.3.2/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="//api-maps.yandex.ru/2.0/?lang=ru-RU&load=package.full" type="text/javascript"></script>
    <script src="%address%js/search_address.js" type="text/javascript"></script>
    <script type="text/javascript" src="%address%js/jquery-ui.js"></script>
    <script type="text/javascript" src="%address%js/script.js"></script>
    <link rel="stylesheet" href="%address%css/dropzone.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="%address%css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="%address%css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="%address%css/main.css" type="text/css">
    <link rel="stylesheet" href="%address%css/animate.css" type="text/css">
    <!-- MOdal -->
    <script type="text/javascript" src="%address%modal/javascript/jquery.toastmessage.js"></script>
    <link rel="stylesheet" href="%address%modal/resources/css/jquery.toastmessage.css" type="text/css">
    <script src="%address%ckeditor/ckeditor.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="animated fadeIn">
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="../images/default_thumb.png" class="img-circle avatar">
            <a class="user_name" href="#"><span>%username%</span></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right margin_top">
                <li class="active">
                    <a href="#">На сайт</a>
                </li>
                <li>
                    <a href="%address%functions.php?logout=1">Выход</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="contaner-fluid">
    <div class="container" id="main_container">
        <div class="row">
            <div class="col-md-12">
                %nav_menu%
            </div>
        </div>
        %message%
        <div class="row">
            <div class="col-md-12">
                %top%
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                        %adm_menu%
                <!-- Таблица -->
                <div class="tab-content">
                    %middle%
                    %bottom%
                </div>

            </div>
        </div>
</body>
</html>