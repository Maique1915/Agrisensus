$(document).ready(function() {
    $('.table-responsive table').each(function () {
        if (!$.fn.DataTable.isDataTable(this)) {
            $(this).DataTable({
                paging: true,
                ordering: true,
                info: true,
                searching: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json"
                },
                columnDefs: [
                    {
                        orderable: false,
                        searchable: false,
                        targets: 'actions-column'
                    }
                ],
                colReorder: true,
                responsive: true
            });
        }
    });

    var table = $('.table-responsive table').DataTable();
    $('#globalSearchInput').on('keyup', function() {
        table.search(this.value).draw();
    });
});
