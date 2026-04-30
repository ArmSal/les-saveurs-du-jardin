class DocumentExplorer {
    constructor(searchElement) {
        this.searchInput = searchElement;
        this.init();
    }

    init() {
        if (!this.searchInput) return;

        // Bind the search event
        this.searchInput.addEventListener('input', () => this.searchDocuments());

        // Let user do Ctrl+F as requested in the mockup ("FAIRE CTRL + F POUR RECHERCHER UN MOT CLEF")
        document.addEventListener("keydown", (e) => {
            if ((e.ctrlKey || e.metaKey) && e.keyCode === 70) {
                // Let default browser CTRL+F work better by expanding all folders
                document.querySelectorAll('details').forEach(d => d.open = true);
            }
        });
    }

    searchDocuments() {
        let filter = this.searchInput.value.trim().toLowerCase();
        
        document.querySelectorAll('details').forEach(d => d.open = true);

        if (filter === '') {
            document.querySelectorAll('.doc-item, details.folder-item').forEach(el => el.style.display = '');
            return;
        }

        // 1. Mark direct matches
        document.querySelectorAll('details.folder-item').forEach(folder => {
            const folderName = folder.querySelector('summary span')?.textContent.toLowerCase() || '';
            if (folderName.indexOf(filter) > -1) {
                folder.dataset.directMatch = 'true';
            } else {
                folder.dataset.directMatch = 'false';
            }
        });

        document.querySelectorAll('.doc-item').forEach(doc => {
            const title = doc.querySelector('.doc-title')?.textContent.toLowerCase() || '';
            if (title.indexOf(filter) > -1) {
                doc.dataset.directMatch = 'true';
            } else {
                doc.dataset.directMatch = 'false';
            }
        });

        // 2. Mark matches based on ancestors
        document.querySelectorAll('details.folder-item').forEach(folder => {
            if (folder.dataset.directMatch === 'true') {
                folder.querySelectorAll('details.folder-item, .doc-item').forEach(child => {
                    child.dataset.ancestorMatch = 'true';
                });
            }
        });

        // 3. Mark matches based on descendants
        document.querySelectorAll('.doc-item, details.folder-item').forEach(el => {
            if (el.dataset.directMatch === 'true') {
                let parent = el.parentElement.closest('details.folder-item');
                while (parent) {
                    parent.dataset.descendantMatch = 'true';
                    parent = parent.parentElement.closest('details.folder-item');
                }
            }
        });

        // 4. Apply visibility
        document.querySelectorAll('.doc-item, details.folder-item').forEach(el => {
            if (el.dataset.directMatch === 'true' || el.dataset.ancestorMatch === 'true' || el.dataset.descendantMatch === 'true') {
                el.style.display = '';
            } else {
                el.style.display = 'none';
            }
            
            // Cleanup temporary attributes
            delete el.dataset.directMatch;
            delete el.dataset.ancestorMatch;
            delete el.dataset.descendantMatch;
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('documentSearch');
    if (searchInput) {
        new DocumentExplorer(searchInput);
    }
});
