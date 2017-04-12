<?php

	$msg = $_GET['msg'];
	
	$nomes = ['Joao', 'Paulo', 'Ricardo', 'Jane', 'Carlos', 'Samuel', 'Mariana',
	          'Monica', 'Gabriela', 'Maria', 'Sergio', 'Etienne', 'Manuela',
	          'Jaqueline', 'Guilherme', 'Samuel', 'Celio', 'Marcio', 'Rodrigo',
	          'Marcia', 'Melissa', 'Vanessa', 'Carla', 'Silvia', 'Danielle'
	          ];
	          
	$rnd = array_rand($nomes, 1);
	 
	$msg = str_replace('{nome}', $nomes[$rnd], $msg);
	          
	/****************************************
	 * Retorna informaçao limpa
	 
	 * @author DTSC Engenharia de Sistemas
	 */
	function textToSMS ($str, $replace=array(), $delimiter=' ') {
			
		setlocale(LC_ALL, 'en_US.UTF8');
	    
	    if( !empty($replace) ) {
	        $str = str_replace((array)$replace, ' ', $str);
	    }
		
	    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	 
	    return $clean;
	}

?>
<!DOCTYPE html>
<html >
   <head>
      <meta charset="UTF-8">
      <title>InovAtiva Brasil - Simulador de SMS</title>
      <link rel="stylesheet" href="css/reset.css">
      <style>
         @import "http://fonts.googleapis.com/css?family=Open+Sans:400,600,700";
         * {
         box-sizing: border-box;
         }
         body {
         background-image: url("img/iphone5_mini.png");
         background-repeat: no-repeat;
         background-position: center;
         background-position: 50% 50px; 
         background-size: 350px 650px;
         color: #FFFFFF;
         font-family: "Open Sans";
         font-size: 14px;
         line-height: 26px;
         max-width: 300px;
         margin: 0 auto;
         overflow-X: hidden;
         position: relative;
         }
         .left {
         position: absolute;
         top: 0;
         left: 30px; /* mensagens esquerda */
         font-size: 14px
         }
         .left:after {
         border: 2px solid #2095FE;
         border-right: 2px solid transparent;
         border-top: 2px solid transparent;
         content: " ";
         height: 8px;
         width: 8px;
         left: -20px;
         position: absolute;
         top: 23px;
         -webkit-transform: rotate(45deg);
         -moz-transform: rotate(45deg);
         transform: rotate(45deg);
         
         }
         .right {
         position: absolute;
         top: 0;
         right: 15px;
         font-size: 14px; /* contato */
         }
         header {
         color: #2095FE;
         width: 293px;
         top:160px;
         left:5px;
         position: absolute;
         background: #eee;
         border: 1px solid #ccc;
         border-bottom: 1px solid #bbb;
         box-shadow: 0 1px 2px rgba(1,1,1,0.2);
         height: 60px;
         text-align: center;
         font-size: 14px; /* inovativa */
         line-height: 58px;
         white-space: nowrap;
         }
         header h2 {
         font-weight: bold;
         color: #111111;
         }
         .messages-wrapper {
         padding-top: 10px;
         position: absolute;
         top: 230px;
         left: 5px;
         border: 0px solid #ddd;
         border-top: 0 none;
         }
         .message {
         border-radius: 20px 20px 20px 20px;
         margin: 0 15px 10px;
         padding: 5px 20px;
         position: relative;
         }
         .message.to {
         background-color: #2095FE;
         color: #fff;
         margin-left: 80px;
         }
         .message.from {
         background-color: #E5E4E9;
         color: #363636;
         margin-right: 80px;
         max-width: 300px;
         }
         .message.to + .message.to,
         .message.from + .message.from {
         margin-top: -7px;
         }
         .message:before {
         border-color: #2095FE;
         border-radius: 50% 50% 50% 50%;
         border-style: solid;
         border-width: 0 20px;
         bottom: 0;
         clip: rect(20px, 35px, 42px, 0px);
         content: " ";
         height: 40px;
         position: absolute;
         right: -50px;
         width: 30px;
         z-index: -1;
         }
         .message.from:before {
         border-color: #E5E4E9;
         left: -50px;
         transform: rotateY(180deg);
         }
      </style>
      <script src="js/prefixfree.min.js"></script>
   </head>
   <body>

      <header>
         <span class="left">Mensagens</span>
         <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;InovAtiva</h2>
         <span class="right">Contato</span>
      </header>
      
  	  <audio autoplay style="display:none;">
	     <source src="sound/messages.mp3" type="audio/mpeg">
	  </audio>      
      <div class="messages-wrapper" id="msgSMS"></div>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
   </body>
   
   <script src="../../../../../../_plataforma/media/js/plugins/jquery-1.10.1.min.js"></script>
   
   
   <script>
		   
   		function addMsg(classe, msg) {
   			$('#msgSMS').append ('<div class="message ' + classe + '">' + msg + '</div>');
   		}
   		
   		setTimeout(function(){
   			addMsg('from', '<?php echo textToSMS ($msg) ?>')
   		}, 1000);
		
		setTimeout(function(){
			addMsg('to', 'Obrigado, vou acessar a plataforma.');
		}, 2600);   		
   		
   </script>
</html>