<?php
$pageTitle = 'History — SRT X CHEATS';
$currentPage = 'history';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
    <div class="tab-row">
        <a href="/store.php" class="tab-pill"><i class="fas fa-store"></i> Store</a>
        <a href="/history.php" class="tab-pill active"><i class="fas fa-clock-rotate-left"></i> Order History</a>
    </div>

    <div class="prompt-header"><i class="fas fa-receipt"></i> PURCHASE HISTORY</div>
    <div id="historyList">
        <div class="dim" style="text-align:center;padding:30px">
            <i class="fas fa-circle-notch fa-spin" style="font-size:24px;color:var(--neon-blue);margin-bottom:8px"></i>
            <div>Loading purchase history...</div>
        </div>
    </div>

    <button class="btn btn-danger" id="clearBtn" style="margin-top:16px"><i class="fas fa-trash-can"></i> Clear Purchase History</button>
</div>

<style>
.log-entry {
    background: var(--glass-panel, #0c1310);
    border: 1px solid var(--glass-border, rgba(57,255,136,0.14));
    border-radius: var(--radius-md, 8px);
    padding: 14px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.log-entry:hover {
    border-color: var(--neon-blue, #00f0ff);
    box-shadow: 0 4px 15px rgba(0, 240, 255, 0.15);
}

.log-entry .top { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 6px; 
}

.log-entry .name { 
    font-weight: 700; 
    color: var(--text-primary, #fff); 
    font-size: 13px; 
}

.log-entry .price { 
    color: var(--neon-amber, #ffb454); 
    font-weight: 800; 
    font-family: var(--font-mono, monospace); 
}

.log-entry .meta { 
    color: var(--text-muted, #8a9a90); 
    font-size: 11px; 
    margin-bottom: 8px; 
}

/* Key Section Flex Layout Fix */
.log-entry .key-wrap {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 8px !important;
    width: 100% !important;
    margin-top: 6px;
}

/* Forces Key Box to take up remaining space */
.log-entry .key-box,
.log-entry .key {
    flex: 1 1 auto !important;
    min-width: 0 !important; /* CRITICAL: Prevents key box from squishing */
    background: var(--surface-tint-strong, rgba(0, 0, 0, 0.3));
    border: 1px solid var(--glass-border, rgba(255,255,255,0.1));
    border-radius: var(--radius-sm, 6px);
    padding: 8px 10px;
    font-family: var(--font-mono, monospace);
    font-weight: 700;
    color: var(--neon-green, #10b981);
    font-size: 12px;
    white-space: nowrap !important;
    overflow-x: auto !important;
    word-break: keep-all !important;
}

/* Restricts button from taking up full width */
.log-entry .key-wrap button,
.copy-key-btn {
    flex: 0 0 auto !important; /* Prevents button from stretching */
    width: auto !important;
    padding: 8px 14px;
    font-size: 12px;
    white-space: nowrap;
    cursor: pointer;
}
</style>


<script type="module">
import { requireAuth, backendFetch, toast, fmtDate, esc, auth } from '/assets/js/app.js';

// nav.php's Logout button calls doLogout() globally — define it here too,
// otherwise Logout silently fails on this page.
window.doLogout = async function() {
    try {
        await auth.signOut();
    } catch (e) {
        console.error('Logout error:', e);
    }
    window.location.href = '/home.php';
};

requireAuth(async () => {
    await loadHistory();
});

async function loadHistory() {
    try {
        const d = await backendFetch('/api/user/history');
        renderHistory(d.history || []);
    } catch (e) {
        document.getElementById('historyList').innerHTML = `
            <div style="color:var(--red, #ff4d4d);font-size:12px;text-align:center;padding:20px">
                <i class="fas fa-triangle-exclamation"></i> Couldn't load history: ${esc(e.message)}
            </div>`;
    }
}

function renderHistory(items) {
    const el = document.getElementById('historyList');
    if (!items.length) {
        el.innerHTML = '<div class="dim" style="text-align:center;padding:30px"><i class="fas fa-box-open" style="font-size:20px;margin-bottom:8px;display:block"></i>No purchases recorded yet.</div>';
        return;
    }

    // Debug: log raw items to see the key structure
    console.log('🔍 History items:', items);

    el.innerHTML = items.map(it => {
        // --- Normalize the key to a continuous string ---
        let keyStr = '';
        if (it.key) {
            if (Array.isArray(it.key)) {
                // e.g., ["48","13","69","41","26"] => "4813694126"
                keyStr = it.key.join('');
            } else if (typeof it.key === 'string') {
                // Remove all whitespace (spaces, newlines, tabs)
                keyStr = it.key.replace(/\s+/g, '');
            } else if (typeof it.key === 'number') {
                keyStr = String(it.key);
            }
        }

        // If keyStr is empty, we can either show a placeholder or hide the block
        const keyHtml = keyStr ? `
            <div class="key-wrap">
                <div class="key-box" title="${esc(keyStr)}">${esc(keyStr)}</div>
                <button class="btn btn-ghost copy-key-btn" data-key="${esc(keyStr)}">
                    <i class="fas fa-copy"></i> Copy
                </button>
            </div>
        ` : '';

        return `
            <div class="log-entry">
                <div class="top">
                    <span class="name">${esc(it.name || '—')}</span>
                    <span class="price mono-num">Rs ${it.price ?? '—'}</span>
                </div>
                <div class="meta">${esc(it.duration || 'Standard')} · ${fmtDate(it.at)}</div>
                ${keyHtml}
            </div>
        `;
    }).join('');

    // Attach click listeners to copy buttons
    document.querySelectorAll('.copy-key-btn').forEach(btn => {
        btn.onclick = () => {
            const keyText = btn.dataset.key;
            if (keyText) {
                navigator.clipboard.writeText(keyText)
                    .then(() => toast('✅ Key copied to clipboard!', 'success'))
                    .catch(() => toast('❌ Failed to copy key', 'error'));
            }
        };
    });
}

// Clear History Action
document.getElementById('clearBtn').onclick = async () => {
    if (!confirm('Clear your entire purchase history? This cannot be undone.')) return;
    try {
        await backendFetch('/api/user/history-clear', { method: 'POST' });
        toast('🗑️ History cleared successfully', 'success');
        await loadHistory();
    } catch (e) {
        toast(e.message, 'error');
    }
};
</script>