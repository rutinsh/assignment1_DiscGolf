<?php
/**
 * Service Class
 * Handles all CRUD operations for services
 */

require_once __DIR__ . '/../classes/Database.php';

class Service {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Create a new service
     */
    public function create($title, $desc, $img) {
        $data = [
            'title' => $title,
            'description' => $desc,
            'image' => $img
        ];
        return $this->db->insert('services', $data);
    }

    /**
     * Read all services
     */
    public function readAll() {
        return $this->db->getAll('SELECT * FROM services ORDER BY created_at DESC');
    }

    /**
     * Read single service by ID
     */
    public function readById($id) {
        return $this->db->getRow('SELECT * FROM services WHERE id = ?', [$id]);
    }

    /**
     * Search services by keyword
     */
    public function search($keyword) {
        $searchTerm = '%' . $keyword . '%';
        return $this->db->getAll(
            'SELECT * FROM services WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC',
            [$searchTerm, $searchTerm]
        );
    }

    /**
     * Update a service
     */
    public function update($id, $title, $desc, $img = null) {
        $data = [
            'title' => $title,
            'description' => $desc
        ];
        
        if ($img !== null) {
            $data['image'] = $img;
        }
        
        $this->db->update('services', $data, 'id = ?', [$id]);
    }

    /**
     * Delete a service
     */
    public function delete($id) {
        $this->db->delete('services', 'id = ?', [$id]);
    }

    /**
     * Count all services
     */
    public function count() {
        $result = $this->db->getRow('SELECT COUNT(*) as total FROM services');
        return $result['total'] ?? 0;
    }
}
?>
