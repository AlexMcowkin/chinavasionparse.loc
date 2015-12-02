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
	    $title = str_replace('/-', '', $title);
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
	    $title = str_replace('&amp;', '', $title);
	    $title = str_replace('&', '', $title);
	    $title = str_replace('=', '', $title);
	    $title = str_replace('+', '', $title);
	    $title = str_replace(')', '', $title);
	    $title = str_replace(':', '-', $title);
	    $title = str_replace('\'', '', $title);
	    $title = str_replace('–', '-', $title);
	    $title = str_replace('_', '-', $title);
	    $title = str_replace("'", '', $title);
	    $title = str_replace('‘', '', $title);
	    $title = str_replace('’', '', $title);
	    $title = str_replace('”', "'", $title);
	    $title = str_replace('“', "'", $title);
	    $title = str_replace('`', '', $title);
	    $title = str_replace('--', '-', $title);
	    $title = str_replace('quot;', '', $title);
	    
	    if (substr($title, -1) == '-')
	    {
	    	$title = substr($title, 0, -1 );
	    }
	    
	    return $title;
	}
}

/*  price calculation formula: [our_price: retail_price * 10% and round to 0.99 cents to the end] */
if(!function_exists('mysellprice'))
{
	function mysellprice($price)
	{
	    // $price = substr($price,0,-3); // delete cents
	    // $price = round($price)-0.01; // rount price and -0.01 cent to be price like xx.99
		$price = round($price*110/100,2); // price + 10% CHANGE PERCENT HERE
		$price = round($price); // round price    

		if($price > 9)
		{
			$_price_l3d = substr($price, -3, 3); // check last three digits			
			$_price_l2d = substr($price, -2, 2); // check last two digits
			$_price_l1d = substr($price, -1, 1); // check last one digit

			switch($_price_l3d)
			{
				case 110: return $price+4.99; // 110 -> 114.99
			}

			switch($_price_l2d)
			{
				case 01: return $price-1.01; // 101 -> 9.99
				case 02: return $price-2.01; // 102 -> 9.99
				case 03: return $price-3.01; // 103 -> 9.99
				case 04: return $price-4.01; // 104 -> 9.99
				case 05: return $price-5.01; // 105 -> 9.99
				case 06: return $price+8.99; // 106 -> 114.99
				case 07: return $price+7.99; // 107 -> 114.99
				case 08: return $price+6.99; // 108 -> 114.99
				case 09: return $price+5.99; // 109 -> 114.99
				case 66: return $price+1.99; // 66 -> 67.99
				case 13: return $price+1.99; // 13 -> 14.99

				case 10: return $price+1.99; // 13 -> 14.99

			}

			switch($_price_l1d)
			{
				case 0: return $price-0.01; // 10 -> 9.99
				case 1: return $price-1.01; // 11 -> 9.99
				case 2: return $price+2.99; // 12 -> 14.99
				case 3: return $price+1.99; // 13 -> 14.99
				case 5: return $price-0.01; // 15 -> 14.99
			}
		}
		
		return $price+0.99;		
	}
}

/*create seo link*/
if(!function_exists('cleantitle'))
{
	function cleantitle($title)
	{
	    $title = trim($title);
	    $title = str_replace('/', '&', $title);
	    $title = str_replace('+', '&', $title);
	    $title = str_replace('"', "'", $title);
	    $title = str_replace('–', ' ', $title);
	    $title = str_replace('–', ' ', $title);
	    $title = str_replace('”', "'", $title);
	    $title = str_replace('“', "'", $title);
	    $title = str_replace('‘', '', $title);
	    $title = str_replace('’', '', $title);	    

	    return $title;
	}
}

/*create seo link*/
if(!function_exists('cleantext'))
{
	function cleantext($text)
	{
	    $text = trim($text);
	    $text = str_replace('"', "'", $text);
	    $text = str_replace('Chinavasion', "Site_name", $text);
	    $text = str_replace('chinavasion', "site_name", $text);

	    return $text;
	}
}

if(!function_exists('removebaflk')) // remove "Bnefits and Foreign Language Keywords"
{
	function removebaflk($text)
	{
		$text = str_ireplace('<strong>Enjoy the following benefits:</strong>', '', $text);
	    $text = preg_replace("/(<ul id='Chinavasion_Benefits'>).*?<\/ul>/is","",$text);

	    $text = str_ireplace('<strong>Foreign Language Keywords</strong>', '', $text);
	    $text = preg_replace("/(<p id='foreign_language_keywords'>).*?<\/p>/is","",$text);

	    return $text;
	}
}