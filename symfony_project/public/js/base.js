window.addEventListener('load', function () {
    const loader = document.getElementById('main-loader');
    if (loader) {
        // Fade out exactly when the circle finishes drawing (450ms)
        setTimeout(() => {
            loader.classList.add('fade-out');
        }, 450);
    }

    // Sidebar brand icon toggle: alternate between carrot and LSDJ every 3s
    const brandCarrot = document.getElementById('brandCarrot');
    const brandLsdj = document.getElementById('brandLsdj');
    if (brandCarrot && brandLsdj) {
        let showingCarrot = true;
        setInterval(() => {
            showingCarrot = !showingCarrot;
            if (showingCarrot) {
                brandCarrot.classList.remove('hidden');
                brandLsdj.classList.remove('visible');
            } else {
                brandCarrot.classList.add('hidden');
                brandLsdj.classList.add('visible');
            }
        }, 3000);
    }
});

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (!sidebar)
        return;



    sidebar.classList.toggle('open');
    overlay.classList.toggle('active');
    document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
}
function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (!sidebar)
        return;



    sidebar.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}
// Show user name label on medium screens
function applyResponsive() {
    const w = window.innerWidth;
    document.querySelectorAll('.user-name-label').forEach(el => {
        el.style.display = w >= 480 ? 'block' : 'none';
    });
    document.querySelectorAll('.cart-label').forEach(el => {
        el.style.display = w >= 480 ? 'block' : 'none';
    });
}
applyResponsive();
window.addEventListener('resize', applyResponsive);

// ===== USER DROPDOWN =====
function toggleUserDropdown(event) {
    event.stopPropagation();
    const content = document.getElementById('userDropdownContent');
    const chevron = document.getElementById('dropdownChevron');
    const trigger = document.getElementById('userDropdownTrigger');
    const isOpen = content.classList.contains('open');
    if (isOpen) {
        content.classList.remove('open');
        trigger.setAttribute('aria-expanded', 'false');
        if (chevron)
            chevron.style.transform = 'rotate(0deg)';



    } else {
        content.classList.add('open');
        trigger.setAttribute('aria-expanded', 'true');
        if (chevron)
            chevron.style.transform = 'rotate(180deg)';



    }
}
document.addEventListener('click', function (e) {
    const dropdown = document.getElementById('userDropdown');
    const content = document.getElementById('userDropdownContent');
    const trigger = document.getElementById('userDropdownTrigger');
    const chevron = document.getElementById('dropdownChevron');
    if (dropdown && !dropdown.contains(e.target)) {
        content && content.classList.remove('open');
        trigger && trigger.setAttribute('aria-expanded', 'false');
        if (chevron)
            chevron.style.transform = 'rotate(0deg)';



    }
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const content = document.getElementById('userDropdownContent');
        const trigger = document.getElementById('userDropdownTrigger');
        const chevron = document.getElementById('dropdownChevron');
        content && content.classList.remove('open');
        trigger && trigger.setAttribute('aria-expanded', 'false');
        if (chevron)
            chevron.style.transform = 'rotate(0deg)';
    }
});

// ===== NOTIFICATION DROPDOWN =====
function toggleNotifDropdown(event) {
    event.stopPropagation();
    const content = document.getElementById('notifDropdownContent');
    const trigger = document.getElementById('notifDropdownTrigger');
    const userContent = document.getElementById('userDropdownContent');
    
    // Close user dropdown if open
    if (userContent && userContent.classList.contains('open')) {
        userContent.classList.remove('open');
        document.getElementById('userDropdownTrigger').setAttribute('aria-expanded', 'false');
        const userChevron = document.getElementById('dropdownChevron');
        if (userChevron) userChevron.style.transform = 'rotate(0deg)';
    }

    const isOpen = content.classList.contains('open');
    if (isOpen) {
        content.classList.remove('open');
        trigger.setAttribute('aria-expanded', 'false');
    } else {
        content.classList.add('open');
        trigger.setAttribute('aria-expanded', 'true');
    }
}

async function markAllNotificationsAsRead(event) {
    event.stopPropagation();
    try {
        const response = await fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        if (data.success) {
            // Update UI in dropdown
            document.querySelectorAll('.notif-item.unread').forEach(item => {
                item.classList.remove('unread');
                const indicator = item.querySelector('.notif-dot-indicator');
                if (indicator) {
                    const spacer = document.createElement('div');
                    spacer.className = 'w-[6px] flex-shrink-0';
                    indicator.replaceWith(spacer);
                }
            });
            
            // Sync badges
            document.querySelectorAll('#global-notif-badge, .unread-badge').forEach(badge => badge.remove());
            
            const markReadBtn = event.target;
            if (markReadBtn && markReadBtn.tagName === 'BUTTON') markReadBtn.remove();
            
            if (window.showToast) window.showToast('Toutes les notifications ont été marquées comme lues.');
        }
    } catch (error) {
        console.error('Error marking notifications as read:', error);
    }
}

async function handleNotifClick(id, event) {
    const item = event.currentTarget;
    const isUnread = item.classList.contains('unread');
    
    if (isUnread) {
        // Optimistic UI update
        item.classList.remove('unread');
        const indicator = item.querySelector('.notif-dot-indicator');
        if (indicator) {
            const spacer = document.createElement('div');
            spacer.className = 'w-[6px] flex-shrink-0';
            indicator.replaceWith(spacer);
        }

        // Update badge count
        const badge = document.getElementById('global-notif-badge');
        const countEl = document.getElementById('global-notif-count');
        if (badge && countEl) {
            const count = parseInt(countEl.innerText) - 1;
            if (count <= 0) {
                badge.remove();
            } else {
                countEl.innerText = count;
            }
        }

        try {
            fetch(`/notifications/mark-read/${id}`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
        } catch (e) {
            console.error('Failed to mark as read:', e);
        }
    }

    // If it's a dummy link (#), prevent default
    if (item.getAttribute('href') === '#') {
        event.preventDefault();
    }
}

// Update click listener to handle both dropdowns
document.addEventListener('click', function (e) {
    const userDropdown = document.getElementById('userDropdown');
    const notifDropdown = document.getElementById('notifDropdown');
    
    if (userDropdown && !userDropdown.contains(e.target)) {
        const content = document.getElementById('userDropdownContent');
        const trigger = document.getElementById('userDropdownTrigger');
        const chevron = document.getElementById('dropdownChevron');
        if (content && content.classList.contains('open')) {
            content.classList.remove('open');
            trigger && trigger.setAttribute('aria-expanded', 'false');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }
    }
    
    if (notifDropdown && !notifDropdown.contains(e.target)) {
        const content = document.getElementById('notifDropdownContent');
        const trigger = document.getElementById('notifDropdownTrigger');
        if (content && content.classList.contains('open')) {
            content.classList.remove('open');
            trigger && trigger.setAttribute('aria-expanded', 'false');
        }
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const userContent = document.getElementById('userDropdownContent');
        const notifContent = document.getElementById('notifDropdownContent');
        
        if (userContent) {
            userContent.classList.remove('open');
            const userTrigger = document.getElementById('userDropdownTrigger');
            const userChevron = document.getElementById('dropdownChevron');
            userTrigger && userTrigger.setAttribute('aria-expanded', 'false');
            if (userChevron) userChevron.style.transform = 'rotate(0deg)';
        }
        
        if (notifContent) {
            notifContent.classList.remove('open');
            const notifTrigger = document.getElementById('notifDropdownTrigger');
            notifTrigger && notifTrigger.setAttribute('aria-expanded', 'false');
        }
    }
});

// ===== SIDEBAR DROPDOWNS =====
function toggleNavDropdown(btn) {
    const parent = btn.closest('.nav-dropdown');
    const isOpen = parent.classList.contains('open');
    
    // Optional: close other dropdowns
    document.querySelectorAll('.nav-dropdown').forEach(d => {
        if (d !== parent) d.classList.remove('open');
    });

    if (isOpen) {
        parent.classList.remove('open');
    } else {
        parent.classList.add('open');
    }
}

// Auto-open dropdown if it contains an active link
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.nav-dropdown').forEach(dropdown => {
        if (dropdown.querySelector('a.active')) {
            dropdown.classList.add('open');
        }
    });

    // ===== ENHANCED INACTIVITY TRACKER (1 HOUR) =====
    let inactivityTimeout;
    const ONE_HOUR = 60 * 60 * 1000;

    function checkInactivity() {
        const lastActivity = parseInt(localStorage.getItem('portal_last_activity') || '0');
        const now = Date.now();

        if (now - lastActivity >= ONE_HOUR) {
            console.log('Inactivité détectée (sync). Déconnexion...');
            window.location.href = '/logout';
            return;
        }

        // Reschedule check based on remaining time
        const remaining = ONE_HOUR - (now - lastActivity);
        if (inactivityTimeout) clearTimeout(inactivityTimeout);
        inactivityTimeout = setTimeout(checkInactivity, remaining + 100);
    }

    function resetInactivityTimer() {
        if (!document.getElementById('userDropdown')) return;

        const now = Date.now();
        localStorage.setItem('portal_last_activity', now.toString());

        // Locally reschedule next check
        if (inactivityTimeout) clearTimeout(inactivityTimeout);
        inactivityTimeout = setTimeout(checkInactivity, ONE_HOUR + 100);
    }

    // Capture events to keep session alive
    if (document.getElementById('userDropdown')) {
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(eventName => {
            document.addEventListener(eventName, resetInactivityTimer, { passive: true });
        });

        // Sync across tabs
        window.addEventListener('storage', (e) => {
            if (e.key === 'portal_last_activity') {
                if (inactivityTimeout) clearTimeout(inactivityTimeout);
                inactivityTimeout = setTimeout(checkInactivity, ONE_HOUR + 100);
            }
        });

        resetInactivityTimer();
    }
});
