<?php

namespace discogs\lib;

final class RequestFactory
{

    public static function build($requestName, $params = [])
    {
        $requestClass = '\\discogs\\lib\requests\\' . ucfirst($requestName);
        $request = new $requestClass($params);

        return $request;
    }

    private function __construct()
    {
        //only static function create()
    }
}
