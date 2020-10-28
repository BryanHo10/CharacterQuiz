<?php

if (basename($_SERVER['PHP_SELF']) == 'login.php') {
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
            case 'POST':
                // /login

                // Validate Email
                $email = $this->inputData->email;
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->addError('Invalid email format');
                }

                // Validate Password
                $password = $this->inputData->password;
                if (strlen($password) < 6 || strlen($password) > 25) {
                    $this->addError('Password must be between 6-25 characters');
                }
                
                $res = $this->user->verifyLogin($email, $password);
                if ($res) {
                    return array(
                        "status" => 200,
                        "id" => $res->id,
                    );
                }

                $this->addError('Login details incorrect');

                break;

            default:
                $this->addError('Invalid request type');
                break;
        }
    }

}
