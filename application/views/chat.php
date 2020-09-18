<!DOCTYPE html>
<html>
<head>
	<title>Aplikasi Chat</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-6 m-auto">
				<div id="pesan">				
				<?php foreach ($chat as $list) {
					echo "<p><span><b>$list->name</b></span> - <span>$list->message</span></p>";
				} ?>
				</div>
				<div class="form-group">
					<input type="text" name="name" id="name" class="form-control" placeholder="name">
				</div>
				<div class="form-group">
					<input type="text" name="message" id="message" class="form-control" placeholder="your message">
				</div>	
				<div class="form-group">
					<input type="button" value="send" class="btn btn-primary btn-block" onclick="store();">
				</div>				
			</div>
		</div>
	</div>

  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('31083d6937811666ff88', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      /*alert(data);*/
      addData(data);
    });

    function addData(data){
    	var str = '';
    	for(var z in data){
    		str += '<p><span><b>'+data[ z ].name+'</b></span> - <span>'+data[ z ].message+'</span></p>';
    	}
    	$('#pesan').html(str);
    }

  </script>
<script>
	function store(){ 
		var value = {
			name: $('#name').val(),
			message: $('#message').val()
		}

		$.ajax({
 				url: '<?=site_url();?>/chat/store',
 				type: 'POST',
 				data: value,
 				dataType: 'JSON',
		});
	}
</script>	

</body>
</html>