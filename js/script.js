$(document).ready(function(){
	
	var sitename = location.protocol + '//' + location.hostname;

	$('#dataparcebuttontgp').hide();
	$('#dataparcebuttongac').hide();
	$('#dataparcebuttongbo').hide();
	$('#urlparceurlbuttongbo').hide();
	$('#urlparcebuttongbo').hide();
	$('#dataparcebuttonwgcgvn').hide();
	
	$('#preloader').hide();
	
/****************************************************/
/***** PARCE ALL PRODUCTS FROM CATEGORY**************/
/****************************************************/
	$(document).on("click", '#parcebutton', function(e){
	
		e.preventDefault();

		var catid = $(this).attr('rel');
		var form_data = {catid:catid};

		$(this).attr('disabled', true);

		$.post(sitename + "/index.php/chinavasioncontroller/parcecategoryproducts",form_data,function(result)
		{
			
			// $('#resultblock').hide();
			// $('#dataparcebuttontgp').attr('disabled', true);
			// / $('#dangerblock').show();
			// $('#resultblock2').append("<h4>Total: <span id='current'>0</span> from " + result + "</h4><hr />");
			alert(result);
		});
	});


});