<?php

namespace Cpeter\PhpCmsVersionChecker;

use Cpeter\PhpCmsVersionChecker\Exception\EmptyUrlException;
use GuzzleHttp\Exception\RequestException;

class Parser 
{
    public function parse($cms, $cms_options)
    {
        $url = $cms_options['version_page'];
        if (empty($url)) {
            throw new EmptyUrlException("URL must be set for '$cms'. We can not parse empty url.");
        }
        
        $regexp = $cms_options['regexp'];
        
        // fetch url and get the version id
        $client = new \GuzzleHttp\Client();

        try {
            $res = $client->get($url, array('verify' => false));
        } catch(RequestException $e){
            $status_code = $e->getCode();
            throw new EmptyUrlException("URL '$url'' returned status code: $status_code. Was expecting 200.");
        }
        
        $status_code = $res->getStatusCode();
        if ($res->getStatusCode() != 200){
            throw new EmptyUrlException("URL '$url'' returned status code: $status_code. Was expecting 200.");
        }
        
        $body = $res->getBody();
        $version_found = preg_match($regexp, $body, $match);
        
        if ($version_found === 1 && !empty($match[1])) {
            return $match[1];
        }
                
        return false;
    }
}
