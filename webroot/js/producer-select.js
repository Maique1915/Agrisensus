function formatProducerDisplayText(data, searchType) {
    if (!data) return '';
    let displayText = searchType === 'cpf' ? data.cpf : data.nome;
    if (searchType === 'cpf' && displayText) {
        let tempInput = { value: displayText, setAttribute: function(a,v){} };
        if (window.AppMasks && window.AppMasks.maskCPF) {
            window.AppMasks.maskCPF(tempInput);
            displayText = tempInput.value;
        }
    } else if (searchType === 'nome' && displayText) {
        displayText = displayText.toUpperCase();
    }
    return displayText || data.text || '';
}

function setupProducerSelect(baseUrl, searchUrlPath, producerIdForEdit = null) {
    const $produtorSelect = $('#produtor-select');

    if ($produtorSelect.data('select2')) {
        $produtorSelect.select2('destroy');
    }

    let ajaxUrl = `${baseUrl}/${searchUrlPath}`;
    if (producerIdForEdit) {
        ajaxUrl += `/${producerIdForEdit}`;
    }

    $produtorSelect.select2({
        placeholder: 'Selecione um produtor...',
        allowClear: true,
        ajax: {
            url: ajaxUrl,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    search_type: $('input[name="search_type"]:checked').val()
                };
            },
            processResults: function (data) {
                return {
                    results: data.results.map(function (item) {
                        return { ...item, text: item.text };
                    })
                };
            },
            cache: true
        },
        templateResult: function (data) {
            if (!data.id) return data.text;
            const searchType = $('input[name="search_type"]:checked').val();
            return formatProducerDisplayText(data, searchType);
        },
        templateSelection: function (data) {
            if (!data.id) return data.text;
            const fullData = $produtorSelect.select2('data')[0] || data;
            const searchType = $('input[name="search_type"]:checked').val();
            return formatProducerDisplayText(fullData, searchType);
        }
    }).on('select2:open', function() {
        const searchField = $('.select2-search__field');
        searchField.off('input').removeAttr('maxlength');
        const searchType = $('input[name="search_type"]:checked').val();
        if (searchType === 'cpf') {
            searchField.on('input', function() {
                if (window.AppMasks && window.AppMasks.maskCPF) {
                    window.AppMasks.maskCPF(this);
                }
            });
        } else if (searchType === 'nome') {
            searchField.on('input', function() {
                this.value = this.value.toUpperCase();
            });
        }
    }).on('select2:select', function (e) {
        const data = e.params.data;
        if (data.id) {
            const currentData = $produtorSelect.select2('data')[0] || {};
            currentData.nome = data.nome;
            currentData.cpf = data.cpf;
        }
    });

    const initialProducerId = $produtorSelect.data('initial-value');
    if (initialProducerId) {
        $.ajax({
            url: `${baseUrl}/getProducerInfo/${initialProducerId}`,
            dataType: 'json',
            success: function(data) {
                if (data && data.produtor) {
                    const produtor = data.produtor;
                    const searchType = $('input[name="search_type"]:checked').val();
                    const displayText = formatProducerDisplayText(produtor, searchType);

                    const option = new Option(displayText, produtor.id, true, true);
                    $produtorSelect.append(option).trigger('change');

                    $produtorSelect.trigger({
                        type: 'select2:select',
                        params: { data: { ...produtor, text: displayText } }
                    });
                }
            }
        });
    }

    $('input[name="search_type"]').on('change', function () {
        $produtorSelect.trigger('change');
    });
}

function initializeProducerSelect(baseUrl) {
    setupProducerSelect(baseUrl, 'searchProducers');
}

function initializeUnusedProducerSelection(baseUrl) {
    const producerId = $('#produtor-select').data('initial-value');
    setupProducerSelect(baseUrl, 'searchUnusedProducerSelection', producerId);
}
