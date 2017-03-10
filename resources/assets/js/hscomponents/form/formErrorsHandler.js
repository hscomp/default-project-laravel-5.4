Project.Components.FormErrorsHandler = {

    scrollDuration: 400,
    scrollBeforeFixedNav: 30,

    init: function () {
        this.initScrollToError();
    },

    initScrollToError: function () {
        if ($('body').find('.has-error').length > 0) {
            var $errorSelector = $('body').find('.has-error:first');
            this.scrollToElem($errorSelector);
        }
    },

    showErrors: function (errors, form) {

        this.removeErrors(form);

        $.each(errors, function (name, messages) {

            fieldElement = form.find('#' + name + '_field');
            fieldElementRoot = form.find('#' + name + '_field_root');

            if (Server.appConfig.debug) {
                console.log('Error: ' + name + ' - ' + messages[0]);
            }

            if (fieldElement[0]) {

                if (fieldElement[0].tagName.toUpperCase() == 'DIV') {
                    fieldElement.append('<p class="help-block alert alert-danger">' + messages[0] + '</p>');
                }
                else {
                    fieldElement.parent().addClass('has-error');
                    fieldElement.after('<p class="help-block alert alert-danger">' + messages[0] + '</p>');
                }

                if (fieldElementRoot[0]) {
                    fieldElementRoot.addClass('has-error');
                }
            }
        });

        this.scrollToElem($('#' + Object.keys(errors)[0] + '_field'));
    },

    scrollToElem: function ($elem) {
        if ($elem.closest('.swal2-container').length == 0) {
            var diff = ( $('#soccer-tourney-management-wrapper .navbar-static-top').length > 0 ? $('#soccer-tourney-management-wrapper .navbar-static-top').height() + this.scrollBeforeFixedNav : 0 );
            var scrollPos = $elem.offset().top - diff;
            $('html, body').animate({
                scrollTop: scrollPos
            }, {
                duration: this.scrollDuration,
                complete: function () {
                    var $errorBox = $elem.parent();
                    $errorBox.addClass('flash animated');
                }
            });
        }
    },

    unmarkInvalid: function ($elem) {
        var $inputBox = $elem.parent();
        if ($inputBox.hasClass('has-error')) {
            $inputBox.removeClass('has-error');
        }

        var $inputBoxAlert = $inputBox.find('.help-block');
        if ($inputBoxAlert.length > 0) {
            $inputBoxAlert.remove();
        }
    },

    markInvalid: function ($elem, message) {
        if ($elem.length > 0) {
            if (!$elem.parent().hasClass('has-error')) {
                $elem.parent().addClass('has-error');
                if ($elem.parent().find('help-block').length > 0) {
                    $elem.parent().find('help-block').text(message);
                } else {
                    $elem.parent().append('<p class="help-block alert alert-danger">' + message + '</p>');
                }
            }
            $elem.parent().removeClass('flash animated');
            this.scrollToElem($elem);
            $elem.focus();
        }
    },

    removeErrors: function (form) {
        $(form).find('.help-block, .alert, .alert-danger').remove();
        $(form).find('.has-error').removeClass('has-error');
    },
}
