<?php
$pageTitle = 'Store — SRT X CHEATS';
$currentPage = 'store';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';   // use the fixed glass nav
?>

<div class="term-window">
    <div class="term-content">

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

        <div class="panel" id="noticePanel">
            <div class="prompt-header"><i class="fas fa-bullhorn"></i> ANNOUNCEMENT</div>
            <div id="noticeText" style="font-size:12px;color:var(--text-secondary)">Loading announcements...</div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:8px">
            <button class="btn btn-ghost" id="openTopup"><i class="fas fa-coins" style="color:var(--neon-amber)"></i> Add Balance</button>
            <button class="btn btn-ghost" id="openProfile"><i class="fas fa-user-gear" style="color:var(--neon-blue)"></i> Profile</button>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:18px">
            <button class="btn btn-ghost" id="openHelp" style="font-size:11px"><i class="fas fa-headset"></i> Support</button>
            <button class="btn btn-ghost" id="openPassword" style="font-size:11px"><i class="fas fa-shield-halved"></i> Password</button>
            <a href="<?= htmlspecialchars(DEVELOPER_URL) ?>" target="_blank" class="btn btn-ghost" style="font-size:11px"><i class="fas fa-code"></i> About</a>
        </div>

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

        <div id="catalogList">
            <div class="dim" style="text-align:center;padding:30px">
                <i class="fas fa-circle-notch fa-spin" style="font-size:24px;color:var(--neon-blue);margin-bottom:8px"></i>
                <div>Loading catalog options...</div>
            </div>
        </div>

    </div>
</div>

<div id="checkoutModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-cart-shopping"></i> CONFIRM PURCHASE</div>
        <div id="checkoutSummary" style="font-size:13px;margin-bottom:14px"></div>
        <div class="field"><label><i class="fas fa-user"></i> Your Name</label><input type="text" id="payName" placeholder="Full name"></div>
        <div class="field"><label><i class="fab fa-whatsapp"></i> WhatsApp Number</label><input type="text" id="payWA" placeholder="98xxxxxxxx"></div>
        <button class="btn btn-solid" id="confirmBuyBtn" style="margin-bottom:8px;position:relative">
            <span class="btn-text"><i class="fas fa-check-circle"></i> Confirm Order</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>
        <button class="btn btn-ghost" onclick="closeModal('checkoutModal')"><i class="fas fa-xmark"></i> Cancel</button>
    </div>
</div>

<div id="deliveryModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%;text-align:center;padding:24px 20px">
        <div class="prompt-header" style="justify-content:center;margin-bottom:16px">
            <i class="fas fa-shipping-fast" style="color:var(--neon-amber)"></i> Fetching Access Key...
        </div>
        <div class="delivery-track">
            <div class="delivery-road"></div>
            <div class="delivery-truck">
                <svg width="36" height="28" viewBox="0 0 24 24" style="display:block;filter:drop-shadow(0 0 8px #00ff88);">
                    <defs>
                        <linearGradient id="truckGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#ff007f" />
                            <stop offset="50%" stop-color="#7928ca" />
                            <stop offset="100%" stop-color="#00dfd8" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#truckGrad)" d="M20 8h-3V4H1v13h2a3 3 0 0 0 6 0h6a3 3 0 0 0 6 0h2v-6l-3-3zM6 18.5A1.5 1.5 0 1 1 7.5 17 1.5 1.5 0 0 1 6 18.5zm12 0a1.5 1.5 0 1 1 1.5-1.5 1.5 1.5 0 0 1-1.5 1.5zM17 12V9.5h2.2l1.8 1.8V12z"/>
                </svg>
            </div>
        </div>

        <div class="dim" id="deliveryLabel" style="font-size:12px;margin:12px 0 8px;color:var(--text-secondary)">Connecting to server...</div>
        <div style="height:6px;background:rgba(255,255,255,0.08);border-radius:99px;overflow:hidden;margin-bottom:6px">
            <div id="deliveryBar" style="height:100%;width:0%;background:linear-gradient(90deg,var(--neon-green),var(--neon-blue));transition:width 0.4s ease"></div>
        </div>
        <div class="mono-num" id="deliveryPct" style="font-size:20px;font-weight:700;color:var(--neon-green)">0%</div>
    </div>
</div>

<div id="keyModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-key" style="color:var(--neon-green)"></i> ACCESS KEY DELIVERED</div>
        <div id="keyProductName" style="font-size:13px;margin-bottom:8px"></div>
        <div style="background:rgba(0,0,0,0.3);border:1px solid var(--neon-green);border-radius:var(--radius-md);padding:14px;word-break:break-all;color:var(--neon-green);font-weight:700;margin-bottom:14px;font-family:var(--font-mono)" id="keyValue"></div>
        <button class="btn btn-solid" onclick="closeModal('keyModal')"><i class="fas fa-check"></i> Done</button>
    </div>
</div>

<div id="topupModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-qrcode"></i> TOPUP BALANCE</div>
        <div class="dim" style="font-size:12px;margin-bottom:12px" id="topupHint"><i class="fas fa-info-circle"></i> Pay via eSewa, then submit your transaction ID.</div>
        <div style="text-align:center;margin-bottom:12px">
            <img src="https://i.postimg.cc/zXm07q9C/Screenshot-20260425-142906.jpg" alt="eSewa QR" style="max-width:180px;border-radius:12px;border:1px solid var(--glass-border)">
        </div>
        <div class="field"><label><i class="fas fa-rupee-sign"></i> Amount (Rs)</label><input type="number" id="topupAmount" value="100" min="50"></div>
        <div class="field"><label><i class="fas fa-id-card"></i> eSewa ID</label><input type="text" id="topupEsewa" placeholder="phone or email"></div>
        <div class="field"><label><i class="fas fa-hashtag"></i> Transaction Code</label><input type="text" id="topupTx" placeholder="e.g. JRJDHD"></div>
        <button class="btn btn-solid" id="submitTopup" style="margin-bottom:8px;position:relative">
            <span class="btn-text"><i class="fas fa-paper-plane"></i> Submit Topup</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>
        <button class="btn btn-ghost" onclick="closeModal('topupModal')"><i class="fas fa-xmark"></i> Close</button>
    </div>
</div>

<div id="profileModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-user-gear"></i> PROFILE SETTINGS</div>
        <div class="field"><label><i class="fas fa-user"></i> Name</label><input type="text" id="profName" placeholder="Your Full Name"></div>
        <div class="field"><label><i class="fab fa-whatsapp"></i> WhatsApp Number</label><input type="text" id="profPhone" placeholder="98xxxxxxxx"></div>
        <button class="btn btn-solid" id="saveProfile" style="margin-bottom:14px;position:relative">
            <span class="btn-text"><i class="fas fa-floppy-disk"></i> Save Details</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>
        <div class="field"><label><i class="fas fa-envelope"></i> Email</label><input type="text" id="profEmail" readonly style="opacity:0.7"></div>
        <div class="field">
            <label><i class="fas fa-fingerprint" style="color:var(--neon-amber)"></i> User ID (UID)</label>
            <div style="display:flex;gap:6px">
                <input type="text" id="profUid" readonly style="opacity:0.8;font-family:var(--font-mono);font-size:12px;letter-spacing:0.5px">
                <button type="button" class="btn btn-ghost" id="copyUidBtn" style="padding:0 12px" title="Copy UID">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
        </div>
        <button class="btn btn-ghost" onclick="closeModal('profileModal')"><i class="fas fa-xmark"></i> Close</button>
    </div>
</div>

<div id="helpModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-headset"></i> SUPPORT / REPORT</div>
        <div class="dim" style="font-size:12px;margin-bottom:12px">Describe your issue. Your account details will be sent to admin.</div>
        <div class="field"><label><i class="fas fa-comment-dots"></i> Describe issue</label><textarea id="problemText" rows="3"></textarea></div>
        <button class="btn btn-solid" id="submitReport" style="margin-bottom:8px;position:relative">
            <span class="btn-text"><i class="fas fa-paper-plane"></i> Send Report</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>
        <button class="btn btn-ghost" onclick="closeModal('helpModal')"><i class="fas fa-xmark"></i> Close</button>
    </div>
</div>

<div id="passwordModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-shield-halved"></i> CHANGE PASSWORD</div>
        <div class="field"><label>Current Password</label><input type="password" id="curPass" autocomplete="current-password"></div>
        <div class="field"><label>New Password (min 6 chars)</label><input type="password" id="newPass" autocomplete="new-password"></div>
        <button class="btn btn-solid" id="savePassword" style="margin-bottom:8px;position:relative">
            <span class="btn-text"><i class="fas fa-key"></i> Update Password</span>
            <span class="btn-spinner hidden"><span class="spinner"></span></span>
        </button>
        <button class="btn btn-ghost" onclick="closeModal('passwordModal')"><i class="fas fa-xmark"></i> Close</button>
    </div>
</div>

<div id="errorModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-exclamation-triangle" style="color:var(--neon-red)"></i> SYSTEM ERROR</div>
        <div id="errorMsg" style="background:rgba(255,0,0,0.05);border:1px solid var(--neon-red);border-radius:var(--radius-md);padding:12px;color:var(--neon-red);font-size:12px;margin-bottom:12px"></div>
        <button class="btn btn-ghost" onclick="closeModal('errorModal')"><i class="fas fa-times"></i> Dismiss</button>
    </div>
</div>

<style>
/* ----- Catalog Card Styles ----- */
.cat-row {
    background: var(--glass-panel);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-md);
    margin-bottom: 14px;
    overflow: hidden;
    transition: border-color 0.3s;
}
.cat-row:hover { border-color: var(--glass-border-hover); }
.cat-head { cursor: pointer; }
.cat-img {
    width: 100%;
    aspect-ratio: 16 / 10;
    overflow: hidden;
    background: rgba(0,0,0,0.3);
    border-bottom: 1px solid var(--glass-border);
    position: relative;
}
.cat-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.cat-tag-badge {
    position: absolute; top: 10px; right: 10px;
    font-size: 10px; font-weight: 800; letter-spacing: 0.5px;
    padding: 4px 10px; border-radius: 999px;
    background: rgba(0,0,0,0.7);
    border: 1px solid var(--glass-border-hover);
    color: var(--neon-blue);
    backdrop-filter: blur(4px);
}
.cat-info {
    padding: 12px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.cat-info .name { flex: 1; font-size: 14px; font-weight: 700; letter-spacing: 0.2px; }
.cat-info .price-range { font-size: 12px; color: var(--neon-amber); font-weight: 700; }
.cat-arrow { font-size: 11px; color: var(--text-muted); transition: transform 0.2s; }
.cat-row.open .cat-arrow { transform: rotate(90deg); }
.cat-body { display: none; border-top: 1px solid var(--glass-border); }
.cat-row.open .cat-body { display: block; }
.dur-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 12px 14px; font-size: 13px;
    border-top: 1px solid var(--glass-border);
    cursor: pointer;
    transition: background 0.15s;
}
.dur-row:hover { background: rgba(255,255,255,0.05); }
.dur-row .price { color: var(--neon-amber); font-weight: 700; }
.apk-update-row {
    display: flex; align-items: center; gap: 8px;
    padding: 12px 14px; font-size: 12px; font-weight: 700;
    border-top: 1px solid var(--glass-border);
    color: var(--neon-blue);
    text-decoration: none;
}
.apk-update-row:hover { background: rgba(0,240,255,0.05); }

/* ----- Delivery Truck Animation ----- */
.delivery-track {
    position: relative; height: 50px; margin: 12px 0;
    background: rgba(0,0,0,0.4); border-radius: 12px; overflow: hidden;
    border: 1px solid var(--glass-border);
}
.delivery-road {
    position: absolute; bottom: 10px; left: 0; right: 0; height: 2px;
    background: repeating-linear-gradient(to right, var(--text-muted) 0 8px, transparent 8px 16px);
}
.delivery-truck {
    position: absolute; bottom: 8px;
    animation: driveContinuous 2s ease-in-out infinite;
}
@keyframes driveContinuous {
    0% { left: -40px; opacity: 0; }
    20% { opacity: 1; }
    80% { opacity: 1; }
    100% { left: 100%; opacity: 0; }
}

/* ----- Modal overlay ----- */
.modal-overlay {
    position: fixed; inset: 0; z-index: 999;
    background: rgba(4,3,12,0.75);
    backdrop-filter: blur(12px);
    display: flex; align-items: center; justify-content: center;
    padding: 16px;
    animation: fadeIn 0.25s ease;
}
.modal-overlay.hidden { display: none !important; }
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}

/* ----- Button loading states ----- */
.btn .btn-spinner { display: none; }
.btn.loading .btn-text { visibility: hidden; }
.btn.loading .btn-spinner { display: inline-flex; align-items: center; gap: 6px; }
.btn.loading .btn-spinner .spinner {
    width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,0.2);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ----- Banner Carousel ----- */
.banner-carousel {
    border-radius: var(--radius-lg);
    overflow: hidden;
    margin-bottom: 16px;
    border: 1px solid var(--glass-border);
    position: relative;
}
.banner-track { display: flex; transition: transform 0.4s ease-in-out; }
.banner-slide { min-width: 100%; }
.banner-slide img { width: 100%; height: 160px; object-fit: cover; display: block; }
.banner-dots {
    position: absolute;
    bottom: 8px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 6px;
}
.banner-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.4);
    cursor: pointer;
    transition: all 0.3s;
}
.banner-dot.active {
    width: 20px;
    border-radius: 10px;
    background: var(--neon-blue);
    box-shadow: 0 0 8px var(--neon-blue);
}
</style>

<script type="module">
import {
    requireAuth, backendFetch, toast, esc,
    auth, EmailAuthProvider, reauthenticateWithCredential, updatePassword,
} from '/assets/js/app.js';

// Global functions for inline onclick
window.openModal = (id) => document.getElementById(id)?.classList.remove('hidden');
window.closeModal = (id) => document.getElementById(id)?.classList.add('hidden');
window.__toastCopy = () => toast('Copied!', 'success');

// Helper to get fresh auth token for direct status polling
async function getToken() {
    const user = auth.currentUser;
    if (!user) throw new Error('Not logged in');
    return await user.getIdToken(true);
}

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

// ---- Global Logout ----
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

// ---- Catalog rendering ----
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

// ---- Start checkout ----
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

// ---- Confirm purchase with job polling restored ----
const confirmBtn = document.getElementById('confirmBuyBtn');
confirmBtn.onclick = async () => {
    if (!pendingCheckout) return;
    const name = document.getElementById('payName').value.trim();
    const waNum = document.getElementById('payWA').value.trim();
    if (!name || !waNum) return toast('Please fill name and WhatsApp', 'error');

    closeModal('checkoutModal');
    openModal('deliveryModal');
    setLoading(confirmBtn, true);

    // Safely reset delivery indicators
    const deliveryBar = document.getElementById('deliveryBar');
    const deliveryPct = document.getElementById('deliveryPct');
    const deliveryLabel = document.getElementById('deliveryLabel');
    if (deliveryBar) deliveryBar.style.width = '0%';
    if (deliveryPct) deliveryPct.textContent = '0%';
    if (deliveryLabel) deliveryLabel.textContent = 'Starting...';

    try {
        // 1. Start job via backendFetch
        const startRes = await backendFetch('/api/purchase/checkout/start', {
            method: 'POST',
            body: JSON.stringify({ sku: pendingCheckout.sku, name, waNum }),
        });
        const jobId = startRes.jobId;

        // 2. Poll job status
        let done = false;
        let result = null;
        const token = await getToken();
        while (!done) {
            const resp = await fetch(`${window.BACKEND_URL}/api/purchase/checkout/status/${jobId}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            if (!resp.ok) {
                throw new Error(`Status request failed (HTTP ${resp.status})`);
            }
            const status = await resp.json();

            if (deliveryBar) deliveryBar.style.width = status.percent + '%';
            if (deliveryPct) deliveryPct.textContent = status.percent + '%';
            if (deliveryLabel) deliveryLabel.textContent = status.label || 'Processing...';

            if (status.done) {
                done = true;
                result = status;
                break;
            }
            await new Promise(r => setTimeout(r, 500));
        }

        closeModal('deliveryModal');

        if (!result || !result.success) {
            throw new Error(result?.error || 'Purchase failed');
        }

        document.getElementById('keyProductName').textContent = pendingCheckout.name;
        document.getElementById('keyValue').textContent = result.key;
        openModal('keyModal');

        if (result.newBalance !== undefined) {
            document.getElementById('balAmount').textContent = result.newBalance;
            const bar = document.getElementById('balBar');
            if (bar) bar.style.width = Math.min(100, (result.newBalance / 10)) + '%';
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
        loadBalance();
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
