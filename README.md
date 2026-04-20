# CI/CD Practical: To-Do List Application 📝🚀

A secure and interactive task management system designed as a practical implementation for CI/CD workflows. This application allows multiple users to manage their daily activities through a streamlined web interface while demonstrating modern deployment and security practices.

## 🌟 Key Features
- **User Authentication**: Secure registration and login system with password hashing.
- **Multi-User Support**: Each user has a private, isolated task list.
- **Task Management**: Create, complete, and delete tasks with ease.
- **Report Generation**: Export a professional PDF summary of tasks using the FPDF library.
- **Security**: Hardened against SQL Injection using prepared statements.
- **Containerization**: Ready for deployment using Docker.

## 🛠️ Technology Stack
- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL
- **Report Library**: FPDF
- **DevOps**: Docker, Render (CI/CD Deployment)

## 📂 Project Structure
```text
ToDo-List-Project/
├── index.php (Main Dashboard)
├── login.php
├── register.php
├── logout.php
├── style.css
├── Report.php
├── clear_history.php
├── setup.php (Database Initialization)
├── setup_db.sql
├── Dockerfile
├── fpdf/ (Report Library)
└── Images/ (UI Assets)
```

## 🚀 Setup & Deployment

### 1. Database Initialization
1.  **Server Requirement**: Local (WAMP/XAMPP) or cloud-hosted MySQL server.
2.  **Configuration**: Set environment variables (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`) or update `db.php`.
3.  **Setup**: Run `setup.php` in your browser to automatically create necessary tables.

### 2. CI/CD Deployment (Render)
This project is configured for automated deployment:
1.  Connect this repository to your **Render** account.
2.  Add the necessary environment variables in the Render Dashboard.
3.  The platform will automatically build and deploy the application on every push to the main branch.

---
*Developed as part of the CI/CD Continuous Integration and Continuous Deployment Practical.*
