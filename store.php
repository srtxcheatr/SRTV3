<?php
$pageTitle = 'Store — SRT X CHEATS';
$currentPage = 'store';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
    <div class="banner-carousel" id="bannerCarousel">
        <div class="banner-track" id="bannerTrack">
            <?php foreach (BANNERS as $b): ?>
            <a href="<?= htmlspecialchars($b['link']) ?>" target="_blank" class="banner-slide">
                <img src="<?= htmlspecialchars($b['image']) ?>" alt="Banner" loading="lazy">
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

<div id="checkoutModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-cart-shopping"></i> CONFIRM PURCHASE</div>
        <div id="checkoutSummary" style="font-size:13px;margin-bottom:14px"></div>
        <div class="field"><label><i class="fas fa-user"></i> Your Name</label><input type="text" id="payName" placeholder="Full name"></div>
        <div class="field"><label><i class="fab fa-whatsapp"></i> WhatsApp Number</label><input type="text" id="payWA" placeholder="98xxxxxxxx"></div>
        <button class="btn btn-solid" id="confirmBuyBtn" style="margin-bottom:8px"><i class="fas fa-check-circle"></i> Confirm Order</button>
        <button class="btn btn-ghost" id="closeCheckout"><i class="fas fa-xmark"></i> Cancel</button>
    </div>
</div>

<div id="deliveryModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:380px;width:100%;text-align:center;padding:24px">
        <div class="prompt-header" style="justify-content:center"><i class="fas fa-truck-fast" style="color:var(--neon-blue)"></i> GENERATING KEY...</div>
        <div class="dim" id="deliveryLabel" style="margin:12px 0 10px">Connecting to server...</div>
        <div style="height:8px;background:rgba(255,255,255,0.08);border-radius:10px;overflow:hidden;margin-bottom:12px">
            <div id="deliveryBar" style="height:100%;width:0%;background:linear-gradient(90deg,var(--neon-blue),var(--neon-purple));transition:width .4s"></div>
        </div>
        <div class="mono-num" id="deliveryPct" style="font-size:22px;font-weight:800;color:var(--neon-blue)">0%</div>
    </div>
</div>

<div id="keyModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-key" style="color:var(--neon-green)"></i> ACCESS KEY DELIVERED</div>
        <div id="keyProductName" style="font-size:13px;margin-bottom:8px"></div>
        <div style="background:rgba(0,0,0,0.3);border:1px solid var(--neon-green);border-radius:var(--radius-md);padding:14px;word-break:break-all;color:var(--neon-green);font-weight:700;margin-bottom:14px;font-family:var(--font-mono)" id="keyValue"></div>
        <button class="btn btn-solid" id="closeKey"><i class="fas fa-check"></i> Done</button>
    </div>
</div>

<div id="topupModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-qrcode"></i> TOPUP BALANCE</div>
        <div class="dim" style="font-size:12px;margin-bottom:12px"><i class="fas fa-info-circle"></i> Scan via eSewa & enter Transaction ID below.</div>
        <div style="text-align:center;margin-bottom:12px">
            <img src="https://i.postimg.cc/zXm07q9C/Screenshot-20260425-142906.jpg" alt="eSewa QR" style="max-width:180px;border-radius:12px;border:1px solid var(--glass-border)">
        </div>
        <div class="field"><label><i class="fas fa-receipt"></i> Transaction ID</label><input type="text" id="txIdInput" placeholder="Enter eSewa Txn ID"></div>
        <button class="btn btn-solid" id="submitTxId" style="margin-bottom:8px"><i class="fas fa-paper-plane"></i> Submit Topup</button>
        <button class="btn btn-ghost" id="closeTopup"><i class="fas fa-xmark"></i> Close</button>
    </div>
</div>

<div id="profileModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-user-gear"></i> PROFILE SETTINGS</div>
        <div class="field"><label><i class="fas fa-envelope"></i> Email</label><input type="text" id="profEmail" readonly style="opacity:0.7"></div>
        <div class="field"><label><i class="fas fa-user"></i> Name</label><input type="text" id="profName"></div>
        <div class="field"><label><i class="fab fa-whatsapp"></i> WhatsApp</label><input type="text" id="profWA"></div>
        <button class="btn btn-solid" id="saveProfile" style="margin-bottom:8px"><i class="fas fa-floppy-disk"></i> Save Details</button>
        <button class="btn btn-ghost" id="closeProfile"><i class="fas fa-xmark"></i> Close</button>
    </div>
</div>

<div id="helpModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-headset"></i> SUPPORT / REPORT</div>
        <div class="field"><label><i class="fas fa-comment-dots"></i> Describe your issue</label><textarea id="problemText" rows="3"></textarea></div>
        <button class="btn btn-solid" id="submitReport" style="margin-bottom:8px"><i class="fas fa-paper-plane"></i> Send Report</button>
        <button class="btn btn-ghost" id="closeHelp"><i class="fas fa-xmark"></i> Close</button>
    </div>
</div>

<div id="passwordModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-shield-halved"></i> CHANGE PASSWORD</div>
        <div class="field"><label>Current Password</label><input type="password" id="curPass"></div>
        <div class="field"><label>New Password</label><input type="password" id="newPass"></div>
        <button class="btn btn-solid" id="savePassword" style="margin-bottom:8px"><i class="fas fa-key"></i> Update Password</button>
        <button class="btn btn-ghost" id="closePassword"><i class="fas fa-xmark"></i> Close</button>
    </div>
</div>

<script type="module">
import {
    auth, requireAuth, backendFetch, toast, setButtonLoading, esc, signOut,
    EmailAuthProvider, reauthenticateWithCredential, updatePassword
} from '/assets/js/app.js';

let userCache = null;
let catalogCache = [];
let activeTag = 'ALL';
let pendingPurchase = null;

const openModal = (id) => document.getElementById(id)?.classList.remove('hidden');
const closeModal = (id) => document.getElementById(id)?.classList.add('hidden');

function setSafeText(id, text) {
    const el = document.getElementById(id);
    if (el) el.textContent = text;
}
function setSafeHtml(id, html) {
    const el = document.getElementById(id);
    if (el) el.innerHTML = html;
}

// Modal Click Bindings
document.getElementById('closeCheckout')?.addEventListener('click', () => closeModal('checkoutModal'));
document.getElementById('closeKey')?.addEventListener('click', () => closeModal('keyModal'));
document.getElementById('closeTopup')?.addEventListener('click', () => closeModal('topupModal'));
document.getElementById('closeProfile')?.addEventListener('click', () => closeModal('profileModal'));
document.getElementById('closeHelp')?.addEventListener('click', () => closeModal('helpModal'));
document.getElementById('closePassword')?.addEventListener('click', () => closeModal('passwordModal'));

document.getElementById('logoutBtn')?.addEventListener('click', async () => {
    await signOut(auth);
    window.location.href = '/home.php';
});

// Banner Carousel with Touch Gesture Swipe & Auto-Slide
(function initBanner() {
    const track = document.getElementById('bannerTrack');
    const dots = document.querySelectorAll('.banner-dot');
    const carousel = document.getElementById('bannerCarousel');
    if (!track || dots.length === 0) return;

    let index = 0;
    let startX = 0;
    let isSwiping = false;

    function setSlide(i) {
        index = (i + dots.length) % dots.length;
        track.style.transform = `translateX(-${index * 100}%)`;
        dots.forEach((d, idx) => d.classList.toggle('active', idx === index));
    }

    dots.forEach((d, idx) => d.onclick = () => setSlide(idx));

    let timer = setInterval(() => setSlide(index + 1), 4000);

    carousel.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isSwiping = true;
        clearInterval(timer);
    }, { passive: true });

    carousel.addEventListener('touchend', (e) => {
        if (!isSwiping) return;
        let diff = startX - e.changedTouches[0].clientX;
        if (diff > 40) setSlide(index + 1);
        else if (diff < -40) setSlide(index - 1);
        isSwiping = false;
        timer = setInterval(() => setSlide(index + 1), 4000);
    }, { passive: true });
})();

// Main Auth & Data Fetching
requireAuth(async () => {
    loadUser();
    loadCatalog();
    loadNotice();
});

async function loadUser() {
    try {
        const res = await backendFetch('/api/user/me');
        const u = (res && (res.user || res.data)) ? (res.user || res.data) : res;
        userCache = u || {};
        
        const bal = u.balance ?? 0;
        setSafeText('balAmount', bal);
        
        const bar = document.getElementById('balBar');
        if (bar) bar.style.width = `${Math.min(100, (bal / 1000) * 100)}%`;
        
        setSafeText('statusVal', u.status || 'Active');
        
        const profEmail = document.getElementById('profEmail');
        if (profEmail) profEmail.value = u.email || auth.currentUser?.email || '';
        
        const profName = document.getElementById('profName');
        if (profName) profName.value = u.name || '';
        
        const profWA = document.getElementById('profWA');
        if (profWA) profWA.value = u.whatsapp || '';
    } catch (e) {
        console.error("loadUser error:", e);
        setSafeText('statusVal', 'Offline');
        toast('User sync error: ' + e.message, 'error');
    }
}

async function loadNotice() {
    try {
        const n = await backendFetch('/api/notice');
        const text = typeof n === 'string' ? n : (n.notice || n.text || n.message || n.announcement || '');
        setSafeHtml('noticeText', text ? esc(text) : 'No new announcements.');
    } catch (e) {
        console.error("loadNotice error:", e);
        setSafeText('noticeText', 'Welcome to SRT X CHEATS.');
    }
}

async function loadCatalog() {
    const list = document.getElementById('catalogList');
    if (!list) return;
    try {
        const res = await backendFetch('/api/catalog');
        if (Array.isArray(res)) {
            catalogCache = res;
        } else if (res && Array.isArray(res.catalog)) {
            catalogCache = res.catalog;
        } else if (res && Array.isArray(res.products)) {
            catalogCache = res.products;
        } else if (res && Array.isArray(res.items)) {
            catalogCache = res.items;
        } else {
            catalogCache = [];
        }
        renderCatalog();
    } catch (e) {
        console.error("loadCatalog error:", e);
        list.innerHTML = `<div style="color:var(--neon-red);padding:20px;text-align:center"><i class="fas fa-triangle-exclamation"></i> Failed to load catalog: ${esc(e.message)}</div>`;
    }
}

function renderCatalog() {
    const list = document.getElementById('catalogList');
    if (!list) return;
    const searchInput = document.getElementById('catalogSearch');
    const search = searchInput ? searchInput.value.toLowerCase().trim() : '';

    const filtered = catalogCache.filter(item => {
        if (!item) return false;
        const tags = item.tags || item.category || [];
        const tagArr = Array.isArray(tags) ? tags : [tags];
        const matchesTag = activeTag === 'ALL' || tagArr.some(t => String(t).toUpperCase().includes(activeTag));
        const nameStr = item.name || item.title || '';
        const matchesSearch = !search || nameStr.toLowerCase().includes(search);
        return matchesTag && matchesSearch;
    });

    if (!filtered.length) {
        list.innerHTML = '<div class="dim" style="text-align:center;padding:30px"><i class="fas fa-box-open" style="font-size:20px;margin-bottom:8px;display:block"></i>No product cheats found for this category.</div>';
        return;
    }

    list.innerHTML = filtered.map(item => {
        const prices = item.prices || item.price || {};
        let priceDisplay = 'N/A';
        if (typeof prices === 'object' && Object.keys(prices).length > 0) {
            priceDisplay = 'Rs ' + Math.min(...Object.values(prices).map(p => Number(p) || 0));
        } else if (typeof prices === 'number' || typeof prices === 'string') {
            priceDisplay = 'Rs ' + prices;
        }

        const tags = Array.isArray(item.tags) ? item.tags.join(' · ') : (item.tags || item.category || '');

        return `
            <div class="panel" style="margin-bottom:12px">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px">
                    <div>
                        <div style="font-weight:800;font-size:15px;color:var(--text-primary)">${esc(item.name || 'Unnamed Product')}</div>
                        <div style="font-size:11px;color:var(--neon-blue);margin-top:2px">${esc(tags)}</div>
                    </div>
                    <div style="color:var(--neon-amber);font-weight:800;font-size:16px" class="mono-num">
                        ${priceDisplay}
                    </div>
                </div>
                <div style="font-size:12px;color:var(--text-secondary);margin-bottom:12px">${esc(item.desc || item.description || '')}</div>
                <div style="display:flex;gap:6px;flex-wrap:wrap">
                    ${typeof prices === 'object' && !Array.isArray(prices) ? Object.entries(prices).map(([dur, price]) => `
                        <button class="btn btn-ghost buy-btn" style="flex:1;font-size:11px;padding:8px 10px;min-width:90px" 
                            data-id="${esc(item.id || '')}" data-name="${esc(item.name || '')}" data-dur="${esc(dur)}" data-price="${price}">
                            <i class="fas fa-cart-plus"></i> ${esc(dur)}: Rs ${price}
                        </button>
                    `).join('') : `
                        <button class="btn btn-ghost buy-btn" style="flex:1;font-size:11px;padding:8px 10px" 
                            data-id="${esc(item.id || '')}" data-name="${esc(item.name || '')}" data-dur="Standard" data-price="${prices}">
                            <i class="fas fa-cart-plus"></i> Buy: Rs ${prices}
                        </button>
                    `}
                </div>
            </div>
        `;
    }).join('');

    document.querySelectorAll('.buy-btn').forEach(btn => {
        btn.onclick = () => {
            pendingPurchase = { ...btn.dataset };
            const summary = document.getElementById('checkoutSummary');
            if (summary) {
                summary.innerHTML = `
                    Purchase <strong>${esc(pendingPurchase.name)}</strong> (${esc(pendingPurchase.dur)}) for 
                    <strong style="color:var(--neon-amber)">Rs ${pendingPurchase.price}</strong>?
                `;
            }
            const payName = document.getElementById('payName');
            if (payName) payName.value = userCache?.name || '';
            const payWA = document.getElementById('payWA');
            if (payWA) payWA.value = userCache?.whatsapp || '';
            openModal('checkoutModal');
        };
    });
}

// Category Filter Binding
document.querySelectorAll('.cat-filter').forEach(btn => {
    btn.onclick = () => {
        document.querySelectorAll('.cat-filter').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeTag = btn.dataset.tag;
        renderCatalog();
    };
});
const searchEl = document.getElementById('catalogSearch');
if (searchEl) searchEl.oninput = renderCatalog;

// Purchase Order Handler
document.getElementById('confirmBuyBtn')?.addEventListener('click', async () => {
    if (!pendingPurchase) return;
    const name = document.getElementById('payName').value.trim();
    const wa = document.getElementById('payWA').value.trim();
    if (!name || !wa) return toast('Please provide Name and WhatsApp', 'error');

    closeModal('checkoutModal');
    openModal('deliveryModal');

    const bar = document.getElementById('deliveryBar');
    const pct = document.getElementById('deliveryPct');

    let progress = 0;
    const interval = setInterval(() => {
        progress += 15;
        if (progress > 90) clearInterval(interval);
        if (bar) bar.style.width = `${progress}%`;
        if (pct) pct.textContent = `${progress}%`;
    }, 150);

    try {
        const res = await backendFetch('/api/buy', {
            method: 'POST',
            body: JSON.stringify({
                itemId: pendingPurchase.id,
                duration: pendingPurchase.dur,
                name, whatsapp: wa
            })
        });

        clearInterval(interval);
        if (bar) bar.style.width = '100%';
        if (pct) pct.textContent = '100%';

        setTimeout(() => {
            closeModal('deliveryModal');
            setSafeText('keyProductName', pendingPurchase.name);
            setSafeText('keyValue', res.key || 'License generated successfully!');
            openModal('keyModal');
            loadUser();
        }, 400);

    } catch (e) {
        clearInterval(interval);
        closeModal('deliveryModal');
        toast(e.message, 'error');
    }
});

// Modals Trigger Handlers
document.getElementById('openTopup')?.addEventListener('click', () => openModal('topupModal'));
document.getElementById('openProfile')?.addEventListener('click', () => openModal('profileModal'));
document.getElementById('openHelp')?.addEventListener('click', () => openModal('helpModal'));
document.getElementById('openPassword')?.addEventListener('click', () => openModal('passwordModal'));

// Submit Topup
document.getElementById('submitTxId')?.addEventListener('click', async () => {
    const txId = document.getElementById('txIdInput').value.trim();
    if (!txId) return toast('Please enter Transaction ID', 'error');
    const btn = document.getElementById('submitTxId');
    setButtonLoading(btn, true);
    try {
        await backendFetch('/api/topup', { method: 'POST', body: JSON.stringify({ txId }) });
        toast('Topup request submitted!', 'success');
        document.getElementById('txIdInput').value = '';
        closeModal('topupModal');
    } catch (e) {
        toast(e.message, 'error');
    } finally {
        setButtonLoading(btn, false);
    }
});

// Save Profile
document.getElementById('saveProfile')?.addEventListener('click', async () => {
    const name = document.getElementById('profName').value.trim();
    const whatsapp = document.getElementById('profWA').value.trim();
    const btn = document.getElementById('saveProfile');
    setButtonLoading(btn, true);
    try {
        await backendFetch('/api/user/profile', { method: 'POST', body: JSON.stringify({ name, whatsapp }) });
        toast('Profile updated', 'success');
        closeModal('profileModal');
        loadUser();
    } catch (e) {
        toast(e.message, 'error');
    } finally {
        setButtonLoading(btn, false);
    }
});

// Submit Report
document.getElementById('submitReport')?.addEventListener('click', async () => {
    const problem = document.getElementById('problemText').value.trim();
    if (!problem) return toast('Describe the problem first', 'error');
    const btn = document.getElementById('submitReport');
    setButtonLoading(btn, true);
    try {
        await backendFetch('/api/user/report', { method: 'POST', body: JSON.stringify({ problem }) });
        toast('Report sent', 'success');
        document.getElementById('problemText').value = '';
        closeModal('helpModal');
    } catch (e) {
        toast(e.message, 'error');
    } finally {
        setButtonLoading(btn, false);
    }
});

// Save Password
document.getElementById('savePassword')?.addEventListener('click', async () => {
    const curPass = document.getElementById('curPass').value;
    const newPass = document.getElementById('newPass').value;
    if (!curPass || !newPass) return toast('Fill both password fields', 'error');
    if (newPass.length < 6) return toast('New password must be at least 6 characters', 'error');
    const btn = document.getElementById('savePassword');
    setButtonLoading(btn, true);
    try {
        const cred = EmailAuthProvider.credential(auth.currentUser.email, curPass);
        await reauthenticateWithCredential(auth.currentUser, cred);
        await updatePassword(auth.currentUser, newPass);
        toast('Password updated successfully', 'success');
        closeModal('passwordModal');
        document.getElementById('curPass').value = '';
        document.getElementById('newPass').value = '';
    } catch (e) {
        toast(e.code === 'auth/wrong-password' ? 'Current password incorrect' : e.message, 'error');
    } finally {
        setButtonLoading(btn, false);
    }
});
</script>
