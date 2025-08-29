const express = require('express');
const bcrypt = require('bcrypt');
const cors = require('cors');
const app = express();
require('dotenv').config();
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));



app.post('/send-mssg', async (req, res) => {
    try {
        const { receiver, message } = req.body;
        // Here you would integrate with your SMS API to send the message
        res.status(200).json({ message: "Message sent successfully", to: receiver });
        // https://www.firetext.co.uk/api/sendsms?apiKey=myApiKey&message=This+is+a+test+message&from=FireText&to=07123456789,447712345678&schedule=2010-05-22%2017:00&reference=1234567
    } catch (error) {
        console.error('Send message error:', error);
        res.status(500).json({ message: "Server error" });
    }
});
