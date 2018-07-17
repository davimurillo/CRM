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
<div id="print" align="left" ><h3>Reporte de Contactos Creados</h3><hr></div>
<table class="table table-bordered" style="font-size:12px; width:100%" > 
<tr class="active" >
		<th  >N°</th>
		<th >Cliente</th>
		<th >Nombres y Apellidos</th>
		<th >Cargo</th>
		<th>Condición</th>
		<th >Correo</th>
		<th>Teléfono</th>
    </tr>
  <?php 
  
   $sql="SELECT tx_nombre, tx_contacto as tx_nombre_apellido, tx_cargo, tx_tipo_condicion_contacto, tx_correo_primario, tx_telefono_con, tx_tipo_telefono_con  FROM vie_empresa_contacto_usuario WHERE 1=1";
  if ($_SESSION['rol']<3){
	  $sql.=" AND id_usuario=".$_SESSION['id_usuario'];
  }
  if (isset($_GET['empresa']) && $_GET['empresa']!=0){
	  $sql.=" AND id_empresa=".$_GET['empresa'];
  }
  if (isset($_GET['tipo_contacto']) && $_GET['tipo_contacto']!=0){
	  $sql.=" AND id_condicion=".$_GET['tipo_contacto'];
  }
  $c=0;
  $titulo="";
  $res=abredatabase(g_BaseDatos,$sql);
  while ($row=dregistro($res)){
	  $c+=1;
	?>
	 
  <tr>
    <td ><?php echo $c; ?> </td>
    <td ><?php echo $row['tx_nombre']; ?></td>
    <td><?php echo $row['tx_nombre_apellido']; ?></td>
    <td ><?php echo $row['tx_cargo']; ?></td>
    <td><?php echo $row['tx_tipo_condicion_contacto']; ?></td>
	<td ><?php echo $row['tx_correo_primario']; ?></td>
    <td><?php echo $row['tx_tipo_telefono_con'].":".$row['tx_telefono_con']; ?></td>
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