<?php
/**
 * User Class
 * Handles user authentication and management
 */

require_once __DIR__ . '/../classes/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Register a new user
     */
    public function register($username, $email, $password) {
        // Check if username or email already exists
        $existing = $this->db->getRow('SELECT id FROM users WHERE username = ? OR email = ?', [$username, $email]);
        
        if ($existing) {
            return ['success' => false, 'message' => 'Username or email already exists'];
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ];

        try {
            $userId = $this->db->insert('users', $data);
            return ['success' => true, 'message' => 'Registration successful', 'user_id' => $userId];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()];
        }
    }

    /**
     * Login user
     */
    public function login($username, $password) {
        $user = $this->db->getRow('SELECT * FROM users WHERE username = ?', [$username]);

        if (!$user) {
            return ['success' => false, 'message' => 'User not found'];
        }

        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid password'];
        }

        return ['success' => true, 'message' => 'Login successful', 'user' => $user];
    }

    /**
     * Get user by ID
     */
    public function getById($id) {
        return $this->db->getRow('SELECT id, username, email, created_at FROM users WHERE id = ?', [$id]);
    }

    /**
     * Get user by username
     */
    public function getByUsername($username) {
        return $this->db->getRow('SELECT id, username, email, created_at FROM users WHERE username = ?', [$username]);
    }
}
?>
