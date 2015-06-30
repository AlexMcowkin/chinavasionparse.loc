<?php
include("hacker_export.php");

$jvpp_file ='';

$sql_query = "SELECT product_price_id, product_id, product_price, product_currency, product_price_vdate, product_price_edate, cdate, mdate, shopper_group_id, price_quantity_start, price_quantity_end FROM jos_vm_product_price WHERE product_id > 8330 ORDER BY product_price_id";
$res_query = mysql_query($sql_query);
	
	if ($res_query)
	{
		while ($row = mysql_fetch_assoc($res_query))
		{
			$jvpp_file .= '"'.$row["product_price_id"].'","'.$row["product_id"].'","'.$row["product_price"].'","'.$row["product_currency"].'","'.$row["product_price_vdate"].'","'.$row["product_price_edate"].'","'.$row["cdate"].'","'.$row["mdate"].'","'.$row["shopper_group_id"].'","'.$row["price_quantity_start"].'","'.$row["price_quantity_end"].'"'."\r\n";
		}
	}
	else {echo 'No result';}
	
$td = date('-y-m-d-H-i');//current date
$out_file_name = 'jvpp_export.csv';
$file_name = 'jvpp/jvpp_export'.$td.'.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($jvpp_file));
fclose($file);
	
header('Content-type: application/csv');
header("Content-Disposition: inline; filename=".$out_file_name);
readfile($file_name);

unlink($file_name);
?>