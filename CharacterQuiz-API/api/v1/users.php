<?php

if (basename($_SERVER['PHP_SELF']) == 'users.php') {
    die('403 - Access Forbidden');
}

require_once 'APIEndpoint.php';

/**
 * Users
 *
 * GET /users - Show All Users
 * POST /users - Register a user
 *  - email
 *  - password (plain text)
 *  - nick
 * GET /users/{id} - Show a single user
 * POST /users/{id}/edit - Edit a user
 */

class Endpoint extends APIEndpoint
{
    protected $filters = ['email', 'password'];

    public function getResponse($reqType, $inputData)
    {
        $this->inputData = $inputData;
        $this->user = new User;

        switch ($reqType) {
            case 'GET':

                // /users
                if (!isset($_GET['id'])) {
                    $result = $this->index();
                    
                // /users/{id}
                } elseif (isset($_GET['id'])) {
                    $result = $this->show($_GET['id']);
                }
                break;

            case 'POST':
                // /users - Create user
                if (!isset($_GET['id'])) {
                    $result = $this->store();
                }

                break;

            case 'PUT':
                parse_str(file_get_contents('php://input'), $_PUT);
                // /users/{id} - Edit user
                if (isset($_GET['id'])) {
                    
                    $result = $this->edit($_PUT);
                }

                break;

            default:
                $this->addError('Invalid request type');
                break;
        }

        return $this->filterOutput($result);
    }

    public function index()
    {
        $results = $this->user->getAll();

        return $results;
    }

    public function show($id)
    {
        $result = $this->user->getById($id);
        if (!$result) {
            $this->addError('Could not find user');
        }

        return $result;
    }

    public function edit() {
        $this->validateFields(['id', 'email', 'password', 'nick']);
        
        // Return if there are errors
        if (!empty($this->_errors))
            return;
            
        $data = array(
            'id' => $this->inputData->id,
            'email' => $this->inputData->email,
            'password' => $this->inputData->password,
            'nick' => $this->inputData->nick,
        );

        $res = $this->user->update($data);
        if ($res) {
            $result = array(
                'message' => 'Success!',
            );

            return $result;
        }

        $this->addError('Some error happened! Try again later');
    }

    public function store() {
        $this->validateFields(['email', 'password', 'password_confirm', 'nick']);

        // Return if there are errors
        if (!empty($this->_errors))
            return;

        $data = array(
            'email' => $this->inputData->email,
            'password' => $this->inputData->password,
            'nick' => $this->inputData->nick,
        );

        $res = $this->user->store($data);
        if ($res) {
            $result = array(
                'status' => 200,
                'id' => $res->id,
            );

            return $result;
        }

        $this->addError('Some error happened! Try again later.');
    }

    private function validateFields($fields) {
        // Valdiate fields
        $missing = check_params($fields, $this->inputData);

        // Check if params are present
        if (!empty($missing)) {
            $this->addError('Missing the following fields: ' . implode(', ', $missing));
        }

        // Validate Email
        $email = $this->inputData->email;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('Invalid email format');
        }

        if (!$this->user->checkUniqueEmail($email)) {
            $this->addError('Email is already in use');
        }

        // Validate Nick
        $nick = $this->inputData->nick;
        if (strlen($nick) < 4 || strlen($nick) > 12) {
            $this->addError('Nick must be between 4-12 characters');
        }

        if (!$this->user->checkUniqueNick($nick)) {
            $this->addError('Nick is already in use');
        }

        // Validate Password
        $password = $this->inputData->password;
        if (strlen($password) < 6 || strlen($password) > 25) {
            $this->addError('Password must be between 6-25 characters');
        }

        if (isset($this->inputData->password_confirm) && $this->inputData->password_confirm != $this->inputData->password) {
            $this->addError('Passwords must match');
        }
    }
}