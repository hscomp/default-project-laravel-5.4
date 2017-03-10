window.Project = {

    Config: {},

    Components: {},

    init: function()
    {
        this.initComponents();
    },

    initComponents: function()
    {
        $.each(Project.Components, function(index, component) {
            if (Server.appConfig.debug) {
                console.log('Loaded component: ' + index);
            }
            if( $.isFunction( component.init ) ){
                component.init();
            } 
        });
    },

    removeFacebookRedirectHash: function()
    {
        if ((location.hash == "#_=_" || location.href.slice(-1) == "#_=_")) {
            var scrollV, scrollH, loc = window.location;
            if ('replaceState' in history) {
                history.replaceState('', document.title, loc.pathname + loc.search);
            } else {
                // Prevent scrolling by storing the page's current scroll offset
                scrollV = document.body.scrollTop;
                scrollH = document.body.scrollLeft;

                loc.hash = '';

                // Restore the scroll offset, should be flicker free
                document.body.scrollTop = scrollV;
                document.body.scrollLeft = scrollH;
            }
        }
    }
}

$(function() {

    Project.init();

    Project.removeFacebookRedirectHash();
});