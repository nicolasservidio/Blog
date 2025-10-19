# Simple PHP Blog System

A simple, clean blog system built with PHP and MySQL. No frameworks, no complex dependencies - just pure PHP that works with XAMPP and Railway.

## Features

- **Simple & Clean**: No frameworks, no complex dependencies
- **XAMPP Ready**: Works immediately with XAMPP
- **Railway Ready**: Deploys easily to Railway
- **Basic MVC**: Simple separation of concerns
- **Bootstrap UI**: Clean, responsive design
- **User Authentication**: Simple login system
- **Admin Dashboard**: Basic content management

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
├── public/                      # Entry point for Railway (index.php)
│   ├── index.php                # Main router or homepage
│   ├── assets/                  # Public static files
│   │   ├── css/
│   │   │   └── style.css
│   │   ├── js/
│   │   │   └── main.js
│   │   └── img/
│   │       └── logo.png
├── src/
│   ├── controllers/             # Procedural controllers
│   │   ├── UserController.php
│   │   ├── CategoryController.php
│   │   └── PostController.php
│   ├── views/                   # Views (HTML + embedded PHP)
│   │   ├── users/
│   │   │   ├── login.php
│   │   │   ├── register.php
│   │   │   └── profile.php
│   │   ├── categories/
│   │   │   ├── index.php
│   │   │   └── show.php
│   │   ├── posts/
│   │   │   ├── index.php
│   │   │   ├── show.php
│   │   │   └── create.php
│   │   └── layout/              # Shared layout components
│   │       ├── header.php
│   │       └── footer.php
│   └── models/                  # OOP classes only
│       ├── User.php
│       ├── Category.php
│       └── Post.php
├── config/                      # Configuration files
│   └── conn.php                 # MySQL connection logic
├── database/                    # DB structure and seed data
│   ├── migrations/
│   │   ├── 001_create_users_table.sql
│   │   ├── 002_create_categories_table.sql
│   │   └── 003_create_posts_table.sql
│   ├── seeds/
│   │   ├── 001_admin_user.sql
│   │   └── 002_sample_categories.sql
├── README.md                    # Project documentation
```

## Default Login
- **Email**: admin@blog.com
- **Password**: password

## Pages
- `/` - Home page with recent posts
- `/blog` - All blog posts
- `/login` - Login form
- `/admin` - Admin dashboard

## Database Tables
- `users` - User accounts
- `categories` - Post categories  
- `posts` - Blog posts

That's it! Simple, clean, and works everywhere.
