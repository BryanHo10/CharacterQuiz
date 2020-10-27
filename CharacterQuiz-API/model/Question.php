<?php

if (basename($_SERVER['PHP_SELF']) == 'Question.php') {
    die('403 - Access Forbidden');
}

class Question {
    private $db;

    public function __construct() {
        $this->db = new DB;
    }

    // Returns All Questions
    public function getAll() {
        $this->db->query("SELECT * FROM `questions`");
        $results = $this->db->resultSet();

        return $results;
    }

    // Return specific question
    public function getByID($id) {
        $this->db->query("SELECT * FROM `questions` 
                          WHERE `id`=:question_id
                        ");

        $this->db->bind(':question_id', $id);
        $row = $this->db->single();

        return $row;
    }

    // Return all questions from a quiz
    public function getAllByQuizID($id) {
        $this->db->query("SELECT * FROM `questions`
                          WHERE `quiz_id`=:quiz_id
                          ");
        $this->db->bind(':quiz_id', $id);
        $results = $this->db->resultSet();

        return $results;
    }

    // Store a question
    // $data should be an array containing title, author_id
    public function store($data) {
        $this->db->query("INSERT INTO `questions` (
                            quiz_id, `text`, position
                            )
                            VALUES (
                            :quiz_id, :text, :position)
                            ");
        
        $this->db->bind(':quiz_id', $data['quiz_id']);
        $this->db->bind(':text', $data['text']);
        $this->db->bind(':position', $data['position']);

        // If the sql executed successfully, return true
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
    }
}