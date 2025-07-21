const express = require('express');
const bodyParser = require('body-parser');
const session = require('express-session');
const adminRoutes = require('./routes/adminRoutes');
const patientRoutes = require('./routes/patientRoutes');

const app = express();

// Middleware
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(session({
    secret: 'your_secret_key',
    resave: false,
    saveUninitialized: true,
}));

// Set view engine
app.set('view engine', 'html');
app.set('views', './views');

// Routes
app.use('/admin', adminRoutes);
app.use('/patients', patientRoutes);

// Error handling
app.use((req, res, next) => {
    res.status(404).send('Page not found');
});

// Start the server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});