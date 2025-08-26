<?php
include('php/auth_check.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Patients - Maa Kalawati Hospital</title>
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
    .patients-section { width: 100%; max-width: 1200px; margin: 36px auto 0 auto; background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); padding: 32px 24px; }
    .patients-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 18px; }
    .patients-header h2 { margin: 0; font-size: 1.4rem; color: var(--primary); font-weight: 700; }
    .add-patient-btn { background: var(--primary); color: #fff; border: none; border-radius: 8px; padding: 10px 20px; font-weight: 600; cursor: pointer; transition: background 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    .add-patient-btn:hover { background: #1d4ed8; }
    .patients-table-wrapper { overflow-x: auto; }
    table.patients-table { width: 100%; border-collapse: collapse; min-width: 800px; background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(16,185,129,0.07); }
    table.patients-table th, table.patients-table td { padding: 12px 10px; border-bottom: 1px solid #f3f4f6; text-align: left; }
    table.patients-table th { background: var(--primary); color: #fff; font-weight: 600; }
    table.patients-table tr:last-child td { border-bottom: none; }
    .action-buttons { display: flex; gap: 8px; }
    .edit-btn { background: #3b82f6; color: #fff; border: none; border-radius: 6px; padding: 6px 12px; font-weight: 600; cursor: pointer; transition: background 0.2s; font-size: 0.9rem; }
    .edit-btn:hover { background: #2563eb; }
    .delete-btn { background: #ef4444; color: #fff; border: none; border-radius: 6px; padding: 6px 12px; font-weight: 600; cursor: pointer; transition: background 0.2s; font-size: 0.9rem; }
    .delete-btn:hover { background: #b91c1c; }

    
    /* Modal Styles */
    .modal { 
      display: none; 
      position: fixed; 
      z-index: 1000; 
      left: 0; 
      top: 0; 
      width: 100%; 
      height: 100%; 
      background-color: rgba(0,0,0,0.5);
      overflow-y: auto;
      padding: 20px;
    }
    .modal-content { 
      background-color: #fff; 
      margin: 20px auto; 
      padding: 24px; 
      border-radius: 12px; 
      width: 100%; 
      max-width: 600px; 
      position: relative;
      max-height: calc(100vh - 40px);
      overflow-y: auto;
    }
    .close { 
      color: #aaa; 
      float: right; 
      font-size: 28px; 
      font-weight: bold; 
      cursor: pointer;
      position: sticky;
      top: 0;
      background: #fff;
      padding: 5px;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
    }
    .close:hover { color: #000; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--text); }
    .form-group input, .form-group select, .form-group textarea { 
      width: 100%; 
      padding: 12px; 
      border: 2px solid #e2e8f0; 
      border-radius: 8px; 
      font-size: 1rem; 
      transition: border-color 0.2s;
      box-sizing: border-box;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--primary); }
    .form-group textarea { resize: vertical; min-height: 100px; }
    .modal-buttons { 
      display: flex; 
      gap: 12px; 
      justify-content: flex-end; 
      margin-top: 24px;
      flex-wrap: wrap;
    }
    .btn { 
      padding: 10px 20px; 
      border: none; 
      border-radius: 8px; 
      font-weight: 600; 
      cursor: pointer; 
      transition: all 0.2s;
      min-width: 100px;
    }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #1d4ed8; }
    .btn-secondary { background: #6b7280; color: #fff; }
    .btn-secondary:hover { background: #4b5563; }
    
    /* Custom Alert Styles */
    .custom-alert {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 16px 20px;
      border-radius: 8px;
      color: #fff;
      font-weight: 600;
      z-index: 10000;
      max-width: 400px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      transform: translateX(100%);
      transition: transform 0.3s ease;
    }
    .custom-alert.show {
      transform: translateX(0);
    }
    .custom-alert.success {
      background: #10b981;
      border-left: 4px solid #059669;
    }
    .custom-alert.error {
      background: #ef4444;
      border-left: 4px solid #dc2626;
    }
    .custom-alert.warning {
      background: #f59e0b;
      border-left: 4px solid #d97706;
    }
    .custom-alert.info {
      background: #3b82f6;
      border-left: 4px solid #2563eb;
    }
    .custom-alert .close-alert {
      float: right;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
      margin-left: 10px;
    }
    .custom-alert .close-alert:hover {
      opacity: 0.7;
    }
    
    /* Responsive Modal */
    @media (max-width: 768px) {
      .modal {
        padding: 10px;
      }
      .modal-content {
        margin: 10px auto;
        padding: 20px;
        max-height: calc(100vh - 20px);
      }
      .modal-buttons {
        flex-direction: column;
        gap: 8px;
      }
      .btn {
        width: 100%;
        padding: 12px 20px;
      }
    }
    
    @media (max-width: 480px) {
      .modal-content {
        padding: 16px;
      }
      .form-group input, .form-group select, .form-group textarea {
        padding: 10px;
        font-size: 16px; /* Prevents zoom on iOS */
      }
    }
    
    @media (max-width: 900px) { .patients-section { padding: 16px 2vw; } .welcome-banner { padding: 24px 12px 18px 12px; } }
    @media (max-width: 600px) { table.patients-table { min-width: 600px; font-size: 0.95rem; } .patients-header { flex-direction: column; align-items: flex-start; gap: 8px; } }
    @media (max-width: 900px) { .navbar { padding: 0 10px; height: 56px; flex-wrap: wrap; } .navbar .logo { font-size: 1.1rem; } .navbar nav { position: absolute; top: 56px; left: 0; width: 100vw; background: var(--navbar-bg); flex-direction: column; align-items: flex-start; gap: 0; max-height: 0; overflow: hidden; box-shadow: 0 4px 24px rgba(37,99,235,0.10); z-index: 200; } .navbar nav.open { max-height: 300px; padding: 12px 0 12px 0; gap: 0; overflow: visible; } .navbar nav a { padding: 14px 24px; width: 100%; border-bottom: none; border-left: 4px solid transparent; font-size: 1.08rem; } .navbar nav a.active, .navbar nav a:hover { background: #f1f5f9; border-left: 4px solid var(--primary); color: var(--primary); } .navbar .hamburger { display: block; } .navbar .back-btn { margin-left: 0; margin-right: 8px; font-size: 0.98rem; padding: 8px 12px; order: 2; } .navbar .profile { margin-left: 0; order: 3; } .navbar { flex-wrap: wrap; } }
  </style>
</head>
<body>
  <header class="navbar">
    <div class="logo"><i class="ri-hospital-line"></i> <span>Maa Kalawati Admin</span></div>
    <button class="hamburger" id="hamburger" aria-label="Open navigation">&#9776;</button>
    <nav id="mainNav">
      <a href="dashboard.php">Dashboard</a>
      <a href="manage_patients.php" class="active">Patients</a>
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
        <a href="php/logout.php">Logout</a>
      </div>
    </div>
  </header>
  <section class="welcome-banner">
    <div>
      <div class="text">Manage Patients</div>
      <div class="desc">View and manage all patient records. You can add, edit, or delete patient information.</div>
    </div>
    <div class="banner-img"><i class="ri-user-line"></i></div>
  </section>
  <section class="patients-section">
    <div class="patients-header">
      <h2>Patients List</h2>
      <button class="add-patient-btn" onclick="openAddModal()">
        <i class="ri-add-line"></i> Add Patient
      </button>
    </div>
    <div class="patients-table-wrapper">
      <table class="patients-table" id="patientsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Medical History</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="patientsTbody">
          <!-- Data will be loaded here -->
        </tbody>
      </table>
    </div>
  </section>

  <!-- Custom Alert Container -->
  <div id="customAlertContainer"></div>

  <!-- Add/Edit Patient Modal -->
  <div id="patientModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2 id="modalTitle">Add New Patient</h2>
      <form id="patientForm">
        <input type="hidden" id="patientId" name="patient_id">
        
        <div class="form-group">
          <label for="name">Name *</label>
          <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
          <label for="age">Age *</label>
          <input type="number" id="age" name="age" min="1" max="150" required>
        </div>
        
        <div class="form-group">
          <label for="gender">Gender *</label>
          <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="contact">Contact Number *</label>
          <input type="text" id="contact" name="contact" required>
        </div>
        
        <div class="form-group">
          <label for="address">Address *</label>
          <textarea id="address" name="address" required></textarea>
        </div>
        
        <div class="form-group">
          <label for="medicalHistory">Medical History</label>
          <textarea id="medicalHistory" name="medical_history" placeholder="Enter medical history (optional)"></textarea>
        </div>
        
        <div class="modal-buttons">
          <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Patient</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Custom Alert Function
    function showCustomAlert(message, type = 'info') {
      const container = document.getElementById('customAlertContainer');
      const alertDiv = document.createElement('div');
      alertDiv.className = `custom-alert ${type}`;
      alertDiv.innerHTML = `
        <span>${message}</span>
        <span class="close-alert" onclick="this.parentElement.remove()">&times;</span>
      `;
      
      container.appendChild(alertDiv);
      
      // Show the alert
      setTimeout(() => {
        alertDiv.classList.add('show');
      }, 100);
      
      // Auto remove after 5 seconds
      setTimeout(() => {
        if (alertDiv.parentElement) {
          alertDiv.classList.remove('show');
          setTimeout(() => {
            if (alertDiv.parentElement) {
              alertDiv.remove();
            }
          }, 300);
        }
      }, 5000);
    }
    
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
    
    // Modal functions
    function openAddModal() {
      document.getElementById('modalTitle').textContent = 'Add New Patient';
      document.getElementById('patientForm').reset();
      document.getElementById('patientId').value = '';
      document.getElementById('patientModal').style.display = 'block';
    }
    
    function openEditModal(patientData) {
      document.getElementById('modalTitle').textContent = 'Edit Patient';
      document.getElementById('patientId').value = patientData.id;
      document.getElementById('name').value = patientData.name || '';
      document.getElementById('age').value = patientData.age || '';
      document.getElementById('gender').value = patientData.gender || '';
      document.getElementById('contact').value = patientData.contact || '';
      document.getElementById('address').value = patientData.address || '';
      document.getElementById('medicalHistory').value = patientData.medical_history || '';
      document.getElementById('patientModal').style.display = 'block';
    }
    
    function closeModal() {
      document.getElementById('patientModal').style.display = 'none';
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
      const modal = document.getElementById('patientModal');
      if (event.target === modal) {
        closeModal();
      }
    }
    
    // Form submission
    document.getElementById('patientForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const patientId = formData.get('patient_id');
      const isEdit = patientId !== '';
      
      const url = isEdit ? 'php/update_patient.php' : 'php/add_patient.php';
      
      fetch(url, {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          closeModal();
          loadPatients();
          showCustomAlert(isEdit ? 'Patient updated successfully!' : 'Patient added successfully!', 'success');
        } else {
          showCustomAlert('Error: ' + (data.message || 'Unknown error'), 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showCustomAlert('An error occurred. Please try again.', 'error');
      });
    });
    
    // Load patients
    function loadPatients() {
      fetch('php/get_patients.php')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          const tbody = document.getElementById('patientsTbody');
          tbody.innerHTML = '';
          
          if (Array.isArray(data) && data.length > 0) {
            data.forEach(patient => {
              const tr = document.createElement('tr');
              tr.innerHTML = `
                <td>${patient.id}</td>
                <td>${patient.name || 'N/A'}</td>
                <td>${patient.age || 'N/A'}</td>
                <td>${patient.gender || 'N/A'}</td>
                <td>${patient.contact || 'N/A'}</td>
                <td>${patient.address || 'N/A'}</td>
                <td>${patient.medical_history || 'N/A'}</td>
                <td>
                  <div class="action-buttons">
                    <button class="edit-btn" onclick="openEditModal(${JSON.stringify(patient).replace(/"/g, '&quot;')})">Edit</button>
                    <button class="delete-btn" onclick="deletePatient(${patient.id})">Delete</button>
                  </div>
                </td>
              `;
              tbody.appendChild(tr);
            });
          } else {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: #888;">No patients found</td></tr>';
          }
        })
        .catch(error => {
          console.error('Error loading patients:', error);
          document.getElementById('patientsTbody').innerHTML = '<tr><td colspan="8" style="text-align: center; color: #888;">Error loading patients</td></tr>';
          showCustomAlert('Error loading patients. Please refresh the page.', 'error');
        });
    }
    
    // Delete patient
    function deletePatient(patientId) {
      if (confirm('Are you sure you want to delete this patient?')) {
        fetch('php/delete_patient.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `patient_id=${patientId}`
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            loadPatients();
            showCustomAlert('Patient deleted successfully!', 'success');
          } else {
            showCustomAlert('Error: ' + (data.message || 'Unknown error'), 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showCustomAlert('An error occurred. Please try again.', 'error');
        });
      }
    }
    

    
    // Load patients on page load
    loadPatients();
  </script>
</body>
</html>
