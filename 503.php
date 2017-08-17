<?php
	global $upgrading;

	if (!isset($upgrading)) $upgrading = null;

	$protocol = $_SERVER["SERVER_PROTOCOL"];
	if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol ) $protocol = 'HTTP/1.0';
	header( $protocol . ' 503 Service Temporarily Unavailable', true, 503 );
	header( 'Status: 503 Service Temporarily Unavailable' );
	header( 'Content-Type: text/html; charset=utf-8' );

	if (!is_null($upgrading)) {
		header( 'Retry-After: ' . date('r', $upgrading) );
		//** set up cache
		header( 'Cache-Control: public' );
		header( 'Expires: ' . date('r', $upgrading) );
		header( 'vary: User-Agent');
		header( 'ETag: "' . date('YmdHis', $upgrading) . '-tsmp"' );

		$upgrading = 'after ' . date('j F Y', $upgrading);
	} else {
		$upgrading = 'shortly';
	}
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>503: Service Temporarily Unavailable</title>
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,300i" type="text/css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
	<style type="text/css">
		/* Open Sans, light=300, regular=400, bold=700 */
		body {
			margin: 0;
			font-family: "Open Sans", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
			font-size: 1rem;
			font-weight: 300;
			line-height: 1.5;
			color: #FFF;
			background-color: #069;
			text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
		}
		.glow {
			/* @see: http://colorzilla.com/gradient-editor/#006699+0,003366+100 */
			background: -moz-radial-gradient(center, ellipse cover, #006699 0%, #003366 100%); /* FF3.6-15 */
			background: -webkit-radial-gradient(center, ellipse cover, #006699 0%,#003366 100%); /* Chrome10-25,Safari5.1-6 */
			background: radial-gradient(ellipse at center, #006699 0%,#003366 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#006699', endColorstr='#003366',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
		}
		.page-wrap {
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			position: absolute;
     			display: table;
		}
		.content {
			text-align: center;
			display: table-cell;
			vertical-align: middle;
		}
		.the-icon {
			font-size: 2.5em;
		}
		.fa-inverse {
			color: #069;
		}
		.the-lead {
			font-weight: 300;
			font-style: normal;
			font-size: 1.5em;
		}
		.the-message {
			font-weight: 300;
			font-style: normal;
		}
	</style>
</head>
<body>
	<div class="page-wrap glow"><div class="content">
		<p><span class="fa-stack fa-lg the-icon">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-wrench fa-stack-1x fa-inverse"></i>
		</span></p>
		<p><b class="the-lead">Sorry, we're down for maintenence.</b></p>
		<p><i class="the-message">We'll be back <?= $upgrading?>.</i></p>
	</div></div>
</body>
</html>
