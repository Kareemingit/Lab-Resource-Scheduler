<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LabUs — Home</title>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
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
    .page { display:none; }
    .page.active { display:flex; flex-direction:column; min-height:calc(100vh - 54px); }
    .main { flex:1; padding:28px 32px; max-width:1120px; width:100%; }
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
    .page-header { margin-bottom:22px; }
    .page-header h1 { font-size:22px; font-weight:600; color:var(--text); letter-spacing:-.3px; }
    .page-header p { color:var(--text3); font-size:13px; margin-top:3px; }
    .card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:20px; box-shadow:var(--shadow); }
    .card-title { font-size:15px; font-weight:600; color:var(--text); margin-bottom:2px; }
    .card-sub { font-size:12px; color:var(--text3); margin-bottom:14px; }
    .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; }
    .grid-4 { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; }
    .stat-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:16px 20px; box-shadow:var(--shadow); }
    .stat-label { font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px; }
    .stat-value { font-size:26px; font-weight:600; color:var(--text); letter-spacing:-.5px; }
    .stat-note { font-size:12px; color:var(--text3); margin-top:4px; }
    .stat-up { color:var(--green); }
    .stat-down { color:var(--red); }
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:13px; }
    thead th { text-align:left; padding:9px 12px; border-bottom:1px solid var(--border); font-size:11px; color:var(--text3); text-transform:uppercase; letter-spacing:.5px; font-weight:600; background:var(--bg); }
    tbody tr { border-bottom:1px solid var(--border); transition:background .1s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:var(--bg); }
    tbody td { padding:11px 12px; color:var(--text2); vertical-align:middle; }
    td.bold { color:var(--text); font-weight:500; }
    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; }
    .badge-dot { width:5px; height:5px; border-radius:50%; background:currentColor; flex-shrink:0; }
    .bg { background:var(--green-soft); color:var(--green); }
    .bb { background:var(--accent-soft); color:var(--accent); }
    .bp { background:var(--purple-soft); color:var(--purple); }
    .by { background:var(--amber-soft); color:var(--amber); }
    .br { background:var(--red-soft); color:var(--red); }
    .bgr { background:var(--bg); color:var(--text3); }
    .bt { background:var(--teal-soft); color:var(--teal); }
    .btn { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; border-radius:var(--radius); font-family:'IBM Plex Sans',sans-serif; font-size:13px; font-weight:500; cursor:pointer; border:none; transition:all .14s; }
    .btn-sm { padding:5px 10px; font-size:12px; }
    .btn-xs { padding:3px 8px; font-size:11px; }
    .btn-accent { background:var(--accent); color:#fff; }
    .btn-accent:hover { background:#1447b2; }
    .btn-green { background:var(--green); color:#fff; }
    .btn-green:hover { background:#057a55; }
    .btn-red { background:var(--red); color:#fff; }
    .btn-red:hover { background:#9b1c1c; }
    .btn-amber { background:var(--amber); color:#fff; }
    .btn-amber:hover { background:#92400e; }
    .btn-ghost { background:transparent; color:var(--text2); border:1px solid var(--border); }
    .btn-ghost:hover { background:var(--bg); border-color:var(--border2); }
    .btn-group { display:flex; gap:6px; flex-wrap:wrap; }
    .search-row { display:flex; align-items:center; gap:8px; margin-bottom:14px; flex-wrap:wrap; }
    .search-input-wrap { display:flex; align-items:center; gap:7px; background:var(--surface); border:1.5px solid var(--border); border-radius:var(--radius); padding:0 11px; flex:1; max-width:300px; transition:border-color .15s; }
    .search-input-wrap:focus-within { border-color:var(--accent); }
    .search-input-wrap svg { color:var(--text4); flex-shrink:0; }
    .search-input-wrap input { background:none; border:none; outline:none; font-family:'IBM Plex Sans',sans-serif; font-size:13px; color:var(--text); padding:8px 0; width:100%; }
    .filter-btn { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:7px 12px; font-size:12px; font-weight:500; color:var(--text3); cursor:pointer; transition:all .12s; font-family:'IBM Plex Sans',sans-serif; }
    .filter-btn:hover,.filter-btn.active { background:var(--accent-soft); color:var(--accent); border-color:var(--accent); }
    .alert { display:flex; gap:10px; padding:12px 14px; border-radius:var(--radius); margin-bottom:14px; font-size:13px; align-items:flex-start; }
    .alert-info { background:var(--accent-soft); border:1px solid #bfdbfe; color:#1e3a8a; }
    .alert-warn { background:var(--amber-soft); border:1px solid #fde68a; color:#78350f; }
    .alert-danger { background:var(--red-soft); border:1px solid #fecaca; color:#7f1d1d; }
    .alert-success { background:var(--green-soft); border:1px solid #a7f3d0; color:#064e3b; }
    .timeline { display:flex; flex-direction:column; }
    .tl-item { display:flex; gap:12px; padding-bottom:14px; }
    .tl-left { display:flex; flex-direction:column; align-items:center; flex-shrink:0; }
    .tl-dot { width:9px; height:9px; border-radius:50%; border:2px solid var(--accent); background:var(--surface); margin-top:3px; }
    .tl-dot.filled { background:var(--accent); }
    .tl-line { width:1px; background:var(--border); flex:1; margin-top:4px; }
    .tl-item:last-child .tl-line { display:none; }
    .tl-title { font-size:13px; color:var(--text); font-weight:500; }
    .tl-meta { font-size:11px; color:var(--text3); margin-top:2px; }
    .bar-row { display:flex; align-items:center; gap:10px; margin-bottom:8px; }
    .bar-label { font-size:12px; color:var(--text2); font-weight:500; width:130px; flex-shrink:0; }
    .bar-track { flex:1; height:16px; background:var(--bg); border-radius:4px; overflow:hidden; border:1px solid var(--border); }
    .bar-fill { height:100%; border-radius:4px; display:flex; align-items:center; justify-content:flex-end; padding-right:6px; }
    .bar-fill span { font-size:11px; color:#fff; font-weight:600; }
    .equip-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); overflow:hidden; transition:all .18s; box-shadow:var(--shadow); }
    .equip-card:hover { border-color:var(--accent); transform:translateY(-1px); box-shadow:0 6px 20px rgba(26,86,219,.12); }
    .equip-card-head { padding:14px 16px; border-bottom:1px solid var(--border); background:var(--bg); display:flex; justify-content:space-between; align-items:flex-start; }
    .equip-card-icon { font-size:22px; margin-bottom:6px; }
    .equip-name { font-size:14px; font-weight:600; color:var(--text); }
    .equip-id { font-size:11px; color:var(--text4); font-family:'IBM Plex Mono',monospace; margin-top:1px; }
    .equip-body { padding:12px 16px; }
    .equip-row { display:flex; justify-content:space-between; font-size:12px; margin-bottom:6px; }
    .equip-row .k { color:var(--text3); }
    .equip-row .v { color:var(--text2); font-weight:500; }
    .equip-foot { padding:10px 16px; border-top:1px solid var(--border); display:flex; gap:6px; background:var(--bg); flex-wrap:wrap; }
    .overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:200; align-items:center; justify-content:center; }
    .overlay.open { display:flex; }
    .modal { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:26px; width:480px; max-width:92vw; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,.18); animation:modal-pop .16s ease; }
    @keyframes modal-pop { from { opacity:0; transform:translateY(-10px) scale(.98); } to { opacity:1; transform:none; } }
    .modal-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .modal-title { font-size:17px; font-weight:600; color:var(--text); }
    .modal-close { background:var(--bg); border:1px solid var(--border); color:var(--text3); width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; }
    .modal-close:hover { background:var(--red-soft); color:var(--red); border-color:var(--red); }
    .form-group { margin-bottom:13px; }
    .form-group label { display:block; font-size:12px; font-weight:600; color:var(--text2); margin-bottom:5px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; background:var(--bg); border:1.5px solid var(--border); color:var(--text); padding:8px 12px; border-radius:var(--radius); font-family:'IBM Plex Sans',sans-serif; font-size:13px; outline:none; transition:border-color .15s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(26,86,219,.07); }
    .form-group textarea { resize:vertical; min-height:72px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    #toastContainer { position:fixed; top:64px; right:18px; z-index:400; display:flex; flex-direction:column; gap:8px; }
    .toast { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:11px 16px; font-size:13px; font-weight:500; color:var(--text); box-shadow:var(--shadow-md); display:flex; align-items:center; gap:9px; animation:toast-in .22s ease; max-width:300px; }
    @keyframes toast-in { from { opacity:0; transform:translateX(14px); } to { opacity:1; transform:none; } }
    @keyframes spin { from { transform:rotate(0deg); } to { transform:rotate(360deg); } }
    .toast.t-success { border-left:3px solid var(--green); }
    .toast.t-error { border-left:3px solid var(--red); }
    .toast.t-info { border-left:3px solid var(--accent); }
    .toast.t-warn { border-left:3px solid var(--amber); }
    .profile-hero { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:24px; display:flex; align-items:center; gap:20px; margin-bottom:18px; box-shadow:var(--shadow); }
    .profile-av { width:60px; height:60px; border-radius:50%; background:var(--accent); color:#fff; font-size:18px; font-weight:600; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .profile-name { font-size:18px; font-weight:600; color:var(--text); }
    .profile-meta { font-size:13px; color:var(--text3); margin-top:3px; }
    .tabs { display:flex; gap:0; border-bottom:1px solid var(--border); margin-bottom:18px; }
    .tab-btn { padding:9px 16px; font-size:13px; background:none; border:none; color:var(--text3); font-family:'IBM Plex Sans',sans-serif; font-weight:500; cursor:pointer; border-bottom:2px solid transparent; margin-bottom:-1px; transition:all .12s; }
    .tab-btn:hover { color:var(--text); }
    .tab-btn.active { color:var(--accent); border-bottom-color:var(--accent); }
    .tab-panel { display:none; }
    .tab-panel.active { display:block; }

    @media(max-width:768px) {
    .grid-2,.grid-3,.grid-4 { grid-template-columns:1fr; }
    .form-row { grid-template-columns:1fr; }
    .main { padding:16px; }
    }

  </style>
</head>
<body>
    <div class="topbar" id="topbar">
        <div class="logo">
            <div class="logo-mark">
                <svg viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="5.5" stroke="white" stroke-width="1.6"/><circle cx="7" cy="7" r="2" fill="white"/></svg>
            </div>
            LabUs
        </div>
        
        <div class="topbar-nav" id="topNav">
            <a class="nav-btn active" href="{{ route('researcher.home', ['id' => $researcher->user_id]) }}">Home</a>
            <a class="nav-btn" href="{{ route('researcher.equipments', ['id' => $researcher->user_id]) }}">Equipment</a>
            <a class="nav-btn" href="">Reservations</a>
            <a class="nav-btn" href="">Profile</a>
        </div>

        <div class="topbar-right">
            <div class="role-pill r-researcher">RESEARCHER</div>
            <div class="avatar">
                US
            </div>
        </div>
    </div>

    <div class="page active" id="page-home">
        <div class="main" style="max-width:100%">
            <div class="page-header">
                <h1>Dashboard</h1>
                <p>Welcome back, {{ Auth::user()->name ?? 'Researcher' }}.</p>
            </div>

            <div id="dynamicHomeContent">
                {{-- Logic moved from JS to Blade --}}
                @php
                    $activeSessions = 0; // Replace with $user->sessions()->whereNull('endTime')->count()
                @endphp

                <div class="alert alert-info">
                    You have {{ $activeSessions }} active session(s).
                </div>

                <div class="grid-4">
                    <div class="stat-card">
                        <div class="stat-label">Grant Balance</div>
                        <div class="stat-value">${{ $project->balance ?? 0 }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Reservations</div>
                        <div class="stat-value">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Active Certs</div>
                        <div class="stat-value">1</div>
                    </div>
                </div>

                <div class="grid-2" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-title">Today's Sessions</div>
                        <div class="btn-group" style="margin-top: 10px;">
                            {{-- Modals don't work without JS. 
                                 Better to link to a separate 'Create Session' page. --}}
                            <a href="" class="btn btn-accent btn-sm">Start Session</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay" id="startModal">
        <div class="modal">
            <div class="modal-head">
                <div class="modal-title">Start Session</div>
                <button class="modal-close" onclick="closeModal('startModal')">×</button>
            </div>
            <div class="form-group">
                <label>Equipment</label>
                <select id="startEquipSelect"></select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Start Time</label>
                    <input type="time" id="startTime" value="09:00"/>
                </div>
                <div class="form-group">
                    <label>Expected End</label>
                    <input type="time" id="endTime" value="11:30"/>
                </div>
            </div>
            <div class="form-group">
                <label>Grant</label>
                <select id="startGrantSelect">
                    <option>NSF-2024-089</option>
                    <option>NIH-2023-445</option>
                    <option>DOE-2024-001</option>
                </select>
            </div>
            <div class="btn-group" style="justify-content:flex-end;margin-top:6px">
                <button class="btn btn-ghost" onclick="closeModal('startModal')">Cancel</button>
                <button class="btn btn-accent" onclick="startSessionSubmit()">Start Session</button>
            </div>
        </div>
    </div>
</body>
</html>
