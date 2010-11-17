<?php

class TPL_Main implements itemplate
{
    public function display($p)
    {
        $web_root = land_conf::$web_root;
        $host = $_SERVER['HTTP_HOST'];
        echo <<<eot
<?xml version="1.0" encoding="UTF-8"?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">
<ShortName>Land Search</ShortName>
<Description>Search problems in Land</Description>
<InputEncoding>UTF-8</InputEncoding>
<Url type="text/html" template="http://{$host}{$web_root}/problem/search?key={searchTerms}"/>
</OpenSearchDescription>
eot;
        return true;
    }
}

?>
