$(window).load(function()
{
	$("#bodypreload").fadeOut("slow");
});


/****************************************************/
/***** PARSE ALL PRODUCTS FROM CATEGORY**************/
/****************************************************/
jQuery(document).ready(function()
{
	// hide #back-top first
	jQuery("#back-top").hide();
	
	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 200) {
				jQuery('#back-top').fadeIn();
			} else {
				jQuery('#back-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		jQuery('#back-top a').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
});
/****************************************************/

$(document).ready(function(){
	
	var sitename = location.protocol + '//' + location.hostname;

	$('body #preloader_button').hide();

/****************************************************/
/***** PARSE ALL PRODUCTS FROM CATEGORY**************/
/****************************************************/
	$(document).on("click", '#parcebutton', function(e){
	
		e.preventDefault();

		var catid = $(this).attr('rel');
		var form_data = {catid:catid};

		$.ajax({
			url : sitename + "/index.php/chinavasioncontroller/parcecategoryproducts",
			type : 'POST',
			data : form_data,
			beforeSend: function() {
				$('#trcatid_' + catid + ' img').show();
				$(this).attr('disabled', true);
			},
			complete: function() {
				$('#trcatid_' + catid + ' img').hide();
			},	
			success : function(msg)
			{
				$('#tdcatid_' + catid).html('<span class="text-success">PARSED: ' + msg + ' products</span>');S
			},
			error: function(msg)
			{
				alert(msg);
			}
		});		
	});
/****************************************************/
});