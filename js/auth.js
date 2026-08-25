/**
 * Department Library AI Chatbot
 * Authentication Controller (Firebase Auth / LocalStorage Session Manager / PHP OTP Integration)
 */

import { FIREBASE_CONFIG, APP_MODE } from "./config.js";

let auth = null;

if (APP_MODE === "firebase") {
    try {
        const { initializeApp } = await import("https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js");
        const { getAuth } = await import("https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js");
        const app = initializeApp(FIREBASE_CONFIG);
        auth = getAuth(app);
    } catch (e) {
        console.error("[Auth] Firebase Auth initialization failed:", e);
    }
}

const SESSION_KEY = "lib_current_session";
const USERS_KEY = "lib_registered_users";

function seedDemoUsers() {
    if (!localStorage.getItem(USERS_KEY)) {
        const defaultUsers = [
            { email: "admin@college.edu", password: "admin123", name: "System Administrator", role: "admin", verified: true },
            { email: "student@college.edu", password: "student123", name: "John Doe", role: "student", verified: true }
        ];
        localStorage.setItem(USERS_KEY, JSON.stringify(defaultUsers));
    }
}
seedDemoUsers();

/**
 * Send OTP via backend PHP API
 */
export async function sendOTP(email) {
    const formData = new FormData();
    formData.append("email", email);

    const res = await fetch("backend/api/send_otp.php", {
        method: "POST",
        body: formData
    });

    const data = await res.json();
    if (!data.success) throw new Error(data.message || "Failed to send OTP.");
    return data;
}

/**
 * Verify OTP via backend PHP API
 */
export async function verifyOTP(email, otp) {
    const formData = new FormData();
    formData.append("email", email);
    formData.append("otp", otp);

    const res = await fetch("backend/api/verify_otp.php", {
        method: "POST",
        body: formData
    });

    const data = await res.json();
    if (!data.success) throw new Error(data.message || "Invalid OTP verification.");
    
    await verifyUserEmail(email);
    return data;
}

export async function register(email, password, displayName, role = "student") {
    if (APP_MODE === "firebase" && auth) {
        const { createUserWithEmailAndPassword, updateProfile, sendEmailVerification } = 
            await import("https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js");
        
        const credential = await createUserWithEmailAndPassword(auth, email, password);
        await updateProfile(credential.user, { displayName });
        await sendEmailVerification(credential.user);
        
        return { email: credential.user.email, name: displayName, role, verified: false };
    } else {
        const users = JSON.parse(localStorage.getItem(USERS_KEY)) || [];
        if (users.some(u => u.email.toLowerCase() === email.toLowerCase())) {
            throw new Error("Email address already registered.");
        }
        
        const newUser = { email: email.toLowerCase(), password, name: displayName, role, verified: false };
        users.push(newUser);
        localStorage.setItem(USERS_KEY, JSON.stringify(users));
        return newUser;
    }
}

export async function login(email, password) {
    if (APP_MODE === "firebase" && auth) {
        const { signInWithEmailAndPassword } = await import("https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js");
        const credential = await signInWithEmailAndPassword(auth, email, password);
        const userObj = {
            email: credential.user.email,
            name: credential.user.displayName || credential.user.email.split('@')[0],
            role: credential.user.email.toLowerCase() === "admin@college.edu" ? "admin" : "student",
            verified: credential.user.emailVerified
        };
        localStorage.setItem(SESSION_KEY, JSON.stringify(userObj));
        return userObj;
    } else {
        const users = JSON.parse(localStorage.getItem(USERS_KEY)) || [];
        const user = users.find(u => u.email.toLowerCase() === email.toLowerCase() && u.password === password);
        if (!user) throw new Error("Invalid email or password.");
        
        const userObj = { email: user.email, name: user.name, role: user.role, verified: user.verified };
        localStorage.setItem(SESSION_KEY, JSON.stringify(userObj));
        return userObj;
    }
}

export async function resetPassword(email) {
    if (APP_MODE === "firebase" && auth) {
        const { sendPasswordResetEmail } = await import("https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js");
        await sendPasswordResetEmail(auth, email);
        return true;
    } else {
        const users = JSON.parse(localStorage.getItem(USERS_KEY)) || [];
        if (!users.some(u => u.email.toLowerCase() === email.toLowerCase())) {
            throw new Error("Email address not found in system.");
        }
        return true;
    }
}

export async function logout() {
    if (APP_MODE === "firebase" && auth) {
        const { signOut } = await import("https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js");
        await signOut(auth);
    }
    localStorage.removeItem(SESSION_KEY);
    return true;
}

export function getCurrentUser() {
    try {
        const session = localStorage.getItem(SESSION_KEY);
        return session ? JSON.parse(session) : null;
    } catch (e) {
        return null;
    }
}

export async function verifyUserEmail(email) {
    if (APP_MODE !== "firebase") {
        const users = JSON.parse(localStorage.getItem(USERS_KEY)) || [];
        const idx = users.findIndex(u => u.email.toLowerCase() === email.toLowerCase());
        if (idx !== -1) {
            users[idx].verified = true;
            localStorage.setItem(USERS_KEY, JSON.stringify(users));
            
            const current = getCurrentUser();
            if (current && current.email.toLowerCase() === email.toLowerCase()) {
                current.verified = true;
                localStorage.setItem(SESSION_KEY, JSON.stringify(current));
            }
            return true;
        }
    }
    return true;
}

export function setupAuthListener(callback) {
    if (APP_MODE === "firebase" && auth) {
        import("https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js").then(({ onAuthStateChanged }) => {
            onAuthStateChanged(auth, (user) => {
                if (user) {
                    const userObj = {
                        email: user.email,
                        name: user.displayName || user.email.split('@')[0],
                        role: user.email.toLowerCase() === "admin@college.edu" ? "admin" : "student",
                        verified: user.emailVerified
                    };
                    localStorage.setItem(SESSION_KEY, JSON.stringify(userObj));
                    callback(userObj);
                } else {
                    localStorage.removeItem(SESSION_KEY);
                    callback(null);
                }
            });
        });
    } else {
        callback(getCurrentUser());
    }
}

export function enforceProtectedRoute(requiredRole = null) {
    const user = getCurrentUser();
    if (!user) {
        window.location.href = "login.php?redirect=" + encodeURIComponent(window.location.pathname);
        return false;
    }
    
    if (requiredRole && user.role !== requiredRole) {
        window.location.href = requiredRole === "admin" ? "dashboard.html" : "index.html";
        return false;
    }
    return true;
}

/**
 * Update user password after successful OTP verification
 */
export async function updatePasswordWithOTP(email, newPassword) {
    if (APP_MODE === "firebase" && auth) {
        // Firebase handles resets via emailed reset link; for demo/local storage:
        throw new Error("Password reset via OTP is supported in Demo mode.");
    } else {
        const users = JSON.parse(localStorage.getItem(USERS_KEY)) || [];
        const index = users.findIndex(u => u.email.toLowerCase() === email.toLowerCase());
        
        if (index === -1) {
            throw new Error("No account found with this email address.");
        }
        
        users[index].password = newPassword;
        localStorage.setItem(USERS_KEY, JSON.stringify(users));
        return true;
    }
}