<?php
/*
Plugin Name: Youtube Embedder
Plugin URI: http://de77.com/
Description: Lets you embed a Youtube video in a post
Version: 1.0
Author: de77.com
Author URI: http://de77.com
Licence: MIT
*/

include 'Youtube.php';

function replacerYoutube($matches)
{	
	$temp = explode(' ', $matches[1]);
    $count = count($temp);   	  
    
	if ($count == 0) return '';
    
    $url = $temp[0];
    
    if ($count == 3)
    {
    	$width = $temp[1];
    	$height = $temp[2];
    }
    else
    {
    	$width = 400;
    	$height = 300;
    }    
    	
	$y = new Youtube;
	$y->load($url);
	    
    return $y->getEmbed(true, $width, $height);
}

function parse_iframeYoutube($text)
{
	return preg_replace_callback("@(?:<p>\s*)?\[youtube\s*(.*?)\](?:\s*</p>)?@", 'replacerYoutube', $text);
}

add_filter('the_content', 'parse_iframeYoutube');