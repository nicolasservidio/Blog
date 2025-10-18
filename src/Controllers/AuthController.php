<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

/**
 * Authentication Controller
 * Handles user login, registration, and logout
 */
class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Show login form
     */
    public function showLogin(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/admin');
        }

        $this->view('auth/login', [
            'title' => 'Login',
            'csrf_token' => $this->csrfToken()
        ]);
    }

    /**
     * Handle login
     */
    public function login(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/login');
        }

        if (!$this->validateCsrf()) {
            $this->flash('error', 'Invalid CSRF token');
            $this->redirect('/login');
        }

        $email = $this->input('email');
        $password = $this->input('password');

        // Validate input
        if (empty($email) || empty($password)) {
            $this->flash('error', 'Email and password are required');
            $this->redirect('/login');
        }

        // Find user
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            $this->flash('error', 'Invalid credentials');
            $this->redirect('/login');
        }

        // Verify password
        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            $this->flash('error', 'Invalid credentials');
            $this->redirect('/login');
        }

        // Check if user is active
        if ($user['status'] !== 'active') {
            $this->flash('error', 'Account is not active');
            $this->redirect('/login');
        }

        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];

        $this->flash('success', 'Welcome back, ' . $user['name'] . '!');
        $this->redirect('/admin');
    }

    /**
     * Show registration form
     */
    public function showRegister(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/admin');
        }

        $this->view('auth/register', [
            'title' => 'Register',
            'csrf_token' => $this->csrfToken()
        ]);
    }

    /**
     * Handle registration
     */
    public function register(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/register');
        }

        if (!$this->validateCsrf()) {
            $this->flash('error', 'Invalid CSRF token');
            $this->redirect('/register');
        }

        $name = trim($this->input('name'));
        $email = trim($this->input('email'));
        $password = $this->input('password');
        $confirmPassword = $this->input('confirm_password');

        // Validate input
        $errors = $this->validateRegistration($name, $email, $password, $confirmPassword);
        
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->flash('error', $error);
            }
            $this->redirect('/register');
        }

        // Check if email already exists
        if ($this->userModel->emailExists($email)) {
            $this->flash('error', 'Email already exists');
            $this->redirect('/register');
        }

        // Create user
        try {
            $userId = $this->userModel->createUser([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => 'user'
            ]);

            // Auto-login after registration
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = 'user';

            $this->flash('success', 'Account created successfully!');
            $this->redirect('/admin');
        } catch (\Exception $e) {
            $this->flash('error', 'Registration failed. Please try again.');
            $this->redirect('/register');
        }
    }

    /**
     * Handle logout
     */
    public function logout(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/');
        }

        if (!$this->validateCsrf()) {
            $this->flash('error', 'Invalid CSRF token');
            $this->redirect('/');
        }

        // Destroy session
        session_destroy();
        
        $this->flash('success', 'You have been logged out successfully.');
        $this->redirect('/');
    }

    /**
     * Validate registration data
     */
    private function validateRegistration(string $name, string $email, string $password, string $confirmPassword): array
    {
        $errors = [];

        if (empty($name) || strlen($name) < 2) {
            $errors[] = 'Name must be at least 2 characters long';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address';
        }

        if (empty($password) || strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }

        return $errors;
    }
}
