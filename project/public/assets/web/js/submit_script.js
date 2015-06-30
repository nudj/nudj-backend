/**
 * Created by viperS on 24-06-2015 г..
 */

var msgFail =
    '<div id="failed-head">Incorrect Code</div>' +
    '<div id="failed-content">Please check and <br>try again.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';

function down_modal(){
    parent.TINY.box.hide();
}

$("#btn-submit").click(function(e){
    /*e.preventDefault();*/
    var verific = $("#mobile-one").val() +$("#mobile-two").val() + $("#mobile-three").val() + $("#mobile-four").val();

    var chkCode = verific.length;

    if(chkCode <4){
        TINY.box.show({html:msgFail,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
    }
    else{
        var phone = $("#phone").html().trim();

        var put_data = {phone:phone,verification:verific};
        $.post( "/verify", put_data,function(data) {})
            .done(function( data ) {
                console.log(data);
                isVerifyet = JSON.stringify(data);
                var obj_verifyet = eval('('+isVerifyet+')');
                if(obj_verifyet){
                    console.log("result"+obj_verifyet);
                    window.location.href = "/job/"+$("#jobid").val();
                }
                else{
                    TINY.box.show({html:msgFail,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
                }
            })
            .fail(function(){
                TINY.box.show({html:msgFail,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
            })
    }

});

function closeFailed(){
    $("input[name=mobile-one]").val("");
    $("input[name=mobile-two]").val("");
    $("input[name=mobile-three]").val("");
    $("input[name=mobile-four]").val("");
    $("#mobile-one").focus();
}

$("#mobile-one").keypress(function(e){
   if($(this).length > 0){
       $("#mobile-two").focus();
   }
});

$("#mobile-two").keypress(function(e){
   if($(this).length > 0){
       $("#mobile-three").focus();
   }
});

$("#mobile-three").keypress(function(e){
   if($(this).length > 0){
       $("#mobile-four").focus();
   }
});

$("#mobile-four").keypress(function(e){

    if (e.keyCode == 13) {

        var verific = $("#mobile-one").val() +$("#mobile-two").val() + $("#mobile-three").val() + $(this).val();

        var chkCode = verific.length;

        if(chkCode <4){
            TINY.box.show({html:msgFail,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
        }
        else{
            $("#btn-submit").click();
        }

    }

});

