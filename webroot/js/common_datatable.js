// webroot/js/common_datatable.js

function initializeCommonDataTable(config) {
    let options = config.dataTableOptions || {};

    // Garante que o seletor de linhas (l) esteja presente.
    if (options.dom) {
        if (options.dom.indexOf('l') === -1) {
            // Adiciona o 'l' se estiver ausente, mantendo a ordem original.
            options.dom = 'l' + options.dom;
        }
    } else {
        // Define o DOM padrão se não for especificado.
        options.dom = 'lfrtip';
    }

    const table = $(config.tableId).DataTable(options);

    const specificSearchInput = $(config.specificSearchInputSelector);
    const clearFilterBtn = $(config.clearFilterBtnSelector);
    const radioButtons = $(config.filterColumnRadioSelector);

    function applyDynamicMask() {
        const selectedRadio = radioButtons.filter(':checked');
        const selectedColumn = selectedRadio.val();
        const filterConfig = config.filterColumnConfigs.find(c => c.value === selectedColumn);

        specificSearchInput.val('');
        specificSearchInput.off('input');
        specificSearchInput.removeAttr('maxlength');

        if (filterConfig) {
            specificSearchInput.attr('placeholder', filterConfig.placeholder);
            if (filterConfig.maskFunction && window.AppMasks && typeof window.AppMasks[filterConfig.maskFunction] === 'function') {
                specificSearchInput.on('input', function () {
                    window.AppMasks[filterConfig.maskFunction](this);
                });
            } else if (filterConfig.customInputHandler && typeof filterConfig.customInputHandler === 'function') {
                specificSearchInput.on('input', filterConfig.customInputHandler);
            }
            if (filterConfig.maxLength) {
                specificSearchInput.attr('maxlength', filterConfig.maxLength);
            }
        } else {
            specificSearchInput.attr('placeholder', 'Filtrar por...');
        }
    }

    const applySpecificFilter = () => {
        table.columns().search('').draw();
        const selectedColumn = radioButtons.filter(':checked').val();
        const searchTerm = specificSearchInput.val() ? specificSearchInput.val().trim() : '';

        if (selectedColumn !== undefined) {
            // Check if the column is configured to be case-insensitive or exact match
            const filterConfig = config.filterColumnConfigs.find(c => c.value === selectedColumn);
            const regex = filterConfig && filterConfig.caseInsensitive ? true : false;
            const smart = filterConfig && filterConfig.exactMatch ? false : true;

            table.column(selectedColumn).search(searchTerm, regex, smart).draw();
        }
    };

    specificSearchInput.on('keyup', applySpecificFilter);
    radioButtons.on('change', function () {
        applyDynamicMask();
        applySpecificFilter();
    });
    clearFilterBtn.on('click', function () {
        specificSearchInput.val('');
        applySpecificFilter();
    });

    // Initial setup
    applyDynamicMask();
    applySpecificFilter();

    // Delete confirmation logic
    if (config.deleteConfig) {
        $(document).on('click', config.deleteConfig.linkSelector, function (event) {
            event.preventDefault();
            const deleteUrl = $(this).data(config.deleteConfig.urlDataAttribute);
            const itemId = $(this).data(config.deleteConfig.idDataAttribute);
            const message = config.deleteConfig.messageTemplate(itemId);

            if (window.modalManager && window.modalManager.showConfirmation) {
                window.modalManager.showConfirmation({
                    title: 'Confirmar Exclusão',
                    message: message,
                    confirmButtonText: 'Excluir',
                    cancelButtonText: 'Cancelar',
                    onConfirm: () => {
                        const formId = '#delete-form-' + itemId;
                        $(formId).submit();
                    }
                });
            } else {
                console.error('window.modalManager ou window.modalManager.showConfirmation não estão disponíveis. Não é possível exibir a confirmação de exclusão.');
            }
        });
    }
}