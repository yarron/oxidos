$(document).ready(function() {
    /* Search */
	$('.searchform').on('click','.icon-search',function() {
		url = $('base').attr('href') + 'search/filter_name/';
				 
		var search = $('input[name=\'filter_name\']').val();
	
		if (search) {
			url += encodeURIComponent(search);
		}
		
		location = url;
	});
	
	$('.searchform ').on('keydown','input[name=\'filter_name\']',function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'search/filter_name/';
			 
			var search = $('input[name=\'filter_name\']').val();
			
			if (search) {
				url += encodeURIComponent(search);
			}
			
			location = url;
		}
	});   
    /* End Search */   
    
    $('.success, .warning, .attention, .information').on('click', 'img',function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});	
    
    /* Colorbox */    
    $('.colorbox').colorbox({
        overlayClose: true,
        opacity: 0.5
    });
    /* End Colorbox */    
        
    /* Mega Menu */
	$('#menu ul > li > a + div').each(function(index, element) {
		
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();
		
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());
		
		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});  
});
    
/* Message */    
function ShowLoading(text)
{
    text&&$("#loading-layer").html(text);
    var width = ($(window).width()-$("#loading-layer").width())/2;
    var height = ($(window).height()-$("#loading-layer").height())/2;
    $("#loading-layer").css({left:width+"px",top:height+"px",position:"fixed",zIndex:"99"});
    $("#loading-layer").fadeTo('slow',0.6);
}
function ShowMessage(message)
{
    message&&$("#loading-layer").html(message);
    var width = ($(window).width()-$("#loading-layer").width())/2;
    var height = ($(window).height()-$("#loading-layer").height())/2;
    $("#loading-layer").css({left:width+"px",top:height+"px",position:"fixed",zIndex:"99"});
    $("#loading-layer").fadeTo(2000,0.6);
}
function HideLoading(){
    $("#loading-layer").fadeOut("slow");
}
/* End Message */  