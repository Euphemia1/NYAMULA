const express = require('express');
const nodemailer = require('nodemailer');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Nodemailer configuration
const transporter = nodemailer.createTransport({
    service: 'Gmail', // You can use other email services like Outlook, Yahoo, etc.
    auth: {
        user: 'your_email@gmail.com', // Replace with your email
        pass: 'your_email_password' // Replace with your email password or app-specific password
    }
});

// Endpoint to handle form submissions
app.post('/submit-form', (req, res) => {
    const { name, email, type } = req.body; // Get data from request body

    const mailOptions = {
        from: email,
        to: 'Admin@nyamula.com',
        subject: `${type} Registration Submission`,
        text: `New submission from ${name} (${email}) for ${type} registration.`
    };

    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            return res.status(500).send(error.toString());
        }
        res.status(200).send('Email sent: ' + info.response);
    });
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
