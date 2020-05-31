'use strict'

const dataTable = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '',
    columns: [
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'id',
            orderable: false,
            searchable: false,
            render: () => '<button class="btn btn-sm btn-danger delete">Hapus</button>'
        }
    ],
    drawCallback: () => {
        $('#dataTable button.delete').click(function () {
            const tr = $(this).closest('tr');
            const data = dataTable.row(tr).data();
            showDeleteModal(data);
        })
    }
})

$('#folder-tambah-modal form').submit(function (e) {
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

function showDeleteModal(data) {
    $('#folder-hapus-id').val(data.id);
    $('#folder-hapus-modal .modal-body strong').text(data.name);
    $('#folder-hapus-modal').modal('show');
}

$('#folder-hapus-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    const url = '/dashboard/folders/' + $('#folder-hapus-id').val();

    axios.delete(url, form.serialize())
        .then(() => {
            modal.modal('hide');
            form.removeClass('was-validated')[0].reset();
            dataTable.ajax.reload();
            iziToast('Berhasil menghapus data')
        })
        .catch(() => iziToast('Gagal menghapus data', false))
        .then(() => form.loading(false));
})