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
Blog/
├── public/
│   ├── index.php          # Main entry point
│   ├── .htaccess          # Apache URL rewriting
│   └── assets/            # CSS, JS, images
├── src/
│   └── Views/             # Simple PHP templates
├── database/
│   ├── migrations/        # SQL table creation
│   └── seeds/             # SQL sample data
└── railway.json           # Railway config
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