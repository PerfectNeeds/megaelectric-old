$.fn.slider = function(options) {

    var sliderCount = null;
    var sliderCurrent = 0;

    var settings = $.extend({
        timer: 15000,
        bullet: true,
        pause: false,
        nextPrev: false,
        stopSliderOnHover: true,
        showBulletOnHover: true,
        debug: true,
    }, options);

    $this = $(this);
    $thisClass = $(this).attr('class');
    sliderCount = $("." + $thisClass + " div").length;
    var sliderAction = setInterval("rotateImages()", settings.timer);

    if (sliderCount > 0)
    {
        $("." + $thisClass + " div").eq(sliderCurrent).css({zIndex: 3}).animate({opacity: 1}, 1000);
    }

    if (sliderCount === 1)
    {
        clearInterval(sliderAction);
    }

    // Bullets Controller
    if (settings.bullet === true && sliderCount > 1)
    {
        // Generate Bullets 
        $("." + $thisClass).append('<p class="button"></p>');
		$("." + $thisClass + ' p.button').append('<span class="prev_arrow"></span>');
        for (var i = 0; i < sliderCount; i++) {
            $("." + $thisClass + ' p.button').append('<span class="bullet"></span>');
        }
        $('.' + $thisClass + ' .button .bullet').eq(0).addClass('hover');
        if (settings.debug === true) {
            console.log('Bullet: Generate');
        }
		$("." + $thisClass + ' p.button').append('<span class="next_arrow"></span>');

        // Show Bullets On hover
        if (settings.showBulletOnHover === true) {
            $('header').hover(function() {
                $('.button').stop(true, true).fadeIn('normal');
            }, function() {
                $('.button').stop(true, true).fadeOut('normal');
            });

            if (settings.debug === true) {
                console.log('Bullet: Show bullets on over slider');
            }
        }

        // Stop Bullets On hover
        if (settings.stopSliderOnHover === true) {
            $('header').hover(function() {
                if (settings.debug === true) {
                    console.log('Bullet: Stop hover');
                }
                clearInterval(sliderAction);
            });

            $('header').mouseleave(function() {
                if (sliderCount <= 1) {
                    clearInterval(sliderAction);
                } else {
                    sliderAction = setInterval("rotateImages()", settings.timer);
                }
                if (settings.debug === true) {
                    console.log('Bullet: Run');
                }
            });

            if (settings.debug === true) {
                console.log('Bullet: Stop bullets on over slider');
            }
        }

        $('.' + $thisClass + ' .button .bullet').click(function() {
            bulletPostion = $('span').index($(this));
            $("." + $thisClass + " div").eq(sliderCurrent).css({zIndex: 3}).animate({opacity: 0.0}, 1000);
            $('.' + $thisClass + ' .button .bullet').eq(sliderCurrent).removeClass('hover');

            $('.' + $thisClass + ' .button .bullet').eq(bulletPostion).addClass('hover');
            $("." + $thisClass + " div").eq(bulletPostion).css({zIndex: 1}).animate({opacity: 1}, 1000);
            if (settings.debug === true) {
                console.log('Bullet: show slider index:' + bulletPostion + ' hide index:' + sliderCurrent);
            }
            sliderCurrent = bulletPostion;
            clearInterval(sliderAction);
            sliderAction = setInterval("rotateImages()", settings.timer);

        });
    }

    rotateImages = function() {
        next();
        if (settings.debug === true) {
            console.log('Bullet: rotateImages()');
        }
    };

    $('.nextbtn').click(function() {
        rotateImages();
        if (settings.debug === true) {
            console.log('Bullet: next Button');
        }
    });
    $('.prevbtn').click(function() {
        prev();
        if (settings.debug === true) {
            console.log('Bullet: perv Button');
        }
    });

    var next = function() {
        clearInterval(sliderAction);
        sliderAction = setInterval("rotateImages()", settings.timer);
        $("." + $thisClass + " div").eq(sliderCurrent).css({zIndex: 3}).animate({opacity: 0.0}, 1000);
        $('.' + $thisClass + ' .button .bullet').eq(sliderCurrent).removeClass('hover');
        if (sliderCurrent + 1 == sliderCount) {
            sliderCurrent = 0;
        }
        else {
            sliderCurrent++;
        }
        $('.' + $thisClass + ' .button .bullet').eq(sliderCurrent).addClass('hover');
        $("." + $thisClass + " div").eq(sliderCurrent).css({zIndex: 1}).animate({opacity: 1}, 1000);
    };
    var prev = function() {
        $("." + $thisClass + " div").eq(sliderCurrent).css({zIndex: 3}).animate({opacity: 0}, 1000);
        $('.' + $thisClass + ' .button .bullet').eq(sliderCurrent).removeClass('hover');
        if (sliderCurrent == 0) {
            sliderCurrent = sliderCount - 1;
        }
        else {
            sliderCurrent--;
        }
        $('.' + $thisClass + ' .button .bullet').eq(sliderCurrent).addClass('hover');
        $("." + $thisClass + " div").eq(sliderCurrent).css({zIndex: 1}).animate({opacity: 1}, 1000);
    };

	$('.next_arrow').click(function(){
		next();
	});
	
	$('.prev_arrow').click(function(){
		prev();
	});
    $(document).keyup(function(event) {
        switch (event.which)
        {
            case 37:
                prev();
                break;
            case 39:
                next();
                break;
        }
    });
};