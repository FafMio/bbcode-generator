<?php

class UrlService
{
    public function __construct() {}

    /**
     * Editing the URL parameters for forms
     *
     * @param string $url
     * @param array $newParams
     * @return string
     */
    public function replaceUrlParameters(string $url = '', array $newParams = []): string
    {
        if($url){
            $urlArray = parse_url($url);
            $queryString = $urlArray['query'];
            parse_str($queryString, $queryParams);
            $queryParams = array_merge($queryParams, $newParams);
            $urlArray['query'] = http_build_query($queryParams);

            if(!empty($urlArray)){
                $url = $urlArray['scheme'].'://'.$urlArray['host'].':8000'.$urlArray['path'].'?'.$urlArray['query'];
            }
        }
        return $url;
    }

}