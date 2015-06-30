<?php 
echo 'Export these TABLES if "NEW PRODUCTS"';
echo '<ul>
		<li><a href="http://test/export/jvc_export.php" title="jos_vm_category">export Category</a></li>
		<li><a href="http://test/export/jvcx_export.php" title="jos_vm_category_xref">export Category Xref</a></li>
		<li><a href="http://test/export/jvpcx_export.php" title="jos_vm_product_category_xref">export Product Category Xref</a></li>
		<li><a href="http://test/export/jvpmx_export.php" title="jos_vm_product_mf_xref">export Product Mf Xref</a></li>
	</ul>';
?>
<?php 
echo '<hr />';
echo 'Export these TABLES if "BuyNow / SoldOut"';
echo '<ul>
		<li><a href="http://test/export/jvp_export.php" title="jos_vm_product">export Products</a></li>
		<li><a href="http://test/export/jvpp_export.php" title="jos_vm_product_price">export Products Price</a></li>
	</ul>';
?>