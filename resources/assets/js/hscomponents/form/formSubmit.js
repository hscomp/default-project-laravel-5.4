Project.Components.FormSubmit = {
    init: function() {
        $(document).on('submit', 'form[data-preloader]' , function(e){
            if( typeof $(this).attr('data-remote') !== 'undefined'){
                e.preventDefault();
                return false;
            } else {
                Project.Components.AjaxLoader.show( $(this) );
            }
        });
    },
}


