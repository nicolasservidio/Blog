<?php

namespace App\Models;

use App\Core\Model;

/**
 * User Model
 * Handles user data and authentication
 */
class User extends Model
{
    protected string $table = 'users';
    protected array $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'bio', 'status'
    ];
    protected array $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?array
    {
        return $this->firstWhere('email', $email);
    }

    /**
     * Verify user password
     */
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Hash password
     */
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Create new user
     */
    public function createUser(array $data): int
    {
        // Hash password
        if (isset($data['password'])) {
            $data['password'] = $this->hashPassword($data['password']);
        }

        // Set default values
        $data['role'] = $data['role'] ?? 'user';
        $data['status'] = $data['status'] ?? 'active';

        return $this->create($data);
    }

    /**
     * Update user password
     */
    public function updatePassword(int $userId, string $newPassword): bool
    {
        $hashedPassword = $this->hashPassword($newPassword);
        return $this->update($userId, ['password' => $hashedPassword]);
    }

    /**
     * Get users by role
     */
    public function getByRole(string $role): array
    {
        return $this->where('role', $role);
    }

    /**
     * Get active users
     */
    public function getActive(): array
    {
        return $this->where('status', 'active');
    }

    /**
     * Check if email exists
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND {$this->primaryKey} != ?";
            $params[] = $excludeId;
        }

        return $this->db->fetchColumn($sql, $params) > 0;
    }

    /**
     * Search users
     */
    public function search(string $query): array
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE name LIKE ? OR email LIKE ? 
                ORDER BY {$this->primaryKey} DESC";
        
        $searchTerm = "%{$query}%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm]);
    }

    /**
     * Get user statistics
     */
    public function getStats(): array
    {
        $total = $this->count();
        $active = $this->countWhere('status', 'active');
        $admins = $this->countWhere('role', 'admin');
        $users = $this->countWhere('role', 'user');

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $total - $active,
            'admins' => $admins,
            'users' => $users
        ];
    }
}
