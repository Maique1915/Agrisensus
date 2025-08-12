$(document).ready(function() {
    // 1. Atualiza o ID da tabela
    const tableId = '#familiaMaoDeObraTable';

    initializeCommonDataTable({
        tableId: tableId,
        dataTableOptions: {
            "order": [], // Mantém a desativação da ordenação inicial
            "columnDefs": [
                { "orderable": false, "targets": -1 } // Desativa ordenação na coluna de ações
            ]
        },
        filterColumnConfigs: [
            // A configuração de filtros pode ser mantida, pois se refere às colunas ocultas
            { value: "0", placeholder: "Filtrar por nome do produtor...", caseInsensitive: true },
            { value: "1", placeholder: "Filtrar por CPF...", maskFunction: "maskCPF" }
        ],
        specificSearchInputSelector: '#specificSearchInput',
        clearFilterBtnSelector: '#clearSpecificFilterBtn',
        filterColumnRadioSelector: 'input[name="filterColumn"]',
        
        // 2. Atualiza a configuração de exclusão
        deleteConfig: {
            // 2a. Atualiza o seletor do link de exclusão
            linkSelector: '.js-delete-familia-link',
            urlDataAttribute: 'url',
            
            // 2b. Atualiza o nome do atributo de dados do ID
            idDataAttribute: 'familia-id', 
            
            // 2c. Atualiza a mensagem de confirmação
            messageTemplate: function(id) {
                // Busca o ID na linha da tabela usando o novo atributo
                const row = $(`${tableId} [data-familia-id="${id}"]`).closest('tr');
                const nomeProdutor = row.find('td:first').text().trim(); // A primeira coluna oculta é o nome
                return `Tem certeza que deseja excluir os dados de família e mão de obra do produtor <strong>${nomeProdutor}</strong>?`;
            }
        }
    });
});