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
        <button class="btn btn-ghost" id="openProfile"><i class="fas fa-user-gear" style="color:var(--neon-blue)"></i> Profile Settings</button>
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
        <button class="btn btn-solid" id="confirmBuyBtn" style="margin-bottom:8px">
            <i class="fas fa-check-circle"></i> Confirm Order
        </button>
        <button class="btn btn-ghost" onclick="closeModal('checkoutModal')"><i class="fas fa-xmark"></i> Cancel</button>
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
        <button class="btn btn-solid" onclick="closeModal('keyModal')"><i class="fas fa-copy"></i> Done</button>
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
        <button class="btn btn-ghost" onclick="closeModal('topupModal')"><i class="fas fa-xmark"></i> Close</button>
    </div>
</div>
