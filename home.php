<?php
$pageTitle = 'ADMIN PANELS';
$currentPage = 'home';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
    <div id="boot" style="padding-top:30px;text-align:center">
        <div style="margin-bottom:12px">
            <img src="https://i.postimg.cc/qqYtBD3k/file-00000000470c8208bd1a0215abff7977.png" alt="Logo" style="width:70px;height:70px;border-radius:16px;box-shadow:0 0 25px rgba(168,85,247,0.5)">
        </div>
        <div style="font-family:var(--font-heading);font-weight:900;font-size:22px;letter-spacing:1px;margin-bottom:4px">
            SRT<span style="color:var(--neon-blue)">X</span>CHEATS
        </div>
        <div class="dim" style="font-size:12px;margin-bottom:18px">Connecting to server gateway...</div>
        <div id="bootLines" style="display:flex;flex-direction:column;gap:4px;min-height:80px;font-size:12px;font-family:var(--font-mono);color:var(--neon-blue)"></div>
        <div style="margin-top:14px;height:4px;background:rgba(255,255,255,0.08);border-radius:99px;overflow:hidden">
            <div id="bootBar" style="height:100%;width:0;background:linear-gradient(90deg,var(--neon-blue),var(--neon-purple));transition:width .3s ease"></div>
        </div>
    </div>

    <div id="authArea" class="hidden">
        <div class="panel">
            <div id="loginForm">
                <div class="prompt-header"><i class="fas fa-right-to-bracket"></i> ACCOUNT LOGIN</div>
                <div class="field">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="loginEmail" placeholder="you@example.com">
                </div>
                <div class="field">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="loginPass" placeholder="••••••••">
                </div>
                <button class="btn btn-solid" id="loginBtn" style="margin-bottom:8px"><i class="fas fa-arrow-right-to-bracket"></i> Login</button>
                <button class="btn btn-ghost" id="googleBtn" style="margin-bottom:12px"><i class="fab fa-google"></i> Continue with Google</button>
                <div style="display:flex;justify-content:space-between;font-size:12px">
                    <a href="#" id="forgotLink"><i class="fas fa-key"></i> Forgot Password?</a>
                    <a href="#" id="openSignup"><i class="fas fa-user-plus"></i> Register Account</a>
                </div>
            </div>

            <div id="regForm" class="hidden">
                <div class="prompt-header"><i class="fas fa-user-plus"></i> REGISTER ACCOUNT</div>
                <div class="field">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="regEmail" placeholder="you@example.com">
                </div>
                <div class="field">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="regPass" placeholder="••••••••">
                </div>
                <button class="btn btn-solid" id="signupBtn" style="margin-bottom:12px"><i class="fas fa-user-check"></i> Create Account</button>
                <div style="text-align:center;font-size:12px">
                    <a href="#" id="openLogin"><i class="fas fa-arrow-left"></i> Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
import {
    auth, onAuthStateChanged, backendFetch, toast, setButtonLoading,
    googleProvider, signInWithPopup, signInWithEmailAndPassword,
    createUserWithEmailAndPassword, sendPasswordResetEmail
} from '/assets/js/app.js';

const bootLines = [
    'booting srtxcheats::gateway...',
    'securing auth channel...',
    'verifying session token...'
];

async function runBoot() {
    const el = document.getElementById('bootLines');
    const bar = document.getElementById('bootBar');
    for (let i = 0; i < bootLines.length; i++) {
        await new Promise(r => setTimeout(r, 220));
        if (el) el.innerHTML += `<div>[ok] ${bootLines[i]}</div>`;
        if (bar) bar.style.width = `${((i + 1) / bootLines.length) * 100}%`;
    }
}

runBoot();

onAuthStateChanged(auth, async (user) => {
    if (user) {
        try {
            await backendFetch('/api/user/init', { method: 'POST' });
        } catch (e) {
            console.error(e);
        }
        window.location.href = '/store.php';
    } else {
        setTimeout(() => {
            document.getElementById('boot')?.classList.add('hidden');
            document.getElementById('authArea')?.classList.remove('hidden');
        }, 800);
    }
});

// Toggle Forms
document.getElementById('openSignup').onclick = (e) => {
    e.preventDefault();
    document.getElementById('loginForm').classList.add('hidden');
    document.getElementById('regForm').classList.remove('hidden');
};
document.getElementById('openLogin').onclick = (e) => {
    e.preventDefault();
    document.getElementById('regForm').classList.add('hidden');
    document.getElementById('loginForm').classList.remove('hidden');
};

// Actions
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
