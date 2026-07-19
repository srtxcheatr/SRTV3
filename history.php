<?php
$pageTitle = 'History — SRT X CHEATS';
$currentPage = 'history';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="shell">
    <div class="content">

        <div class="section-label">🏆 Purchase History</div>
        <div id="historyList"><div class="dim" style="text-align:center;padding:24px">Loading...</div></div>

        <button class="btn btn-danger" id="clearBtn" style="margin-top:16px">🗑️ Clear History</button>

    </div>
</div>

<style>
.hist-card {
    background: var(--panel); border: 1px solid var(--border); clip-path: var(--clip-panel);
    padding: 14px; margin-bottom: 10px; backdrop-filter: blur(6px);
}
.hist-top { display: flex; justify-content: space-between; margin-bottom: 6px; }
.hist-name { font-family: var(--font-display); font-weight: 700; font-size: 12.5px; }
.hist-price { color: var(--gold); font-family: var(--font-display); font-weight: 700; font-size: 12px; }
.hist-meta { color: var(--text3); font-size: 11px; margin-bottom: 8px; }
.hist-key {
    background: rgba(0,255,163,0.06); border: 1px solid rgba(0,255,163,0.3); clip-path: var(--clip-btn);
    padding: 8px 10px; word-break: break-all; color: var(--success); font-size: 11px; font-weight: 700;
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
        document.getElementById('historyList').innerHTML = `<div style="color:var(--danger);font-size:12px">Couldn't load: ${esc(e.message)}</div>`;
    }
}

function renderHistory(items) {
    const el = document.getElementById('historyList');
    if (!items.length) {
        el.innerHTML = '<div class="dim" style="text-align:center;padding:24px">No purchases yet — check the Store!</div>';
        return;
    }
    el.innerHTML = items.map(it => `
        <div class="hist-card">
            <div class="hist-top"><span class="hist-name">${esc(it.name || '—')}</span><span class="hist-price">Rs ${it.price ?? '—'}</span></div>
            <div class="hist-meta">${esc(it.duration || '')} · ${fmtDate(it.at)}</div>
            ${it.key ? `<div class="hist-key">${esc(it.key)}</div>` : ''}
        </div>
    `).join('');
}

document.getElementById('clearBtn').onclick = async () => {
    if (!confirm('Clear your entire purchase history? This cannot be undone.')) return;
    try {
        await backendFetch('/api/user/history-clear', { method: 'POST' });
        toast('History cleared', 'success');
        await loadHistory();
    } catch (e) {
        toast(e.message, 'error');
    }
};
</script>

</body>
</html>
