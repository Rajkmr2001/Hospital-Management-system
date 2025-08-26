<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Maa Kalawati Hospital</title>
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
    .login-section { width: 100%; max-width: 1200px; margin: 36px auto 0 auto; background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); padding: 32px 24px; }
    .login-form { max-width: 400px; margin: 0 auto; }
    .form-group { margin-bottom: 24px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--text); }
    .form-group input { width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s; }
    .form-group input:focus { outline: none; border-color: var(--primary); }
    .form-group input[type="password"] { padding-right: 45px; }
    .form-group input[type="text"] { padding-right: 45px; }
    .login-btn { width: 100%; background: var(--primary); color: #fff; border: none; border-radius: 8px; padding: 14px 24px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .login-btn:hover { background: #1d4ed8; }
    .error-message { background: #fef2f2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #fecaca; }
    .success-message { background: #f0fdf4; color: #16a34a; padding: 12px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #bbf7d0; }
    @media (max-width: 900px) { .login-section { padding: 16px 2vw; } .welcome-banner { padding: 24px 12px 18px 12px; } }
    @media (max-width: 900px) { .navbar { padding: 0 10px; height: 56px; flex-wrap: wrap; } .navbar .logo { font-size: 1.1rem; } .navbar nav { position: absolute; top: 56px; left: 0; width: 100vw; background: var(--navbar-bg); flex-direction: column; align-items: flex-start; gap: 0; max-height: 0; overflow: hidden; box-shadow: 0 4px 24px rgba(37,99,235,0.10); z-index: 200; } .navbar nav.open { max-height: 300px; padding: 12px 0 12px 0; gap: 0; overflow: visible; } .navbar nav a { padding: 14px 24px; width: 100%; border-bottom: none; border-left: 4px solid transparent; font-size: 1.08rem; } .navbar nav a.active, .navbar nav a:hover { background: #f1f5f9; border-left: 4px solid var(--primary); color: var(--primary); } .navbar .hamburger { display: block; } .navbar .back-btn { margin-left: 0; margin-right: 8px; font-size: 0.98rem; padding: 8px 12px; order: 2; } .navbar .profile { margin-left: 0; order: 3; } .navbar { flex-wrap: wrap; } }
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
      <div class="text">Admin Login</div>
      <div class="desc">Enter your credentials to access the admin panel.</div>
    </div>
    <div class="banner-img"><i class="ri-lock-line"></i></div>
  </section>
  <section class="login-section">
    <div class="login-form">
      <form id="loginForm" method="POST" action="php/login.php">
        <div id="errorMessage" class="error-message" style="display: none;"></div>
        <div id="successMessage" class="success-message" style="display: none;"></div>
        
        <div class="form-group">
          <label for="mobile_number">Mobile Number</label>
          <input type="text" id="mobile_number" name="mobile_number" required>
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <div style="position: relative;">
            <input type="password" id="password" name="password" required>
            <button type="button" id="togglePassword" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748b; font-size: 18px;">
              <i class="ri-eye-line" id="eyeIcon"></i>
            </button>
          </div>
        </div>
        
        <button type="submit" class="login-btn">Login</button>
      </form>
    </div>
  </section>
  
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
    
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      eyeIcon.className = type === 'password' ? 'ri-eye-line' : 'ri-eye-off-line';
    });
    
    // Login form handling
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const mobile_number = formData.get('mobile_number');
      const password = formData.get('password');
      
      fetch('php/login.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `mobile_number=${encodeURIComponent(mobile_number)}&password=${encodeURIComponent(password)}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          document.getElementById('successMessage').textContent = 'Login successful! Redirecting...';
          document.getElementById('successMessage').style.display = 'block';
          document.getElementById('errorMessage').style.display = 'none';
          
          setTimeout(() => {
            window.location.href = 'dashboard.php';
          }, 1000);
        } else {
          document.getElementById('errorMessage').textContent = data.message || 'Login failed';
          document.getElementById('errorMessage').style.display = 'block';
          document.getElementById('successMessage').style.display = 'none';
        }
      })
      .catch(error => {
        document.getElementById('errorMessage').textContent = 'An error occurred. Please try again.';
        document.getElementById('errorMessage').style.display = 'block';
        document.getElementById('successMessage').style.display = 'none';
      });
    });
  </script>
</body>
</html>
