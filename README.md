# Article Management & Data Visualization Web Application

A PHP-based web application designed to display dynamic data/information to users while providing a complete Content Management (CRUD) system to update and maintain the content whenever necessary.

---

## 🛠️ Key Features

- **Data Display (Frontend)**: Presents visual data and article content to end-users (`tampilandatajkt.php` & `index.php`).
- **Article Management (CRUD)**:
  - **Add Article**: Publish new content or articles (`Tambahartikel.php`).
  - **Article Table/List**: View and search all existing articles (`Tabelartikel.php`).
  - **Edit Article**: Update and edit existing article details (`Editartikel.php`).
  - **Delete Article**: Remove outdated or unnecessary articles (`Deleteartikel.php`).
- **CRUD Dashboard & Processing**: Module landing page and core data processing logic (`crudintro.php` & `cruddata.php`).

---

## 💻 Tech Stack

- **PHP** (Server-side scripting & CRUD business logic)
- **HTML5 & CSS3** (Custom user interface styling via `cssintro.css` and `gayacrd.css`)

---

## 📁 Repository File Structure

```text
.
├── index.php             # Main landing page
├── tampilandatajkt.php   # Main data display page (e.g., Jakarta data/articles)
├── Tabelartikel.php      # Admin overview table for managing articles
├── Tambahartikel.php     # Form interface for creating new articles
├── Editartikel.php       # Form interface and processing for editing articles
├── Deleteartikel.php     # Script for handling article deletion
├── crudintro.php         # Introductory dashboard for the CRUD module
├── cruddata.php          # Core data management processor
├── cssintro.css          # CSS styles for the intro/landing page
├── gayacrd.css           # CSS styles for the CRUD interfaces
└── README.md             # Project documentation
