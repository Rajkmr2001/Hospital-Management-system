// This file contains JavaScript functions for handling user interactions in the admin panel.

document.addEventListener('DOMContentLoaded', function () {
    loadPatients();

    document.getElementById('addPatientBtn').addEventListener('click', function () {
        openModal('Add Patient');
    });

    document.querySelector('.close').addEventListener('click', closeModal);

    window.onclick = function (event) {
        var modal = document.getElementById('patientModal');
        if (event.target == modal) {
            closeModal();
        }
    };

    document.getElementById('patientForm').addEventListener('submit', function (event) {
        event.preventDefault();
        submitPatientForm();
    });

    document.getElementById('cancelBtn').onclick = closeModal;
});

function loadPatients() {
    fetch('php/get_patients.php')
        .then(response => response.json())
        .then(data => {
            const patientTableBody = document.getElementById('patientTableBody');
            patientTableBody.innerHTML = '';
            data.forEach(patient => {
                const genderDisplay = patient.gender.toLowerCase() === 'male' ? 'M' :
                    patient.gender.toLowerCase() === 'female' ? 'F' : 'O';
                const submissionTime = patient.submission_time || '';
                const submissionDate = patient.submission_date || '';
                const address = patient.address || '';
                const medicalHistory = patient.medical_history || '';
                const contact = patient.contact || '';
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${patient.id}</td>
                    <td>${patient.name}</td>
                    <td>${patient.age}</td>
                    <td>${genderDisplay}</td>
                    <td>${contact}</td>
                    <td>${address}</td>
                    <td>${submissionTime}</td>
                    <td>${submissionDate}</td>
                    <td>${medicalHistory}</td>
                    <td>
                        <button class="actionBtn edit" onclick="editPatient(${patient.id})">Edit</button>
                        <button class="actionBtn delete" onclick="deletePatient(${patient.id})">Delete</button>
                    </td>
                `;
                patientTableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error loading patients:', error));
}

function openModal(title) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('patientModal').style.display = 'flex';
    document.getElementById('patientForm').reset();
    document.getElementById('patientId').value = '';
    document.getElementById('submitBtn').innerText = title.includes('Edit') ? 'Update Patient' : 'Add Patient';
}

function closeModal() {
    document.getElementById('patientModal').style.display = 'none';
    document.getElementById('patientForm').reset();
}

function submitPatientForm() {
    const id = document.getElementById('patientId').value;
    const formData = new FormData(document.getElementById('patientForm'));
    let url = 'php/add_patient.php';
    let method = 'POST';
    if (id) {
        url = 'php/update_patient.php';
        formData.append('patient_id', id); // for update
    }
    fetch(url, {
        method: method,
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadPatients();
                closeModal();
            } else {
                alert('Error: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => console.error('Error submitting form:', error));
}

window.editPatient = function (id) {
    fetch(`php/get_patient.php?id=${id}`)
        .then(response => response.json())
        .then(patient => {
            openModal('Edit Patient');
            document.getElementById('patientId').value = patient.id;
            document.getElementById('name').value = patient.name;
            document.getElementById('age').value = patient.age;
            document.getElementById('gender').value = patient.gender;
            document.getElementById('contact').value = patient.contact;
            document.getElementById('address').value = patient.address;
            document.getElementById('medical_history').value = patient.medical_history;
        })
        .catch(error => console.error('Error fetching patient:', error));
};

window.deletePatient = function (id) {
    if (confirm('Are you sure you want to delete this patient?')) {
        fetch('php/delete_patient.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `patient_id=${encodeURIComponent(id)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadPatients();
                } else {
                    alert('Error deleting patient: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => console.error('Error deleting patient:', error));
    }
};

// Dashboard logic
if (window.location.pathname.endsWith('dashboard.html')) {
    document.addEventListener('DOMContentLoaded', function () {
        // Log user visit before fetching stats
        fetch('php/log_user_visit.php', { method: 'POST' })
            .finally(() => {
                // Fetch total patients count
                fetch('php/get_total_patients.php')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('total-patients').textContent = data.total || 0;
                    })
                    .catch(() => {
                        document.getElementById('total-patients').textContent = 'N/A';
                    });

                // Fetch total feedback count
                fetch('php/get_total_feedback.php')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('total-feedback').textContent = data.total || 0;
                    })
                    .catch(() => {
                        document.getElementById('total-feedback').textContent = 'N/A';
                    });

                // Fetch total messages count
                fetch('php/get_total_messages.php')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('messages-count').textContent = data.total || 0;
                    })
                    .catch(() => {
                        document.getElementById('messages-count').textContent = 'N/A';
                    });

                // Fetch total user visits count
                fetch('php/get_total_user_visits.php')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('user-visits').textContent = data.total || 0;
                    })
                    .catch(() => {
                        document.getElementById('user-visits').textContent = 'N/A';
                    });
            });

        const hamburger = document.getElementById('hamburger');
        const nav = document.querySelector('.sidebar nav');
        if (hamburger && nav) {
            hamburger.addEventListener('click', function () {
                nav.classList.toggle('active');
            });
        }

        // Hamburger menu and sidebar overlay logic for mobile
        (function() {
            const sidebar = document.getElementById('sidebar');
            const hamburger = document.getElementById('hamburger');
            const nav = document.getElementById('sidebarNav');
            const logout = document.getElementById('sidebarLogout');
            let sidebarOpen = false;

            function openSidebar() {
                sidebar.classList.add('open');
                sidebarOpen = true;
                document.body.style.overflow = 'hidden';
            }
            function closeSidebar() {
                sidebar.classList.remove('open');
                sidebarOpen = false;
                document.body.style.overflow = '';
            }
            if (hamburger) {
                hamburger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (!sidebarOpen) openSidebar();
                    else closeSidebar();
                });
            }
            // Close sidebar when clicking outside
            document.addEventListener('click', function(e) {
                if (sidebarOpen && !sidebar.contains(e.target)) {
                    closeSidebar();
                }
            });
            // Close sidebar when clicking a nav link
            if (nav) {
                nav.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 900) closeSidebar();
                    });
                });
            }
            // Also close on logout click
            if (logout) {
                logout.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 900) closeSidebar();
                    });
                });
            }
            // Optional: close sidebar on resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 900) closeSidebar();
            });
        })();
    });
}
