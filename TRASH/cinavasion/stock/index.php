<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Stock List</title>
	<style>
	
		th{
			background-color: #999;
			height: 18px;
			font-size: 14;
		}
		td{	
			background-color: #F8F8F8;
			padding: 5px;
			vertical-align: middle;
			font-size:12px;
		}
	</style>
</head>
<body>
<?php
error_reporting(0); // Выключаем показ ошибок. Чтобы их видеть - вместо 0 поставьте E_ALL

include('hacker.php');

function uploadForm()
{
	echo '<p><a href="https://docs.google.com/spreadsheet/ccc?key=0AlvRvKLbKtYcdFM5T2xnbTVrU2NtZVctTElFT194S0E#gid=0" target="_blank">Chinavasion GoogleDocs Stock Update</a></p>';
	echo '<p>Insert The File</p>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="filename" size="20" /><br />
		
		<br /><input type="text" name="chinaData" value="2012-" /> !!! - date like in chinavasion google document [ year-month-day = '.date("Y-m-d").' ]
		
		<input type="hidden" name="update" value="ok" />
		<br /><br /><input type="submit" value="Upload" />
	</form>';
}

$max_file_size = 10; // Максимальный размер файла в МегаБайтах
if($_POST['update']=='ok')
{
	$curChangeData = trim($_POST['chinaData']);
	if(strlen($curChangeData) != 10)
	{
		echo 'wrong DATA';
		exit;
	}
	else
	{
		// СТАРТ Загрузка файла на сервер
		if($_FILES["filename"]["size"] > $max_file_size*1024*1024)
		{
			echo 'The SIZE of File is more than '.$max_file_size.' Mb!';
			uploadForm();
			exit;
		}
		if(copy($_FILES["filename"]["tmp_name"],$path.$_FILES["filename"]["name"]))
		{
			echo("The file "."<b>".$_FILES["filename"]["name"]."</b>"." was imported to server successfully!<br />");
			echo '<a href="http://www.elite-electronix.com/chinavasion_shop/stock/">go back</a>';
		}
		else
		{
			echo 'Error of Uploading<br>';
			uploadForm();
			exit;
		}
    
		setlocale(LC_ALL, 'en_US.utf8'); // Определяем параметры локали
		if(setlocale(LC_ALL, 0) == 'C') die('Your server does not suport LOCALS');
    
		$file = fopen('php://memory', 'w+');
		fwrite($file, iconv('CP1251', 'UTF-8', file_get_contents($_FILES["filename"]["name"])));
		rewind($file);
    
	
		$r = 0;
		$html = '';
		//$yesterDate = date('Y-m-d',strtotime("-1 days"));
	
		echo '<table width="100%" cellspacing="2" cellpadding="4" border="0">';
		echo '<tr><th>#</th><th>Date</th><th>SKU</th><th>Name</th><th>Link</th><th>Status</th></tr>';
    
		while (($row = fgetcsv($file, 1000, ",")) != FALSE)
		{
			$r++;
			$nomer = ($r-2); // текущая строка минус 2 -> для порядкого номера
		
			if($r == 1) {continue;} // пропуск первой строки
			if($r == 2) {continue;} // пропуск второй строки
		
			$sku = $row['1'];
			$link = $row['3'];
			$link = '<a href="'.$link.'" target="_blank">'.$link.'</a>';
		
			//if ($row["4"] == 'Product open, back on line') $stat = '<span style="color:blue;">BuyNow</span>';
			//elseif ($row["4"] == 'Product closed, put offline') $stat = '<span style="color:red;">SoldOut</span>';
		
			if ($row['0'] == $curChangeData)
			{
				//$html .= '<tr><td>'.$nomer.'</td><td>'.$row["0"].'</td><td>'.$row["1"].'</td><td>'.$row["2"].'</td><td>'.$link.'</td><td>'.$stat.'</td></tr>';
				//if ($row["4"] == 'Product open, back on line') $sql .= "UPDATE jos_vm_product SET product_in_stock = '99999' WHERE product_sku = '".$sku."';<br />";
				if ($row["4"] == 'Product open, back on line')
				{
					$html .= '<tr><td>'.$nomer.'</td><td>'.$row["0"].'</td><td>'.$row["1"].'</td><td>'.$row["2"].'</td><td><span style="color:blue;">'.$link.'</span></td><td>'.$stat.'</td></tr>';
				}
				elseif ($row["4"] == 'Product closed, put offline')
				{
					$sql = "UPDATE jos_vm_product SET product_in_stock = '0' WHERE product_sku = '".$sku."';";
					$query = mysql_query($sql);
					if(!$query) die('Error Update Data');
				}
			}
			//if ($row["4"] == 'Product open, back on line') $sql .= "UPDATE jos_vm_product SET product_in_stock = '99999' WHERE product_sku = '".$sku."';<br />";
			//if ($row["4"] == 'Product closed, put offline') $sql .= "UPDATE jos_vm_product SET product_in_stock = '0' WHERE product_sku = '".$sku."';<br />";
		}
		echo $html;
		echo '</table>';
		fclose($file);
		//echo 'Обработано строк - '.$r;

	}	
}
else
{
    uploadForm();
}
?>
</body>
</html>