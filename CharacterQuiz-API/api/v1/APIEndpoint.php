<?php

require_once('IEndpoint.php');

abstract class APIEndpoint implements IEndpoint {
    protected $_errors = [];
    protected $statusCode = 200;
    protected $filters = [];

    abstract public function getResponse($reqType, $inputData);

    public function errors() {
        return $this->_errors;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function addError($error) {
        $this->statusCode = 400;
        array_push($this->_errors, $error);
    }

    protected function filterOutput($output) {
        if (is_array($output)) {
            foreach ($output as $o) {
                foreach ($this->filters as $filter) {
                    unset($o->$filter);
                }
            }
        } elseif ($output) {
            foreach ($this->filters as $filter) {
                unset($output->$filter);
            }
        }

        return $output;
    }
}