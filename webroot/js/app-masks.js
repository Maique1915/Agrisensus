// Conteúdo de app-masks.js
window.AppMasks = {
    maskCPF: function (input) {
        input.setAttribute('maxlength', '14');
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        input.value = value;
    },
    maskCNPJ: function (input) {
        input.setAttribute('maxlength', '18');
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
        input.value = value;
    },
    maskPhone: function (input) {
        input.setAttribute('maxlength', '15');
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d\d)(\d)/g, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2'); // Ajuste para celular com 9 dígitos
        value = value.replace(/(\d{4})-(\d)(\d{4})/, '$1$2-$3'); // Corrige o posicionamento do hífen
        input.value = value;
    },
    formatUppercaseAlpha: function (input) {
        input.value = input.value.replace(/\d/g, '').toUpperCase();
    },
    formatUppercase: function (input) {
        input.value = input.value.toUpperCase();
    },
    maskCEP: function (input) {
        input.setAttribute('maxlength', '9');
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{5})(\d)/, '$1-$2');
        input.value = value;
    },
    maskNumeric: function (input) {
        input.value = input.value.replace(/\D/g, '');
    },
    maskFloat: function (input) {
        let value = input.value.replace(/[^0-9,]/g, ''); // Permite apenas números e vírgula
        let parts = value.split(',');

        if (parts.length > 2) {
            value = parts[0] + ',' + parts.slice(1).join(''); // Garante apenas uma vírgula
        }

        if (parts[0].length > 4) {
            parts[0] = parts[0].substr(0, 4);
        }

        if (parts.length === 2 && parts[1].length > 2) {
            parts[1] = parts[1].substring(0, 2); // Limita a 2 dígitos após a vírgula
        }

        input.value = parts.join(',');
    },
    maskMoney: function (input) {
        let value = input.value.replace(/\D/g, ''); // Mantém apenas dígitos

        // Se estiver vazio, não mostra nada
        if (value === '') {
            input.value = '';
            return;
        }

        // Garante pelo menos 3 dígitos para formar "0,00"
        while (value.length < 3) {
            value = '0' + value;
        }


        // Adiciona pontos de milhar
        reais = reais.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Junta a parte inteira com os centavos
        input.value = reais;
    }
};

$('[data-mask-type]').each(function () {
    const input = $(this);
    const maskType = input.data('mask-type');

    switch (maskType) {
        case 'uppercase':
            input.on('input', function () {
                if (window.AppMasks && window.AppMasks.formatUppercase) {
                    window.AppMasks.formatUppercase(this);
                }
            });
            break;
        case 'uppercase-text':
            input.on('input', function () {
                if (window.AppMasks && window.AppMasks.formatUppercaseAlpha) {
                    window.AppMasks.formatUppercaseAlpha(this);
                }
            });
            break;
        case 'cep':
            input.on('input', function () {
                if (window.AppMasks && window.AppMasks.maskCEP) {
                    window.AppMasks.maskCEP(this);
                }
            });
            break;
        case 'numeric':
            input.on('input', function () {
                if (window.AppMasks && window.AppMasks.maskNumeric) {
                    window.AppMasks.maskNumeric(this);
                }
            });
            break;
        case 'float':
            input.on('input', function () {
                if (window.AppMasks && window.AppMasks.maskFloat) {
                    window.AppMasks.maskFloat(this);
                }
            });
            break;
        case 'money':
            input.on('input', function () {
                if (window.AppMasks && window.AppMasks.maskMoney) {
                    window.AppMasks.maskMoney(this);
                }
            });
            break;
        // Add other mask types as needed
    }
});