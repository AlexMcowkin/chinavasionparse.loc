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

            $csv_file .= 'FINISH'."\r\n";

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
        $result = array();

        $query = $this->db->query("SELECT sku, price FROM oc_products");

        if ($query->num_rows() > 0)
        {
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
            return 'No Data.';
        }
    }

/**************************************************************************/
/**************************************************************************/
/**************************************************************************/


}
?>