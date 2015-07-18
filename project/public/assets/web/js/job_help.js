/**
 * Created by viperS on 16-07-2015 г..
 */

var goCountr = '';
var msgRefer ='';

$.get(base_path +"/countries", function() {})
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
            '<div class="holdMsg" ><textarea id="themsg" placeholder="Write your referral message" cols="30" rows="4" onfocus="runFocus(this.id);"></textarea></div>' +
            '<div id="ref-content"><input class="refMsg" id="refname" name="refname" value="" placeholder="Name"  onfocus="runFocus(this.id);"/>'+
            '<select id="countr" class="form-control" style="margin-top: 14px;" onchange="myFunction();">'+goCountr+'</select>'+
            '<input style="margin-top: 14px;" class="refcoda" id="refcode" name="refcode" value="+44" placeholder=""/>'+
            '<input class="refMsg-phone" id="refphone" name="refphone" style="  float: left;width: 158px;  margin-top: 14px;" value="" placeholder="Phone Number" onfocus="runFocus(this.id);"/> </div>' +
            '<div id="refs-btn"><div id="btn-ok" style="" onclick="spoter();" >SEND SMS</div></div></div>';

    })
    .fail(function() {
        console.log( "error" );
    });