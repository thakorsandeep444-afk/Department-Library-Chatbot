// Local Database Store for Library Portal
import { extraBooks } from "./books-data.js";

const BOOKS_DATA = [
    { id: 1, addedAt: "2026-03-05", title: "Data Structures Using C", author: "Reema Thareja", subject: "Data Structures", department: "CO", semester: 3, type: "Textbook", year: 2014, rating: 4.2, quantity: 15, available: 10, code: "3130702" },
    { id: 2, addedAt: "2026-05-12", title: "Computer Networks", author: "Andrew S. Tanenbaum", subject: "Networking", department: "CO", semester: 5, type: "Textbook", year: 2024, rating: 4.0, quantity: 10, available: 4, code: "3150710" },
    { id: 3, addedAt: "2026-07-20", title: "Introduction to Algorithms", author: "Cormen, Leiserson, Rivest, Stein", subject: "Algorithms", department: "CO", semester: 4, type: "Reference", year: 2022, rating: 4.7, quantity: 8, available: 2, code: "3140708" },
    { id: 4, addedAt: "2026-09-10", title: "Database System Concepts", author: "Silberschatz, Korth", subject: "Database Management", department: "CO", semester: 3, type: "Textbook", year: 2019, rating: 4.5, quantity: 12, available: 7, code: "3130703" },
    { id: 5, addedAt: "2026-09-24", title: "Operating System Concepts", author: "Silberschatz, Galvin", subject: "Operating Systems", department: "CO", semester: 4, type: "Textbook", year: 2018, rating: 4.6, quantity: 14, available: 9, code: "3140702" }
];

// Add the new books, skipping any title that already exists above
const existingTitles = new Set(BOOKS_DATA.map(b => b.title.trim().toLowerCase()));
const ALL_BOOKS = [
    ...BOOKS_DATA,
    ...extraBooks.filter(b => !existingTitles.has(b.title.trim().toLowerCase()))
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

// Safe localStorage reader: never throws, returns null when empty or broken
function readStore(key) {
    try {
        const raw = localStorage.getItem(key);
        const parsed = raw ? JSON.parse(raw) : null;
        return Array.isArray(parsed) ? parsed : null;
    } catch {
        return null;
    }
}

function writeStore(key, list) {
    localStorage.setItem(key, JSON.stringify(list));
}

// Saved changes (e.g. reservations) win over defaults, but new default books always appear
export async function getBooks() {
    const saved = readStore("lib_books");
    if (!saved) return ALL_BOOKS.map(b => ({ ...b }));
    const merged = new Map(ALL_BOOKS.map(b => [String(b.id), { ...b }]));
    saved.forEach(b => merged.set(String(b.id), b));
    return [...merged.values()];
}

export async function updateBook(id, changes) {
    const books = await getBooks();
    const index = books.findIndex(b => String(b.id) === String(id));
    if (index === -1) throw new Error("Book not found: " + id);
    books[index] = { ...books[index], ...changes };
    writeStore("lib_books", books);
    return books[index];
}

export async function addBook(book) {
    const books = await getBooks();
    const newBook = { ...book, id: book.id ?? "B" + Date.now(), addedAt: book.addedAt || new Date().toISOString() };
    books.push(newBook);
    writeStore("lib_books", books);
    return newBook;
}

export async function deleteBook(id) {
    const books = await getBooks();
    writeStore("lib_books", books.filter(b => String(b.id) !== String(id)));
}

export async function getNotices() {
    return readStore("lib_notices") || NOTICES_DATA;
}

export async function getFaculty() {
    return readStore("lib_faculty") || FACULTY_DATA;
}
