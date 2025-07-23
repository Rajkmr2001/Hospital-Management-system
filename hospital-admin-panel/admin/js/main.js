// This file contains JavaScript functions for handling user interactions in the admin panel.

document.addEventListener('DOMContentLoaded', function() {
    loadPatients();

    document.getElementById('addPatientBtn').addEventListener('click', function() {
        openModal('Add Patient');
    });

    document.querySelector('.close').addEventListener('click', closeModal);

    window.onclick = function(event) {
        var modal = document.getElementById('patientModal');
        if (event.target == modal) {
            closeModal();
        }
    };

    document.getElementById('patientForm').addEventListener('submit', function(event) {
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
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${patient.id}</td>
                    <td>${patient.name}</td>
                    <td>${patient.age}</td>
                    <td>${patient.gender}</td>
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

window.editPatient = function(id) {
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

window.deletePatient = function(id) {
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
