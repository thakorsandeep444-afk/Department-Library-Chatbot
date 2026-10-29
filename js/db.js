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

// [id, title, author, category, size, year, description]
const EBOOK_ROWS = [
    ["E101", "C Programming Language Notes", "Brian Kernighan, Dennis Ritchie", "Programming", "4.2 MB", 2015, "Core C programming concepts: data types, pointers, arrays, functions and file handling."],
    ["E102", "Data Structures Study Guide", "Reema Thareja", "Programming", "6.8 MB", 2014, "Stacks, queues, linked lists, trees and graphs explained with C examples."],
    ["E103", "Python Programming Basics", "Eric Matthes", "Programming", "5.5 MB", 2023, "Beginner friendly Python guide with practical exercises and mini projects."],
    ["E104", "Java Complete Reference Notes", "Herbert Schildt", "Programming", "8.1 MB", 2021, "Object oriented programming in Java: classes, inheritance, exceptions and collections."],
    ["E105", "Computer Networks Lecture Sheets", "Andrew S. Tanenbaum", "Networking", "7.3 MB", 2024, "OSI and TCP/IP models, routing, switching and network security basics."],
    ["E106", "Database Management Guide", "Silberschatz, Korth", "Database", "6.2 MB", 2019, "ER modelling, SQL queries, normalization and transaction management."],
    ["E107", "Operating System Concepts Summary", "Silberschatz, Galvin", "Operating Systems", "5.9 MB", 2018, "Processes, scheduling, memory management, file systems and deadlocks."],
    ["E108", "Software Engineering Handbook", "Ian Sommerville", "Software Engineering", "7.0 MB", 2016, "SDLC models, requirements, design, testing and project management."],
    ["E109", "Web Development Basics", "Uttam K. Roy", "Web Development", "4.8 MB", 2020, "HTML, CSS, JavaScript and responsive design for beginners."],
    ["E110", "Engineering Mathematics Formula Sheet", "B. S. Grewal", "Mathematics", "2.9 MB", 2017, "Calculus, matrices, differential equations and Laplace transform formulas."],
    ["E111", "Basic Electrical Engineering Notes", "V. N. Mittle", "Electrical", "5.1 MB", 2015, "Circuit laws, AC fundamentals, transformers and electrical machines."],
    ["E112", "Digital Electronics Guide", "M. Morris Mano", "Electronics", "4.6 MB", 2013, "Logic gates, flip-flops, counters, registers and combinational design."],
    ["E113", "Engineering Thermodynamics Notes", "P. K. Nag", "Mechanical", "5.7 MB", 2013, "Laws of thermodynamics, cycles, entropy and heat engines."],
    ["E114", "Fluid Mechanics Quick Guide", "R. K. Bansal", "Mechanical", "6.0 MB", 2015, "Fluid properties, flow measurement, pumps and turbines."],
    ["E115", "Surveying Fundamentals", "B. C. Punmia", "Civil", "5.4 MB", 2016, "Chain, compass and theodolite surveying with levelling methods."],
    ["E116", "Concrete Technology Notes", "M. S. Shetty", "Civil", "4.9 MB", 2013, "Cement, aggregates, mix design and testing of concrete."],
    ["E117", "GTU Exam Preparation Guide", "Department Faculty", "Exam Preparation", "3.5 MB", 2025, "Important questions and answer-writing tips for GTU diploma exams."],
    ["E118", "Placement Aptitude Handbook", "R. S. Aggarwal", "Exam Preparation", "4.0 MB", 2022, "Quantitative aptitude, reasoning and interview preparation material."]
];

const EBOOKS_DATA = EBOOK_ROWS.map((r, i) => ({
    id: r[0], title: r[1], author: r[2], category: r[3], subject: r[3], size: r[4], year: r[5],
    description: r[6], fileName: r[1].toLowerCase().replace(/[^a-z0-9]+/g, "-") + ".pdf",
    fileUrl: "", // put a real PDF link here to enable Read and Download
    createdAt: `2026-09-${String(1 + (i % 28)).padStart(2, "0")}`
}));

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

// Saved e-books win over defaults, but new default e-books always appear
export async function getEbooks() {
    const saved = readStore("lib_ebooks");
    if (!saved) return EBOOKS_DATA.map(e => ({ ...e }));
    const merged = new Map(EBOOKS_DATA.map(e => [String(e.id), { ...e }]));
    saved.forEach(e => merged.set(String(e.id), e));
    return [...merged.values()];
}

export async function addEbook(ebook) {
    const list = await getEbooks();
    const item = { ...ebook, id: ebook.id ?? "E" + Date.now(), createdAt: ebook.createdAt || new Date().toISOString() };
    list.push(item);
    writeStore("lib_ebooks", list);
    return item;
}

export async function deleteEbook(id) {
    const list = await getEbooks();
    writeStore("lib_ebooks", list.filter(e => String(e.id) !== String(id)));
}
