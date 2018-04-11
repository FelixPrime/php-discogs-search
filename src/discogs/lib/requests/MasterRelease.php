<?php

namespace discogs\lib\requests;

use discogs\lib\Request;

class MasterRelease extends Request
{
    protected $requiredKeys = ['master_id'];

    public function __construct($params)
    {
        $this->uri = '/masters/{master_id}';
        $this->createUri($params);
    }
}
