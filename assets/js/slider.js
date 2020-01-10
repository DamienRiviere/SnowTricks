const btnDisplay = document.getElementById("display-media");

btnDisplay.addEventListener("click", function () {
    $("#slider").attr("style", "display: block !important");
});

$('.slider').slick({
    centerMode: true,
    centerPadding: "60px",
    slidesToShow: 3,
    variableWidth: true,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
    },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
    },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
    }
    ]
});