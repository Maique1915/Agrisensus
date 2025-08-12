$(document).ready(function () {
    initializeCommonDataTable({
        tableId: '#produtoresTable',
        specificSearchInputSelector: '#specificSearchInput',
        clearFilterBtnSelector: '#clearSpecificFilterBtn',
        filterColumnRadioSelector: 'input[name="filterColumn"]',
        filterColumnConfigs: [
            { value: '0', placeholder: 'Filtrar por Nome...', maskFunction: 'formatUppercaseAlpha' },
            { value: '1', placeholder: 'Filtrar por CPF...', maskFunction: 'maskCPF', maxLength: 14 },
            { value: '2', placeholder: 'Filtrar por CNPJ...', maskFunction: 'maskCNPJ', maxLength: 18 },
            { value: '3', placeholder: 'Filtrar por Telefone...', maskFunction: 'maskPhone', maxLength: 15 }
        ],
        deleteConfig: {
            linkSelector: '.js-delete-producer-link',
            urlDataAttribute: 'url',
            idDataAttribute: 'produtor-id',
            messageTemplate: (id) => `Tem certeza que deseja excluir o produtor ${id ? '#' + id : ''}?`
        }
    });
});

