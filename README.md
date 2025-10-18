# Professional PHP Blog System

A modern, professional blog system built with PHP 8+ and MySQL, featuring MVC architecture, object-oriented programming, and designed for Railway deployment.

## Features

- **MVC Architecture**: Clean separation of concerns with Models, Views, and Controllers
- **Object-Oriented Design**: Modern PHP with classes, inheritance, and encapsulation
- **User Authentication**: Secure login/registration system with password hashing
- **Blog Management**: Full CRUD operations for posts and categories
- **Admin Dashboard**: Complete admin panel for content management
- **Responsive Design**: Modern, mobile-first UI with Bootstrap 5
- **Security Features**: CSRF protection, XSS prevention, input validation
- **Railway Ready**: Optimized for deployment on Railway platform

## Technology Stack

- **Backend**: PHP 8.0+, MySQL 8.0+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Bootstrap 5
- **Architecture**: MVC Pattern, Object-Oriented Programming
- **Security**: Password hashing, CSRF tokens, input validation
- **Deployment**: Railway, Docker-ready

## Installation

### Local Development

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Blog
   ```

2. **No dependencies to install**
   The project uses only PHP built-in functions.

3. **Environment setup**
   ```bash
   cp env.example .env
   ```
   Edit `.env` file with your database credentials:
   ```env
   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=blog_db
   DB_USER=root
   DB_PASS=your_password
   ```

4. **Database setup**
   - Create a MySQL database named `blog_db`
   - Run the migration files in `database/migrations/` in order
   - Run the seed files in `database/seeds/` to populate sample data

5. **Web server setup**
   - Point your web server document root to the `public` directory
   - For Apache, the included `.htaccess` file will handle URL rewriting
   - For development, you can use PHP's built-in server:
     ```bash
     php -S localhost:8000 -t public
     ```

### Railway Deployment

1. **Connect to Railway**
   - Push your code to a Git repository
   - Connect the repository to Railway
   - Railway will automatically detect the PHP application

2. **Environment variables**
   Set the following environment variables in Railway:
   ```
   DB_HOST=your_mysql_host
   DB_PORT=3306
   DB_NAME=your_database_name
   DB_USER=your_username
   DB_PASS=your_password
   APP_URL=https://your-app.railway.app
   APP_ENV=production
   APP_DEBUG=false
   ```

3. **Database setup**
   - Create a MySQL database on Railway or use an external service
   - Run the migration files to create tables
   - Run the seed files to populate initial data

## Project Structure

```
Blog/
├── public/                 # Web root directory
│   ├── index.php          # Application entry point
│   ├── .htaccess          # Apache configuration
│   └── assets/            # Static assets (CSS, JS, images)
├── src/                   # Application source code
│   ├── Core/              # Core framework classes
│   │   ├── Application.php
│   │   ├── Config.php
│   │   ├── Database.php
│   │   ├── Router.php
│   │   ├── Controller.php
│   │   └── Model.php
│   ├── Controllers/       # Application controllers
│   ├── Models/            # Data models
│   ├── Views/             # View templates
│   ├── Middleware/        # Middleware classes
│   └── routes/            # Route definitions
├── database/              # Database files
│   ├── migrations/        # Database migrations
│   └── seeds/             # Database seeders
├── config/                # Configuration files
├── env                    # Environment configuration
├── railway.json           # Railway configuration
├── nixpacks.toml          # Nixpacks configuration
└── README.md              # This file
```

## Usage

### Default Admin Account
- **Email**: admin@blog.com
- **Password**: password

### Creating Content

1. **Login** to the admin panel at `/admin`
2. **Create Categories** for organizing posts
3. **Create Posts** with rich content and featured images
4. **Manage Users** and their permissions

### API Endpoints

The system provides RESTful endpoints for all operations:

- `GET /` - Home page
- `GET /blog` - Blog listing
- `GET /blog/{slug}` - Single post
- `GET /category/{slug}` - Posts by category
- `GET /login` - Login form
- `POST /login` - Login action
- `GET /register` - Registration form
- `POST /register` - Registration action
- `POST /logout` - Logout action

## Security Features

- **Password Hashing**: Uses PHP's `password_hash()` with secure defaults
- **CSRF Protection**: All forms include CSRF tokens
- **Input Validation**: Server-side validation for all user inputs
- **XSS Prevention**: Output escaping in all templates
- **SQL Injection Prevention**: Prepared statements for all database queries
- **Session Security**: Secure session configuration

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please open an issue on the GitHub repository.