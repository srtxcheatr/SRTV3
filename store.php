<?php
$pageTitle = 'Store — SRT X CHEATS';
$currentPage = 'store';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
    <div class="term-content">

        <div class="panel" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px">
            <div>
                <div class="dim" style="font-size:11px"><i class="fas fa-wallet"></i> balance</div>
                <div style="color:var(--amber);font-weight:800;font-size:20px" class="mono-num">Rs <span id="balAmount">—</span></div>
            </div>
            <div style="flex:1;min-width:80px;margin-top:4px">
                <div class="xp-track" style="height:4px;border-radius:4px;background:rgba(255,255,255,0.06)">
                    <div class="xp-fill" id="balBar" style="width:0;height:100%;background:linear-gradient(90deg,var(--amber),var(--gold));border-radius:4px;transition:width 0.3s"></div>
                </div>
            </div>
            <div style="text-align:right">
                <div class="dim" style="font-size:11px"><i class="fas fa-circle"></i> status</div>
                <div id="statusVal" style="font-weight:700;font-size:13px">—</div>
            </div>
        </div>

        <div class="panel" id="noticePanel" style="border-color:var(--border-strong)">
            <div class="dim" style="font-size:11px;margin-bottom:4px"><i class="fas fa-terminal"></i> admin-notice.txt</div>
            <div id="noticeText" style="font-size:12px;color:var(--text2)">loading...</div>
        </div>

        <div style="display:flex;gap:8px;margin-bottom:8px;flex-wrap:wrap">
            <button class="btn btn-ghost" id="openTopup" style="font-size:12px;flex:1;min-width:100px"><i class="fas fa-coins"></i> ./topup.sh</button>
            <button class="btn btn-ghost" id="openProfile" style="font-size:12px;flex:1;min-width:100px"><i class="fas fa-user-edit"></i> ./profile.sh</button>
            <!-- Removed ./keys.sh -->
        </div>
        <div style="display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap">
            <button class="btn btn-ghost" id="openHelp" style="font-size:12px;flex:1"><i class="fas fa-life-ring"></i> ./help.sh</button>
            <button class="btn btn-ghost" id="openPassword" style="font-size:12px;flex:1"><i class="fas fa-key"></i> ./passwd.sh</button>
            <!-- Removed ./apk.sh -->
            <a href="https://srtxcheat.github.io/About" target="_blank" class="btn btn-ghost" style="font-size:12px;flex:1;text-decoration:none"><i class="fas fa-code"></i> ./about.sh</a>
        </div>

        <div class="prompt-header"><i class="fas fa-folder-open"></i> ls -la /catalog</div>

        <div style="position:relative;margin-bottom:8px">
            <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text3);font-size:12px"></i>
            <input type="text" id="catalogSearch" placeholder="search products..." style="padding-left:32px">
        </div>
        <div id="catFilters" style="display:flex;gap:6px;margin-bottom:12px;overflow-x:auto;padding-bottom:2px">
            <button class="cat-filter active" data-tag="ALL">ALL</button>
            <button class="cat-filter" data-tag="ROOT">ROOT</button>
            <button class="cat-filter" data-tag="NONROOT">NONROOT</button>
            <button class="cat-filter" data-tag="PC">PC</button>
            <button class="cat-filter" data-tag="IOS">IOS</button>
        </div>

        <div class="dim" style="font-size:10px;margin-bottom:8px;padding:0 2px">
            <i class="fas fa-cubes"></i> tap a product to see pricing options
        </div>
        <div id="catalogList"><div class="dim" style="text-align:center;padding:20px"><i class="fas fa-spinner fa-pulse"></i> loading catalog...</div></div>

    </div>
</div>

<!-- ---- Checkout confirm modal ---- -->
<div id="checkoutModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header"><i class="fas fa-shopping-cart"></i> confirm --purchase</div>
        <div id="checkoutSummary" style="font-size:13px;margin-bottom:12px"></div>
        <div class="field"><label><i class="fas fa-user"></i> your name</label><input type="text" id="payName" placeholder="For delivery contact"></div>
        <div class="field"><label><i class="fab fa-whatsapp"></i> whatsapp number</label><input type="text" id="payWA" placeholder="98xxxxxxxx"></div>
        <button class="btn btn-solid" id="confirmBuyBtn" style="margin-bottom:8px;position:relative">
            <span class="btn-text"><i class="fas fa-check"></i> confirm.sh</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>
        <button class="btn btn-ghost" onclick="closeModal('checkoutModal')"><i class="fas fa-times"></i> cancel</button>
    </div>
</div>

<!-- ---- Delivery progress modal ---- -->
<div id="deliveryModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto;text-align:center">
        <div class="prompt-header" style="justify-content:center"><i class="fas fa-truck fa-fw fa-pulse" style="color:var(--amber)"></i> delivering key...</div>
        <div class="delivery-track">
            <div class="delivery-road"></div>
            <div class="delivery-truck" id="deliveryTruck"><i class="fas fa-rocket fa-fw fa-spin" style="color:var(--green);font-size:28px"></i></div>
        </div>
        <div class="dim" id="deliveryLabel" style="font-size:12px;margin-top:10px"><i class="fas fa-sync-alt fa-spin"></i> Connecting to server...</div>
        <div class="dim" id="deliveryPct" style="font-family:var(--font-display);font-size:20px;margin-top:6px">0%</div>
    </div>
</div>

<!-- ---- Key delivered modal ---- -->
<div id="keyModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header"><i class="fas fa-check-circle" style="color:var(--green)"></i> cat delivered_key.txt</div>
        <div id="keyProductName" style="font-size:13px;margin-bottom:6px"></div>
        <div style="background:#040a06;border:1px solid var(--border-strong);border-radius:var(--radius-sm);padding:12px;word-break:break-all;color:var(--green);font-weight:700;margin-bottom:12px" id="keyValue"></div>
        <button class="btn btn-solid" onclick="closeModal('keyModal')"><i class="fas fa-thumbs-up"></i> done</button>
    </div>
</div>

<!-- ---- Top-up modal ---- -->
<div id="topupModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header"><i class="fas fa-coins"></i> topup --esewa</div>
        <div class="dim" style="font-size:12px;margin-bottom:12px" id="topupHint"><i class="fas fa-info-circle"></i> Pay via eSewa, then submit your transaction ID. Admin verifies and credits shortly.</div>
        <div class="qr-wrap">
            <img src="https://i.postimg.cc/zXm07q9C/Screenshot-20260425-142906.jpg" alt="eSewa QR">
            <div class="dim" style="text-align:center;font-size:11px;margin-top:6px"><i class="fas fa-qrcode"></i> Scan with eSewa App</div>
        </div>
        <div class="field"><label><i class="fas fa-rupee-sign"></i> amount (Rs)</label><input type="number" id="topupAmount" value="100" min="50"></div>
        <div class="field"><label><i class="fas fa-id-card"></i> your eSewa ID</label><input type="text" id="topupEsewa" placeholder="phone or email"></div>
        <div class="field"><label><i class="fas fa-hashtag"></i> transaction code</label><input type="text" id="topupTx" placeholder="e.g. JRJDHD"></div>
        <button class="btn btn-solid" id="submitTopup" style="margin-bottom:8px;position:relative">
            <span class="btn-text"><i class="fas fa-paper-plane"></i> submit.sh</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>
        <button class="btn btn-ghost" onclick="closeModal('topupModal')"><i class="fas fa-times"></i> cancel</button>
    </div>
</div>

<!-- ---- Profile modal ---- -->
<div id="profileModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header"><i class="fas fa-user-edit"></i> profile --edit</div>
        <div class="field"><label><i class="fas fa-user"></i> display name</label><input type="text" id="profName"></div>
        <div class="field"><label><i class="fab fa-whatsapp"></i> whatsapp number</label><input type="text" id="profPhone"></div>
        <button class="btn btn-solid" id="saveProfile" style="margin-bottom:14px;position:relative">
            <span class="btn-text"><i class="fas fa-save"></i> save.sh</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>

        <div class="field">
            <label><i class="fas fa-envelope"></i> email address</label>
            <input type="text" id="profEmail" readonly style="color:var(--text2)">
        </div>
        <div class="field">
            <label><i class="fas fa-id-badge"></i> user id (uid)</label>
            <div style="display:flex;gap:6px">
                <input type="text" id="profUid" readonly style="color:var(--text2);font-size:11px">
                <button class="btn btn-ghost" style="width:auto;padding:0 12px" onclick="navigator.clipboard.writeText(document.getElementById('profUid').value); window.__toastCopy()"><i class="fas fa-copy"></i> copy</button>
            </div>
        </div>
        <button class="btn btn-ghost" onclick="closeModal('profileModal')"><i class="fas fa-times"></i> close</button>
    </div>
</div>

<!-- ---- Report a problem modal ---- -->
<div id="helpModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header"><i class="fas fa-life-ring"></i> report --problem</div>
        <div class="dim" style="font-size:12px;margin-bottom:12px">
            Describe what's going wrong. Your account details (uid, email, balance) are attached automatically and sent straight to the admin.
        </div>
        <div class="field"><label><i class="fas fa-comment-dots"></i> describe issue</label><textarea id="problemText" rows="5" placeholder="e.g. Purchase failed after payment, balance not updated..."></textarea></div>
        <button class="btn btn-solid" id="submitReport" style="margin-bottom:8px;position:relative">
            <span class="btn-text"><i class="fas fa-paper-plane"></i> send.sh</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>
        <button class="btn btn-ghost" onclick="closeModal('helpModal')"><i class="fas fa-times"></i> cancel</button>
    </div>
</div>

<!-- ---- Change password modal ---- -->
<div id="passwordModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header"><i class="fas fa-key"></i> passwd --change</div>
        <div class="field"><label><i class="fas fa-lock"></i> current password</label><input type="password" id="curPass" autocomplete="current-password"></div>
        <div class="field"><label><i class="fas fa-unlock-alt"></i> new password (min 6 chars)</label><input type="password" id="newPass" autocomplete="new-password"></div>
        <button class="btn btn-solid" id="savePassword" style="margin-bottom:8px;position:relative">
            <span class="btn-text"><i class="fas fa-sync-alt"></i> update.sh</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>
        <button class="btn btn-ghost" onclick="closeModal('passwordModal')"><i class="fas fa-times"></i> cancel</button>
    </div>
</div>

<style>
/* ---- modal overlay ---- */
.modal-overlay {
    position: fixed; inset: 0; z-index: 100;
    background: rgba(2,6,4,0.85);
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
}
/* ---- search + category filters ---- */
.cat-filter {
    flex-shrink: 0;
    background: var(--panel); border: 1px solid var(--border); border-radius: 999px;
    color: var(--text3); font-family: inherit; font-size: 11px; font-weight: 700;
    letter-spacing: 0.4px; padding: 6px 14px; cursor: pointer; white-space: nowrap;
    transition: color .15s ease, border-color .15s ease, background .15s ease;
}
.cat-filter.active {
    color: var(--green); border-color: var(--border-strong);
    background: rgba(52,227,122,0.08);
}
/* ---- catalog cards — big hero image, like a real product card ---- */
.cat-row {
    background: var(--panel); border: 1px solid var(--border); border-radius: var(--radius);
    margin-bottom: 14px; overflow: hidden;
}
.cat-head { cursor: pointer; }
.cat-img {
    width: 100%; aspect-ratio: 16 / 10; overflow: hidden;
    background: #040a06; border-bottom: 1px solid var(--border);
    position: relative;
}
.cat-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.cat-img .cat-tag-badge {
    position: absolute; top: 10px; right: 10px;
    font-size: 10px; font-weight: 800; letter-spacing: 0.5px;
    padding: 4px 10px; border-radius: 999px;
    background: rgba(2,6,4,0.75); border: 1px solid var(--border-strong);
    color: var(--green); backdrop-filter: blur(4px);
}
.cat-info { padding: 12px 14px; display: flex; align-items: center; gap: 10px; }
.cat-head .name { flex: 1; font-size: 14px; font-weight: 700; letter-spacing: 0.2px; }
.cat-head .price-range { font-size: 12px; color: var(--amber); font-weight: 700; }
.cat-arrow { font-size: 11px; color: var(--text3); transition: transform .2s; }
.cat-row.open .cat-arrow { transform: rotate(90deg); }
.cat-body { display: none; border-top: 1px solid var(--border); }
.cat-row.open .cat-body { display: block; }
.dur-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 12px 14px; font-size: 13px; border-top: 1px solid var(--border);
    cursor: pointer;
}
.dur-row:active { background: var(--panel2); }
.dur-row .price { color: var(--amber); font-weight: 700; }
.qr-wrap {
    background: #040a06; border: 1px solid var(--border); border-radius: var(--radius-sm);
    padding: 12px; margin-bottom: 12px; text-align: center;
}
.qr-wrap img { width: 160px; height: 160px; object-fit: contain; border-radius: 6px; }

/* ---- delivery truck animation ---- */
.delivery-track {
    position: relative; height: 50px; margin: 20px 0 6px;
    background: rgba(255,255,255,0.03); border-radius: 12px; overflow: hidden;
    border: 1px solid var(--border);
}
.delivery-road {
    position: absolute; bottom: 10px; left: 6%; right: 6%; height: 2px;
    background: repeating-linear-gradient(to right, var(--text3) 0 8px, transparent 8px 16px);
}
.delivery-truck {
    position: absolute; bottom: 4px; left: 0%; font-size: 26px;
    transition: left 0.4s cubic-bezier(0.22,1,0.36,1);
    filter: drop-shadow(0 0 8px var(--secondary-glow));
}

/* ---- button loading states ---- */
.btn {
    position: relative;
}
.btn .btn-spinner {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-left: 8px;
}
.btn .btn-spinner .spinner {
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255,255,255,0.2);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
.btn.loading .btn-text { visibility: hidden; }
.btn.loading .btn-spinner { display: inline-flex; }
.btn.loading .btn-spinner .spinner { display: inline-block; }

@keyframes spin {
    to { transform: rotate(360deg); }
}

.hidden { display: none !important; }
</style>

<script type="module">
import {
    requireAuth, backendFetch, toast, fmtDate, esc,
    auth, EmailAuthProvider, reauthenticateWithCredential, updatePassword,
} from '/assets/js/app.js';

let userState = {};
let catalog = {};
let pendingCheckout = null;
let currentUid = '';

window.closeModal = (id) => document.getElementById(id).classList.add('hidden');
window.openModal = (id) => document.getElementById(id).classList.remove('hidden');
window.__toastCopy = () => toast('Copied', 'success');

// ---- button loading helpers ----
function setLoading(btn, loading) {
    if (!btn) return;
    if (loading) {
        btn.classList.add('loading');
        btn.disabled = true;
    } else {
        btn.classList.remove('loading');
        btn.disabled = false;
    }
}

requireAuth(async (user) => {
    currentUid = user.uid;
    await Promise.all([loadBalance(), loadCatalog()]);
});

async function loadBalance() {
    try {
        const d = await backendFetch('/api/user/balance');
        userState = d;
        document.getElementById('balAmount').textContent = d.balance;
        document.getElementById('balBar').style.width = Math.min(100, d.balance / 10) + '%';
        document.getElementById('statusVal').textContent = d.requestStatus;
        document.getElementById('statusVal').style.color =
            d.requestStatus === 'Active' ? 'var(--green)' :
            d.requestStatus === 'Pending' ? 'var(--amber)' : 'var(--red)';
        document.getElementById('noticeText').textContent = d.adminMessage || 'No messages.';
        document.getElementById('profName').value = d.profileName || '';
        document.getElementById('profPhone').value = d.profilePhone || '';
        document.getElementById('profEmail').value = d.email || '';
        document.getElementById('profUid').value = currentUid;
        document.getElementById('payName').value = d.profileName || '';
        document.getElementById('payWA').value = d.profilePhone || '';
        setupTopupLock(d.hasCompletedFirstTopup);
    } catch (e) {
        toast(e.message, 'error');
    }
}

function setupTopupLock(hasCompletedFirstTopup) {
    const amountInput = document.getElementById('topupAmount');
    const hint = document.getElementById('topupHint');
    if (!hasCompletedFirstTopup) {
        amountInput.value = 1000;
        amountInput.readOnly = true;
        amountInput.style.opacity = '0.6';
        hint.textContent = 'Your first top-up is fixed at Rs 1,000. After it\'s approved, you can top up any amount.';
    } else {
        amountInput.readOnly = false;
        amountInput.style.opacity = '1';
        amountInput.value = 100;
        hint.textContent = 'Pay via eSewa, then submit your transaction ID. Admin verifies and credits shortly.';
    }
}

async function loadCatalog() {
    try {
        const r = await fetch(`${window.BACKEND_URL}/api/catalog`);
        const d = await r.json();
        catalog = d.catalog;
        renderCatalog();
    } catch (e) {
        document.getElementById('catalogList').innerHTML = '<div style="color:var(--red);font-size:12px"><i class="fas fa-exclamation-triangle"></i> Failed to load catalog</div>';
    }
}

let searchQuery = '';
let activeTag = 'ALL';

const tagOf = (row) => /root/i.test(row) && !/non ?root/i.test(row) ? 'ROOT'
    : /ios/i.test(row) ? 'IOS'
    : /pc/i.test(row) ? 'PC'
    : 'NONROOT';

function renderCatalog() {
    const groups = {};
    for (const [sku, p] of Object.entries(catalog)) {
        if (!groups[p.row]) groups[p.row] = [];
        groups[p.row].push({ sku, ...p });
    }

    const q = searchQuery.trim().toLowerCase();
    const filteredEntries = Object.entries(groups).filter(([row, items]) => {
        if (activeTag !== 'ALL' && tagOf(row) !== activeTag) return false;
        if (!q) return true;
        // Matches against the row name AND every duration's product
        // name, so a search for e.g. a specific variant still finds it.
        return row.toLowerCase().includes(q) || items.some((it) => it.name.toLowerCase().includes(q));
    });

    if (!filteredEntries.length) {
        document.getElementById('catalogList').innerHTML =
            '<div class="dim" style="text-align:center;padding:24px"><i class="fas fa-ghost"></i> No products match</div>';
        return;
    }

    const html = filteredEntries.map(([row, items], gi) => {
        const prices = items.map((it) => it.price);
        const priceRange = Math.min(...prices) === Math.max(...prices)
            ? `Rs ${prices[0]}`
            : `Rs ${Math.min(...prices)}–${Math.max(...prices)}`;
        return `
        <div class="cat-row" id="cat-${gi}">
            <div class="cat-head" onclick="document.getElementById('cat-${gi}').classList.toggle('open')">
                <div class="cat-img">
                    <img src="${items[0].image || ''}" alt="${esc(row)}" loading="lazy">
                    <span class="cat-tag-badge">${tagOf(row)}</span>
                </div>
                <div class="cat-info">
                    <div style="flex:1">
                        <div class="name">${esc(row)}</div>
                        <div class="price-range">${priceRange}</div>
                    </div>
                    <span class="cat-arrow"><i class="fas fa-chevron-right"></i></span>
                </div>
            </div>
            <div class="cat-body">
                ${items.map(it => `
                    <div class="dur-row" onclick="window.__startCheckout('${it.sku}')">
                        <span>${esc(it.name)} <span class="dim">· ${esc(it.duration)}</span></span>
                        <span class="price">Rs ${it.price}</span>
                    </div>
                `).join('')}
            </div>
        </div>
    `;
    }).join('');
    document.getElementById('catalogList').innerHTML = html;
}

document.getElementById('catalogSearch').addEventListener('input', (e) => {
    searchQuery = e.target.value;
    renderCatalog();
});

document.getElementById('catFilters').addEventListener('click', (e) => {
    const btn = e.target.closest('.cat-filter');
    if (!btn) return;
    document.querySelectorAll('.cat-filter').forEach((b) => b.classList.remove('active'));
    btn.classList.add('active');
    activeTag = btn.dataset.tag;
    renderCatalog();
});

window.__startCheckout = (sku) => {
    const p = catalog[sku];
    if (!p) return;
    pendingCheckout = { sku, ...p };
    document.getElementById('checkoutSummary').innerHTML = `
        <div style="display:flex;justify-content:space-between;margin-bottom:4px"><span class="dim"><i class="fas fa-cube"></i> product</span><span>${esc(p.name)}</span></div>
        <div style="display:flex;justify-content:space-between;margin-bottom:4px"><span class="dim"><i class="fas fa-clock"></i> duration</span><span>${esc(p.duration)}</span></div>
        <div style="display:flex;justify-content:space-between"><span class="dim"><i class="fas fa-tag"></i> price</span><span class="price" style="color:var(--amber);font-weight:700">Rs ${p.price}</span></div>
    `;
    openModal('checkoutModal');
};

// ---- Checkout with real progress polling ----
const confirmBtn = document.getElementById('confirmBuyBtn');
confirmBtn.onclick = async () => {
    if (!pendingCheckout) return;
    const name = document.getElementById('payName').value.trim();
    const waNum = document.getElementById('payWA').value.trim();

    // Close the checkout modal immediately, before any network call —
    // this is what actually prevents accidental double-taps. Waiting
    // until after a successful response meant a failed/slow request
    // left the modal (and a clickable button) sitting on screen.
    closeModal('checkoutModal');
    openModal('deliveryModal');
    setTruckProgress(0, '<i class="fas fa-sync-alt fa-spin"></i> Connecting to server...');
    setLoading(confirmBtn, true);

    try {
        const start = await backendFetch('/api/purchase/checkout/start', {
            method: 'POST',
            body: JSON.stringify({ sku: pendingCheckout.sku, name, waNum }),
        });
        const jobId = start.jobId;

        const result = await pollJob(jobId);
        closeModal('deliveryModal');

        if (!result.success) {
            toast(result.error || 'Purchase failed', 'error');
            return;
        }

        document.getElementById('keyProductName').textContent = pendingCheckout.name;
        document.getElementById('keyValue').textContent = result.key;
        openModal('keyModal');
        document.getElementById('balAmount').textContent = result.newBalance;
        document.getElementById('balBar').style.width = Math.min(100, result.newBalance / 10) + '%';
    } catch (e) {
        closeModal('deliveryModal');
        toast(e.message, 'error');
    } finally {
        setLoading(confirmBtn, false);
        pendingCheckout = null;
    }
};

function setTruckProgress(pct, label) {
    document.getElementById('deliveryTruck').style.left = `calc(${pct}% - ${pct * 0.2}px)`;
    document.getElementById('deliveryPct').textContent = pct + '%';
    if (label) document.getElementById('deliveryLabel').innerHTML = label;
}

async function pollJob(jobId) {
    while (true) {
        const d = await backendFetch(`/api/purchase/checkout/status/${jobId}`);
        setTruckProgress(d.percent, d.label);
        if (d.done) return d;
        await new Promise((r) => setTimeout(r, 500));
    }
}

// ---- Top-up ----
document.getElementById('openTopup').onclick = () => openModal('topupModal');
const topupBtn = document.getElementById('submitTopup');
topupBtn.onclick = async () => {
    const amount = parseInt(document.getElementById('topupAmount').value, 10);
    const esewaId = document.getElementById('topupEsewa').value.trim();
    const txCode = document.getElementById('topupTx').value.trim();
    setLoading(topupBtn, true);
    try {
        await backendFetch('/api/user/topup', { method: 'POST', body: JSON.stringify({ amount, esewaId, txCode }) });
        toast('Submitted — awaiting admin approval', 'success');
        closeModal('topupModal');
    } catch (e) {
        toast(e.message, 'error');
    } finally {
        setLoading(topupBtn, false);
    }
};

// ---- Profile ----
document.getElementById('openProfile').onclick = () => openModal('profileModal');
const profileBtn = document.getElementById('saveProfile');
profileBtn.onclick = async () => {
    const name = document.getElementById('profName').value.trim();
    const phone = document.getElementById('profPhone').value.trim();
    setLoading(profileBtn, true);
    try {
        await backendFetch('/api/user/profile', { method: 'POST', body: JSON.stringify({ name, phone }) });
        toast('Saved', 'success');
        closeModal('profileModal');
    } catch (e) {
        toast(e.message, 'error');
    } finally {
        setLoading(profileBtn, false);
    }
};

// ---- Change password ----
document.getElementById('openPassword').onclick = () => openModal('passwordModal');
const passBtn = document.getElementById('savePassword');
passBtn.onclick = async () => {
    const curPass = document.getElementById('curPass').value;
    const newPass = document.getElementById('newPass').value;
    if (!curPass || !newPass) return toast('Fill both fields', 'error');
    if (newPass.length < 6) return toast('New password must be at least 6 characters', 'error');
    setLoading(passBtn, true);
    try {
        const cred = EmailAuthProvider.credential(auth.currentUser.email, curPass);
        await reauthenticateWithCredential(auth.currentUser, cred);
        await updatePassword(auth.currentUser, newPass);
        toast('Password updated', 'success');
        closeModal('passwordModal');
        document.getElementById('curPass').value = '';
        document.getElementById('newPass').value = '';
    } catch (e) {
        toast(e.code === 'auth/wrong-password' ? 'Current password is incorrect' : e.message, 'error');
    } finally {
        setLoading(passBtn, false);
    }
};

// ---- Help / Report a Problem ----
document.getElementById('openHelp').onclick = () => openModal('helpModal');
const reportBtn = document.getElementById('submitReport');
reportBtn.onclick = async () => {
    const problem = document.getElementById('problemText').value.trim();
    if (!problem) return toast('Please describe the problem', 'error');
    setLoading(reportBtn, true);
    try {
        await backendFetch('/api/user/report', { method: 'POST', body: JSON.stringify({ problem }) });
        toast('Report sent', 'success');
        document.getElementById('problemText').value = '';
        closeModal('helpModal');
    } catch (e) {
        toast(e.message, 'error');
    } finally {
        setLoading(reportBtn, false);
    }
};
</script>

</body>
</html>