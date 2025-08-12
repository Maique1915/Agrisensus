$(document).ready(function () {
    var table = $('#enderecosTable').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 0 } // Hide the first column (Produtor)
        ]
    });

    const specificSearchInput = $('#specificSearchInput');
    const clearFilterBtn = $('#clearSpecificFilterBtn');
    const radioButtons = $('input[name="filterColumn"]');

    function applyDynamicMask() {
        const selectedColumn = radioButtons.filter(':checked').val();

        specificSearchInput.val('');
        specificSearchInput.off('input');
        specificSearchInput.removeAttr('maxlength');

        switch (selectedColumn) {
            case '0': // Estado
                specificSearchInput.attr('placeholder', 'Filtrar por Estado...');
                break;
            case '1': // CEP
                specificSearchInput.attr('placeholder', 'Filtrar por CEP...');
                specificSearchInput.attr('maxlength', 9);
                specificSearchInput.on('input', function () { window.AppMasks.maskCEP(this); });
                break;
            case '2': // Bairro
                specificSearchInput.attr('placeholder', 'Filtrar por Bairro...');
                break;
            case '3': // Cidade
                specificSearchInput.attr('placeholder', 'Filtrar por Cidade...');
                break;
            case '4': // Complemento
                specificSearchInput.attr('placeholder', 'Filtrar por Complemento...');
                break;
            default: 
                specificSearchInput.attr('placeholder', 'Filtrar por...');
                break;
        }
    }

    const applySpecificFilter = () => {
        table.columns().search('').draw();
        const selectedColumn = $('input[name="filterColumn"]:checked').val();
        const searchTerm = specificSearchInput.val();

        if (selectedColumn !== undefined) {
            table.column(selectedColumn).search(searchTerm).draw();
        }
    };

    specificSearchInput.on('keyup', applySpecificFilter);
    $('input[name="filterColumn"]').on('change', applySpecificFilter);
    clearFilterBtn.on('click', function () {
        specificSearchInput.val('');
        applySpecificFilter();
    });

    $('input[name="filterColumn"]').on('change', function () {
        applyDynamicMask();
        applySpecificFilter();
    });

    applyDynamicMask();

    $(document).on('click', '.js-delete-endereco-link', function (event) {
        event.preventDefault();
        const deleteUrl = $(this).data('url');
        const enderecoId = $(this).data('endereco-id');

        if (window.modalManager && window.modalManager.showConfirmation) {
            window.modalManager.showConfirmation({
                title: 'Confirmar Exclusão',
                message: `Tem certeza que deseja excluir o endereço ${enderecoId ? '#' + enderecoId : ''}?`,
                confirmButtonText: 'Excluir',
                cancelButtonText: 'Cancelar',
                onConfirm: () => {
                    const form = $('<form/>', {
                        action: deleteUrl,
                        method: 'post',
                        style: 'display:none;'
                    }).appendTo('body');

                    const csrfToken = $('input[name="_csrfToken"]').val();
                    if (csrfToken) {
                        $('<input/>', {
                            type: 'hidden',
                            name: '_csrfToken',
                            value: csrfToken
                        }).appendTo(form);
                    }

                    $('<input/>', {
                        type: 'hidden',
                        name: '_method',
                        value: 'POST'
                    }).appendTo(form);
                    form.submit();
                }
            });
        } else {
            console.error('window.modalManager ou window.modalManager.showConfirmation não estão disponíveis. Não é possível exibir a confirmação de exclusão.');
        }
    });
});