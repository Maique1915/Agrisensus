$(document).ready(function () {
    initializeCommonDataTable({
        tableId: '#propriedadesTable',
        dataTableOptions: {
            "columnDefs": [
                { "visible": false, "targets": [0, 1] } // Hide the first two columns (Produtor Nome e CPF)
            ]
        },
        specificSearchInputSelector: '#specificSearchInput',
        clearFilterBtnSelector: '#clearSpecificFilterBtn',
        filterColumnRadioSelector: 'input[name="filterColumn"]',
        filterColumnConfigs: [
            { value: '0', placeholder: 'Filtrar por Nome do Produtor...', maskFunction: 'formatUppercaseAlpha' },
            { value: '1', placeholder: 'Filtrar por CPF do Produtor...', maskFunction: 'maskCPF' },
            { value: '2', placeholder: 'Filtrar por Nome da Propriedade...', maskFunction: 'formatUppercaseAlpha' },
            { value: '3', placeholder: 'Filtrar por Relação com a Propriedade...', maskFunction: 'formatUppercaseAlpha' },
            { value: '4', placeholder: 'Filtrar por Bairro...', maskFunction: 'formatUppercaseAlpha' },
            { value: '5', placeholder: 'Filtrar por Complemento...', maskFunction: 'formatUppercaseAlpha' }
        ],
        deleteConfig: {
            linkSelector: '.js-delete-propriedade-link',
            urlDataAttribute: 'url',
            idDataAttribute: 'propriedade-id',
            messageTemplate: (id) => `Tem certeza que deseja excluir a propriedade ${id ? '#' + id : ''}?`
        }
    });
});