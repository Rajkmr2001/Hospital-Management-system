<?php
include('php/auth_check.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Registered Persons - Maa Kalawati Hospital</title>
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
    .persons-section { width: 100%; max-width: 1200px; margin: 36px auto 0 auto; background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); padding: 32px 24px; }
    .persons-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 18px; }
    .persons-header h2 { margin: 0; font-size: 1.4rem; color: var(--primary); font-weight: 700; }
    .persons-table-wrapper { overflow-x: auto; }
    table.persons-table { width: 100%; border-collapse: collapse; min-width: 800px; background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(16,185,129,0.07); }
    table.persons-table th, table.persons-table td { padding: 12px 10px; border-bottom: 1px solid #f3f4f6; text-align: left; }
    table.persons-table th { background: var(--primary); color: #fff; font-weight: 600; }
    table.persons-table tr:last-child td { border-bottom: none; }
    .action-buttons { display: flex; gap: 8px; }
    .edit-btn { background: #3b82f6; color: #fff; border: none; border-radius: 6px; padding: 6px 12px; font-weight: 600; cursor: pointer; transition: background 0.2s; font-size: 0.9rem; }
    .edit-btn:hover { background: #2563eb; }
    .delete-btn { background: #ef4444; color: #fff; border: none; border-radius: 6px; padding: 6px 12px; font-weight: 600; cursor: pointer; transition: background 0.2s; font-size: 0.9rem; }
    .delete-btn:hover { background: #b91c1c; }
    .password-field { font-family: monospace; background: #f8fafc; padding: 4px 8px; border-radius: 4px; border: 1px solid #e2e8f0; }
    
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
      max-width: 500px;
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
    
    /* Edit Dialog Styles */
    .edit-dialog-box {
      max-width: 600px;
      text-align: left;
    }
    .edit-dialog-box .dialog-title {
      text-align: center;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: var(--text);
    }
    .form-group input, .form-group select {
      width: 100%;
      padding: 12px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.2s;
    }
    .form-group input:focus, .form-group select:focus {
      outline: none;
      border-color: var(--primary);
    }
    .edit-dialog-box .dialog-buttons {
      justify-content: flex-end;
    }
    .edit-dialog-box .dialog-btn.confirm {
      background: var(--primary);
    }
    .edit-dialog-box .dialog-btn.confirm:hover {
      background: #1d4ed8;
    }
    
    @media (max-width: 900px) { .persons-section { padding: 16px 2vw; } .welcome-banner { padding: 24px 12px 18px 12px; } }
    @media (max-width: 600px) { table.persons-table { min-width: 600px; font-size: 0.95rem; } .persons-header { flex-direction: column; align-items: flex-start; gap: 8px; } }
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
      <a href="manage_messages.php">Messages</a>
      <a href="manage_registered_persons.php" class="active">REG_PERSON</a>
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
      <div class="text">Manage Registered Persons</div>
      <div class="desc">View and manage all registered persons. You can edit or delete records as needed.</div>
    </div>
    <div class="banner-img"><i class="ri-user-settings-line"></i></div>
  </section>
  <section class="persons-section">
    <div class="persons-header">
      <h2>Registered Persons List</h2>
    </div>
    <div class="persons-table-wrapper">
      <table class="persons-table" id="personsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile No</th>
            <th>Gender</th>
            <th>Password</th>
            <th>Register Date</th>
            <th>Register Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="personsTbody">
          <!-- Data will be loaded here -->
        </tbody>
      </table>
    </div>
  </section>
  
  <!-- Delete Dialog Box -->
  <div class="dialog-overlay" id="deleteDialog">
    <div class="dialog-box">
      <div class="dialog-icon">
        <i class="ri-delete-bin-line"></i>
      </div>
      <div class="dialog-title">Delete Registered Person</div>
      <div class="dialog-message">Are you sure you want to delete this registered person?</div>
      <div class="dialog-buttons">
        <button class="dialog-btn cancel" id="cancelDelete">Cancel</button>
        <button class="dialog-btn confirm" id="confirmDelete">Delete</button>
      </div>
    </div>
  </div>
  
  <!-- Edit Dialog Box -->
  <div class="dialog-overlay" id="editDialog">
    <div class="dialog-box edit-dialog-box">
      <div class="dialog-title">Edit Registered Person</div>
      <form id="editForm">
        <div class="form-group">
          <label for="editName">Name</label>
          <input type="text" id="editName" name="name" required>
        </div>
        <div class="form-group">
          <label for="editMobile">Mobile No</label>
          <input type="text" id="editMobile" name="mobile_no" required>
        </div>
        <div class="form-group">
          <label for="editGender">Gender</label>
          <select id="editGender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="form-group">
          <label for="editPassword">Password (leave empty to keep current)</label>
          <input type="text" id="editPassword" name="password" placeholder="Enter new password or leave empty">
        </div>
        <div class="dialog-buttons">
          <button type="button" class="dialog-btn cancel" id="cancelEdit">Cancel</button>
          <button type="submit" class="dialog-btn confirm">Update</button>
        </div>
      </form>
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
    let currentPersonId = null;
    let currentPersonData = null;
    
    function showDeleteDialog(personId) {
      currentPersonId = personId;
      document.getElementById('deleteDialog').classList.add('show');
    }
    
    function hideDeleteDialog() {
      document.getElementById('deleteDialog').classList.remove('show');
      currentPersonId = null;
    }
    
    function showEditDialog(personData) {
      currentPersonData = personData;
      document.getElementById('editName').value = personData.name || '';
      document.getElementById('editMobile').value = personData.mobile_no || '';
      document.getElementById('editGender').value = personData.gender || 'Male';
      document.getElementById('editPassword').value = ''; // Clear password field for security
      document.getElementById('editDialog').classList.add('show');
    }
    
    function hideEditDialog() {
      document.getElementById('editDialog').classList.remove('show');
      currentPersonData = null;
    }
    
    function deletePerson() {
      if (!currentPersonId) return;
      
      fetch('php/delete_registered_person.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(currentPersonId)}`
      })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            loadPersons();
            hideDeleteDialog();
          } else {
            alert('Error deleting person: ' + (data.message || 'Unknown error'));
          }
        })
        .catch(() => {
          alert('Failed to delete person.');
        });
    }
    
    function updatePerson(formData) {
      if (!currentPersonData) return;
      
      fetch('php/update_registered_person.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData
      })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            loadPersons();
            hideEditDialog();
          } else {
            alert('Error updating person: ' + (data.message || 'Unknown error'));
          }
        })
        .catch(() => {
          alert('Failed to update person.');
        });
    }
    
    // Dialog event listeners
    document.getElementById('cancelDelete').addEventListener('click', hideDeleteDialog);
    document.getElementById('confirmDelete').addEventListener('click', deletePerson);
    document.getElementById('cancelEdit').addEventListener('click', hideEditDialog);
    
    // Close dialogs when clicking outside
    document.getElementById('deleteDialog').addEventListener('click', function(e) {
      if (e.target === this) {
        hideDeleteDialog();
      }
    });
    document.getElementById('editDialog').addEventListener('click', function(e) {
      if (e.target === this) {
        hideEditDialog();
      }
    });
    
    // Edit form submission
    document.getElementById('editForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      formData.append('id', currentPersonData.id);
      
      const urlEncodedData = new URLSearchParams(formData).toString();
      updatePerson(urlEncodedData);
    });
    
    // Load persons
    function loadPersons() {
      console.log('Loading persons...');
      fetch('php/get_registered_persons.php')
        .then(r => {
          console.log('Response status:', r.status);
          return r.json();
        })
        .then(data => {
          console.log('Received data:', data);
          const tbody = document.getElementById('personsTbody');
          tbody.innerHTML = '';
          
          if (data.error) {
            tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;color:#ef4444;">Error: ${data.error}</td></tr>`;
            return;
          }
          
          if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;color:#888;">No registered persons found.</td></tr>';
            return;
          }
          
          data.forEach(person => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${person.id}</td>
              <td>${person.name || 'N/A'}</td>
              <td>${person.mobile_no || 'N/A'}</td>
              <td>${person.gender || 'N/A'}</td>
              <td><span class="password-field">${person.password || 'N/A'}</span></td>
              <td>${person.register_date || 'N/A'}</td>
              <td>${person.register_time || 'N/A'}</td>
              <td>
                <div class="action-buttons">
                  <button class="edit-btn" onclick="showEditDialog(${JSON.stringify(person).replace(/"/g, '&quot;')})">Edit</button>
                  <button class="delete-btn" onclick="showDeleteDialog(${person.id})">Delete</button>
                </div>
              </td>
            `;
            tbody.appendChild(tr);
          });
        })
        .catch(error => {
          console.error('Error loading persons:', error);
          document.getElementById('personsTbody').innerHTML = '<tr><td colspan="8" style="text-align:center;color:#888;">Failed to load registered persons.</td></tr>';
        });
    }
    
    loadPersons();
  </script>
</body>
</html>
