$(document).ready(function () {
    initializeCommonDataTable({
        tableId: '#produtosCultivadosTable',
        dataTableOptions: {
            "columnDefs": [
                { "visible": false, "targets": [0] }
            ]
        },
        specificSearchInputSelector: '#specificSearchInput',
        clearFilterBtnSelector: '#clearSpecificFilterBtn',
        filterColumnRadioSelector: 'input[name="filterColumn"]',
        filterColumnConfigs: [
            { value: '0', placeholder: 'Filtrar por Nome do Produtor...', maskFunction: 'formatUppercaseAlpha' },
            { value: '1', placeholder: 'Filtrar por CPF do Produtor...', maskFunction: 'maskCPF' },
            { value: '2', placeholder: 'Filtrar por Nome do Produto...', maskFunction: 'formatUppercaseAlpha' }
        ],
        deleteConfig: {
            linkSelector: '.js-delete-produto-link',
            urlDataAttribute: 'url',
            idDataAttribute: 'produto-id',
            messageTemplate: (id) => `Tem certeza que deseja excluir o produto ${id ? '#' + id : ''}?`
        }
    });
});
