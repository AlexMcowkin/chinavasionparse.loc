<?php
include("hacker_export.php");

$jvp_file ='';

$sql_query = "SELECT product_id, vendor_id, product_parent_id, product_sku, product_s_desc, product_desc, product_thumb_image, product_full_image, product_publish, product_weight, product_weight_uom, product_length, product_width, product_height, product_lwh_uom, product_url, product_in_stock, product_available_date, product_availability, product_special, product_discount_id, ship_code_id, cdate, mdate, product_name, product_sales, attribute, custom_attribute, product_tax_id, product_unit, product_packaging, child_options, quantity_options, child_option_ids, product_order_levels FROM  jos_vm_product WHERE product_id > 8333 ORDER BY product_id";
$res_query = mysql_query($sql_query);
	
	if ($res_query)
	{
		while ($row = mysql_fetch_assoc($res_query))
		{
			$row["product_name"] = str_replace('\'','', $row["product_name"]); //delete all <'> from Product Name field
			
			$jvp_file .= '"'.$row["product_id"].'";"'.$row["vendor_id"].'";"'.$row["product_parent_id"].'";"'.$row["product_sku"].'";"";"";"'.$row["product_thumb_image"].'";"'.$row["product_full_image"].'";"'.$row["product_publish"].'";"'.$row["product_weight"].'";"'.$row["product_weight_uom"].'";"'.$row["product_length"].'";"'.$row["product_width"].'";"'.$row["product_height"].'";"'.$row["product_lwh_uom"].'";"'.$row["product_url"].'";"'.$row["product_in_stock"].'";"'.$row["product_available_date"].'";"'.$row["product_availability"].'";"'.$row["product_special"].'";"'.$row["product_discount_id"].'";"'.$row["ship_code_id"].'";"'.$row["cdate"].'";"'.$row["mdate"].'";"'.$row["product_name"].'";"'.$row["product_sales"].'";"'.$row["attribute"].'";"'.$row["custom_attribute"].'";"'.$row["product_tax_id"].'";"'.$row["product_unit"].'";"'.$row["product_packaging"].'";"'.$row["child_options"].'";"'.$row["quantity_options"].'";"'.$row["child_option_ids"].'";"'.$row["product_order_levels"].'"'."\r\n";
		}
	}
	else {echo 'No result';}
	
$td = date('-y-m-d-H-i');//current date
$out_file_name = 'jvp_export.csv';
$file_name = 'jvp/jvp_export'.$td.'.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($jvp_file));
fclose($file);
	
header('Content-type: application/csv');
header("Content-Disposition: inline; filename=".$out_file_name);
readfile($file_name);

unlink($file_name);
?>