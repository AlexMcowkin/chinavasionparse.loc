<?php
  class bbParser{
    public function __construct(){}
    
    public function getHtml($str){
      $bb[] = "#\<strong\>(.*?)\</strong\>#si";
      $html[] = "<b>\\1</b>";
      $bb[] = "#\[i\](.*?)\[/i\]#si";
      $html[] = "<i>\\1</i>";
      $bb[] = "#\[u\](.*?)\[/u\]#si";
      $html[] = "<u>\\1</u>";
      $bb[] = "#\[hr\]#si";
      $html[] = "<hr>";
      $str = preg_replace ($bb, $html, $str);
      $patern="#\[url href=([^\]]*)\]([^\[]*)\[/url\]#i";
      $replace='<a href="\\1" target="_blank" rel="nofollow">\\2</a>';
      $str=preg_replace($patern, $replace, $str); 
      $patern="#\[img\]([^\[]*)\[/img\]#i";
      $replace='<img src="\\1" alt=""/>';
      $str=preg_replace($patern, $replace, $str);  
	  $str=nl2br($str);
      return $str;
    }
  }

  $bb = new bbParser();
  echo $bb->getHtml($_GET["bbcode"]);

?>