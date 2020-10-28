<?php

if (basename($_SERVER['PHP_SELF']) == 'Character.php') {
    die('403 - Access Forbidden');
}

class Character {
    private $db;

    public function __construct() {
        $this->db = new DB;
    }

    // Returns All Characters
    public function getAll() {
        $this->db->query("SELECT * FROM `characters`");
        $results = $this->db->resultSet();

        return $results;
    }

    // Return specific character
    public function getByID($id) {
        $this->db->query("SELECT * FROM `characters` 
                          WHERE `id`=:character_id
                        ");

        $this->db->bind(':character_id', $id);
        $row = $this->db->single();

        return $row;
    }

    // Store a character
    // $data should be an array containing title, author_id
    public function store($data) {
        $this->db->query("INSERT INTO `characters` (
                            name
                            )
                            VALUES (
                            :name)
                            ");
        
        $this->db->bind(':name', $data['name']);

        // If the sql executed successfully, return true
        $res = $this->db->execute();
        if ($res) {
            return $this->db->lastInsertId();
        }
    }
}