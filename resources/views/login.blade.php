<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LabUs - Login</title>
        <style>
            :root {
            --bg: #f4f5f7;
            --surface: #ffffff;
            --border: #e2e5eb;
            --border2: #c8cdd8;
            --accent: #1a56db;
            --accent-soft: #eef2fd;
            --accent-dim: #3b6fe0;
            --green: #0e9f6e;
            --green-soft: #ecfdf5;
            --red: #c81e1e;
            --red-soft: #fef2f2;
            --amber: #b45309;
            --amber-soft: #fffbeb;
            --purple: #6c2bd9;
            --purple-soft: #f5f3ff;
            --teal: #0694a2;
            --teal-soft: #ecfeff;
            --text: #111928;
            --text2: #374151;
            --text3: #6b7280;
            --text4: #9ca3af;
            --radius: 6px;
            --radius-lg: 10px;
            --shadow: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 16px rgba(0,0,0,.1);
            }
            * { margin:0; padding:0; box-sizing:border-box; }
            body { font-family:'IBM Plex Sans',sans-serif; background:var(--bg); color:var(--text); font-size:14px; line-height:1.55; min-height:100vh; }
            code, .mono { font-family:'IBM Plex Mono',monospace; }

            /* ─── TOPBAR ─── */
            .topbar {
            height:54px; background:var(--surface); border-bottom:1px solid var(--border);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 28px; position:sticky; top:0; z-index:100; box-shadow:var(--shadow);
            }
            .logo { font-weight:600; font-size:18px; color:var(--accent); letter-spacing:-.4px; display:flex; align-items:center; gap:8px; }
            .logo-mark { width:26px; height:26px; background:var(--accent); border-radius:6px; display:flex; align-items:center; justify-content:center; }
            .logo-mark svg { width:14px; height:14px; }
            .topbar-nav { display:flex; gap:2px; }
            .nav-btn { background:none; border:none; padding:7px 14px; border-radius:6px; font-family:'IBM Plex Sans',sans-serif; font-size:13px; font-weight:500; color:var(--text3); cursor:pointer; transition:all .15s; }
            .nav-btn:hover { background:var(--bg); color:var(--text); }
            .nav-btn.active { background:var(--accent-soft); color:var(--accent); }
            .topbar-right { display:flex; align-items:center; gap:10px; }
            .role-pill { font-size:11px; font-weight:600; padding:3px 9px; border-radius:20px; }
            .r-researcher { background:var(--accent-soft); color:var(--accent); }
            .r-pi { background:var(--purple-soft); color:var(--purple); }
            .r-admin { background:var(--amber-soft); color:var(--amber); }
            .r-lab { background:var(--red-soft); color:var(--red); }
            .r-supervisor { background:var(--green-soft); color:var(--green); }
            .r-financial { background:var(--teal-soft); color:var(--teal); }
            .avatar { width:32px; height:32px; border-radius:50%; background:var(--accent); color:#fff; font-size:12px; font-weight:600; display:flex; align-items:center; justify-content:center; cursor:pointer; letter-spacing:-.5px; }
            .auth-wrap { flex:1; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#eef2fd 0%,#f4f5f7 60%,#f5f3ff 100%); min-height:100vh; }
            .auth-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:36px; width:420px; box-shadow:var(--shadow-md); }
            .auth-logo { font-weight:600; font-size:20px; color:var(--accent); margin-bottom:4px; display:flex; align-items:center; gap:9px; }
            .auth-logo-mark { width:28px; height:28px; background:var(--accent); border-radius:7px; display:flex; align-items:center; justify-content:center; }
            .auth-sub { color:var(--text3); font-size:13px; margin-bottom:26px; }
            .field { margin-bottom:13px; }
            .field label { display:block; font-size:12px; font-weight:600; color:var(--text2); margin-bottom:5px; }
            .field input, .field select { width:100%; background:var(--bg); border:1.5px solid var(--border); color:var(--text); padding:9px 12px; border-radius:var(--radius); font-family:'IBM Plex Sans',sans-serif; font-size:13px; outline:none; transition:border-color .15s; }
            .field input:focus, .field select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(26,86,219,.08); }
            .btn-primary { width:100%; padding:11px; border-radius:var(--radius); background:var(--accent); border:none; color:#fff; font-family:'IBM Plex Sans',sans-serif; font-weight:600; font-size:14px; cursor:pointer; transition:background .15s; }
            .btn-primary:hover { background:#1447b2; }
            .auth-switch { text-align:center; margin-top:16px; font-size:13px; color:var(--text3); }
            .auth-switch a { color:var(--accent); cursor:pointer; font-weight:600; }
            </style>
    </head>
    <body>
        <div class="page active" id="page-login">
        <div class="auth-wrap">
            <div class="auth-card">
            <div class="auth-logo">
                <div class="auth-logo-mark">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="white" stroke-width="1.6"/><circle cx="7" cy="7" r="2" fill="white"/></svg>
                </div>LabUs</div>
            <div class="auth-sub">Research Equipment Management — University Portal</div>
            <div class="field"><label>username</label><input id="loginName" placeholder="Jane Doe"/></div>
            <div class="field"><label>Password</label><input type="password" id="loginPw" placeholder="••••••••"/></div>
            <button class="btn-primary" onclick="doLogin()">Sign In</button>
            <div class="auth-switch">New here? <a href="{{ route('register.view') }}">Request access</a></div>
            </div>
        </div>
        </div>
    </body>
</html>