<?php
include("hacker_export.php");

$jvc_file ='';

$sql_query = "SELECT category_id, vendor_id, category_name, category_description, category_thumb_image, category_full_image, category_publish, cdate, mdate, category_browsepage, products_per_row, category_flypage, list_order FROM jos_vm_category WHERE category_id > 570 ORDER BY category_id";
$res_query = mysql_query($sql_query);
	
	if ($res_query)
	{
		while ($row = mysql_fetch_assoc($res_query))
		{
			$jvc_file .= '"'.$row["category_id"].'","'.$row["vendor_id"].'","'.$row["category_name"].'","'.$row["category_description"].'","'.$row["category_thumb_image"].'","'.$row["category_full_image"].'","'.$row["category_publish"].'","'.$row["cdate"].'","'.$row["mdate"].'","'.$row["category_browsepage"].'","'.$row["products_per_row"].'","'.$row["category_flypage"].'","'.$row["list_order"].'"'."\r\n";
		}
	}
	else {echo 'No result';}
	
$td = date('-y-m-d-H-i');//current date
$out_file_name = 'jvc_export.csv';
$file_name = 'jvc/jvc_export'.$td.'.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($jvc_file));
fclose($file);
	
header('Content-type: application/csv');
header("Content-Disposition: inline; filename=".$out_file_name);
readfile($file_name);

unlink($file_name);
?>