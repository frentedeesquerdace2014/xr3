jQuery.noConflict();

/* Filled when a form is clicked and No! The user *CAN'T* select more
 * than one form at the same time. */
var SELECTED_P = null;

/* Function to validate comment form */
function validateForm (formObj) {
    var counter = 0;
    jQuery('.required', formObj).each (
        function () {
            if (jQuery.trim(jQuery(this).val()) == '') {
                jQuery(this).css('borderColor', 'red');
                jQuery(this).focus();
                counter++;
            } else {
                jQuery(this).css('borderColor', '');
            }
        }
    );

    return (counter == 0);
}

jQuery(document).ready (
    function () {
        /* Setting up comment textareas */
        jQuery('.comment-pp p').click (
            function () {
                var parent = jQuery(this).parent();
                var obj = jQuery('div.comment-form', parent);
                var shouldShow = obj.css('display') == 'none';

                /* Fixing a possible changed opacity */
                //jQuery('form', obj).css('opacity', 1);

                /* Caching selected form. It's very useful to handle
                 * ui interaction after posting this form. */
                SELECTED_P = parent;

                /* Time to toggle display state of the selected form
                 * and focus its main textarea */
                if (shouldShow)
                    obj.fadeIn();
                else
                    obj.fadeOut();
                jQuery('textarea.comment', parent).focus();
            }
        );

        /* Setting up comment forms */
        var optCommentForm = {
            dataType: 'html',

            beforeSubmit: function (data, formObj, options) {
                var valid = validateForm(formObj);
                if (valid) {
                    formObj.parent().css('height', '60px');
                    jQuery('div.loading', formObj).show();
                }
                return valid;
            },

            success: function (response, responseText) {
                var p = SELECTED_P;
                var form = jQuery('form', p);
                var msg = jQuery('div.message', p);

                /* Everything worked fine, let's reset field values */
                jQuery('textarea', form).val('');
                jQuery('input[type=text]', form).val('');
                jQuery('div.comment-form', p).css('height', 'auto');
                jQuery('div.comment-form', p).hide();
                jQuery('div.loading', form).hide();

                /* Time to inform to the user that everything worked */
                msg.html('Obrigado por contribuir com o seu comentário');
                msg.fadeIn();
                window.setTimeout(function () { msg.fadeOut('slow'); }, 10000);
            },

            error: function (xhr, err) {
                var p = SELECTED_P;
                var msg = jQuery('div.message', p);

                jQuery('div.loading', p).hide();
                jQuery('div.comment-form', p).css('height', 'auto');

                msg.html("Ocorreu um erro ao tentar postar o seu comentário =(");
                msg.fadeIn();
                window.setTimeout(function () { msg.fadeOut('slow'); }, 10000);
            }
        };
        jQuery('div.comment-form form').ajaxForm(optCommentForm);

        /* Setting up new-text checkbutton behaviour */
        jQuery('input[name=new_text_check]').click (
            function () {
                var parent = jQuery(this).parent();
                jQuery('textarea.newText', parent).toggle().focus();
            }
        );
    }
);


function dialogue_expand_comment(id, text) {
    jQuery("#comment-area-"+id).toggle();
    jQuery("#comment-full-"+id).toggle();
}
