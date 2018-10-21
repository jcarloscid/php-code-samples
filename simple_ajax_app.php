<?php 
/**
 * Sample code to demostrate AJAX.
 *
 * When it is called via AJAX, it returns some dynamic content (the <select> element)
 * When called to process a POST request, it prints out form fields as a HTML document.
 */

if ( (isset($_POST['textfield'])) || (isset($_POST['radiob'])) || (isset($_POST['numberfield'])) ) { 
/* This is the processing of a POST request */
?>
	<!DOCTYPE html>
	<html>
	<body>
		<h1>Form data</h1>
		<p>Text: <?php print $_POST['textfield']; ?> </p>
		<p>Choice: <?php if (isset($_POST['radiob'])) print $_POST['radiob']; else print 'not set'; ?> </p>
		<p>Number: <?php print $_POST['numberfield']; ?> </p>
		<p>Selection: <?php if (isset($_POST['radiob'])) print $_POST['selectfield']; else print 'only available with Java Script'; ?> </p>
		<a href='ajax_sample.html'>Go back to form page</a>
	</body>
	</html>
<?php 
} else { 
/* This is the part returned on a AJAX call */
?>
	<p>This dynamic contetnt is obtained via AJAX:</p>
	<select name="selectfield" id="selectfield">
		<option value="no set">Select an item</option>
		<option value="volvo">Volvo</option>
		<option value="saab">Saab</option>
		<option value="mercedes">Mercedes</option>
		<option value="audi">Audi</option>
	</select>
<?php 
}	
?>
