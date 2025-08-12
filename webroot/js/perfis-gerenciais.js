$(document).ready(function() {
    const tableId = '#perfilGerencialTable';

    initializeCommonDataTable({
        tableId: tableId,
        dataTableOptions: {
            "order": [], // Desativa a ordenação inicial
            "columnDefs": [
                { "orderable": false, "targets": -1 } // Desativa ordenação na coluna de ações
            ]
        },
        filterColumnConfigs: [
            { value: "0", placeholder: "Filtrar por nome do produtor...", caseInsensitive: true },
            { value: "1", placeholder: "Filtrar por CPF...", maskFunction: "maskCPF" }
        ],
        specificSearchInputSelector: '#specificSearchInput',
        clearFilterBtnSelector: '#clearSpecificFilterBtn',
        filterColumnRadioSelector: 'input[name="filterColumn"]',
        deleteConfig: {
            linkSelector: '.js-delete-perfil-link',
            urlDataAttribute: 'url',
            idDataAttribute: 'perfil-id',
            messageTemplate: function(id) {
                const row = $(`${tableId} [data-perfil-id="${id}"]`).closest('tr');
                const nome = row.find('td:first').text().trim();
                return `Tem certeza que deseja excluir o perfil de <strong>${nome}</strong>?`;
            }
        }
    });
});
