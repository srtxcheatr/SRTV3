<?php
$pageTitle = 'SRT X CHEATS';
$currentPage = 'home';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="shell">
    <div class="content" style="padding-top:60px">

        <div id="loadScreen" style="text-align:center;padding-top:40px">
            <div class="logo-ring">
                <div class="logo-ring-glow"></div>
                <i class="logo-icon">⚡</i>
            </div>
            <div class="brand" style="font-size:26px;margin-top:20px">SRT<span>X</span>CHEATS</div>
            <div class="dim" style="font-size:12px;margin-top:6px;letter-spacing:1px">PREMIUM GAME ENHANCEMENT SUITE</div>
            <div class="xp-track" style="max-width:220px;margin:24px auto 0">
                <div class="xp-fill" id="loadBar" style="width:0"></div>
            </div>
            <div class="dim" id="loadLabel" style="font-size:10px;margin-top:8px;letter-spacing:1px">INITIALIZING...</div>
        </div>

        <div id="authArea" class="hidden">
            <div class="panel" style="text-align:center;margin-bottom:20px">
                <div class="brand" style="font-size:22px">SRT<span>X</span>CHEATS</div>
                <div class="dim" style="font-size:11px;margin-top:4px">🇳🇵 Nepal · Solo-dev build</div>
            </div>

            <div class="panel" id="loginPanel">
                <div class="section-label">Player Login</div>
                <div class="field"><label>Email</label><input type="email" id="loginEmail" placeholder="you@example.com" autocomplete="username"></div>
                <div class="field"><label>Password</label><input type="password" id="loginPass" placeholder="••••••••" autocomplete="current-password"></div>
                <button class="btn btn-primary" id="loginBtn" style="margin-bottom:10px">▸ Enter Store</button>
                <button class="btn btn-secondary" id="googleBtn" style="margin-bottom:12px">Continue with Google</button>
                <div style="display:flex;justify-content:space-between;font-size:11.5px">
                    <a href="#" id="forgotLink">Forgot password?</a>
                    <a href="#" id="showSignup">Create Account →</a>
                </div>
            </div>

            <div class="panel hidden" id="signupPanel">
                <div class="section-label">New Player</div>
                <div class="field"><label>Email</label><input type="email" id="regEmail" placeholder="you@example.com" autocomplete="username"></div>
                <div class="field"><label>Password (min 6 chars)</label><input type="password" id="regPass" placeholder="••••••••" autocomplete="new-password"></div>
                <button class="btn btn-primary" id="signupBtn" style="margin-bottom:12px">▸ Create Account</button>
                <div style="text-align:center;font-size:11.5px">
                    <a href="#" id="showLogin">← Back to Login</a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.logo-ring {
    width: 84px; height: 84px; margin: 0 auto; position: relative;
    display: flex; align-items: center; justify-content: center;
}
.logo-ring-glow {
    position: absolute; inset: 0; border-radius: 50%;
    border: 2px solid transparent;
    background: linear-gradient(var(--bg), var(--bg)) padding-box,
                linear-gradient(120deg, var(--primary), var(--secondary)) border-box;
    animation: spin 3s linear infinite;
    box-shadow: 0 0 30px var(--primary-glow);
}
.logo-icon { font-size: 32px; position: relative; z-index: 1; filter: drop-shadow(0 0 10px var(--gold-glow)); }
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<script type="module">
import {
    auth, onAuthStateChanged, signInWithEmailAndPassword, createUserWithEmailAndPassword,
    signInWithPopup, googleProvider, sendPasswordResetEmail, backendFetch, toast, setButtonLoading,
} from '/assets/js/app.js';

// ---- Loading sequence ----
const steps = [
    { pct: 30, label: 'LOADING ASSETS...' },
    { pct: 60, label: 'CONNECTING TO SERVER...' },
    { pct: 90, label: 'VERIFYING SESSION...' },
    { pct: 100, label: 'READY' },
];
let i = 0;
const bar = document.getElementById('loadBar');
const label = document.getElementById('loadLabel');
const stepTimer = setInterval(() => {
    if (i >= steps.length) { clearInterval(stepTimer); return; }
    bar.style.width = steps[i].pct + '%';
    label.textContent = steps[i].label;
    i++;
}, 280);

onAuthStateChanged(auth, (user) => {
    if (user) {
        window.location.href = '/store.php';
        return;
    }
    setTimeout(() => {
        document.getElementById('loadScreen').classList.add('hidden');
        document.getElementById('authArea').classList.remove('hidden');
    }, 1300);
});

document.getElementById('showSignup').onclick = (e) => {
    e.preventDefault();
    document.getElementById('loginPanel').classList.add('hidden');
    document.getElementById('signupPanel').classList.remove('hidden');
};
document.getElementById('showLogin').onclick = (e) => {
    e.preventDefault();
    document.getElementById('signupPanel').classList.add('hidden');
    document.getElementById('loginPanel').classList.remove('hidden');
};

document.getElementById('loginBtn').onclick = async () => {
    const email = document.getElementById('loginEmail').value.trim();
    const pass = document.getElementById('loginPass').value;
    if (!email || !pass) return toast('Fill both fields', 'error');
    const btn = document.getElementById('loginBtn');
    setButtonLoading(btn, true);
    try {
        await signInWithEmailAndPassword(auth, email, pass);
        window.location.href = '/store.php';
    } catch (e) {
        toast(e.message, 'error');
        setButtonLoading(btn, false);
    }
};

document.getElementById('signupBtn').onclick = async () => {
    const email = document.getElementById('regEmail').value.trim();
    const pass = document.getElementById('regPass').value;
    if (!email || !pass) return toast('Fill both fields', 'error');
    if (pass.length < 6) return toast('Password must be at least 6 characters', 'error');
    const btn = document.getElementById('signupBtn');
    setButtonLoading(btn, true);
    try {
        await createUserWithEmailAndPassword(auth, email, pass);
        await backendFetch('/api/user/init', { method: 'POST' });
        window.location.href = '/store.php';
    } catch (e) {
        toast(e.message, 'error');
        setButtonLoading(btn, false);
    }
};

document.getElementById('googleBtn').onclick = async () => {
    try {
        await signInWithPopup(auth, googleProvider);
        await backendFetch('/api/user/init', { method: 'POST' });
        window.location.href = '/store.php';
    } catch (e) {
        if (e.code !== 'auth/popup-closed-by-user') toast(e.message, 'error');
    }
};

document.getElementById('forgotLink').onclick = async (e) => {
    e.preventDefault();
    const email = document.getElementById('loginEmail').value.trim();
    if (!email) return toast('Enter your email above first', 'error');
    try {
        await sendPasswordResetEmail(auth, email);
        toast('Password reset email sent', 'success');
    } catch (e) {
        toast(e.message, 'error');
    }
};
</script>

</body>
</html>
