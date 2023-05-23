/**
 * Cleans all feedback elements from the page
 */
function cleanFormFeedback() {
	$(".invalid-feedback").removeClass('d-block');
    $(".form-control").removeClass('is-invalid');
    $(".valid-feedback").removeClass('d-block');
    $(".form-control").removeClass('is-valid');
}

function centerInput(feedbackId) {
    $([document.documentElement, document.body]).animate({
        scrollTop: $('#' + feedbackId).offset().top - screen.height/2
    }, 1000);
}

/**
 * Handles an incomming error response from an Ajax request
 * 
 * Displays invalid colors in input fields
 * Displays the returned error message if there is a div with the same id as the
 * input field but with "_fb" at the end, such as "in_name_fb" (the input field is "in_name")
 *
 * NOTE: Input Ids must be exactly the same as validation field names in controller
 */
function handleRequestErrors(err) {
    // We only care about 422 errors (validation errors)
    if (err.status == 422 && err.responseJSON != undefined && err.responseJSON.errors != undefined) {

        var firstError = null;

        // Cycling through all errors
        for (var input_id in err.responseJSON.errors) {
            $('#' + input_id).addClass('is-invalid');
            $('#' + input_id + '_fb').addClass('d-block');
            $('#' + input_id + '_fb').empty();
            $('#' + input_id + '_fb').append(err.responseJSON.errors[input_id]);
            
            if (firstError == null) { // keeping first error so we center it after this
                firstError = input_id;
            }
        }

        // centering only first error
        if (firstError != null) {
            centerInput(firstError);
        }

    }
}


/**
 * Checks if the given input has a value
 * @param { id } inputId 
 * @param { id } feedbackId 
 * @returns {boolean} true if the element is empty
 */
function isEmpty(inputId, feedbackId) {
    if (!$('#' + inputId).val() || !$('#' + inputId).val().replace(/\s/g, '').length) {
        $('#' + inputId).addClass('is-invalid');
        $('#' + feedbackId).addClass('d-block');

        centerInput(feedbackId);
        return true;

    } else {
        return false;
    }
}

/**
 * Checks if the passed text input respects a minimum number of characters
 * @param { $(#'id') } inputElement 
 * @param { $(#'id') } feedbackElement 
 * @param {int} min: the minimum number of characters for the text input
 * @returns boolean true if the element is invalid
 */
function isNotAtLeast(min, inputId, feedbackId) {
    if ( $('#' + inputId).val().replace(/\s/g, '').length < min ) {
        $('#' + inputId).addClass('is-invalid');
        $('#' + feedbackId).addClass('d-block');

        centerInput(feedbackId);
        return true;

    } else {
        return false;
    }
}

/**
 * Checks if the passed number input has a minimum value of "min"
 * @param { $(#'id') } inputElement 
 * @param { $(#'id') } feedbackElement 
 * @param {int} min: the minimum value of the number input
 * @returns boolean true if the element is invalid
 */
function isNotMin(min, inputId, feedbackId) {
    if ( $('#' + inputId).val() < min ) {
        $('#' + inputId).addClass('is-invalid');
        $('#' + feedbackId).addClass('d-block');

        centerInput(feedbackId);
        return true;

    } else {
        return false;
    }
}

function isInvalidEmail(inputId, feedbackId) {

    var emailFormula = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

    if ( emailFormula.test($('#' + inputId).val()) ) {

        return false;

    } else {
        $('#' + inputId).addClass('is-invalid');
        $('#' + feedbackId).addClass('d-block');

        centerInput(feedbackId);
        return true;
    }
}
