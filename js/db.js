// Local Database Store for Library Portal
const BOOKS_DATA = [
    { id: 1, title: "Data Structures Using C", author: "Reema Thareja", subject: "Data Structures", quantity: 15, available: 10, code: "3130702" },
    { id: 2, title: "Computer Networks", author: "Andrew S. Tanenbaum", subject: "Networking", quantity: 10, available: 4, code: "3150710" },
    { id: 3, title: "Introduction to Algorithms", author: "Cormen, Leiserson, Rivest, Stein", subject: "Algorithms", quantity: 8, available: 2, code: "3140708" },
    { id: 4, title: "Database System Concepts", author: "Silberschatz, Korth", subject: "Database Management", quantity: 12, available: 7, code: "3130703" },
    { id: 5, title: "Operating System Concepts", author: "Silberschatz, Galvin", subject: "Operating Systems", quantity: 14, available: 9, code: "3140702" }
];

const NOTICES_DATA = [
    { id: 1, title: "GTU Mid-Sem Exam Schedule Released", content: "Mid-semester examination timetable for Semester 3 & 5 is uploaded.", category: "Exam", date: "2026-08-20", important: true },
    { id: 2, title: "Library Book Return Reminder", content: "All books issued before August 10 must be returned or renewed by Friday.", category: "General", date: "2026-08-18", important: false },
    { id: 3, title: "New E-Book Portal Access", content: "Students can now download PDF lecture guides directly from the E-Books tab.", category: "Digital", date: "2026-08-15", important: false }
];

const FACULTY_DATA = [
    { id: 1, name: "Prof. A. K. Sharma", role: "HOD - Computer Dept" },
    { id: 2, name: "Prof. R. M. Patel", role: "Assistant Professor" },
    { id: 3, name: "Prof. S. N. Verma", role: "Library Coordinator" }
];

export async function getBooks() {
    return JSON.parse(localStorage.getItem("lib_books")) || BOOKS_DATA;
}

export async function getNotices() {
    return JSON.parse(localStorage.getItem("lib_notices")) || NOTICES_DATA;
}

export async function getFaculty() {
    return JSON.parse(localStorage.getItem("lib_faculty")) || FACULTY_DATA;
}