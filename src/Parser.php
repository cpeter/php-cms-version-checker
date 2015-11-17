<?php

namespace Cpeter\PhpCmsVersionChecker;

use Cpeter\PhpCmsVersionChecker\Exception\EmptyUrlException;
use GuzzleHttp\Exception\RequestException;

class Parser {
    public function parse($cms, $cms_options){
        $url = $cms_options['version_page'];
        if (empty($url)) {
            throw new EmptyUrlException("URL must be set for '$cms'. We can not parse empty url.");
        }
        
        $regexp = $cms_options['regexp'];
        
        // fetch url and get the version id
        $client = new \GuzzleHttp\Client();
        $client->setDefaultOption('verify', false);
        
        try {
            $res = $client->request('GET', $url);
        } catch(RequestException $e){
            $status_code = $e->getCode();
            throw new EmptyUrlException("URL '$url'' returned status code: $status_code. Was expecting 200.");
        }
        
        $status_code = $res->getStatusCode();
        if ($res->getStatusCode() != 200){
            throw new EmptyUrlException("URL '$url'' returned status code: $status_code. Was expecting 200.");
        }
        
        $body = $res->getBody();
        echo $body;
        
        return 1;
    }
}
