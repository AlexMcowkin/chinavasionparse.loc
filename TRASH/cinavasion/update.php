<?php include('simple_html_dom.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Updates</title>
	<link href='parcer_for_upd.css' rel='stylesheet' type='text/css' />
</head>
<body>

<div id="start">

<div class="update_links">
<?php
echo "Today is: <span class='today-date'>".date('Y-m-d').'</span>';
echo "<p>http://feeds.feedburner.com/chinavasion/Stock-Update</p>";
echo "<p>OR</p>";
echo "<p>http://blog.chinavasion.com/index.php/category/stock-update/</p>";
?>

<?php
// get data from FeedBurner URL
$xml = file_get_contents('http://feeds.feedburner.com/chinavasion/Stock-Update');
$xmlobj = new SimpleXMLElement($xml);
$namespaces = $xmlobj->getDocNamespaces();

// for the last Update Link
$feedburner_namespace = $xmlobj->channel->item[0]->children($namespaces['feedburner']);
echo '<br>';
$theLastUpdateLink = $feedburner_namespace->origLink;
echo '<br>';

// for All links in feedburner document

foreach($xmlobj->channel->item as $item)
{
	$feedburner_namespace = $item->children($namespaces['feedburner']);
	echo $feedburner_namespace->origLink ."<br />";
}

echo '</div><hr />';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST['submit_u']))
	{
		function see_updates() 
		{
			if (!empty($_POST['link']))  // for editing title for Folder Name
			{
				
				$link = $_POST['link'];
				$lin_arr = array();
				$kk = 0;
				$q = 1;
				
				// Create DOM from URL or file
				$html = file_get_html($link);
				
				foreach($html->find('div.pmain strong a') as $element)
				{
					// get the text
					$lnk = $element->innertext;
					$lin_arr[] =  $lnk;
					
					// get the link
					$lnk2 = $element->href;
					$lin2_arr2[] =  $lnk2;
					
					$kk = $kk+1;
					
				}
				
				$outQueries = '';  // make queries to DataBase
				
				echo '<table><tr><th>#</th><th>Status</th><th>Name</th><th>SKU</th></tr>';
				for ($i=0;$i<$kk;$i++)
				{
				
					if (strlen(strstr($lin_arr[$i],'Relisted:'))>0)  // if BuyNow
					{	
						echo '<tr><td>'.$i.'</td><td><font color="blue">Buy Now:</font></td>';
						$lin_arr[$i] = str_replace('Relisted:', '', $lin_arr[$i]);
						
						$pieces = explode('[', $lin_arr[$i]);
						echo '<td>'.$pieces[0].'</td>';   // product name
						
						echo '<td>'. $mysku = str_replace("]","", $pieces[1]).'</td></tr>';   // product code
												
						
						// ïîëó÷àåì ññûëêó íà ñòðàíèöó ïðîäóêòà
						/*
						$link3 = $lin2_arr2[$i];
						$html3 = file_get_html($link3);
						foreach($html3->find('div #current_price_div span.ccy') as $pricer)
						{
							echo '<tr><td colspan="3">'.$price = $pricer->innertext.'</td></tr>';  // íàõîäèì öåíó ïðîäóêòà çà 1 øòóêó
						}
						
						$outQueries .= "UPDATE jos_vm_product SET product_in_stock = '9999' WHERE product_sku = '".$mysku."';<br />";	
						*/
					}
					elseif (strlen(strstr($lin_arr[$i],'Offline:'))>0)
					{
						echo '<tr><td>'.$i.'</td><td><font color="red">Sold Out:</font></td>';
						$lin_arr[$i] = str_replace('Offline:', '', $lin_arr[$i]);
						
						$pieces = explode('[', $lin_arr[$i]);
						echo '<td>'.$pieces[0].'</td>';   // product name
						echo '<td>'. $mysku = str_replace("]","", $pieces[1]).'</td></tr>';   // product code
						
						$outQueries .= "UPDATE jos_vm_product SET product_in_stock = '0' WHERE product_sku = '".$mysku."';<br />";	
						
					}
					elseif (strlen(strstr($lin_arr[$i],'Delisted:'))>0)
					{
						echo '<tr><td>'.$i.'</td><td><font color="red">Out Of Stock 4ever:</font></td>';
						$lin_arr[$i] = str_replace('Delisted:', '', $lin_arr[$i]);
						
						$pieces = explode('[', $lin_arr[$i]);
						echo '<td>'.$pieces[0].'</td>';   // product name
						echo '<td>'. $mysku = str_replace("]","", $pieces[1]).'</td></tr>';   // product code
						
						$outQueries .= "UPDATE jos_vm_product SET product_in_stock = '0' WHERE product_sku = '".$mysku."';<br />";	
					}
				}
				echo '</table>';
				
				echo '<hr /><div class="queries_out">'.$outQueries.'</div>';
			}
			else echo '<p class="error">Insert Link</p>';
		}
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 ?>
 	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="titleForm" id="">
	<fieldset>
	<legend>Paste the Link:</legend>
		<input name="link" class="text-field-title" value="<?php echo $theLastUpdateLink; ?>" type="text" /><br />
		<input type="submit" value="Press Here" class="button" name="submit_u" />
	</fieldset>
    </form>
	
<hr />
	<?php if (isset($_POST['submit_u'])) @see_updates();?>
</div>
</body>
</html>