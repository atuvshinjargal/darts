/**
 * 
 */
function goBack()
  {
  window.history.back()
  }
function click(url){
	var x;
	var r=confirm("Та устгахдаа итгэлтэй байна уу");
	if (r==true)
	  {
		window.location.href = url;
	  }
}
function success(url){
	var x;
	var r=confirm("Та дуусгахдаа итгэлтэй байна уу");
	if (r==true)
	  {
		window.location.href = url;
	  }
}
$(document).ready(function () {
    /* assuming that text input datePicker would have id='datePicker' */
    $( "#startdate" ).datepicker({ dateFormat: 'yy-mm-dd' });

});