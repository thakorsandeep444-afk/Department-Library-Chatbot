// =========================================================
// Department Library AI Chatbot Integration
// API: Google Gemini API (Free Tier)
// =========================================================

// 1. Replace with your actual key from Google AI Studio (starts with AIzaSy...)
const GEMINI_API_KEY = "AQ.Ab8RN6IUZUX2WS2SlfIlwIy5zn3I6KtyiW4VGAAVCrwootv5Sg";

document.addEventListener("DOMContentLoaded", () => {
    
    // Global Click Delegation for Dynamic UI Elements
    document.addEventListener("click", (e) => {
        const triggerBtn = e.target.closest("#chatbot-trigger-btn");
        const minimizeBtn = e.target.closest("#chat-minimize-btn");
        const chipBtn = e.target.closest(".suggestion-chip");

        if (triggerBtn) {
            const chatWindow = document.getElementById("chatbot-window-box");
            const chatInput = document.getElementById("chat-user-input");
            if (chatWindow) {
                chatWindow.classList.toggle("active");
                if (chatWindow.classList.contains("active") && chatInput) {
                    chatInput.focus();
                }
            }
        }

        if (minimizeBtn) {
            const chatWindow = document.getElementById("chatbot-window-box");
            if (chatWindow) chatWindow.classList.remove("active");
        }

        if (chipBtn) {
            const query = chipBtn.innerText.trim();
            const chatInput = document.getElementById("chat-user-input");
            if (query && chatInput) {
                chatInput.value = query;
                handleSendMessage();
            }
        }
    });

    // Form Submission Event
    document.addEventListener("submit", (e) => {
        if (e.target.id === "chat-input-form") {
            e.preventDefault();
            handleSendMessage();
        }
    });

    // Core Message Handler
    async function handleSendMessage() {
        const chatInput = document.getElementById("chat-user-input");
        const chatLogs = document.getElementById("chat-logs-container");
        if (!chatInput || !chatLogs) return;

        const messageText = chatInput.value.trim();
        if (!messageText) return;

        appendMessage(messageText, "user");
        chatInput.value = "";

        const loadingId = appendLoadingIndicator();

        try {
            const botResponse = await callGeminiAPI(messageText);
            removeLoadingIndicator(loadingId);
            appendMessage(botResponse, "bot");
        } catch (error) {
            console.error("Chatbot Error:", error);
            removeLoadingIndicator(loadingId);
            appendMessage("Sorry, I encountered an issue connecting to the library assistant. Please verify your API key.", "bot");
        }
    }

    // UI Rendering Helpers
    function appendMessage(text, sender) {
        const chatLogs = document.getElementById("chat-logs-container");
        if (!chatLogs) return;

        const msgDiv = document.createElement("div");
        msgDiv.className = `chat-msg ${sender}`;
        const avatarIcon = sender === "user" ? "person" : "smart_toy";
        
        msgDiv.innerHTML = `
            <div class="msg-avatar"><span class="material-icons">${avatarIcon}</span></div>
            <div class="msg-bubble">${escapeHtml(text)}</div>
        `;

        chatLogs.appendChild(msgDiv);
        chatLogs.scrollTop = chatLogs.scrollHeight;
    }

    function appendLoadingIndicator() {
        const chatLogs = document.getElementById("chat-logs-container");
        const id = "loading-" + Date.now();
        const loadingDiv = document.createElement("div");
        loadingDiv.id = id;
        loadingDiv.className = "chat-msg bot";
        loadingDiv.innerHTML = `
            <div class="msg-avatar"><span class="material-icons">smart_toy</span></div>
            <div class="msg-bubble"><em>Searching catalog...</em></div>
        `;
        chatLogs.appendChild(loadingDiv);
        chatLogs.scrollTop = chatLogs.scrollHeight;
        return id;
    }

    function removeLoadingIndicator(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    function escapeHtml(str) {
        return str.replace(/[&<>"']/g, (m) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
        })[m]);
    }

    // 5. Google Gemini API Call
    async function callGeminiAPI(userQuery) {
        const apiKey = "AQ.Ab8RN6IUZUX2WS2SlfIlwIy5zn3I6KtyiW4VGAAVCrwootv5Sg";
        const systemPrompt = "You are Liby, the official AI Librarian for the Computer Engineering Department Library. Assist students with GTU exam syllabus, GTU papers, book availability, library operational hours, and digital e-books clearly and concisely.";

        // Updated model route to gemini-2.0-flash
        const endpoint = `https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key=${apiKey}`;

        const response = await fetch(endpoint, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                contents: [{
                    role: "user",
                    parts: [{ text: `${systemPrompt}\n\nStudent Question: ${userQuery}` }]
                }]
            })
        });

        if (!response.ok) {
            const errDetails = await response.text();
            console.error("Gemini API Error Response:", errDetails);
            throw new Error(`HTTP Error: ${response.status}`);
        }

        const data = await response.json();
        return data?.candidates?.[0]?.content?.parts?.[0]?.text || "No response received from Gemini.";
    }
});