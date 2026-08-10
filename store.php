<?php
$pageTitle = 'Store — SRT X CHEATS';
$currentPage = 'store';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
    <div class="term-content">

        <div class="tab-row">
            <a href="/store.php" class="tab-pill active"><i class="fas fa-store"></i> Store</a>
            <a href="/history.php" class="tab-pill"><i class="fas fa-clock-rotate-left"></i> Order History</a>
        </div>

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

        <div class="panel panel-premium" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
            <div>
                <div class="dim" style="font-size:11px"><i class="fas fa-wallet" style="color:var(--neon-amber)"></i> BALANCE</div>
                <div style="font-weight:800;font-size:22px" class="mono-num gold-text">Rs <span id="balAmount">—</span></div>
            </div>
            <div style="flex:1;min-width:80px">
                <div style="height:6px;border-radius:6px;background:var(--surface-tint-strong);overflow:hidden">
                    <div id="balBar" style="width:0%;height:100%;background:var(--gold-shine);transition:width 0.4s ease"></div>
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

        <div class="prompt-header"><i class="fas fa-gamepad"></i> PRODUCTS CATALOG</div>
        <div style="position:relative;margin-bottom:10px">
            <i class="fas fa-magnifying-glass" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--text-muted)"></i>
            <input type="text" id="catalogSearch" placeholder="Search product cheats..." style="padding-left:38px">
        </div>

        <div id="catFilters" style="display:flex;gap:8px;margin-bottom:14px;overflow-x:auto;padding-bottom:4px">
            <button class="cat-filter active" data-tag="ALL"><i class="fas fa-layer-group"></i> ALL</button>
            <button class="cat-filter" data-tag="ROOT"><i class="fas fa-mobile-screen-button"></i> ROOT</button>
            <button class="cat-filter" data-tag="NONROOT"><i class="fas fa-tablet-screen-button"></i> NONROOT</button>
            <button class="cat-filter" data-tag="PC"><i class="fas fa-desktop"></i> PC</button>
            <button class="cat-filter" data-tag="IOS"><i class="fab fa-apple"></i> IOS</button>
        </div>

        <div id="catalogList" class="product-grid">
            <div class="dim" style="text-align:center;padding:30px">
                <i class="fas fa-circle-notch fa-spin" style="font-size:24px;color:var(--neon-blue);margin-bottom:8px"></i>
                <div>Loading catalog options...</div>
            </div>
        </div>

    </div>
</div>

<div id="durationModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-layer-group"></i> <span id="durationTitle">SELECT DURATION</span></div>
        <div id="durationList"></div>
        <button class="btn btn-ghost" style="margin-top:10px" onclick="closeModal('durationModal')"><i class="fas fa-xmark"></i> Close</button>
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
    <div class="panel" style="max-width:400px;width:100%;text-align:center;padding:28px 20px">
        <div class="prompt-header" style="justify-content:center;margin-bottom:18px">
            <i class="fas fa-shield-halved" style="color:var(--neon-amber)"></i> Fetching Access Key...
        </div>

        <div class="load-ring-wrap" id="deliveryRingWrap">
            <svg class="load-ring" viewBox="0 0 120 120">
                <circle class="load-ring-bg" cx="60" cy="60" r="52"></circle>
                <circle class="load-ring-fg" id="deliveryRing" cx="60" cy="60" r="52"></circle>
            </svg>
            <div class="load-ring-center">
                <i class="fas fa-key load-ring-icon" id="deliveryIcon"></i>
                <div class="mono-num load-ring-pct" id="deliveryPct">0%</div>
            </div>
        </div>

        <div class="dim" id="deliveryLabel" style="font-size:12px;margin-top:14px;color:var(--text-secondary)">Connecting to server...</div>
    </div>
</div>

<div id="keyModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-key" style="color:var(--neon-green)"></i> ACCESS KEY DELIVERED</div>
        <div id="keyProductName" style="font-size:13px;margin-bottom:8px"></div>
        <div style="background:var(--input-bg);border:1px solid var(--neon-green);border-radius:var(--radius-md);padding:14px;word-break:break-all;color:var(--neon-green);font-weight:700;margin-bottom:14px;font-family:var(--font-mono)" id="keyValue"></div>
        <button class="btn btn-solid" onclick="closeModal('keyModal')"><i class="fas fa-check"></i> Done</button>
    </div>
</div>

<div id="topupModal" class="modal-overlay hidden">
    <div class="panel" style="max-width:400px;width:100%">
        <div class="prompt-header"><i class="fas fa-qrcode"></i> TOPUP BALANCE</div>

        <div class="topup-steps" id="topupSteps">
            <span class="topup-step active" data-step="1">1</span>
            <span class="topup-step-line"></span>
            <span class="topup-step" data-step="2">2</span>
            <span class="topup-step-line"></span>
            <span class="topup-step" data-step="3">3</span>
        </div>

        <!-- Step 1: eSewa number only -->
        <div class="topup-step-panel" id="topupStep1">
            <div class="field"><label><i class="fas fa-id-card"></i> Enter eSewa Number</label><input type="text" id="topupEsewa" placeholder="98xxxxxxxx" inputmode="numeric"></div>
            <button class="btn btn-solid" id="topupNext1" style="margin-bottom:8px"><i class="fas fa-arrow-right"></i> Next</button>
            <button class="btn btn-ghost" onclick="closeModal('topupModal')"><i class="fas fa-xmark"></i> Cancel</button>
        </div>

        <!-- Step 2: Balance / amount to top up -->
        <div class="topup-step-panel hidden" id="topupStep2">
            <div class="dim" style="font-size:12px;margin-bottom:12px" id="topupHint"><i class="fas fa-info-circle"></i> Pay via eSewa, then submit your transaction ID.</div>

            <div style="font-size:11px;font-weight:700;letter-spacing:0.5px;color:var(--text-secondary);margin-bottom:8px"><i class="fas fa-rupee-sign"></i> BALANCE (RS)</div>
            <div class="amount-chip-row" id="amountChipRow">
                <button type="button" class="amount-chip active" data-amount="100">Rs 100</button>
                <button type="button" class="amount-chip" data-amount="500">Rs 500</button>
                <button type="button" class="amount-chip" data-amount="1000">Rs 1000</button>
                <button type="button" class="amount-chip" data-amount="2000">Rs 2000</button>
                <button type="button" class="amount-chip" data-amount="5000">Rs 5000</button>
                <button type="button" class="amount-chip" id="amountChipCustom" data-amount="custom"><i class="fas fa-pen"></i> Custom</button>
            </div>
            <div class="field" id="customAmountField" style="display:none">
                <label id="customAmountLabel"><i class="fas fa-pen"></i> Enter Custom Amount</label>
                <input type="number" id="topupAmount" value="1000" min="50">
            </div>
            <button class="btn btn-solid" id="topupNext2" style="margin-bottom:8px"><i class="fas fa-arrow-right"></i> Next</button>
            <button class="btn btn-ghost" id="topupBack2"><i class="fas fa-arrow-left"></i> Back</button>
        </div>

        <!-- Step 3: QR code + warning + transaction code -->
        <div class="topup-step-panel hidden" id="topupStep3">
            <div style="text-align:center;margin-bottom:12px">
                <img src="https://i.postimg.cc/zXm07q9C/Screenshot-20260425-142906.jpg" alt="eSewa QR" style="max-width:180px;border-radius:12px;border:1px solid var(--glass-border)">
            </div>
            <div class="topup-warning">
                <i class="fas fa-triangle-exclamation"></i>
                Pay from eSewa and enter the right amount. Wrong amount = order cancelled ❌ — no refunds.
            </div>
            <div class="field"><label><i class="fas fa-hashtag"></i> Transaction Code</label><input type="text" id="topupTx" placeholder="e.g. JRJDHD"></div>
            <button class="btn btn-solid" id="submitTopup" style="margin-bottom:8px;position:relative">
                <span class="btn-text"><i class="fas fa-paper-plane"></i> Submit Topup</span>
                <span class="btn-spinner hidden"><span class="spinner"></span></span>
            </button>
            <button class="btn btn-ghost" id="topupBack3"><i class="fas fa-arrow-left"></i> Back</button>
        </div>
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
        <div class="prompt-header"><i class="fas fa-headset"></i> WELCOME TO SRT SUPPORT</div>
        <div class="support-ticket">
            <div class="ticket-row"><span class="k">Token</span><span class="eq">=</span><span class="v" id="supToken">—</span></div>
            <div class="ticket-row"><span class="k">UID</span><span class="eq">=</span><span class="v" id="supUid">—</span></div>
            <div class="ticket-row"><span class="k">Name</span><span class="eq">=</span><span class="v" id="supName">—</span></div>
            <div class="ticket-row"><span class="k">WhatsApp</span><span class="eq">=</span><span class="v" id="supWa">—</span></div>
            <div class="ticket-row"><span class="k">Email</span><span class="eq">=</span><span class="v" id="supEmail">—</span></div>
        </div>
        <div class="field" style="margin-top:14px"><label><i class="fas fa-comment-dots"></i> Describe your problem or glitches</label><textarea id="problemText" rows="3" placeholder="Tell us what happened..."></textarea></div>
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
/* ----- Duration list rows (used inside the duration-select modal) ----- */
.dur-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 12px 14px; font-size: 13px;
    border-top: 1px solid var(--glass-border);
    cursor: pointer;
    transition: background 0.15s;
}
.dur-row:hover { background: var(--surface-tint); }
.dur-row .price { color: var(--neon-amber); font-weight: 700; }
.apk-update-row {
    display: flex; align-items: center; gap: 8px;
    padding: 12px 14px; font-size: 12px; font-weight: 700;
    border-top: 1px solid var(--glass-border);
    color: var(--neon-blue);
    text-decoration: none;
}
.apk-update-row:hover { background: rgba(0,240,255,0.05); }

/* ----- Access-key delivery: circular progress ring ----- */
.load-ring-wrap {
    position: relative;
    width: 132px;
    height: 132px;
    margin: 0 auto;
}
.load-ring {
    width: 100%;
    height: 100%;
    transform: rotate(-90deg);
    filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.35));
}
.load-ring-bg {
    fill: none;
    stroke: var(--surface-tint-strong);
    stroke-width: 8;
}
.load-ring-fg {
    fill: none;
    stroke: var(--neon-amber);
    stroke-width: 8;
    stroke-linecap: round;
    stroke-dasharray: 326.7;
    stroke-dashoffset: 326.7;
    transition: stroke-dashoffset 0.5s cubic-bezier(0.4, 0, 0.2, 1), stroke 0.4s ease;
}
.load-ring-fg.complete { stroke: var(--neon-green); }
.load-ring-center {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.load-ring-icon {
    font-size: 20px;
    color: var(--neon-amber);
    animation: ringIconPulse 1.6s ease-in-out infinite;
}
.load-ring-icon.complete { color: var(--neon-green); animation: none; }
.load-ring-pct {
    font-size: 18px;
    font-weight: 800;
    color: var(--text-primary);
}
@keyframes ringIconPulse {
    0%, 100% { transform: scale(1); opacity: 0.75; }
    50% { transform: scale(1.15); opacity: 1; }
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
    box-shadow: var(--card-shadow);
    position: relative;
}
.banner-track { display: flex; transition: transform 0.4s ease-in-out; }
.banner-slide { min-width: 100%; position: relative; }
.banner-slide img {
    width: 100%; height: 160px; object-fit: cover; display: block;
    filter: saturate(0.72) brightness(0.94);
}
.banner-slide::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(160deg, rgba(88, 28, 220, 0.22), transparent 55%),
                linear-gradient(0deg, rgba(4, 3, 12, 0.5), transparent 45%);
    pointer-events: none;
}
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

/* ----- Topup step wizard ----- */
.topup-steps {
    display: flex; align-items: center; justify-content: center;
    gap: 6px; margin-bottom: 18px;
}
.topup-step {
    width: 26px; height: 26px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
    background: var(--surface-tint-strong);
    color: var(--text-muted);
    border: 1px solid var(--glass-border);
    transition: all 0.25s ease;
}
.topup-step.active {
    background: linear-gradient(135deg, var(--neon-purple), #6d28d9);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 0 10px rgba(168,85,247,0.5);
}
.topup-step.done {
    background: var(--neon-green);
    color: #fff;
    border-color: transparent;
}
.topup-step-line {
    width: 28px; height: 2px;
    background: var(--glass-border);
}
.topup-step-panel.hidden { display: none; }
.topup-warning {
    display: flex; align-items: flex-start; gap: 8px;
    background: rgba(239,68,68,0.08);
    border: 1px solid var(--neon-red);
    border-radius: var(--radius-md);
    padding: 10px 12px;
    font-size: 12px; line-height: 1.5;
    color: var(--neon-red);
    margin-bottom: 14px;
}
.topup-warning i { margin-top: 2px; }

/* ----- Amount preset chips ----- */
.amount-chip-row {
    display: flex; flex-wrap: wrap; gap: 8px;
    margin-bottom: 14px;
}
.amount-chip {
    flex: 1 1 auto;
    min-width: 70px;
    padding: 10px 12px;
    border-radius: var(--radius-md);
    border: 1px solid var(--glass-border);
    background: var(--surface-tint);
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    text-align: center;
    transition: all 0.2s ease;
}
.amount-chip:hover { border-color: var(--neon-purple); color: var(--text-primary); }
.amount-chip.active {
    background: linear-gradient(135deg, var(--neon-purple), #6d28d9);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 0 10px rgba(168,85,247,0.4);
}
#amountChipCustom { flex-basis: 100%; }
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

// ---- Support ticket token (client-side reference number, sent along with the report) ----
let supportToken = null;
function getSupportToken() {
    if (!supportToken) supportToken = 'SRT-' + Math.random().toString(36).slice(2, 8).toUpperCase();
    return supportToken;
}

// ---- Open Support modal & populate the ticket fields ----
function openHelpModal() {
    document.getElementById('supToken').textContent = getSupportToken();
    document.getElementById('supUid').textContent = currentUid || '—';
    document.getElementById('supName').textContent = userState.profileName || '—';
    document.getElementById('supWa').textContent = userState.profilePhone || '—';
    document.getElementById('supEmail').textContent = userState.email || '—';
    openModal('helpModal');
}

// ---- Menu items live in the drawer/bottom-bar (nav.php) and link here via
// a URL hash (#topup, #profile, #support, #password) so they work from any
// page. Route the hash to the right modal, then clear it. ----
function routeHash() {
    const hash = location.hash.replace('#', '');
    if (!hash) return;
    if (hash === 'topup') { window.resetTopupSteps?.(); openModal('topupModal'); }
    else if (hash === 'profile') openModal('profileModal');
    else if (hash === 'password') openModal('passwordModal');
    else if (hash === 'support') openHelpModal();
    history.replaceState(null, '', location.pathname);
}
window.addEventListener('hashchange', routeHash);

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
    routeHash();
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
        const drawerBal = document.getElementById('drawerBalance');
        if (drawerBal) drawerBal.textContent = 'Rs ' + d.balance;
        const drawerName = document.getElementById('drawerUserName');
        if (drawerName) drawerName.textContent = d.profileName || 'My Account';
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
    const chipRow = document.getElementById('amountChipRow');
    const customField = document.getElementById('customAmountField');
    const customLabel = document.getElementById('customAmountLabel');
    if (!hasCompletedFirstTopup) {
        // First top-up is locked to a fixed amount — no chips, no custom entry.
        chipRow.style.display = 'none';
        customField.style.display = 'block';
        customLabel.innerHTML = '<i class="fas fa-lock"></i> First Top-up Amount (Fixed)';
        amountInput.value = 1000;
        amountInput.readOnly = true;
        amountInput.style.opacity = '0.6';
        hint.textContent = 'First top‑up is fixed at Rs 1,000. After approval you can top up any amount.';
    } else {
        chipRow.style.display = 'flex';
        amountInput.readOnly = false;
        amountInput.style.opacity = '1';
        hint.textContent = 'Pay via eSewa, then submit your transaction ID. Admin verifies and credits shortly.';
        selectAmountChip('100');
    }
}

// ---- Amount preset chips ----
function selectAmountChip(amount) {
    const amountInput = document.getElementById('topupAmount');
    const customField = document.getElementById('customAmountField');
    const customLabel = document.getElementById('customAmountLabel');
    document.querySelectorAll('.amount-chip').forEach(c => c.classList.toggle('active', c.dataset.amount === amount));
    if (amount === 'custom') {
        customLabel.innerHTML = '<i class="fas fa-pen"></i> Enter Custom Amount';
        customField.style.display = 'block';
        amountInput.readOnly = false;
        amountInput.style.opacity = '1';
        amountInput.value = '';
        amountInput.focus();
    } else {
        customField.style.display = 'none';
        amountInput.value = amount;
    }
}
document.getElementById('amountChipRow').addEventListener('click', (e) => {
    const chip = e.target.closest('.amount-chip');
    if (chip) selectAmountChip(chip.dataset.amount);
});

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

let lastGroups = [];

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
        container.innerHTML = '<div class="dim" style="text-align:center;padding:30px;grid-column:1/-1"><i class="fas fa-box-open"></i> No products match.</div>';
        return;
    }

    lastGroups = filteredEntries.map(([row, items]) => ({ row, items }));

    let html = '';
    lastGroups.forEach(({ row, items }, gi) => {
        const prices = items.map(it => it.price);
        const minPrice = Math.min(...prices);
        const priceLabel = prices.every(p => p === minPrice)
            ? `Rs ${minPrice}`
            : `From Rs ${minPrice}`;
        const durLabel = `${items.length} duration${items.length > 1 ? 's' : ''} available`;
        html += `
        <div class="product-card">
            <div class="product-thumb">
                <img src="${items[0].image || ''}" alt="${esc(row)}" loading="lazy">
                <span class="product-tag">${tagOf(row)}</span>
            </div>
            <div class="product-body">
                <div class="product-title">${esc(row)}</div>
                <div class="product-meta">${durLabel}<br><span class="gold-text" style="font-weight:700">${priceLabel}</span></div>
                <div class="product-actions">
                    <button class="btn-buy" onclick="window.__openDurations(${gi})"><i class="fas fa-cart-shopping"></i> Buy</button>
                    ${items[0].apkUrl ? `
                        <a href="${esc(items[0].apkUrl)}" target="_blank" class="btn-download" onclick="event.stopPropagation()">
                            <i class="fas fa-download"></i> Download
                        </a>
                    ` : ''}
                </div>
            </div>
        </div>`;
    });
    container.innerHTML = html;
}

// ---- Duration picker (opened from a product card's Buy button) ----
window.__openDurations = (gi) => {
    const group = lastGroups[gi];
    if (!group) return;
    document.getElementById('durationTitle').textContent = group.row;
    document.getElementById('durationList').innerHTML = group.items.map(it => `
        <div class="dur-row" onclick="window.__startCheckout('${it.sku}'); closeModal('durationModal')">
            <span>${esc(it.name)} <span class="dim">· ${esc(it.duration)}</span></span>
            <span class="price">Rs ${it.price}</span>
        </div>
    `).join('');
    openModal('durationModal');
};

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

// ---- Drive the circular progress ring on the delivery modal ----
const RING_CIRCUMFERENCE = 2 * Math.PI * 52; // matches r=52 on the SVG circle
function setDeliveryProgress(percent, label) {
    const ring = document.getElementById('deliveryRing');
    const icon = document.getElementById('deliveryIcon');
    const pct = document.getElementById('deliveryPct');
    const lbl = document.getElementById('deliveryLabel');
    const p = Math.max(0, Math.min(100, percent));
    if (ring) ring.style.strokeDashoffset = RING_CIRCUMFERENCE * (1 - p / 100);
    if (pct) pct.textContent = Math.round(p) + '%';
    if (lbl && label) lbl.textContent = label;
    const isComplete = p >= 100;
    ring?.classList.toggle('complete', isComplete);
    icon?.classList.toggle('complete', isComplete);
}

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

    // Reset the delivery ring
    setDeliveryProgress(0, 'Starting...');

    try {
        // 1. Start job via backendFetch
        const startRes = await backendFetch('/api/purchase/checkout/start', {
            method: 'POST',
            body: JSON.stringify({
                sku: pendingCheckout.sku,
                name,
                waNum,
            }),
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

            setDeliveryProgress(status.percent, status.label || 'Processing...');

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

// ---- Topup step wizard ----
function goToTopupStep(step) {
    [1, 2, 3].forEach(n => {
        document.getElementById(`topupStep${n}`).classList.toggle('hidden', n !== step);
        const dot = document.querySelector(`.topup-step[data-step="${n}"]`);
        if (dot) {
            dot.classList.toggle('active', n === step);
            dot.classList.toggle('done', n < step);
        }
    });
}
window.resetTopupSteps = () => {
    document.getElementById('topupTx').value = '';
    if (typeof userState !== 'undefined') setupTopupLock(userState?.hasCompletedFirstTopup);
    goToTopupStep(1);
};

document.getElementById('topupNext1').onclick = () => {
    const esewaId = document.getElementById('topupEsewa').value.trim();
    if (!esewaId) return toast('Enter your eSewa number', 'error');
    goToTopupStep(2);
};
document.getElementById('topupNext2').onclick = () => {
    const amount = parseInt(document.getElementById('topupAmount').value, 10);
    if (!amount || amount < 50) return toast('Enter a valid amount (min Rs 50)', 'error');
    goToTopupStep(3);
};
document.getElementById('topupBack2').onclick = () => goToTopupStep(1);
document.getElementById('topupBack3').onclick = () => goToTopupStep(2);

// ---- Topup ----
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
        resetTopupSteps();
    } catch (e) {
        toast(e.message, 'error');
    } finally {
        setLoading(topupBtn, false);
    }
};

// ---- Profile ----
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
const reportBtn = document.getElementById('submitReport');
reportBtn.onclick = async () => {
    const problem = document.getElementById('problemText').value.trim();
    if (!problem) return toast('Please describe the problem', 'error');
    setLoading(reportBtn, true);
    try {
        await backendFetch('/api/user/report', { method: 'POST', body: JSON.stringify({ problem, token: getSupportToken() }) });
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