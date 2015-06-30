<?php
include("hacker_export.php");

$jvpcx_file ='';

$sql_query = "SELECT category_id, product_id, product_list FROM jos_vm_product_category_xref WHERE category_id > 570 ORDER BY category_id";
$res_query = mysql_query($sql_query);
	
	if ($res_query)
	{
		while ($row = mysql_fetch_assoc($res_query))
		{
			$jvpcx_file .= '"'.$row["category_id"].'","'.$row["product_id"].'","'.$row["product_list"].'"'."\r\n";
		}
	}
	else {echo 'No result';}
	
$td = date('-y-m-d-H-i');//current date
$out_file_name = 'jvpcx_export.csv';
$file_name = 'jvpcx/jvpcx_export'.$td.'.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($jvpcx_file));
fclose($file);
	
header('Content-type: application/csv');
header("Content-Disposition: inline; filename=".$out_file_name);
readfile($file_name);

unlink($file_name);
?>