<div class="table-responsive">
<table id="parrent_tab" class="table table-hover">
    <thead>
    <tr>
        <th>Обьект</th>
        <th>Адрес</th>
        <th>Цена</th>
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
        (function($) {
            var sR = {
                defaults: {
                    slideSpeed: 400,
                    easing: false,
                    callback: false
                },
                thisCallArgs: {
                    slideSpeed: 400,
                    easing: false,
                    callback: false
                },
                methods: {
                    up: function (arg1,arg2,arg3) {
                        if(typeof arg1 == 'object') {
                            for(p in arg1) {
                                sR.thisCallArgs.eval(p) = arg1[p];
                            }
                        }else if(typeof arg1 != 'undefined' && (typeof arg1 == 'number' || arg1 == 'slow' || arg1 == 'fast')) {
                            sR.thisCallArgs.slideSpeed = arg1;
                        }else{
                            sR.thisCallArgs.slideSpeed = sR.defaults.slideSpeed;
                        }

                        if(typeof arg2 == 'string'){
                            sR.thisCallArgs.easing = arg2;
                        }else if(typeof arg2 == 'function'){
                            sR.thisCallArgs.callback = arg2;
                        }else if(typeof arg2 == 'undefined') {
                            sR.thisCallArgs.easing = sR.defaults.easing;
                        }
                        if(typeof arg3 == 'function') {
                            sR.thisCallArgs.callback = arg3;
                        }else if(typeof arg3 == 'undefined' && typeof arg2 != 'function'){
                            sR.thisCallArgs.callback = sR.defaults.callback;
                        }
                        var $cells = $(this).find('td');
                        $cells.wrapInner('<div class="slideRowUp" />');
                        var currentPadding = $cells.css('padding');
                        $cellContentWrappers = $(this).find('.slideRowUp');
                        $cellContentWrappers.slideUp(sR.thisCallArgs.slideSpeed,sR.thisCallArgs.easing).parent().animate({
                            paddingTop: '0px',
                            paddingBottom: '0px'},{
                            complete: function () {
                                $(this).children('.slideRowUp').replaceWith($(this).children('.slideRowUp').contents());
                                $(this).parent().css({'display':'none'});
                                $(this).css({'padding': currentPadding});
                            }});
                        var wait = setInterval(function () {
                            if($cellContentWrappers.is(':animated') === false) {
                                clearInterval(wait);
                                if(typeof sR.thisCallArgs.callback == 'function') {
                                    sR.thisCallArgs.callback.call(this);
                                }
                            }
                        }, 100);
                        return $(this);
                    },
                    down: function (arg1,arg2,arg3) {
                        if(typeof arg1 == 'object') {
                            for(p in arg1) {
                                sR.thisCallArgs.eval(p) = arg1[p];
                            }
                        }else if(typeof arg1 != 'undefined' && (typeof arg1 == 'number' || arg1 == 'slow' || arg1 == 'fast')) {
                            sR.thisCallArgs.slideSpeed = arg1;
                        }else{
                            sR.thisCallArgs.slideSpeed = sR.defaults.slideSpeed;
                        }

                        if(typeof arg2 == 'string'){
                            sR.thisCallArgs.easing = arg2;
                        }else if(typeof arg2 == 'function'){
                            sR.thisCallArgs.callback = arg2;
                        }else if(typeof arg2 == 'undefined') {
                            sR.thisCallArgs.easing = sR.defaults.easing;
                        }
                        if(typeof arg3 == 'function') {
                            sR.thisCallArgs.callback = arg3;
                        }else if(typeof arg3 == 'undefined' && typeof arg2 != 'function'){
                            sR.thisCallArgs.callback = sR.defaults.callback;
                        }
                        var $cells = $(this).find('td');
                        $cells.wrapInner('<div class="slideRowDown" style="display:none;" />');
                        $cellContentWrappers = $cells.find('.slideRowDown');
                        $(this).show();
                        $cellContentWrappers.slideDown(sR.thisCallArgs.slideSpeed, sR.thisCallArgs.easing, function() { $(this).replaceWith( $(this).contents()); });

                        var wait = setInterval(function () {
                            if($cellContentWrappers.is(':animated') === false) {
                                clearInterval(wait);
                                if(typeof sR.thisCallArgs.callback == 'function') {
                                    sR.thisCallArgs.callback.call(this);
                                }
                            }
                        }, 100);
                        return $(this);
                    }
                }
            };

            $.fn.slideRow = function(method,arg1,arg2,arg3) {
                if(typeof method != 'undefined') {
                    if(sR.methods[method]) {
                        return sR.methods[method].apply(this, Array.prototype.slice.call(arguments,1));
                    }
                }
            };
        })(jQuery);
//        var up = "<a class='equasss' href='#' title='Удалить навсегда'></a>";
//        $('.table tr').hover(function () {
//            $(this).append(up);
////            $(this).find('.tab_content').stop(true).animate({ height: "200px"}, 300)
//        },
//                function () {
////                    $(this).find('.tab_content').stop(true).animate({ height: "58px"}, 300)
//                    $(this).find('.equasss').remove();
//                })
        $('.spoiler_title').click(function(){
            var show = $(this).attr('show');
            var id = $(this).attr('data-target');
            if(show == 1){
                $(this).attr('show', 0);
                $(this).html("Свернуть");
                $(id).slideRow('down');
            }else{
                $(this).attr('show', 1);
                $(this).html("Подробнее");
                $(id).slideRow('up');
            }
        });
    });
</script>
