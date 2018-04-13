<?php

namespace discogs\lib;

class Request
{
    const DISCOGS_API_URL = 'https://api.discogs.com';

    protected $uri = '';
    protected $requiredKeys = [];

    public function exec()
    {
        $url = self::DISCOGS_API_URL . $this->uri;
        $responseData = $this->getData($url);

        $data = false;

        if (!empty($responseData['error'])) {
            $message = $responseData['error'];
        } else {
            $data = json_decode($responseData['data'], true);
            if ($responseData['status'] == 200) {
                $message = 'ok';
            } else {
                $message = isset($data['message'])?$data['message']:'';
            }
        }

        return [
            'data' => $data,
            'status' => $responseData['status'],
            'message' => $message,
            'date' => $responseData['date'],
            'exec_time' => $responseData['exec_time']
        ];
    }

    /**
    * Exec cUrl
    * @param string $url
    * @return array
    */
    private function getData($url)
    {
        $startTime = microtime(true);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'DiscogsAPIClient');

        $data = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        return [
            'data' => $data,
            'status' => $status,
            'error' => $error,
            'exec_time' => microtime(true) - $startTime,
            'date' => date('Y-m-d H:i:s')
        ];
    }

    protected function createUri($params)
    {
        //required params
        foreach ($this->requiredKeys as $key) {
            if (!isset($params[$key])) {
                throw new \Exception('Missing required key ' . $key);
            }
            $this->uri = str_replace('{' . $key . '}', $params[$key], $this->uri);
            unset($params[$key]);
        }
        unset($key);
        //additional params
        if (!empty($params)) {
            $this->uri .= '?';
            foreach ($params as $key => $val) {
                $this->uri .= $key . '=' . $val . '&';
            }
            $this->uri = trim($this->uri, '&');
        }
    }
}
