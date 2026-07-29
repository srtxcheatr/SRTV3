<?php
$pageTitle = 'SRT X CHEATS';
$currentPage = 'home';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<div class="term-window">
    <div id="boot" style="padding-top:30px;text-align:center">
        <div style="margin-bottom:12px">
            <img src="https://i.ibb.co/9HmdjJr1/file-000000008a6481f588e660845aa6efa9.png" alt="Logo" style="width:70px;height:70px;border-radius:16px;box-shadow:0 0 25px rgba(168,85,247,0.5)">
        </div>
        <div style="font-family:var(--font-heading);font-weight:900;font-size:22px;letter-spacing:1px;margin-bottom:4px">
            SRT<span style="color:var(--neon-blue)">X</span>CHEATS
        </div>
        <div class="dim" style="font-size:12px;margin-bottom:18px">Connecting to server gateway...</div>
        <div id="bootLines" style="display:flex;flex-direction:column;gap:4px;min-height:90px;font-size:12px;font-family:var(--font-mono);color:var(--neon-blue)"></div>
        <div style="margin-top:14px;height:4px;background:rgba(255,255,255,0.08);border-radius:99px;overflow:hidden">
            <div id="bootBar" style="height:100%;width:0;background:linear-gradient(90deg,var(--neon-blue),var(--neon-purple));transition:width .3s ease"></div>
        </div>
    </div>

    <div id="authArea" class="hidden">
        <div class="panel">
            <div class="prompt-header"><i class="fas fa-right-to-bracket"></i> ACCOUNT LOGIN</div>
            <div id="loginForm">
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
