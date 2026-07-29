<?php
$pageTitle = 'History — SRT X CHEATS';
$currentPage = 'history';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
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
    background: var(--glass-panel);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-md);
    padding: 14px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}
.log-entry:hover {
    border-color: var(--neon-blue);
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
    color: var(--text-primary); 
    font-size: 13px; 
}
.log-entry .price { 
    color: var(--neon-amber); 
    font-weight: 800; 
    font-family: var(--font-mono); 
}
.log-entry .meta { 
    color: var(--text-muted); 
    font-size: 11px; 
    margin-bottom: 8px; 
}

/* Key Wrapper & Box Layout */
.log-entry .key-wrap {
    display: flex;
    gap: 6px;
    align-items: center;
    margin-top: 6px;
}
.log-entry .key-box {
    flex: 1;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-sm);
    padding: 8px 10px;
    font-family: var(--font-mono);
    font-weight: 700;
    color: var(--neon-green);
    font-size: 12px;
    white-space: nowrap;
    overflow-x: auto;
    word-break: keep-all;
}

/* Copy Button Styling */
.copy-key-btn {
    padding: 6px 10px;
    font-size: 11px;
    white-space: nowrap;
    cursor: pointer;
}

/* Light Mode Override Support */
[data-theme="light"] .log-entry .key-box {
    background: #f0fdf4;
    border-color: #86efac;
    color: #15803d;
}
</style>

<script type="module">
import { requireAuth, backendFetch, toast, fmtDate, esc } from '/assets/js/app.js';

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