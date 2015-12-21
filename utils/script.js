<script type="text/javascript">
		$(function() {
		//LINK
			$('#modif_link').submit(function(e){	
				e.preventDefault();
				var link = $('#link_value').val();
				$.ajax({
				        url : "utils/update_link.php",
				        type : "POST",
				        data : "username=" + <?= '"'.$_SESSION['username'].'"' ?> + "&link=" + link,
				        success : function(code_html, statut){
		           			$('#link_value').val(link);
				       },
				       error : function(resultat, statut, erreur){
				       		$("#modif_link").append("Erreur lors de la modification");
				       }
		    	});
			});
		//STREAMERS
			function actualize_streamers(){
				$('#streamers').load('utils/streamers.php');
				//setTimeout(actualize_streamers, 2000);
			}
			actualize_streamers();

			$("#button_actualize_streamers").click(function(e){
				actualize_streamers();
			})

			$('#streamers').submit(function(e){
				e.preventDefault();
				var link = $('input[name=streamers_tolisten]:checked').val();
				$('#player').html("<audio controls autoplay name='media'><source src='"+ link +"' ></audio>");
			});

		//CHAT
			function load_chat_messages(){
				$('#chat_messages').load("utils/chat_messages.php");
				setTimeout(load_chat_messages, 2000);
			}
			load_chat_messages();

			function insert_chat_message(){
				var message = $('#message').val();
				$('#message').val("");
				var date = <?= '"'.date('d/m/Y H:i:s').'"' ?>;
				if(message != "" && message != " "){
				    $.ajax({
				        url : "utils/add_message.php",
				        type : "POST",
				        data : "username=" + <?= '"'.$_SESSION['username'].'"' ?> + "&message=" + message + "&time=" + date,success : function(code_html, statut){
		           			load_chat_messages();
		           			$('#message_chat_error').text("");
				       },
				       error : function(resultat, statut, erreur){
				       		$('#message_chat_error').text("Erreur lors de l'envoi du message");
				       }
				    });
				}else{
					$('#message_chat_error').text("Veuillez entrer un message non vide");
				}
			}

			$('#new_message').submit(function(e){
				e.preventDefault();
				insert_chat_message();
			});

			$('#message').keyup(function(e) {
		      	if(e.keyCode == 13 && !event.shiftKey) {
		            insert_chat_message();
		       }
			});

			//DECONNECT STREAMERS WHEN THEY QUIT
			$(window).bind('beforeunload', function(){
				//return "Vous allez être déconnecté de GroovYou !";
				 $.ajax({
				        url : "utils/deco.php",
				        type : "POST"
				    });
			});
		});
	</script>