
$(function() {
    $('.banner').hover(function() {
        $('ul.bjqs-controls , ol.bjqs-markers').stop(true, true).fadeIn();
    }, function() {
        $('ul.bjqs-controls , ol.bjqs-markers').stop(true, true).fadeOut();
    });
// nev Menu
    $('nav ul li').hover(function() {
        $(this).children('ol').stop(true, true).fadeIn('normal');
        $(this).children('a').css({'color': '#FA7000'});
    }, function() {
        $(this).children('ol').stop(true, true).fadeOut('normal');
        $(this).children('a').css({'color': '#959595'});
    });


    $('.bticino_logo, .legrand_logo').hover(function() {
        $(this).css({'background-position': '0px 0px'});
    }, function() {
        $(this).css({'background-position': '0px -29px'});
    });

    $('.rs-btn').click(function() {
        $('nav ul').stop(true, true).slideToggle();
    });

    $('.social_media ul li').hover(function() {
        $(this).stop(true, true).css({'background': '#FA7000'});
        $(this).children('a').stop(true, true).css({'color': 'white'});
    }, function() {
        $(this).stop(true, true).css({'background': 'white'});
        $(this).children('a').stop(true, true).css({'color': '#FA7000'});
    });

    if ($(window).innerWidth() <= 768) {
        $('nav ul li').click(function() {
            $(this).children('ol').stop(true, true).slideToggle('normal');
        });
    }
});
