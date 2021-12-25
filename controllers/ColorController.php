<?php

namespace Controllers;

use Models\Color;

class ColorController
{
    private $db;
    private $requestMethod;
    private $colorId;

    private $color;

    public function __construct($db, $requestMethod, $colorId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->colorId = $colorId;

        $this->color = new Color($this->db);
    }

    public function handleRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->colorId) {
                    $response = $this->show($this->colorId);
                } else {
                    $response = $this->index();
                };
                break;
            case 'POST':
                $response = $this->create();
                break;
            case 'DELETE':
                $response = $this->delete($this->colorId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        http_response_code($response['status_code']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function index()
    {
        $result = $this->color->findAll();
        $response['status_code'] = 200;
        $response['body'] = json_encode($result);
        return $response;
    }

    private function show($id)
    {
        $result = $this->color->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code'] = 200;
        $response['body'] = json_encode($result[0]);
        return $response;
    }

    private function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        if (!$this->validateColor($input)) {
            return $this->validationErrorResponse();
        }
        $this->color->insert($input);
        $response['status_code'] = 201;
        $response['body'] = json_encode([
            'message' => 'Color created.'
        ]);
        return $response;
    }

    private function delete($id)
    {
        $result = $this->color->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $this->color->delete($id);
        $response['status_code'] = 200;
        $response['body'] = json_encode([
            'message' => 'Color deleted.'
        ]);
        return $response;
    }

    private function validateColor($input)
    {
        if (!isset($input['name']) || empty(trim($input['name']))) {
            return false;
        }
        if (!isset($input['value']) || empty(trim($input['value']))) {
            return false;
        }
        return true;
    }

    private function validationErrorResponse()
    {
        $response['status_code'] = 400;
        $response['body'] = json_encode([
            'error' => 'Invalid input.'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code'] = 404;
        $response['body'] = json_encode([
            'error' => 'Color not found.'
        ]);
        return $response;
    }
}
