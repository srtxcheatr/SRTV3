<?php
$pageTitle = 'Store — SRT X CHEATS';
$currentPage = 'store';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';   // use the fixed nav.php below
?>

<div class="term-window">
    <div class="term-content">

        <!-- Banner Carousel -->
        <div class="banner-carousel" id="bannerCarousel">
            <div class="banner-track" id="bannerTrack">
                <?php foreach (BANNERS as $b): ?>
                <a href="<?= htmlspecialchars($b['link']) ?>" target="_blank" class="banner-slide">
                    <img src="<?= htmlspecialchars($b['image']) ?>" alt="banner" loading="lazy">
                </a>
                <?php endforeach; ?>
            </div>
            <div class="banner-dots" id="bannerDots">
                <?php foreach (BANNERS as $i => $b): ?>
                <span class="banner-dot<?= $i === 0 ? ' active' : '' ?>" data-i="<?= $i ?>"></span>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Balance Panel (new UI) -->
        <div class="panel" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
            <div>
                <div class="dim" style="font-size:11px"><i class="fas fa-wallet" style="color:var(--neon-amber)"></i> BALANCE</div>
                <div style="color:var(--neon-amber);font-weight:800;font-size:22px" class="mono-num">Rs <span id="balAmount">—</span></div>
            </div>
            <div style="flex:1;min-width:80px">
                <div style="height:6px;border-radius:6px;background:rgba(255,255,255,0.08);overflow:hidden">
                    <div id="balBar" style="width:0%;height:100%;background:linear-gradient(90deg,var(--neon-amber),var(--neon-purple));transition:width 0.4s ease"></div>
                </div>
            </div>
            <div style="text-align:right">
                <div class="dim" style="font-size:11px"><i class="fas fa-signal" style="color:var(--neon-green)"></i> STATUS</div>
                <div id="statusVal" style="font-weight:700;font-size:13px;color:var(--neon-green)">—</div>
            </div>
        </div>

        <!-- Announcement Panel -->
        <div class="panel" id="noticePanel">
            <div class="prompt-header"><i class="fas fa-bullhorn"></i> ANNOUNCEMENT</div>
            <div id="noticeText" style="font-size:12px;color:var(--text-secondary)">Loading announcements...</div>
        </div>

        <!-- Action Buttons -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:8px">
            <button class="btn btn-ghost" id="openTopup"><i class="fas fa-coins" style="color:var(--neon-amber)"></i> Add Balance</button>
            <button class="btn btn-ghost" id="openProfile"><i class="fas fa-user-gear" style="color:var(--neon-blue)"></i> Profile</button>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:18px">
            <button class="btn btn-ghost" id="openHelp" style="font-size:11px"><i class="fas fa-headset"></i> Support</button>
            <button class="btn btn-ghost" id="openPassword" style="font-size:11px"><i class="fas fa-shield-halved"></i> Password</button>
            <a href="<?= htmlspecialchars(DEVELOPER_URL) ?>" target="_blank" class="btn btn-ghost" style="font-size:11px"><i class="fas fa-code"></i> About</a>
        </div>

        <!-- Catalog Header -->
        <div class="prompt-header"><i class="fas fa-gamepad"></i> PRODUCTS CATALOG</div>
        <div style="position:relative;margin-bottom:10px">
            <i class="fas fa-magnifying-glass" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--text-muted)"></i>
            <input type="text" id="catalogSearch" placeholder="Search product cheats..." style="padding-left:38px">
        </div>

        <div id="catFilters" style="display:flex;gap:8px;margin-bottom:14px;overflow-x:auto;padding-bottom:4px">
            <button class="cat-filter active" data-tag="ALL"><i class="fas fa-layer-group"></i> ALL</button>
            <button class="cat-filter" data-tag="ROOT"><i class="fas fa-mobile-screen-button"></i> ROOT</button>
            <button class="cat-filter" data-tag="NONROOT"><i class="fas fa-mobile-button"></i> NONROOT</button>
            <button class="cat-filter" data-tag="PC"><i class="fas fa-desktop"></i> PC</button>
            <button class="cat-filter" data-tag="IOS"><i class="fab fa-apple"></i> IOS</button>
        </div>

        <!-- Catalog List -->
        <div id="catalogList">
            <div class="dim" style="text-align:center;padding:30px">
                <i class="fas fa-circle-notch fa-spin" style="font-size:24px;color:var(--neon-blue);margin-bottom:8px"></i>
                <div>Loading catalog options...</div>
            </div>
        </div>

    </div>
</div>

<!-- ---- All Modals (same as your new design, keep them) ---- -->
<!-- ... (all modals: checkout, delivery, key, topup, profile, help, password, error) ... -->
<!-- I'll omit them here for brevity – copy them from your new store.php or the previous answer -->

<!-- ---- JavaScript (exact old logic with new UI bindings) ---- -->
<script type="module">
import {
    requireAuth, backendFetch, toast, esc,
    auth, EmailAuthProvider, reauthenticateWithCredential, updatePassword,
} from '/assets/js/app.js';

// Global functions for inline onclick in HTML
window.openModal = (id) => document.getElementById(id)?.classList.remove('hidden');
window.closeModal = (id) => document.getElementById(id)?.classList.add('hidden');
window.__toastCopy = () => toast('Copied!', 'success');

// Loading helper
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

// ---- Banner Carousel Auto-Slide ----
(function initCarousel() {
    const track = document.getElementById('bannerTrack');
    const dots = document.querySelectorAll('.banner-dot');
    if (!track || dots.length < 2) return;
    let idx = 0;
    setInterval(() => {
        idx = (idx + 1) % dots.length;
        track.style.transform = `translateX(-${idx * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle('active', i === idx));
    }, 4000);
})();

// ---- Global Logout (used by nav) ----
window.doLogout = async function() {
    try {
        await auth.signOut();
    } catch (e) {
        console.error('Logout error:', e);
    }
    window.location.href = '/home.php';
};

// ---- State ----
let userState = {};
let catalog = {};
let pendingCheckout = null;
let currentUid = '';

// ---- Main auth & data load ----
requireAuth(async (user) => {
    currentUid = user.uid;
    await Promise.all([loadBalance(), loadCatalog()]);
});

// ---- Load balance and profile ----
async function loadBalance() {
    try {
        const d = await backendFetch('/api/user/balance');
        userState = d;
        document.getElementById('balAmount').textContent = d.balance;
        const bar = document.getElementById('balBar');
        if (bar) bar.style.width = Math.min(100, (d.balance / 10)) + '%';
        const statusEl = document.getElementById('statusVal');
        statusEl.textContent = d.requestStatus || 'Active';
        statusEl.style.color = d.requestStatus === 'Active' ? 'var(--neon-green)' :
                               d.requestStatus === 'Pending' ? 'var(--neon-amber)' : 'var(--neon-red)';
        document.getElementById('noticeText').textContent = d.adminMessage || 'Welcome to SRT X CHEATS.';
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
        hint.textContent = 'First top‑up is fixed at Rs 1,000. After approval you can top up any amount.';
    } else {
        amountInput.readOnly = false;
        amountInput.style.opacity = '1';
        amountInput.value = 100;
        hint.textContent = 'Pay via eSewa, then submit your transaction ID. Admin verifies and credits shortly.';
    }
}

// ---- Load catalog ----
async function loadCatalog() {
    try {
        const d = await backendFetch('/api/user/catalog');
        catalog = d.catalog || {};
        renderCatalog();
    } catch (e) {
        document.getElementById('catalogList').innerHTML = `<div class="dim" style="text-align:center;padding:30px;color:var(--neon-red)"><i class="fas fa-exclamation-triangle"></i> Failed to load catalog</div>`;
    }
}

// ---- Catalog rendering (old logic) ----
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
        return row.toLowerCase().includes(q) || items.some(it => it.name.toLowerCase().includes(q));
    });

    const container = document.getElementById('catalogList');
    if (!filteredEntries.length) {
        container.innerHTML = '<div class="dim" style="text-align:center;padding:30px"><i class="fas fa-box-open"></i> No products match.</div>';
        return;
    }

    let html = '';
    filteredEntries.forEach(([row, items], gi) => {
        const prices = items.map(it => it.price);
        const priceRange = Math.min(...prices) === Math.max(...prices)
            ? `Rs ${prices[0]}`
            : `Rs ${Math.min(...prices)} – ${Math.max(...prices)}`;
        html += `
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
                ${items[0].apkUrl ? `
                    <a href="${esc(items[0].apkUrl)}" target="_blank" class="apk-update-row" onclick="event.stopPropagation()">
                        <i class="fas fa-download"></i> APK Update — ${esc(row)}
                    </a>
                ` : ''}
            </div>
        </div>`;
    });
    container.innerHTML = html;
}

// ---- Search & filter events ----
document.getElementById('catalogSearch').addEventListener('input', (e) => {
    searchQuery = e.target.value;
    renderCatalog();
});
document.getElementById('catFilters').addEventListener('click', (e) => {
    const btn = e.target.closest('.cat-filter');
    if (!btn) return;
    document.querySelectorAll('.cat-filter').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    activeTag = btn.dataset.tag;
    renderCatalog();
});

// ---- Start checkout (global) ----
window.__startCheckout = (sku) => {
    const p = catalog[sku];
    if (!p) return toast('Product not found', 'error');
    pendingCheckout = { sku, ...p };
    document.getElementById('checkoutSummary').innerHTML = `
        <div style="display:flex;justify-content:space-between;margin-bottom:4px"><span class="dim"><i class="fas fa-cube"></i> Product</span><span>${esc(p.name)}</span></div>
        <div style="display:flex;justify-content:space-between;margin-bottom:4px"><span class="dim"><i class="fas fa-clock"></i> Duration</span><span>${esc(p.duration)}</span></div>
        <div style="display:flex;justify-content:space-between"><span class="dim"><i class="fas fa-tag"></i> Price</span><span class="price" style="color:var(--neon-amber);font-weight:700">Rs ${p.price}</span></div>
    `;
    openModal('checkoutModal');
};

// ---- Confirm purchase ----
const confirmBtn = document.getElementById('confirmBuyBtn');
confirmBtn.onclick = async () => {
    if (!pendingCheckout) return;
    const name = document.getElementById('payName').value.trim();
    const waNum = document.getElementById('payWA').value.trim();
    if (!name || !waNum) return toast('Please fill name and WhatsApp', 'error');

    closeModal('checkoutModal');
    openModal('deliveryModal');
    setLoading(confirmBtn, true);

    try {
        const res = await backendFetch('/api/purchase/checkout', {
            method: 'POST',
            body: JSON.stringify({ sku: pendingCheckout.sku, name, waNum }),
        });

        closeModal('deliveryModal');

        if (!res || !res.key) {
            throw new Error(res?.error || 'Purchase failed or out of stock');
        }

        document.getElementById('keyProductName').textContent = pendingCheckout.name;
        document.getElementById('keyValue').textContent = res.key;
        openModal('keyModal');

        if (res.newBalance !== undefined) {
            document.getElementById('balAmount').textContent = res.newBalance;
            const bar = document.getElementById('balBar');
            if (bar) bar.style.width = Math.min(100, (res.newBalance / 10)) + '%';
        }
    } catch (e) {
        closeModal('deliveryModal');
        document.getElementById('errorMsg').textContent = e.message || 'Key delivery failed. Contact admin.';
        openModal('errorModal');
    } finally {
        setLoading(confirmBtn, false);
        pendingCheckout = null;
    }
};

// ---- Topup ----
document.getElementById('openTopup').onclick = () => openModal('topupModal');
const topupBtn = document.getElementById('submitTopup');
topupBtn.onclick = async () => {
    const amount = parseInt(document.getElementById('topupAmount').value, 10);
    const esewaId = document.getElementById('topupEsewa').value.trim();
    const txCode = document.getElementById('topupTx').value.trim();
    if (!amount || !esewaId || !txCode) return toast('Fill all fields', 'error');
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
        toast('Profile saved', 'success');
        closeModal('profileModal');
        loadBalance(); // refresh
    } catch (e) {
        toast(e.message, 'error');
    } finally {
        setLoading(profileBtn, false);
    }
};

// Copy UID
document.getElementById('copyUidBtn')?.addEventListener('click', () => {
    const uid = document.getElementById('profUid').value;
    if (uid) {
        navigator.clipboard.writeText(uid);
        toast('UID copied!', 'success');
    }
});

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

// ---- Help / Report ----
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