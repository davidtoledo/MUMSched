<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="utf-8" />
		<title>MUM Schedule</title>

		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="author" content="http://www.dtsc-it.com" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css' />
		<link rel="shortcut icon" href="{{ URL::to('_plataforma/media/img/ico/favicon.ico') }}" />
		
		@yield('header_elements')

		{{ HTML::style('_plataforma/media/css/base.css?v=' . $global_app_version , array('media' => 'screen')) }}
		
		{{ HTML::style('_plataforma/media/css/plugins/jslider.css?v=' . $global_app_version , array('media' => 'screen')) }}
		{{ HTML::style('_plataforma/media/css/plugins/jslider.blue.css?v=' . $global_app_version , array('media' => 'screen')) }}
		{{ HTML::style('_plataforma/media/css/plugins/jslider.plastic.css?v=' . $global_app_version , array('media' => 'screen')) }}
		{{ HTML::style('_plataforma/media/css/plugins/jslider.round.css?v=' . $global_app_version , array('media' => 'screen')) }}
		{{ HTML::style('_plataforma/media/css/plugins/jslider.round.plastic.css?v=' . $global_app_version , array('media' => 'screen')) }}
				
		<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/font-awesome.css') }}" />

		@yield('estilo_header')

		{{ HTML::style('_plataforma/media/css/custom.css?v=' . $global_app_version, array('media' => 'screen')) }}

		<!--[if lt IE 9]><script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<!--[if IE 8]>{{ HTML::style('_plataforma/media/css/ie8.css?v=' . $global_app_version) }} <![endif]-->
		<!--[if IE 7]>{{ HTML::style('_plataforma/media/css/ie7.css?v=' . $global_app_version) }} <![endif]-->
	</head>