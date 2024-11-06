<?php

namespace Controller\Data;

class Data
{
    public array $data;

    public function __construct()
    {
        $this->data = $_POST;
    }

    public function getPost(): array
    {
        return $data = $this->data;
    }
}