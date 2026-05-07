<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LabUs — Equipment</title>
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

/* ─── GRIDS ─── */
.grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }

/* ─── BADGES ─── */
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
.bg { background: var(--green-soft); color: var(--green); }
.bb { background: var(--accent-soft); color: var(--accent); }
.br { background: var(--red-soft); color: var(--red); }

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
.btn-red { background: var(--red); color: #fff; }
.btn-red:hover { background: #9b1c1c; }
.btn-amber { background: var(--amber); color: #fff; }
.btn-amber:hover { background: #92400e; }
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

/* ─── EQUIP CARDS ─── */
.equip-card {
  background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg);
  overflow: hidden; transition: all .18s; box-shadow: var(--shadow);
}
.equip-card:hover { border-color: var(--accent); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,86,219,.12); }
.equip-card-head {
  padding: 14px 16px; border-bottom: 1px solid var(--border); background: var(--bg);
  display: flex; justify-content: space-between; align-items: flex-start;
}
.equip-card-icon { font-size: 22px; margin-bottom: 6px; }
.equip-name { font-size: 14px; font-weight: 600; color: var(--text); }
.equip-id { font-size: 11px; color: var(--text4); font-family: 'IBM Plex Mono', monospace; margin-top: 1px; }
.equip-body { padding: 12px 16px; }
.equip-row { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 6px; }
.equip-row .k { color: var(--text3); }
.equip-row .v { color: var(--text2); font-weight: 500; }
.equip-foot { padding: 10px 16px; border-top: 1px solid var(--border); display: flex; gap: 6px; background: var(--bg); flex-wrap: wrap; }

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

/* ─── SEARCH / FILTER ─── */
.search-row { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; flex-wrap: wrap; }
.search-input-wrap {
  display: flex; align-items: center; gap: 7px; background: var(--surface);
  border: 1.5px solid var(--border); border-radius: var(--radius); padding: 0 11px;
  flex: 1; max-width: 300px; transition: border-color .15s;
}
.search-input-wrap:focus-within { border-color: var(--accent); }
.search-input-wrap svg { color: var(--text4); flex-shrink: 0; }
.search-input-wrap input {
  background: none; border: none; outline: none; font-family: 'IBM Plex Sans', sans-serif;
  font-size: 13px; color: var(--text); padding: 8px 0; width: 100%;
}
.filter-btn {
  background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius);
  padding: 7px 12px; font-size: 12px; font-weight: 500; color: var(--text3);
  cursor: pointer; transition: all .12s; font-family: 'IBM Plex Sans', sans-serif; text-decoration: none;
}
.filter-btn:hover, .filter-btn.active { background: var(--accent-soft); color: var(--accent); border-color: var(--accent); }

/* ─── RESPONSIVE ─── */
@media (max-width: 768px) {
  .grid-3 { grid-template-columns: 1fr; }
  .form-row { grid-template-columns: 1fr; }
  .main { padding: 16px; }
  .topbar { padding: 0 14px; }
}
</style>
</head>
<body>

<!-- ═══ TOPBAR ═══ -->
<div class="topbar">
  <a class="logo" href="{{ route('lab_manager.equipments', ['id' => $lab_manager_id]) }}">
    <div class="logo-mark">
      <svg viewBox="0 0 14 14" fill="none">
        <circle cx="7" cy="7" r="5.5" stroke="white" stroke-width="1.6"/>
        <circle cx="7" cy="7" r="2" fill="white"/>
      </svg>
    </div>
    LabUs
  </a>
  <div class="topbar-nav">
    <a class="nav-link active" href="{{ route('lab_manager.equipments', ['id' => $lab_manager_id]) }}">Equipment</a>
    <a class="nav-link" href="{{ route('lab_manager.profile', ['id' => $lab_manager_id]) }}">Profile</a>
  </div>
  <div class="topbar-right">
    <div class="role-pill r-lab">Lab Manager</div>
    <a class="avatar" href="{{ route('lab_manager.profile', ['id' => $lab_manager_id]) }}">T</a>
  </div>
</div>

<!-- ═══ PAGE CONTENT ═══ -->
<div class="page-wrap">
  <div class="main" style="max-width:100%">

    <div class="page-header">
      <h1>Research Equipment</h1>
      <p>Browse, manage, and maintain lab equipment</p>
    </div>

    <!-- SEARCH / FILTER BAR -->
    <div class="search-row">
      <div class="search-input-wrap">
        <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
          <circle cx="6.5" cy="6.5" r="5" stroke="currentColor" stroke-width="1.5"/>
          <path d="M10.5 10.5L14 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        <input name="search" placeholder="Search equipment…" value=""/>
      </div>
      <a class="filter-btn active" href="#">All</a>
      <div style="margin-left:auto">
        <a class="btn btn-accent btn-sm" href="#addEquipModal">+ Add Equipment</a>
      </div>
    </div>

    <!-- EQUIPMENT GRID (LOOPED) -->
    <div class="grid-3">
      @forelse($equipments as $equipment)
        @php
          // Determine status badge class
          $statusClass = match(strtolower($equipment->status ?? 'available')) {
            'available' => 'bg',
            'in-use', 'in use' => 'bb',
            'maintenance' => 'br',
            default => 'bg',
          };
          $statusLabel = ucfirst($equipment->status ?? 'Available');
          
          // Map category to emoji
          $emojiMap = [
            'microscopy' => '🔬',
            'sequencing' => '🧬',
            'computing' => '💻',
            'spectroscopy' => '⚗️',
          ];
          $icon = $emojiMap[strtolower($equipment->category ?? '')] ?? '🔧';
        @endphp
        
        <div class="equip-card">
          <div class="equip-card-head">
            <div>
              <div class="equip-card-icon">{{ $icon }}</div>
              <div class="equip-name">{{ $equipment->name }}</div>
              <div class="equip-id">EQ-{{ str_pad($equipment->eq_id, 3, '0', STR_PAD_LEFT) }}</div>
            </div>
            <span class="badge {{ $statusClass }}"><span class="badge-dot"></span>{{ $statusLabel }}</span>
          </div>
          <div class="equip-body">
            <div class="equip-row"><span class="k">Category</span><span class="v">{{ $equipment->category ?? 'N/A' }}</span></div>
            <div class="equip-row"><span class="k">Rate</span><span class="v">${{ $equipment->price ?? '0' }}/session</span></div>
            <div class="equip-row"><span class="k">Max Hours</span><span class="v">{{ $equipment->max_hours ?? 'N/A' }} hrs</span></div>
            <div class="equip-row"><span class="k">Certification</span><span class="v">{{ $equipment->required_role ?? 'None' }}</span></div>
          </div>
          <div class="equip-foot">
            <a class="btn btn-sm btn-ghost" href="#updateEquipModal-{{ $equipment->eq_id }}">Update</a>
            <form method="POST" action="{{ route('equipment.destroy', $equipment->eq_id) }}" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-red">Remove</button>
            </form>
            <a class="btn btn-sm btn-amber" href="#reportAccidentModal-{{ $equipment->eq_id }}">Report</a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text3);">
          <p>No equipment found</p>
        </div>
      @endforelse
    </div><!-- /grid-3 -->

  </div>
</div>

<!-- ADD EQUIPMENT -->
<div class="modal-overlay" id="addEquipModal">
  <div class="modal">
    <div class="modal-head">
      <div class="modal-title">Add Equipment</div>
      <a class="modal-close" href="#">&times;</a>
    </div>
    <form method="POST" action="{{ route('equipment.store', $lab_manager_id) }}">
      @csrf
      <div class="form-row">
        <div class="form-group"><label>Equipment Name</label><input name="name" placeholder="e.g. Confocal C" required/></div>
        <div class="form-group"><label>Category</label><select name="category" required><option value="">Select Category</option><option value="Microscopy">Microscopy</option><option value="Sequencing">Sequencing</option><option value="Computing">Computing</option><option value="Spectroscopy">Spectroscopy</option></select></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label>Rate</label><input name="price" type="number" step="0.01" placeholder="$420" /></div>
      </div>
      <div class="form-group">
        <label class="checkbox-label">
          <input type="checkbox" name="needs_supervision" value="1" />
          Requires Supervision
        </label>
      </div>
      <div class="form-group"><label>Secondary Equipment ID</label><input name="sec_eq_id"/></div>
      <div class="form-group"><label>Required Role</label><input name="required_role" placeholder="PHD" /></div>
      <div class="form-group"><label>Required Certification</label><input name="certification_name" placeholder="e.g. BSL-2, Radiation Safety" /></div>
      <div class="form-group"><label>Initial State</label><select name="status" required><option value="available">Available</option><option value="offline">Offline</option><option value="maintenance">Maintenance</option></select></div>
      <div class="btn-group" style="justify-content:flex-end;margin-top:6px">
        <a class="btn btn-ghost" href="#">Cancel</a>
        <button type="submit" class="btn btn-accent">Add Equipment</button>
      </div>
    </form>
  </div>
</div>

<!-- UPDATE EQUIPMENT MODALS (LOOPED) -->
@foreach($equipments as $equipment)
  <div class="modal-overlay" id="updateEquipModal-{{ $equipment->eq_id }}">
    <div class="modal">
      <div class="modal-head">
        <div class="modal-title">Update: {{ $equipment->name }}</div>
        <a class="modal-close" href="#">&times;</a>
      </div>
      <form method="POST" action="{{ route('equipment.update', $equipment->eq_id) }}">
        @csrf
        @method('PUT')
        <div class="form-group"><label>Equipment Name</label><input name="name" value="{{ $equipment->name }}" readonly/></div>
        <div class="form-group">
          <label>Change State</label>
          <select name="status" required>
            <option value="available" @if(strtolower($equipment->status ?? 'available') === 'available') selected @endif>Available</option>
            <option value="in-use" @if(strtolower($equipment->status ?? '') === 'in-use') selected @endif>In Use</option>
            <option value="maintenance" @if(strtolower($equipment->status ?? '') === 'maintenance') selected @endif>Maintenance</option>
            <option value="locked-out" @if(strtolower($equipment->status ?? '') === 'locked-out') selected @endif>Locked Out</option>
            <option value="offline" @if(strtolower($equipment->status ?? '') === 'offline') selected @endif>Offline</option>
          </select>
        </div>
        <div class="form-group"><label>Rate (leave blank to keep current)</label><input name="price" type="number" step="0.01" placeholder="${{ $equipment->price ?? '0' }}/session"/></div>
        <div class="form-group"><label>Max Hours</label><input name="max_hours" type="number" step="0.01" value="{{ $equipment->max_hours ?? '' }}"/></div>
        <div class="btn-group" style="justify-content:flex-end;margin-top:6px">
          <a class="btn btn-ghost" href="#">Cancel</a>
          <button type="submit" class="btn btn-accent">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
@endforeach

<!-- REPORT ACCIDENT MODALS (LOOPED) -->
@foreach($equipments as $equipment)
  <div class="modal-overlay" id="reportAccidentModal-{{ $equipment->eq_id }}">
    <div class="modal">
      <div class="modal-head">
        <div class="modal-title">Report — {{ $equipment->name }}</div>
        <a class="modal-close" href="#">&times;</a>
      </div>
      <form method="POST" action="{{ route('equipment.report', $equipment->eq_id) }}">
        @csrf
        <div class="form-group"><label>Equipment</label><input value="{{ $equipment->name }}" readonly/></div>
        <div class="form-group"><label>Researcher ID Involved</label><input name="researcher_id" type="text" placeholder="Enter researcher ID" required/></div>
        <div class="form-group"><label>Description</label><textarea name="description" rows="4" placeholder="Describe the issue…" required></textarea></div>
        <div class="btn-group" style="justify-content:flex-end;margin-top:6px">
          <a class="btn btn-ghost" href="#">Cancel</a>
          <button type="submit" class="btn btn-red">Submit Report</button>
        </div>
      </form>
    </div>
  </div>
@endforeach

</body>
</html>
