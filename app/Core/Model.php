<?php

namespace App\Core;

use PDO;

/**
 * Base Model with CRUD Query Builder functions
 */
abstract class Model {
    protected static string $table = '';

    /**
     * Retrieve active PDO DB connection
     */
    public static function getDb(): PDO {
        return Database::getConnection();
    }

    /**
     * Find a single record by ID
     */
    public static function find(int $id): ?array {
        $db = self::getDb();
        $table = static::$table;
        $stmt = $db->prepare("SELECT * FROM `$table` WHERE `id` = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Find a single record by dynamic slug
     */
    public static function findBySlug(string $slug): ?array {
        $db = self::getDb();
        $table = static::$table;
        $stmt = $db->prepare("SELECT * FROM `$table` WHERE `slug` = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Retrieve all records
     */
    public static function all(string $orderBy = 'id DESC'): array {
        $db = self::getDb();
        $table = static::$table;
        $stmt = $db->prepare("SELECT * FROM `$table` ORDER BY $orderBy");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Filter records matching a specific column criteria
     */
    public static function where(string $column, mixed $value, string $orderBy = 'id DESC'): array {
        $db = self::getDb();
        $table = static::$table;
        $stmt = $db->prepare("SELECT * FROM `$table` WHERE `$column` = :val ORDER BY $orderBy");
        $stmt->execute(['val' => $value]);
        return $stmt->fetchAll();
    }

    /**
     * Create / Insert a new record
     */
    public static function create(array $data): int {
        $db = self::getDb();
        $table = static::$table;

        $columns = implode(', ', array_map(fn($col) => "`$col`", array_keys($data)));
        $placeholders = implode(', ', array_map(fn($col) => ":$col", array_keys($data)));

        $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";
        $stmt = $db->prepare($sql);
        $stmt->execute($data);

        return (int)$db->lastInsertId();
    }

    /**
     * Update an existing record
     */
    public static function update(int $id, array $data): bool {
        $db = self::getDb();
        $table = static::$table;

        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= "`$key` = :$key, ";
        }
        $fields = rtrim($fields, ', ');

        $sql = "UPDATE `$table` SET $fields WHERE `id` = :id";
        $data['id'] = $id;

        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Delete a record by ID
     */
    public static function delete(int $id): bool {
        $db = self::getDb();
        $table = static::$table;
        $stmt = $db->prepare("DELETE FROM `$table` WHERE `id` = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Custom Raw Query Wrapper
     */
    public static function query(string $sql, array $params = []): array {
        $db = self::getDb();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
