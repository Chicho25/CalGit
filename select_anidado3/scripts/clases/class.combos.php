<?php

class selects extends MySQL
{
	var $code = "";

	function cargarPaises()
	{
		$consulta = parent::consulta("SELECT id_proyecto, proy_nombre_proyecto FROM maestro_proyectos ORDER BY proy_nombre_proyecto ASC");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$paises = array();
			while($pais = parent::fetch_assoc($consulta))
			{
				$code = $pais["id_proyecto"];
				$name = $pais["proy_nombre_proyecto"];
				$paises[$code]=$name;
			}
			return $paises;
		}
		else
		{
			return false;
		}
	}
	function cargarEstados()
	{
		$consulta = parent::consulta("SELECT id_grupo_inmuebles, gi_nombre_grupo_inmueble FROM grupo_inmuebles WHERE gi_id_proyecto = '".$this->code."'");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$estados = array();
			while($estado = parent::fetch_assoc($consulta))
			{
				$name = $estado["gi_nombre_grupo_inmueble"];
				$code = $estado["id_grupo_inmuebles"];
				$estados[$code]=$name;
			}
			return $estados;
		}
		else
		{
			return false;
		}
	}

	function cargarCiudades()
	{
		$consulta = parent::consulta("SELECT
																		mi.id_inmueble,
																		mi.mi_nombre,
																		mi.mi_precio_real
																	FROM
																		maestro_inmuebles mi
																	WHERE
																	mi.id_grupo_inmuebles = '".$this->code."'
																	AND
																	mi.mi_status = 1");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$ciudades = array();
			while($ciudad = parent::fetch_assoc($consulta))
			{
				$name = $ciudad["mi_nombre"].' // '.$ciudad["mi_precio_real"];
				$code = $ciudad["id_inmueble"];
				$ciudades[$code]=$name;
			}
			return $ciudades;
		}
		else
		{
			return false;
		}
	}
}
?>
