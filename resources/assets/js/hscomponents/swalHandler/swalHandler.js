Project.Components.SwalHandler = {
    'defaults': {
        'confirmButtonText': 'Yes',
        'cancelButtonText': 'No',
        'normalButtonColor': '',
    },
    
    'general': function( arg, callbackSuccess, callbackError ){
        var self = this;
        if( typeof callbackSuccess !== 'undefined' || typeof callbackError !== 'undefined' ){
            swal( arg ).then( function(){
                if( $.isFunction( callbackSuccess ) ){
                    callbackSuccess();
                }
            }, function( dismiss ){
                if( dismiss === 'cancel' ){
                    if( $.isFunction( callbackError ) ){
                        callbackError();
                    }
                }
            });
        } else {
            swal( arg );
        }
    },
    
    'getArgs': function( text, title, type ){
        return {
            'title': (typeof title !== 'undefined' ? title : ''),
            'text' : (typeof text !== 'undefined' ? text : ''),
            'type' : type
        };
    },
    
    'info': function( text, title){
        this.general( this.getArgs(text, title, 'info') );
    },
    
    'success': function( text, title ){
        this.general( this.getArgs(text, title, 'success') );
    },
    
    'error': function( text, title, callbackFn ){
        this.general( this.getArgs(text, title, 'error') );
        if( typeof callbackFn !== 'undefined' ){
            if( $.isFunction( callbackFn ) ){
                callbackFn();
            }
        }
    },
    
    'confirm': function( confirmObj, callbackSuccess, callbackError ){
        
        var arg = {
            'title' : (typeof confirmObj.title !== 'undefined' ? confirmObj.title : ''),
            'text' : (typeof confirmObj.text !== 'undefined' ? confirmObj.text : ''),
            'type' : 'warning',
            'showCancelButton': true,
            'confirmButtonColor': '',
            'cancelButtonColor': '',
            'confirmButtonText' : ( typeof confirmObj.confirmBtnText !== 'undefined' ? confirmObj.confirmBtnText : this.defaults.confirmButtonText ),
            'cancelButtonText': ( typeof confirmObj.cancelBtnText !== 'undefined' ? confirmObj.cancelBtnText : this.defaults.cancelButtonText ),
            'confirmButtonClass' : 'btn btn-success',
            'cancelButtonClass' : 'btn btn-carret btn-gap',
            'buttonsStyling' : false
        };
        
        this.general( arg, callbackSuccess, callbackError );
    },
    
};

