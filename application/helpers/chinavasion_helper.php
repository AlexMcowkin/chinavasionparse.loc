<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*create seo link*/
if(!function_exists('seofromname'))
{
	function seofromname($title)
	{
	    $title = trim($title);
	    $title = strtolower($title);
	    $title = str_replace(' - ', '-', $title);
	    $title = str_replace(' ', '-', $title);
	    $title = str_replace('.', '', $title);
	    $title = str_replace('(', '', $title);
	    $title = str_replace(',', '', $title);
	    $title = str_replace('/', '', $title);
	    $title = str_replace('\\', '', $title);
	    $title = str_replace('\'', '', $title);
	    $title = str_replace('"', '', $title);
	    $title = str_replace('#', '', $title);
	    $title = str_replace('%', '', $title);
	    $title = str_replace('@', '', $title);
	    $title = str_replace('?', '', $title);
	    $title = str_replace('$', '', $title);
	    $title = str_replace('*', '', $title);
	    $title = str_replace('~', '', $title);
	    $title = str_replace('!', '', $title);
	    $title = str_replace('^', '', $title);
	    $title = str_replace('&', '', $title);
	    $title = str_replace('=', '', $title);
	    $title = str_replace('+', '', $title);
	    $title = str_replace(')', '', $title);
	    $title = str_replace(':', '-', $title);
	    $title = str_replace('\'', '', $title);
	    $title = str_replace('–', '-', $title);
	    $title = str_replace('_', '-', $title);
	    $title = str_replace('"', '', $title);
	    $title = str_replace('quot;', '', $title);
	    
	    if (substr($title, -1) == '-')
	    {
	    	$title = substr($title, 0, -1 );
	    }
	    
	    return $title;
	}
}

/*  price calculation formula: [our_price: retail_price * 20% and round to 0.99]   */
/*
x66 -> x67
x13 -> x14
x5 -> x4
x2 -> x4
x3 -> x4
x1 -> y9
x0 -> y9
x03 -> y99
x07 -> x09
*/
if(!function_exists('mysellprice'))
{
	function mysellprice($price)
	{
	    $price = substr($price,0,-3);
		$price = round($price*110/100,2);
		$price = round($price)-0.05;
		return $price;
	}
}