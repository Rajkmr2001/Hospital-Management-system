const express = require('express');
const router = express.Router();
const adminController = require('../controllers/adminController');

// Admin login route
router.post('/login', adminController.login);

// Admin dashboard route
router.get('/dashboard', adminController.dashboard);

// Export the router
module.exports = router;