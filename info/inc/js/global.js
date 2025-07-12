/**
 * WpChats WordPress Plugin
 * Main scripts
 * Author: @samuel_elh
 */
jQuery(document).ready(function ($) {
    
	$(document).on('click', '.textarea-cont', function(){
		$('body').find('#message_body').focus();
		$('body').find('#message_send').val(trans['19']);
	});
	$(document).on('click', '#wpchats', function(){
		if($("body").find(".wpchats-single").length > 0 && $("body").find("#wpcnm").length > 0)
			$("body").find("#wpcnm").remove();
	});
	window.setInterval(function () {
		if( $.trim($('#message_body').val()) == 0 ) {
			$('#message_send').addClass("disabled");
		} else {
			$('#message_send').removeClass("disabled");
		}
	}, 400);
	$(document).on('click', '#wpcusers #wusc', function(){
		$('body').find('#wpc_user_search_s').focus();
	});
	$(document).on('click', '.wpc-lb-close', function(event){
		event.preventDefault();
		$('body').find( '.wpcm-'+$(this).attr('data-pm') ).slideUp();
	});
	$(document).on('click', '#wpc-pick-sm', function(){
		if( !($(this).hasClass('active') ) ) {
			$('body').find('#wpc-pick-emoji').slideDown();
			$(this).addClass('active');
			if($('body').find('#msg-vid-tool').is(":visible"))
				$('body').find('#msg-vid-tool').slideUp();
			if($('body').find('#msg-aud-tool').is(":visible"))
				$('body').find('#msg-aud-tool').slideUp();
			$('body').find('#wpc-vid-ico, #wpc-aud-ico').removeClass('active');
		} else {
			$('body').find('#wpc-pick-emoji').slideUp();
			$(this).removeClass('active');
		}
	});
	$(document).on('click', '#wpc-pick-emoji > img', function(event){
		var code = $(this).attr('alt');
		$('body').find('#message_body').val($('body').find('#message_body').val()+' '+code);
		$('body').find('#message_body').focus();
		$('body').find('#message_body').change();
		return false;
	});
	$(document).on('keyup', '#emoji-search', function(){
		var s = $(this).val();
		$('body').find('#wpc-pick-emoji > img').each(function() {
			var desc = $(this).attr('title');
			if( desc.indexOf(s) >= 0 ) {
				$(this).slideDown();
			} else {
				$(this).slideUp();
			}
		});
		return false;
	});
	$(document).on('click', '#wpc-vid-ico', function(){
		if( !($(this).hasClass('active') ) ) {
			$('body').find('#msg-vid-tool').slideDown();
			$(this).addClass('active');
			if($('body').find('#wpc-pick-emoji').is(":visible"))
				$('body').find('#wpc-pick-emoji').slideUp();
			if($('body').find('#msg-aud-tool').is(":visible"))
				$('body').find('#msg-aud-tool').slideUp();
			$('body').find('#wpc-pick-sm, #wpc-aud-ico').removeClass('active');
		} else {
			$('body').find('#msg-vid-tool').slideUp();
			$(this).removeClass('active');
		}
	});
	$(document).on('click', '#wpc-aud-ico', function(){
		if( !($(this).hasClass('active') ) ) {
			$('body').find('#msg-aud-tool').slideDown();
			$(this).addClass('active');
			if($('body').find('#wpc-pick-emoji').is(":visible"))
				$('body').find('#wpc-pick-emoji').slideUp();
			if($('body').find('#msg-vid-tool').is(":visible"))
				$('body').find('#msg-vid-tool').slideUp();
			$('body').find('#wpc-pick-sm, #wpc-vid-ico').removeClass('active');
		} else {
			$('body').find('#msg-aud-tool').slideUp();
			$(this).removeClass('active');
		}
	});
	$(document).on('click', '#wpc-img-ico', function(){
		var url = prompt(trans['15']);
		if(url == 0 || url === null || url.indexOf('http') < 0) {
			if(url !== null)
				alert(trans['3']);
			return false;
		}
		var link = prompt(trans['18']);
		if(link && link.indexOf('http') < 0) {
			alert(trans['4']);
			return false;
		}
		var linkV = link == 0 || link === null ? '' : '(link)'+link;
		var code = '[img]'+url+linkV+'[/img]';
  		$('body').find('#message_body').val($('body').find('#message_body').val()+' '+code);
		$('body').find('#message_body').focus();
  		return false;
	});
	$(document).on('click', '#wpc-link-ico', function(){
		var url = prompt(trans['16']);
		if(url == 0 || url === null || url.indexOf('http') < 0 ) {
			if(url !== null)
				alert(trans['5']);
			return false;
		}
		var title = prompt(trans['17']);
		var lTitle = title == 0 || title === null ? '' : '(title)'+title;
		var code = '[link]'+url+lTitle+'[/link]';
  		$('body').find('#message_body').val($('body').find('#message_body').val()+' '+code);
		$('body').find('#message_body').focus();
  		return false;
	});	
	$(document).on('submit', '#msg-vid-tool form', function(event){
		event.preventDefault();
		var value = $('body').find('#msg-vid-tool form input').val();
		if(value==0)
			return false
		var val = value;
		var svc = $('body').find('#msg-vid-tool #provider > span.active').attr('data-service');
		if(svc == "youtube") {
			if(value.indexOf('v=') >= 0)
				val = value.match("v=([a-zA-Z0-9\_\-]+)&?")[1];
		}
		if(svc == "vimeo") {
			if(value.indexOf('.com/') >= 0)
				val = value.split('.com/')[1];
		}
		if(svc == "dailymotion") {
			if(value.indexOf('video/') >= 0) {
				var res = value.substring(value.indexOf('video/')).replace("video/", "");
				val = res.indexOf('_') >= 0 ? res.substring(0,res.indexOf('_')) : res;
			}
		}
		var output 	= $('body').find('#message_body').val()+' ['+svc+']'+val+'[/'+svc+']';
		$('body').find('#message_body').val(output);
		$('body').find('#msg-vid-tool form input').val('');
	});
	$(document).on('click', '#msg-vid-tool #provider > span', function(){
		$(this).parent().children('span').removeClass('active');
		$(this).addClass('active');
		
		if( $(this).attr('data-service') == 'video' )
			$('body').find('#msg-vid-tool input').attr('placeholder', trans['6']);
		else
			$('body').find('#msg-vid-tool input').attr('placeholder', trans['7'].replace('[service]', $(this).attr('title')));
		
		$('body').find('#msg-vid-tool input').focus();
	});

	$(document).on('click', '#msg-aud-tool #provider > span', function(){
		$(this).parent().children('span').removeClass('active');
		$(this).addClass('active');
		var sample = 'Enter a [service] URL';
		if( $(this).attr('data-service') == 'audio' )
			$('body').find('#msg-aud-tool input').attr('placeholder', trans['26']);
		else
			$('body').find('#msg-aud-tool input').attr('placeholder', trans['25'].replace('[service]', $(this).attr('title')));
		
		$('body').find('#msg-aud-tool input').focus();
	});
	$(document).on('submit', '#msg-aud-tool form', function(event){
		event.preventDefault();
		var value = $('body').find('#msg-aud-tool form input').val();
		if(value==0)
			return false
		var val = value;
		var svc = $('body').find('#msg-aud-tool #provider > span.active').attr('data-service');
		if( val.indexOf('http://') <= -1 && val.indexOf('https://') <= -1 ) {
			val = 'http://'+val;
		}
		if( svc == 'beatport' ) {
			val = val.replace( /^\D+/g, '');
		}
		if( svc == 'audio' ) {
			val = val.indexOf('http') >= 0 ? val : 'http://'+val;
		}
		//var hold = false;
		/*if( svc == 'soundcloud' ) {
			hold = true;
			$.get( "http://soundcloud.com/oembed?format=js&url="+val+"&iframe=true", function(data) {
			    data = data.replace(new RegExp("\\\\", "g"), "");
				var Final = data.substring(data.indexOf('src'), data.indexOf('/iframe'));
				Final = decodeURIComponent(Final);
				Final = Final.substring( 5 );
				val = Final.substring( 0, Final.indexOf("\"") );
			})
			.done(function() {
				var output 	= $('body').find('#message_body').val()+' ['+svc+']'+val+'[/'+svc+']';
				$('body').find('#message_body').val(output);
				$('body').find('#msg-aud-tool form input').val('');
				$('body').find('#message_body').change();
			})
			.fail(function() {
				alert('Failed getting soundcloud embed URL. Please try again');
            });
		}**/
		//if( !hold ) {
		var output 	= $('body').find('#message_body').val()+' ['+svc+']'+val+'[/'+svc+']';
		$('body').find('#message_body').val(output);
		$('body').find('#msg-aud-tool form input').val('');
		$('body').find('#message_body').change();
		//}
	});
    $(document).on('click', 'body', function(){
    	setTimeout(function() { $("body").find("#wpcnm").remove(); }, 2000);
    	$('body').find('.newm').removeClass('newm');
    });
	$(document).on("click", '.cancel_notice', function(){
		$(document).find(".wpc_notices").slideUp();
		if( window.location.href.indexOf('&scs') >= 0 || window.location.href.indexOf('?scs') >= 0 ) {
			var term = window.location.href.indexOf('&scs') >= 0 ? '&scs' : '?scs';
			window.history.replaceState( {} , '', window.location.href.substring(0, window.location.href.indexOf(term)) );
		}
	});
	wpcMasonry();
	function wpcMasonry() {
		// masonry view for users cards
		if($('body').find("#wpc-users-cont").length > 0) {
			$items = $('body').find("#wpc-users-cont");
			$items.imagesLoaded(function(){
				$items.masonry({
					itemSelector: '.wpc-user-card',
					columnWidth: 5,
					isOriginLeft: true,
					isOriginTop: true
				});
				if(isRTL) {
					$items.masonry({
						isRTL: true
					});
				}
				$('.wpc-user-card').fadeIn();
			});
			setTimeout( function() { $items.masonry(); }, 100);
			$(window).resize(function () {
				$items.masonry();
			});
		}
	}
});