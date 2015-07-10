/**
 * Created by viperS on 24-06-2015 г..
 */
var pubUrl = window.location.protocol + '//' + window.location.host;
var goCountr = '';var msgRefer ='';

function down_modal(){
    parent.TINY.box.hide();
}
function spoter(){
    var chkr = 0;

    if($("#refphone").val().length == 0){
        chkr = chkr +1;
        $("#refphone").css("border-color","red");
    }
    if($("#refname").val().length == 0){
        chkr =chkr + 1;
        $("#refname").css("border-color","red");
    }
    if($("#themsg").val().length == 0){
        chkr =chkr + 1;
        $("#themsg").css("border-color","red");
    }

    if(chkr == 0){
        successSpoter();
        setTimeout(function() {
            parent.TINY.box.hide();
        }, 3000);
    }


}

function runFocus(thisElement){
    $("#"+thisElement).css("border-color","#EBEBEB");
};


function myFunction(){
    var origVal = $("#countr").val().split("-");
    var newCode = '+' + origVal[1];
    $("#refcode").val(newCode);
};


var msgSuccess =
    '<div id="success-head">Success !</div>' +
    '<div id="success-content">The hirer has been notified about your application.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';

var msgSpoter =
    '<div id="sms-head" class="sms-sent">SMS sent!</div>';

var msgFailed =
    '<div id="failed-head">Failed !</div>' +
    '<div id="failed-content">Something went wrong.Please try again.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';


function successSpoter(){
    TINY.box.show({html:msgSpoter,width:200,height:50,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeSuccess()}})
}

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

/*applay*/

//$("#btn-submit").click(function(e){
//    /*e.preventDefault();*/
//
//    var job_id = $("#job_id").val();
//
//        var put_data = {job_id:job_id};
//        $.post( base_path +"/applay", put_data,function(data) {})
//            .done(function( data ) {
//                successResult();
//            })
//            .fail(function(){
//                TINY.box.show({html:msgFail,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
//            })
//});

