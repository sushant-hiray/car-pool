    <!DOCTYPE html>
    <html>
    <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    </head>
    <body>
			<h1>Plan a Tour!</h1>
				<div id="response"></div>

			<form method="post" action="save_comment.php">
							
				<div><input type="text" name="From" placeholder="From" value=""/></div>
					<div class="inputs">
				 </div>
				<div><input type="text" name="To" placeholder="To" value=""/></div>
					 <input type="hidden" id="total" name="totalRequests" value=1 >
				   <input class="btn" type="submit" name="SUBMIT" value="Submit">
					
      </form>
				<div class="btn-group">
				<button class="btn" id ="add">Add Hop</button>
				<button class="btn" id="remove">Delete Hop</button>
				<button class="btn" id="reset">Reset Hop(Sorry Rahega!)</button>
				</div>


    <script src="http://code.jquery.com/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
     <script  >
		$(document).ready(function(){
		
		
				var i = $('.inputs').size() ;
				var nameName = "dyanmic" + i;	
				$('#add').click(function() {
						$('<div><input type="text" class="field" placeholder="Hop " +"' +i+'" name="'+ nameName+'"   value="" /></div>').fadeIn('slow').appendTo('.inputs');
						i++;
						var fields= Number($("#total").val())+Number(1);
						$("#total").val(fields);
						
				});
				
				$('#remove').click(function() {
				if(i > 1) {
						$('.field:last').remove();
						var fields= Number($("#total").val())-Number(1);
						i--;
				}
				});
				
				$('#reset').click(function() {
				while(i >= 1) {
						$('.field:last').remove();
						var fields= Number($("#total").val())-Number(1);
						i--;
				}
				});
				
				// here's our click function for when the forms submitted
				/*
				$('#submit').click(function(){
						var answers = [];
						$.each($('.field'), function() {
						answers.push($(this).val());

						 });
						var request = $.ajax({
						url: "save_comment.php",
						type: "POST",
						data: {
						post: answers
						},
						dataType: "json"
						});
						request.done(function (msg) {
								if(msg.status == "success") {
												$("#response").html("hi");

								}		
						});

				if(answers.length == 0) {
						answers = "none";
				}  
				

				
				$.post("save_comment.php",{name:$("#total").val(), time:"2pm"})
				.done(function(data){
								alert("Data Loaded: " + data);
				//alert(answers);	
				});
												
				});
		
				*/
		
		});
		</script>
		</body>
    </html>
