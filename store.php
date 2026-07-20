<?php
$pageTitle = 'Store — SRT X CHEATS';
$currentPage = 'store';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
    <div class="term-content">

        <div class="panel" style="display:flex;justify-content:space-between;align-items:center">
            <div>
                <div class="dim" style="font-size:11px">balance</div>
                <div style="color:var(--amber);font-weight:800;font-size:20px" class="mono-num">Rs <span id="balAmount">—</span></div>
            </div>
            <div style="text-align:right">
                <div class="dim" style="font-size:11px">status</div>
                <div id="statusVal" style="font-weight:700;font-size:13px">—</div>
            </div>
        </div>

        <div class="panel" id="noticePanel" style="border-color:var(--border-strong)">
            <div class="dim" style="font-size:11px;margin-bottom:4px">### admin-notice.txt</div>
            <div id="noticeText" style="font-size:12px;color:var(--text2)">loading...</div>
        </div>

        <div style="display:flex;gap:8px;margin-bottom:8px;flex-wrap:wrap">
            <button class="btn btn-ghost" id="openTopup" style="font-size:12px;flex:1;min-width:100px">./topup.sh</button>
            <button class="btn btn-ghost" id="openProfile" style="font-size:12px;flex:1;min-width:100px">./profile.sh</button>
            <button class="btn btn-ghost" id="openPassword" style="font-size:12px;flex:1;min-width:100px">./passwd.sh</button>
        </div>
        <div style="display:flex;gap:8px;margin-bottom:16px">
            <button class="btn btn-ghost" id="openHelp" style="font-size:12px;flex:1">./help.sh</button>
            <!-- developer.sh link – uses the DEVELOPER_URL from config.php -->
            <a href="<?= htmlspecialchars(DEVELOPER_URL) ?>" target="_blank" class="btn btn-ghost" style="font-size:12px;flex:1;text-decoration:none">./developer.sh</a>
        </div>

        <div class="prompt-header">ls -la /catalog</div>
        <div class="dim" style="font-size:10px;margin-bottom:8px;padding:0 2px">
            <span style="display:inline-block;width:52%">NAME</span><span style="display:inline-block;width:20%">TAG</span><span>SIZE</span>
        </div>
        <div id="catalogList"><div class="dim" style="text-align:center;padding:20px">loading catalog...</div></div>

    </div>
</div>
<!-- ---- Checkout confirm modal ---- -->
<div id="checkoutModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header">confirm --purchase</div>
        <div id="checkoutSummary" style="font-size:13px;margin-bottom:12px"></div>
        <div class="field"><label>your name</label><input type="text" id="payName" placeholder="For delivery contact"></div>
        <div class="field"><label>whatsapp number</label><input type="text" id="payWA" placeholder="98xxxxxxxx"></div>
        <button class="btn btn-solid" id="confirmBuyBtn" style="margin-bottom:8px">confirm.sh</button>
        <button class="btn btn-ghost" onclick="closeModal('checkoutModal')">cancel</button>
    </div>
</div>

<!-- ---- Key delivered modal ---- -->
<div id="keyModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header">cat delivered_key.txt</div>
        <div id="keyProductName" style="font-size:13px;margin-bottom:6px"></div>
        <div style="background:#040a06;border:1px solid var(--border-strong);border-radius:var(--radius-sm);padding:12px;word-break:break-all;color:var(--green);font-weight:700;margin-bottom:12px" id="keyValue"></div>
        <button class="btn btn-solid" onclick="closeModal('keyModal')">done</button>
    </div>
</div>

<!-- ---- Top-up modal ---- -->
<div id="topupModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header">topup --esewa</div>
        <div class="dim" style="font-size:12px;margin-bottom:12px">Pay via eSewa, then submit your transaction ID. Admin verifies and credits shortly.</div>
        <div class="qr-wrap">
            <img src="https://i.postimg.cc/zXm07q9C/Screenshot-20260425-142906.jpg" alt="eSewa QR">
            <div class="dim" style="text-align:center;font-size:11px;margin-top:6px">Scan with eSewa App</div>
        </div>
        <div class="field"><label>amount (Rs)</label><input type="number" id="topupAmount" value="100" min="50"></div>
        <div class="field"><label>your eSewa ID</label><input type="text" id="topupEsewa" placeholder="phone or email"></div>
        <div class="field"><label>transaction code</label><input type="text" id="topupTx" placeholder="e.g. JRJDHD"></div>
        <button class="btn btn-solid" id="submitTopup" style="margin-bottom:8px">submit.sh</button>
        <button class="btn btn-ghost" onclick="closeModal('topupModal')">cancel</button>
    </div>
</div>

<!-- ---- Profile modal ---- -->
<div id="profileModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header">profile --edit</div>
        <div class="field"><label>display name</label><input type="text" id="profName"></div>
        <div class="field"><label>whatsapp number</label><input type="text" id="profPhone"></div>
        <button class="btn btn-solid" id="saveProfile" style="margin-bottom:8px">save.sh</button>
        <button class="btn btn-ghost" onclick="closeModal('profileModal')">close</button>
    </div>
</div>

<!-- ---- Profile modal ---- -->
<div id="profileModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header">profile --edit</div>
        <div class="field"><label>display name</label><input type="text" id="profName"></div>
        <div class="field"><label>whatsapp number</label><input type="text" id="profPhone"></div>
        <button class="btn btn-solid" id="saveProfile" style="margin-bottom:14px">save.sh</button>

        <div class="field">
            <label>email address</label>
            <input type="text" id="profEmail" readonly style="color:var(--text2)">
        </div>
        <div class="field">
            <label>user id (uid)</label>
            <div style="display:flex;gap:6px">
                <input type="text" id="profUid" readonly style="color:var(--text2);font-size:11px">
                <button class="btn btn-ghost" style="width:auto;padding:0 12px" onclick="navigator.clipboard.writeText(document.getElementById('profUid').value); window.__toastCopy()">copy</button>
            </div>
        </div>
        <button class="btn btn-ghost" onclick="closeModal('profileModal')">close</button>
    </div>
</div>

<!-- ---- Report a problem modal ---- -->
<div id="helpModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header">report --problem</div>
        <div class="dim" style="font-size:12px;margin-bottom:12px">
            Describe what's going wrong. Your account details (uid, email, balance) are attached automatically.
        </div>
        <div class="field"><label>describe issue</label><textarea id="problemText" rows="5" placeholder="e.g. Purchase failed after payment, balance not updated..."></textarea></div>
        <button class="btn btn-solid" id="submitReport" style="margin-bottom:8px">send.sh</button>
        <button class="btn btn-ghost" onclick="closeModal('helpModal')">cancel</button>
    </div>
</div>

<!-- ---- Change password modal ---- -->
<div id="passwordModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;margin:auto">
        <div class="prompt-header">passwd --change</div>
        <div class="field"><label>current password</label><input type="password" id="curPass" autocomplete="current-password"></div>
        <div class="field"><label>new password (min 6 chars)</label><input type="password" id="newPass" autocomplete="new-password"></div>
        <button class="btn btn-solid" id="savePassword" style="margin-bottom:8px">update.sh</button>
        <button class="btn btn-ghost" onclick="closeModal('passwordModal')">cancel</button>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed; inset: 0; z-index: 100;
    background: rgba(2,6,4,0.85);
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
}
.cat-row {
    background: var(--panel); border: 1px solid var(--border); border-radius: var(--radius-sm);
    margin-bottom: 6px; overflow: hidden;
}
.cat-head {
    display: flex; align-items: center; gap: 10px; padding: 11px 12px; cursor: pointer;
}
.cat-img {
    width: 38px; height: 38px; border-radius: 6px; overflow: hidden; flex-shrink: 0;
    border: 1px solid var(--border); background: #040a06;
}
.cat-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.cat-head .name { flex: 1; font-size: 12.5px; font-weight: 600; }
.cat-head .tag { font-size: 9px; padding: 2px 6px; border-radius: 4px; border: 1px solid var(--border-strong); color: var(--text2); }
.cat-head .arrow { font-size: 10px; color: var(--text3); transition: transform .2s; }
.cat-row.open .arrow { transform: rotate(90deg); }
.cat-body { display: none; border-top: 1px solid var(--border); }
.cat-row.open .cat-body { display: block; }
.dur-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 12px; font-size: 12px; border-top: 1px solid var(--border);
    cursor: pointer;
}
.dur-row:active { background: var(--panel2); }
.dur-row .price { color: var(--amber); font-weight: 700; }
.qr-wrap {
    background: #040a06; border: 1px solid var(--border); border-radius: var(--radius-sm);
    padding: 12px; margin-bottom: 12px; text-align: center;
}
.qr-wrap img { width: 160px; height: 160px; object-fit: contain; border-radius: 6px; }
.code-block {
    background: #040a06; border: 1px solid var(--border); border-radius: 6px;
    padding: 8px 10px; font-size: 10px; color: var(--cyan); overflow-x: auto;
    white-space: pre; margin-bottom: 4px;
}
</style>

<script type="module">
import {
    requireAuth, backendFetch, toast, fmtDate, esc, setButtonLoading,
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
    } catch (e) {
        toast(e.message, 'error');
    }
}

async function loadCatalog() {
    try {
        const r = await fetch(`${window.BACKEND_URL}/api/catalog`);
        const d = await r.json();
        catalog = d.catalog;
        renderCatalog();
    } catch (e) {
        document.getElementById('catalogList').innerHTML = '<div style="color:var(--red);font-size:12px">Failed to load catalog</div>';
    }
}

function renderCatalog() {
    // Group by `row`
    const groups = {};
    for (const [sku, p] of Object.entries(catalog)) {
        if (!groups[p.row]) groups[p.row] = [];
        groups[p.row].push({ sku, ...p });
    }
    const tagOf = (row) => /root/i.test(row) && !/non ?root/i.test(row) ? 'ROOT'
        : /ios/i.test(row) ? 'IOS'
        : /pc/i.test(row) ? 'PC'
        : 'NONROOT';

    const html = Object.entries(groups).map(([row, items], gi) => `
        <div class="cat-row" id="cat-${gi}">
            <div class="cat-head" onclick="document.getElementById('cat-${gi}').classList.toggle('open')">
                <div class="cat-img"><img src="${items[0].image || ''}" alt="${esc(row)}" loading="lazy"></div>
                <span class="name">${esc(row)}</span>
                <span class="tag">${tagOf(row)}</span>
                <span class="arrow">▸</span>
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
        <div style="display:flex;justify-content:space-between;margin-bottom:4px"><span class="dim">product</span><span>${esc(p.name)}</span></div>
        <div style="display:flex;justify-content:space-between;margin-bottom:4px"><span class="dim">duration</span><span>${esc(p.duration)}</span></div>
        <div style="display:flex;justify-content:space-between"><span class="dim">price</span><span class="price" style="color:var(--amber);font-weight:700">Rs ${p.price}</span></div>
    `;
    openModal('checkoutModal');
};

// ---- Checkout with fake timer + real progress polling ----
document.getElementById('confirmBuyBtn').onclick = async () => {
    if (!pendingCheckout) return;
    const name = document.getElementById('payName').value.trim();
    const waNum = document.getElementById('payWA').value.trim();
    const btn = document.getElementById('confirmBuyBtn');

    // Show button loading state
    setButtonLoading(btn, true);
    closeModal('checkoutModal');

    // ---- Fake timer overlay ----
    openModal('timerModal');
    const timerEl = document.getElementById('timerCount');
    let count = 4;
    timerEl.textContent = count;
    await new Promise((resolve) => {
        const interval = setInterval(() => {
            count -= 1;
            if (count === 0) {
                clearInterval(interval);
                timerEl.textContent = '⏳';
                resolve();
            } else {
                timerEl.textContent = count;
            }
        }, 1000);
    });
    closeModal('timerModal');

    // ---- Real delivery progress ----
    openModal('deliveryModal');
    setDeliveryProgress(0, 'Connecting to server...');

    try {
        const start = await backendFetch('/api/purchase/checkout/start', {
            method: 'POST',
            body: JSON.stringify({ sku: pendingCheckout.sku, name, waNum }),
        });
        const result = await pollCheckoutJob(start.jobId);
        closeModal('deliveryModal');

        if (!result.success) {
            toast(result.error || 'Purchase failed', 'error');
            return;
        }

        document.getElementById('keyProductName').textContent = pendingCheckout.name;
        document.getElementById('keyValue').textContent = result.key;
        openModal('keyModal');
        document.getElementById('balAmount').textContent = result.newBalance;
    } catch (e) {
        closeModal('deliveryModal');
        toast(e.message, 'error');
    } finally {
        setButtonLoading(btn, false);
    }
};

function setDeliveryProgress(pct, label) {
    document.getElementById('deliveryBar').style.width = pct + '%';
    document.getElementById('deliveryPct').textContent = pct + '%';
    if (label) document.getElementById('deliveryLabel').textContent = label;
}

async function pollCheckoutJob(jobId) {
    while (true) {
        const d = await backendFetch(`/api/purchase/checkout/status/${jobId}`);
        setDeliveryProgress(d.percent, d.label);
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
    const btn = document.getElementById('submitTopup');
    setButtonLoading(btn, true);
    try {
        await backendFetch('/api/user/topup', { method: 'POST', body: JSON.stringify({ amount, esewaId, txCode }) });
        toast('Submitted — awaiting admin approval', 'success');
        closeModal('topupModal');
    } catch (e) {
        toast(e.message, 'error');
    }
    setButtonLoading(btn, false);
};

// ---- Profile ----
document.getElementById('openProfile').onclick = () => openModal('profileModal');
document.getElementById('saveProfile').onclick = async () => {
    const name = document.getElementById('profName').value.trim();
    const phone = document.getElementById('profPhone').value.trim();
    const btn = document.getElementById('saveProfile');
    setButtonLoading(btn, true);
    try {
        await backendFetch('/api/user/profile', { method: 'POST', body: JSON.stringify({ name, phone }) });
        toast('Saved', 'success');
        closeModal('profileModal');
    } catch (e) {
        toast(e.message, 'error');
    }
    setButtonLoading(btn, false);
};

// ---- Help / Report a Problem ----
document.getElementById('openHelp').onclick = () => openModal('helpModal');
document.getElementById('submitReport').onclick = async () => {
    const problem = document.getElementById('problemText').value.trim();
    if (!problem) return toast('Please describe the problem', 'error');
    const btn = document.getElementById('submitReport');
    setButtonLoading(btn, true);
    try {
        await backendFetch('/api/user/report', { method: 'POST', body: JSON.stringify({ problem }) });
        toast('Report sent', 'success');
        document.getElementById('problemText').value = '';
        closeModal('helpModal');
    } catch (e) {
        toast(e.message, 'error');
    }
    setButtonLoading(btn, false);
};

// ---- Change password ----
document.getElementById('openPassword').onclick = () => openModal('passwordModal');
document.getElementById('savePassword').onclick = async () => {
    const curPass = document.getElementById('curPass').value;
    const newPass = document.getElementById('newPass').value;
    if (!curPass || !newPass) return toast('Fill both fields', 'error');
    if (newPass.length < 6) return toast('New password must be at least 6 characters', 'error');
    const btn = document.getElementById('savePassword');
    setButtonLoading(btn, true);
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
    setButtonLoading(btn, false);
};
</script>

</body>
</html>