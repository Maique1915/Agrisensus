$(document).ready(function() {
    // --- GERENCIAMENTO DE ESTADO DO FORMULÁRIO ---
    const form = $('#profileForm');
    const editableFields = form.find('input').not('#grupo, [type=hidden]');
    const passwordSection = $('#passwordSection');
    const btnEdit = $('#btnEdit');
    const editActions = $('#editActions');
    const btnSave = $('#btnSave');
    const btnCancel = $('#btnCancel');

    // Função para entrar no modo de edição
    function enableEditMode() {
        editableFields.prop('readonly', false);
        passwordSection.slideDown();
        btnEdit.hide();
        editActions.show();
    }

    // Função para sair do modo de edição e recarregar a página para reverter alterações
    function disableEditMode() {
        window.location.reload(); // A forma mais simples de cancelar é recarregar a página
    }

    // Event Listeners para os botões
    btnEdit.on('click', enableEditMode);
    btnCancel.on('click', disableEditMode);
    
    // Validação de senha antes do submit
    form.on('submit', function(event) {
        const novaSenha = $('#novaSenha').val();
        const confirmaSenha = $('#confirmaSenha').val();

        if (novaSenha !== confirmaSenha) {
            event.preventDefault(); // Impede o envio do formulário
            // Assuming window.modalManager.showAlert is available
            window.modalManager.showAlert({
                title: 'Erro de Validação',
                message: 'As senhas não coincidem. Por favor, verifique.',
                type: 'error'
            });
        }
    });

    // --- Alertas de Sucesso/Erro ---
    // This part needs to be handled by CakePHP's FlashComponent and modal-manager.js
    // The _checkFlashMessages in modal-manager.js already handles this.
    // So, no need to duplicate here.
});