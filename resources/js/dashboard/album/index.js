'use strict'

const dataTable = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '',
    columns: [
        {
            data: 'title',
            name: 'title'
        },
        {
            data: 'category',
            name: 'category'
        },
        {
            data: null,
            orderable: false,
            searchable: false,
            render: () => {
                return /*html*/ `
                    <button class="btn btn-sm btn-success edit">Edit</button>
                    <button class="btn btn-sm btn-danger delete">Hapus</button>
                `
            }
        }
    ]
})

$('#album-tambah-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    axios.post('', form.serialize())
        .then(() => {
            modal.modal('hide');
            form.removeClass('was-validated')[0].reset();
            dataTable.ajax.reload();
            iziToast('Berhasil menambah data')
        })
        .catch(() => iziToast('Gagal menambah data', false))
        .then(() => form.loading(false));
})