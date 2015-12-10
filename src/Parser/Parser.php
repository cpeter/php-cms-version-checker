<?php

namespace Cpeter\PhpCmsVersionChecker\Parser;

use Cpeter\PhpCmsVersionChecker\Exception\EmptyUrlException;
use GuzzleHttp\Exception\RequestException;
use Cpeter\PhpCmsVersionChecker\Parser\Plugins as Plugins;

class Parser
{

    private $parsers = array();
    
    public function __construct()
    {
        $this->registerPlugins();
    }
    
    protected function registerPlugins()
    {
        // get all the parsers
        
    }
    
    //add observer
    public function attach(\IParser $parser) {
        $this->parsers[] = $parser;
    }

    //remove observer
    public function detach(\IParser $parser) {

        $key = array_search($parser,$this->parsers, true);
        if($key){
            unset($this->parsers[$key]);
        }
    }
    
    public function parse($cms, $cms_options)
    {
        $url = $cms_options['version_page'];
        if (empty($url)) {
            throw new EmptyUrlException("URL must be set for '$cms'. We can not parse empty url.");
        }
       
        // $regexp = $cms_options['regexp'];
        
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
        
        // loop through all parsers and try to get the cms value. 
        // each CMS should have only one parser so once one parser has commited to do the job don't try the other
        // parsers, they should not match 
        foreach ($this->parsers as $parser) {
            $value = $parser->parse($body, $cms_options);
        }
        
        $version_found = preg_match($regexp, $body, $match);
        
        if ($version_found === 1 && !empty($match[1])) {
            return $match[1];
        }
                
        return false;
    }
}
