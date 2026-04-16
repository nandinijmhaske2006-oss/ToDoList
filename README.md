# To-Do List Website 📝

A simple and interactive task management system built with PHP and MySQL. This web application allows users to organize their daily activities efficiently by adding, updating, and deleting tasks.

## 🌟 Key Features
- **Task Management**: Add new tasks, mark them as completed, and delete tasks.
- **Database Integration**: Persistent storage using MySQL.
- **User-Friendly Interface**: Minimalistic design with a responsive layout.
- **Report Generation**: Generate a PDF summary of your tasks using the FPDF library.
- **Clear History**: Option to reset your task history easily.
- **Real-Time Updates**: Instant feedback upon task actions.

## 🛠️ Technology Stack
- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL
- **Report Library**: FPDF 1.86

## 📂 Directory Structure
```text
ToDo-List-Project/
├── TodoList.php (main)
├── style.css
├── Report.php
├── clear_history.php
├── setup_db.sql
├── .gitignore
├── README.md
├── fpdf/ (FPDF library files)
└── Images/ (UI Icons and Backgrounds)
    ├── checklist.png
    ├── delete.png
    ├── check-mark (1).png
    └── clear.png
```

## 🚀 Setup Instructions

### 1. Database Setup
1.  **Open MySQL Management**: Log in to your MySQL server (via phpMyAdmin, MySQL Workbench, etc.).
2.  **Run SQL Script**: Import the provided [setup_db.sql](setup_db.sql) file.
    - This will create a database named `php micro project`.
    - It will also create a `tasks` table with the following structure: `Id`, `task`, `status`.

### 2. Configure PHP
1.  **Server Requirement**: You need a local server environment like XAMPP or WAMP.
2.  **Move Files**: Place the project folder into your server's root directory (`htdocs` for XAMPP, `www` for WAMP).
3.  **Start Services**: Ensure both Apache and MySQL are running.

### 3. Run the App
1.  Open your browser and navigate to:
    `http://localhost/micro_project_TodoList/TodoList.php`

---
*Created for the PWP (Programming with PHP) Micro Project.*
