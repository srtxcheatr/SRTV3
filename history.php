<?php
$pageTitle = 'History — SRT X CHEATS';
$currentPage = 'history';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
    <div class="prompt-header"><i class="fas fa-receipt"></i> PURCHASE HISTORY</div>
    <div id="historyList">
        <div class="dim" style="text-align:center;padding:30px">
            <i class="fas fa-circle-notch fa-spin" style="font-size:24px;color:var(--neon-blue);margin-bottom:8px"></i>
            <div>Loading purchase history...</div>
        </div>
    </div>

    <button class="btn btn-danger" id="clearBtn" style="margin-top:16px"><i class="fas fa-trash-can"></i> Clear Purchase History</button>
</div>

<style>
.log-entry {
    background: var(--glass-panel, #161b22);
    border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1));
    border-radius: var(--radius-md, 8px);
    padding: 14px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}
.log-entry:hover {
    border-color: var(--neon-blue, #00f0ff);
    box-shadow: 0 4px 15px rgba(0, 240, 255, 0.15);
}
.log-entry .top { 
    display: flex; 
    justify-content: space-between; 
    align-items: center;
    margin-bottom: 6px; 
}
.log-entry .name { 
    font-weight: 700; 
    color: var(--text-primary, #ffffff); 
    font-size: 13px; 
}
.log-entry .price { 
    color: var(--neon-amber, #ffb703); 
    font-weight: 800; 
    font-family: var(--font-mono, monospace); 
}
.log-entry .meta { 
    color: var(--text-muted, #8b949e); 
    font-size: 11px; 
    margin-bottom: 8px; 
}

/* Key Container Fixes (Readable in Light/Dark Modes) */
.log-entry .key-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #0f172a; /* Solid high-contrast background */
    border: 1px solid rgba(0, 240, 255, 0.25);
    border-radius: var(--radius-sm, 6px);
    padding: 8px 12px;
    gap: 10px;
}

.log-entry .key-text {
    font-family: var(--font-mono, monospace);
    color: #00ff88; /* High-contrast neon green */
    word-break: break-all;
    font-size: 12px;
    font-weight: 600;
}

/* Copy Button Styling */
.copy-btn {
    background: rgba(0, 240, 255, 0.15);
    border: 1px solid rgba(0, 240, 255, 0.4);
    color: #00f0ff;
    border-radius: 4px;
    padding: 5px 10px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.copy-btn:hover {
    background: #00f0ff;
    color: #000;
}

.copy-btn.copied {
    background: #00ff88;
    border-color: #00ff88;
    color: #000;
}
</style>

<script>
// Function to copy key to clipboard with visual feedback
function copyKey(keyText, btnElement) {
    navigator.clipboard.writeText(keyText).then(() => {
        const originalHTML = btnElement.innerHTML;
        btnElement.classList.add('copied');
        btnElement.innerHTML = '<i class="fas fa-check"></i> Copied!';
        
        setTimeout(() => {
            btnElement.classList.remove('copied');
            btnElement.innerHTML = originalHTML;
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy key: ', err);
    });
}
</script>
