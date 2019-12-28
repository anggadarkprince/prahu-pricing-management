import variables from './variables';

export default function () {

    const SUBSCRIBE_AR = 'ar';
    const SUBSCRIBE_AP = 'ap';
    const SUBSCRIBE_INFO = 'info';

    const EVENT_AR_MUTATION = 'ar-mutation';
    const EVENT_AR_PAYMENT = 'ar-payment';
    const EVENT_AR_TAX = 'ar-tax';

    const EVENT_AP_MUTATION = 'ap-mutation';
    const EVENT_AP_VALIDATION = 'ap-validation';

    const EVENT_INFO_ANNOUNCEMENT = 'info-announcement';
    const EVENT_INFO_CALENDAR = 'info-calendar';

    function displayNotification(title, message) {
        let options = {
            body: message,
            icon: variables.baseUrl + 'assets/dist/img/layouts/icon.jpg',
        };
        const notification = new Notification(title, options);
        notification.onclick = function () {
            window.open(url);
        };
    }

    if (variables.userId) {
        if ('Notification' in window) {
            if (Notification.permission !== "granted") {
                Notification.requestPermission(function (result) {
                    console.log('User choice', result);
                    if (result !== 'granted') {
                        console.log('No notification permission granted');
                    } else {
                        displayNotification('Successfully subscribed!', 'You successfully subscribe to our notification service!');
                    }
                });
            } else {
                //Pusher.logToConsole = true;

                let pusher = new Pusher('26e6e8709320db34adbb', {
                    cluster: 'ap1',
                    encrypted: true
                });

                let channelAR = pusher.subscribe(`${SUBSCRIBE_AR}-${variables.userId}`);
                channelAR.bind(EVENT_AR_MUTATION, function (data) {
                    displayNotification('Account Receivable', data.message);
                });
                channelAR.bind(EVENT_AR_PAYMENT, function (data) {
                    displayNotification('AR Payment', data.message);
                });
                channelAR.bind(EVENT_AR_TAX, function (data) {
                    displayNotification('Tax Invoice Set', data.message);
                });

                let channelAP = pusher.subscribe(`${SUBSCRIBE_AP}-${variables.userId}`);
                channelAP.bind(EVENT_AP_MUTATION, function (data) {
                    displayNotification('Account Payable', data.message);
                });
                channelAP.bind(EVENT_AP_VALIDATION, function (data) {
                    displayNotification('AP Validation', data.message);
                });

                let channelInfo = pusher.subscribe(`${SUBSCRIBE_INFO}-${variables.userId}`);
                channelInfo.bind(EVENT_INFO_ANNOUNCEMENT, function (data) {
                    displayNotification('Announcement', data.message);
                });
                channelInfo.bind(EVENT_INFO_CALENDAR, function (data) {
                    displayNotification('Calendar', data.message);
                });
            }
        } else {
            console.log('Not support notification');
        }
    }

};
