const express = require("express");
const path = require("path");
const cors = require("cors");
require("dotenv").config();

const app = express();

app.use(cors());
app.use(express.json());

// Serve static files
app.use(express.static(__dirname));

// Home page
app.get("/", (req, res) => {
    res.sendFile(path.join(__dirname, "index.html"));
});

const PORT = process.env.PORT || 8080;

app.listen(PORT, () => {
    console.log("====================================");
    console.log("Department Library Chatbot");
    console.log(`Server Running: http://localhost:${PORT}`);
    console.log("====================================");
});