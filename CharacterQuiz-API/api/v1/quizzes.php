<?php

if (basename($_SERVER['PHP_SELF']) == 'quizzes.php') {
    die('403 - Access Forbidden');
}

require_once 'APIEndpoint.php';

/**
 * Quizzes
 *
 * GET /quizzes - Show All Quizzes
 * POST /quizzes - Register a quiz
 *  - email
 *  - password (plain text)
 *  - nick
 * GET /quizzes/{id} - Show a single quiz
 * POST /quizzes/{id}/edit - Edit a quiz
 */

class Endpoint extends APIEndpoint
{
    protected $filters = [];

    public function getResponse($reqType, $inputData)
    {
        $this->inputData = $inputData;
        $this->character = new Character;
        $this->characters = array();

        $this->quiz = new Quiz;
        $this->question = new Question;
        $this->answer = new Answer;
        $this->user = new User;

        switch ($reqType) {
            case 'GET':

                // /quizzes
                if (!isset($_GET['id'])) {
                    $result = $this->index();

                    // /quizzes/{id}
                } elseif (isset($_GET['id'])) {
                    $result = $this->show($_GET['id']);
                }

                break;

            case 'POST':
                // /quizzes - Create quiz
                if (!isset($_GET['id'])) {
                    $result = $this->store();
                }

                break;

            case 'PUT':
                parse_str(file_get_contents('php://input'), $_PUT);
                // /quizzes/{id} - Edit quiz
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
        $results = $this->quiz->getAll();
        $characterIds = array();

        foreach ($results as $quiz) {
            $author = $this->user->getByID($this->inputData->author_id);

            // Populate questions
            $quiz->questions = $this->question->getAllByQuizID($quiz->id);

            // Populate answers
            foreach ($quiz->questions as $question) {
                $question->answers = $this->answer->getAllByQuestionID($question->id);

                foreach ($question->answers as $answer) {
                    if (!in_array($answer->character_id, $characterIds)) {
                        array_push($characterIds, $answer->character_id);
                    }
                }
            }

            // Populate characters
            $quiz->characters = array();
            foreach ($characterIds as $cid) {
                array_push($quiz->characters, $this->character->getByID($cid));
            }

            $quiz->author = array(
                'id' => $author->id,
                'nick' => $author->nick,
            );
        }

        return $results;
    }

    public function show($id)
    {
        $result = $this->quiz->getById($id);
        if (!$result) {
            $this->addError('Could not find quiz');
        }

        $author = $this->user->getByID($this->inputData->author_id);

        // Populate questions
        $result->questions = $this->question->getAllByQuizID($result->id);

        // Populate answers
        foreach ($result->questions as $question) {
            $question->answers = $this->answer->getAllByQuestionID($question->id);

            foreach ($question->answers as $answer) {
                if (!in_array($answer->character_id, $characterIds)) {
                    array_push($characterIds, $answer->character_id);
                }
            }
        }

        // Populate characters
        $result->characters = array();
        foreach ($characterIds as $cid) {
            array_push($result->characters, $this->character->getByID($cid));
        }

        $result->author = array(
            'id' => $author->id,
            'nick' => $author->nick,
        );

        return $result;
    }

    public function edit()
    {
        $this->validateFields(['id', 'email', 'password', 'nick']);

        // Return if there are errors
        if (!empty($this->_errors)) {
            return;
        }

        $data = array(
            'id' => $this->inputData->id,
            'email' => $this->inputData->email,
            'password' => $this->inputData->password,
            'nick' => $this->inputData->nick,
        );

        $res = $this->quiz->update($data);
        if ($res) {
            $result = array(
                'message' => 'Success!',
            );

            return $result;
        }

        $this->addError('Some error happened! Try again later');
    }

    public function store()
    {
        $this->validateFields(['title', 'characters', 'questions']);

        // Return if there are errors
        if (!empty($this->_errors)) {
            return;
        }

        $data = array(
            'title' => $this->inputData->title,
            'author_id' => $this->inputData->author_id,
        );

        $res = $this->quiz->store($data);
        if (!$res) {
            $this->addError('Problem storing quiz');
            return;
        }

        $result = array(
            'status' => 200,
            'id' => $res,
            'title' => $this->inputData->title,
            'characters' => array(),
            'questions' => array(),
        );

        $this->characterMap = array();

        // Go through characters
        foreach ($this->characters as $character) {
            $data = array(
                'name' => $character,
            );

            $res = $this->character->store($data);
            if (!$res) {
                $this->addError('Problem storing character: ' . $character);
                return;
            }

            array_push($result['characters'], array(
                'id' => $res,
                'name' => $character,
            ));

            $this->characterMap[$character] = $res;

        }

        // Go through questions
        foreach ($this->inputData->questions as $question) {
            $data = array(
                'quiz_id' => $result['id'],
                'text' => $question->text,
                'position' => $question->position,
                'answers' => array(),
            );

            $res = $this->question->store($data);
            if (!$res) {
                $this->addError('Problem storing question: ' . $question->text);
                return;
            }

            $pending = array();
            $question_id = $res;
            $data['id'] = $question_id;

            // Go through answers
            foreach ($question->answers as $answer) {
                $answerData = array(
                    'question_id' => $question_id,
                    'text' => $answer->text,
                    'character_id' => $this->characterMap[$answer->character],
                );

                $res = $this->answer->store($answerData);
                if (!$res) {
                    $this->addError('Problem storing answer: ' . $answer->text);
                    return;
                }

                $pending['question_id'] = $answerData['question_id'];
                $pending['text'] = $answerData['text'];
                $pending['character_id'] = $answerData['character_id'];
                array_push($data['answers'], $pending);
            }

            array_push($result['questions'], $data);
        }

        $author = $this->user->getByID($this->inputData->author_id);
        $result['author'] = array(
            'id' => $author->id,
            'nick' => $author->nick,
        );

        return $result;
    }

    private function validateFields($fields)
    {
        // Valdiate fields
        $missing = check_params($fields, $this->inputData);

        // Check if params are present
        if (!empty($missing)) {
            $this->addError('Missing the following fields: ' . implode(', ', $missing));
        }

        // Validate title
        $title = $this->inputData->title;
        if (strlen($title) < 4 || strlen($title) > 20) {
            $this->addError('Title must be between 4-20 characters');
        }

        // Validate characters
        $characters = $this->inputData->characters;
        foreach ($characters as $character) {
            if (in_array($character, $this->characters)) {
                $this->addError('Duplicate character: ' . $character);
            } else if (strlen($character) < 6 || strlen($character) > 25) {
                $this->addError('Character name must be between 6-25 characters');
            } else {
                // Map character
                array_push($this->characters, $character);
            }
        }
    }
}
