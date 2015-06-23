/**
 * Created by viperS on 22-06-2015 г..
 */
var pubUrl = window.location.protocol + '//' + window.location.host;

$(window).load(function(){

    $.ajax({
        type: "GET",
        url: pubUrl + '/assets/web/js/countries-json/countries.json',
        async: false,
        dataType: "json",
        success: function(data){
            var isLoadOne = JSON.stringify(data);var obj_load_one = eval('('+isLoadOne+')');
            $.each(obj_load_one, function (index, value) {
                var official = '';
                var callCode = '';
                $.each(value, function (index, value) {
                    switch (index) {
                        case "name":
                            $.each(value, function (index, value) {
                                switch (index) {
                                    case "common":
                                        official = value;
                                        break;
                                }
                            });
                            break;

                        case "callingCode":
                            callCode = value;
                            break;
                    }
                });
                var inHtml = '<option value="'+callCode+'">'+official+' (+ '+callCode+')'+'</option>';
                $("#countries").append(inHtml);
            });

            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
                $('.selectpicker').selectpicker('mobile');
            }
            else{
                $('.selectpicker').selectpicker({
                    style: 'btn-info',
                    size: 6
                });
            }
        }
    });



});