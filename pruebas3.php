<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title></title>
		<style media="screen">
			.cuadro{
				display: none;
			}
		</style>
	</head>
	<body>
		<div class="caja" onmouseover="bigImg(this)" onmouseout="normalImg(this)"> Seleccionar
			<div class="cuadro">Resultado</div>
		</div>
		<div class="caja" onmouseover="bigImg(this)" onmouseout="normalImg(this)"> Seleccionar
			<div class="cuadro">Resultado</div>
		</div>
		<div class="caja" onmouseover="bigImg(this)" onmouseout="normalImg(this)"> Seleccionar
			<div class="cuadro">Resultado</div>
		</div>
		<div class="caja" onmouseover="bigImg(this)" onmouseout="normalImg(this)"> Seleccionar
			<div class="cuadro">Resultado</div>
		</div>
		<div class="caja" onmouseover="bigImg(this)" onmouseout="normalImg(this)"> Seleccionar
			<div class="cuadro">Resultado</div>
		</div>
		<script>
		function bigImg(x) {
		    x.style.height = "64px";
		    x.style.width = "64px";
		    var cu = x.querySelector(".cuadro");
		    cu.style.width = "300px";
		    cu.style.height = "300px";
		    cu.style.border = "3px black solid";
		    cu.style.background.color = "green";
				cu.style.display = "block";
		}

		function normalImg(x) {
		    x.style.height = "32px";
		    x.style.width = "32px";
				var cu = x.querySelector(".cuadro").style.display = "none";
		}
		</script>
	</body>
</html>
