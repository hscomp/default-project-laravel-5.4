Project.Components.Ajax = {

    init: function () {

        this.setAjaxSetup();

        this.initGlobalListeners();
    },

    /**
     * Global Ajax setup.
     */
    setAjaxSetup: function () {
        // jQuery
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken}
        });

        //
        window.axios.defaults.headers.common = {
            'X-CSRF-TOKEN': window.Laravel.csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        };

    },

    initGlobalListeners: function () {

        var self = this;

        /**
         * Forms marked with the "data-remote" attribute will submit, via AJAX.
         */
        $(document).on('submit', 'form[data-remote]', function (e) {
            self.submitAjaxRequest($(this), e);
        });

        /**
         *  The "data-click-submits-form" attribute immediately submits the form on change.
         */
        $(document).on('click', '*[data-click-submits-form]', function () {
            $(this).closest('form').submit();
        });

    },

    /**
     * Form ajax handler.
     */
    submitAjaxRequest: function (form, e) {
        var form = $(form);
        var method = form.prop('method');
        var url = form.prop('action');
        var subscribers = form.data('subscribers');
        var data = form.serialize();
        var dataType = form.attr("enctype") == "multipart/form-data"
            ? 'files'
            : '';

        e.preventDefault();

        if (dataType == 'files') {
            var data = new FormData();
            $(form).find('input,select,textarea').each(function () {
                var inp = $(this);
                if (inp[0].files != null) {
                    var _content = inp[0].files[0];
                } else {
                    var _content = inp.val();
                }
                data.append($(this).attr('name'), _content);
            });
        }

        if (form.attr('data-preloader')) {
            Project.Components.AjaxLoader.show(form, form.attr('data-preloader'));
        }

        $.publish(subscribers, {
            _type: 'before'
        });

        $.ajax({
            type: method,
            url: url,
            data: data,
            dataType: 'json',
            contentType: dataType == 'files' ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
            processData: dataType == 'files' ? false : true,
            success: function (data) {
                $.publish(subscribers, {
                    _type: 'done',
                    data: data
                });
                if (typeof data.ajaxResponse != 'undefined') {
                    Project.Components.Ajax.responseHandler(data.ajaxResponse);
                }
            },
            error: function (data) {
                if (form.attr('data-remote')) {
                    Project.Components.FormErrorsHandler.showErrors(data.responseJSON, form);
                }

                $.publish(subscribers, {
                    _type: 'done',
                    data: data.responseJSON
                });

            },
            complete: function () {
                if (form.attr('data-preloader')) {
                    Project.Components.AjaxLoader.hide(form);
                }
            }
        });
    },

    responseHandler: function (data) {

        var stopRedirect = false;

        if (typeof data.alert != 'undefined' && data.alert) {
            stopRedirect = true;
            var alertData = data.alert.data;
            switch (data.alert.driver) {
                case 'swal':
                    swal(alertData)
                        .then(function () {
                            if (typeof data.redirect != "undefined" && data.redirect) {
                                location.href = data.redirect;
                            }
                        }, function (dismiss) {
                            if (typeof data.redirect != "undefined" && data.redirect) {
                                location.href = data.redirect;
                            }
                        });
                    break;
                case 'vex':
                    alertData.afterClose = function () {
                        if (typeof data.redirect != "undefined" && data.redirect) {
                            location.href = data.redirect;
                        }
                    }
                    vex.open(alertData);
                    break;
            }
        }

        if (typeof data.notifications != 'undefined' && data.notifications) {
            stopRedirect = true;
            // @todo Add notification processing
        }

        if (!stopRedirect && typeof data.redirect != "undefined") {
            location.href = data.redirect;
        }

    }
}