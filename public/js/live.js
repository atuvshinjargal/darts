/**
 * 
 */
function change(){
	$.ajax({
		url:window.location.pathname,
		type:"GET",
		data:"format=json",
		async:false,
		success: function(response){
			response=JSON.parse(response);
			$('#score1').html(response.data[0]["score"]);
			$('#score2').html(response.data[1]["score"]);
			$('#liveScore1').html(response.data[0]["liveScore"]);
			$('#liveScore2').html(response.data[1]["liveScore"]);
			$('#lastScore1').html(response.data[0]["lastScore"]);
			$('#lastScore2').html(response.data[1]["lastScore"]);
			
		}});
}
$(document).ready(function(){
	setInterval(function(){change()},1000);
	});