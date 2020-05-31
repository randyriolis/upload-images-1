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
    ]
})