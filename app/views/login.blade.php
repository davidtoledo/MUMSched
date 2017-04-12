<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>MUMSched</title>
		<link href="{{ URL::to('_plataforma/media/css/login.css') }}" rel="stylesheet" type="text/css">
		<link rel="shortcut icon" href="{{ URL::to('_plataforma/media/img/ico/favicon.ico') }}" />
	</head>
	
	<body bgcolor="#CFCFCF">
		
	   @if (count($errors) > 0)
	   		@foreach ($errors->all() as $message)
	   			<div id="campo-mensagem" class="erro"><h3>{{ $message }}</h3></div>
	   		@endforeach
	   		
   	   @elseif (Session::has('success'))
   			<div id="campo-mensagem" class="sucesso"><h3>{{ Session::get('success') }}</h3></div>
	   @else
	   		<div id="campo-mensagem" class="erro" style="visibility: hidden;"></div>
	   @endif  
	   	  
	   <div id="container-formulario"><br>
	      <h1><br>Welcome</h1><br>
	        <br>
	        {{ Form::open ( array('url' => route('auth'), 'id' => 'frm')) }}
	        
		        <div id="formulario">
		            <label>User</label>
		            {{ Form::text('username', '', array( 'id' => 'cadastro-email', 'class' => 'campo', 'placeholder' => 'Username')) }}
		            <br><br>
		            <label>Pass</label>
					{{ Form::password('password', array( 'id' => 'cadastro-senha', 'class' => 'campo', 'placeholder' => 'Password')) }}
				
		        </div>    
	        
		        <a href="{{-- URL::to('login/request') --}}"><h2>Forgot your password?</h2></a>
		        {{ Form::submit('Submit', array( 'id' => 'cadastro-salvar', 'class' => 'botao-logar') ) }}
		    {{ Form::close() }}
	   </div>  
	
	</body>
</html>