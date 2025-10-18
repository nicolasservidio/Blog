<?php

namespace App\Core;

/**
 * Base Model Class
 * Provides common database operations for all models
 */
abstract class Model
{
    protected Database $db;
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $guarded = ['id', 'created_at', 'updated_at'];

    public function __construct()
    {
        $app = Application::getInstance();
        $this->db = $app->getDatabase();
    }

    /**
     * Find record by ID
     */
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    /**
     * Find all records
     */
    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Find records with conditions
     */
    public function where(string $column, mixed $value, string $operator = '='): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} ? ORDER BY {$this->primaryKey} DESC";
        return $this->db->fetchAll($sql, [$value]);
    }

    /**
     * Find first record with conditions
     */
    public function firstWhere(string $column, mixed $value, string $operator = '='): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} ? LIMIT 1";
        return $this->db->fetchOne($sql, [$value]);
    }

    /**
     * Create new record
     */
    public function create(array $data): int
    {
        $data = $this->filterFillable($data);
        $data = $this->addTimestamps($data, 'create');

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $this->db->query($sql, $data);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Update record by ID
     */
    public function update(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);
        $data = $this->addTimestamps($data, 'update');

        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "{$column} = :{$column}";
        }
        $setClause = implode(', ', $setClause);

        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :id";
        $data['id'] = $id;

        return $this->db->execute($sql, $data) > 0;
    }

    /**
     * Delete record by ID
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->execute($sql, [$id]) > 0;
    }

    /**
     * Count records
     */
    public function count(string $column = '*'): int
    {
        $sql = "SELECT COUNT({$column}) as count FROM {$this->table}";
        return (int) $this->db->fetchColumn($sql);
    }

    /**
     * Count records with conditions
     */
    public function countWhere(string $column, mixed $value, string $operator = '='): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE {$column} {$operator} ?";
        return (int) $this->db->fetchColumn($sql, [$value]);
    }

    /**
     * Paginate records
     */
    public function paginate(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC LIMIT {$perPage} OFFSET {$offset}";
        $records = $this->db->fetchAll($sql);
        $total = $this->count();

        return [
            'data' => $records,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage),
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total)
        ];
    }

    /**
     * Filter data to only include fillable fields
     */
    protected function filterFillable(array $data): array
    {
        if (empty($this->fillable)) {
            return array_diff_key($data, array_flip($this->guarded));
        }

        return array_intersect_key($data, array_flip($this->fillable));
    }

    /**
     * Add timestamps to data
     */
    protected function addTimestamps(array $data, string $type): array
    {
        $now = date('Y-m-d H:i:s');

        if ($type === 'create') {
            $data['created_at'] = $now;
        }

        $data['updated_at'] = $now;

        return $data;
    }

    /**
     * Execute raw SQL query
     */
    protected function query(string $sql, array $params = []): \PDOStatement
    {
        return $this->db->query($sql, $params);
    }

    /**
     * Begin database transaction
     */
    protected function beginTransaction(): bool
    {
        return $this->db->beginTransaction();
    }

    /**
     * Commit database transaction
     */
    protected function commit(): bool
    {
        return $this->db->commit();
    }

    /**
     * Rollback database transaction
     */
    protected function rollback(): bool
    {
        return $this->db->rollback();
    }
}
