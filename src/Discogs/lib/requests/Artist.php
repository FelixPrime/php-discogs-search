<?php

namespace discogs\lib\requests;

use discogs\lib\Request;

class Artist extends Request
{
    protected $requiredKeys = ['artist_id'];

    public function __construct($params)
    {
        $this->uri = '/artists/{artist_id}';
        $this->createUri($params);
    }
}
