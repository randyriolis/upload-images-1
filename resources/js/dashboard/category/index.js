'use strict'

const dataTable = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '',
    columns: [
        {
            data: 'category_name',
            name: 'category_name'
        },
        {
            data: 'folder_name',
            name: 'folder_name'
        },
        {
            data: 'albums_count',
            name: 'albums_count'
        },
        {
            data: 'id',
            orderable: false,
            searchable: false,
            render: (id) => {
                return /*html*/`
                    <button class="btn btn-sm btn-danger delete">Hapus</button>
                    <a href="${'/dashboard/categories/' + id}" class="btn btn-sm btn-primary detail">Detail</a>
                `
            }
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