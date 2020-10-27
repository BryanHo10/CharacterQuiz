<?php

if (basename($_SERVER['PHP_SELF']) == 'characters.php') {
    die('403 - Access Forbidden');
}

require_once 'APIEndpoint.php';

/**
 * Characters
 *
 * GET /characters - Show All Characters
 * POST /characters - Register a character
 *  - email
 *  - password (plain text)
 *  - nick
 * GET /characters/{id} - Show a single character
 * POST /characters/{id}/edit - Edit a character
 */

class Endpoint extends APIEndpoint
{
    protected $filters = [];

    public function getResponse($reqType, $inputData)
    {
        $this->inputData = $inputData;
        $this->character = new Character;

        switch ($reqType) {

            case 'GET':

                // /characters
                if (!isset($_GET['id'])) {
                    $result = $this->index();
                    
                // /characters/{id}
                } elseif (isset($_GET['id'])) {
                    $result = $this->show($_GET['id']);
                }
                break;

            case 'POST':
                // /characters - Create character
                if (!isset($_GET['id'])) {
                    $result = $this->store();
                }

                // /characters/{id}/edit
                elseif (isset($_GET['id']) && isset($_GET['edit']) && $_GET['edit'] == '1') {
                    $result = $this->update();
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
        $results = $this->character->getAll();

        return $results;
    }

    public function show($id)
    {
        $result = $this->character->getById($id);
        if (!$result) {
            $this->addError('Could not find character');
        }

        return $result;
    }

    public function edit() {
        $this->addError('Not supported yet.');
    }

    public function store() {
        // Valdiate fields
        $missing = check_params(['name'], $_POST);

        // Check if params are present
        if (!empty($missing)) {
            $this->addError('Missing the following fields: ' . implode(', ', $missing));

            return false;
        }

        // Validate Name
        $name = $_POST['name'];
        if (strlen($name) < 4 || strlen($name) > 25) {
            $this->addError('Name must be between 4-25 characters');
        }
        
        // Return if there are errors
        if (!empty($this->_errors))
            return;

        $data = array(
            'name' => $name,
        );

        $res = $this->character->store($data);
        if ($res) {
            $result = array(
                'message' => 'Success!',
            );

            return $result;
        }

        $this->addError('Some error happened! Try again later.');
    }
}