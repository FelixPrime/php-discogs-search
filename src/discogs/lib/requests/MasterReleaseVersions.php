<?php

namespace discogs\lib\requests;

use discogs\lib\Request;

class MasterReleaseVersions extends Request
{
    protected $requiredKeys = ['master_id'];

    public function __construct($params)
    {
        $this->uri = '/masters/{master_id}/versions';
        $this->createUri($params);
    }
}
