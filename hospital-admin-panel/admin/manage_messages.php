<?php
include('php/auth_check.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Messages - Maa Kalawati Hospital</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <style>
    html, body { margin: 0; padding: 0; font-family: 'Poppins', Arial, sans-serif; background: #f8fafc; color: #222; min-height: 100vh; width: 100vw; box-sizing: border-box; overflow-x: hidden; }
    *, *::before, *::after { box-sizing: inherit; }
    :hospit27_admin_raj { --primary: #2563eb; --primary-light: #60a5fa; --accent: #10b981; --bg: #f8fafc; --card-bg: #fff; --navbar-bg: #fff; --navbar-shadow: 0 2px 12px rgba(37,99,235,0.07); --text: #222; --muted: #64748b; --radius: 18px; --shadow: 0 4px 24px rgba(37,99,235,0.10); }
    .navbar { width: 100%; background: var(--navbar-bg); box-shadow: var(--navbar-shadow); display: flex; align-items: center; justify-content: space-between; padding: 0 32px; height: 64px; position: sticky; top: 0; z-index: 100; position: relative; }
    .navbar .logo { display: flex; align-items: center; font-size: 1.5rem; font-weight: 700; color: var(--primary); gap: 10px; white-space: nowrap; }
    .navbar nav { display: flex; gap: 28px; flex-wrap: wrap; align-items: center; transition: max-height 0.3s; }
    .navbar nav a { text-decoration: none; color: var(--muted); font-weight: 600; font-size: 1.08rem; padding: 8px 0; border-bottom: 2px solid transparent; transition: color 0.2s, border-color 0.2s; white-space: nowrap; }
    .navbar nav a.active, .navbar nav a:hover { color: var(--primary); border-bottom: 2px solid var(--primary); }
    .navbar .back-btn { display: flex; align-items: center; background: #e0e7ef; color: var(--primary); border: none; border-radius: 8px; font-weight: 600; padding: 8px 16px; margin-left: 18px; cursor: pointer; text-decoration: none; transition: background 0.2s, color 0.2s; font-size: 1rem; gap: 6px; }
    .navbar .back-btn:hover { background: #dbeafe; color: #1746a2; }
    .navbar .hamburger { display: none; font-size: 2rem; background: none; border: none; color: var(--primary); cursor: pointer; margin-left: 18px; }
    .navbar .profile { display: flex; align-items: center; gap: 12px; cursor: pointer; position: relative; margin-left: 18px; }
    .navbar .profile .avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; font-weight: 700; }
    .navbar .profile .dropdown { display: none; position: absolute; right: 0; top: 52px; background: #fff; box-shadow: 0 4px 24px rgba(37,99,235,0.10); border-radius: 10px; min-width: 140px; z-index: 10; }
    .navbar .profile.open .dropdown { display: block; }
    .navbar .profile .dropdown a { display: block; padding: 12px 18px; color: var(--text); text-decoration: none; font-weight: 500; border-radius: 10px; transition: background 0.2s; }
    .navbar .profile .dropdown a:hover { background: var(--bg); }
    .welcome-banner { width: 100%; max-width: 1200px; margin: 32px auto 0 auto; background: linear-gradient(90deg, var(--primary-light) 0%, var(--primary) 100%); color: #fff; border-radius: var(--radius); box-shadow: var(--shadow); padding: 36px 40px 32px 40px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
    .welcome-banner .text { font-size: 2.1rem; font-weight: 700; line-height: 1.2; }
    .welcome-banner .desc { font-size: 1.1rem; font-weight: 400; margin-top: 10px; color: #e0e7ef; }
    .welcome-banner .banner-img { width: 120px; height: 120px; background: rgba(255,255,255,0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; box-shadow: 0 2px 12px rgba(16,185,129,0.10); }
    .messages-section { width: 100%; max-width: 1200px; margin: 36px auto 0 auto; background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); padding: 32px 24px; }
    .messages-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 18px; }
    .messages-header h2 { margin: 0; font-size: 1.4rem; color: var(--primary); font-weight: 700; }
    .messages-table-wrapper { overflow-x: auto; }
    table.messages-table { width: 100%; border-collapse: collapse; min-width: 700px; background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(16,185,129,0.07); }
    table.messages-table th, table.messages-table td { padding: 12px 10px; border-bottom: 1px solid #f3f4f6; text-align: left; }
    table.messages-table th { background: var(--primary); color: #fff; font-weight: 600; }
    table.messages-table tr:last-child td { border-bottom: none; }
    .delete-btn { background: #ef4444; color: #fff; border: none; border-radius: 6px; padding: 7px 16px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .delete-btn:hover { background: #b91c1c; }
    
    /* Custom Dialog Styles */
    .dialog-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      backdrop-filter: blur(4px);
    }
    .dialog-overlay.show {
      display: flex;
    }
    .dialog-box {
      background: #fff;
      border-radius: var(--radius);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      padding: 32px;
      max-width: 400px;
      width: 90%;
      text-align: center;
      animation: dialogSlideIn 0.3s ease-out;
    }
    @keyframes dialogSlideIn {
      from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
      }
      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }
    .dialog-icon {
      width: 60px;
      height: 60px;
      background: #fef2f2;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      color: #ef4444;
      font-size: 1.8rem;
    }
    .dialog-title {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 12px;
    }
    .dialog-message {
      color: var(--muted);
      font-size: 1rem;
      line-height: 1.5;
      margin-bottom: 24px;
    }
    .dialog-buttons {
      display: flex;
      gap: 12px;
      justify-content: center;
    }
    .dialog-btn {
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      font-size: 0.95rem;
    }
    .dialog-btn.cancel {
      background: #f1f5f9;
      color: var(--muted);
    }
    .dialog-btn.cancel:hover {
      background: #e2e8f0;
    }
    .dialog-btn.confirm {
      background: #ef4444;
      color: #fff;
    }
    .dialog-btn.confirm:hover {
      background: #b91c1c;
    }
    
    @media (max-width: 900px) { .messages-section { padding: 16px 2vw; } .welcome-banner { padding: 24px 12px 18px 12px; } }
    @media (max-width: 600px) { table.messages-table { min-width: 400px; font-size: 0.95rem; } .messages-header { flex-direction: column; align-items: flex-start; gap: 8px; } }
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
  </style>
</head>
<body>
  <header class="navbar">
    <div class="logo"><i class="ri-hospital-line"></i> <span>Maa Kalawati Admin</span></div>
    <button class="hamburger" id="hamburger" aria-label="Open navigation">&#9776;</button>
    <nav id="mainNav">
      <a href="dashboard.php">Dashboard</a>
      <a href="manage_patients.php">Patients</a>
      <a href="user_visits.php">Visits</a>
      <a href="manage_feedback.php">Feedback</a>
      <a href="manage_messages.php" class="active">Messages</a>
      <a href="manage_registered_persons.php">REG_PERSON</a>
    </nav>
    <a href="../../index.html" class="back-btn"><i class="ri-arrow-left-line"></i> Back to Home</a>
    <div class="profile" id="profileMenu">
      <div class="avatar"><i class="ri-user-3-line"></i></div>
      <span>Admin</span>
      <div class="dropdown">
        <a href="#">Profile</a>
        <a href="#">Settings</a>
        <a href="php/logout.php">Logout</a>
      </div>
    </div>
  </header>
  <section class="welcome-banner">
    <div>
      <div class="text">Manage Messages</div>
      <div class="desc">View and manage user messages. You can delete resolved or spam messages.</div>
    </div>
    <div class="banner-img"><i class="ri-mail-line"></i></div>
  </section>
  <section class="messages-section">
    <div class="messages-header">
      <h2>Messages List</h2>
    </div>
    <div class="messages-table-wrapper">
      <table class="messages-table" id="messagesTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
            <th>Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="messagesTbody">
          <!-- Data will be loaded here -->
        </tbody>
      </table>
    </div>
  </section>
  
  <!-- Custom Dialog Box -->
  <div class="dialog-overlay" id="deleteDialog">
    <div class="dialog-box">
      <div class="dialog-icon">
        <i class="ri-delete-bin-line"></i>
      </div>
      <div class="dialog-title">Delete Message</div>
      <div class="dialog-message">Are you sure you want to delete this message?</div>
      <div class="dialog-buttons">
        <button class="dialog-btn cancel" id="cancelDelete">Cancel</button>
        <button class="dialog-btn confirm" id="confirmDelete">Delete</button>
      </div>
    </div>
  </div>
  
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
    // Custom Dialog Functions
    let currentMessageId = null;
    
    function showDeleteDialog(messageId) {
      currentMessageId = messageId;
      document.getElementById('deleteDialog').classList.add('show');
    }
    
    function hideDeleteDialog() {
      document.getElementById('deleteDialog').classList.remove('show');
      currentMessageId = null;
    }
    
    function deleteMessage() {
      if (!currentMessageId) return;
      
      fetch('php/delete_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(currentMessageId)}`
      })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            loadMessages();
            hideDeleteDialog();
          } else {
            alert('Error deleting message: ' + (data.message || 'Unknown error'));
          }
        })
        .catch(() => {
          alert('Failed to delete message.');
        });
    }
    
    // Dialog event listeners
    document.getElementById('cancelDelete').addEventListener('click', hideDeleteDialog);
    document.getElementById('confirmDelete').addEventListener('click', deleteMessage);
    
    // Close dialog when clicking outside
    document.getElementById('deleteDialog').addEventListener('click', function(e) {
      if (e.target === this) {
        hideDeleteDialog();
      }
    });
    
    // Load messages
    function loadMessages() {
      fetch('php/get_messages.php')
        .then(r => r.json())
        .then(data => {
          const tbody = document.getElementById('messagesTbody');
          tbody.innerHTML = '';
          data.forEach(msg => {
            let timestamp = msg.timestamp || '';
            let date = '';
            let time = '';
            if (timestamp && timestamp.includes(' ')) {
              const parts = timestamp.split(' ');
              date = parts[0];
              time = parts[1] || '';
            } else {
              date = timestamp;
            }
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${msg.id}</td>
              <td>${msg.name || 'Anonymous'}</td>
              <td>${msg.email || ''}</td>
              <td>${msg.phone || 'N/A'}</td>
              <td>${msg.subject || ''}</td>
              <td>${msg.message || msg.content || ''}</td>
              <td>${date}</td>
              <td>${time}</td>
              <td><button class="delete-btn">Delete</button></td>
            `;
            tr.querySelector('.delete-btn').onclick = function() {
              showDeleteDialog(msg.id);
            };
            tbody.appendChild(tr);
          });
        })
        .catch(() => {
          document.getElementById('messagesTbody').innerHTML = '<tr><td colspan="9" style="text-align:center;color:#888;">Failed to load messages.</td></tr>';
        });
    }
    loadMessages();
  </script>
</body>
</html>
