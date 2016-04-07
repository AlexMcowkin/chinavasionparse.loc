<?php 
class Chinavasionmodel extends CI_Model
{
/**************************************************************************/
/**********************    CATEGORIES    **********************************/
/**************************************************************************/   
    function parceCategories()
    {
        $arrayData = array('key'=>CHINAVASION_APIKEY, 'include_content'=>"0");
        $jsonRequest = json_encode($arrayData);

        $curl = curl_init(CHINAVASION_APIURL_CATEGORY);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonRequest);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $jsonResponse = curl_exec($curl);
        $statusResponse = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($statusResponse != 200)
        {
            $msg = "Error: call to URL CHINAVASION_APIURL_CATEGORY failed with status $statusResponse, response $jsonResponse, curl_error ".curl_error($curl).", curl_errno ".curl_errno($curl);
            curl_close($curl);
            return $msg;
        }
        curl_close($curl);
        $result = json_decode($jsonResponse, true);

        if(isset($result['error']))
        {
            return $result['error_message'].'<br/><br/>'.$jsonRequest;
        }
        else
        {
            $this->db->empty_table('cv_categories');
            $this->db->query('ALTER TABLE cv_categories AUTO_INCREMENT = 1');
            $this->db->empty_table('cv_products');
            $this->db->query('ALTER TABLE cv_products AUTO_INCREMENT = 1');
            $this->db->empty_table('cv_products_imgs');
            $this->db->query('ALTER TABLE cv_products_imgs AUTO_INCREMENT = 1');

            $i=100;
            foreach ($result['categories'] as $value)
            {
                $data = array(
                    'id'=>$i++,
                    'name' => $value['name'],
                    'url' => $value['url'],
                    'parentname' => '',
                    'img' => $value['image'],
                );
                $this->db->insert('cv_categories', $data);
                $parentname = $value['name'];
                empty($data);
                
                foreach ($value['subcategories'] as $subvalue)
                {
                    $subdata = array(
                        'id'=>$i++,
                        'name' => $subvalue['name'],
                        'url' => $subvalue['url'],
                        'parentname' => $parentname,
                        'img' => $subvalue['image'],
                    );
                    $this->db->insert('cv_categories', $subdata);
                    empty($subdata);
                    empty($parentname);
                }
            }
            
            return true;
        }
    }

    function listCategories()
    {
        $newProductsArray = array();
        $query = $this->db->query("SELECT id, name, url, parce_status, total FROM cv_categories WHERE parentname = '' ORDER BY name");
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
    }

/**************************************************************************/
/************************    PRODUCTS    **********************************/
/**************************************************************************/
   
   function parceCategoryProducts($id, $start = 0, $data = array())
    {
        $query = $this->db->query("SELECT name FROM cv_categories WHERE id = $id LIMIT 1");
        $categoryName = $query->row(0)->name;

        $this->db->delete('cv_products', array('category_name' => $categoryName));

        $arrayData = array('key'=>CHINAVASION_APIKEY, 'categories'=>array($categoryName), 'pagination'=>array('start'=>$start, 'count'=>50));
        $jsonRequest = json_encode($arrayData);

        $curl = curl_init(CHINAVASION_APIURL_PRODUCTLIST);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonRequest);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $jsonResponse = curl_exec($curl);
        $statusResponse = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($statusResponse != 200)
        {
            $msg = "Error: call to URL CHINAVASION_APIURL_PRODUCTLIST failed with status $statusResponse, response $jsonResponse, curl_error ".curl_error($curl).", curl_errno ".curl_errno($curl);
            curl_close($curl);
            return $msg;
        }
        curl_close($curl);
        $result = json_decode($jsonResponse, true);

        if(isset($result['error']))
        {
            return $result['error_message'].'<br/><br/>'.$jsonRequest;
        }
        else
        {
            foreach ($result['products'] as $value)
            {
                $data[] = array(
                    'product_id'=>$value['product_id'],
                    'model_code' => $value['model_code'],
                    'ean' => $value['ean'],
                    'full_product_name' => $value['full_product_name'],
                    'short_product_name' => $value['short_product_name'],
                    'category_name' => $value['category_name'],
                    'subcategory_name' => (empty($value['subcategory_name'])) ? '' : $value['subcategory_name'],
                    'price' => $value['price'],
                    'retail_price'=> $value['retail_price'],
                    'product_url' => $value['product_url'],
                    'main_picture'=> $value['main_picture'],
                    'meta_keyword'=> $value['meta_keyword'],
                    'meta_description'=> $value['meta_description'],
                    'overview'=> $value['overview'],
                    'specification'=> $value['specification'],
                    'status' => $value['status'],
                    'continuity' => $value['continuity'],
                    'parse_date' => date('d-m-Y')
                );

                $_countAdditionlImages = count($value['additional_images']);
                if($_countAdditionlImages > 0)
                {

                    for($j=0;$j<$_countAdditionlImages;$j++)
                    {
                        $subdata = array(
                            'prod_id'=>$value['product_id'],
                            'img' => $value['additional_images'][$j],
                        );
                        $this->db->insert('cv_products_imgs', $subdata);
                        empty($subdata);
                    }
                }
            }

            $start = $start + 50;
            
            if($result['pagination']['total'] > $start)
            {
               return $data[] = $this->parceCategoryProducts($id, $start, $data);
            }
            else
            {
                $this->db->insert_batch('cv_products', $data);
                $this->db->update('cv_categories', array('parce_status'=>1, 'total'=>count($data)), "id=".$id);
                return $data;
            }
        }
    }

/**************************************************************************/
/**************************************************************************/
/**************************************************************************/

    function parceNewProductsXml($parcexmlurl)
    {
        $this->db->empty_table('cv_newproducts');

        $feed = file_get_contents($parcexmlurl);
        $xml = new SimpleXmlElement($feed);
        
        $rowsCount = 0;
        foreach ($xml->channel->item as $item)
        {
            $sku = explode(' - ', $item->title);

            $item_dc = $item->children('http://purl.org/dc/elements/1.1/');

            $data = array(
                'link' => $item->link,
                'sku' => end($sku),
                'date' => date('Y-m-d', strtotime($item_dc->date)),
            );

            $this->db->insert('cv_newproducts', $data);
            unset($data);
            $rowsCount += $this->db->affected_rows();
        }

        return $rowsCount;
    }

    function getNewProducts()
    {
        $newProductsArray = array();
        $query = $this->db->query("SELECT link, sku FROM cv_newproducts");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $query2 = $this->db->query("SELECT id FROM oc_products WHERE sku = '{$row->sku}' LIMIT 1");
                if($query2->num_rows() == 0)
                {
                    $newProductsArray[] = array($row->link, $row->sku);
                }
            }
            return $newProductsArray;
        }
        else
        {
            return 'No new products';
        }
    }

/**************************************************************************/
/**************************************************************************/
/**************************************************************************/

    function getProductDetails($sku)
    {
        $arrayData = array('key'=>CHINAVASION_APIKEY, 'model_code'=>$sku);
        $jsonRequest = json_encode($arrayData);

        $curl = curl_init(CHINAVASION_APIURL_PRODUCTDETAIL);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonRequest);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $jsonResponse = curl_exec($curl);
        $statusResponse = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if($statusResponse != 200)
        {
            $msg = "Error: call to URL CHINAVASION_APIURL_PRODUCTDETAIL failed with status $statusResponse, response $jsonResponse, curl_error ".curl_error($curl).", curl_errno ".curl_errno($curl);
            curl_close($curl);
            return $msg;
        }
        curl_close($curl);
        $result = json_decode($jsonResponse, true);

        if(isset($result['error']))
        {
            return $result['error_message'].'<br/><br/>'.$jsonRequest;
        }
        else
        {
            foreach ($result['products'] as $value)
            {
                $data = array(
                    'id' => $value['product_id'],
                    'sku' => $value['model_code'],
                    'ean' => $value['ean'],
                    'full_product_name' => $value['full_product_name'],
                    'category_name' => $value['category_name'],
                    'product_url' => $value['product_url'],
                    'main_picture' => $value['main_picture'],
                    'additional_images' => $value['additional_images'],
                    'meta_description' => $value['meta_description'],
                    'overview' => $value['overview'],
                    'specification' => $value['specification'],
                    'price' => $value['price'],
                    'status' => $value['status'],
                    'continuity' => $value['continuity']
                );
            }
        }

        return $data;
    }

/**************************************************************************/
/**************************************************************************/
/**************************************************************************/

    // function downloadXml()    
    // {
    //     $url  = 'https://www.chinavasion.com/sitemap.xml';

    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_NOBODY, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     $chdata = curl_exec($ch);
    //     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    //     if ($httpCode == 200)
    //     {
    //         $path =  $_SERVER['DOCUMENT_ROOT'].'/download/chinavasion_'.date('Y-m-d').'.xml';
           
    //         if(file_exists($path)){unlink($path);}
           
    //         if (($fp = fopen($path, "a")) !== false)
    //         { 
    //             curl_setopt($ch, CURLOPT_NOBODY, false);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //             curl_setopt($ch, CURLOPT_FILE, $fp);
    //             $chdata = curl_exec($ch);
    //             // fwrite($path, $chdata);
    //             curl_close($ch);
    //             fclose($fp);
    //         }
    //         return TRUE;
    //     }
    //     else
    //     {
    //         curl_close($ch);
    //         return FALSE;
    //     }
    // }

    // function parseXml()
    // {
    //     $url = $_SERVER['DOCUMENT_ROOT'].'/download/chinavasion_'.date('Y-m-d').'.xml';
    //     $xml = simplexml_load_file($url);
        
    //     $this->db->empty_table('sitemap');
        
    //     $rowsCount = $counter = 0;

    //     foreach ($xml->url as $item)
    //     {
    //         $data = array(
    //             'url' => $item->loc,
    //             'datetime' => date('Y-m-d', strtotime($item->lastmod)),
    //         );

    //         $this->db->insert('sitemap', $data);
    //         unset($data);
    //         $rowsCount += $this->db->affected_rows();
    //         $counter++;
    //     }

    //     if ($rowsCount == $counter)
    //     {
    //         return $rowsCount;
    //     }
    //     else 
    //     {
    //         return FALSE;
    //     }
    // }

    // function parseResultsGetDateList()
    // {
    //     $query = $this->db->query('SELECT datetime FROM sitemap GROUP BY datetime ORDER BY datetime DESC');
    //     if ($query)
    //     {
    //         return $query->result();
    //     }
    //     else
    //     {
    //         return FALSE;
    //     }
    // }

    // function parseResultsLincs($date)
    // {
    //     $query = $this->db->query('SELECT url FROM sitemap WHERE datetime ="'.$date.'"');
    //     if ($query)
    //     {
    //         return $query->result();
    //     }
    //     else
    //     {
    //         return FALSE;
    //     }
    // }

    // function deleteXmls()
    // {
    //     $files = glob($_SERVER['DOCUMENT_ROOT'].'/download/*.xml');
    //     foreach($files as $file)
    //     { 
    //         if($file != $_SERVER['DOCUMENT_ROOT'].'/download/index.html' ) 
    //         {
    //             unlink($file);
    //         }
    //     }
    //     return true;
    // }

/**************************************************************************/
/**************************************************************************/
/**************************************************************************/

    function parseImages($imgurl)
    {
        $imgurl = trim($imgurl);
        if (filter_var($imgurl, FILTER_VALIDATE_URL) !== FALSE)
        {
            include('php/simple_html_dom.php');
            if (!is_dir(SAVE_IMAGES_PATH)) {return 'PLEASE: setup SAVE_IMAGES_PATH path to your desctop in application\config\constants.php';}

            $link = str_replace("http://", "https://", trim($imgurl));
            $lin_arr = array();
            $kk = 0;
            $q = 1;

            $curl = curl_init();
            curl_setopt($curl,CURLOPT_URL,$link);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5'); // set user agent
            $out = curl_exec($curl);

            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if($httpCode == 200)
            {
                $html = str_get_html($out);

                foreach($html->find('h1[class="fn"]') as $h1t)
                {
                    //echo $h1t->innertext;
                    $title = seofromname($h1t->innertext); // this function from 'chinavasion' helper
                }

                $filename = SAVE_IMAGES_PATH.'\gallery\\'.$title;
                // if we have such folder on desctop so we skip it
                if (file_exists($filename)) 
                {
                    curl_close($curl); // clean content
                    return 'File: '.$title.' already exists at Your DESKTOP';
                }
                else
                {
                    // create folder on the desktop
                    mkdir(SAVE_IMAGES_PATH.'\\'.$title);
                              
                    foreach($html->find('#xxyts img') as $element)
                    {
                        $main_img_url = "http:$element->src";
                        $ext = pathinfo($main_img_url); // get file data
                        $extension = $ext['extension']; // get file extension
                        $path = SAVE_IMAGES_PATH.'/'.$title.'.'.$extension; // set path where will save image
                        file_put_contents($path, file_get_contents($main_img_url)); // download image and save it
                    }
                    
                    // find & save ADDITIONAL images
                    $i = 1;
                    foreach($html->find('#xys img') as $element2)
                    {
                        $add_img_url = "http:$element2->src";
                        $add_img_url = str_replace('.thumb_70x70.jpg','',$add_img_url);
                        $add_img_url = str_replace('.thumb_140x140.jpg','',$add_img_url);
                        $add_img_url = str_replace('images/thumbnails/','images/',$add_img_url);

                        $ext2 = pathinfo($add_img_url); // get file data
                        $extension2 = $ext2['extension']; // get file extension
                        $path2 = SAVE_IMAGES_PATH.'/'.$title.'/'.$i.'.'.$extension2; // set path where will save image
                        file_put_contents($path2, file_get_contents($add_img_url)); // download image and save it
                        $i++;
                    }
                    
                    $gallery = htmlentities($title);
                    curl_close($curl); // clean content
                    return $gallery;
                }
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

/**************************************************************************/
/**************************************************************************/
/**************************************************************************/

}
?>