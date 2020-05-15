'use strict'

const albumId = $('meta[name="album-id"]').attr('content');

const dataTable = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/dashboard/images',
        data: {
            album_id: albumId
        }
    },
    columns: [
        {
            data: 'path',
            name: 'path',
            orderable: false,
            searchable: false,
            render: (data) => {
                return `<img src="/storage/${data}" alt="thumbnail" class="img-thumbnail" height="125" width="200">`;
            }
        },
        {
            data: 'path',
            name: 'path',
            width: '40%'
        },
        {
            data: null,
            orderable: false,
            searchable: false,
            render: () => {
                return /*html*/ `
                    <button class="btn btn-sm btn-danger delete">Hapus</button>
                    <button class="btn btn-sm btn-info copy">Copy URL</button>
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

// ubah label saat input image
$('.custom-file input').change(function (e) {
    const files = [];

    for (let i = 0; i < $(this)[0].files.length; i++) {
        files.push($(this)[0].files[i].name);
    }

    $(this).next('.custom-file-label').html(files.join(', '));
});

$('#image-tambah-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    const formData = new FormData(form[0]);

    axios.post('/dashboard/images', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(() => {
            modal.modal('hide');
            form.removeClass('was-validated')[0].reset();
            form.next('.custom-file-label').html('Choose images...');
            dataTable.ajax.reload();
            iziToast('Berhasil menambah data')
        })
        .catch(() => iziToast('Gagal menambah data', false))
        .then(() => form.loading(false));
})

function showDeleteModal(data) {
    $('#image-hapus-id').val(data.id);
    $('#image-hapus-modal .modal-body strong').text(data.path);
    $('#image-hapus-modal .modal-body img').attr('src', `/storage/${data.path}`);
    $('#image-hapus-modal').modal('show');
}

$('#image-hapus-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    const url = '/dashboard/images/' + $('#image-hapus-id').val();

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