<?php
$cell = 1;
$connect = mysql_connect("openserver:3306","root","");
mysql_select_db("electronix",$connect);

$result = mysql_query('SELECT * FROM jos_vm_product');   // WHERE productid > 8339

if(mysql_num_rows($result) != 0)
	{
		$count = mysql_num_rows($result);
		echo '<table cellpadding="3" width="75%"><tr style="background-color:#aaa;"><th>Category</th><th>Name</th><th>SKU</th><th>Price</th><th>DHL</th><th>HKP</th></tr>';
		for ($n = 0; $n < 20; $n++)   // $count!!!!!!!!!!!!!!!!!!!
		{
			if ($cell == 1) {echo '<tr style="background-color: #eee;">';}
			if ($cell == 0) {echo '<tr style="background-color: #ddd;">';}
			
			
			$row = mysql_fetch_array($result);
			
			$prod_id = $row['product_id'];
			
			// get PRICE var
			$price_q = mysql_query('SELECT product_price FROM jos_vm_product_price WHERE product_id = '.$prod_id.' LIMIT 1');
			while($row_p = mysql_fetch_array($price_q))
			{
				$price = substr($row_p['product_price'],0,-3).' USD';
			}
			
			// get CATEGORY list
			echo '<td>';
			$category_l = mysql_query('SELECT category_id FROM jos_vm_product_category_xref WHERE product_id = '.$prod_id);
			while($row_l = mysql_fetch_array($category_l))
			{
				$categ_id = $row_l['category_id'];
				$categ_name_q = mysql_query('SELECT category_name FROM jos_vm_category WHERE category_id = '.$categ_id);
				while($row_cat_q = mysql_fetch_array($categ_name_q))
				{
					echo $row_cat_q['category_name'].'<br />';
					
				}
			}
			echo '</td>';
			
			echo '<td>'.$row['product_name'];
			if ($row['product_in_stock'] == 0) {echo '<br /><span style="color:red;font-size:12px;">( SoldOut )</span></td>';}
			else '</td>';
			echo '<td>'.$row['product_sku'].'</td>';
			echo '<td>'.$price.'</td>';
						
			//echo '<td>'.$row['dhl_ship_price'].'</td>';
			//echo '<td>'.$row['hkp_ship_price'].'</td>';
			echo '</tr>';
			if ($cell == 0) {$cell = 1;} else {$cell = 0;}
		}
		echo '</table>';
	}
mysql_close($connect);
?>