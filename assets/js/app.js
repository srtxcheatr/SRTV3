// assets/js/app.js — shared across every page. Firebase Auth still
// runs client-side (that's normal and fine — it's how Firebase Auth
// works everywhere), but it NEVER touches Firestore directly anymore.
// Every read/write goes through your Node backend at window.BACKEND_URL.

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

export async function backendFetch(endpoint, options = {}) {
    const url = `${window.BACKEND_URL || ''}${endpoint}`;
    
    // Add default headers
    options.headers = {
        'Content-Type': 'application/json',
        ...(options.headers || {})
    };

    const res = await fetch(url, options);

    // Check if response is HTML instead of JSON (e.g. 404/500 error page)
    const contentType = res.headers.get('content-type');
    if (!contentType || !contentType.includes('application/json')) {
        const text = await res.text();
        throw new Error(`Server returned non-JSON response (${res.status}). Check server logs or API endpoint URL.`);
    }

    const data = await res.json();
    if (!res.ok) {
        throw new Error(data.error || data.message || `Request failed with status ${res.status}`);
    }

    return data;
}


/**
 * Every page except home.php calls this on load. Redirects to
 * /home.php if not signed in, and calls back with the uid once
 * Firebase confirms the session — this is a full page each time
 * (traditional multi-page nav), so there's no shared in-memory state
 * between pages; each page re-checks auth on its own.
 */
export function requireAuth(onReady) {
    onAuthStateChanged(auth, (user) => {
        if (!user) {
            window.location.href = '/home.php';
            return;
        }
        onReady(user);
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
    await signOut(auth);
    window.location.href = '/home.php';
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
// Scrambles the button's own text into random characters that
// gradually "resolve" back to readable text while a request is in
// flight, instead of just going blank/disabled with no feedback —
// exists because users kept thinking the site was frozen when
// Render's free tier had a slow cold start and nothing on screen
// changed after tapping a button.
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
