<?php
include("hacker_export.php");

$jvpmx_file ='';

$sql_query = "SELECT product_id, manufacturer_id FROM jos_vm_product_mf_xref WHERE product_id > 8330 ORDER BY product_id";
$res_query = mysql_query($sql_query);
	
	if ($res_query)
	{
		while ($row = mysql_fetch_assoc($res_query))
		{
			$jvpmx_file .= '"'.$row["product_id"].'","'.$row["manufacturer_id"].'"'."\r\n";
		}
	}
	else {echo 'No result';}
	
$td = date('-y-m-d-H-i');//current date
$out_file_name = 'jvpmx_export.csv';
$file_name = 'jvpmx/jvpmx_export'.$td.'.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($jvpmx_file));
fclose($file);
	
header('Content-type: application/csv');
header("Content-Disposition: inline; filename=".$out_file_name);
readfile($file_name);

unlink($file_name);
?>