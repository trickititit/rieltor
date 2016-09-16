<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 11.07.2016
 * Time: 11:33
 */



    mb_internal_encoding("UTF-8");
    require_once "lib/config_class.php";
    $config = new Config();
    $address = $config->siteAddress;
?>

<html lang="ru"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <meta name="keywords" content="web magisters курсы веб-дизайн создание сайтов обучение">
    <meta name="description" content="Каталог онлайн-курсов по современным профессиям. Получи профессию самостоятельно и построй карьеру своей мечты.">

    <link href="<?echo $address?>css/build.css" rel="stylesheet">
    <link rel="stylesheet" href="%address%css/animate.css" type="text/css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script>try {  for(var lastpass_iter=0; lastpass_iter < document.forms.length; lastpass_iter++){    var lastpass_f = document.forms[lastpass_iter];    if(typeof(lastpass_f.lpsubmitorig)=="undefined"){      if (typeof(lastpass_f.submit) == "function") {        lastpass_f.lpsubmitorig = lastpass_f.submit;        lastpass_f.submit = function(){          var form = this;          try {            if (document.documentElement && 'createEvent' in document)            {              var forms = document.getElementsByTagName('form');              for (var i=0 ; i<forms.length ; ++i)                if (forms[i]==form)                {                  var element = document.createElement('lpformsubmitdataelement');                  element.setAttribute('formnum',i);                  element.setAttribute('from','submithook');                  document.documentElement.appendChild(element);                  var evt = document.createEvent('Events');                  evt.initEvent('lpformsubmit',true,false);                  element.dispatchEvent(evt);                  break;                }            }          } catch (e) {}          try {            form.lpsubmitorig();          } catch (e) {}        }      }    }  }} catch (e) {}</script></head>
<body class="login animated fadeIn">
    <canvas height="1000" width="1400" id="canvas"></canvas>
    <div class="bg-gradient"></div>
    <div class="auth-form-wrapper clearfix">
        <div class="col-xs-12 col-xs-offset-0 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 text-center vertical-offset-100 clearfix">
            <a href="<?echo $address?>"><img src="<?echo $address?>images/login-logo.png" alt="New life Logo"></a>
        </div>
        <div class="col-xs-12 col-xs-offset-0 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 clearfix">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Авторизация</h3>
                </div>
                <div class="panel-body">
                    <!--<div class="row">
                        <div class="col-md-4">
                            <a href="#" class="btn btn-lg btn-block">
                                <i class="fa fa-facebook visible-xs"></i>
                                <span class="hidden-xs">Facebook</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-lg btn-block omb_btn-twitter">
                                <i class="fa fa-twitter visible-xs"></i>
                                <span class="hidden-xs">Twitter</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-lg btn-block omb_btn-google">
                                <i class="fa fa-google-plus visible-xs"></i>
                                <span class="hidden-xs">Google+</span>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span>Или</span>
                        </div>
                    </div>-->
                    <form name="auth" class="connect-form bv-form" action="functions.php" method="post"><input value="Авторизироваться" name="auth" style="display: none; width: 0px; height: 0px;" class="bv-hidden-submit" type="submit">
                        <div class="form-group has-feedback has-success">
                            <input style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAIZJREFUOBFjYKAMrGWiTD+DOMgANyC+DMSbgVgEiEHACojPAfFuIJYBYhDQB+KTQHwYiFWBGA4eA1n/obgNKnoBSWwmVGwvktgaqNgRSr0ANscVSF4E4k1ALAwWYWCwBNJngXgXEEtDxfSA9HEgPgjEMC8cgcqRTVHshRdkWz2qcTQEqBoCAI5ZGWbGuw0sAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" data-bv-field="login" class="form-control" placeholder="Ваш логин" name="login" id="login" type="text"><i data-bv-icon-for="login" class="form-control-feedback bv-no-label fa fa-check" style="display: block;"></i>
                        <small data-bv-result="VALID" data-bv-for="login" data-bv-validator="notEmpty" class="help-block" style="display: none;">Это поле не может быть пустым</small></div>
                        <div class="form-group has-feedback has-success">
                            <input style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAALZJREFUOBFjYKAANDQ0rGWiQD9IqzgL0BQ3IKMXiB8AcSKQ/waIrYDsKUD8Fir2pKmpSf/fv3+zgPxfzMzMSbW1tbeBbAaQC+b+//9fB4h9gOwikCAQTAPyDYHYBciuBQkANfcB+WZAbPP37992kBgIUOoFBiZGRsYkIL4ExJvZ2NhAXmFgYmLKBPLPAfFuFhaWJpAYEBQC+SeA+BDQC5UQIQpJYFgdodQLLyh0w6j20RCgUggAAEREPpKMfaEsAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" data-bv-field="password" class="form-control" placeholder="Ваш пароль" id="password" name="password" value="" type="password"><i data-bv-icon-for="password" class="form-control-feedback bv-no-label fa fa-check" style="display: block;"></i>
                        <small data-bv-result="VALID" data-bv-for="password" data-bv-validator="notEmpty" class="help-block" style="display: none;">Это поле не может быть пустым</small></div>
                        <div class="row">
                        </div>
                        <button value="Авторизироваться" name="auth" class="btn btn-green btn-block" type="submit"><i class="fa fa-sign-in"></i> Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="<?echo $address?>js/watch.js" async="" type="text/javascript"></script>-->
    <script src="<?echo $address?>js/jquery.js"></script>
<script src="<?echo $address?>js/bootstrap.js"></script>
<script src="<?echo $address?>js/particles.js"></script>
<script src="<?echo $address?>js/bootstrapValidator.js"></script>
<script src="<?echo $address?>js/emailAddress.js"></script>
<script src="<?echo $address?>js/notEmpty.js"></script>
<script src="<?echo $address?>js/identical.js"></script>
<script src="<?echo $address?>js/validationControl.js"></script>
<script src="<?echo $address?>js/ru_RU.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->

</body></html>