<?php
/**
 * Database Class
 * Encapsulates all database connection logic using OOP
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'webdev_project';
    private $user = 'root';
    private $pass = '';
    private $pdo;

    /**
     * Constructor - Establish database connection
     */
    public function __construct() {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8mb4',
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die('Database Connection Error: ' . $e->getMessage());
        }
    }

    /**
     * Get PDO instance
     */
    public function getPDO() {
        return $this->pdo;
    }

    /**
     * Execute a query with parameters
     */
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Get single row
     */
    public function getRow($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Get all rows
     */
    public function getAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Insert data
     */
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->query($sql, array_values($data));
        return $this->pdo->lastInsertId();
    }

    /**
     * Update data
     */
    public function update($table, $data, $where, $whereParams = []) {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
        }
        $setString = implode(', ', $set);
        
        $sql = "UPDATE $table SET $setString WHERE $where";
        $params = array_merge(array_values($data), $whereParams);
        $this->query($sql, $params);
    }

    /**
     * Delete data
     */
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM $table WHERE $where";
        $this->query($sql, $params);
    }
}
?>
