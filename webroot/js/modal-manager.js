/**
 * modal-manager.js
 *
 * Módulo para gerenciar a exibição de modals genéricos (confirmação e alerta).
 * Permite configurar título, mensagem, tipo de alerta e callbacks para ações.
 */

class ModalManager {
    constructor() {
        this.confirmationModal = document.getElementById('generalConfirmationModal');
        this.alertDialog = document.getElementById('generalAlertDialog');

        if (!this.confirmationModal || !this.alertDialog) {
            console.warn("Modals de confirmação ou alerta não encontrados no DOM. Verifique 'general-modals.html' no seu layout principal.");
        }

        this.confirmTitle = this.confirmationModal ? this.confirmationModal.querySelector('[data-modal-title]') : null;
        this.confirmMessage = this.confirmationModal ? this.confirmationModal.querySelector('[data-modal-message]') : null;
        this.confirmButton = this.confirmationModal ? this.confirmationModal.querySelector('[data-modal-confirm]') : null;
        this.cancelButton = this.confirmationModal ? this.confirmationModal.querySelector('[data-modal-cancel]') : null;
        this.confirmDismiss = this.confirmationModal ? this.confirmationModal.querySelector('[data-modal-dismiss]') : null;

        this.alertTitle = this.alertDialog ? this.alertDialog.querySelector('[data-modal-title]') : null;
        this.alertMessage = this.alertDialog ? this.alertDialog.querySelector('[data-modal-message]') : null;
        this.alertOkButton = this.alertDialog ? this.alertDialog.querySelector('[data-modal-ok]') : null;
        this.alertDismiss = this.alertDialog ? this.alertDialog.querySelector('[data-modal-dismiss]') : null;

        this.onConfirmCallback = null;
        this.onCancelCallback = null;
        this.onOkCallback = null;

        this._setupEventListeners();
        this._checkFlashMessages(); // Add this line
    }

    _setupEventListeners() {
        if (this.confirmButton) {
            this.confirmButton.addEventListener('click', () => {
                this.hideModal(this.confirmationModal);
                if (this.onConfirmCallback) {
                    this.onConfirmCallback();
                }
            });
        }
        if (this.cancelButton) {
            this.cancelButton.addEventListener('click', () => {
                this.hideModal(this.confirmationModal);
                if (this.onCancelCallback) {
                    this.onCancelCallback();
                }
            });
        }
        if (this.confirmDismiss) {
            this.confirmDismiss.addEventListener('click', () => {
                this.hideModal(this.confirmationModal);
                if (this.onCancelCallback) {
                    this.onCancelCallback();
                }
            });
        }

        if (this.alertOkButton) {
            this.alertOkButton.addEventListener('click', () => {
                this.hideModal(this.alertDialog);
                if (this.onOkCallback) {
                    this.onOkCallback();
                }
            });
        }
        if (this.alertDismiss) {
            this.alertDismiss.addEventListener('click', () => {
                this.hideModal(this.alertDialog);
                if (this.onOkCallback) {
                    this.onOkCallback();
                }
            });
        }

        window.addEventListener('click', (event) => {
            if (this.confirmationModal && event.target === this.confirmationModal) {
                this.hideModal(this.confirmationModal);
                if (this.onCancelCallback) {
                    this.onCancelCallback();
                }
            }
            if (this.alertDialog && event.target === this.alertDialog) {
                this.hideModal(this.alertDialog);
                if (this.onOkCallback) {
                    this.onOkCallback();
                }
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                if (this.confirmationModal && this.confirmationModal.classList.contains('is-visible')) {
                    this.hideModal(this.confirmationModal);
                    if (this.onCancelCallback) {
                        this.onCancelCallback();
                    }
                }
                if (this.alertDialog && this.alertDialog.classList.contains('is-visible')) {
                    this.hideModal(this.alertDialog);
                    if (this.onOkCallback) {
                        this.onOkCallback();
                    }
                }
            }
        });
    }

    showModal(modalElement) {
        if (!modalElement) return;

        modalElement.style.display = 'none';

        const modalContent = modalElement.querySelector('.modal-content');
        if (modalContent) {
            modalContent.classList.remove('modal-exit-animation');
        }
        
        modalElement.classList.add('is-visible');
        modalElement.style.display = 'flex';
    }

    hideModal(modalElement) {
        if (!modalElement || !modalElement.classList.contains('is-visible')) {
            return;
        }

        const modalContent = modalElement.querySelector('.modal-content');
        if (modalContent) {
            modalContent.classList.add('modal-exit-animation');
            
            const handleAnimationEnd = () => {
                modalElement.classList.remove('is-visible');
                modalElement.style.display = 'none';
                modalContent.classList.remove('modal-exit-animation');
                modalContent.removeEventListener('animationend', handleAnimationEnd);
            };
            modalContent.addEventListener('animationend', handleAnimationEnd);
        } else {
            modalElement.classList.remove('is-visible');
            modalElement.style.display = 'none';
        }
    }

    showConfirmation(options) {
        if (!this.confirmationModal) return;

        this.confirmTitle.textContent = options.title || 'Confirmar Ação';
        this.confirmMessage.innerHTML = options.message || 'Tem certeza que deseja realizar esta ação?';
        this.confirmButton.textContent = options.confirmButtonText || 'Confirmar';
        this.cancelButton.textContent = options.cancelButtonText || 'Cancelar';

        this.confirmButton.className = 'btn ' + (options.confirmButtonClass || 'btn-danger');
        this.cancelButton.className = 'btn ' + (options.cancelButtonClass || 'btn-secondary');

        this.onConfirmCallback = options.onConfirm;
        this.onCancelCallback = options.onCancel;

        this.showModal(this.confirmationModal);
    }

    showAlert(options) {
        if (!this.alertDialog) return;

        const type = options.type || 'info';
        let titleClass = '';
        let okButtonClass = '';
        let contentClass = '';

        switch (type) {
            case 'success':
                titleClass = 'modal-title-success';
                okButtonClass = 'btn-success';
                contentClass = 'alert-success';
                break;
            case 'error':
                titleClass = 'modal-title-danger';
                okButtonClass = 'btn-danger';
                contentClass = 'alert-error';
                break;
            case 'warning':
                titleClass = 'modal-title-warning';
                okButtonClass = 'btn-warning';
                break;
            case 'info':
            default:
                titleClass = 'modal-title-info';
                okButtonClass = 'btn-primary';
                break;
        }

        this.alertTitle.classList.remove('modal-title-success', 'modal-title-danger', 'modal-title-info', 'modal-title-warning');
        this.alertTitle.classList.add(titleClass);

        const modalContent = this.alertDialog.querySelector('.modal-content');
        if (modalContent) {
            modalContent.classList.remove('alert-success', 'alert-error'); // Remove previous alert classes
            if (contentClass) {
                modalContent.classList.add(contentClass);
            }
        }

        this.alertTitle.textContent = options.title || 'Alerta';
        this.alertMessage.innerHTML = options.message || 'Esta é uma mensagem de alerta.';
        this.alertOkButton.textContent = options.okButtonText || 'OK';

        this.alertOkButton.className = 'btn ' + okButtonClass;

        this.onOkCallback = options.onOk;

        this.showModal(this.alertDialog);
    }

    _checkFlashMessages() {
        const flashContainer = document.getElementById('flash-message-container');
        if (flashContainer) {
            // Check if there's any content rendered by Flash component
            const flashMessageDiv = flashContainer.querySelector('.message');
            if (flashMessageDiv) {
                const message = flashMessageDiv.innerHTML; // Get the actual message content
                let type = 'info'; // Default type

                if (flashMessageDiv.classList.contains('success')) {
                    type = 'success';
                } else if (flashMessageDiv.classList.contains('error')) {
                    type = 'error';
                } else if (flashMessageDiv.classList.contains('warning')) {
                    type = 'warning';
                }

                this.showAlert({
                    title: 'Mensagem do Sistema',
                    message: message,
                    type: type
                });
                // Clear the message from the DOM to prevent it from showing again
                flashContainer.innerHTML = '';
            }
        }
    }
}

// Inicializa o ModalManager assim que o script é carregado.
window.modalManager = new ModalManager();