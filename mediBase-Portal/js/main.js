(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });


    // Calendar
    $('#calendar').datetimepicker({
        inline: true,
        format: 'L'
    });

    
})(jQuery);



// POPUPS
document.addEventListener('DOMContentLoaded', function() {
    // Function to open a popup
    function openPopup(popupId) {
        var popup = document.getElementById(popupId);
        if (popup) {
            popup.style.display = 'block';
        }
    }

    // Function to close a popup
    function closePopup(popupId) {
        var popup = document.getElementById(popupId);
        if (popup) {
            popup.style.display = 'none';
        }
    }

    // Attach event listeners to open popup buttons
    var openPopupButtons = document.querySelectorAll('.openPopupBtn');
    openPopupButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var popupId = btn.getAttribute('data-popup-target');
            openPopup(popupId);
        });
    });

    // Attach event listeners to close buttons in each popup
    var closeButtons = document.querySelectorAll('.popup .close');
    closeButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            btn.closest('.popup').style.display = 'none';
        });
    });

    // Close popup when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('popup')) {
            event.target.style.display = 'none';
        }
    });

    // Close popup when pressing the Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.popup').forEach(function(popup) {
                popup.style.display = 'none';
            });
        }
    });
});
