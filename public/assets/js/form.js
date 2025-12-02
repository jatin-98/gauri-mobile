$("input[type='submit'], button[type='submit']").click(function (e) {
    e.preventDefault();
    $(".invalid-feedback").text('');

    var form = $(this).closest("form");
    var fields = form.find("select, textarea, input");

    if (validateForm(fields)) {
        form.submit();
    }
});

function validateForm(fields) {
    var isValid = true;

    fields.each(function () {
        var $field = $(this);
        var fieldValue = $field.val();

        if ($field.hasClass('required') && fieldValue === '') {
            showError($field, 'This field is required');
            isValid = false;
        } else if ($field.hasClass('numbers-only') && !isValidNumber(fieldValue)) {
            showError($field, 'Please enter numbers only');
            isValid = false;
        } else if ($field.hasClass('letters-only') && !isValidLetters(fieldValue)) {
            showError($field, 'Please enter letters only');
            isValid = false;
        } else if ($field.hasClass('email-only') && !isValidEmail(fieldValue)) {
            showError($field, 'Please enter a valid email address');
            isValid = false;
        } else {
            $field.removeClass('is-invalid');
        }
    });

    return isValid;
}

function showError(field, message) {
    field.addClass('is-invalid');
    field.siblings('.invalid-feedback').text(message);
}

function isValidNumber(value) {
    return /^\d+$/.test(value);
}

function isValidLetters(value) {
    return /^[A-Za-z\s]+$/.test(value.trim());
}

function isValidEmail(value) {
    // A simple email validation regex pattern
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(value);
}