// 30 new books for the Department Library catalog.
// Fields match what books.html and index.html read:
// id, title, author, subject, department, semester, type, year, quantity, available, rating, location, publisher, addedAt

// [id, title, author, subject, dept, sem, type, year, quantity, available, rating, rack, publisher]
const rows = [
  ["B101", "Operating System Concepts", "Abraham Silberschatz, Peter Galvin", "Operating Systems", "CO", 4, "Textbook", 2018, 10, 3, 4.6, "CO-R1", "Wiley"],
  ["B102", "Database System Concepts", "Abraham Silberschatz, Henry Korth", "DBMS", "CO", 4, "Textbook", 2019, 8, 2, 4.5, "CO-R1", "McGraw Hill"],
  ["B103", "Data Structures Using C", "Reema Thareja", "Data Structures", "CO", 3, "Textbook", 2014, 12, 7, 4.2, "CO-R2", "Oxford University Press"],
  ["B104", "Let Us C", "Yashavant Kanetkar", "Programming in C", "CO", 1, "Textbook", 2020, 15, 9, 4.4, "CO-R2", "BPB Publications"],
  ["B105", "The C Programming Language", "Brian Kernighan, Dennis Ritchie", "Programming in C", "CO", 1, "Reference", 2015, 5, 4, 4.8, "CO-R2", "Pearson"],
  ["B106", "Java: The Complete Reference", "Herbert Schildt", "Object Oriented Programming", "CO", 4, "Reference", 2021, 8, 5, 4.5, "CO-R3", "McGraw Hill"],
  ["B107", "Python Crash Course", "Eric Matthes", "Python Programming", "IF", 2, "Textbook", 2023, 9, 4, 4.7, "IF-R1", "No Starch Press"],
  ["B108", "Software Engineering", "Ian Sommerville", "Software Engineering", "IF", 5, "Textbook", 2016, 7, 2, 4.3, "IF-R1", "Pearson"],
  ["B109", "Computer Organization and Architecture", "William Stallings", "Computer Architecture", "CO", 3, "Textbook", 2016, 8, 6, 4.4, "CO-R3", "Pearson"],
  ["B110", "Artificial Intelligence: A Modern Approach", "Stuart Russell, Peter Norvig", "Artificial Intelligence", "CO", 6, "Reference", 2021, 6, 3, 4.7, "CO-R4", "Pearson"],
  ["B111", "Web Technologies", "Uttam K. Roy", "Web Development", "IF", 5, "Textbook", 2010, 10, 8, 4.0, "IF-R2", "Oxford University Press"],
  ["B112", "Higher Engineering Mathematics", "B. S. Grewal", "Engineering Mathematics", "CO", 1, "Textbook", 2017, 14, 5, 4.5, "GEN-R1", "Khanna Publishers"],
  ["B113", "Engineering Physics", "Gaur, Gupta", "Engineering Physics", "EE", 1, "Textbook", 2013, 11, 8, 4.1, "GEN-R1", "Dhanpat Rai"],
  ["B114", "Basic Electrical Engineering", "V. N. Mittle, Arvind Mittal", "Basic Electrical Engineering", "EE", 1, "Textbook", 2015, 12, 6, 4.3, "EE-R1", "McGraw Hill"],
  ["B115", "Electrical Machines", "P. S. Bimbhra", "Electrical Machines", "EE", 4, "Textbook", 2012, 9, 2, 4.4, "EE-R1", "Khanna Publishers"],
  ["B116", "Power System Analysis", "Hadi Saadat", "Power Systems", "EE", 5, "Textbook", 2010, 6, 4, 4.2, "EE-R2", "McGraw Hill"],
  ["B117", "Principles of Electronics", "V. K. Mehta, Rohit Mehta", "Electronics", "EE", 3, "Textbook", 2014, 10, 7, 4.3, "EE-R2", "S. Chand"],
  ["B118", "Engineering Thermodynamics", "P. K. Nag", "Thermodynamics", "ME", 3, "Textbook", 2013, 9, 3, 4.5, "ME-R1", "McGraw Hill"],
  ["B119", "Fluid Mechanics and Hydraulic Machines", "R. K. Bansal", "Fluid Mechanics", "ME", 4, "Textbook", 2015, 10, 5, 4.4, "ME-R1", "Laxmi Publications"],
  ["B120", "Theory of Machines", "S. S. Rattan", "Theory of Machines", "ME", 5, "Textbook", 2014, 8, 6, 4.2, "ME-R2", "McGraw Hill"],
  ["B121", "Strength of Materials", "R. K. Rajput", "Strength of Materials", "ME", 3, "Textbook", 2012, 9, 4, 4.1, "ME-R2", "S. Chand"],
  ["B122", "Manufacturing Technology", "P. N. Rao", "Manufacturing Processes", "ME", 4, "Textbook", 2013, 7, 5, 4.2, "ME-R3", "McGraw Hill"],
  ["B123", "Surveying", "B. C. Punmia", "Surveying", "CE", 3, "Textbook", 2016, 12, 7, 4.4, "CE-R1", "Laxmi Publications"],
  ["B124", "Structural Analysis", "R. C. Hibbeler", "Structural Analysis", "CE", 4, "Textbook", 2017, 6, 2, 4.5, "CE-R1", "Pearson"],
  ["B125", "Concrete Technology", "M. S. Shetty", "Concrete Technology", "CE", 5, "Textbook", 2013, 9, 6, 4.3, "CE-R2", "S. Chand"],
  ["B126", "Soil Mechanics and Foundation Engineering", "K. R. Arora", "Geotechnical Engineering", "CE", 5, "Textbook", 2011, 8, 5, 4.2, "CE-R2", "Standard Publishers"],
  ["B127", "Engineering Mechanics", "Irving H. Shames", "Engineering Mechanics", "CE", 2, "Textbook", 2005, 10, 8, 4.0, "CE-R3", "Pearson"],
  ["B128", "Digital Design", "M. Morris Mano", "Digital Electronics", "IF", 3, "Textbook", 2013, 11, 4, 4.6, "IF-R2", "Pearson"],
  ["B129", "Cracking the Coding Interview", "Gayle Laakmann McDowell", "Interview Preparation", "CO", 6, "Competitive", 2019, 5, 1, 4.8, "CO-R4", "CareerCup"],
  ["B130", "Programming in C Lab Manual", "Department Faculty", "Programming in C", "CO", 1, "Lab Manual", 2024, 15, 11, 4.0, "CO-LAB", "K.D. Polytechnic"]
];

export const extraBooks = rows.map((r, i) => ({
  id: r[0], title: r[1], author: r[2], subject: r[3], department: r[4], semester: r[5],
  type: r[6], year: r[7], quantity: r[8], available: r[9], rating: r[10], location: r[11],
  publisher: r[12], language: "English",
  description: `${r[1]} by ${r[2]} covers ${r[3]} for semester ${r[5]} students and is available in the department library.`,
  addedAt: `2026-10-${String(1 + (i % 15)).padStart(2, "0")}T10:00:00.000Z`
}));
