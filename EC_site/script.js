$(document).ready(function(){
    $('.slider').slick({
        autoplay: true,
        autoplaySpeed: 3000,
        dots: true, // 下にドット表示
        arrows: true, // 左右の矢印
        fade: false, // フェード切り替え
        speed: 800,
        cssEase: 'linear'
    });
});
