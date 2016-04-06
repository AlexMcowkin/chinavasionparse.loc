<?php 
class Opencartmodel extends CI_Model
{
/**************************************************************************/
/***************************    STOCK    **********************************/
/**************************************************************************/   

    function getStockDataFromCsv($csvfile)
    {
        $this->db->empty_table('oc_products');

        $file = fopen($csvfile, 'r');
        
        $r = 0;
        
        while (($row = fgetcsv($file, 10000, ",")) != FALSE)
        {
            $r++;
            if($r == 1)
            {
                if($row['0'] == "SKU") {continue;}
                else { return 0;}
            }

            $sqlins = "INSERT INTO oc_products (id, sku, quantity, price) VALUES (NULL,'".$row[0]."','".$row[1]."','".$row[2]."')";
            $this->db->query($sqlins);
        }
        
        fclose($file);
        array_map("unlink", glob($_SERVER["DOCUMENT_ROOT"]."/upload/opencart/*.csv"));

        return $r;
    }

    function setUpdateStockToCsv()
    {
        $csv_file = '"SKU","QUANTITY"'."\r\n";

        $query = $this->db->query("SELECT sku, quantity FROM oc_products");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $query2 = $this->db->query("SELECT model_code, status, continuity FROM cv_products WHERE model_code = '{$row->sku}' LIMIT 1");
                if($query2->num_rows() == 0)
                {
                    $csv_file .= '"'.$row->sku.'","0"'."\r\n";
                }
                else
                {
                    foreach ($query2->result() as $row2)
                    {
                        if(($row2->status == 'In Stock') AND ($row2->continuity == 'Normal Product'))
                        {
                            $csv_file .= '"'.$row->sku.'","999"'."\r\n";
                        }
                        else
                        {
                            $csv_file .= '"'.$row->sku.'","0"'."\r\n";
                        }
                    }
                }
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'ee_stock_export.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);
            return $file_name;
        }
        else
        {
            return 'no_data';
        }
    }

    function getNewPrices()
    {
        $query = $this->db->query("SELECT sku, price FROM oc_products");

        if ($query->num_rows() > 0)
        {
            $result = array();

            foreach ($query->result() as $row)
            {
                $query2 = $this->db->query("SELECT model_code, price, product_url FROM cv_products WHERE model_code = '{$row->sku}' AND status = 'In Stock' AND continuity = 'Normal Product' LIMIT 1");
                if($query2->num_rows() > 0)
                {
                    foreach ($query2->result() as $row2)
                    {
                        if ($row->price != $row2->price)
                        {
                            $result[] = array($row->sku, $row->price, $row2->price, $row2->product_url);
                        }
                    }
                }
            }

            return $result;
        }
        else
        {
            return 'No Data';
        }
    }

    function getNewProducts()
    {
        $query = $this->db->query("SELECT model_code, product_url FROM cv_products");

        if ($query->num_rows() > 0)
        {
            $result = array();

            foreach ($query->result() as $row)
            {
                $query2 = $this->db->query("SELECT id FROM oc_products WHERE sku = '{$row->model_code}' LIMIT 1");
                if($query2->num_rows() == 0)
                {
                    $result[] = array($row->model_code, $row->product_url);
                }
            }

            return $result;
        }
        else
        {
            return 'No Data';
        }
    }

/**************************************************************************/
/************************ C A T E G O R Y *********************************/
/**************************************************************************/
    function csvCatSeoUrlAlias()
    {
        $csv_file = '"URL_ALIAS_ID";"QUERY";"KEYWORD"'."\r\n";

        $query = $this->db->query("SELECT id, name FROM cv_categories");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $csv_file .= '"";"category_id='.$row->id.'";"'.seofromname($row->name).'.html"'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc_category__url_alias.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvCatStore()
    {
        $csv_file = '"CATEGORY_ID";"STORE_ID"'."\r\n";

        $query = $this->db->query("SELECT id FROM cv_categories");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $csv_file .= '"'.$row->id.'";"0"'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__category_to_store.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvCatLayout()
    {
        $csv_file = '"CATEGORY_ID";"STORE_ID";"LAYOUT_ID"'."\r\n";

        $query = $this->db->query("SELECT id FROM cv_categories");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $csv_file .= '"'.$row->id.'";"0";"3"'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__category_to_layout.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvCatTexts()
    {
        $csv_file = '"CATEGORY_ID";"LANGUAGE_ID";"NAME";"DESCRIPTION";"META_TITLE";"META_DESCRIPTION";"META_KEYWORD"'."\r\n";

        $query = $this->db->query("SELECT id, name FROM cv_categories");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $name = cleantitle($row->name);
                $csv_file .= '"'.$row->id.'";"1";"'.$name.'";"";"Buy online chinese '.$name.'";"Buy cheap online at discounted prices '.$name.'";""'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__category_description.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvCatCommonData()
    {
        $csv_file = '"CATEGORY_ID";"IMAGE";"PARENT_ID";"TOP";"COLUMN";"SORT_ORDER";"STATUS";"DATE_ADDED";"DATE_MODIFIED"'."\r\n";

        $query = $this->db->query("SELECT id, name FROM cv_categories WHERE parentname = '' ORDER BY id");
        if ($query->num_rows() > 0)
        {
            $i=1;
            foreach ($query->result() as $row)
            {
                $csv_file .= '"'.$row->id.'";"";"0";"0";"1";"'.$i++.'";"1";"'.date('Y-m-d H:m:s').'";"'.date('Y-m-d H:m:s').'"'."\r\n";
                
                $query2 = $this->db->query("SELECT id FROM cv_categories WHERE parentname = '$row->name' ORDER BY id");
                if($query2->num_rows() > 0)
                {
                    $j=1;
                    foreach ($query2->result() as $row2)
                    {
                        $csv_file .= '"'.$row2->id.'";"";"'.$row->id.'";"0";"1";"'.$j++.'";"1";"'.date('Y-m-d H:m:s').'";"'.date('Y-m-d H:m:s').'"'."\r\n";
                    }
                }
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__category.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvCatHierarchy()
    {
        // http://stackoverflow.com/questions/15162193/opencart-how-to-accurately-populate-oc-category-path
        $csv_file = '"CATEGORY_ID";"PATH_ID";"LEVEL"'."\r\n";

        $query = $this->db->query("SELECT id, parentname FROM cv_categories ORDER BY id");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                if($row->parentname == '')
                {
                    $csv_file .= '"'.$row->id.'";"'.$row->id.'";"0"'."\r\n";
                }
                else
                {
                    $csv_file .= '"'.$row->id.'";"'.$row->id.'";"1"'."\r\n";
                    
                    $query2 = $this->db->query("SELECT id FROM cv_categories WHERE name = '$row->parentname' LIMIT 1");
                    if($query2->num_rows() > 0)
                    {
                        foreach($query2->result() as $row2)
                        {
                            $csv_file .= '"'.$row->id.'";"'.$row2->id.'";"0"'."\r\n";
                        }
                    }
                }
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__category_path.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

/**************************************************************************/
/************************ P R O D U C T ***********************************/
/**************************************************************************/
    function csvProdSeoUrlAlias()
    {
        $csv_file = '"URL_ALIAS_ID";"QUERY";"KEYWORD"'."\r\n";

        $query = $this->db->query("SELECT product_id, short_product_name, category_name, subcategory_name FROM cv_products");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $subCatSeo = '';
                if(!empty($row->subcategory_name))
                {
                    $subCatSeo = seofromname($row->subcategory_name).'/';
                }
                $seoUrl = seofromname($row->category_name).'/'.$subCatSeo.seofromname($row->short_product_name);
                $csv_file .= '"";"product_id='.$row->product_id.'";"'.$seoUrl.'.html"'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc_product__url_alias.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvProdStore()
    {
        $csv_file = '"PRODUCT_ID";"STORE_ID"'."\r\n";

        $query = $this->db->query("SELECT product_id FROM cv_products");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $csv_file .= '"'.$row->product_id.'";"0"'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__product_to_store.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvProdLayout()
    {
        $csv_file = '"CATEGORY_ID";"STORE_ID";"LAYOUT_ID"'."\r\n";

        $query = $this->db->query("SELECT product_id FROM cv_products");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $csv_file .= '"'.$row->product_id.'";"0";"3"'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__product_to_layout.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvProdTexts()
    {
        $csv_file = '"PRODUCT_ID";"LANGUAGE_ID";"NAME";"DESCRIPTION";"TAG";"META_TITLE";"META_DESCRIPTION";"META_KEYWORD";"SPECIFICATION"'."\r\n";

        $query = $this->db->query("SELECT product_id, full_product_name, overview, specification, meta_keyword, meta_description FROM cv_products");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {

                $csv_file .= '"'.$row->product_id.'";"1";"'.cleantitle($row->full_product_name).'";"'.cleantext(removebaflk($row->overview)).'";"";"Buy cheap online at discounted prices '.cleantitle($row->full_product_name).'";"Buy online chinese '.cleantext($row->meta_description).'";"'.cleantext($row->meta_keyword).'";"'.cleantext(removebaflk($row->specification)).'"'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__product_description.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvProdCommonData()
    {
        // statuses: In Stock | Out of Stock
        // continuity: Normal Product | Soon Discontinued
        $csv_file = '"PRODUCT_ID";"MODEL";"SKU";"UPC";"EAN";"JAN";"ISBN";"MPN";"LOCATION";"QUANTITY";"STOCK_STATUS_ID";"IMAGE";"MANUFACTURER_ID";"SHIPPING";"PRICE";"POINTS";"TAX_CLASS_ID";"DATE_AVAILABLE";"WEIGHT";"WEIGHT_CLASS_ID";"LENGTH";"WIDTH";"HEIGHT";"LENGTH_CLASS_ID";"SUBTRACT";"MINIMUM";"SORT_ORDER";"STATUS";"VIEWED";"DATE_ADDED";"DATE_MODIFIED";"CHINAVASION_PRICE"'."\r\n";
                    
        $query = $this->db->query("SELECT product_id, model_code, ean, main_picture, price, status, continuity FROM cv_products");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                
                // check quantity of products
                $quantity = 9999;
                if($row->status == 'Out of Stock')
                {
                    $quantity = 0;
                }
                elseif($row->continuity == 'Soon Discontinued')
                {
                    $quantity = 0;
                }

                $csv_file .= '"'.$row->product_id.'";"'.$row->model_code.'";"'.$row->model_code.'";"";"'.$row->ean.'";"";"";"";"";"'.$quantity.'";"7";"'.$row->main_picture.'";"0";"1";"'.mysellprice($row->price).'";"0";"0";"'.date('Y-m-d').'";"0";"1";"0";"0";"0";"1";"0";"1";"1";"1";"0";"'.date('Y-m-d H:m:s').'";"'.date('Y-m-d H:m:s').'";"'.$row->price.'"'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__product.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }


    function csvProdImgs()
    {
        // original:    http://cdn.chv.me/images/XWvnAaAn.jpg
        // thumbnail:   http://cdn.chv.me/images/thumbnails/XWvnAaAn.jpg.thumb_70x70.jpg
        $csv_file = '"PRODUCT_IMAGE_ID";"PRODUCT_ID";"IMAGE";"SORT_ORDER"'."\r\n";

        $query = $this->db->query("SELECT prod_id, img FROM cv_products_imgs ORDER BY prod_id");
        if ($query->num_rows() > 0)
        {
            $oldId = ''; // check if previous ID not equal current ID
            foreach ($query->result() as $row)
            {
                if($oldId != $row->prod_id)
                {
                    $i=1;
                    $oldId = $row->prod_id;
                }
                else
                {
                    $i++;
                }
                
                $csv_file .= '"";"'.$row->prod_id.'";"'.$row->img.'";"'.$i.'"'."\r\n";
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__product_image.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }
    }

    function csvProdCat()
    {
        $csv_file = '"PRODUCT_ID";CATEGORY_ID"'."\r\n";

        $query = $this->db->query("SELECT product_id, category_name, subcategory_name FROM cv_products");
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                // get category id based on category name
                $query2 = $this->db->query("SELECT id FROM cv_categories WHERE name = '$row->category_name'");
                if ($query2->num_rows() > 0)
                {
                    foreach ($query2->result() as $row2)
                    {
                        $csv_file .= '"'.$row->product_id.'";"'.$row2->id.'"'."\r\n";
                    }
                }

                // get category id based on child category name
                $query3 = $this->db->query("SELECT id FROM cv_categories WHERE name = '$row->subcategory_name'");
                if ($query3->num_rows() > 0)
                {
                    foreach ($query3->result() as $row3)
                    {
                        $csv_file .= '"'.$row->product_id.'";"'.$row3->id.'"'."\r\n";
                    }
                }
            }

            // $csv_file .= 'FINISH'."\r\n";

            $file_name = 'oc__product_to_category.csv';
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/upload/opencart\/';
    
            $file_path_name = $file_path . $file_name;
            $file = fopen($file_path_name,"w");
            fwrite($file,trim($csv_file));
            fclose($file);

            return $file_name;
        }        
    }

/**************************************************************************/
}
?>