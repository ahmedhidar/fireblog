# 🔥 FireBlog

FireBlog is a simple blogging platform built using **Native PHP** and **MySQLi**.  
The project focuses on core backend concepts such as authentication, authorization, role-based access, and content management without using any PHP frameworks.
the admin info you need to control the project
email : admin@admin.com
password : admin123
---

## 🚀 Features

### 👤 User System
- User registration and login system
- Newly registered users are marked as **Pending**
- Pending users **cannot log in or write posts** until approved by an admin
- Admin approval is required to activate users

### ✍️ Posts Management
- Authenticated users can create blog posts
- **Only the post author can edit or delete their own posts**
- Posts are visible after being created by approved users

### 🛠 Admin Dashboard
The admin dashboard contains **only two main sections**:
1. **Users**
   - View pending users
   - Approve or manage users
2. **Posts**
   - View and manage all posts

---
# 🔥 FireBlog

FireBlog is a simple blogging platform built using **Native PHP** and **MySQLi**.  
The project focuses on core backend concepts such as authentication, authorization, role-based access, and content management without using any PHP frameworks.

---

## 🚀 Features

### 👤 User System
- User registration and login system
- Newly registered users are marked as **Pending**
- Pending users **cannot log in or write posts** until approved by an admin
- Admin approval is required to activate users

### ✍️ Posts Management
- Authenticated users can create blog posts
- **Only the post author can edit or delete their own posts**
- Posts are visible after being created by approved users

### 🛠 Admin Dashboard
The admin dashboard contains **only two main sections**:
1. **Users**
   - View pending users
   - Approve or manage users
2. **Posts**
   - View and manage all posts

---

## 🧱 Project Structure
fireblog/
│
├── admin/ # Admin dashboard files
├── auth/ # Authentication (login, register)
├── Articles/ # Post creation & editing
├── database_creation/ # SQL file for database & tables
├── includes/
│ ├── config/ # Database connection
│ ├── models/ # Models (User, Post, etc.)
│ └── functions/ # Helper & utility functions
│
├── uploads
└── index.php # Main entry point

---

## 🗄 Database

- The database uses **MySQL**
- Connection is handled using **MySQLi**
- The SQL file for creating the database and tables can be found in:

database_creation/


### Setup Steps
1. Create a new database in MySQL
2. Import the SQL file from `database_creation`
3. Update database credentials in:
includes/config/Database.php


---

## 🔐 Roles & Permissions

| Role   | Permissions |
|------|-------------|
| Pending User | Cannot log in |
| User | Create posts, edit only their own posts |
| Admin | Approve users, manage all posts |

---

## 🧰 Technologies Used

- PHP (Native)
- MySQL
- MySQLi
- HTML
- CSS
- JavaScript (basic)

---

## 🎯 Purpose of the Project

This project was built to:
- Practice **backend fundamentals** using native PHP
- Understand authentication & authorization
- Apply role-based access control
- Work with MySQLi directly without ORM or frameworks

---

## 📌 Notes

- No frameworks (Laravel, Symfony, etc.) were used
- Focused on clean logic and backend structure
- Suitable for learning and small-scale blogging systems

---

## 👨‍💻 Author

**Ahmed Hidar**  
 Developer (PHP / Laravel)

---

## 📄 License

This project is open-source and available for learning and educational purposes.




