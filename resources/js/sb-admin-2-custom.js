'use strict'

window.izitoast = require('izitoast');

// loading button saat form di submit
$.fn.loading = function (setLoading = true) {
    const submitBtn = $('button[type="submit"]', this);

    if (setLoading) {
        const submitBtnText = submitBtn.text();
        const loadingText = "<i class='fa fa-spinner fa-spin'></i> ";
    
        submitBtn.data('original-text', submitBtnText);
        submitBtn.html(loadingText + submitBtnText).prop('disabled', true);
        
        return this;
    }

    const originalText = submitBtn.data('original-text');
    submitBtn.html(originalText).prop('disabled', false);

    return this;
}

window.iziToast = function (msg, type = true) {
    izitoast.show({
        title: type ? 'Sukses!' : 'Error!',
        message: msg,
        color: type ? 'green' : 'red',
        position: 'topCenter'
    });
}

$('#regenerate-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();
    
    axios.post('/dashboard/regenerate/all')
        .then(() => {
            modal.modal('hide');
            iziToast('Berhasil regenerate url')
        })
        .catch(() => iziToast('Gagal regenerate url', false))
        .then(() => form.loading(false));
})