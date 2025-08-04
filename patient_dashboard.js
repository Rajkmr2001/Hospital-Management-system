// Global variables
let currentPatientData = null;

// Define all functions first, before DOMContentLoaded
function showEditModal() {
    console.log('showEditModal called');
    if (!currentPatientData || !currentPatientData.patient_info) {
        showAlert('Error', 'Patient data not available. Please refresh the page.', 'error');
        return;
    }
    
    const patientInfo = currentPatientData.patient_info;
    
    // Populate form fields
    const editName = document.getElementById('editName');
    const editAge = document.getElementById('editAge');
    const editGender = document.getElementById('editGender');
    const editAddress = document.getElementById('editAddress');
    
    if (editName) editName.value = patientInfo.name || '';
    if (editAge) editAge.value = patientInfo.age === 'N/A' ? '' : patientInfo.age;
    if (editGender) editGender.value = patientInfo.gender || 'Male';
    if (editAddress) editAddress.value = patientInfo.address === 'N/A' ? '' : patientInfo.address;
    
    // Show modal
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.classList.add('show');
    }
}

function hideEditModal() {
    console.log('hideEditModal called');
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.classList.remove('show');
    }
    
    // Reset form
    const form = document.getElementById('editForm');
    if (form) {
        form.reset();
    }
}

function hideAlertModal() {
    const alertModal = document.getElementById('alertModal');
    if (alertModal) {
        alertModal.classList.remove('show');
    }
}

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

function uploadProfilePicture(input) {
    const file = input.files[0];
    if (!file) return;
    
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        showAlert('Error', 'Please select a valid image file (JPG, JPEG, PNG, GIF)', 'error');
        return;
    }
    
    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        showAlert('Error', 'File size must be less than 5MB', 'error');
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
            const profilePic = document.getElementById('profilePicture');
            if (profilePic) {
                profilePic.src = data.picture_url;
            }
            showAlert('Success', 'Profile picture updated successfully!', 'success');
        } else {
            showAlert('Error', data.message || 'Failed to upload profile picture', 'error');
        }
    })
    .catch(error => {
        console.error('Upload error:', error);
        showAlert('Error', 'Failed to upload profile picture', 'error');
    });
}

function checkAuthentication() {
    console.log('Checking authentication...');
    
    // Add timestamp to prevent caching
    const url = 'check_patient_auth.php?t=' + Date.now();
    console.log('Auth check URL:', url);
    
    fetch(url)
        .then(response => {
            console.log('Auth response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(text => {
            console.log('Auth raw response:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Auth JSON parse error:', e);
                throw new Error('Invalid JSON response from auth check');
            }
        })
        .then(data => {
            console.log('Auth data:', data);
            if (data.logged_in) {
                console.log('User authenticated:', data.name);
                updateHeaderName(data.name);
                loadPatientData();
            } else {
                console.log('User not authenticated, redirecting to login');
                window.location.href = 'patient_login.html';
            }
        })
        .catch(error => {
            console.error('Authentication check failed:', error);
            showAlert('Error', 'Authentication failed. Please login again.', 'error');
            setTimeout(() => {
                window.location.href = 'patient_login.html';
            }, 2000);
        });
}

function loadPatientData() {
    console.log('Loading patient data...');
    showLoadingStates();
    
    // Add timestamp to prevent caching
    const url = 'get_patient_dashboard_data.php?t=' + Date.now();
    console.log('Fetching from:', url);
    
    fetch(url)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(text => {
            console.log('Raw response:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('JSON parse error:', e);
                throw new Error('Invalid JSON response from server');
            }
        })
        .then(data => {
            console.log('Patient data received:', data);
            if (data.success) {
                currentPatientData = data;
                displayPatientData(data);
                console.log('Data displayed successfully');
            } else {
                console.error('Data loading failed:', data.message);
                showAlert('Error', data.message || 'Failed to load patient data', 'error');
                displayEmptyStates();
            }
        })
        .catch(error => {
            console.error('Error loading patient data:', error);
            showAlert('Error', 'Failed to load patient data. Please try refreshing the page.', 'error');
            displayEmptyStates();
        });
}

// Export functions to global scope IMMEDIATELY
window.showEditModal = showEditModal;
window.hideEditModal = hideEditModal;
window.hideAlertModal = hideAlertModal;
window.logout = logout;
window.uploadProfilePicture = uploadProfilePicture;
window.loadPatientData = loadPatientData;
window.checkAuthentication = checkAuthentication;

console.log('Functions exported to window immediately:', {
    showEditModal: typeof window.showEditModal,
    hideEditModal: typeof window.hideEditModal,
    hideAlertModal: typeof window.hideAlertModal,
    logout: typeof window.logout,
    uploadProfilePicture: typeof window.uploadProfilePicture,
    loadPatientData: typeof window.loadPatientData,
    checkAuthentication: typeof window.checkAuthentication
});

// Initialize the dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Patient Dashboard initialized');
    console.log('DOM ready, checking for elements...');
    
    // Debug: Check if key elements exist
    const editForm = document.getElementById('editForm');
    const modals = document.querySelectorAll('.modal');
    const patientName = document.getElementById('patientName');
    
    console.log('Element check:', {
        editForm: editForm ? 'Found' : 'Not found',
        modals: modals.length,
        patientName: patientName ? 'Found' : 'Not found'
    });
    
    initializeDashboard();
});

// Initialize dashboard
function initializeDashboard() {
    console.log('Initializing dashboard...');
    
    // Set up event listeners first
    setupEventListeners();
    
    // Check authentication
    checkAuthentication();
}

// Update header with patient name
function updateHeaderName(name) {
    const headerElement = document.getElementById('headerPatientName');
    if (headerElement) {
        headerElement.textContent = name || 'Welcome';
    }
}

// Show loading states
function showLoadingStates() {
    const loadingElements = [
        'patientName', 'patientAge', 'patientGender', 'patientContact', 'patientAddress',
        'registrationDate', 'totalFeedback', 'totalMessages', 'lastVisit',
        'accountCreated', 'latestFeedback', 'latestMessage'
    ];
    
    loadingElements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = 'Loading...';
        }
    });
}

// Display patient data
function displayPatientData(data) {
    console.log('Displaying patient data:', data);
    const patientInfo = data.patient_info;
    console.log('Patient info:', patientInfo);
    
    // Update personal information
    updateElement('patientName', patientInfo.name);
    updateElement('patientAge', patientInfo.age);
    updateElement('patientGender', patientInfo.gender);
    updateElement('patientContact', patientInfo.contact);
    updateElement('patientAddress', patientInfo.address);
    
    // Update stats
    updateElement('registrationDate', formatDate(patientInfo.register_date));
    updateElement('totalFeedback', patientInfo.total_feedback);
    updateElement('totalMessages', patientInfo.total_messages);
    updateElement('lastVisit', formatDate(patientInfo.last_visit));
    
    // Update activity section
    updateElement('accountCreated', formatDate(patientInfo.register_date));
    updateLatestActivity(data.feedback, data.messages);
    
    // Display feedback and messages
    displayFeedback(data.feedback);
    displayMessages(data.messages);
    
    // Update profile picture if available
    if (data.profile_picture) {
        const profilePic = document.getElementById('profilePicture');
        if (profilePic) {
            profilePic.src = data.profile_picture;
        }
    }
}

// Update element safely
function updateElement(id, value) {
    const element = document.getElementById(id);
    if (element) {
        element.textContent = value || 'N/A';
        console.log(`Updated element '${id}' with value: '${value || 'N/A'}'`);
    } else {
        console.warn(`Element with id '${id}' not found`);
    }
}

// Format date
function formatDate(dateString) {
    if (!dateString || dateString === 'N/A') {
        return 'N/A';
    }
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    } catch (error) {
        return dateString;
    }
}

// Update latest activity
function updateLatestActivity(feedback, messages) {
    // Latest feedback
    if (feedback && feedback.length > 0) {
        const latestFeedback = feedback[0];
        const feedbackText = latestFeedback.feedback.length > 50 
            ? latestFeedback.feedback.substring(0, 50) + '...'
            : latestFeedback.feedback;
        updateElement('latestFeedback', `${formatDate(latestFeedback.timestamp)} - ${feedbackText}`);
    } else {
        updateElement('latestFeedback', 'No feedback yet');
    }
    
    // Latest message
    if (messages && messages.length > 0) {
        const latestMessage = messages[0];
        const messageText = latestMessage.subject || 'No subject';
        updateElement('latestMessage', `${formatDate(latestMessage.timestamp)} - ${messageText}`);
    } else {
        updateElement('latestMessage', 'No messages yet');
    }
}

// Display feedback
function displayFeedback(feedback) {
    const container = document.getElementById('feedbackContainer');
    if (!container) {
        console.warn('Feedback container not found');
        return;
    }
    
    if (!feedback || feedback.length === 0) {
        container.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-comments text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-500">No feedback available</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = feedback.map(item => `
        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
            <div class="flex justify-between items-start mb-2">
                <h4 class="font-semibold text-gray-800">${item.feedback.substring(0, 60)}${item.feedback.length > 60 ? '...' : ''}</h4>
                <span class="text-sm text-gray-500">${formatDate(item.timestamp)}</span>
            </div>
            <p class="text-gray-600 text-sm mb-3">${item.feedback}</p>
            <div class="flex items-center text-sm text-gray-500">
                <i class="fas fa-thumbs-up mr-1"></i>
                <span class="mr-4">${item.likes || 0}</span>
                <i class="fas fa-thumbs-down mr-1"></i>
                <span>${item.dislikes || 0}</span>
            </div>
        </div>
    `).join('');
}

// Display messages
function displayMessages(messages) {
    const container = document.getElementById('messagesContainer');
    if (!container) {
        console.warn('Messages container not found');
        return;
    }
    
    if (!messages || messages.length === 0) {
        container.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-envelope text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-500">No messages available</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = messages.map(item => `
        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-purple-500">
            <div class="flex justify-between items-start mb-2">
                <h4 class="font-semibold text-gray-800">${item.subject || 'No Subject'}</h4>
                <span class="text-sm text-gray-500">${formatDate(item.timestamp)}</span>
            </div>
            <p class="text-gray-600 text-sm mb-3">${item.message}</p>
            <div class="flex items-center text-sm text-gray-500">
                <i class="fas fa-phone mr-1"></i>
                <span>${item.phone || 'N/A'}</span>
            </div>
        </div>
    `).join('');
}

// Display empty states
function displayEmptyStates() {
    const emptyElements = [
        'patientName', 'patientAge', 'patientGender', 'patientContact', 'patientAddress',
        'registrationDate', 'totalFeedback', 'totalMessages', 'lastVisit',
        'accountCreated', 'latestFeedback', 'latestMessage'
    ];
    
    emptyElements.forEach(id => {
        updateElement(id, 'N/A');
    });
    
    // Empty feedback and messages
    displayFeedback([]);
    displayMessages([]);
}

// Update patient information
function updatePatientInfo(formData) {
    const submitBtn = document.getElementById('updateButtonText');
    const originalText = submitBtn ? submitBtn.textContent : 'Update Information';
    
    // Show loading state
    if (submitBtn) {
        submitBtn.textContent = 'Updating...';
    }
    
    fetch('update_patient_info.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Update response:', data);
        if (data.success) {
            showAlert('Success', 'Information updated successfully!', 'success');
            hideEditModal();
            // Reload data to show updated information
            loadPatientData();
        } else {
            showAlert('Error', data.message || 'Failed to update information', 'error');
        }
    })
    .catch(error => {
        console.error('Update error:', error);
        showAlert('Error', 'Failed to update information. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button text
        if (submitBtn) {
            submitBtn.textContent = originalText;
        }
    });
}

// Show alert modal
function showAlert(title, message, type = 'info') {
    const alertModal = document.getElementById('alertModal');
    const alertTitle = document.getElementById('alertTitle');
    const alertMessage = document.getElementById('alertMessage');
    const alertIcon = document.getElementById('alertIcon');
    
    if (alertTitle) alertTitle.textContent = title;
    if (alertMessage) alertMessage.textContent = message;
    
    // Set icon and color based on type
    if (alertIcon) {
        let iconClass = 'fas fa-info-circle text-blue-500';
        switch (type) {
            case 'success':
                iconClass = 'fas fa-check-circle text-green-500';
                break;
            case 'error':
                iconClass = 'fas fa-exclamation-circle text-red-500';
                break;
            case 'warning':
                iconClass = 'fas fa-exclamation-triangle text-yellow-500';
                break;
        }
        alertIcon.innerHTML = `<i class="${iconClass} text-2xl"></i>`;
    }
    
    if (alertModal) {
        alertModal.classList.add('show');
    }
}

// Setup event listeners
function setupEventListeners() {
    console.log('Setting up event listeners...');
    
    // Edit form submission
    const editForm = document.getElementById('editForm');
    if (editForm) {
        console.log('Edit form found, adding event listener');
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            updatePatientInfo(formData);
        });
    } else {
        console.warn('Edit form not found - will retry later');
        // Retry after a short delay
        setTimeout(() => {
            const retryForm = document.getElementById('editForm');
            if (retryForm) {
                console.log('Edit form found on retry, adding event listener');
                retryForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    updatePatientInfo(formData);
                });
            } else {
                console.error('Edit form still not found after retry');
            }
        }, 100);
    }
    
    // Modal close on backdrop click
    const modals = document.querySelectorAll('.modal');
    if (modals.length > 0) {
        console.log('Found', modals.length, 'modals');
        modals.forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });
    } else {
        console.warn('No modals found - will retry later');
        // Retry after a short delay
        setTimeout(() => {
            const retryModals = document.querySelectorAll('.modal');
            if (retryModals.length > 0) {
                console.log('Found', retryModals.length, 'modals on retry');
                retryModals.forEach(modal => {
                    modal.addEventListener('click', function(e) {
                        if (e.target === this) {
                            this.classList.remove('show');
                        }
                    });
                });
            } else {
                console.error('No modals found after retry');
            }
        }, 100);
    }
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideEditModal();
            hideAlertModal();
        }
    });
    
    console.log('Event listeners setup completed');
}

console.log('Patient Dashboard JavaScript loaded successfully!'); 