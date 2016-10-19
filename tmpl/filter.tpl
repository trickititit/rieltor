
<div id="filter">
    <form name="filter" action="%address%cabinet\" method="get">
        <div class="row bg_top">
            <div class="col-md-12 top_filter">
                    <select id="type" name="type">
                        %type%
                    </select>
                    %obj_address%
                    <select name="city" id="city">
                        %city%
                    </select>
                    %area_1_title%
                    <div id="area_1_search" hidden>
                        %area_1%
                    </div>
                    %area_2_title%
                    <div id="area_2_search" hidden>
                        %area_2%
                    </div>
                    <input id="submit_search" name="search" type="submit" value="Найти" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 dop_select">
                    <select id="typedeal" name="typedeal">
                        %typedeal%
                    </select>
                    %rooms_title%
                    <div id="rooms_search" hidden>
                        <fieldset>
                            %rooms%
                        </fieldset>
                    </div>
                    <select id="formObj_3" name="formObj_3" hidden>
                        %form_obj_3%
                    </select>
                    %type_house_2_title%
                    <div id="formObj_2_search" hidden>
                        %form_obj_2%
                    </div>
                    <input type="text" id="amount-square_2" readonly hidden>
                    <!-- Поля для поиска -->
                    %square_2%
                    <div id="square_2_search" hidden>
                        <div id="slider-range-square_2"></div>
                    </div>
                    <select id="formObj_1" name="formObj_1">
                        %form_obj_1%
                    </select>
                    <input type="text" id="amount-square_1" readonly >
                    <!-- Поля для поиска -->
                    %amount-square%
                    <div id="square_1_search" hidden>
                    <div id="slider-range-square_1"></div>
                    </div>
                    <input type="text" id="amount-square_earth" readonly hidden>
                    <!-- Поля для поиска -->
                    %square_earth%
                    <div id="square_earth_search" hidden>
                        <div id="slider-range-square_earth"></div>
                    </div>
                    %rieltors%
        </div>
        </div>
        <div class="row">
            <div class="col-md-12 dop_select">
                    <input type="text" id="amount-floor" readonly >
                    <!-- Поля для поиска -->
                    %amount-floor%
                    <div id="floor_search" hidden>
                    <div id="slider-range-floor"></div>
                    </div>
                    <input type="text" id="amount-floorInObj_2" readonly hidden>
                    <!-- Поля для поиска -->
                    %floorInObj_2%
                    <div id="floorInObj_2_search" hidden>
                        <div id="slider-range-floorInObj_2"></div>
                    </div>
                    <input type="text" id="amount-floorInObj_1" readonly>
                    <!-- Поля для поиска -->
                    %floorInObj_1%
                    <div id="floorInObj_1_search" hidden>
                        <div id="slider-range-floorInObj_1"></div>
                    </div>
                    %type_house_3_title%
                    <div id="typeHouse_2_search" hidden>
                        %type_house_2%
                    </div>
                    %type_house_1_title%
                    <div id="typeHouse_1_search" hidden>
                        %type_house_1%
                    </div>
                    <input type="text" id="amount-distance" readonly hidden>
                    <!-- Поля для поиска -->
                    %distance%
                    <div id="distance_search" hidden>
                        <div id="slider-range-distance"></div>
                    </div>
                    <input type="text" id="amount-price" readonly value="Цена, руб">
                    <div id="price_search" hidden>
                        %price%
                    </div>
                <label id="photo"><table><tr><td><input type="checkbox" name="photo" /></td><td id="label_checkbox">только с фото</td></tr></table></label>
            </div>
        </div>
        <input type="text" hidden name="typepage" readonly value="%typepage%">
    </form>
</div>
<script>
    %script%
</script>
<script>
    $(document).ready(function() {
                $( "#slider-range-floor" ).slider({
                    range: true,
                    min: 1,
                    max: 31,
                    %slider-range-floor_values%
                    slide: function( event, ui ) {

                        var lastVar1 = ui.values[0];
                        var lastVar2 = ui.values[1];
                        $("#amount-floor_min").val(lastVar1);
                        $("#amount-floor_max").val(lastVar2);
                        if (lastVar1 == 31) {
                            lastVar1 = "31+";
                        }
                        if (lastVar2 == 31) {
                            lastVar2 = "31+";
                        }
                        var resultat = "";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + " этаж";
                        } else if ((lastVar1 == 1) && (lastVar2 == "31+")) {
                            resultat = "Этаж";
                        } else {
                            resultat = lastVar1 + " - " + lastVar2 + " этаж";
                        }
                        $("#amount-floor").val(resultat);
                        $("#slider-range-floor .ui-slider-handle").first().text(lastVar1);
                        $("#slider-range-floor .ui-slider-handle").last().text(lastVar2);
                    }
                });
                var lastVar1_1 = $( "#slider-range-floor" ).slider( "values", 0 );
                var lastVar2_1 = $( "#slider-range-floor" ).slider( "values", 1 );
                $( "#amount-floor_min" ).val(lastVar1_1);
                $( "#amount-floor_max" ).val(lastVar2_1);

                if (lastVar1_1 == 31) {
                    lastVar1_1 = "31+";
                }
                if (lastVar2_1 == 31) {
                    lastVar2_1 = "31+";
                }
                var resultat2 = "";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + " этаж";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == "31+")) {
                    resultat2 = "Этаж";
                } else {
                    resultat2 = lastVar1_1 + " - " + lastVar2_1 + " этаж";
                }
                $( "#amount-floor" ).val(resultat2);
                $("#slider-range-floor .ui-slider-handle").first().text(lastVar1_1);
                $("#slider-range-floor .ui-slider-handle").last().text(lastVar2_1);

                $( "#slider-range-floorInObj_1" ).slider({
                    range: true,
                    min: 1,
                    max: 31,
                    %slider-range-floorInObj_1_values%
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[0];
                        var lastVar2 = ui.values[1];
                        $("#amount-floorInObj_1_min").val(lastVar1);
                        $("#amount-floorInObj_1_max").val(lastVar2);
                        if (lastVar1 == 31) {
                            lastVar1 = "31+";
                        }
                        if (lastVar2 == 31) {
                            lastVar2 = "31+";
                        }
                        var resultat = "";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + " этажей";
                        } else if ((lastVar1 == 1) && (lastVar2 == "31+")) {
                            resultat = "Этажей в доме";
                        } else {
                            resultat = lastVar1 + " - " + lastVar2 + " этажей";
                        }
                        $("#amount-floorInObj_1").val(resultat);
                        $("#slider-range-floorInObj_1 .ui-slider-handle").first().text(lastVar1);
                        $("#slider-range-floorInObj_1 .ui-slider-handle").last().text(lastVar2);
                    }
                });
                var lastVar1_1 = $( "#slider-range-floorInObj_1" ).slider( "values", 0 );
                var lastVar2_1 = $( "#slider-range-floorInObj_1" ).slider( "values", 1 );
                $( "#amount-floorInObj_1_min" ).val(lastVar1_1);
                $( "#amount-floorInObj_1_max" ).val(lastVar2_1);

                if (lastVar1_1 == 31) {
                    lastVar1_1 = "31+";
                }
                if (lastVar2_1 == 31) {
                    lastVar2_1 = "31+";
                }
                var resultat2 = "";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + " этажей";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == "31+")) {
                    resultat2 = "Этажей в доме";
                } else {
                    resultat2 = lastVar1_1 + " - " + lastVar2_1 + " этажей";
                }
                $( "#amount-floorInObj_1" ).val(resultat2);
                $("#slider-range-floorInObj_1 .ui-slider-handle").first().text(lastVar1_1);
                $("#slider-range-floorInObj_1 .ui-slider-handle").last().text(lastVar2_1);


        $( "#slider-range-floorInObj_2" ).slider({
                    range: true,
                    min: 1,
                    max: 5,
                    %slider-range-floorInObj_2_values%
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[0];
                        var lastVar2 = ui.values[1];
                        $("#amount-floorInObj_2_min").val(lastVar1);
                        $("#amount-floorInObj_2_max").val(lastVar2);
                        if (lastVar1 == 5) {
                            lastVar1 = "5+";
                        }
                        if (lastVar2 == 5) {
                            lastVar2 = "5+";
                        }
                        var resultat = "";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + " этажей";
                        } else if ((lastVar1 == 1) && (lastVar2 == "5+")) {
                            resultat = "Этажей в доме";
                        } else {
                            resultat = lastVar1 + " - " + lastVar2 + " этажей";
                        }
                        $("#amount-floorInObj_2").val(resultat);
                        $("#slider-range-floorInObj_2 .ui-slider-handle").first().text(lastVar1);
                        $("#slider-range-floorInObj_2 .ui-slider-handle").last().text(lastVar2);
                    }
                });
                var lastVar1_1 = $( "#slider-range-floorInObj_2" ).slider( "values", 0 );
                var lastVar2_1 = $( "#slider-range-floorInObj_2" ).slider( "values", 1 );
                $( "#amount-floorInObj_2_min" ).val(lastVar1_1);
                $( "#amount-floorInObj_2_max" ).val(lastVar2_1);

                if (lastVar1_1 == 5) {
                    lastVar1_1 = "5+";
                }
                if (lastVar2_1 == 5) {
                    lastVar2_1 = "5+";
                }
                var resultat2 = "";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + " этажей";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == "5+")) {
                    resultat2 = "Этажей в доме";
                } else {
                    resultat2 = lastVar1_1 + " - " + lastVar2_1 + " этажей";
                }
                $( "#amount-floorInObj_2" ).val(resultat2);
                $("#slider-range-floorInObj_2 .ui-slider-handle").first().text(lastVar1_1);
                $("#slider-range-floorInObj_2 .ui-slider-handle").last().text(lastVar2_1);

                $( "#slider-range-square_1" ).slider({
                    range: true,
                    min: 10,
                    max: 200,
                    %slider-range-square_1_values%
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( "#amount-square_min" ).val(lastVar1);
                        $( "#amount-square_max" ).val(lastVar2);
                        if (lastVar1 == 200) {
                            lastVar1 = "200+";
                        }
                        if (lastVar2 == 200) {
                            lastVar2 = "200+";
                        }
                        var resultat = "";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + " м²";
                        } else if ( (lastVar1 == 10) && (lastVar2 == "200+")) {
                            resultat = "Площадь, м²";
                        } else {
                            resultat = lastVar1 + " - " + lastVar2 + " м²";
                        }
                        $( "#amount-square_1" ).val(resultat);
                        $("#slider-range-square_1 .ui-slider-handle").first().text(lastVar1);
                        $("#slider-range-square_1 .ui-slider-handle").last().text(lastVar2);
                    }
                });
                var lastVar1_1 = $( "#slider-range-square_1" ).slider( "values", 0 );
                var lastVar2_1 = $( "#slider-range-square_1" ).slider( "values", 1 );
                $( "#amount-square_min" ).val(lastVar1_1);
                $( "#amount-square_max" ).val(lastVar2_1);
                if (lastVar1_1 == 200) {
                    lastVar1_1 = "200+";
                }
                if (lastVar2_1 == 200) {
                    lastVar2_1 = "200+";
                }
                var resultat2 = "";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + " м²";
                } else if ((lastVar1_1 == 10) && (lastVar2_1 == "200+")) {
                    resultat2 = "Площадь, м²";
                } else {
                    resultat2 = lastVar1_1 + " - " + lastVar2_1 + " м²";
                }
                $( "#amount-square_1" ).val(resultat2);
                $("#slider-range-square_1 .ui-slider-handle").first().text(lastVar1_1);
                $("#slider-range-square_1 .ui-slider-handle").last().text(lastVar2_1);

                $( "#slider-range-square_2" ).slider({
                    range: true,
                    min: 10,
                    max: 500,
                    %slider-range-square_2_values%
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( "#amount-square_2_min" ).val(lastVar1);
                        $( "#amount-square_2_max" ).val(lastVar2);
                        if (lastVar1 == 500) {
                            lastVar1 = "500+";
                        }
                        if (lastVar2 == 500) {
                            lastVar2 = "500+";
                        }
                        var resultat = "";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + " м²";
                        } else if ( (lastVar1 == 10) && (lastVar2 == "500+")) {
                            resultat = "Площадь дома, м²";
                        } else {
                            resultat = lastVar1 + " - " + lastVar2 + " м²";
                        }
                        $( "#amount-square_2" ).val(resultat);
                        $("#slider-range-square_2 .ui-slider-handle").first().text(lastVar1);
                        $("#slider-range-square_2 .ui-slider-handle").last().text(lastVar2);
                    }
                });
                var lastVar1_1 = $( "#slider-range-square_2" ).slider( "values", 0 );
                var lastVar2_1 = $( "#slider-range-square_2" ).slider( "values", 1 );
                $( "#amount-square_2_min" ).val(lastVar1_1);
                $( "#amount-square_2_max" ).val(lastVar2_1);
                if (lastVar1_1 == 500) {
                    lastVar1_1 = "500+";
                }
                if (lastVar2_1 == 500) {
                    lastVar2_1 = "500+";
                }
                var resultat2 = "";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + " м²";
                } else if ((lastVar1_1 == 10) && (lastVar2_1 == "500+")) {
                    resultat2 = "Площадь дома, м²";
                } else {
                    resultat2 = lastVar1_1 + " - " + lastVar2_1 + " м²";
                }
                $( "#amount-square_2" ).val(resultat2);
                $("#slider-range-square_2 .ui-slider-handle").first().text(lastVar1_1);
                $("#slider-range-square_2 .ui-slider-handle").last().text(lastVar2_1);

                $( "#slider-range-square_earth" ).slider({
                    range: true,
                    min: 1,
                    max: 100,
                    %slider-range-square_earth_values%
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( "#amount-square_earth_min" ).val(lastVar1);
                        $( "#amount-square_earth_max" ).val(lastVar2);
                        if (lastVar1 == 100) {
                            lastVar1 = "100+";
                        }
                        if (lastVar2 == 100) {
                            lastVar2 = "100+";
                        }
                        var resultat = "";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + " сот.";
                        } else if ( (lastVar1 == 1) && (lastVar2 == "100+")) {
                            resultat = "Площадь участка, сот.";
                        } else {
                            resultat = lastVar1 + " - " + lastVar2 + " сот.";
                        }
                        $( "#amount-square_earth" ).val(resultat);
                        $("#slider-range-square_earth .ui-slider-handle").first().text(lastVar1);
                        $("#slider-range-square_earth .ui-slider-handle").last().text(lastVar2);
                    }
                });
                var lastVar1_1 = $( "#slider-range-square_earth" ).slider( "values", 0 );
                var lastVar2_1 = $( "#slider-range-square_earth" ).slider( "values", 1 );
                $( "#amount-square_earth_min" ).val(lastVar1_1);
                $( "#amount-square_earth_max" ).val(lastVar2_1);
                if (lastVar1_1 == 100) {
                    lastVar1_1 = "100+";
                }
                if (lastVar2_1 == 100) {
                    lastVar2_1 = "100+";
                }
                var resultat2 = "";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + " сот.";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == "100+")) {
                    resultat2 = "Площадь участка, сот.";
                } else {
                    resultat2 = lastVar1_1 + " - " + lastVar2_1 + " сот.";
                }
                $( "#amount-square_earth" ).val(resultat2);
                $("#slider-range-square_earth .ui-slider-handle").first().text(lastVar1_1);
                $("#slider-range-square_earth .ui-slider-handle").last().text(lastVar2_1);

                $( "#slider-range-distance" ).slider({
                    range: true,
                    min: 0,
                    max: 100,
                    %slider-range-distance_values%
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( "#amount-distance_min" ).val(lastVar1);
                        $( "#amount-distance_max" ).val(lastVar2);
                        if (lastVar1 == 100) {
                            lastVar1 = "100+";
                        }
                        if (lastVar2 == 100) {
                            lastVar2 = "100+";
                        }
                        if (lastVar1 == 0 && lastVar2 == 0) {
                            lastVar1 = "В черте города";
                        }
                        var resultat = "";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + " км.";
                        } else if ( (lastVar1 == 0) && (lastVar2 == "100+")) {
                            resultat = "Расстояние до города, км.";
                        } else if (lastVar1 == "В черте города") {
                            resultat = "В черте города";
                            lastVar1 = 0;
                        } else {
                            resultat = lastVar1 + " - " + lastVar2 + " км.";
                        }
                        $( "#amount-distance" ).val(resultat);
                        $("#slider-range-distance .ui-slider-handle").first().text(lastVar1);
                        $("#slider-range-distance .ui-slider-handle").last().text(lastVar2);
                    }
                });
                var lastVar1_1 = $( "#slider-range-distance" ).slider( "values", 0 );
                var lastVar2_1 = $( "#slider-range-distance" ).slider( "values", 1 );
                $( "#amount-distance_min" ).val(lastVar1_1);
                $( "#amount-distance_max" ).val(lastVar2_1);
                if (lastVar1_1 == 100) {
                    lastVar1_1 = "100+";
                }
                if (lastVar2_1 == 100) {
                    lastVar2_1 = "100+";
                }
                if (lastVar1_1 == 0 && lastVar2_1 == 0) {
                    lastVar1_1 = "В черте города";
                }
                var resultat2 = "";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + " км.";
                } else if ((lastVar1_1 == 0) && (lastVar2_1 == "100+")) {
                    resultat2 = "Расстояние до города, км.";
                } else if (lastVar1_1 == "В черте города") {
                    resultat2 = "В черте города";
                    lastVar1_1 = 0;
                } else {
                    resultat2 = lastVar1_1 + " - " + lastVar2_1 + " км.";
                }
                $( "#amount-distance" ).val(resultat2);
                $("#slider-range-distance .ui-slider-handle").first().text(lastVar1_1);
                $("#slider-range-distance .ui-slider-handle").last().text(lastVar2_1);

                $( function() {
                    $( "#rooms_search :checkbox" ).checkboxradio({
                        icon: false
                    });
                });

            });
</script>