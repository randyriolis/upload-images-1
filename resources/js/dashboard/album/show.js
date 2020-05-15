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
            name: 'path'
        },
        {
            data: null,
            orderable: false,
            searchable: false,
            render: () => {
                return /*html*/ `
                    <button class="btn btn-sm btn-success edit">Edit</button>
                    <button class="btn btn-sm btn-danger delete">Hapus</button>
                    <button class="btn btn-sm btn-info copy">Copy URL</button>
                `
            }
        }
    ]
})