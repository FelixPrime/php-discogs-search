<?php

namespace discogs\lib\requests;

use discogs\lib\Request;

class AllLabelReleases extends Request
{
    protected $requiredKeys = ['label_id'];

    public function __construct($params)
    {
        $this->uri = '/labels/{label_id}/releases';
        $this->createUri($params);
    }
}
