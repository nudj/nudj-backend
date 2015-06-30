/**
 * Created by viperS on 24-06-2015 г..
 */
var pubUrl = window.location.protocol + '//' + window.location.host;

function down_modal(){
    parent.TINY.box.hide();
}

var msgSuccess =
    '<div id="success-head">Success !</div>' +
    '<div id="success-content">The hirer has been notified about your application.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';

var msgFailed =
    '<div id="failed-head">Failed !</div>' +
    '<div id="failed-content">Something went wrong.Please try again.</div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';

var msgRefer =
    '<div id="failed-content"><input id="refname" name="refname" value="" /><br><input id="refphone" name="refphone" value=""/> </div>' +
    '<div id="success-btn" onclick="down_modal();"><div id="btn-ok" style="" >OK</div></div>';

function successResult(){
    TINY.box.show({html:msgRefer,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeSuccess()}})
}
function failedResult(){
    TINY.box.show({html:msgFailed,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
}

$("#submit").click(function(){
    var ch = 1;

    if(ch > 0){
        successResult();
    }
    else{
        failedResult();
    }

});

function closeSuccess(){
    console.log("Closed modal");
}
function closeFailed(){
    console.log("Closed modal");
}