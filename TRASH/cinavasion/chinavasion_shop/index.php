<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>ReMake Text</title>
	<link href='parcer.css' rel='stylesheet' type='text/css' />
	<script type="text/javascript" src="parcer.js"></script>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
	<script src='jquery.bbcode.js' type='text/javascript'></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#test").bbcode({tag_bold:true,tag_italic:true,tag_underline:true,tag_link:true,tag_image:true,button_image:false});
		process();
	});
	
		var bbcode="";
		function process()
		{
			if (bbcode != $("#test").val())
			{
				bbcode = $("#test").val();
				$.get('bbParser.php',
				{
					bbcode: bbcode
				},
				function(txt)
				{
					$("#preview").html(txt);
				})
			
			}
			setTimeout("process()", 2000);
		}
	</script>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST['submit_t']))
	{
		function see_title() 
		{
			if (!empty($_POST['title']))  // for editing title for Folder Name
			{
				 global $HTTP_POST_VARS;
				
				echo "<p class='suplier'>Product Tile:</p><p class='weare'>".$_POST['title']."</p>";
		
					$title = $_POST['title'];
					$title = strtolower($title);
					$title = str_replace(' - ', '-', $title);
					$title = str_replace(' ', '-', $title);
					$title = str_replace('.', '', $title);
					$title = str_replace('(', '', $title);
					$title = str_replace(',', '', $title);
					$title = str_replace('/', '', $title);
					$title = str_replace('\\', '', $title);
					$title = str_replace('\'', '', $title);
					$title = str_replace('"', '', $title);
					$title = str_replace('#', '', $title);
					$title = str_replace('%', '', $title);
					$title = str_replace('@', '', $title);
					$title = str_replace('?', '', $title);
					$title = str_replace('$', '', $title);
					$title = str_replace('*', '', $title);
					$title = str_replace('~', '', $title);
					$title = str_replace('!', '', $title);
					$title = str_replace('^', '', $title);
					$title = str_replace('&', '', $title);
					$title = str_replace('=', '', $title);
					$title = str_replace('+', '', $title);
					$title = str_replace(')', '', $title);
					$title = str_replace(':', '-', $title);
					$title = str_replace('\'', '', $title);
					$title = str_replace('–', '-', $title);
					$title = str_replace('_', '-', $title);
				
				//$title = preg_replace('/\(.*\)/', '', $title); //delete all data between ()
				if (substr($title, -1) == '-') $title = substr($title, 0, -1 );
		
				echo "<p class='suplier'>Gallery Name:</p><p class='weare'>$title</p>";
				
				$gallery = htmlentities('<p>{gallery}'.$title.'{/gallery}</p>');
				
				echo "<p class='suplier'>Gallery Code:</p><p class='weare'>$gallery</p>";
				
				$_POST['title'] = $title;
				
			}
		else echo '<p class="error">Insert Title</p>';
		}
	}
	
	elseif (isset($_POST['submit_p']))
	{
		function see_price() 
		{
			if (!empty($_POST['price']))  // for editing Price
			{
			
				echo "<p class='suplier'>Supplier Price:</p><p class='weare'>".$_POST['price']."</p>";
		
				$price = $_POST['price'];
			
				$price = str_replace('$', '', $price);
				$price = (float)$price*1.13;  //umnojaiu na 13 procentov
				$price = number_format($price, 2, '.', ''); // obrezaiu s okrugleniem do 2 znaka posle tocki
		
				echo "<p class='suplier'>Our Price(+13%):</p><p class='weare'>$price</p>";
			}
			else echo '<p class="error">Insert Price</p>';
		}
	}
	elseif (isset($_POST['submit_m']))
	{
		function see_description() 
		{
			if (!empty($_POST['comment']))  // for editing Description
			{
				$message = $_POST['comment'];
				$message = str_replace('Chinavasion', 'Elite-Electronix', $message);
				$message = str_replace('chinavasion', 'Elite-Electronix', $message);
				
				$message = str_replace('benefits;', 'benefits:', $message);
				
				$message = str_replace('[http://screencast.com/t/SBc7GG6ZXXci]', '<img alt="USB debugging first" title="USB debugging first" src="http://www.elite-electronix.com/images/stories/help-files/debugging.png" />', $message);
		
				$message = str_replace('[http://dl.dropbox.com/u/10073935/Pics/2010-11-23_1011.png]', '<img alt="pop up" title="pop up" src="http://www.elite-electronix.com/images/stories/help-files/popup.png" />', $message);
		
				$message = str_replace('[http://dl.dropbox.com/u/10073935/Pics/2010-11-23_1031.png]', '<img alt="option" title="option" src="http://www.elite-electronix.com/images/stories/help-files/option.png" />', $message);
				
				$message = preg_replace('/\[(.*)\]/','<a href="$1" target="_blank" rel="nofollow">$1</a>',$message);
				
				echo "<br /><br />";
				echo "<p class='new-description' id='tpost_1'>";
				echo htmlspecialchars ($message);
				echo "</p>";
				
			}
		}
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 ?>
 <?php /*
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="priceForm" id="">
	<fieldset>
	<legend>Enter Price:</legend>
		<input name="price" class="text-field-price" value="" type="text" />
		<input type="submit" value="Calculate Price" class="button" name="submit_p" />
	<?php if (isset($_POST['submit_p'])) @see_price();?>
    </fieldset>
	</form>

<hr />
*/
?>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="titleForm" id="">
	<fieldset>
	<legend>Enter Title:</legend>
		<input name="title" class="text-field-title" value="" type="text" /><br />
		<input type="submit" value="Get Title" class="button" name="submit_t" />
	<?php if (isset($_POST['submit_t'])) @see_title();?>
	</fieldset>
    </form>
<?php /*	
<hr />

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="messageForm" id="comment_form">
	<fieldset>
	<legend>Enter Description:</legend>
	<?php echo "<p><span>Gallery Name:</span><br /><br /><span2>".@$_POST['title']."</span2></p>";?>
<table border='0'  cellspacing='0' cellpadding='0'>
<tr>
	<td class='htmlButtonOuterL'>
	<div class='htmlButtonInner'>
		<div class='htmlButtonOff' id='button_0'><a href='javascript:nullo();' title="Bold Text" name='button_0' onclick='taginsert(this, "<strong>", "</strong>")' >&lt;Strong&gt;&lt;/Strong&gt;</a></div>
	</div>
	</td>

	<td class='htmlButtonOuter'>
		<div class='htmlButtonInner'>
			<div class='htmlButtonOff' id='button_1'>
			<a href='javascript:nullo();' title="Make Paragraph" name='button_1' onclick='taginsert(this, "<p>", "</p>")' >&lt;P&gt;&lt;/P&gt;</a>
			</div>
	</div>
	</td>

	<td class='htmlButtonOuter'>
	<div class='htmlButtonInner'>
		<div class='htmlButtonOff' id='button_2'>
		<a href='javascript:nullo();' title="Make Gallery" name='button_2' onclick='taginsert(this, "<p>{gallery}", "{/gallery}</p>")' >Gallery</a></div>
	</div>
	</td>

	<td class='htmlButtonOuter'>
	<div class='htmlButtonInner'>
		<div class='htmlButtonOff' id='button_3'>
		<a href='javascript:nullo();' title="Make Border of List" name='button_3' onclick='taginsert(this, "<ul>", "</ul>")' >&lt;UL&gt;&lt;/UL&gt;</a></div>
	</div>
	</td>

	<td class='htmlButtonOuter'>
	<div class='htmlButtonInner'>
		<div class='htmlButtonOff' id='button_4'>
		<a href='javascript:nullo();' title="One Line from List" name='button_4' onclick='taginsert(this, "<li>", "</li>")' >&lt;Li&gt;&lt;/Li&gt;</a></div>
	</div>
	</td>
	
	<td class='htmlButtonOuter'>
	<div class='htmlButtonInner'>
		<div class='htmlButtonOff' id='button_5'>
		<a href='javascript:nullo();' title="Make Break" name='button_5' onclick='taginsert(this, "", "<br />")' >&lt;/Br&gt;</a></div>
	</div>
	</td>
	
	<td class='htmlButtonOuter'>
	<div class='htmlButtonInner'>
		<div class='htmlButtonOff' id='button_6'>
		<a href='javascript:nullo();' title="Start List Line" name='button_6' onclick='taginsert(this, "<li>", "")' >&lt;Li&gt;</a></div>
	</div>
	</td>
	
	<td class='htmlButtonOuter'>
	<div class='htmlButtonInner'>
		<div class='htmlButtonOff' id='button_7'>
		<a href='javascript:nullo();' title="End List Line" name='button_7' onclick='taginsert(this, "", "</li>")' >&lt;/Li&gt;</a></div>
	</div>
	</td>
	
	<td class='htmlButtonOuter'><div class='htmlButtonInner'><div class='htmlButtonOff'><a href='javascript:promptTag("email");' >&nbsp;E-Mail&nbsp;</a></div></div></td>

	<td class='htmlButtonOuter'><div class='htmlButtonInner'><div class='htmlButtonOff'><a href='javascript:promptTag("link");' >&lt;Link&gt;</a></div></div></td>

	<td class='htmlButtonOuter'><div class='htmlButtonInner'><div class='htmlButtonOff'><a href='javascript:promptTag("images");' >IMG</a></div></div></td>
	
	<!-- <td class='htmlButtonOuter'><div class='htmlButtonInner'><div class='htmlButtonOff'><a href='javascript:closeall();' >Close All</a></div></div></td> -->

</tr>
</table> 
<?php if (isset($_POST['submit_m'])) see_description(); ?>    
	<textarea name="comment" id="test" cols="javascript:max_cols();" rows="javascript:max_cols();" WRAP="virtual" ></textarea>
	<br />
    <input type="submit" value="Make All Text" class="button" name="submit_m" />  
</fieldset>
</form>	
*/ ?>
</body>
</html>