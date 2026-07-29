<?php
$currentPage = $currentPage ?? 'home';
$breadcrumb  = $breadcrumb ?? $currentPage;
?>
<header class="glass-nav-header">
    <div class="nav-container">
        <a href="<?= $currentPage === 'home' ? '/home.php' : '/index.php' ?>" class="brand-logo">
            <div class="logo-img-wrap">
                <img src="https://i.ibb.co/9HmdjJr1/file-000000008a6481f588e660845aa6efa9.png" alt="SRT X CHEATS Logo" class="site-logo">
            </div>
            <div class="brand-title">
                <span class="brand-main">SRT<span class="neon-cyan">X</span></span>
                <span class="brand-sub">STORE</span>
            </div>
        </a>

        <div class="nav-actions">
            <?php if ($currentPage !== 'home'): ?>
                <nav class="nav-links">
                    <a href="/index.php" class="nav-item <?= (in_array($currentPage, ['store', 'index'])) ? 'active' : '' ?>">
                        <i class="fas fa-store"></i> <span class="nav-text">Store</span>
                    </a>
                    <a href="/history.php" class="nav-item <?= $currentPage === 'history' ? 'active' : '' ?>">
                        <i class="fas fa-clock-rotate-left"></i> <span class="nav-text">History</span>
                    </a>
                </nav>
            <?php endif; ?>

            <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Toggle Theme">
                <i class="fas fa-moon moon-icon"></i>
                <i class="fas fa-sun sun-icon"></i>
            </button>

            <?php if ($currentPage !== 'home'): ?>
                <a href="#" class="btn-logout" onclick="doLogout(); return false;" title="Logout">
                    <i class="fas fa-right-from-bracket"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeBtn = document.getElementById('themeToggleBtn');
    if (themeBtn) {
        themeBtn.addEventListener('click', function() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme') || 'dark';
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('srtx_theme', next);
        });
    }
});
</script>