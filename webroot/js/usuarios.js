$(document).ready(function () {
    initializeCommonDataTable({
        tableId: '#usuariosTable',
        specificSearchInputSelector: '#specificSearchInput',
        clearFilterBtnSelector: '#clearSpecificFilterBtn',
        filterColumnRadioSelector: 'input[name="filterColumn"]',
        filterColumnConfigs: [
            { value: '0', placeholder: 'Filtrar por Nome...', maskFunction: 'formatUppercaseAlpha' },
            { value: '1', placeholder: 'Filtrar por Matrícula...', maskFunction: 'formatUppercaseAlpha' }, // Assuming matricula is text
            { value: '2', placeholder: 'Filtrar por CPF...', maskFunction: 'maskCPF', maxLength: 14 },
            { value: '3', placeholder: 'Filtrar por Grupo...', maskFunction: 'formatUppercaseAlpha' } // Assuming grupo is text
        ],
        deleteConfig: {
            linkSelector: '.js-delete-user-link',
            urlDataAttribute: 'url',
            idDataAttribute: 'user-id',
            messageTemplate: (id) => `Tem certeza que deseja excluir o usuário ${id ? '#' + id : ''}?`
        }
    });
});