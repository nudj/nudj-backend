/**
 * Created by viperS on 16-07-2015 г..
 */

var goCountr = '';
var msgRefer ='';

//msgRefer =
//    '<div id="inn">'+
//    '<div id="refera-content">Refer Someone</div>' +
//    '<div ><textarea id="themsg" placeholder="Write your referral message" cols="30" rows="4" onfocus="runFocus(this.id);"></textarea></div>' +
//    '<div id="ref-content"><input class="refMsg" id="refname" name="refname" value="" placeholder="Name"  onfocus="runFocus(this.id);"/>'+
//    '<select id="countr" class="form-control" style="margin-top: 14px;" onchange="myFunction();"></select>'+
//    '<input style="margin-top: 14px;" class="refcoda" id="refcode" name="refcode" value="+44" placeholder=""/>'+
//    '<input class="refMsg-phone" id="refphone" name="refphone" style="  float: left;width: 158px;  margin-top: 14px;" value="" placeholder="Phone Number" onfocus="runFocus(this.id);"/> </div>' +
//    '<div id="refs-btn"><div id="btn-ok" style="" >SEND SMS</div></div></div>';

$.get( "/countries", function() {})
    .done(function(data) {
        isVerifyet = JSON.stringify(data);
        var obj_verifyet = eval('('+isVerifyet+')');

        $.each( obj_verifyet, function( key, value ) {
            if(value.name == 'United Kingdom')
                goCountr += '<option value="'+value.name+'-'+value.code+'" selected>'+value.name+' (+'+value.code+') </option>';
            else
                goCountr += '<option value="'+value.name+'-'+value.code+'">'+value.name+' (+'+value.code+') </option>';
        });

        msgRefer =
            '<div id="inn">'+
            '<div id="refera-content">Refer Someone</div>' +
            '<div ><textarea id="themsg" placeholder="Write your referral message" cols="30" rows="4" onfocus="runFocus(this.id);"></textarea></div>' +
            '<div id="ref-content"><input class="refMsg" id="refname" name="refname" value="" placeholder="Name"  onfocus="runFocus(this.id);"/>'+
            '<select id="countr" class="form-control" style="margin-top: 14px;" onchange="myFunction();">'+goCountr+'</select>'+
            '<input style="margin-top: 14px;" class="refcoda" id="refcode" name="refcode" value="+44" placeholder=""/>'+
            '<input class="refMsg-phone" id="refphone" name="refphone" style="  float: left;width: 158px;  margin-top: 14px;" value="" placeholder="Phone Number" onfocus="runFocus(this.id);"/> </div>' +
            '<div id="refs-btn"><div id="btn-okay" style="" onclick="spoter();" >SEND SMS</div></div></div>';

    })
    .fail(function() {
        console.log( "error" );
    });

        /*refer*/

        $("#refs-btn").click(function(e){
            e.preventDefault();
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
                var job_id = $("#job_id").val();

                var put_data = {job_id:job_id};
                //$.post( base_path +"/apply", put_data,function(data) {})
                //        .done(function( data ) {
                //            successSpoter();
                //            setTimeout(function() {
                //                parent.TINY.box.hide();
                //            }, 3000);
                //        })
                //        .fail(function(){
                //            TINY.box.show({html:msgFail,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
                //        })

                successSpoter();
                setTimeout(function() {
                    parent.TINY.box.hide();
                }, 3000);

            }

        });