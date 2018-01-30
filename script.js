	
function colapseMenu(sub)
{
	if((sub != '.sub1') && ($('.sub1').is(':visible'))) {
		$('.sub1').slideUp();
	};
	if((sub != '.sub2') && ($('.sub2').is(':visible'))) {
		$('.sub2').slideUp();
	};
	if((sub != '.sub3') && ($('.sub3').is(':visible'))) {
		$('.sub3').slideUp();
	};
	if((sub != '.sub3') && ($('.sub3').is(':visible'))) {
		$('.sub3').slideUp();
	};
	if((sub != '.sub4') && ($('.sub4').is(':visible'))) {
		$('.sub4').slideUp();
	};
	$(sub).slideDown();
}
	
	
$(function() {
	$('#expandSumm').click(function(){
	$('.sub1').slideToggle();
	});	
});



$(function() {
	$('#expandCath').click(function(){
	$('.sub2').slideToggle();
	});	
});	



$(function() {
	$('#expandMeth').click(function(){
	$('.sub3').slideToggle();
	});	
});

$(function() {
	$('#expandExps').click(function(){
	$('.sub4').slideToggle();
	});	
});

function changeContent(fadeInDiv, fadeOutDiv_1, fadeOutDiv_2, hideDiv_1) {
	if ($(hideDiv_1).css('display') != 'none') {
		$(hideDiv_1).css('display', 'none');
	}
	if($(fadeInDiv).css('display') == 'none')
	{
		if($(fadeOutDiv_1).css('display') != 'none') {
			$(fadeOutDiv_1).fadeOut((500), function() {
				$(fadeOutDiv_1).css('display', 'none');
				$(fadeInDiv).fadeIn(500);
				$(fadeInDiv).css('display', 'block');
			});
			
		} else if($(fadeOutDiv_2).css('display') != 'none') {
			$(fadeOutDiv_2).fadeOut((500), function(){
				$(fadeOutDiv_2).css('display', 'none');
				$(fadeInDiv).fadeIn(500);
				$(fadeInDiv).css('display', 'block');
			});
			
		} else {
			$(fadeInDiv).fadeIn(500);
			$(fadeInDiv).css('display', 'block');
		}
	}
};
	
	
	function changeContent_2(fadeInDiv, fadeOutDiv_1, fadeOutDiv_2, fadeOutDiv_3, hideDiv_1) {
	if ($(hideDiv_1).css('display') != 'none') {
		$(hideDiv_1).css('display', 'none');
	}
	if($(fadeInDiv).css('display') == 'none')
	{
		if($(fadeOutDiv_1).css('display') != 'none') {
			$(fadeOutDiv_1).fadeOut((500), function() {
				$(fadeOutDiv_1).css('display', 'none');
				$(fadeInDiv).fadeIn(500);
				$(fadeInDiv).css('display', 'block');
			});
			
		} else if($(fadeOutDiv_2).css('display') != 'none') {
			$(fadeOutDiv_2).fadeOut((500), function(){
				$(fadeOutDiv_2).css('display', 'none');
				$(fadeInDiv).fadeIn(500);
				$(fadeInDiv).css('display', 'block');
			});
			
		} else if($(fadeOutDiv_3).css('display') != 'none') {
		$(fadeOutDiv_3).fadeOut((500), function(){
			$(fadeOutDiv_3).css('display', 'none');
			$(fadeInDiv).fadeIn(500);
			$(fadeInDiv).css('display', 'block');
		});
		} else {
			$(fadeInDiv).fadeIn(500);
			$(fadeInDiv).css('display', 'block');
		}
	}
};