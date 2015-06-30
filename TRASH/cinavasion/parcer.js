var selField  = 'comment';
var selMode   = "normal";

var url_text      = "Enter the hyperlink URL";
var webpage_text  = "Enter the title of the link";
var title_text	  = "Optional: Enter a title attribute";
var image_text    = "Enter the image URL";
var email_text    = "Enter the email address";
var email_title   = "Enter the link title (or leave the field empty to use the email address as the title.)";
var enter_text    = "Enter the text you want to format";
var images_text    = "Enter the Image name";
var images_title   = "Enter the Tile of the Link";


var button_0 = 0;
var button_1 = 0;
var button_2 = 0;
var button_3 = 0;
var button_4 = 0;


tagarray  = new Array();
usedarray = new Array();

function nullo()
{
	return;
}
		
//  State change

function styleswap(link)
{
	if (document.getElementById(link).className == 'htmlButtonOff')
	{
		document.getElementById(link).className = 'htmlButtonOn';
	}
	else
	{
		document.getElementById(link).className = 'htmlButtonOff';
	}
}

//  Set button mode

function setmode(which)
{	
	if (which == 'guided')
		selMode = 'guided';
	else
		selMode = 'normal';
}

// Clear state

function clear_state()
{
	if (usedarray[0])
	{
		while (usedarray[0])
		{
			clearState = arraypop(usedarray);
			
			eval(clearState + " = 0");
			
			document.getElementById(clearState).className = 'htmlButtonOff';
		}
	}	
}

// Array size

function getarraysize(thearray)
{
	for (i = 0; i < thearray.length; i++)
	{
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
		{
			return i;
		}
	}
	
	return thearray.length;
}        

// Array push

function arraypush(thearray, value)
{
	thearray[getarraysize(thearray)] = value;
}

// Array pop

function arraypop(thearray)
{
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}

// Insert single tag

function singleinsert(tagOpen)
{		
	eval("document.getElementById('comment_form')." + selField + ".value += tagOpen");	
	
	curField = eval("document.getElementById('comment_form')." + selField);
	curField.blur();
	curField.focus();	
}


// Insert font color and size

function selectinsert(item, tag)
{
	var selval =  item.options[item.selectedIndex].value;
		
    if (selval == 0)
    	return;

	var tagOpen		= '<' + tag + '=' + selval + '>';
	var tagClose	= '</' + tag + '>';
		
	taginsert('other', tagOpen, tagClose, 'menu');
}

// Insert tag

var tagarray  	= new Array();
var usedarray 	= new Array();
var running		= 0;

function taginsert(item, tagOpen, tagClose, type)
{
	// Determine which tag we are dealing with

	var which = eval('item.name');
	
	var theSelection = false;  
	var result		 = false;
	eval("var theField = document.getElementById('comment_form')." + selField + ";");
		
	if (selMode == 'guided')
	{
		data = prompt(enter_text, "");
		
		if ((data != null) && (data != ""))
		{
			result = tagOpen + data + tagClose;		
		}
	}
	
	// one branch for Firefox/Safari/Opera, another for IE
	if (window.getSelection && (theSelection = window.getSelection()) != false)
	{
		theSelection = window.getSelection();

		var selLength = theField.textLength;
		var selStart = theField.selectionStart;
		var selEnd = theField.selectionEnd;
		if (selEnd <= 2 && typeof(selLength) != 'undefined')
			selEnd = selLength;

		var s1 = (theField.value).substring(0,selStart);
		var s2 = (theField.value).substring(selStart, selEnd)
		var s3 = (theField.value).substring(selEnd, selLength);

		s2 = (result == false) ? tagOpen + theSelection + tagClose : result;
		
		theSelection = '';
	
		theField.value = s1+s2+s3;
		theField.blur();
		theField.focus();
		
		return;
	}
	else if (document.selection) 
	{
		theSelection = document.selection.createRange().text;
		
		theField.focus();
	
		if (theSelection)
		{
			document.selection.createRange().text = (result == false) ? tagOpen + theSelection + tagClose : result;
		}
		else
		{
			document.selection.createRange().text = (result == false) ? tagOpen + tagClose : result;
		}
		
		theSelection = '';
		
		theField.blur();
		theField.focus();
		
		return;
	}
	else if ( ! isNaN(theField.selectionEnd))
	{
		var scrollPos = theField.scrollTop;
		var selLength = theField.textLength;
		var selStart = theField.selectionStart;
		var selEnd = theField.selectionEnd;
		if (selEnd <= 2 && typeof(selLength) != 'undefined')
			selEnd = selLength;

		var s1 = (theField.value).substring(0,selStart);
		var s2 = (theField.value).substring(selStart, selEnd)
		var s3 = (theField.value).substring(selEnd, selLength);
		
		if (result == false)
		{
			var newStart = selStart + tagOpen.length + s2.length + tagClose.length;
		
			theField.value = (result == false) ? s1 + tagOpen + s2 + tagClose + s3 : result;
		}
		else
		{
			var newStart = selStart + result.length;
		
			theField.value = s1 + result + s3;
		}
		
		theField.focus();
		theField.selectionStart = newStart;
		theField.selectionEnd = newStart;
		theField.scrollTop = scrollPos;
		return;
	}
	else if (selMode == 'guided')
	{
		eval("document.getElementById('comment_form')." + selField + ".value += result");			
		
		curField = eval("document.getElementById('comment_form')." + selField);
		curField.blur();
		curField.focus();	
		return;		
	}
	
		
	// Add single open tags
	
	if (item == 'other')
	{
		if (tagClose)
		{
			eval("document.getElementById('comment_form')." + selField + ".value += tagOpen + tagClose");
		}
		else
		{
			eval("document.getElementById('comment_form')." + selField + ".value += tagOpen");
		}
	}
	else if (eval(which) == 0)
	{
		var result = tagOpen;
		
		eval("document.getElementById('comment_form')." + selField + ".value += result");			
		eval(which + " = 1");
		
		arraypush(tagarray, tagClose);
		arraypush(usedarray, which);
		
		running++;
					   
		styleswap(which);
	}
	else
	{
		// Close tags
	
		n = 0;
		
		for (i = 0 ; i < tagarray.length; i++ )
		{
			if (tagarray[i] == tagClose)
			{
				n = i;
				
				running--;
				
				while (tagarray[n])
				{
					closeTag = arraypop(tagarray);
					eval("document.getElementById('comment_form')." + selField + ".value += closeTag");			
				}
				
				while (usedarray[n])
				{
					clearState = arraypop(usedarray);
					eval(clearState + " = 0");
					document.getElementById(clearState).className = 'htmlButtonA';
				}						
			}
		}
	}
	
	curField = eval("document.getElementById('comment_form')." + selField);
	curField.blur();
	curField.focus();
}

// Prompted tags

function promptTag(which)
{

	if ( ! which)
		return;
		
	// Is this a Windows user?  
		
	var theSelection = "";    
	eval("var theField = document.getElementById('comment_form')." + selField + ";");
	
	if ((navigator.appName == "Microsoft Internet Explorer") &&
		(navigator.appVersion.indexOf("Win") != -1))
	{
		theSelection = document.selection.createRange().text; 
	}
	else if (theField.selectionEnd && (theField.selectionEnd - theField.selectionStart > 0))
	{
		var selLength = theField.textLength;
		var selStart = theField.selectionStart;
		var selEnd = theField.selectionEnd;
		if (selEnd <= 2 && typeof(selLength) != 'undefined')
			selEnd = selLength;

		var s1 = (theField.value).substring(0,selStart);
		var s2 = (theField.value).substring(selStart, selEnd)
		var s3 = (theField.value).substring(selEnd, selLength);
		theSelection = s2;
	}
	
	// Create Link
	if (which == "link")
	{
		var URL = prompt(url_text, "http://");
				
		if ( ! URL || URL == 'http://' || URL == null)
			return; 
		
		var Name = prompt(webpage_text, theSelection);
		
		if ( ! Name || Name == null)
			return; 
				
		var Link = '<a href="' + URL + '">' + Name + '</a>';
	}
	
	
	if (which == "email")
	{
		var Email = prompt(email_text,"");
		
		if ( ! Email || Email == null)
			return; 
			
		var Title = prompt(email_title, theSelection);
		
		if (Title == null)
			return; 
	
		if (Title == "")
			Title = Email;
	
		var Link = '<a href="' + 'mailto:' + Email + '">' + Title + '</a>';                
	}
	
	
	
	
	
		if (which == "images")
	{
		var Images = prompt(images_text,"");
		
		if ( ! Images || Images == null)
			return; 
			
		var Title = prompt(images_title, theSelection);
		
		if (Title == null)
			return; 
	
		if (Title == "")
			Title = Images;
	
		var Link = '<img src="http://www.elite-electronix.com/images/stories/help-files/' + Images + '" title="' + Title + '" />';                
	}
	
	
	
	
	
	
	
	
	

	if ((navigator.appName == "Microsoft Internet Explorer") &&
		(navigator.appVersion.indexOf("Win") != -1))
	{
		if (theSelection != "")
		{
			document.selection.createRange().text = Link;
		}
		else
		{
			eval("document.getElementById('comment_form')." + selField + ".value += Link");			
		}
	}
	else if (theField.selectionEnd && (theField.selectionEnd - theField.selectionStart > 0))
	{
		theField.value = s1 + Link + s3;
	}
	else
	{
		eval("document.getElementById('comment_form')." + selField + ".value += Link");			
	}
	
	curField = eval("document.getElementById('comment_form')." + selField);
	curField.blur();
	curField.focus();
}

// Close all tags

function closeall()
{	
	if (tagarray[0])
	{
		while (tagarray[0])
		{
			closeTag = arraypop(tagarray);
						
			eval("document.getElementById('comment_form')." + selField + ".value += closeTag");			
		}
	}
	
	clear_state();	
	curField = eval("document.getElementById('comment_form')." + selField);
	curField.focus();
}