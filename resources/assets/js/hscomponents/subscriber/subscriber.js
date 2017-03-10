Project.Components.Subscriber = {

    init: function()
    {
        this.createSubscriber();

        this.initClickActionHandler();

        this.initChangeActionHandler();

        this.initShowDialogHandler();

        //this.initMatchTimerHandler();
    },

    /**
     * Simple subscriber.
     */
    createSubscriber: function()
    {
        (function() {
            var o = $({});

            $.subscribe = function() {
                o.on.apply(o, arguments);
            };

            $.unsubscribe = function() {
                o.off.apply(o, arguments);
            };

            $.publish = function() {     
                if (arguments[0]) {
                    if (arguments[0].indexOf('|') != -1) {
                        var handlers = arguments[0].split('|');
                        var data = arguments[1];
                        $.each(handlers, function(index, handler) {
                            o.trigger.apply(o, [handler, data]);
                        })
                    }
                    else {
                        o.trigger.apply(o, arguments);
                    }
                }
            };

        })(jQuery);
    },

    initClickActionHandler: function()
    {
        $(document).on('click', '*[data-click-action]', function(e) {
            e.preventDefault();
            $.publish($(this).attr('data-click-action'), {
                _type: 'done',
                element: $(e.currentTarget)[0],
                data: $(e.currentTarget).data()
            });
        });
    },

    initChangeActionHandler: function()
    {
        $(document).on('change', '*[data-change-action]', function(e) {
            e.preventDefault();
            $.publish($(this).attr('data-change-action'), {
                _type: 'done',
                element: $(e.currentTarget)[0],
                data: $(e.currentTarget).data()
            });
        });
    },

    initShowDialogHandler: function()
    {
        $(document).on('click', '*[dialog-warning]', function(e) {
            e.preventDefault();
            Project.Components.SwalHandler.error($(this).attr('dialog-warning'));
            return false;
        });
    }
}