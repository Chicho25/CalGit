<?php
include "php/conexion.php";
include "php/functions.php";
$cat = get_cat_by_id($_GET["id"]);
$categories = get_base_categories();

?>
<?php if($cat!=null):?>
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
	<h1>EDITAR CATEGORIA</h1>
	<form role="form" method="post" action="./php/actions.php?do=update">
	  <div class="form-group">
	    <label for="name">Titulo</label>
	    <input type="text" name="name" value="<?php echo $cat["p_nombre"]; ?>" required class="form-control" id="name" placeholder="Titulo">
	  </div>
	  <div class="form-group">
	    <label for="category_id">Categoria Padre</label>
	    <select class="form-control" name="category_id" id="category_id">
	    	<option value="">-- CATEGORIA SUPERIOR --</option>
			<?php if(count($categories)>0):?>
				<?php foreach($categories as $c):?>
					<option value="<?php echo $c["id"];?>" <?php if($cat["id_categoria"]==$c["id"]){ echo "selected"; }?> ><?php echo $c["p_nombre"];?></option>
					<?php selected_tree_cat_id($c["id"],1,$cat["id"],$cat["id_categoria"]); ?>
				<?php endforeach;?>
			<?php endif;?>
	    </select>
	  </div>
	  <input type="hidden" name="id" value="<?php echo $cat["id"]; ?>">
	  <button type="submit" class="btn btn-success">ACTUALIZAR CATEGORIA</button>
	</form>
	</div>
	</div>
	</div>
	</body>
</html>
<?php endif;?>
