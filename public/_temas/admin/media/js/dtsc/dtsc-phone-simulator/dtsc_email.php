<?php

	$texto = $_GET['msg'];	
	$titulo = $_GET['assunto'];
	
	$nomes = ['Joao', 'Paulo', 'Ricardo', 'Jane', 'Carlos', 'Samuel', 'Mariana',
	          'Monica', 'Gabriela', 'Maria', 'Sergio', 'Etienne', 'Manuela',
	          'Jaqueline', 'Guilherme', 'Samuel', 'Celio', 'Marcio', 'Rodrigo',
	          'Marcia', 'Melissa', 'Vanessa', 'Carla', 'Silvia', 'Danielle'
	          ];
	          
	$rnd = array_rand($nomes, 1);	 
	$texto = str_replace('{nome}', $nomes[$rnd], $texto);
?>
<html>
<head>
	<title>Inovativa Brasil</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="portuguese" />
	<meta name="author" content="DTSC Engenharia de Sistemas" />
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >

<!-- HEADER -->
	<table width="640" height="178" border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td colspan="3" width="640" height="25">
				
		</tr>
		<tr>
			<td width="38" height="153">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/inovativa_02.jpg" width="38" height="153" alt="" border="0"></td>
			<td width="166" height="153">
					<a href="http://www.inovativabrasil.com.br/" target="_blank" title="Inovativa Brasil">
					<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/logo_grand.jpg" width="166" height="153" border="0" alt=""></a></td>
			<td width="436" height="153">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/inovativa_04.jpg" width="436" height="153" alt="" border="0"></td>
		</tr>
	</table>
<!-- END HEADER -->

<!-- CONTENT -->
	<table width="640" height="178" border="0" cellpadding="0" cellspacing="0" align="center">
		<tbody>
			<tr>
				<td style="padding:50px 40px 0 40px;">
					<p>
						<font style="color:#0066cc; font-family:'Trebuchet MS', Helvetica, Arial, sans-serif; font-size:32px; font-weight:bold;"><?php echo $titulo ?>
						</font>
					</p>
				</td>
			</tr>

			<tr>
				<td style="padding:5px 40px 15px 40px;">
					<p>
					<font style="color:#333333; font-family:'Trebuchet MS', Helvetica, Arial, sans-serif; font-size:18px;"></font></p>
				</td>
			</tr> 

			<tr>
				<td style="padding: 0 40px 0 40px">
					<p><font style="font-family:'Trebuchet MS',Arial,Helvetica,sans-serif;font-size:16px;color:#5c5c5c">
							<? echo $texto ?>
							<br><br>Para acessar a plataforma de mentoria, <a href='#2'>clique aqui</a>.
						</font>
					</p>
				</td>
			</tr>
			<tr>
				<td style="padding:40px 50px 50px 0px;" align="right">
					<p style="color:#0066cc; font-family:'Trebuchet MS', Helvetica, Arial, sans-serif; font-size:18px;" >
					Equipe InovAtiva</p>
				</td>
			</tr>
		</tbody>
	</table>
<!-- END CONTENT -->

<!-- FOOTER -->
	<table width="640" height="76" border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td colspan="7" width="640" height="20">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/rodade_01.jpg" width="640" height="20" alt="" style="display:block;"></td>
		</tr>
		<tr>
			<td rowspan="2" width="38" height="56">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/rodade_02.jpg" width="38" height="56" alt="" style="display:block;"></td>
			<td width="178" height="35">
				<a href="http://www.inovativabrasil.com.br/" target="_blank" title="Inovativa Brasil">
					<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/inovativa_footer.jpg" width="178" height="35" border="0" alt="" style="display:block;"></a></td>
			<td rowspan="2" width="310" height="56">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/rodade_04.jpg" width="310" height="56" alt="" style="display:block;"></td>
			<td width="32" height="35">
				<a href="https://www.facebook.com/InovativaBrasil" target="_blank" title="facebook">
					<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/inovativa_footer-05.jpg" width="32" height="35" border="0" alt="" style="display:block;"></a></td>
			<td rowspan="2" width="11" height="56">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/rodade_06.jpg" width="11" height="56" alt="" style="display:block;"></td>
			<td width="32" height="35">
				<a href="http://www.youtube.com/inovativabrasil2014" target="_blank" title="youtube">
					<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/inovativa_footer-07.jpg" width="32" height="35" border="0" alt="" style="display:block;"></a></td>
			<td rowspan="2" width="39" height="56">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/rodade_08.jpg" width="39" height="56" alt="" style="display:block;"></td>
		</tr>
		<tr>
			<td width="178" height="21">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/rodade_09.jpg" width="178" height="21" alt="" border="0" style="display:block;"></td>
			<td width="32" height="21">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/rodade_10.jpg" width="32" height="21" alt="" border="0" style="display:block;"></td>
			<td width="32" height="21">
				<img src="http://inovativabrasil.com.br/plataforma/_plataforma/media/img/emkt/rodade_11.jpg" width="32" height="21" alt="" border="0" style="display:block;"></td>
		</tr>
	</table>
<!-- END FOOTER -->

</body>
</html>