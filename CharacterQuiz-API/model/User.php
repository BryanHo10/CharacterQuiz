<?php

if (basename($_SERVER['PHP_SELF']) == 'User.php') {
    die('403 - Access Forbidden');
}

class User {
    private $db;

    public function __construct() {
        $this->db = new DB;
    }

    // Returns All Users
    public function getAll() {
        $this->db->query("SELECT * FROM `users`");
        $results = $this->db->resultSet();

        return $results;
    }

    // Return specific user
    public function getByID($id) {
        $this->db->query("SELECT * FROM `users` 
                          WHERE `id`=:user_id
                        ");

        $this->db->bind(':user_id', $id);
        $row = $this->db->single();

        return $row;
    }

    // Return specific user by email
    public function getByEmail($email) {
        $this->db->query("SELECT * FROM `users` 
                          WHERE `email`=:email
                        ");

        $this->db->bind(':email', $email);
        $row = $this->db->single();

        return $row;
    }

    // Store a user
    // $data should be an array containing email, password, and nick
    public function store($data) {
        $this->db->query("INSERT INTO `users` (
                            email, password, nick
                            )
                            VALUES (
                            :email, :password, :nick)
                            ");
        
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT)); // Use bcrypt to hash the password
        $this->db->bind(':nick', $data['nick']);

        // If the sql executed successfully, return true
        if ($this->db->execute()) {
            return $this->getByEmail($data['email']);
        }
    }

    // Update a user
    // $data should be an array containing email, password, and nick
    public function update($data) {
        $this->db->query("UPDATE `users` WHERE `id`=:id (
                            email, password, nick
                            )
                            VALUES (
                            :email, :password, :nick)
                            ");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT)); // Use bcrypt to hash the password
        $this->db->bind(':nick', $data['nick']);

        // If the sql executed successfully, return true
        if ($this->db->execute()) {
            return true;
        }
    }


    // Verify login. If no return, then login failed.
    public function verifyLogin($email, $password) {
        $this->db->query("SELECT * FROM `users` 
                          WHERE `email`=:email
                        ");

        $this->db->bind(':email', $email);
        $row = $this->db->single();

        // Check if the passwords match (bcrypt) and return row
        if (password_verify($password, $row->password)) {
            return $row;
        }
    }

    public function checkUniqueNick($nick) {
        $this->db->query("SELECT `id` FROM `users`
                            WHERE `nick`=:nick
                        ");

        $this->db->bind(':nick', $nick);
        $row = $this->db->single();

        return $row ? false : true;
    }

    public function checkUniqueEmail($email) {
        $this->db->query("SELECT `id` FROM `users`
                            WHERE `email`=:email
                        ");

        $this->db->bind(':email', $email);
        $row = $this->db->single();
        
        return $row ? false : true;
    }
}