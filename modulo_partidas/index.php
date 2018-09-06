<?php

include "php/conexion.php";
include "php/functions.php";
$categories = get_base_categories();
?>
<html>
	<head>
		<title>.: CATEGORIAS, SUBCATEGORIAS Y MAS :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	</head>
	<body>
	<?php include "php/navbar.php"; ?>
	<div class="container">
	<div class="row">
	<div class="col-md-12">
	<h1>CATEGORIAS</h1>

<?php if(count($categories)>0):?>
	<ul>
	<?php foreach($categories as $cat):?>
		<li><?php echo $cat["p_nombre"]." ".edit_btn($cat["id"])." ".del_btn($cat["id"]);?> </li>
		<?php
		list_tree_cat_id($cat["id"]);
		?>
	<?php endforeach;?>
	</ul>
<?php else:?>
	<p class="alert alert-danger">No hay categorias</p>
<?php endif;?>

	</div>
	</div>
	</div>
	</body>
</html>
