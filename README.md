# 📚 Blogin — A Modular PHP+MySQL Publishing System with MVC architecture

This is a simple, clean content management and plublishing system built with PHP, MySQL and Bootstrap. No PHP frameworks, no complex dependencies - just pure PHP that works with XAMPP and PaaS environments like Railway.

Blogin is a modular, expandable, and audit-friendly publishing system. It features a strict **MVC (Model-View-Controller) architecture** designed to clearly demonstrate MVC implementation and object-oriented programming in PHP. This makes it ideal for customization but also for learning. 

The system also includes comprehensive CSS and JavaScript assets equipped with collections of classified, reusable code blocks, allowing developers to radically reshape the appearance and behavior of Blogin, and effectively turning it into a custom-tailored solution. Thanks to its modular design and this rich front-end toolkit, Blogin serves as a flexible starting point for building other lightweight PHP applications.

Blogin supports role-based access control with clear permissions, secure user authentication with encryption, publishing, and category management - delivering simplicity, autonomy, and scalability out of the box.

## Features

- **Simple & Clean**: No frameworks, no complex dependencies
- **XAMPP Ready**: Works immediately with XAMPP
- **Railway Ready**: Deploys easily to Railway
- **Basic MVC**: Simple separation of concerns
- **Bootstrap UI**: Clean, responsive design
- **User Authentication**: Simple login system
- **Admin Dashboard**: Basic content management

### ✅ Post Management:

- Create, edit, publish, and archive posts
- Logical deletion (no physical removal)
- Markdown rendering via Parsedown
- Role-aware access (author/admin)

### ✅ Category Module

- List, create, and view categories
- Slug-based filtering of posts
- Color-coded Bootstrap cards
- Admin-only creation flo

### ✅ User System

- Login, registration, and profile
- Role-based navigation (Sr Administrator, user)
- Avatar and bio support

### ✅ Routing & Layout

- Centralized router in public/index.php
- Clean separation of views and actions
- Universal layout with header/footer
- Theme toggle and accessibility hooks

### ✅ Database Design

- Normalized schema with referential integrity
- ENUM-based status control
- Indexed slugs, timestamps, and foreign keys

## Technology Stack

- **Backend**: PHP 7.4+, MySQL 5.7+
- **Frontend**: HTML5, CSS3, Bootstrap 5
- **Database**: MySQL with simple PDO queries
- **Deployment**: XAMPP (local), Railway (production)

## Quick Start

### 1. XAMPP Setup
1. Place the project in `htdocs/proyectos/Blog/`
2. Create database `blog_db` in phpMyAdmin
3. Run SQL files from `database/migrations/` in order
4. Run SQL files from `database/seeds/` for sample data
5. Access: `http://localhost/proyectos/Blog/public/`

### 2. Railway Setup
1. Push to GitHub
2. Connect to Railway
3. Add MySQL database
4. Set environment variables for database
5. Deploy!

## Project Structure

```
blog-app/
│
├── public/                      # Entry point for Railway (index.php)
│   │
│   ├── assets/                  # Public static files
│   │   ├── css/
│   │   │   └── style.css
│   │   ├── js/
│   │   │   └── main.js
│   │   └── img/
│   │       └── logo.png
│   ├── index.php                # Main router or homepage
│   ├── test-db.php              # Test database connection
│   └── ...
│
├── src/
│   ├── utils/                   # Utilities
│   │   ├── Parserdown.php
│   │   ├── validateUser.php
│   │   └── ...
│   │ 
│   ├── controllers/             # Procedural and OOP controllers
│   │   ├── UserController.php
│   │   ├── CategoryController.php
│   │   ├── PostController.php
│   │   ├── LoginController.php
│   │   ├── RegisterController.php
│   │   ├── categories-store-action.php
│   │   ├── post-create-action.php
│   │   ├── post-delete-action.php
│   │   ├── post-update-action.php
│   │   └── ...
│   │ 
│   ├── views/                   # Views or Presentation Layer (HTML + embedded PHP)
│   │   ├── users/
│   │   │   ├── login.php
│   │   │   ├── logout.php
│   │   │   ├── profile.php
│   │   │   ├── register.php
│   │   │   └── ...
│   │   ├── categories/
│   │   │   ├── create.php
│   │   │   ├── index.php
│   │   │   ├── show.php
│   │   │   └── ...
│   │   ├── posts/
│   │   │   ├── create.php
│   │   │   ├── index.php
│   │   │   ├── post-edit.php
│   │   │   ├── show.php
│   │   │   └── ...
│   │   └── layout/              # Shared layout components
│   │       ├── footer.php
│   │       ├── header.php
│   │       ├── main.php
│   │       └── ...
│   └── models/                  # Main OOP classes 
│       ├── User.php
│       ├── Category.php
│       ├── Post.php
│       └── ...
│
├── config/                      # Configuration files
│   ├── conn.php                 # MySQL connection logic
│   ├── constants.php            # For detection of BASE_PATHs
│   └── ...
│
├── database/                    # DB structure and seed data
│   ├── migrations/
│   │   ├── 001_create_users_table.sql
│   │   ├── 002_create_categories_table.sql
│   │   ├── 003_create_posts_table.sql
│   │   └── ...
│   ├── seeds/
│   │   ├── 001_admin_user.sql
│   │   ├── 002_sample_categories.sql
│   │   └── ...
│   └── full database/
│       ├── blog_db.sql
│       └── ...
│
├── vendor/ 
│   ├── graham-campbell
│   ├── phpoption
│   ├── vlucas
│   └── ...
│
├── .dockerignore
├── .env.example
├── .gitignore
├── composer.json
├── Dockerfile
├── README.md                    # Project documentation
│
```

## Default Login
- **Email**: admin@blog.com
- **Password**: administrador

Other users:

- **Password**: 12345678
- **Emails**: 
    - rosa@blog.com
    - nicolas@blog.com
    - maria@blog.com
    - rosario@blog.com
    - augusto@blog.com

## Pages

- `/Profile` - Profile of the user with all his posts
- `/Posts` - All blog posts
- `/Categories` - All the categories of the blog
- `/Login` - Login form
- `/Register` - Sign up form

## Database Tables
- `users` - User accounts
- `categories` - Post categories  
- `posts` - Blog posts

That's it! Simple, clean, and works everywhere.
