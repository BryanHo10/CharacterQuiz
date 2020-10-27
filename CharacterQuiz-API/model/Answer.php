<?php

if (basename($_SERVER['PHP_SELF']) == 'Answer.php') {
    die('403 - Access Forbidden');
}

class Answer {
    private $db;

    public function __construct() {
        $this->db = new DB;
    }

    // Returns All Answers
    public function getAll() {
        $this->db->query("SELECT * FROM `answers`");
        $results = $this->db->resultSet();

        return $results;
    }

    // Return specific answer
    public function getByID($id) {
        $this->db->query("SELECT * FROM `answers` 
                          WHERE `id`=:answer_id
                        ");

        $this->db->bind(':answer_id', $id);
        $row = $this->db->single();

        return $row;
    }

    // Return all answers from a question
    public function getAllByQuestionID($id) {
        $this->db->query("SELECT * FROM `answers`
                          WHERE `question_id`=:question_id
                          ");
        $this->db->bind(':question_id', $id);
        $results = $this->db->resultSet();

        return $results;
    }

    // Store a answer
    // $data should be an array containing title, author_id
    public function store($data) {
        $this->db->query("INSERT INTO `answers` (
                            question_id, text, character_id
                            )
                            VALUES (
                            :question_id, :text, :character_id)
                            ");
        
        $this->db->bind(':question_id', $data['question_id']);
        $this->db->bind(':text', $data['text']);
        $this->db->bind(':character_id', $data['character_id']);

        // If the sql executed successfully, return true
        if ($this->db->execute()) {
            return true;
        }
    }
}