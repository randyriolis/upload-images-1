'use strict'

const categoryId = $('meta[name="category-id"]').attr('content');

const dataTable = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/dashboard/albums/categories',
        data: {
            category_id: categoryId
        }
    },
    columns: [
        {
            data: 'title',
            name: 'title'
        },
        {
            data: 'images_count',
            name: 'images_count'
        },
        {
            data: 'id',
            orderable: false,
            searchable: false,
            render: (id) => {
                return /*html*/ `
                    <button class="btn btn-sm btn-danger delete">Hapus</button>
                    <a href="/dashboard/albums/${id}" class="btn btn-sm btn-primary detail">Detail</a>
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

$('#album-tambah-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    axios.post('/dashboard/albums', form.serialize())
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

    const url = '/dashboard/albums/' + $('#album-hapus-id').val();

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