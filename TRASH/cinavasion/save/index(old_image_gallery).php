<?php include('simple_html_dom.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Save Images to Desctop</title>
	<link href='parcer.css' rel='stylesheet' type='text/css' />
</head>
<body>
<div id="start">

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST['submit_i']))
	{
		function see_saves() 
		{
			if (!empty($_POST['link']))  // for editing title for Folder Name
			{

				$link = trim($_POST['link']);
				$lin_arr = array();
				$kk = 0;
				$q = 1;

				$curl = curl_init();
				curl_setopt($curl,CURLOPT_URL,$link);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5'); // set user agent
				$out = curl_exec($curl); // get content


				// Create DOM from URL or file
				$html = str_get_html($out);
				
				// get the TITLE of current page
				foreach($html->find('h1[class="fn"]') as $h1t)
				{
					//echo $h1t->innertext;
					$title = trim($h1t->innertext);
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
					


					//$title = preg_replace('/\(.*\)/', '', $title); //delete all data between ()
					if (substr($title, -1) == '-') $title = substr($title, 0, -1 );

				}

				$filename = 'C:\Users\Don Alehandro\Desktop\gallery\\'.$title; // !!! personally data
				if (file_exists($filename)) 
				{
					echo 'File Exists';
					echo '<br />'.$title;
				}
				else
				{
					// Find all links 
					foreach($html->find('a.highslide') as $element)
					{
						$lin_arr[] =  $element->href;
						$kk = $kk+1;
					}
				
					// create folder on the desctop
					mkdir('C:\Users\Don Alehandro\Desktop\\'.$title);

					// download all pictures
					for ($i=0;$i<$kk;$i++)
					{

						$img_file=$lin_arr[$i];
					
						$ext = pathinfo($img_file);
						$ext = $ext['extension'];
					
						$img_file=file_get_contents($img_file);
						if ($i == 0)
						{
							//$file_loc=$_SERVER['DOCUMENT_ROOT'].'/saveimg/'.$title.'/'.$title.'.jpg';
							$file_loc = 'C:\Users\Don Alehandro\Desktop/'.$title.'.jpg';
						}
						else
						{
							//$file_loc=$_SERVER['DOCUMENT_ROOT'].'/saveimg/'.$title.'/'.$i.'.jpg';
							$file_loc='C:\Users\Don Alehandro\Desktop/'.$title.'/'.$i.'.'.$ext;
						}

						$file_handler=fopen($file_loc,'w');
						if(fwrite($file_handler,$img_file)==false){ echo 'error'; }
						fclose($file_handler);
					}
					echo 'Well Done!!! All saved??? =)';
					
					$gallery = htmlentities('<p>{gallery}'.$title.'{/gallery}</p>');
					echo "<p class='suplier'>Gallery Code:</p><p class='weare'>".$gallery."</p>";
				}
				
				curl_close($curl); // clean content
			}
			else echo '<p class="error">Insert Link</p>';
		}
	}
}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="titleForm" id="">
	<fieldset>
	<legend>Paste the Link:</legend>
		<input name="link" class="text-field-title" value="" type="text" /><br />
		<input type="submit" value="Press Here" class="button" name="submit_i" />
	</fieldset>
    </form>
	<?php if (isset($_POST['submit_i'])) @see_saves();?>
</div>
</body>
</html>