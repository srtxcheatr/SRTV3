<?php
// includes/config.php — the only place these values live. Every page
// includes this, so changing your backend URL means editing ONE file.


define('DEVELOPER_URL', 'https://srtxcheatr.github.io/srtxcheats/');

define('BACKEND_URL', 'https://reprov1.onrender.com'); // ← your Node backend URL


define('BANNERS', [
    ['image' => 'https://your-banner-1-image-direct-link.example.com/banner1.jpg', 'link' => 'https://your-banner-1-target-link.example.com'],
    ['image' => 'https://your-banner-2-image-direct-link.example.com/banner2.jpg', 'link' => 'https://your-banner-2-target-link.example.com'],
]);

// Cloudflare Turnstile — bot-protection widget shown on signup.
// Get this from the Cloudflare dashboard: Turnstile → Add Site →
// copy the "Site Key" (public, safe to put here). The matching
// Secret Key goes in Render as TURNSTILE_SECRET_KEY, NOT here.
define('TURNSTILE_SITE_KEY', '0x4AAAAAAD7qtHsXZ5GrNpLY); // ← EDIT




define('FIREBASE_CONFIG_JSON', json_encode([
    'apiKey' => 'AIzaSyC75_Oqo4wc7Jx58wfkkoQML9YxgP24QR4',
    'authDomain' => 'bronzx.firebaseapp.com',
    'projectId' => 'bronzx',
    'storageBucket' => 'bronzx.firebasestorage.app',
    'messagingSenderId' => '155159545642',
    'appId' => '1:155159545642:web:1d615183d1cdee3bdac053',
]));
