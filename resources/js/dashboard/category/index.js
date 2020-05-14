'use strict'

$('#dataTable').DataTable({
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
                    <button class="btn btn-sm btn-success">Edit</button>
                    <button class="btn btn-sm btn-danger">Hapus</button>
                `
            }
        }
    ]
})