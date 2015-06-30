<?php
include("hacker_export.php");

$jvcx_file ='';

$sql_query = "SELECT category_parent_id, category_child_id, category_list FROM jos_vm_category_xref WHERE category_parent_id > 570 ORDER BY category_parent_id";
$res_query = mysql_query($sql_query);
	
	if ($res_query)
	{
		while ($row = mysql_fetch_assoc($res_query))
		{
			$jvcx_file .= '"'.$row["category_parent_id"].'","'.$row["category_child_id"].'","'.$row["category_list"].'"'."\r\n";
		}
	}
	else {echo 'No result';}
	
$td = date('-y-m-d-H-i');//current date
$out_file_name = 'jvcx_export.csv';
$file_name = 'jvcx/jvcx_export'.$td.'.csv';
$file = fopen($file_name,"w");
fwrite($file,trim($jvcx_file));
fclose($file);
	
header('Content-type: application/csv');
header("Content-Disposition: inline; filename=".$out_file_name);
readfile($file_name);

unlink($file_name);
?>