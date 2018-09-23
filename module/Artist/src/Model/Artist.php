<?php

namespace Artist\Model;

class Artist
{
    public $id;
    public $name;
    public $bio;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->bio  = !empty($data['bio']) ? $data['bio'] : null;
    }
}