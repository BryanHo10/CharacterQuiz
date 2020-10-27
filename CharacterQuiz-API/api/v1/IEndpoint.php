<?php

interface IEndpoint {
    // Return the endpoint's response
    public function getResponse($reqType, $data);

    // Returns array of errors for implosion later on
    public function errors();

    // Returns status code
    public function getStatusCode();
}