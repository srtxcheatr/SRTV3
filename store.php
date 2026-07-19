<?php
$pageTitle = 'Store — SRT X CHEATS';
$currentPage = 'store';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="shell">
    <div class="content">

        <div class="panel">
            <div class="balance-hud">
                <div>
                    <div class="balance-label">Wallet Balance</div>
                    <div class="balance-amount">Rs <span id="balAmount">—</span></div>
                </div>
                <div class="rank-badge" id="statusBadge">—</div>
            </div>
            <div class="xp-track"><div class="xp-fill" id="balBar" style="width:0"></div></div>
        </div>

        <div class="panel" style="border-color:rgba(255,204,51,0.25)">
            <div class="section-label">📢 Announcement</div>
            <div id="noticeText" class="dim" style="font-size:13px">loading...</div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:8px">
            <button class="btn btn-secondary" id="openTopup">💰 Top Up</button>
            <button class="btn btn-ghost" id="openProfile">👤 Profile</button>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:20px">
            <button class="btn btn-ghost" id="openBalHistory" style="font-size:11px">📊 Balance Log</button>
            <a href="<?= htmlspecialchars(ABOUT_URL) ?>" target="_blank" class="btn btn-ghost" style="font-size:11px;text-decoration:none">ℹ️ About</a>
        </div>

        <div class="section-label">🎮 Product Catalog</div>
        <div id="catalogList"><div class="dim" style="text-align:center;padding:24px">Loading catalog...</div></div>

    </div>
</div>

<!-- ---- Checkout confirm modal ---- -->
<div id="checkoutModal" class="modal-overlay hidden">
    <div class="panel modal-panel">
        <div class="section-label">⚡ Confirm Purchase</div>
        <div id="checkoutSummary" style="margin-bottom:14px"></div>
        <div class="field"><label>Your Name</label><input type="text" id="payName" placeholder="For delivery contact"></div>
        <div class="field"><label>WhatsApp Number</label><input type="text" id="payWA" placeholder="98xxxxxxxx"></div>
        <button class="btn btn-primary" id="confirmBuyBtn" style="margin-bottom:10px">▸ Confirm Purchase</button>
        <button class="btn btn-ghost" onclick="closeModal('checkoutModal')">Cancel</button>
    </div>
</div>

<!-- ---- Delivery progress modal ---- -->
<div id="deliveryModal" class="modal-overlay hidden">
    <div class="panel modal-panel" style="text-align:center">
        <div class="section-label" style="justify-content:center">🚚 Delivering Your Key</div>
        <div class="delivery-track">
            <div class="delivery-road"></div>
            <div class="delivery-truck" id="deliveryTruck">🚀</div>
        </div>
        <div class="dim" id="deliveryLabel" style="font-size:12px;margin-top:10px">Connecting to server...</div>
        <div class="dim" id="deliveryPct" style="font-family:var(--font-display);font-size:20px;margin-top:6px">0%</div>
    </div>
</div>

<!-- ---- Key delivered modal ---- -->
<div id="keyModal" class="modal-overlay hidden">
    <div class="panel modal-panel" style="text-align:center">
        <div style="font-size:40px;margin-bottom:8px">🏆</div>
        <div class="section-label" style="justify-content:center">Key Delivered!</div>
        <div id="keyProductName" style="font-size:13px;margin-bottom:10px" class="dim"></div>
        <div class="key-box" id="keyValue"></div>
        <button class="btn btn-primary" style="margin-top:14px" onclick="closeModal('keyModal')">Awesome!</button>
    </div>
</div>

<!-- ---- Top-up modal ---- -->
<div id="topupModal" class="modal-overlay hidden">
    <div class="panel modal-panel">
        <div class="section-label">💰 Top Up Balance</div>
        <div class="dim" style="font-size:12px;margin-bottom:12px" id="topupHint">Pay via eSewa, then submit your transaction ID. Admin verifies and credits shortly.</div>
        <div class="qr-box">
            <img src="https://i.postimg.cc/zXm07q9C/Screenshot-20260425-142906.jpg" alt="eSewa QR">
            <div class="dim" style="text-align:center;font-size:11px;margin-top:6px">Scan with eSewa App</div>
        </div>
        <div class="field"><label>Amount (Rs)</label><input type="number" id="topupAmount" value="100" min="50"></div>
        <div class="field"><label>Your eSewa ID</label><input type="text" id="topupEsewa" placeholder="phone or email"></div>
        <div class="field"><label>Transaction Code</label><input type="text" id="topupTx" placeholder="e.g. JRJDHD"></div>
        <button class="btn btn-primary" id="submitTopup" style="margin-bottom:10px">▸ Submit</button>
        <button class="btn btn-ghost" onclick="closeModal('topupModal')">Cancel</button>
    </div>
</div>

<!-- ---- Profile modal ---- -->
<div id="profileModal" class="modal-overlay hidden">
    <div class="panel modal-panel">
        <div class="section-label">👤 Player Profile</div>
        <div class="field"><label>Display Name</label><input type="text" id="profName"></div>
        <div class="field"><label>WhatsApp Number</label><input type="text" id="profPhone"></div>
        <button class="btn btn-primary" id="saveProfile" style="margin-bottom:16px">▸ Save Profile</button>

        <div class="field">
            <label>Email Address</label>
            <input type="text" id="profEmail" readonly style="color:var(--text2)">
        </div>
        <div class="field">
            <label>Player ID (UID)</label>
            <div style="display:flex;gap:6px">
                <input type="text" id="profUid" readonly style="color:var(--text2);font-size:10px">
                <button class="btn btn-ghost" style="width:auto;padding:0 14px" onclick="navigator.clipboard.writeText(document.getElementById('profUid').value); window.__toastCopy()">Copy</button>
            </div>
        </div>
        <button class="btn btn-secondary" id="openPassword" style="margin:14px 0 10px">🔒 Change Password</button>
        <button class="btn btn-ghost" onclick="closeModal('profileModal')">Close</button>
    </div>
</div>

<!-- ---- Change password modal ---- -->
<div id="passwordModal" class="modal-overlay hidden">
    <div class="panel modal-panel">
        <div class="section-label">🔒 Change Password</div>
        <div class="field"><label>Current Password</label><input type="password" id="curPass" autocomplete="current-password"></div>
        <div class="field"><label>New Password (min 6 chars)</label><input type="password" id="newPass" autocomplete="new-password"></div>
        <button class="btn btn-primary" id="savePassword" style="margin-bottom:10px">▸ Update Password</button>
        <button class="btn btn-ghost" onclick="closeModal('passwordModal')">Cancel</button>
    </div>
</div>

<!-- ---- Balance history modal ---- -->
<div id="balHistoryModal" class="modal-overlay hidden">
    <div class="panel modal-panel" style="max-height:80vh;overflow-y:auto">
        <div class="section-label">📊 Balance Log</div>
        <div id="balHistoryList"></div>
        <button class="btn btn-ghost" style="margin-top:10px" onclick="closeModal('balHistoryModal')">Close</button>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed; inset: 0; z-index: 100;
    background: rgba(4,5,15,0.88);
    display: flex; align-items: center; justify-content: center;
    padding: 20px; backdrop-filter: blur(4px);
}
.modal-panel { max-width: 400px; width: 100%; margin: auto; max-height: 85vh; overflow-y: auto; }

.cat-item {
    background: var(--panel); border: 1px solid var(--border); clip-path: var(--clip-panel);
    margin-bottom: 10px; overflow: hidden; backdrop-filter: blur(6px);
}
.cat-head { display: flex; align-items: center; gap: 12px; padding: 12px; cursor: pointer; }
.cat-img {
    width: 46px; height: 46px; border-radius: 10px; overflow: hidden; flex-shrink: 0;
    border: 1px solid var(--border); background: #0a0c1f;
}
.cat-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.cat-head .name { flex: 1; font-family: var(--font-display); font-size: 12px; font-weight: 700; letter-spacing: 0.3px; }
.cat-tag {
    font-family: var(--font-display); font-size: 9px; font-weight: 700; letter-spacing: 0.5px;
    padding: 3px 8px; border-radius: 6px; border: 1px solid var(--border); color: var(--text2);
}
.cat-tag.root { color: var(--danger); border-color: rgba(255,59,92,0.35); }
.cat-tag.nonroot { color: var(--success); border-color: rgba(0,255,163,0.35); }
.cat-tag.ios { color: var(--secondary); border-color: rgba(0,229,255,0.35); }
.cat-tag.pc { color: var(--gold); border-color: rgba(255,204,51,0.35); }
.cat-arrow { font-size: 11px; color: var(--text3); transition: transform 0.2s ease; }
.cat-item.open .cat-arrow { transform: rotate(90deg); }
.cat-body { display: none; border-top: 1px solid var(--border); }
.cat-item.open .cat-body { display: block; }
.dur-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 11px 14px; font-size: 12.5px; font-weight: 600; border-top: 1px solid var(--border); cursor: pointer;
    transition: background 0.15s ease;
}
.dur-row:active { background: rgba(255,255,255,0.04); }
.dur-row .price { color: var(--gold); font-family: var(--font-display); font-weight: 700; font-size: 12px; }

.qr-box {
    background: rgba(255,255,255,0.03); border: 1px solid var(--border); clip-path: var(--clip-btn);
    padding: 14px; margin-bottom: 12px; text-align: center;
}
.qr-box img { width: 150px; height: 150px; object-fit: contain; border-radius: 8px; }

.key-box {
    background: rgba(0,255,163,0.06); border: 1px solid rgba(0,255,163,0.35); clip-path: var(--clip-btn);
    padding: 14px; word-break: break-all; color: var(--success); font-family: var(--font-display);
    font-weight: 700; font-size: 13px; text-shadow: 0 0 12px rgba(0,255,163,0.3);
}

.log-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0; border-bottom: 1px solid var(--border); font-size: 12.5px;
}
.log-item:last-child { border-bottom: none; }

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

        const badge = document.getElementById('statusBadge');
        badge.textContent = d.requestStatus;
        badge.style.color = d.requestStatus === 'Active' ? 'var(--success)'
            : d.requestStatus === 'Pending' ? 'var(--gold)' : 'var(--danger)';
        badge.style.borderColor = d.requestStatus === 'Active' ? 'rgba(0,255,163,0.4)'
            : d.requestStatus === 'Pending' ? 'rgba(255,204,51,0.4)' : 'rgba(255,59,92,0.4)';

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

// ---- First-time top-up lock (server confirms the real state — this
// is just reflecting it in the UI, the actual enforcement is in the
// backend so it can't be bypassed via devtools) ----
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
        document.getElementById('catalogList').innerHTML = '<div style="color:var(--danger);font-size:12px;text-align:center">Failed to load catalog</div>';
    }
}

function renderCatalog() {
    const groups = {};
    for (const [sku, p] of Object.entries(catalog)) {
        if (!groups[p.row]) groups[p.row] = [];
        groups[p.row].push({ sku, ...p });
    }
    const tagOf = (row) => /root/i.test(row) && !/non ?root/i.test(row) ? 'root'
        : /ios/i.test(row) ? 'ios'
        : /pc/i.test(row) ? 'pc'
        : 'nonroot';

    const html = Object.entries(groups).map(([row, items], gi) => `
        <div class="cat-item" id="cat-${gi}">
            <div class="cat-head" onclick="document.getElementById('cat-${gi}').classList.toggle('open')">
                <div class="cat-img"><img src="${items[0].image || ''}" alt="${esc(row)}" loading="lazy"></div>
                <span class="name">${esc(row)}</span>
                <span class="cat-tag ${tagOf(row)}">${tagOf(row).toUpperCase()}</span>
                <span class="cat-arrow">▸</span>
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
    `).join('');
    document.getElementById('catalogList').innerHTML = html;
}

window.__startCheckout = (sku) => {
    const p = catalog[sku];
    if (!p) return;
    pendingCheckout = { sku, ...p };
    document.getElementById('checkoutSummary').innerHTML = `
        <div class="log-item"><span class="dim">Product</span><span>${esc(p.name)}</span></div>
        <div class="log-item"><span class="dim">Duration</span><span>${esc(p.duration)}</span></div>
        <div class="log-item"><span class="dim">Price</span><span style="color:var(--gold);font-weight:700">Rs ${p.price}</span></div>
    `;
    openModal('checkoutModal');
};

// ---- Checkout with real progress polling ----
// The animation only moves as far as the backend has actually gotten
// (via a real job-status endpoint), not a fake timer — see
// /api/purchase/checkout/status/:jobId in the backend.
document.getElementById('confirmBuyBtn').onclick = async () => {
    if (!pendingCheckout) return;
    const name = document.getElementById('payName').value.trim();
    const waNum = document.getElementById('payWA').value.trim();

    closeModal('checkoutModal');
    openModal('deliveryModal');
    setTruckProgress(0, 'Connecting to server...');

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
    }
};

function setTruckProgress(pct, label) {
    document.getElementById('deliveryTruck').style.left = `calc(${pct}% - ${pct * 0.2}px)`;
    document.getElementById('deliveryPct').textContent = pct + '%';
    if (label) document.getElementById('deliveryLabel').textContent = label;
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
document.getElementById('submitTopup').onclick = async () => {
    const amount = parseInt(document.getElementById('topupAmount').value, 10);
    const esewaId = document.getElementById('topupEsewa').value.trim();
    const txCode = document.getElementById('topupTx').value.trim();
    try {
        await backendFetch('/api/user/topup', { method: 'POST', body: JSON.stringify({ amount, esewaId, txCode }) });
        toast('Submitted — awaiting admin approval', 'success');
        closeModal('topupModal');
    } catch (e) {
        toast(e.message, 'error');
    }
};

// ---- Profile ----
document.getElementById('openProfile').onclick = () => openModal('profileModal');
document.getElementById('saveProfile').onclick = async () => {
    const name = document.getElementById('profName').value.trim();
    const phone = document.getElementById('profPhone').value.trim();
    try {
        await backendFetch('/api/user/profile', { method: 'POST', body: JSON.stringify({ name, phone }) });
        toast('Saved', 'success');
        closeModal('profileModal');
    } catch (e) {
        toast(e.message, 'error');
    }
};

// ---- Change password ----
document.getElementById('openPassword').onclick = () => openModal('passwordModal');
document.getElementById('savePassword').onclick = async () => {
    const curPass = document.getElementById('curPass').value;
    const newPass = document.getElementById('newPass').value;
    if (!curPass || !newPass) return toast('Fill both fields', 'error');
    if (newPass.length < 6) return toast('New password must be at least 6 characters', 'error');
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
    }
};

// ---- Balance history (with localStorage cache for instant display) ----
document.getElementById('openBalHistory').onclick = async () => {
    openModal('balHistoryModal');

    // Cache is a speed layer only — never treated as the source of
    // truth. It's shown instantly, then immediately overwritten by
    // whatever the backend actually says.
    const cached = localStorage.getItem('srtx_bal_log_cache');
    if (cached) renderBalHistory(JSON.parse(cached));

    try {
        const d = await backendFetch('/api/user/balance-history');
        renderBalHistory(d.log || []);
        localStorage.setItem('srtx_bal_log_cache', JSON.stringify(d.log || []));
    } catch (e) {
        if (!cached) document.getElementById('balHistoryList').innerHTML = `<div style="color:var(--danger);font-size:12px">${esc(e.message)}</div>`;
    }
};
function renderBalHistory(list) {
    document.getElementById('balHistoryList').innerHTML = list.length ? list.map(l => `
        <div class="log-item">
            <div>
                <div style="color:${l.delta >= 0 ? 'var(--success)' : 'var(--danger)'};font-weight:700">${l.delta >= 0 ? '+' : ''}${l.delta}</div>
                <div class="dim" style="font-size:10.5px">${esc(l.note || '')}</div>
            </div>
            <div style="text-align:right">
                <div class="dim" style="font-size:10.5px">${fmtDate(l.at)}</div>
                <div style="font-size:11px">→ Rs ${l.resultingBalance}</div>
            </div>
        </div>
    `).join('') : '<div class="dim" style="text-align:center;padding:16px">No balance changes yet</div>';
}
</script>

</body>
</html>
