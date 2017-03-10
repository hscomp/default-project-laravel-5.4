Project.Components.AjaxLoader = {

    btnContent: null,
    

    loaderTemplate: function( text ){
        return '<div class="item_preloader __preloader __preloader-ajax-request"><div class="item_preloader-inner"><div class="item-loader-container"><div class="la-ball-pulse"><div></div><div></div><div></div></div></div></div><div class="item-title">'+text+'</div></div>'
    },
    
    show: function( $formElement, text ){
        if (typeof text === 'undefined') {
            text = $formElement.data('preloader');
        }
        this.btnContent = $formElement.find('button[type="submit"]').html();
        $formElement.find('button[type="submit"]').attr('disabled', true).html( this.loaderTemplate( text ) );
    },
    
    hide: function( $formElement ){
        $formElement.find('.__preloader').remove();
        $formElement.find('button[type="submit"]').attr('disabled', false).html( this.btnContent );
        this.btnContent = null;
    },
    
    'btnRequest': function( element ){
        this.btnContent = $(element).html();
        $(element).attr('disabled', true).html( this.loaderTemplate( $(element).attr('click-action-preloader') ) );
    },
    
    'btnRequestReset': function( element ){
        $(element).find('.__preloader').remove();
        $(element).attr('disabled', false).html( this.btnContent );
        this.btnContent = null;
    }
};

