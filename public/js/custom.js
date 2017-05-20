//Header
	$(window).scroll(function() {    
		var scroll = $(window).scrollTop();
		if (scroll >= 70) {
			$(".navbar").addClass("dark-header");
		}
		if (scroll <= 69) {
			$(".navbar").removeClass("dark-header");
		}												
	});
	//Burger Menu
	$(document).ready(function () {
		$(".burger").click(function () {
			$("#mobile-menu").addClass("display-menu");
			$("#overley").addClass("display-overley");
			$("#close-menu").addClass("display-close-menu");
			$("#image-list").addClass("fixed-il");
			$('.pagination').css('display','none');
		});
		$("#close-menu, #overley").click(function () {
			$("#close-menu").attr('class', '');
			$("#mobile-menu").attr('class', '');
			$("#overley").attr('class', '');
			$("#image-list").attr('class', '');
			$('.pagination').css('display','block');
		});
	});
	//Fix categories after scroll
	if($('.fixme').length) {
        var fixmeTop = $('.fixme').offset().top;
        $(window).scroll(function () {
            var currentScroll = $(window).scrollTop() + 70;
            if (currentScroll >= fixmeTop) {
                $('.fixme').css({
                    position: 'fixed',
                    top: '70px',
                    left: '0'
                });
            } else {
                $('.fixme').css({
                    position: 'static',
                });
                $(".fixme").addClass("aaa");
            }
        });
    }
	//Tooltip
	$('[data-toggle="tooltip"]').tooltip();