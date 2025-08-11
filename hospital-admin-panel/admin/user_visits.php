<?php
include('php/auth_check.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Visits Analytics - Maa Kalawati Hospital</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    html, body { margin: 0; padding: 0; font-family: 'Poppins', Arial, sans-serif; background: #f8fafc; color: #222; min-height: 100vh; width: 100vw; box-sizing: border-box; overflow-x: hidden; }
    *, *::before, *::after { box-sizing: inherit; }
    :root { --primary: #2563eb; --primary-light: #60a5fa; --accent: #10b981; --bg: #f8fafc; --card-bg: #fff; --navbar-bg: #fff; --navbar-shadow: 0 2px 12px rgba(37,99,235,0.07); --text: #222; --muted: #64748b; --radius: 18px; --shadow: 0 4px 24px rgba(37,99,235,0.10); }
    .navbar {
      width: 100%;
      background: var(--navbar-bg);
      box-shadow: var(--navbar-shadow);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 32px;
      height: 64px;
      position: sticky;
      top: 0;
      z-index: 100;
      position: relative;
    }
    .navbar .logo {
      display: flex;
      align-items: center;
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary);
      gap: 10px;
      white-space: nowrap;
    }
    .navbar nav {
      display: flex;
      gap: 28px;
      flex-wrap: wrap;
      align-items: center;
      transition: max-height 0.3s;
    }
    .navbar nav a {
      text-decoration: none;
      color: var(--muted);
      font-weight: 600;
      font-size: 1.08rem;
      padding: 8px 0;
      border-bottom: 2px solid transparent;
      transition: color 0.2s, border-color 0.2s;
      white-space: nowrap;
    }
    .navbar nav a.active,
    .navbar nav a:hover {
      color: var(--primary);
      border-bottom: 2px solid var(--primary);
    }
    .navbar .back-btn {
      display: flex;
      align-items: center;
      background: #e0e7ef;
      color: var(--primary);
      border: none;
      border-radius: 8px;
      font-weight: 600;
      padding: 8px 16px;
      margin-left: 18px;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.2s, color 0.2s;
      font-size: 1rem;
      gap: 6px;
    }
    .navbar .back-btn:hover {
      background: #dbeafe;
      color: #1746a2;
    }
    .navbar .hamburger {
      display: none;
      font-size: 2rem;
      background: none;
      border: none;
      color: var(--primary);
      cursor: pointer;
      margin-left: 18px;
    }
    .navbar .profile {
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      position: relative;
      margin-left: 18px;
    }
    .navbar .profile .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      font-weight: 700;
    }
    .navbar .profile .dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 52px;
      background: #fff;
      box-shadow: 0 4px 24px rgba(37,99,235,0.10);
      border-radius: 10px;
      min-width: 140px;
      z-index: 10;
    }
    .navbar .profile.open .dropdown {
      display: block;
    }
    .navbar .profile .dropdown a {
      display: block;
      padding: 12px 18px;
      color: var(--text);
      text-decoration: none;
      font-weight: 500;
      border-radius: 10px;
      transition: background 0.2s;
    }
    .navbar .profile .dropdown a:hover {
      background: var(--bg);
    }
    .welcome-banner { width: 100%; max-width: 1200px; margin: 32px auto 0 auto; background: linear-gradient(90deg, var(--primary-light) 0%, var(--primary) 100%); color: #fff; border-radius: var(--radius); box-shadow: var(--shadow); padding: 36px 40px 32px 40px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
    .welcome-banner .text { font-size: 2.1rem; font-weight: 700; line-height: 1.2; }
    .welcome-banner .desc { font-size: 1.1rem; font-weight: 400; margin-top: 10px; color: #e0e7ef; }
    .welcome-banner .banner-img { width: 120px; height: 120px; background: rgba(255,255,255,0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; box-shadow: 0 2px 12px rgba(16,185,129,0.10); }
    .analytics-section { width: 100%; max-width: 1200px; margin: 36px auto 0 auto; background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); padding: 32px 24px; }
    .stats-row { display: flex; gap: 32px; flex-wrap: wrap; margin-bottom: 32px; }
    .stat-card { background: #f3f4f6; border-radius: 14px; box-shadow: 0 2px 12px rgba(16,185,129,0.07); padding: 24px 32px; min-width: 220px; flex: 1 1 220px; display: flex; flex-direction: column; align-items: flex-start; gap: 10px; margin-bottom: 0; transition: transform 0.2s ease, box-shadow 0.25s ease, background 0.2s ease; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(37,99,235,0.18); background: #eef2ff; }
    .stat-card .label { color: #888; font-size: 1.02rem; font-weight: 500; }
    .stat-card .value { font-size: 2.1rem; font-weight: 700; color: var(--primary); }
    .stat-card .icon { font-size: 2rem; color: #1976d2; margin-bottom: 8px; }
    .chart-container { background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(16,185,129,0.07); padding: 24px 24px 12px 24px; margin-bottom: 0; width: 100%; max-width: 900px; margin: 0 auto; }
    .chart-type-section {
      margin-top: 24px;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 12px rgba(16,185,129,0.07);
      padding: 24px 18px 18px 18px;
      max-width: 900px;
      margin-left: auto;
      margin-right: auto;
    }
    .chart-type-title {
      font-weight: 600;
      color: #1976d2;
      margin-bottom: 12px;
    }
    .chart-type-buttons {
      display: flex;
      gap: 10px;
      margin-bottom: 18px;
    }
    .chart-type-btn {
      background: #fff;
      color: #2563eb;
      border: 2px solid #2563eb;
      border-radius: 6px;
      padding: 8px 20px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.2s, color 0.2s, border-color 0.2s;
      outline: none;
      font-weight: 600;
      box-shadow: 0 1px 3px rgba(37,99,235,0.08);
    }
    .chart-type-btn.active,
    .chart-type-btn:hover {
      background: #2563eb;
      color: #fff;
      border-color: #1746a2;
      box-shadow: 0 2px 8px rgba(37,99,235,0.15);
    }
    .ip-table-section {
      margin-top: 32px;
      width: 100%;
      max-width: 1200px;
      overflow-x: auto;
    }
    table.ip-table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(16,185,129,0.07);
    }
    table.ip-table th, table.ip-table td {
      padding: 10px 14px;
      border-bottom: 1px solid #f3f4f6;
      text-align: left;
      font-size: 1rem;
    }
    table.ip-table th {
      background: #2563eb;
      color: #fff;
      font-weight: 600;
    }
    table.ip-table tr:last-child td {
      border-bottom: none;
    }
    @media (max-width: 900px) { .analytics-section { padding: 16px 2vw; } .welcome-banner { padding: 24px 12px 18px 12px; } .stats-row { flex-direction: column; gap: 16px; } }
    @media (max-width: 600px) { .chart-container { padding: 12px 2px; } .stat-card, .chart-container { max-width: 100vw; min-width: 0; } .stat-card .label, .stat-card .value { font-size: 1rem; } }
    @media (max-width: 900px) {
      .navbar {
        padding: 0 10px;
        height: 56px;
        flex-wrap: wrap;
      }
      .navbar .logo {
        font-size: 1.1rem;
      }
      .navbar nav {
        position: absolute;
        top: 56px;
        left: 0;
        width: 100vw;
        background: var(--navbar-bg);
        flex-direction: column;
        align-items: flex-start;
        gap: 0;
        max-height: 0;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(37,99,235,0.10);
        z-index: 200;
      }
      .navbar nav.open {
        max-height: 300px;
        padding: 12px 0 12px 0;
        gap: 0;
        overflow: visible;
      }
      .navbar nav a {
        padding: 14px 24px;
        width: 100%;
        border-bottom: none;
        border-left: 4px solid transparent;
        font-size: 1.08rem;
      }
      .navbar nav a.active,
      .navbar nav a:hover {
        background: #f1f5f9;
        border-left: 4px solid var(--primary);
        color: var(--primary);
      }
      .navbar .hamburger {
        display: block;
      }
      .navbar .back-btn {
        margin-left: 0;
        margin-right: 8px;
        font-size: 0.98rem;
        padding: 8px 12px;
        order: 2;
      }
      .navbar .profile {
        margin-left: 0;
        order: 3;
      }
      .navbar {
        flex-wrap: wrap;
      }
    }
    @media (max-width: 600px) {
      .chart-type-section { padding: 8px 2vw 4px 2vw; }
      table.ip-table th, table.ip-table td { padding: 8px 6px; font-size: 0.95rem; }
    }
  </style>
</head>
<body>
  <header class="navbar">
    <div class="logo"><i class="ri-hospital-line"></i> <span>Maa Kalawati Admin</span></div>
    <button class="hamburger" id="hamburger" aria-label="Open navigation">&#9776;</button>
    <nav id="mainNav">
      <a href="dashboard_auth.php">Dashboard</a>
      <a href="manage_patients.php">Patients</a>
      <a href="user_visits.php" class="active">Visits</a>
      <a href="manage_feedback.php">Feedback</a>
      <a href="manage_messages.php">Messages</a>
      <a href="manage_registered_persons.php">REG_PERSON</a>
    </nav>
    <a href="../../index.html" class="back-btn"><i class="ri-arrow-left-line"></i> Back to Home</a>
    <div class="profile" id="profileMenu">
      <div class="avatar"><i class="ri-user-3-line"></i></div>
      <span>Admin</span>
      <div class="dropdown">
        <a href="#">Profile</a>
        <a href="#">Settings</a>
        <a href="#">Logout</a>
      </div>
    </div>
  </header>
  <section class="welcome-banner">
    <div>
      <div class="text">User Visits Analytics</div>
      <div class="desc">Track unique and total user visits, trends, and more. Data updates in real time.</div>
    </div>
    <div class="banner-img"><i class="ri-bar-chart-line"></i></div>
  </section>
  <section class="analytics-section">
    <div class="stats-row">
      <div class="stat-card">
        <div class="icon"><i class="ri-bar-chart-line"></i></div>
        <div class="label">Total Unique Visitors (index.html, Current Month)</div>
        <div class="value" id="total-unique">0</div>
      </div>
      <div class="stat-card">
        <div class="icon"><i class="ri-calendar-line"></i></div>
        <div class="label">Today's Total Visits</div>
        <div class="value" id="daily-total">0</div>
      </div>
      <div class="stat-card">
        <div class="icon"><i class="ri-calendar-event-line"></i></div>
        <div class="label">This Week's Total Visits</div>
        <div class="value" id="weekly-total">0</div>
      </div>
      <div class="stat-card">
        <div class="icon"><i class="ri-calendar-2-line"></i></div>
        <div class="label">This Month's Total Visits</div>
        <div class="value" id="monthly-total">0</div>
      </div>
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:32px;align-items:flex-start;justify-content:space-between;width:100%;max-width:1200px;margin:0 auto 32px auto;">
      <div style="flex:1 1 320px;min-width:260px;max-width:340px;background:#fff;border-radius:14px;box-shadow:0 2px 12px rgba(16,185,129,0.07);padding:24px 18px 18px 18px;">
        <div style="font-weight:600;color:#1976d2;margin-bottom:8px;">Calendar</div>
        <input id="calendar" type="text" style="width:100%;padding:10px;border-radius:6px;border:1px solid #27ec08;" readonly>
        <div class="calendar-side-panel" id="calendarSidePanel" style="margin-top:18px;background:#f3f4f6;border-radius:8px;padding:12px 16px;width:100%;">
          <div><strong>Today:</strong> <span id="calendarToday"></span></div>
          <div id="calendarVisitInfo"></div>
        </div>
      </div>
      <div class="chart-container" style="flex:2 1 500px;min-width:320px;">
        <div class="label" style="font-weight:600;color:#1976d2;margin-bottom:8px;">Total Visits Trend (Last 60 Days)</div>
        <canvas id="trendChart" height="80"></canvas>
      </div>
    </div>
    <div class="chart-type-section" style="margin-top:24px;background:#fff;border-radius:14px;box-shadow:0 2px 12px rgba(16,185,129,0.07);padding:24px 18px 18px 18px;max-width:900px;margin-left:auto;margin-right:auto;">
      <div class="chart-type-title" style="font-weight:600;color:#1976d2;margin-bottom:12px;">Visits Analytics</div>
      <div class="chart-type-buttons" style="display:flex;gap:10px;margin-bottom:18px;">
        <button class="chart-type-btn active" data-type="doughnut">Doughnut (Weekly Unique)</button>
        <button class="chart-type-btn" data-type="bar-monthly">Monthly (Unique)</button>
      </div>
      <div style="width:100%;max-width:900px;margin:0 auto;">
        <canvas id="visitsTypeChart" height="140"></canvas>
      </div>
      <div id="chartNoData" style="text-align:center;color:#888;margin-top:12px;display:none;">No data available for this chart.</div>
      
      <!-- Chart Descriptions -->
      <div id="doughnutDescription" class="chart-description" style="margin-top:16px;padding:12px;background:#f8f9fa;border-radius:8px;border-left:4px solid #1976d2;display:block;">
        <strong>Doughnut Chart:</strong> Weekly unique visits by weekday (Sun-Sat) using last 7 days of unique counts.
      </div>
      <div id="monthlyBarDescription" class="chart-description" style="margin-top:16px;padding:12px;background:#f8f9fa;border-radius:8px;border-left:4px solid #1976d2;display:none;">
        <strong>Monthly Chart:</strong> Unique visits per month for the last 6 months.
      </div>
    </div>
    <div class="ip-table-section" style="margin-top:32px;width:100%;max-width:1200px;">
      <div class="ip-table-title" style="font-size:1.1rem;font-weight:600;color:#1976d2;margin-bottom:12px;">All Unique Visitors</div>
      <table class="ip-table" style="width:100%;border-collapse:collapse;background:#fff;border-radius:10px;box-shadow:0 2px 12px rgba(16,185,129,0.07);">
        <thead>
          <tr><th>IP Address</th><th>First Visit</th></tr>
        </thead>
        <tbody id="ipTableBody"></tbody>
      </table>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    // Navbar hamburger menu logic
    const hamburger = document.getElementById('hamburger');
    const mainNav = document.getElementById('mainNav');
    hamburger.addEventListener('click', function(e) {
      e.stopPropagation();
      mainNav.classList.toggle('open');
    });
    document.addEventListener('click', function(e) {
      if (window.innerWidth <= 900 && mainNav.classList.contains('open') && !mainNav.contains(e.target) && e.target !== hamburger) {
        mainNav.classList.remove('open');
      }
    });
    window.addEventListener('resize', function() {
      if (window.innerWidth > 900) mainNav.classList.remove('open');
    });
    // Profile dropdown logic
    const profileMenu = document.getElementById('profileMenu');
    profileMenu.addEventListener('click', function(e) { e.stopPropagation(); this.classList.toggle('open'); });
    document.addEventListener('click', function() { profileMenu.classList.remove('open'); });
    // Live date/time in Calendar side panel
    function updateCalendarToday() {
      const calendarTodayElement = document.getElementById('calendarToday');
      if (!calendarTodayElement) return;
      const now = new Date();
      let hours = now.getHours();
      let minutes = now.getMinutes();
      let ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12;
      const timeStr = hours + ':' + (minutes<10?'0':'') + minutes + ' ' + ampm;
      calendarTodayElement.textContent = now.toLocaleDateString() + ' ' + timeStr;
    }
    updateCalendarToday();
    setInterval(updateCalendarToday, 1000);

    // Fetch and render analytics
    fetch('../../php/get_user_visits_stats.php')
      .then(r => r.json())
      .then(data => {
        // Cards
        document.getElementById('total-unique').textContent = data.total_unique_current_month_index ?? 0;
        document.getElementById('daily-total').textContent = data.today_unique ?? 0;
        document.getElementById('weekly-total').textContent = data.this_week_unique ?? 0;
        document.getElementById('monthly-total').textContent = data.this_month_unique ?? 0;

        // Trend chart: total visits for last 60 days (fill missing days with 0)
        const allVisits = Array.isArray(data.all_visits) ? data.all_visits : [];
        const countByDay = {};
        allVisits.forEach(r => { countByDay[r.day] = Number(r.count); });
        const todayDate = new Date();
        const days = [];
        for (let i = 59; i >= 0; i--) {
          const d = new Date(todayDate);
          d.setDate(d.getDate() - i);
          const iso = d.toISOString().slice(0,10);
          days.push(iso);
        }
        const trendLabels = days.map(d => new Date(d).toLocaleDateString(undefined, { month: 'short', day: 'numeric' }));
        const trendCounts = days.map(d => countByDay[d] ?? 0);
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        const gradient = ctxTrend.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(25,118,210,0.30)');
        gradient.addColorStop(1, 'rgba(25,118,210,0.04)');
        new Chart(ctxTrend, {
          type: 'line',
          data: { labels: trendLabels, datasets: [{ label: 'Total Visits', data: trendCounts, borderColor: '#1976d2', backgroundColor: gradient, fill: true, tension: 0.35, pointRadius: 2.5, pointHoverRadius: 5, pointBackgroundColor: '#1976d2' }] },
          options: { plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } }, hover: { mode: 'nearest', intersect: false }, scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.06)' } }, x: { grid: { display: false } } } }
        });
        // Doughnut chart: weekly unique visits by weekday using backend daily unique
        const chartTypeBtns = document.querySelectorAll('.chart-type-btn');
        let visitsTypeChart;
        function renderWeeklyDoughnut() {
          if (visitsTypeChart) visitsTypeChart.destroy();
          const weekDays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
          const weekCounts = Array(7).fill(0);
          const today = new Date();
          const weekStart = new Date(today); weekStart.setDate(today.getDate() - today.getDay());
          const weekEnd = today;
          (data.daily ?? []).forEach(row => {
            const d = new Date(row.day);
            if (!isNaN(d) && d >= weekStart && d <= weekEnd) {
              weekCounts[d.getDay()] = Number(row.count);
            }
          });
          const chartData = {
            labels: weekDays,
            datasets: [{
              data: weekCounts,
              backgroundColor: [
                'rgba(96,165,250,0.85)','rgba(37,99,235,0.85)','rgba(16,185,129,0.85)','rgba(245,158,66,0.85)','rgba(239,68,68,0.85)','rgba(99,102,241,0.85)','rgba(251,191,36,0.85)'
              ]
            }]
          };
          document.getElementById('chartNoData').style.display = weekCounts.reduce((a,b)=>a+b,0) === 0 ? 'block' : 'none';
          visitsTypeChart = new Chart(document.getElementById('visitsTypeChart').getContext('2d'), {
            type: 'doughnut',
            data: chartData,
            options: { plugins:{ legend:{ display:true, position:'bottom' } }, responsive:true, maintainAspectRatio:false }
          });
        }
        function renderMonthlyBar() {
          if (visitsTypeChart) visitsTypeChart.destroy();
          // Aggregate daily unique into month buckets for last 6 months
          const monthlyMap = new Map(); // key: YYYY-MM, value: count
          const now = new Date();
          const sixMonthsAgo = new Date(now.getFullYear(), now.getMonth() - 5, 1);
          (data.daily ?? []).forEach(row => {
            const d = new Date(row.day);
            if (isNaN(d)) return;
            if (d < sixMonthsAgo) return;
            const key = `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}`;
            monthlyMap.set(key, (monthlyMap.get(key) ?? 0) + Number(row.count));
          });
          // Ensure all months exist even if zero
          const labels = [];
          const values = [];
          for (let i = 5; i >= 0; i--) {
            const dt = new Date(now.getFullYear(), now.getMonth() - i, 1);
            const key = `${dt.getFullYear()}-${String(dt.getMonth()+1).padStart(2,'0')}`;
            labels.push(dt.toLocaleString(undefined, { month: 'short', year: '2-digit' }));
            values.push(monthlyMap.get(key) ?? 0);
          }
          const ctx = document.getElementById('visitsTypeChart').getContext('2d');
          visitsTypeChart = new Chart(ctx, {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Unique Visits', data: values, backgroundColor: 'rgba(37,99,235,0.55)' }] },
            options: { scales: { y: { beginAtZero: true } }, plugins: { legend: { display: false } }, responsive:true, maintainAspectRatio:false }
          });
          document.getElementById('chartNoData').style.display = values.reduce((a,b)=>a+b,0) === 0 ? 'block' : 'none';
        }
        renderWeeklyDoughnut();
        chartTypeBtns.forEach(btn => {
          btn.addEventListener('click', function() {
            chartTypeBtns.forEach(b=>b.classList.remove('active'));
            btn.classList.add('active');
            const t = btn.getAttribute('data-type');
            if (t === 'bar-monthly') {
              renderMonthlyBar();
            } else {
              renderWeeklyDoughnut();
            }
            document.querySelectorAll('.chart-description').forEach(desc => desc.style.display = 'none');
            if (t === 'bar-monthly') {
              document.getElementById('monthlyBarDescription').style.display = 'block';
            } else {
              document.getElementById('doughnutDescription').style.display = 'block';
            }
          });
        });
        // Calendar logic
        flatpickr('#calendar', {
          defaultDate: new Date(),
          dateFormat: 'Y-m-d',
          onChange: function(selectedDates, dateStr) {
            let selected = dateStr;
            const totalRow = (data.all_visits ?? []).find(row => row.day === selected);
            const uniqueRow = (data.daily ?? []).find(row => row.day === selected);
            const dayCount = totalRow ? Number(totalRow.count) : 0;
            const dayUnique = uniqueRow ? Number(uniqueRow.count) : 0;
            document.getElementById('calendarSidePanel').innerHTML =
              `<div><strong>Selected:</strong> ${selected}</div>`+
              `<div><strong>Total Visits:</strong> ${dayCount}</div>`+
              `<div><strong>Unique Visits:</strong> ${dayUnique}</div>`;
          }
        });
        // Today's stats in side panel by default (after data load)
        // Show today's stats in side panel by default
        const todayStr = new Date().toISOString().slice(0,10);
        const todayTotalRow = (data.all_visits ?? []).find(r => r.day === todayStr);
        const todayUniqueRow = (data.daily ?? []).find(r => r.day === todayStr);
        const todayCount = todayTotalRow ? Number(todayTotalRow.count) : 0;
        const todayUnique = todayUniqueRow ? Number(todayUniqueRow.count) : 0;
        document.getElementById('calendarVisitInfo').innerHTML =
          `<div><strong>Today's Visits:</strong> ${todayCount}</div>`+
          `<div><strong>Today's Unique:</strong> ${todayUnique}</div>`;
        // IP Table
        const ipTableBody = document.getElementById('ipTableBody');
        ipTableBody.innerHTML = '';
        if (Array.isArray(data.ips) && data.ips.length > 0) {
          data.ips.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${row.user_ip}</td><td>${row.first_visit || ''}</td>`;
            ipTableBody.appendChild(tr);
          });
        } else {
          ipTableBody.innerHTML = '<tr><td colspan="2" style="text-align:center;color:#888;">No IP data found.</td></tr>';
        }
      });
  </script>
</body>
</html> 