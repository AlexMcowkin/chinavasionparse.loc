<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>New Products List</title>
	<link href='prod_new.css' rel='stylesheet' type='text/css' />
</head>
<body>

<div id="today">
<?php
	$yestr_date = date('d F Y',strtotime("-1 days"));
	echo "Curent date: <span class='today_date'>".date('Y-m-d').'</span>';
	echo "<br />Yesterday date: <span class='yester_date'>".$yestr_date.'</span>';
	echo '<p><a class="xml_link" href="http://rss.chinavasion.com/new_products.xml" target="_blank">http://rss.chinavasion.com/new_products.xml</a></p>';
	echo '<p class="gd_link"><a href="https://docs.google.com/spreadsheet/ccc?key=0AlvRvKLbKtYcdFM5T2xnbTVrU2NtZVctTElFT194S0E#gid=0" target="_blank">Chinavasion GoogleDocs Stock Update</a></p>';
?>
</div>

<?php
$get_url = file_get_contents('http://rss.chinavasion.com/new_products.xml');
$xml = new SimpleXmlElement($get_url);
echo '<table width="100%" cellspacing="2" cellpadding="4" border="0">';
echo '<tr><th>Title</th><th>Link</th><th>Date</th></tr>';
foreach ($xml->channel->item as $entry)
{
    echo '<tr><td>'.$entry->title.'</td>';
    echo '<td><a target="_blank" href="'.$entry->link.'">'.$entry->link.'</a></td>';
	
	// we hahe date in such construction  dc:date
	$namespaces = $entry->getNameSpaces(true); 
	$dc = $entry->children($namespaces['dc']);
	
	$yestr_prod = date('d F Y',strtotime($dc->date));
	
	if ($yestr_date == $yestr_prod) {echo '<td><span style="color:red;">'.$yestr_prod.'</span></td></tr>';}
	else {echo '<td>'.$yestr_prod.'</td></tr>';}
}
echo '</table>';
?>
</div>
</body>
</html>