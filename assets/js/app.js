// assets/js/app.js — shared across every page.
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js';
import {
    getAuth, onAuthStateChanged, signOut,
    signInWithEmailAndPassword, createUserWithEmailAndPassword,
    GoogleAuthProvider, signInWithPopup, sendPasswordResetEmail,
    EmailAuthProvider, reauthenticateWithCredential, updatePassword,
} from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js';

export const app = initializeApp(window.FIREBASE_CONFIG);
export const auth = getAuth(app);
export const googleProvider = new GoogleAuthProvider();

export {
    onAuthStateChanged, signOut, signInWithEmailAndPassword, createUserWithEmailAndPassword,
    signInWithPopup, sendPasswordResetEmail, EmailAuthProvider, reauthenticateWithCredential, updatePassword,
};

export async function getAuthToken() {
    const user = auth.currentUser;
    if (!user) throw new Error('Not logged in. Please refresh.');
    return await user.getIdToken(true);
}

export async function backendFetch(path, options = {}) {
    const token = await getAuthToken();
    const r = await fetch(`${window.BACKEND_URL}${path}`, {
        ...options,
        headers: {
            Authorization: `Bearer ${token}`,
            ...(options.body ? { 'Content-Type': 'application/json' } : {}),
            ...(options.headers || {}),
        },
    });

    // Handle Cloudflare / HTML Challenge intercept safely
    const contentType = r.headers.get('content-type') || '';
    if (!contentType.includes('application/json')) {
        throw new Error('Security check or invalid server response. Please try refreshing.');
    }

    const d = await r.json();
    if (!d.success) throw new Error(d.error || 'Request failed');
    return d;
}

/**
 * Every page except home.php calls this on load. Redirects to
 * /home.php if not signed in, and calls back with the user once
 * Firebase confirms the session.
 */
export function requireAuth(onReady) {
    const unsubscribe = onAuthStateChanged(auth, async (user) => {
        if (!user) {
            unsubscribe(); // Detach listener before redirecting to avoid infinite loop
            if (window.location.pathname !== '/home.php') {
                window.location.href = '/home.php';
            }
            return;
        }
        
        try {
            await onReady(user);
        } catch (err) {
            console.error('Error in page init:', err);
            toast(err.message || 'Failed to load page data', 'error');
        }
    });
}

export function toast(msg, kind) {
    let el = document.getElementById('__toast');
    if (!el) {
        el = document.createElement('div');
        el.id = '__toast';
        el.className = 'toast';
        document.body.appendChild(el);
    }
    el.textContent = msg;
    el.className = 'toast show' + (kind ? ' ' + kind : '');
    clearTimeout(el._timer);
    el._timer = setTimeout(() => el.classList.remove('show'), 3200);
}

export async function doLogout() {
    try {
        // Clear local caches first so listeners don't re-trigger background fetches
        localStorage.clear();
        sessionStorage.clear();
        await signOut(auth);
    } catch (e) {
        console.error('Logout error:', e);
    } finally {
        window.location.href = '/home.php';
    }
}
window.doLogout = doLogout;

export function fmtDate(iso) {
    if (!iso) return '';
    try { return new Date(iso).toLocaleString(); } catch (e) { return iso; }
}

export function esc(s) {
    const d = document.createElement('div');
    d.textContent = s ?? '';
    return d.innerHTML;
}

// ---- Hacker-style button loading state ----
const SCRAMBLE_CHARS = '!<>-_\\/[]{}—=+*^?#________';

export function setButtonLoading(btn, loading) {
    if (loading) {
        if (btn.dataset.origText === undefined) btn.dataset.origText = btn.textContent;
        btn.disabled = true;
        const original = btn.dataset.origText;
        let frame = 0;
        btn._scrambleTimer = setInterval(() => {
            frame++;
            const revealCount = Math.floor((frame / 14) * original.length);
            let out = '';
            for (let i = 0; i < original.length; i++) {
                if (original[i] === ' ') { out += ' '; continue; }
                out += i < revealCount
                    ? original[i]
                    : SCRAMBLE_CHARS[Math.floor(Math.random() * SCRAMBLE_CHARS.length)];
            }
            btn.textContent = out;
            if (revealCount >= original.length) frame = 0;
        }, 45);
    } else {
        clearInterval(btn._scrambleTimer);
        btn.disabled = false;
        if (btn.dataset.origText !== undefined) btn.textContent = btn.dataset.origText;
    }
}
