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
	<h1>NUEVA CATEGORIA</h1>
	<form role="form" method="post" action="./php/actions.php?do=new">
	  <div class="form-group">
	    <label for="name">Titulo</label>
	    <input type="text" name="name" required class="form-control" id="name" placeholder="Titulo">
	  </div>
	  <div class="form-group">
	    <label for="category_id">Categoria Padre</label>
	    <select class="form-control" name="id_categoria" id="category_id">
	    	<option value="">-- CATEGORIA SUPERIOR --</option>
			<?php if(count($categories)>0):?>
				<?php foreach($categories as $cat):?>
					<option value="<?php echo $cat["id"];?>" ><?php echo $cat["p_nombre"];?></option>
					<?php select_tree_cat_id($cat["id"],1); ?>
				<?php endforeach;?>
			<?php endif;?>
	    </select>
	  </div>
	  <button type="submit" class="btn btn-primary">AGREGAR CATEGORIA</button>
	</form>
	</div>
	</div>
	</div>
	</body>
</html>
