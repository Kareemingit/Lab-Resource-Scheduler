<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LabUs — Profile</title>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ─── VARIABLES & RESET ─── */
:root {
  --bg: #f4f5f7;
  --surface: #ffffff;
  --border: #e2e5eb;
  --border2: #c8cdd8;
  --accent: #1a56db;
  --accent-soft: #eef2fd;
  --green: #0e9f6e;
  --green-soft: #ecfdf5;
  --red: #c81e1e;
  --red-soft: #fef2f2;
  --amber: #b45309;
  --amber-soft: #fffbeb;
  --text: #111928;
  --text2: #374151;
  --text3: #6b7280;
  --text4: #9ca3af;
  --radius: 6px;
  --radius-lg: 10px;
  --shadow: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
  --shadow-md: 0 4px 16px rgba(0,0,0,.1);
}
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
body {
  font-family: 'IBM Plex Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  background: var(--bg);
  color: var(--text);
  font-size: 14px;
  line-height: 1.55;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* ─── TOPBAR ─── */
.topbar {
  height: 54px;
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 28px;
  position: sticky;
  top: 0;
  z-index: 100;
  box-shadow: var(--shadow);
}
.logo {
  font-weight: 600; font-size: 18px; color: var(--accent);
  letter-spacing: -.4px; display: flex; align-items: center; gap: 8px; text-decoration: none;
}
.logo-mark {
  width: 26px; height: 26px; background: var(--accent); border-radius: 6px;
  display: flex; align-items: center; justify-content: center;
}
.logo-mark svg { width: 14px; height: 14px; }
.topbar-nav { display: flex; gap: 2px; }
.nav-link {
  text-decoration: none; padding: 7px 14px; border-radius: 6px;
  font-size: 13px; font-weight: 500; color: var(--text3); transition: all .15s;
}
.nav-link:hover { background: var(--bg); color: var(--text); }
.nav-link.active { background: var(--accent-soft); color: var(--accent); }
.topbar-right { display: flex; align-items: center; gap: 10px; }
.role-pill { font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
.r-lab { background: var(--red-soft); color: var(--red); }
.avatar {
  width: 32px; height: 32px; border-radius: 50%; background: var(--accent); color: #fff;
  font-size: 12px; font-weight: 600; display: flex; align-items: center;
  justify-content: center; letter-spacing: -.5px; text-decoration: none;
}

/* ─── LAYOUT ─── */
.page-wrap { flex: 1; display: flex; flex-direction: column; }
.main { flex: 1; padding: 28px 32px; max-width: 1120px; width: 100%; }

/* ─── PAGE HEADER ─── */
.page-header { margin-bottom: 22px; }
.page-header h1 { font-size: 22px; font-weight: 600; color: var(--text); letter-spacing: -.3px; }
.page-header p { color: var(--text3); font-size: 13px; margin-top: 3px; }

/* ─── CARDS ─── */
.card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow); }
.card-title { font-size: 15px; font-weight: 600; color: var(--text); margin-bottom: 2px; }
.card-sub { font-size: 12px; color: var(--text3); margin-bottom: 14px; }

/* ─── BUTTONS ─── */
.btn {
  display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px;
  border-radius: var(--radius); font-family: 'IBM Plex Sans', sans-serif;
  font-size: 13px; font-weight: 500; cursor: pointer; border: none;
  transition: all .14s; text-decoration: none; line-height: 1.4;
}
.btn-sm { padding: 5px 10px; font-size: 12px; }
.btn-accent { background: var(--accent); color: #fff; }
.btn-accent:hover { background: #1447b2; }
.btn-ghost { background: transparent; color: var(--text2); border: 1px solid var(--border); }
.btn-ghost:hover { background: var(--bg); border-color: var(--border2); }
.btn-group { display: flex; gap: 6px; flex-wrap: wrap; }

/* ─── FORMS ─── */
.form-group { margin-bottom: 13px; }
.form-group label { display: block; font-size: 12px; font-weight: 600; color: var(--text2); margin-bottom: 5px; }
.form-group input, .form-group select, .form-group textarea {
  width: 100%; background: var(--bg); border: 1.5px solid var(--border); color: var(--text);
  padding: 8px 12px; border-radius: var(--radius); font-family: 'IBM Plex Sans', sans-serif;
  font-size: 13px; outline: none; transition: border-color .15s;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
  border-color: var(--accent); box-shadow: 0 0 0 3px rgba(26,86,219,.07);
}
.form-group input[readonly] { background: var(--border); cursor: not-allowed; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

/* ─── CSS-ONLY MODALS (:target) ─── */
.modal-overlay {
  position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 200;
  display: flex; align-items: center; justify-content: center;
  opacity: 0; visibility: hidden; transition: opacity .18s, visibility .18s;
}
.modal-overlay:target { opacity: 1; visibility: visible; }
.modal {
  background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg);
  padding: 26px; width: 480px; max-width: 92vw; max-height: 90vh; overflow-y: auto;
  box-shadow: 0 20px 60px rgba(0,0,0,.18);
}
.modal-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.modal-title { font-size: 17px; font-weight: 600; color: var(--text); }
.modal-close {
  background: var(--bg); border: 1px solid var(--border); color: var(--text3);
  width: 28px; height: 28px; border-radius: 6px; font-size: 16px;
  display: flex; align-items: center; justify-content: center; text-decoration: none; line-height: 1;
}
.modal-close:hover { background: var(--red-soft); color: var(--red); border-color: var(--red); }

/* ─── PROFILE ─── */
.profile-hero {
  background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg);
  padding: 24px; display: flex; align-items: center; gap: 20px; margin-bottom: 18px; box-shadow: var(--shadow);
}
.profile-av {
  width: 60px; height: 60px; border-radius: 50%; background: var(--accent); color: #fff;
  font-size: 18px; font-weight: 600; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.profile-name { font-size: 18px; font-weight: 600; color: var(--text); }
.profile-meta { font-size: 13px; color: var(--text3); margin-top: 3px; }

/* ─── RESPONSIVE ─── */
@media (max-width: 768px) {
  .form-row { grid-template-columns: 1fr; }
  .main { padding: 16px; }
  .topbar { padding: 0 14px; }
  .profile-hero { flex-direction: column; text-align: center; }
}
</style>
</head>
<body>

<!-- ═══ TOPBAR ═══ -->
<div class="topbar">
  <a class="logo" href="{{ route('lab_manager.equipments', ['id' => $user->user_id]) }}">
    <div class="logo-mark">
      <svg viewBox="0 0 14 14" fill="none">
        <circle cx="7" cy="7" r="5.5" stroke="white" stroke-width="1.6"/>
        <circle cx="7" cy="7" r="2" fill="white"/>
      </svg>
    </div>
    LabUs
  </a>
  <div class="topbar-nav">
    <a class="nav-link" href="{{ route('lab_manager.equipments', ['id' => $user->user_id]) }}">Equipment</a>
    <a class="nav-link active" href="{{ route('lab_manager.profile', ['id' => $user->user_id]) }}">Profile</a>
  </div>
  <div class="topbar-right">
    <div class="role-pill r-lab">Lab Manager</div>
    <a class="avatar" href="{{ route('lab_manager.profile', ['id' => $user->user_id]) }}">{{ substr($user->name, 0, 1) }}</a>
  </div>
</div>

<!-- ═══ PAGE CONTENT ═══ -->
<div class="page-wrap">
  <div class="main" style="max-width:100%">

    <div class="page-header">
      <h1>Profile</h1>
      <p>Manage your account details</p>
    </div>

    <!-- PROFILE HERO -->
    <div class="profile-hero">
      <div class="profile-av">{{ substr($user->name, 0, 1) }}</div>
      <div style="flex:1">
        <div class="profile-name">{{ $user->name }}</div>
        <div class="profile-meta">Lab Manager</div>
      </div>
      <a class="btn btn-ghost" href="#editProfileModal">Edit Profile</a>
    </div>

    <!-- PERSONAL INFORMATION -->
    <div class="card" style="margin-bottom:18px">
      <div class="card-title">Personal Information</div>
      <div class="card-sub">Your account details</div>

      <div class="form-row">
        <div class="form-group"><label>Full Name</label><input value="{{ $user->name }}" readonly/></div>
        <div class="form-group"><label>Username</label><input value="{{ $user->username }}" readonly/></div>
      </div>

      <div style="margin-top:14px">
        <a class="btn btn-accent btn-sm" href="#editProfileModal">Edit Profile</a>
      </div>
    </div>

    <!-- SECURITY -->
    <div class="card">
      <div class="card-title">Security</div>
      <div class="card-sub">Password and authentication</div>

      <div class="form-row">
        <div class="form-group"><label>Password</label><input value="••••••••••" readonly/></div>
      </div>

      <div style="margin-top:14px">
        <a class="btn btn-ghost btn-sm" href="#changePasswordModal">Change Password</a>
      </div>
    </div>

  </div>
</div>

<!-- EDIT PROFILE -->
<div class="modal-overlay" id="editProfileModal">
  <div class="modal">
    <div class="modal-head">
      <div class="modal-title">Edit Profile</div>
      <a class="modal-close" href="#">&times;</a>
    </div>
    <form method="POST" action="{{ route('lab_manager.update_profile', ['id' => $user->user_id]) }}">
      @csrf
      @method('PUT')
      <div class="form-group"><label>Full Name</label><input name="name" value="{{ $user->name }}" required/></div>
      <div class="form-group"><label>Username</label><input name="username" value="{{ $user->username }}" required/></div>
      <div class="btn-group" style="justify-content:flex-end">
        <a class="btn btn-ghost" href="#">Cancel</a>
        <button type="submit" class="btn btn-accent">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- CHANGE PASSWORD -->
<div class="modal-overlay" id="changePasswordModal">
  <div class="modal">
    <div class="modal-head">
      <div class="modal-title">Change Password</div>
      <a class="modal-close" href="#">&times;</a>
    </div>
    <form method="POST" action="{{ route('lab_manager.update_password', ['id' => $user->user_id]) }}">
      @csrf
      @method('PUT')
      <div class="form-group"><label>Current Password</label><input type="password" name="current_password" required/></div>
      <div class="form-group"><label>New Password</label><input type="password" name="new_password" required minlength="8"/></div>
      <div class="form-group"><label>Confirm New Password</label><input type="password" name="new_password_confirmation" required minlength="8"/></div>
      <div class="btn-group" style="justify-content:flex-end">
        <a class="btn btn-ghost" href="#">Cancel</a>
        <button type="submit" class="btn btn-accent">Update Password</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
