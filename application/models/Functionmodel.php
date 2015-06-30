<?php 
class Functionmodel extends CI_Model
{
    function downloadXml()    
    {
        $url  = 'https://www.chinavasion.com/sitemap.xml';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chdata = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200)
        {
            $path =  $_SERVER['DOCUMENT_ROOT'].'/download/chinavasion_'.date('Y-m-d').'.xml';
           
            if(file_exists($path)){unlink($path);}
           
            if (($fp = fopen($path, "a")) !== false)
            { 
                curl_setopt($ch, CURLOPT_NOBODY, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FILE, $fp);
                $chdata = curl_exec($ch);
                // fwrite($path, $chdata);
                curl_close($ch);
                fclose($fp);
            }
            return TRUE;
        }
        else
        {
            curl_close($ch);
            return FALSE;
        }
    }

    function parseXml()
    {
        $url = $_SERVER['DOCUMENT_ROOT'].'/download/chinavasion_'.date('Y-m-d').'.xml';
        $xml = simplexml_load_file($url);
        
        $this->db->empty_table('sitemap');
        
        $rowsCount = $counter = 0;

        foreach ($xml->url as $item)
        {
            $data = array(
                'url' => $item->loc,
                'datetime' => date('Y-m-d', strtotime($item->lastmod)),
            );

            $this->db->insert('sitemap', $data);
            unset($data);
            $rowsCount += $this->db->affected_rows();
            $counter++;
        }

        if ($rowsCount == $counter)
        {
            return $rowsCount;
        }
        else 
        {
            return FALSE;
        }
    }

    function parseResultsGetDateList()
    {
        $query = $this->db->query('SELECT datetime FROM sitemap GROUP BY datetime ORDER BY datetime DESC');
        if ($query)
        {
            return $query->result();
        }
        else
        {
            return FALSE;
        }
    }

    function parseResultsLincs($date)
    {
        $query = $this->db->query('SELECT url FROM sitemap WHERE datetime ="'.$date.'"');
        if ($query)
        {
            return $query->result();
        }
        else
        {
            return FALSE;
        }
    }

    function deleteXmls()
    {
        $files = glob($_SERVER['DOCUMENT_ROOT'].'/download/*.xml');
        foreach($files as $file)
        { 
            if($file != $_SERVER['DOCUMENT_ROOT'].'/download/index.html' ) 
            {
                unlink($file);
            }
        }
        return true;
    }

    function parseImages($imgurl)
    {
        include('php/simple_html_dom.php');
        define('SAVE_PATH','C:\Users\phpist\Desktop');
        if (!is_dir(SAVE_PATH)) {return 'setup path to desctop';}

        $link = trim($imgurl);
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
            curl_close($curl); // clean content
            return 'File: '.$title.' already exists at Your DESKTOP';
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
                $add_img_url = str_replace('.thumb_140x140.jpg','',$add_img_url);
                $add_img_url = str_replace('images/thumbnails/','images/',$add_img_url);

                $ext2 = pathinfo($add_img_url); // разбиваем его на составные
                $extension2 = $ext2['extension']; // получаем его расширение
                $path2 = SAVE_PATH.'/'.$title.'/'.$i.'.'.$extension2; // указываем путь, куда будем сохранять изображения
                file_put_contents($path2, file_get_contents($add_img_url)); // само скачивание картинки и сохранение
                $i++;
            }
            
            $gallery = htmlentities('<p>{gallery}'.$title.'{/gallery}</p>');
            curl_close($curl); // clean content
            return $gallery;
        }
    }





}
?>