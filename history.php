<?php
$pageTitle = 'History — ADMIN PANELS';
$currentPage = 'history';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
    <div class="term-content">

        <div class="prompt-header"><i class="fas fa-clock-rotate-left"></i> PURCHASE HISTORY</div>
        
        <div id="historyList">
            <div class="dim" style="text-align:center;padding:20px">
                <i class="fas fa-circle-notch fa-spin"></i> Loading purchase history...
            </div>
        </div>

        <button class="btn btn-ghost" id="clearBtn" style="margin-top:16px;color:var(--red, #ff4d4d);width:100%">
            <i class="fas fa-trash-can"></i> Clear History
        </button>

    </div>
</div>

<style>
.log-entry {
    background: var(--panel, #0c1310);
    border: 1px solid var(--border, rgba(57,255,136,0.14));
    border-radius: var(--radius-sm, 6px);
    padding: 12px;
    margin-bottom: 10px;
    font-size: 12px;
}
.log-entry .top { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 4px; 
}
.log-entry .name { 
    font-weight: 700; 
    font-size: 13px; 
}
.log-entry .price { 
    color: var(--amber, #ffb454); 
    font-weight: 800; 
}
.log-entry .meta { 
    color: var(--text3, #8a9a90); 
    font-size: 11px; 
    margin-bottom: 8px; 
}

/* Dynamic License Key Box (Works in both Dark & Light/White Mode) */
.log-entry .key-wrap {
    display: flex;
    gap: 6px;
    align-items: center;
    margin-top: 6px;
}
.log-entry .key-box {
    flex: 1;
    background: rgba(0, 0, 0, 0.06);
    border: 1px solid var(--border-strong, rgba(57,255,136,0.35));
    border-radius: 4px;
    padding: 8px 10px;
    word-break: break-all;
    font-family: monospace;
    font-weight: 700;
    color: var(--neon-green, #10b981);
    font-size: 12px;
}

/* Light mode support override */
[data-theme="light"] .log-entry .key-box {
    background: #f0fdf4;
    border-color: #86efac;
    color: #15803d;
}

.copy-key-btn {
    padding: 6px 10px;
    font-size: 11px;
    white-space: nowrap;
    cursor: pointer;
}

.log-entry .key-box {
    white-space: nowrap;          /* prevents line breaks */
    overflow-x: auto;            /* scroll if too long */
    word-break: keep-all;        /* avoids breaking inside characters */
    /* existing styles remain */
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

    console.log('Raw history:', items); // 🔍 DEBUG

    el.innerHTML = items.map(it => {
        let keyStr = '';
        if (it.key) {
            if (Array.isArray(it.key)) {
                keyStr = it.key.join('');
            } else if (typeof it.key === 'string') {
                keyStr = it.key.replace(/\s+/g, '');
            } else {
                keyStr = String(it.key);
            }
        }

        // If the key is still a single character, log a warning
        if (keyStr && keyStr.length <= 2) {
            console.warn('Possible truncated key for', it.name, ':', keyStr);
        }

        const keyHtml = keyStr ? `
            <div class="key-wrap">
                <div class="key-box">${esc(keyStr)}</div>
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

    // Copy listeners
    document.querySelectorAll('.copy-key-btn').forEach(btn => {
        btn.onclick = () => {
            const keyText = btn.dataset.key;
            if (keyText) {
                navigator.clipboard.writeText(keyText);
                toast('Key copied to clipboard!', 'success');
            }
        };
    });
}

// Clear History Action
document.getElementById('clearBtn').onclick = async () => {
    if (!confirm('Clear your entire purchase history? This cannot be undone.')) return;
    try {
        await backendFetch('/api/user/history-clear', { method: 'POST' });
        toast('History cleared successfully', 'success');
        await loadHistory();
    } catch (e) {
        toast(e.message, 'error');
    }
};
</script>
