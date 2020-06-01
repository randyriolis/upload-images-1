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
            data: 'no_urut',
            name: 'no_urut'
        },
        {
            data: 'path',
            name: 'path',
            orderable: false,
            searchable: false,
            render: (data) => {
                return `<img src="/image/${data}" alt="thumbnail" class="img-thumbnail" height="125" width="200">`;
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

        $('#dataTable button.copy').click(function () {
            const tr = $(this).closest('tr');
            const data = dataTable.row(tr).data();
            copyToClipboard(data);
        })
    }
})

// ubah label saat input image
$('.custom-file input').change(function (e) {
    const files = [];

    for (let i = 0; i < $(this)[0].files.length; i++) {
        files.push($(this)[0].files[i].name);
    }

    const labelText = files.join(', ').length > 50 ? files.join(', ').slice(0, 50) + '...' : files.join(', ');

    $(this).next('.custom-file-label').html(labelText);
});

$('#image-tambah-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');
    const progressBar = $('.progress .progress-bar', form);

    form.loading();
    $(progressBar).parent().removeClass('d-none');

    const formData = new FormData(form[0]);

    axios.post('/dashboard/images', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: (progressEvent) => {
                const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                
                $(progressBar).attr('aria-valuenow', percentCompleted).css('width', `${percentCompleted}%`).html(`${percentCompleted}%`);
            }
        })
        .then(() => {
            modal.modal('hide');
            form.removeClass('was-validated')[0].reset();
            $('.custom-file-label', form).html('Choose images...');
            dataTable.ajax.reload();
            iziToast('Berhasil menambah data')
        })
        .catch(() => iziToast('Gagal menambah data', false))
        .then(() => {
            form.loading(false);
            $(progressBar).attr('aria-valuenow', 0).css('width', '0%').html('0%').parent().addClass('d-none');
        });
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

$('#image-regenerate-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    const url = `/dashboard/images/regenerate/${albumId}`;

    axios.post(url)
        .then(() => {
            modal.modal('hide');
            dataTable.ajax.reload();
            iziToast('Berhasil regenerate url')
        })
        .catch(() => iziToast('Gagal regenerate url', false))
        .then(() => form.loading(false));
})

function copyToClipboard(data) {
    const url = window.location.protocol + '//' + window.location.hostname + '/image/' + data.path;
    let aux = document.createElement("input");

    aux.setAttribute("value", url);
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);

    iziToast('URL telah disalin');
}

$('#image-path-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (! this.checkValidity()) {
        return $(this).addClass('was-validated');
    }

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();

    axios.post('/dashboard/images/path', form.serialize())
        .then(() => {
            modal.modal('hide');
            form.removeClass('was-validated')[0].reset();
            dataTable.ajax.reload();
            iziToast('Berhasil menambah data')
        })
        .catch(() => iziToast('Gagal menambah data', false))
        .then(() => form.loading(false));
})
