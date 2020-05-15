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
            render: () => {
                return /*html*/ `
                    <button class="btn btn-sm btn-success edit">Edit</button>
                    <button class="btn btn-sm btn-danger delete">Hapus</button>
                `
            }
        }
    ]
})