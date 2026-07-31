<?php
// includes/config.php — the only place these values live. Every page
// includes this, so changing your backend URL means editing ONE file.


define('DEVELOPER_URL', 'https://srtxcheatr.github.io/srtxcheats/');

define('BACKEND_URL', 'https://repromax5.onrender.com'); // ← your Node backend URL

define('BANNERS', [
    ['image' => 'https://i.postimg.cc/0rgvg95j/file-00000000a47882118a513b5f8330bb53.png', 'link' => 'GZOWtlF8OFSeM0E08epGicNHvAh2'],
    ['image' => 'https://i.postimg.cc/RFZ9zPc2/file-000000000e688211a2be320f8de763e4.png', 'link' => 'GZOWtlF8OFSeM0E08epGicNHvAh2'],
]);


define('TURNSTILE_SITE_KEY', '0x4AAAAAAD7qtHsXZ5GrNpLY'); // ← EDIT


define('FIREBASE_CONFIG_JSON', json_encode([
    'apiKey' => 'AIzaSyC75_Oqo4wc7Jx58wfkkoQML9YxgP24QR4',
    'authDomain' => 'bronzx.firebaseapp.com',
    'projectId' => 'bronzx',
    'storageBucket' => 'bronzx.firebasestorage.app',
    'messagingSenderId' => '155159545642',
    'appId' => '1:155159545642:web:1d615183d1cdee3bdac053',
]));