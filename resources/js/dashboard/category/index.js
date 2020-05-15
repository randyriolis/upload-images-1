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

$('#kategori-tambah-modal form').submit(function (e) {
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
    $('#kategori-edit-id').val(data.id);
    $('#kategori-edit-nama').val(data.name);
    $('#kategori-edit-modal').modal('show');
}

$('#kategori-edit-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    const url = 'categories/' + $('#kategori-edit-id').val();

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
    $('#kategori-hapus-id').val(data.id);
    $('#kategori-hapus-modal .modal-body strong').text(data.name);
    $('#kategori-hapus-modal').modal('show');
}

$('#kategori-hapus-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    const url = 'categories/' + $('#kategori-hapus-id').val();

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