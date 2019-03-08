select
gi.gi_nombre_grupo_inmueble,
sum(mca.monto_abonado) as total
from maestro_ventas mv
inner join grupo_inmuebles gi on mv.id_grupo_inmueble = gi.id_grupo_inmuebles
inner join maestro_inmuebles mi on mi.id_grupo_inmuebles = mv.id_grupo_inmueble
inner join maestro_cuota_abono mca on mca.mca_id_grupo_inmueble = gi.id_grupo_inmuebles
where
gi.gi_id_proyecto = 13
group by
gi.gi_nombre_grupo_inmueble
########################################################################################
select
gi.gi_nombre_grupo_inmueble,
mi.mi_nombre,

sum(mca.monto_abonado) as total
from maestro_ventas mv inner join maestro_clientes mc on mc.id_cliente = mv.id_cliente



inner join grupo_inmuebles gi on mv.id_grupo_inmueble = gi.id_grupo_inmuebles
inner join maestro_inmuebles mi on mi.id_inmueble = mv.id_inmueble
inner join maestro_cuota_abono mca on mca.mca_id_documento_venta = mv.id_venta
where
gi.gi_id_proyecto = 13
group by
gi.gi_nombre_grupo_inmueble
