<?php
// includes/nav.php — Header with Top-Left Logo & Dark/Light Mode Switcher
$breadcrumb = $breadcrumb ?? $currentPage;
?>
<header class="glass-nav-header">
    <div class="nav-container">
        <a href="<?= $currentPage === 'home' ? '/home.php' : '/store.php' ?>" class="brand-logo">
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
                <a href="/store.php" class="nav-item <?= $currentPage === 'store' ? 'active' : '' ?>">
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
            <button type="button" class="btn-logout" id="logoutBtn" title="Logout">
                <i class="fas fa-right-from-bracket"></i>
            </button>
            <?php endif; ?>
        </div>
    </div>
</header>

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
});
</script>
