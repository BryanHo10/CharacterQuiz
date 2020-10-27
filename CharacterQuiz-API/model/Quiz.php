<?php

if (basename($_SERVER['PHP_SELF']) == 'Quiz.php') {
    die('403 - Access Forbidden');
}

class Quiz {
    private $db;

    public function __construct() {
        $this->db = new DB;
    }

    // Returns All Quizzes
    public function getAll() {
        $this->db->query("SELECT * FROM `quizzes`");
        $results = $this->db->resultSet();

        return $results;
    }

    // Return specific quiz
    public function getByID($id) {
        $this->db->query("SELECT * FROM `quizzes` 
                          WHERE `id`=:quiz_id
                        ");

        $this->db->bind(':quiz_id', $id);
        $row = $this->db->single();

        return $row;
    }

    // Store a quiz
    // $data should be an array containing title, author_id
    public function store($data) {
        $this->db->query("INSERT INTO `quizzes` (
                            title, author_id
                            )
                            VALUES (
                            :title, :author_id)
                            ");

        $this->db->bind(':title', $data['title']);
        $this->db->bind(':author_id', $data['author_id']);

        // If the sql executed successfully, return true
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
    }
}