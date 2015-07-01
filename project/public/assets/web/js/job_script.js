/**
 * Created by viperS on 24-06-2015 г..
 */
var pubUrl = window.location.protocol + '//' + window.location.host;

function down_modal(){
    parent.TINY.box.hide();
}


$.get( "/countries", function() {})
    .done(function(data) {
        isVerifyet = JSON.stringify(data);
        var obj_verifyet = eval('('+isVerifyet+')');
        $.each( obj_verifyet, function( key, value ) {
            $.each( value, function( keys, val ) {
                switch (keys) {
                    case "name":
                        var newName = val;
                        break;
                    case "code":
                        var newCode = val;
                        break;
                }
                console.log(newName+'-'+newCode);
            });

        });

    })
    .fail(function() {
        console.log( "error" );
    });

var msgSuccess =
    '<div id="success-head">Success !</div>' +
    '<div id="success-content">The hirer has been notified about your application.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';

var msgFailed =
    '<div id="failed-head">Failed !</div>' +
    '<div id="failed-content">Something went wrong.Please try again.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';

var msgRefer =
    '<div id="inn">'+
    '<div id="refera-content">Refer Someone</div>' +
    '<div ><textarea id="themsg" placeholder="Write your referral message" cols="30" rows="3"></textarea></div>' +
    '<div id="ref-content"><input class="refMsg" id="refname" name="refname" value="" placeholder="Name" /><br/><br/>'+
    '<select id="countr" class="form-control"><option value="United Kingdom-44">United Kingdom (+44)</option></select><br/>'+
    '<input class="refcoda" id="refphone" name="refphone" value="+44" placeholder=""/><input class="refMsg" id="refphone" name="refphone" style="  float: left;width: 157px;" value="" placeholder="Phone Number"/> </div>' +
    '<div id="refs-btn" onclick="down_modal();"><div id="btn-ok" style="" >SEND SMS</div></div></div>';

function successResult(){
    TINY.box.show({html:msgSuccess,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeSuccess()}})
}
function refResult(){
    TINY.box.show({html:msgRefer,width:260,height:360,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeSuccess()}})
}
function failedResult(){
    TINY.box.show({html:msgFailed,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
}

$("#btn-submit").click(function(){
    successResult();
    //var ch = 1;
    //
    //if(ch > 0){
    //    var getType = $("input[name=refer]").val();
    //    switch (getType){
    //        case "1":
    //            refResult();
    //            break;
    //        case "2":
    //            successResult();
    //            break;
    //    }
    //
    //}
    //else{
    //    failedResult();
    //}

});

$("#btn-refer").click(function() {
    refResult();
});

function closeSuccess(){
    console.log("Closed modal");
}
function closeFailed(){
    console.log("Closed modal");
}

//$(window).load(function(){
//
//    $('.selectpicker').selectpicker('val', 'United Kingdom-44');
//
//    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
//        $('.selectpicker').selectpicker('mobile');
//    }
//    else{
//        $('.selectpicker').selectpicker({
//            style: 'btn-info',
//            size: 6
//        });
//    }
//
//});

$('.selectpicker').selectpicker('val', 'United Kingdom-44');

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
    $('.selectpicker').selectpicker('mobile');
}
else{
    $('.selectpicker').selectpicker({
        style: 'btn-info',
        size: 6
    });
}