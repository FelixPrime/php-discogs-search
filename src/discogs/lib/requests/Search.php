<?php

namespace discogs\lib\requests;

use discogs\lib\Request;

class Search extends Request
{

    public function __construct($params)
    {
        $this->uri = '/database/search';
        $this->createUri($params);
    }
}
