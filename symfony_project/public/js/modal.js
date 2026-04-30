/**
 * Custom Modal System - LSDJ Portal
 * Reusable styled modals matching the website theme
 */

// Create modal container if it doesn't exist
function ensureModalContainer() {
    let container = document.getElementById('custom-modal-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'custom-modal-container';
        document.body.appendChild(container);
    }
    return container;
}

/**
 * Show a confirmation modal with Confirm/Cancel buttons
 * @param {string} title - Modal title
 * @param {string} message - Modal message
 * @param {function} onConfirm - Callback when confirmed
 * @param {function} onCancel - Callback when cancelled (optional)
 */
function showConfirmModal(title, message, onConfirm, onCancel) {
    const container = ensureModalContainer();
    const modalId = 'custom-confirm-modal-' + Date.now();
    
    const modal = document.createElement('div');
    modal.id = modalId;
    modal.className = 'fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-xl w-full max-w-md overflow-hidden shadow-xl transform transition-all scale-95 opacity-0" id="${modalId}-content">
            <div class="bg-indigo-600 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="text-white">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">${title}</h3>
                </div>
            </div>
            <div class="p-6">
                <p class="text-slate-600 text-sm">${message}</p>
            </div>
            <div class="p-4 border-t border-slate-100 flex gap-3 justify-end">
                <button id="${modalId}-cancel" class="h-10 px-6 text-sm font-bold uppercase tracking-wider text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-all">
                    Annuler
                </button>
                <button id="${modalId}-confirm" class="h-10 px-6 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold uppercase tracking-wider rounded-lg transition-all shadow-sm">
                    Confirmer
                </button>
            </div>
        </div>
    `;
    
    container.appendChild(modal);
    
    const content = document.getElementById(`${modalId}-content`);
    const confirmBtn = document.getElementById(`${modalId}-confirm`);
    const cancelBtn = document.getElementById(`${modalId}-cancel`);
    
    // Close handlers
    const closeModal = () => {
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.remove();
        }, 200);
    };
    
    confirmBtn.addEventListener('click', () => {
        closeModal();
        if (onConfirm) onConfirm();
    });
    
    cancelBtn.addEventListener('click', () => {
        closeModal();
        if (onCancel) onCancel();
    });
    
    // Close on backdrop click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
            if (onCancel) onCancel();
        }
    });
    
    // Animate in
    requestAnimationFrame(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    });
}

/**
 * Show an alert/notification modal with OK button
 * @param {string} title - Modal title
 * @param {string} message - Modal message
 * @param {string} type - 'success', 'error', or 'info'
 * @param {function} onClose - Callback when closed (optional)
 */
function showAlertModal(title, message, type = 'success', onClose) {
    const container = ensureModalContainer();
    const modalId = 'custom-alert-modal-' + Date.now();
    
    const colors = {
        success: { bg: 'bg-emerald-500', iconBg: 'bg-emerald-100', iconColor: 'text-emerald-600' },
        error: { bg: 'bg-rose-500', iconBg: 'bg-rose-100', iconColor: 'text-rose-600' },
        info: { bg: 'bg-indigo-600', iconBg: 'bg-indigo-100', iconColor: 'text-indigo-600' }
    };
    const color = colors[type] || colors.success;
    
    const icons = {
        success: '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>',
        error: '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>',
        info: '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
    };
    
    const modal = document.createElement('div');
    modal.id = modalId;
    modal.className = 'fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-xl w-full max-w-sm overflow-hidden shadow-xl transform transition-all scale-95 opacity-0" id="${modalId}-content">
            <div class="${color.bg} p-4">
                <div class="flex items-center justify-center">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <div class="${color.iconColor}">
                            ${icons[type]}
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 text-center">
                <h3 class="text-lg font-bold text-slate-900 mb-2">${title}</h3>
                <p class="text-slate-600 text-sm">${message}</p>
            </div>
            <div class="px-6 pb-6">
                <button id="${modalId}-ok" class="w-full h-11 ${color.bg} hover:opacity-90 text-white text-sm font-bold uppercase tracking-wider rounded-lg transition-all shadow-sm">
                    OK
                </button>
            </div>
        </div>
    `;
    
    container.appendChild(modal);
    
    const content = document.getElementById(`${modalId}-content`);
    const okBtn = document.getElementById(`${modalId}-ok`);
    
    // Close handler
    const closeModal = () => {
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.remove();
        }, 200);
    };
    
    okBtn.addEventListener('click', () => {
        closeModal();
        if (onClose) onClose();
    });
    
    // Close on backdrop click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
            if (onClose) onClose();
        }
    });
    
    // Animate in
    requestAnimationFrame(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    });
}

// Export for module systems if available
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { showConfirmModal, showAlertModal };
}
