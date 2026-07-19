<?php
// includes/nav.php — expects $currentPage ('home'|'store'|'history').
?>
<div class="bg-orbs">
    <div class="bg-orb o1"></div>
    <div class="bg-orb o2"></div>
    <div class="bg-orb o3"></div>
</div>
<div class="topbar">
    <div class="brand">SRT<span>X</span>CHEATS</div>
    <?php if ($currentPage !== 'home'): ?>
    <button class="btn btn-ghost" style="width:auto;padding:8px 14px;font-size:10px" onclick="doLogout()">LOGOUT</button>
    <?php endif; ?>
</div>
<?php if ($currentPage !== 'home'): ?>
<nav class="tabbar">
    <a href="/store.php" class="<?= $currentPage === 'store' ? 'active' : '' ?>">Store</a>
    <a href="/history.php" class="<?= $currentPage === 'history' ? 'active' : '' ?>">History</a>
</nav>
<?php endif; ?>
