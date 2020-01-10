function showAlert(title, message, subMessage = '') {
    const modalAlert = $('#modal-alert');
    modalAlert.find('.modal-title').html(title);
    modalAlert.find('.modal-message').html(message);
    modalAlert.find('.modal-sub-message').html(subMessage || '');

    modalAlert.modal({
        backdrop: 'static',
        keyboard: false
    });
}

export default showAlert
