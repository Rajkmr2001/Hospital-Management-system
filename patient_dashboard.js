// Check if user is logged in
function checkAuth() {
  fetch('check_patient_auth.php')
    .then(response => response.json())
    .then(data => {
      if (!data.logged_in) {
        window.location.href = 'patient_login.html';
      } else {
        document.getElementById('patientName').textContent = data.name;
        loadPatientData();
      }
    })
    .catch(error => {
      console.error('Auth check failed:', error);
      window.location.href = 'patient_login.html';
    });
}

// Load patient data
function loadPatientData() {
  fetch('get_patient_dashboard_data.php')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        displayPatientInfo(data.patient_info);
        displayFeedback(data.feedback);
        displayMessages(data.messages);
        if (data.profile_picture) {
          document.getElementById('profilePicture').src = data.profile_picture;
        }
      } else {
        showDialog('Error', data.message || 'Failed to load patient data');
      }
    })
    .catch(error => {
      console.error('Error loading patient data:', error);
      showDialog('Error', 'Failed to load patient data');
    });
}

// Display patient information
function displayPatientInfo(info) {
  document.getElementById('patientNameInfo').textContent = info.name || 'N/A';
  document.getElementById('patientAgeInfo').textContent = info.age || 'N/A';
  document.getElementById('patientGenderInfo').textContent = info.gender || 'N/A';
  document.getElementById('patientContactInfo').textContent = info.contact || 'N/A';
  document.getElementById('patientAddressInfo').textContent = info.address || 'NULL';
  document.getElementById('patientMedicalHistoryInfo').textContent = info.medical_history || 'NULL';
  document.getElementById('registrationDateInfo').textContent = info.register_date || 'N/A';
  document.getElementById('totalFeedbackInfo').textContent = info.total_feedback || '0';
  document.getElementById('totalMessagesInfo').textContent = info.total_messages || '0';
  document.getElementById('lastVisitInfo').textContent = info.last_visit || 'N/A';
}

// Display feedback
function displayFeedback(feedback) {
  const container = document.getElementById('feedbackList');
  if (!feedback || feedback.length === 0) {
    container.innerHTML = '<p class="text-gray-500 text-center py-8">NULL</p>';
    return;
  }

  container.innerHTML = feedback.map(item => `
    <div class="border border-gray-200 rounded-lg p-4">
      <div class="flex justify-between items-start mb-2">
        <span class="font-semibold text-gray-800">${item.comment.substring(0, 50)}${item.comment.length > 50 ? '...' : ''}</span>
        <span class="text-sm text-gray-500">${new Date(item.created_at).toLocaleDateString()}</span>
      </div>
      <p class="text-gray-600 text-sm">${item.comment}</p>
      <div class="flex items-center mt-2 text-sm text-gray-500">
        <i class="ri-thumb-up-line mr-1"></i>
        <span>${item.likes || 0}</span>
        <i class="ri-thumb-down-line ml-3 mr-1"></i>
        <span>${item.dislikes || 0}</span>
      </div>
    </div>
  `).join('');
}

// Display messages
function displayMessages(messages) {
  const container = document.getElementById('messagesList');
  if (!messages || messages.length === 0) {
    container.innerHTML = '<p class="text-gray-500 text-center py-8">NULL</p>';
    return;
  }

  container.innerHTML = messages.map(item => `
    <div class="border border-gray-200 rounded-lg p-4">
      <div class="flex justify-between items-start mb-2">
        <span class="font-semibold text-gray-800">${item.subject}</span>
        <span class="text-sm text-gray-500">${new Date(item.timestamp).toLocaleDateString()}</span>
      </div>
      <p class="text-gray-600 text-sm">${item.message}</p>
      <div class="flex items-center mt-2 text-sm text-gray-500">
        <i class="ri-phone-line mr-1"></i>
        <span>${item.phone || 'N/A'}</span>
      </div>
    </div>
  `).join('');
}

// Upload profile picture
function uploadProfilePicture(input) {
  const file = input.files[0];
  if (!file) return;

  // Validate file type
  const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
  if (!allowedTypes.includes(file.type)) {
    showDialog('Error', 'Please select a valid image file (JPG, JPEG, PNG, GIF)');
    return;
  }

  // Validate file size (5MB)
  if (file.size > 5 * 1024 * 1024) {
    showDialog('Error', 'File size must be less than 5MB');
    return;
  }

  const formData = new FormData();
  formData.append('profile_picture', file);

  fetch('upload_profile_picture.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      document.getElementById('profilePicture').src = data.picture_url;
      showDialog('Success', 'Profile picture updated successfully!');
    } else {
      showDialog('Error', data.message || 'Failed to upload profile picture');
    }
  })
  .catch(error => {
    console.error('Upload error:', error);
    showDialog('Error', 'Failed to upload profile picture');
  });
}

// Show custom dialog
function showDialog(title, message) {
  document.getElementById('dialogTitle').textContent = title;
  document.getElementById('dialogMessage').textContent = message;
  document.getElementById('customDialog').classList.add('show');
}

// Hide custom dialog
function hideDialog() {
  document.getElementById('customDialog').classList.remove('show');
}

// Logout function
function logout() {
  fetch('patient_logout.php')
    .then(() => {
      window.location.href = 'patient_login.html';
    })
    .catch(error => {
      console.error('Logout error:', error);
      window.location.href = 'patient_login.html';
    });
}

// Show edit dialog
function showEditDialog() {
  // Populate form with current data
  document.getElementById('editName').value = document.getElementById('patientNameInfo').textContent;
  document.getElementById('editAge').value = document.getElementById('patientAgeInfo').textContent;
  document.getElementById('editGender').value = document.getElementById('patientGenderInfo').textContent;
  document.getElementById('editAddress').value = document.getElementById('patientAddressInfo').textContent;
  document.getElementById('editMedicalHistory').value = document.getElementById('patientMedicalHistoryInfo').textContent;
  
  document.getElementById('editDialog').classList.add('show');
}

// Hide edit dialog
function hideEditDialog() {
  document.getElementById('editDialog').classList.remove('show');
}

// Update patient information
function updatePatientInfo(formData) {
  fetch('update_patient_info.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showDialog('Success', 'Information updated successfully!');
      hideEditDialog();
      // Reload patient data to show updated information
      loadPatientData();
    } else {
      showDialog('Error', data.message || 'Failed to update information');
    }
  })
  .catch(error => {
    console.error('Update error:', error);
    showDialog('Error', 'Failed to update information');
  });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('dialogConfirm').addEventListener('click', hideDialog);
  document.getElementById('customDialog').addEventListener('click', function(e) {
    if (e.target === this) {
      hideDialog();
    }
  });
  
  // Edit dialog event listeners
  document.getElementById('editDialog').addEventListener('click', function(e) {
    if (e.target === this) {
      hideEditDialog();
    }
  });
  
  // Edit form submission
  document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    updatePatientInfo(formData);
  });
  
  // Initialize
  checkAuth();
}); 