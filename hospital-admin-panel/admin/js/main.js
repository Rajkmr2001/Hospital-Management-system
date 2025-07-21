// This file contains JavaScript functions for handling user interactions in the admin panel.

document.addEventListener('DOMContentLoaded', function() {
    loadPatients();

    document.getElementById('addPatientForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addPatient();
    });

    document.getElementById('updatePatientForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updatePatient();
    });
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
                    <td>${patient.contact}</td>
                    <td>
                        <button onclick="editPatient(${patient.id})">Edit</button>
                        <button onclick="deletePatient(${patient.id})">Delete</button>
                    </td>
                `;
                patientTableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error loading patients:', error));
}

function addPatient() {
    const formData = new FormData(document.getElementById('addPatientForm'));
    fetch('php/add_patient.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadPatients();
            document.getElementById('addPatientForm').reset();
        } else {
            alert('Error adding patient: ' + data.message);
        }
    })
    .catch(error => console.error('Error adding patient:', error));
}

function editPatient(id) {
    fetch(`php/get_patient.php?id=${id}`)
        .then(response => response.json())
        .then(patient => {
            document.getElementById('updatePatientId').value = patient.id;
            document.getElementById('updatePatientName').value = patient.name;
            document.getElementById('updatePatientAge').value = patient.age;
            document.getElementById('updatePatientGender').value = patient.gender;
            document.getElementById('updatePatientContact').value = patient.contact;
        })
        .catch(error => console.error('Error fetching patient:', error));
}

function updatePatient() {
    const formData = new FormData(document.getElementById('updatePatientForm'));
    fetch('php/update_patient.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadPatients();
            document.getElementById('updatePatientForm').reset();
        } else {
            alert('Error updating patient: ' + data.message);
        }
    })
    .catch(error => console.error('Error updating patient:', error));
}

function deletePatient(id) {
    if (confirm('Are you sure you want to delete this patient?')) {
        fetch(`php/delete_patient.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadPatients();
            } else {
                alert('Error deleting patient: ' + data.message);
            }
        })
        .catch(error => console.error('Error deleting patient:', error));
}