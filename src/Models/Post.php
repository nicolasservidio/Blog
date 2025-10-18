<?php

namespace App\Models;

use App\Core\Model;

/**
 * Post Model
 * Handles blog post data
 */
class Post extends Model
{
    protected string $table = 'posts';
    protected array $fillable = [
        'title', 'slug', 'content', 'excerpt', 'featured_image', 
        'status', 'author_id', 'category_id', 'meta_title', 'meta_description'
    ];
    protected array $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Find post by slug
     */
    public function findBySlug(string $slug): ?array
    {
        return $this->firstWhere('slug', $slug);
    }

    /**
     * Get published posts
     */
    public function getPublished(): array
    {
        return $this->where('status', 'published');
    }

    /**
     * Get posts by category
     */
    public function getByCategory(int $categoryId): array
    {
        return $this->where('category_id', $categoryId);
    }

    /**
     * Get posts by author
     */
    public function getByAuthor(int $authorId): array
    {
        return $this->where('author_id', $authorId);
    }

    /**
     * Get posts with author and category info
     */
    public function getWithRelations(): array
    {
        $sql = "SELECT p.*, u.name as author_name, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN users u ON p.author_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
        
        return $this->db->fetchAll($sql);
    }

    /**
     * Get published posts with relations
     */
    public function getPublishedWithRelations(): array
    {
        $sql = "SELECT p.*, u.name as author_name, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN users u ON p.author_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.status = 'published'
                ORDER BY p.created_at DESC";
        
        return $this->db->fetchAll($sql);
    }

    /**
     * Get single post with relations
     */
    public function getWithRelationsById(int $id): ?array
    {
        $sql = "SELECT p.*, u.name as author_name, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN users u ON p.author_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ?";
        
        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * Search posts
     */
    public function search(string $query): array
    {
        $sql = "SELECT p.*, u.name as author_name, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN users u ON p.author_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE (p.title LIKE ? OR p.content LIKE ? OR p.excerpt LIKE ?)
                AND p.status = 'published'
                ORDER BY p.created_at DESC";
        
        $searchTerm = "%{$query}%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $searchTerm]);
    }

    /**
     * Get recent posts
     */
    public function getRecent(int $limit = 5): array
    {
        $sql = "SELECT p.*, u.name as author_name, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN users u ON p.author_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.status = 'published'
                ORDER BY p.created_at DESC 
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$limit]);
    }

    /**
     * Generate unique slug
     */
    public function generateSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
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
     * Get post statistics
     */
    public function getStats(): array
    {
        $total = $this->count();
        $published = $this->countWhere('status', 'published');
        $draft = $this->countWhere('status', 'draft');

        return [
            'total' => $total,
            'published' => $published,
            'draft' => $draft
        ];
    }
}
