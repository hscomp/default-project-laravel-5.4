Project.Components.Ajax = {

    init: function() {

        this.setAjaxSetup();

        this.initGlobalListeners();
    },

    /**
     * Global Ajax setup.
     */
    setAjaxSetup: function()
    {
        // jQuery
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken }
        });

        //
        window.axios.defaults.headers.common = {
            'X-CSRF-TOKEN': window.Laravel.csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        };

    },

    initGlobalListeners: function() {

        var self = this;

        /**
         * Forms marked with the "data-remote" attribute will submit, via AJAX.
         */
        $(document).on('submit', 'form[data-remote]', function(e) {
            self.submitAjaxRequest($(this), e);
        });

        /**
         *  The "data-click-submits-form" attribute immediately submits the form on change.
         */
        $(document).on('click', '*[data-click-submits-form]', function() {
            $(this).closest('form').submit();
        });

    },

    /**
     * Form ajax handler.
     */
    submitAjaxRequest: function(that, e) {
        var form = $(that);
        var method = form.prop('method');
        var url = form.prop('action');
        var subscribers = form.data('subscribers');
        var data = form.serialize();
        var dataType = form.attr("enctype") == "multipart/form-data"
            ? 'files'
            : '';

        e.preventDefault();

        if (dataType == 'files')
        {
            var data = new FormData();
            $(form).find('input,select,textarea').each(function() {
                var inp = $(this);
                if (inp[0].files != null) {
                    var _content = inp[0].files[0];
                } else {
                    var _content = inp.val();
                }
                data.append($(this).attr('name'), _content);
            });
        }

        if(form.attr('data-preloader')) {
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
            success: function(data) {
                $.publish(subscribers, {
                    _type: 'done',
                    data: data
                });
            },
            error: function(data)
            {
                if(form.attr('data-remote')) {
                    Project.Components.FormErrorsHandler.showErrors(data.responseJSON, form);
                }

                $.publish(subscribers, {
                    _type: 'done',
                    data: data.responseJSON
                });

            },
            complete: function()
            {
                if(form.attr('data-preloader')) {
                    Project.Components.AjaxLoader.hide(form);
                }
            }
        });
    },
    
    commonResponseHandler: function(response, subscriber) {

        var alerting = false;
        var timeout = 0;

        var alerts = {};
        var redirect = '';
        if (typeof response.data._alerts != "undefined") {
            var alerts = response.data._alerts;
        }
        if (typeof response._alerts != "undefined") {
            var alerts = response._alerts;
        }
        if (typeof response.data._redirect != "undefined") {
            var redirect = response.data._redirect;
        }
        if (typeof response._redirect != "undefined") {
            var redirect = response._redirect;
        }

        if ( alerts != {} ) {
            $.each(alerts, function(key, alert) {
                alerting = true;
                timeout = timeout + 2500;
                swal({
                    title: alert.title,
                    text : alert.text,
                    type:  alert.type,
                    confirmButtonText: 'OK'
                });
            });
        }

        if (redirect != '') {
            if (redirect != -1) {
                if (alerting) {
                    window.setTimeout(function() {
                        location.href = redirect;
                    }, timeout);
                } else {
                    location.href = redirect;
                }
            }
        }

        if (typeof subscriber == "undefined") {
            return;
        }

        var form = $('form[data-subscribers="'+subscriber+'"]');

        Project.Components.FormErrorsHandler.showErrors(response, form);
    }
}