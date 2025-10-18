<?php

namespace App\Models;

use App\Core\Model;

/**
 * Category Model
 * Handles blog category data
 */
class Category extends Model
{
    protected string $table = 'categories';
    protected array $fillable = [
        'name', 'slug', 'description', 'color', 'status'
    ];
    protected array $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Find category by slug
     */
    public function findBySlug(string $slug): ?array
    {
        return $this->firstWhere('slug', $slug);
    }

    /**
     * Get active categories
     */
    public function getActive(): array
    {
        return $this->where('status', 'active');
    }

    /**
     * Get categories with post count
     */
    public function getWithPostCount(): array
    {
        $sql = "SELECT c.*, COUNT(p.id) as post_count 
                FROM {$this->table} c 
                LEFT JOIN posts p ON c.id = p.category_id AND p.status = 'published'
                WHERE c.status = 'active'
                GROUP BY c.id 
                ORDER BY c.name";
        
        return $this->db->fetchAll($sql);
    }

    /**
     * Generate unique slug
     */
    public function generateSlug(string $name): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if slug exists
     */
    private function slugExists(string $slug): bool
    {
        return $this->countWhere('slug', $slug) > 0;
    }

    /**
     * Check if name exists
     */
    public function nameExists(string $name, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE name = ?";
        $params = [$name];

        if ($excludeId) {
            $sql .= " AND {$this->primaryKey} != ?";
            $params[] = $excludeId;
        }

        return $this->db->fetchColumn($sql, $params) > 0;
    }
}
