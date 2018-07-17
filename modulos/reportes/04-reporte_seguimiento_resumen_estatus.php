<?php require_once('common.php'); checkUser();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Apices | CRM</title>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../../lib/css/bootstrap.min.css" >
	<link rel="stylesheet" href="../../lib/css/animate.css" >
	<link href="../../lib/fonts/css/font-awesome.min.css" rel="stylesheet">
	<link id="switcher" href="../../lib/css/theme-color/lite-blue-theme.css" rel="stylesheet">
	  
	   <!-- Main Style -->
    <link href="../../style.css" rel="stylesheet">
	
	

</head>

<body>
<div class="container">
<?php require_once('cfg_cabecera.php'); ?>


<div id="dvData" style="margin-top:50px">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div id="print" align="left" ><h3>Resumen de Clientes vs Oportunidades</h3><hr></div>
<table class="table table-bordered" style="font-size:12px; width:100%" > 
  
  
  
 
  <?php 
    $sql="SELECT tx_nombre, tx_ruc, id_oportunidad, (SELECT tx_nombre_apellido FROM cfg_usuario WHERE cfg_usuario.id_usuario=vie_seguimiento_control_oportunidad.id_usuario) AS usuario, (SELECT to_char(fe_actuali,'DD/MM/YYYY') FROM tbl_empresa WHERE tbl_empresa.id_empresa=vie_seguimiento_control_oportunidad.id_empresa) AS fecha, tx_tipo_documento, tx_tipo_servicio, to_char(fe_creacion,'DD/MM/YYYY') as fe_creacion, to_char(fe_inicio,'DD/MM/YYYY') as fe_inicio, to_char(fe_probable_cierre, 'DD/MM/YYYY') as fe_probable_cierre, tx_tipo_condicion_oportunidad, nu_avance, nu_tiempo, nu_tiempo_avance, CASE WHEN nu_tiempo<nu_tiempo_avance THEN 'A Tiempo' ELSE 'A Destiempo' END AS estatus_tiempo FROM vie_seguimiento_control_oportunidad WHERE 1=1 ";
 /* if ($_SESSION['rol']<3){
	  $sql.=" AND id_usuario=".$_SESSION['id_usuario'];
  }*/
  if ($_SESSION['rol']<3){
	  $sql.=" AND id_usuario=".$_SESSION['id_usuario'];
  }
  if (isset($_GET['empresa']) && $_GET['empresa']!=0){
	  $sql.=" AND id_empresa=".$_GET['empresa'];
  }
  if (isset($_GET['tipo_contacto']) && $_GET['tipo_contacto']!=0){
	  $sql.=" AND id_condicion=".$_GET['tipo_contacto'];
  }
  $sql.=" ORDER BY tx_nombre";
   $c=0;
  $titulo="";
  $res=abredatabase(g_BaseDatos,$sql);
  
  ?>
   <tr class="active">
	<th >N° CLIENTE</th>
    <th >RUC</th>
    <th >Id Oportunidad </th>
	<th >Oportunidad </th>
    <th >Condición</th>
    <th>Fecha Cierre</th>
    <th >Avance %</th>
    <th>Tiempo %</th>
	<th>Usuario Asignado</th>
  </tr>
  <?php
  while ($row=dregistro($res)){
	$c+=1;  
	
	?>
	
 
 
	
	<tr>
	<td><?php echo "#".$c." ".$row['tx_nombre']; ?></td>
	<td><?php echo $row['tx_ruc']; ?></td>
	<td><?php $configuracion_n_oportunidad="000000"; if ($row['tx_tipo_documento']=='Carta de Presentación'){ echo "CP"; }else{ echo "CO"; } ; echo substr($configuracion_n_oportunidad,1,strlen($configuracion_n_oportunidad)-strlen($row['id_oportunidad'])).$row['id_oportunidad'];  ?></td>
    <td ><?php echo "Tipo Oportunidad:".$row['tx_tipo_documento']."<br> Tipo Servicio:".$row['tx_tipo_servicio']."<br>Fecha Creación:".$row['fe_creacion']." <i class='fa fa-long-arrow-right'></i>  Fecha Inicio:".$row['fe_inicio']; ?> </td>
    <td ><?php echo $row['tx_tipo_condicion_oportunidad']; ?></td>
    <td><?php echo $row['fe_probable_cierre']; ?></td>
    <td ><?php echo $row['nu_avance']; ?></td>
    <td><?php echo $row['nu_tiempo']." / ".$row['nu_tiempo_avance']." <br> ".$row['estatus_tiempo']."<br>(".($row['nu_tiempo_avance']-$row['nu_tiempo'])." Días)"; ?></td>
	<td ><?php echo $row['usuario']; ?></td>
  </tr>
	<?php } ?>
</table>
</div>
</div>

<script>
$(document).ready(function()
{
	$("#printer").click(function ()
	{
		$('#cabecera').hide();
		window.print();
		$('#cabecera').show();
	});
	
	
	$("#exportar").click(function (e) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#dvData').html()));
    e.preventDefault();
	});
	
	
});
</script>
</body>
</html>