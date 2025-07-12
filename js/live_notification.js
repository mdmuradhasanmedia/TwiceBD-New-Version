/*-- ln_livenotifications JS Script
--------------------------------*/
function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return unescape(y);
        }
    }
}

var xmlHttp = null;
var ln_transferids = '';

function ln_fetchnotifications(type,e) {
	if(document.getElementById("livenotifications_list").style.display == "block"){
		document.getElementById("livenotifications_list").style.display = "none";
		if(type == 'comment'){
			jQuery("#livenotifications a").removeClass("selected");
			return;
		}
	}
	if(document.getElementById("livenotifications_list_nb").style.display == "block"){
		document.getElementById("livenotifications_list_nb").style.display = "none";
		if(type == 'nb'){
			jQuery("#livenotifications_nb a").removeClass("selected");
			return;
		}
	}
	if(document.getElementById("livenotifications_list_pm").style.display == "block"){
		document.getElementById("livenotifications_list_pm").style.display = "none";
		if(type == 'pm'){
			jQuery("#livenotifications_pm a").removeClass("selected");
			return;
		}
	}
	if(document.getElementById("livenotifications_list_moderation").style.display == "block"){
		document.getElementById("livenotifications_list_moderation").style.display = "none";
		if(type == 'moderation'){
			jQuery("#livenotifications_moderation a").removeClass("selected");
			return;
		}
	}
	if(jQuery("#user-dropdown").length > 0){
		if(document.getElementById("user-dropdown").style.display == "block"){
			document.getElementById("user-dropdown").style.display = "none";
		}
	}
	if(type == "comment"){
		document.getElementById("livenotifications_list").style.display = "block";
		jQuery("#livenotifications a").addClass("selected");
		jQuery("#livenotifications_pm a").removeClass("selected");
		jQuery("#livenotifications_moderation a").removeClass("selected");
	}
	else if(type == "nb"){
		document.getElementById("livenotifications_list_nb").style.display = "block";
		jQuery("#livenotifications_nb a").addClass("selected");
		jQuery("#livenotifications a").removeClass("selected");
		jQuery("#livenotifications_moderation a").removeClass("selected");
	}
	else if(type == "pm"){
		document.getElementById("livenotifications_list_pm").style.display = "block";
		jQuery("#livenotifications_pm a").addClass("selected");
		jQuery("#livenotifications a").removeClass("selected");
		jQuery("#livenotifications_moderation a").removeClass("selected");
	}
	else if(type == "moderation"){
		document.getElementById("livenotifications_list_moderation").style.display = "block";
		jQuery("#livenotifications_moderation a").addClass("selected");
		jQuery("#livenotifications_pm a").removeClass("selected");
		jQuery("#livenotifications a").removeClass("selected");
	}

	jQuery.ajax({
        type: 'POST',
        url: base_url + '/wp-admin/admin-ajax.php',
        data: {
        	action:'ln_ajax_process',
            do: 'ln_getcount',
            numonly: 1,
            type: type
        },
        success: function(data, textStatus, XMLHttpRequest){
        	if (data.indexOf("|") > -1) {
    			var num = data.substring(0,data.indexOf("|"));
    			var type = data.substring(data.indexOf("|")+1);
    			if(type == "comment"){
    				document.getElementById("livenotifications_num").innerHTML = num;
    				document.getElementById("livenotifications_num").style.visibility = "hidden";
    			}
    			else if(type == "nb"){
    				document.getElementById("livenotifications_num_nb").innerHTML = num;
    				document.getElementById("livenotifications_num_nb").style.visibility = "hidden";
    			}
    			else if(type == "pm"){
    				document.getElementById("livenotifications_num_pm").innerHTML = num;
    				document.getElementById("livenotifications_num_pm").style.visibility = "hidden";
    			}
    			else if(type == "moderation"){
    				document.getElementById("livenotifications_num_moderation").innerHTML = num;
    				document.getElementById("livenotifications_num_moderation").style.visibility = "hidden";
    			}
    		}
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
//            alert(errorThrown);
        }
    });

}

function ln_nb_reply_action(nb_id,scrollpane_height) {
	jQuery.ajax({
        type: 'POST',
        url: base_url + '/wp-admin/admin-ajax.php',
        data: {
        	action:'ln_ajax_process',
            a: 'pr',
            i: nb_id,
            t: jQuery("#reply_"+nb_id).val(),
            h: scrollpane_height
        },
        success: function(data, textStatus, XMLHttpRequest){
        	var arr = data.split(",");
    		ln_back_to_notices(arr['0'],arr['1']);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
//            alert(errorThrown);
        }
    });
}

function ln_pm_reply_action(pm_id,scrollpane_height) {
	jQuery.ajax({
        type: 'POST',
        url: base_url + '/wp-admin/admin-ajax.php',
        data: {
        	action:'ln_ajax_process',
            a: 'pr',
            i: pm_id,
            t: jQuery("#reply_"+pm_id).val(),
            h: scrollpane_height
        },
        success: function(data, textStatus, XMLHttpRequest){
        	var arr = data.split(",");
    		ln_back_to_messages(arr['0'],arr['1']);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
//            alert(errorThrown);
        }
    });
}


setTimeout(function() {
    jQuery('#notification_box').hide();
}, 5000); 

function ln_transfer_overview(url) {
	//self.location.href = url + "&lntransf=" + ln_transferids + "#livenotifications";
	self.location.href = url ;
}