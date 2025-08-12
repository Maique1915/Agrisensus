$(document).ready(function () {
    initializeCommonDataTable({
        tableId: '#insumosUtilizadosTable',
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
            { value: '2', placeholder: 'Filtrar por Nome do Insumo...', maskFunction: 'formatUppercaseAlpha' },
            { value: '3', placeholder: 'Filtrar por Local de compra...', maskFunction: 'formatUppercaseAlpha' }
        ],
        deleteConfig: {
            linkSelector: '.js-delete-insumo-link',
            urlDataAttribute: 'url',
            idDataAttribute: 'insumo-id',
            messageTemplate: (id) => `Tem certeza que deseja excluir o insumo ${id ? '#' + id : ''}?`
        }
    });
});
