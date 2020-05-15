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
            render: (data) => {
                return /*html*/ `
                    <button class="btn btn-sm btn-success edit">Edit</button>
                    <button class="btn btn-sm btn-danger delete">Hapus</button>
                    <a href="${window.location.href + '/' + data.id}" class="btn btn-sm btn-primary detail">Detail</a>
                `
            }
        }
    ],
    drawCallback: () => {
        $('#dataTable button.edit').click(function () {
            const tr = $(this).closest('tr');
            const data = dataTable.row(tr).data();
            showEditModal(data);
        })

        $('#dataTable button.delete').click(function () {
            const tr = $(this).closest('tr');
            const data = dataTable.row(tr).data();
            showDeleteModal(data);
        })
    }
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

function showEditModal(data) {
    $('#album-edit-id').val(data.id);
    $('#album-edit-title').val(data.title);
    $('#album-edit-category').val(data.category_id);
    $('#album-edit-modal').modal('show');
}

$('#album-edit-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    const url = 'albums/' + $('#album-edit-id').val();

    axios.put(url, form.serialize())
        .then(() => {
            modal.modal('hide');
            form.removeClass('was-validated')[0].reset();
            dataTable.ajax.reload();
            iziToast('Berhasil menyimpan data')
        })
        .catch(() => iziToast('Gagal menyimpan data', false))
        .then(() => form.loading(false));
})

function showDeleteModal(data) {
    $('#album-hapus-id').val(data.id);
    $('#album-hapus-modal .modal-body strong').text(data.title);
    $('#album-hapus-modal').modal('show');
}

$('#album-hapus-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    const url = 'albums/' + $('#album-hapus-id').val();

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