$(document).ready(function() {
   	
	$('.mySelect').on('change', function() {
		var questionVal = $(this).val();
		var chkClass = $(this).hasClass('mySelect-1');
   		if(chkClass){
   			$('.mySelect-2 option').each(function (index, value){
   				if(questionVal != '' && questionVal == $(this).val()){
   					$('.mySelect-2 option').prop('disabled', false);
   					$(this).prop('disabled', true);
   				}
   			});
   		}else{
   			$('.mySelect-1 option').each(function (index, value){
   				if(questionVal != '' && questionVal == $(this).val()){
   					$('.mySelect-1 option').prop('disabled', false);
   					$(this).prop('disabled', true);
   				}
   			});
   		}
	});
	
});