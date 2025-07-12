jQuery(document).ready(function($){
    var custom_uploader;
    $('body').find('.wpc_uploader').live("click", function(e){
        e.preventDefault();
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('.wpc_uploader_target').val(attachment.url);
            $('#add_smiley #sc').focus();
            $(".wpc_uploader_target").trigger("change");
        });
        custom_uploader.open();
    });
    $('body').find('#user-search').live("keyup", function(){
        var s = $(this).val();
        $('body').find('#users-cont > div').each(function() {
            var key = $(this).data('keyword');
            if( key.indexOf(s) >= 0 ) {
                $(this).slideDown();
            } else {
                $(this).slideUp();
            }
        });
        return false;
    });
    $(document).on('click', '#wpc-add-trans', function(){
            var url = prompt('Please enter a translation URL\n\nFor available translations, you can get this URL from \nhttp://wpchats.samelh.com/translations/\n\nWarning: Please make a record of your own modifications and translations as they will be replaced after you use this feature.');
            if(url == 0 || url === null || url.indexOf('http') < 0) {
                if(url !== null)
                    alert('Please enter a valid URL');
                return false;
            }
            var pageurl = window.location.href;
            if( pageurl.indexOf('&getTrans') < 0 )
                window.location.href = pageurl + '&getTrans='+url; 
            else
                window.location.href = pageurl.substring(0, pageurl.indexOf('&getTrans'))+"&getTrans="+url;
            return false;
            $(document).find('p#status').html('<span>loading translations..</span>');
            $.get( url, function(ret) {
                $.each(ret, function(key,val) {
                    $(document).find('#case-'+key).val(val);
                });
            })
            .done(function() {
                wpc_submit();
                setTimeout( function() {
                    $(document).find('p#status').html('<span class="success">Success!</span>');
                }, 1000);
                setTimeout( function() {
                    $(document).find('form#wpc-trans').slideDown();
                    $('html, body').animate({
                        scrollTop: $("#save-translations").offset().top
                    }, 1000);

                }, 1500);
            })
            .fail(function() {
                $(document).find('p#status').html('<span class="error">Error while retrieving data. Please try again.</span>');
            });
    });
    $(document).on('click', '#start-trans', function(){
        $(document).find('form#wpc-trans').slideDown();
        $('html, body').animate({
            scrollTop: $("form#wpc-trans").offset().top
        }, 1000);
    });
    $(document).on('click', '#wpc-btt', function(e){
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('html').offset().top
        }, 1000);
    });
    $(document).on('click', '#wpc-btb', function(e){
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('#wpfooter').offset().top
        }, 1000);
    });
    var pageurl = window.location.href;
    if( pageurl.indexOf('&getTrans') >= 0 ) {
		var flush = pageurl.substring(0, pageurl.indexOf('&getTrans'));				
		window.history.replaceState( {} , '', flush );
	}

});