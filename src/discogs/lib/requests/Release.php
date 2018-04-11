<?php

namespace discogs\lib\requests;

use discogs\lib\Request;

class Release extends Request
{
    protected $requiredKeys = ['release_id'];

    public function __construct($params)
    {
        $this->uri = '/releases/{release_id}';
        $this->createUri($params);
    }
}
