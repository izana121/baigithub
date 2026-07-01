<?php
/**
 * Lớp Model cơ sở
 * Tất cả các model phải kế thừa lớp này
 */
class Model {
    protected $db;
    protected $conn;
    protected $table;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Tìm tất cả bản ghi
     */
    public function findAll($orderBy = 'id DESC', $limit = null, $offset = null) {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        
        if ($limit !== null) {
            $sql .= " LIMIT " . intval($limit);
            if ($offset !== null) {
                $sql .= " OFFSET " . intval($offset);
            }
        }
        
        $result = $this->conn->query($sql);
        $data = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }
    
    /**
     * Tìm bản ghi theo ID
     */
    public function findById($id) {
        $id = intval($id);
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id}";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Tìm bản ghi theo điều kiện
     */
    public function findWhere($conditions, $orderBy = 'id DESC') {
        $where = [];
        foreach ($conditions as $key => $value) {
            $value = $this->conn->real_escape_string($value);
            $where[] = "{$key} = '{$value}'";
        }
        
        $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $where) . " ORDER BY {$orderBy}";
        $result = $this->conn->query($sql);
        $data = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }
    
    /**
     * Count all records
     */
    public function count($conditions = []) {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $value = $this->conn->real_escape_string($value);
                $where[] = "{$key} = '{$value}'";
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        $result = $this->conn->query($sql);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return intval($row['total']);
        }
        
        return 0;
    }
    
    /**
     * Insert new record
     */
    public function insert($data) {
        $keys = array_keys($data);
        $values = array_map(function($v) {
            return "'" . $this->conn->real_escape_string($v) . "'";
        }, array_values($data));
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ")";
        
        if ($this->conn->query($sql)) {
            return $this->conn->insert_id;
        }
        
        return false;
    }
    
    /**
     * Update record
     */
    public function update($id, $data) {
        $set = [];
        foreach ($data as $key => $value) {
            $value = $this->conn->real_escape_string($value);
            $set[] = "{$key} = '{$value}'";
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE id = " . intval($id);
        
        return $this->conn->query($sql);
    }
    
    /**
     * Delete record
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = " . intval($id);
        return $this->conn->query($sql);
    }
    
    /**
     * Execute raw query
     */
    public function query($sql) {
        return $this->conn->query($sql);
    }
    
    /**
     * Get last error
     */
    public function getError() {
        return $this->conn->error;
    }
}
?>
