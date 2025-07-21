const express = require('express');
const router = express.Router();
const patientController = require('../controllers/patientController');

// Route to view all patients
router.get('/patients', patientController.viewPatients);

// Route to add a new patient
router.post('/patients', patientController.addPatient);

// Route to update an existing patient
router.put('/patients/:id', patientController.updatePatient);

// Route to delete a patient
router.delete('/patients/:id', patientController.deletePatient);

// Route to view a specific patient
router.get('/patients/:id', patientController.viewPatient);

module.exports = router;