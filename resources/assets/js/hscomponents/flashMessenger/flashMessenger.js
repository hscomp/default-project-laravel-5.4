Project.Components.FlashMessenger = {

    notificationsConfig: null,

    alertsConfig: null,

    init: function() {

        if (typeof Server != 'undefined' && Server.flashMessenger) {

            this.notificationsConfig = Server.flashMessenger.notificationsConfig;
            this.alertsConfig = Server.flashMessenger.alertsConfig;

            var notifications = Server.flashMessenger.notifications,
                alerts = Server.flashMessenger.alerts;

            if (notifications) {
                this.handleServerNotifications(notifications);
            }

            if (alerts) {
                this.handleServerAlerts(alerts);
            }
        }
    },

    handleServerAlerts: function(alerts) {

        for(var i=0; i<alerts.length; i++) {

            var alert = alerts[i];

            //var config = this.alertsConfig['types'][messageType];

            var content = {
                type: alert['type'],
                title: alert['title'],
                text: alert['text'],
                confirmButtonText: alert['confirmButtonText'],
            }

            this.pushAlert(content);
        }
    },

    handleServerNotifications: function(notifications) {

        for(var i=0; i<notifications.length; i++) {

            var notification = notifications[i],
                messageType = notification['type'],
                messageTitle = notification['title'],
                messageText = notification['text'],
                messageOptions = notification['options'];

            var config = this.notificationsConfig['types'][messageType];

            var messageContent = {
                title: messageTitle,
                icon: config['icon'],
                message: messageText
            }

            var messageOptions = {
                delay: config['delay'],
                allow_dismiss: config['allowDismiss'],
                type: messageType,
                animate: config['animate'] ? config['animate'] : this.notificationsConfig.defaultAnimate,
                template: config['template'] ? config['template'] : this.notificationsConfig.defaultTemplate,
            }

            this.pushNotification(messageContent, messageOptions);
        }
    },

    pushNotification: function(content, options) {
        $.notify(content, options);
    },

    createNotificationByType: function(type, text, title) {

        var config = this.notificationsConfig['types'][type];

        var messageContent = {
            title: title,
            icon: config['icon'],
            message: text
        }

        var messageOptions = {
            delay: config['delay'],
            allow_dismiss: config['allowDismiss'],
            type: type,
            animate: config['animate'] ? config['animate'] : this.notificationsConfig.defaultAnimate,
            template: config['template'] ? config['template'] : this.notificationsConfig.defaultTemplate,
        }

        this.pushNotification(messageContent, messageOptions);
    },

    infoNotification: function(text, title) {
        this.createNotificationByType('info', text, title);
    },

    successNotification: function(text, title) {
        this.createNotificationByType('success', text, title);
    },

    warningNotification: function(text, title) {
        this.createNotificationByType('warning', text, title);
    },

    dangerNotification: function(text, title) {
        this.createNotificationByType('danger', text, title);
    },

    pushAlert: function(content, options) {
        swal(content);
    },

    infoAlert: function(text, title) {
        this.createAlertByType('info', text, title);
    },

    successAlert: function(text, title) {
        this.createAlertByType('success', text, title);
    },

    warningAlert: function(text, title) {
        this.createAlertByType('warning', text, title);
    },

    errorAlert: function(text, title) {
        this.createAlertByType('error', text, title);
    },

    questionAlert: function(text, title) {
        this.createAlertByType('question', text, title);
    },

    createAlertByType: function(type, title, text) {

        var config = this.alertsConfig['types'][type];

        var settings = {
            type: type,
            title: title,
            text: text,
            confirmButtonText: config['confirmButtonText'],
        }

        this.pushAlert(settings);
    }

}