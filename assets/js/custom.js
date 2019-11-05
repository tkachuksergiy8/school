(function ($) {
    "use strict"; // Start of use strict

    // Toggle the side navigation
    $("#sidebarToggle").on('click', function (e) {
        e.preventDefault();
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
    });

    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
        if ($(window).width() > 768) {
            var e0 = e.originalEvent,
                    delta = e0.wheelDelta || -e0.detail;
            this.scrollTop += (delta < 0 ? 1 : -1) * 30;
            e.preventDefault();
        }
    });

    // Scroll to top button appear
    $(document).on('scroll', function () {
        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });

    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function (event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        event.preventDefault();
    });

})(jQuery); // End of use strict

$(document).ready(function () {
    $('#dataTable').DataTable();
});

(function () {
    var webcamButton = document.getElementById('webcamButton');

    if (webcamButton) {
        var booth = document.getElementById('booth'),
            video = document.getElementById('video'),
            canvas = document.getElementById('canvas'),
            context = canvas.getContext('2d'),
            photo = document.getElementById('teacher_profile_base64_photo'),
            vendorUrl = window.URL || window.webkitURL;

        webcamButton.addEventListener('click', function () {
            if (webcamButton.getAttribute('value') === 'Take a photo') {
                webcamButton.setAttribute('value', 'Close');
                booth.style.display = 'block';


                navigator.getMedia = navigator.getUserMedia ||
                    navigator.webkitGetUserMedia ||
                    navigator.mozGetUserMedia ||
                    navigator.msGetUserMedia;

                navigator.getMedia({
                    video: true,
                    audio: false
                }, function (stream) {
                    video.src = vendorUrl.createObjectURL(stream);
                    video.play();
                }, function (error) {

                });

                document.getElementById('capture').addEventListener('click', function () {
                    context.drawImage(video, 0, 0, 400, 300);
                    photo.setAttribute('value', canvas.toDataURL('img/png'));
                })
            } else {
                webcamButton.setAttribute('value', 'Take a photo');
                booth.style.display = 'none';
                photo.setAttribute('value', '');
            }
        });
    }
})();

