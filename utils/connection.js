<script type="text/javascript">
	$(function() {
		$(window).bind('beforeunload', function(){
			//return "Vous allez être déconnecté de GroovYou !";
			 $.ajax({
			        url : "utils/connection.php",
			        type : "POST",
			        data : "from_unload=1"
			    });
		});
		$(window).bind('load', function(){
			 $.ajax({
			        url : "utils/connection.php",
			        type : "POST",
			        data : "from_load=1"
			    });
		});
	});
</script>