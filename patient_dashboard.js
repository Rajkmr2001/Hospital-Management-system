// Debug function to check if all required elements exist
function debugElements() {
  const requiredElements = [
    'patientName', 'patientNameInfo', 'patientAgeInfo', 'patientGenderInfo',
    'patientContactInfo', 'patientAddressInfo', 'registrationDateInfo',
    'totalFeedbackInfo', 'totalMessagesInfo', 'lastVisitInfo',
    'feedbackList', 'messagesList', 'profilePicture',
    'editName', 'editAge', 'editGender', 'editAddress',
    'editDialog', 'editForm', 'customDialog', 'dialogConfirm'
  ];
  
  console.log('Checking required elements...');
  requiredElements.forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      console.log(`✅ ${id} - Found`);
    } else {
      console.error(`❌ ${id} - Missing`);
    }
  });
}

// Check if user is logged in
function checkAuth() {
  fetch('check_patient_auth.php')
    .then(response => response.json())
    .then(data => {
      if (!data.logged_in) {
        window.location.href = 'patient_login.html';
      } else {
        const patientNameElement = document.getElementById('patientName');
        if (patientNameElement) {
          patientNameElement.textContent = data.name;
        }
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
  // Show loading state with null checks
  const feedbackList = document.getElementById('feedbackList');
  const messagesList = document.getElementById('messagesList');
  
  if (feedbackList) {
    feedbackList.innerHTML = '<div class="text-center py-8"><div class="loading"></div><p class="text-gray-500 mt-2">Loading feedback...</p></div>';
  }
  if (messagesList) {
    messagesList.innerHTML = '<div class="text-center py-8"><div class="loading"></div><p class="text-gray-500 mt-2">Loading messages...</p></div>';
  }
  
  fetch('get_patient_dashboard_data.php')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.status);
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        displayPatientInfo(data.patient_info);
        displayFeedback(data.feedback);
        displayMessages(data.messages);
        const profilePicture = document.getElementById('profilePicture');
        if (data.profile_picture && profilePicture) {
          profilePicture.src = data.profile_picture;
        }
      } else {
        console.error('Data loading error:', data.message);
        showDialog('Error', data.message || 'Failed to load patient data');
        // Show default values for feedback and messages
        displayFeedback([]);
        displayMessages([]);
      }
    })
    .catch(error => {
      console.error('Error loading patient data:', error);
      showDialog('Error', 'Failed to load patient data. Please try refreshing the page.');
      // Show default values for feedback and messages
      displayFeedback([]);
      displayMessages([]);
    });
}

// Display patient information
function displayPatientInfo(info) {
  const elements = {
    'patientNameInfo': info.name || 'N/A',
    'patientAgeInfo': info.age || 'N/A',
    'patientGenderInfo': info.gender || 'N/A',
    'patientContactInfo': info.contact || 'N/A',
    'patientAddressInfo': info.address || 'N/A',
    'registrationDateInfo': info.register_date || 'N/A',
    'totalFeedbackInfo': info.total_feedback || '0',
    'totalMessagesInfo': info.total_messages || '0',
    'lastVisitInfo': info.last_visit || 'N/A'
  };

  for (const [id, value] of Object.entries(elements)) {
    const element = document.getElementById(id);
    if (element) {
      element.textContent = value;
    } else {
      console.warn(`Element with id '${id}' not found`);
    }
  }
}

// Display feedback
function displayFeedback(feedback) {
  const container = document.getElementById('feedbackList');
  if (!container) {
    console.warn('feedbackList element not found');
    return;
  }
  
  if (!feedback || feedback.length === 0) {
    container.innerHTML = '<p class="text-gray-500 text-center py-8">No feedback available</p>';
    return;
  }

  container.innerHTML = feedback.map(item => `
    <div class="border border-gray-200 rounded-lg p-4">
      <div class="flex justify-between items-start mb-2">
        <span class="font-semibold text-gray-800">${item.feedback.substring(0, 50)}${item.feedback.length > 50 ? '...' : ''}</span>
        <span class="text-sm text-gray-500">${new Date(item.timestamp).toLocaleDateString()}</span>
      </div>
      <p class="text-gray-600 text-sm">${item.feedback}</p>
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
  if (!container) {
    console.warn('messagesList element not found');
    return;
  }
  
  if (!messages || messages.length === 0) {
    container.innerHTML = '<p class="text-gray-500 text-center py-8">No messages available</p>';
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
      const profilePicture = document.getElementById('profilePicture');
      if (profilePicture) {
        profilePicture.src = data.picture_url;
      }
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
  const dialogTitle = document.getElementById('dialogTitle');
  const dialogMessage = document.getElementById('dialogMessage');
  const customDialog = document.getElementById('customDialog');
  
  if (dialogTitle) dialogTitle.textContent = title;
  if (dialogMessage) dialogMessage.textContent = message;
  if (customDialog) customDialog.classList.add('show');
}

// Hide custom dialog
function hideDialog() {
  const customDialog = document.getElementById('customDialog');
  if (customDialog) customDialog.classList.remove('show');
}

// Hide edit dialog
function hideEditDialog() {
  const editDialog = document.getElementById('editDialog');
  const editForm = document.getElementById('editForm');
  
  if (editDialog) editDialog.classList.remove('show');
  if (editForm) editForm.reset();
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
  // Get current data with null checks
  const nameElement = document.getElementById('patientNameInfo');
  const ageElement = document.getElementById('patientAgeInfo');
  const genderElement = document.getElementById('patientGenderInfo');
  const addressElement = document.getElementById('patientAddressInfo');
  
  if (!nameElement || !ageElement || !genderElement || !addressElement) {
    console.error('Required elements not found for edit dialog');
    showDialog('Error', 'Unable to load current data. Please refresh the page.');
    return;
  }

  // Populate form with current data
  const editNameElement = document.getElementById('editName');
  const editAgeElement = document.getElementById('editAge');
  const editGenderElement = document.getElementById('editGender');
  const editAddressElement = document.getElementById('editAddress');
  
  if (editNameElement) editNameElement.value = nameElement.textContent;
  if (editAgeElement) editAgeElement.value = ageElement.textContent === 'N/A' ? '' : ageElement.textContent;
  if (editGenderElement) editGenderElement.value = genderElement.textContent;
  if (editAddressElement) editAddressElement.value = addressElement.textContent === 'N/A' ? '' : addressElement.textContent;
  
  const editDialog = document.getElementById('editDialog');
  if (editDialog) {
    editDialog.classList.add('show');
  } else {
    console.error('Edit dialog element not found');
  }
}



// Update patient information
function updatePatientInfo(formData) {
  // Show loading state
  const submitBtn = document.querySelector('#editForm button[type="submit"]');
  if (!submitBtn) {
    console.error('Submit button not found');
    showDialog('Error', 'Form submission failed. Please refresh the page.');
    return;
  }
  
  const originalText = submitBtn.textContent;
  submitBtn.textContent = 'Updating...';
  submitBtn.disabled = true;
  
  fetch('update_patient_info.php', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok: ' + response.status);
    }
    return response.json();
  })
  .then(data => {
    console.log('Update response:', data); // Debug log
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
    showDialog('Error', 'Failed to update information. Please try again.');
  })
  .finally(() => {
    // Reset button state
    submitBtn.textContent = originalText;
    submitBtn.disabled = false;
  });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
  // Check if required elements exist before adding event listeners
  const dialogConfirm = document.getElementById('dialogConfirm');
  const customDialog = document.getElementById('customDialog');
  const editDialog = document.getElementById('editDialog');
  const editForm = document.getElementById('editForm');
  
  if (dialogConfirm) {
    dialogConfirm.addEventListener('click', hideDialog);
  }
  
  if (customDialog) {
    customDialog.addEventListener('click', function(e) {
      if (e.target === this) {
        hideDialog();
      }
    });
  }
  
  if (editDialog) {
    editDialog.addEventListener('click', function(e) {
      if (e.target === this) {
        hideEditDialog();
      }
    });
  }
  
  if (editForm) {
    editForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      updatePatientInfo(formData);
    });
  }
  
  // Initialize after a short delay to ensure DOM is ready
  setTimeout(() => {
    debugElements(); // Debug elements first
    checkAuth();
  }, 100);
}); 