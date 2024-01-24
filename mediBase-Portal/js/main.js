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
            document.body.classList.add('no-scroll');
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
            document.body.classList.remove('no-scroll');
        });
    });

    // Close popup when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('popup')) {
            event.target.style.display = 'none';
            document.body.classList.remove('no-scroll');
        }
    });

    // Close popup when pressing the Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.popup').forEach(function(popup) {
                popup.style.display = 'none';
                document.body.classList.remove('no-scroll');
            });
        }
    });
});


// EDIT PATIENT'S INFO
document.addEventListener('DOMContentLoaded', function () {
    function setupEditToggle(editButtonId, fieldsSelector) {
        var editButton = document.getElementById(editButtonId);
        var editableFields = document.querySelectorAll(fieldsSelector);
        
        var isEditable = false;
        var isEdited = false;

        function fieldEdited() {
            if (!isEdited) {
                isEdited = true;
                editButton.textContent = 'Save Changes';
            }
        }

        // Adding input event listener to each field
        editableFields.forEach(function(field) {
            if (field.tagName === 'SELECT') {
                // For select elements
                field.disabled = true; // Initially disabled
                field.addEventListener('change', fieldEdited);
            } else {
                // For other editable fields
                field.addEventListener('input', fieldEdited);
            }
        });

        editButton.addEventListener('click', function() {
            if (isEditable) {
                // Switching from editable to non-editable
                if (isEdited) {
                    // TODO: Handle data update
                    console.log('Save data for', editButtonId);
                    isEdited = false;
                }
                editableFields.forEach(function(field) {
                    if (field.tagName === 'SELECT') {
                        field.disabled = true;
                    } else {
                        field.contentEditable = false;
                    }
                });
                this.textContent = 'Edit Info';
            } else {
                // Switching from non-editable to editable
                editableFields.forEach(function(field) {
                    if (field.tagName === 'SELECT') {
                        field.disabled = false;
                    } else {
                        field.contentEditable = true;
                    }
                });
                this.textContent = isEdited ? 'Save Changes' : 'Edit Info';
            }

            isEditable = !isEditable;
        });
    }

    // Setup for Patient Info Edit Button
    setupEditToggle('editPatientInfoBtn', '.patient-editable-field');

    // Setup for Doctor Info Edit Button
    setupEditToggle('editDoctorInfoBtn', '.doctor-editable-field');
});


/* document.addEventListener('DOMContentLoaded', function () {
    // Function to handle edit toggle
    function setupEditToggle(editButtonId, fieldsSelector) {
        var editButton = document.getElementById(editButtonId);
        var editableFields = document.querySelectorAll(fieldsSelector);
        
        var isEditable = false;
        var isEdited = false;

        // Function to set isEdited to true
        function fieldEdited() {
            if (!isEdited) {
                isEdited = true;
                editButton.textContent = 'Save Changes';
            }
        }

        // Adding input event listener to each field
        editableFields.forEach(function(field) {
            field.addEventListener('input', fieldEdited);
        });

        // Toggle contenteditable attribute for all editable fields
        editButton.addEventListener('click', function() {
            if (isEditable) {
                // Switching from editable to non-editable
                if (isEdited) {
                    // TODO: Handle data update
                    console.log('Save data for', editButtonId);
                    isEdited = false;
                }
                editableFields.forEach(function(field) {
                    field.contentEditable = false;
                });
                this.textContent = 'Edit Info';
            } else {
                // Switching from non-editable to editable
                editableFields.forEach(function(field) {
                    field.contentEditable = true;
                });
                this.textContent = isEdited ? 'Save Changes' : 'Edit Info';
            }

            isEditable = !isEditable;
        });
    }

    // Setup for Patient Info Edit Button
    setupEditToggle('editPatientInfoBtn', '.patient-editable-field');

    // Setup for Doctor Info Edit Button
    setupEditToggle('editDoctorInfoBtn', '.doctor-editable-field');
}); */
