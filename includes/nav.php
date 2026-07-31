<?php
// includes/nav.php — Minimal top header + left drawer menu + bottom tab bar
$breadcrumb = $breadcrumb ?? $currentPage;
$pageTitles = ['store' => 'Store', 'history' => 'Order History'];
$headerTitle = $pageTitles[$currentPage] ?? 'SRT X CHEATS';
$isGuestPage = $currentPage === 'home';
?>
<header class="glass-nav-header">
    <div class="nav-container">
        <?php if (!$isGuestPage): ?>
        <button type="button" class="icon-btn" id="drawerToggle" title="Menu">
            <i class="fas fa-bars"></i>
        </button>
        <?php endif; ?>
        <div class="page-title"><?= htmlspecialchars($headerTitle) ?></div>
        <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Toggle Light/Dark Theme">
            <i class="fas fa-moon moon-icon"></i>
            <i class="fas fa-sun sun-icon"></i>
        </button>
    </div>
</header>

<?php if (!$isGuestPage): ?>
<div class="drawer-backdrop hidden" id="drawerBackdrop"></div>
<aside class="drawer-panel" id="drawerPanel">
    <div class="drawer-header">
        <div class="drawer-brand">
            <div class="logo-img-wrap" style="width:32px;height:32px">
                <img src="https://i.postimg.cc/qqYtBD3k/file-00000000470c8208bd1a0215abff7977.png" alt="SRT X CHEATS Logo" class="site-logo">
            </div>
            <div class="brand-title" style="font-size:14px">ADMIN<span class="neon-cyan">PANEL</span></div>
        </div>
        <button type="button" class="icon-btn" id="drawerClose" title="Close"><i class="fas fa-xmark"></i></button>
    </div>

    <div class="drawer-user">
        <div class="avatar-circle"><i class="fas fa-user"></i></div>
        <div class="drawer-user-name" id="drawerUserName">My Account</div>
    </div>

    <div class="drawer-balance-card">
        <div class="dbc-label"><i class="fas fa-wallet"></i> BALANCE</div>
        <div class="dbc-amount" id="drawerBalance">Rs —</div>
        <a href="/store.php#topup" class="dbc-btn"><i class="fas fa-circle-plus"></i> Add Balance</a>
    </div>

    <div class="drawer-section-label">Account</div>
    <a href="/store.php#profile" class="drawer-item"><i class="fas fa-user-gear"></i> Profile</a>
    <a href="/store.php#support" class="drawer-item"><i class="fas fa-headset"></i> Support</a>
    <a href="/store.php#password" class="drawer-item"><i class="fas fa-shield-halved"></i> Password</a>
    <a href="<?= htmlspecialchars(DEVELOPER_URL) ?>" target="_blank" class="drawer-item"><i class="fas fa-code"></i> About Developer</a>

    <button type="button" class="drawer-logout" id="drawerLogoutBtn">
        <i class="fas fa-right-from-bracket"></i> Logout
    </button>
</aside>

<nav class="bottom-tabbar">
    <a href="/store.php" class="tab-item <?= $currentPage === 'store' ? 'active' : '' ?>">
        <i class="fas fa-store"></i><span>Store</span>
    </a>
    <a href="/history.php" class="tab-item <?= $currentPage === 'history' ? 'active' : '' ?>">
        <i class="fas fa-clock-rotate-left"></i><span>History</span>
    </a>
    <a href="/store.php#topup" class="tab-fab" title="Add Balance"><i class="fas fa-coins"></i></a>
    <a href="/store.php#support" class="tab-item"><i class="fas fa-headset"></i><span>Support</span></a>
    <button type="button" class="tab-item" id="drawerToggle2"><i class="fas fa-ellipsis"></i><span>More</span></button>
</nav>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const themeBtn = document.getElementById('themeToggleBtn');
    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('srtx_theme', newTheme);
        });
    }

    const drawerPanel = document.getElementById('drawerPanel');
    const drawerBackdrop = document.getElementById('drawerBackdrop');
    if (drawerPanel && drawerBackdrop) {
        const openDrawer = () => { drawerPanel.classList.add('open'); drawerBackdrop.classList.remove('hidden'); drawerBackdrop.classList.add('show'); };
        const closeDrawer = () => { drawerPanel.classList.remove('open'); drawerBackdrop.classList.remove('show'); setTimeout(() => drawerBackdrop.classList.add('hidden'), 250); };
        window.openDrawer = openDrawer;
        window.closeDrawer = closeDrawer;
        document.getElementById('drawerToggle')?.addEventListener('click', openDrawer);
        document.getElementById('drawerToggle2')?.addEventListener('click', openDrawer);
        document.getElementById('drawerClose')?.addEventListener('click', closeDrawer);
        drawerBackdrop.addEventListener('click', closeDrawer);
    }

    // Logout button lives in the drawer now — every page needs a working
    // doLogout(); store.php and history.php each define it with their own
    // imported `auth`. If a page hasn't defined it, fail quietly instead
    // of throwing.
    document.getElementById('drawerLogoutBtn')?.addEventListener('click', () => {
        if (typeof window.doLogout === 'function') window.doLogout();
    });
});
</script>
