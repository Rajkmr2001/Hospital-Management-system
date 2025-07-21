class PatientController {
    constructor(patientModel) {
        this.patientModel = patientModel;
    }

    async viewPatients(req, res) {
        try {
            const patients = await this.patientModel.find({});
            res.status(200).json(patients);
        } catch (error) {
            res.status(500).json({ message: "Error retrieving patients", error });
        }
    }

    async addPatient(req, res) {
        try {
            const newPatient = new this.patientModel(req.body);
            await newPatient.save();
            res.status(201).json(newPatient);
        } catch (error) {
            res.status(400).json({ message: "Error adding patient", error });
        }
    }

    async updatePatient(req, res) {
        try {
            const updatedPatient = await this.patientModel.findByIdAndUpdate(req.params.id, req.body, { new: true });
            if (!updatedPatient) {
                return res.status(404).json({ message: "Patient not found" });
            }
            res.status(200).json(updatedPatient);
        } catch (error) {
            res.status(400).json({ message: "Error updating patient", error });
        }
    }

    async deletePatient(req, res) {
        try {
            const deletedPatient = await this.patientModel.findByIdAndDelete(req.params.id);
            if (!deletedPatient) {
                return res.status(404).json({ message: "Patient not found" });
            }
            res.status(200).json({ message: "Patient deleted successfully" });
        } catch (error) {
            res.status(500).json({ message: "Error deleting patient", error });
        }
    }
}

export default PatientController;