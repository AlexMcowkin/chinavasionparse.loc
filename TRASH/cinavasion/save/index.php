<?php
	include('simple_html_dom.php');
	define('SAVE_PATH','C:\Users\phpist\Desktop');
	if (!is_dir(SAVE_PATH)) {die('Change path to desctop');}
?>

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
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5'); // set user agent
				$out = curl_exec($curl); // get content

				// echo curl_error($curl);  echo $out; die();

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
					
					if (substr($title, -1) == '-') $title = substr($title, 0, -1 );
				}

				$filename = SAVE_PATH.'\gallery\\'.$title; // !!! personally data
				// если есть файл, то пропускаем повторное создание
				if (file_exists($filename)) 
				{
					echo 'File Exists at Your DESKTOP';
					echo '<br />'.$title;
				}
				else
				{
					// create folder on the desktop
					mkdir(SAVE_PATH.'\\'.$title);
					
					// find & save MAIN image
					// foreach($html->find('a.highslide') as $element)
					// {
						// $main_img_url = "http:$element->href";
						// $ext = pathinfo($main_img_url); // разбиваем его на составные
						// $extension = $ext['extension']; // получаем его расширение
						// $path = SAVE_PATH.'/'.$title.'.'.$extension; // указываем путь, куда будем сохранять изображения
						// file_put_contents($path, file_get_contents($main_img_url)); // само скачивание картинки и сохранение
					// }
					
					foreach($html->find('#xxyts img') as $element)
					{
						$main_img_url = "http:$element->src";
						$ext = pathinfo($main_img_url); // разбиваем его на составные
						$extension = $ext['extension']; // получаем его расширение
						$path = SAVE_PATH.'/'.$title.'.'.$extension; // указываем путь, куда будем сохранять изображения
						file_put_contents($path, file_get_contents($main_img_url)); // само скачивание картинки и сохранение
					}
					
					// find & save ADDITIONAL images
					$i = 1;
					foreach($html->find('#xys img') as $element2)
					{
						$add_img_url = "http:$element2->src";
						$add_img_url = str_replace('.thumb_70x70.jpg','',$add_img_url);
						$add_img_url = str_replace('images/thumbnails/','images/',$add_img_url);

						$ext2 = pathinfo($add_img_url); // разбиваем его на составные
						$extension2 = $ext2['extension']; // получаем его расширение
						$path2 = SAVE_PATH.'/'.$title.'/'.$i.'.'.$extension2; // указываем путь, куда будем сохранять изображения
						file_put_contents($path2, file_get_contents($add_img_url)); // само скачивание картинки и сохранение
						$i++;
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