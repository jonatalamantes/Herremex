<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Herremex</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="Recursos/css/styleLogin.css">
	<link rel="stylesheet" href="Recursos/css/font-awesome.css">
	<script type="text/javascript" src="Ajax/ajax.js"></script>
</head>
<body onkeypress="keyPress(event);">
<header>Herremex</header>
<section class = "login">
	<table class="bodylogin">
		<tr>
			<td>
				<p class="txtlogin" id = 'txtloginu'>
					<span class="fa fa-user"></span> Usuario:
				</p>
			</td>
			<td class="tablei">
				<input name="txtUsuario" type="text" id="txtUsuario" placeholder="Usuario" placeholder=":input" class="inputs" onclick="normalBackground();" onkeyup="pressKey('txtUsuario', '18');">
			</td>
		</tr>
		<tr>
			<td>
				<p class="txtlogin" id = 'txtloginp'>
					<span class="fa fa-lock"></span> Password:
				</p>
			</td>
			<td class="tablei">
				<input name="txtPassword" type="password" id="txtPassword" placeholder="••••••••" class="inputs"  onclick="normalBackground();">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<button class="hvr-skew-forward" onclick = 'validadUsuario();'>
					Acceder <span class="fa fa-signin"></span>
				</button>
			</td>
		</tr>
	</table>
</section>

</body>

</html>