/**
 * produtores-view.js
 *
 * Gerencia a lógica de exclusão de entidades relacionadas na página de visualização do produtor.
 * Utiliza o modal de confirmação customizado (ModalManager).
 */

$(document).ready(function () {
    // Função genérica para configurar a exclusão de entidades
    function setupDeleteConfirmation(linkSelector, entityType, messageTemplate) {
        $(linkSelector).on('click', function (e) {
            e.preventDefault();
            const entityId = $(this).data('entity-id');
            const entityName = $(this).data('entity-name'); // Get the entity name
            const deleteUrl = $(this).data('url');
            const formId = `delete-form-${entityType}-${entityId}`;

            window.modalManager.showConfirmation({
                title: `Confirmar Exclusão de ${entityType}`,
                message: messageTemplate(entityName, entityId),
                onConfirm: () => {
                    // Submete o formulário oculto correspondente
                    document.getElementById(formId).submit();
                }
            });
        });
    }

    // Configurações para cada tipo de entidade
    setupDeleteConfirmation(
        '.js-delete-propriedade-link',
        'propriedade',
        (name, id) => `Tem certeza que deseja excluir a propriedade ${name ? name : '#' + id}?`
    );

    setupDeleteConfirmation(
        '.js-delete-produtocultivado-link',
        'produtocultivado',
        (name, id) => `Tem certeza que deseja excluir o produto cultivado ${name ? name : '#' + id}?`
    );

    setupDeleteConfirmation(
        '.js-delete-criacaoanimal-link',
        'criacaoanimal',
        (name, id) => `Tem certeza que deseja excluir a criação de animal ${name ? name : '#' + id}?`
    );

    setupDeleteConfirmation(
        '.js-delete-insumo-link',
        'insumo',
        (name, id) => `Tem certeza que deseja excluir o insumo ${name ? name : '#' + id}?`
    );
});
