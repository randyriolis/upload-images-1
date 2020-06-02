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
            data: 'images_count',
            name: 'images_count'
        },
        {
            data: 'id',
            orderable: false,
            searchable: false,
            render: () => /*html*/`<button class="btn btn-sm btn-warning regenerate">Regenerate</button>`
        }
    ],
    drawCallback: () => {
        $('#dataTable button.regenerate').click(function () {
            const tr = $(this).closest('tr');
            const data = dataTable.row(tr).data();
            showRegenerateModal(data);
        })
    }
})

function showRegenerateModal(data) {
    $('#image-regenerate-id').val(data.id);
    $('#image-regenerate-modal .modal-body strong').text(data.title);
    $('#image-regenerate-modal').modal('show');
}

$('#image-regenerate-modal form').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    const form = $(this);
    const modal = $(this).parents('.modal');

    form.loading();
    
    axios.post('/dashboard/regenerate/album', form.serialize())
        .then(() => {
            modal.modal('hide');
            iziToast('Berhasil regenerate url')
        })
        .catch(() => iziToast('Gagal regenerate url', false))
        .then(() => form.loading(false));
})