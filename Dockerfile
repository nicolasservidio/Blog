# 🐘 Use the official PHP 8.2 CLI image as the base
FROM php:8.2-cli

# 🧪 Install the mysqli extension for MySQL connectivity (required for mysqli_connect() in Railway)
RUN docker-php-ext-install mysqli

# 📁 Set the working directory inside the container to /app
WORKDIR /app

# 📦 Copy all files from your project into the container's /app directory
COPY . .

# 🚪 Expose port 8080 so Railway can route traffic to your app (this is the port used in Railway for the app)
EXPOSE 8080

# 🚀 Start the built-in PHP server, serving files from the public/ folder
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]