/**
 * Created by viperS on 22-06-2015 г..
 */
var pubUrl = window.location.protocol + '//' + window.location.host;

$(window).load(function(){

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        $('.selectpicker').selectpicker('mobile');
    }
    else{
        $('.selectpicker').selectpicker({
            style: 'btn-info',
            size: 6
        });
    }

});