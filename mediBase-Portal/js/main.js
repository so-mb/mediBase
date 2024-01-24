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
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
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
document.addEventListener('DOMContentLoaded', function () {
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
    openPopupButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var popupId = btn.getAttribute('data-popup-target');
            openPopup(popupId);
        });
    });

    // Attach event listeners to close buttons in each popup
    var closeButtons = document.querySelectorAll('.popup .close');
    closeButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.closest('.popup').style.display = 'none';
            document.body.classList.remove('no-scroll');
        });
    });

    // Close popup when clicking outside of it
    window.addEventListener('click', function (event) {
        if (event.target.classList.contains('popup')) {
            event.target.style.display = 'none';
            document.body.classList.remove('no-scroll');
        }
    });

    // Close popup when pressing the Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.popup').forEach(function (popup) {
                popup.style.display = 'none';
                document.body.classList.remove('no-scroll');
            });
        }
    });
});


// // EDIT INFO
// document.addEventListener('DOMContentLoaded', function () {
//     function setupEditToggle(editButtonId, fieldsSelector) {
//         var editButton = document.getElementById(editButtonId);
//         var editableFields = document.querySelectorAll(fieldsSelector);

//         var isEditable = false;
//         var isEdited = false;

//         function fieldEdited() {
//             if (!isEdited) {
//                 isEdited = true;
//                 editButton.textContent = 'Save Changes';
//             }
//         }

//         // Adding input event listener to each field
//         editableFields.forEach(function(field) {
//             if (field.tagName === 'SELECT') {
//                 // For select elements
//                 field.disabled = true; // Initially disabled
//                 field.addEventListener('change', fieldEdited);
//             } else {
//                 // For other editable fields
//                 field.addEventListener('input', fieldEdited);
//             }
//         });

//         editButton.addEventListener('click', function() {
//             if (isEditable) {
//                 // Switching from editable to non-editable
//                 if (isEdited) {
//                     // TODO: Handle data update
//                     console.log('Save data for', editButtonId);
//                     isEdited = false;
//                 }
//                 editableFields.forEach(function(field) {
//                     if (field.tagName === 'SELECT') {
//                         field.disabled = true;
//                     } else {
//                         field.contentEditable = false;
//                     }
//                 });
//                 this.textContent = 'Edit Info';
//             } else {
//                 // Switching from non-editable to editable
//                 editableFields.forEach(function(field) {
//                     if (field.tagName === 'SELECT') {
//                         field.disabled = false;
//                     } else {
//                         field.contentEditable = true;
//                     }
//                 });
//                 this.textContent = isEdited ? 'Save Changes' : 'Edit Info';
//             }

//             isEditable = !isEditable;
//         });
//     }

//     // Setup for Patient Info Edit Button
//     setupEditToggle('editPatientInfoBtn', '.patient-editable-field');

//     // Setup for Doctor Info Edit Button
//     setupEditToggle('editDoctorInfoBtn', '.doctor-editable-field');
// });

/* // EDIT INFO
document.addEventListener('DOMContentLoaded', function () {
    function setupEditToggle(editButtonId, formSelector) {
        var editButton = document.getElementById(editButtonId);
        var form = document.querySelector(formSelector);
        var inputs = form.querySelectorAll('input, select');

        var isEditable = false;
        var isEdited = false;

        function fieldEdited() {
            if (!isEdited) {
                isEdited = true;
                editButton.textContent = 'Save Changes';
            }
        }

        // Adding input/change event listener to each field
        inputs.forEach(function (input) {
            input.disabled = true; // Initially disabled
            input.addEventListener(input.tagName === 'SELECT' ? 'change' : 'input', fieldEdited);
        });

        editButton.addEventListener('click', function () {
            if (isEditable) {
                // Switching from editable to non-editable
                if (isEdited) {
                    // TODO: Submit form or handle data update
                    console.log('Save data for', editButtonId);
                    form.submit(); // Submit the form
                    isEdited = false;
                }
                inputs.forEach(function (input) {
                    input.disabled = true;
                });
                this.textContent = 'Edit Info';
            } else {
                // Switching from non-editable to editable
                inputs.forEach(function (input) {
                    input.disabled = false;
                });
                this.textContent = isEdited ? 'Save Changes' : 'Edit Info';
            }

            isEditable = !isEditable;
        });
    }

    // Setup for Patient Info Edit Button
    setupEditToggle('editPatientInfoBtn', '#patientInfoPopup form');

    // Additional setups for other forms can be added in a similar way
});

 */

// EDIT INFO
document.addEventListener('DOMContentLoaded', function () {
    function setupEditToggle(editButtonId, formSelector) {
        var editButton = document.getElementById(editButtonId);
        var form = document.querySelector(formSelector);
        var inputs = form.querySelectorAll('input, select');

        var isEditable = false;

        function makeFieldsEditable(editable) {
            inputs.forEach(function (input) {
                if (!input.classList.contains('non-editable')) {
                    input.disabled = !editable;
                }
            });
            editButton.textContent = editable ? 'Update Info' : 'Edit Info';
            isEditable = editable;
        }


        // Initially, make fields not editable
        makeFieldsEditable(false);

        // Adding input/change event listener to each field
        inputs.forEach(function (input) {
            input.addEventListener(input.tagName === 'SELECT' ? 'change' : 'input', function () {
                if (!isEditable) {
                    makeFieldsEditable(true);
                }
            });
        });

        editButton.addEventListener('click', function () {
            if (isEditable) {
                // Submit form or handle data update
                console.log('Submit data for', editButtonId);
                form.submit(); // Submit the form
            } else {
                // Make fields editable
                makeFieldsEditable(true);
            }
        });
    }

    // Setup for Patient Info Edit Button
    setupEditToggle('editPatientInfoBtn', '#patientInfoPopup form');
    setupEditToggle('editDoctorInfoBtn', '#doctorInfoPopup form');

    // Additional setups for other forms can be added in a similar way
});

editButton.addEventListener('click', function (event) {
    event.preventDefault(); // Prevents default form submission behavior

    if (isEditable) {
        // Submit form or handle data update
        console.log('Submit data for', editButtonId);
        form.submit(); // Only submit the form here
    } else {
        // Make fields editable
        makeFieldsEditable(true);
    }
});
