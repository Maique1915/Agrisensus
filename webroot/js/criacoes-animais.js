$(document).ready(function () {
    initializeCommonDataTable({
        tableId: '#criacoesAnimaisTable',
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
            { value: '2', placeholder: 'Filtrar por Tipo de Animal...', maskFunction: 'formatUppercaseAlpha' },
            { value: '3', placeholder: 'Filtrar por Finalidade...', maskFunction: 'formatUppercaseAlpha' },
            { value: '4', placeholder: 'Filtrar por Data de Aquisição...', maskFunction: 'formatUppercaseAlpha' }
        ],
        deleteConfig: {
            linkSelector: '.js-delete-criacao-link',
            urlDataAttribute: 'url',
            idDataAttribute: 'criacao-id',
            messageTemplate: (id) => `Tem certeza que deseja excluir a criação de animal ${id ? '#' + id : ''}?`
        }
    });
});
