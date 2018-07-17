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
<div id="cabecera" class="panel panel-default" style="margin-top:10px">
  <div class="panel-body" align="right" >
  <div class="btn-group" role="group" >
	<button type="button" id="printer" class="btn btn-default btn-lg"><i class="fa fa-print"> Imprimir</i></button>  
	<button type="button" class="btn btn-default btn-lg"><i class="fa fa-envelope-o"> Email</i></button> 
	<button type="button" id="exportar" class="btn btn-default btn-lg"><i class="fa fa-file-excel-o"> Exportar</i></button>
  </div>
  </div>
</div>


<div id="dvData">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div id="print" align="center" >
  <h1>RESUMEN DE COTIZACIONES </h1>
</div>
<table width="100%" class="table table-bordered" >
  
  <tr >
    <th width="3%"  ><div align="center">N°</div></th>
    <th width="10%" ><div align="center">CLIENTE</div></th>
    <th width="11%" ><div align="center">RUC</div></th>
    <th width="15%"  ><div align="center">N° DE COTIZACIÓN </div></th>
    <th width="14%"  ><div align="center">FECHA</div></th>
    <th width="15%"  ><div align="center">SERVICIO</div></th>
    <th width="17%"  ><div align="center">RESPONSABLE </div></th>
    <th width="15%"  ><div align="center">MONTO</div></th>
  </tr>
  
 
  <?php 
    $sql="SELECT id_empresa, tx_ruc, tx_nombre, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE cfg_tipo_objeto.id_tipo_objeto=vie_usuario_empresa.id_estatus) AS estatus, (SELECT tx_nombre_apellido FROM cfg_usuario WHERE cfg_usuario.id_usuario=vie_usuario_empresa.id_usuario) AS usuario, (SELECT to_char(fe_actuali,'DD/MM/YYYY') FROM tbl_empresa WHERE tbl_empresa.id_empresa=vie_usuario_empresa.id_empresa) AS fecha FROM vie_usuario_empresa WHERE id_estatus=42";
  if ($_SESSION['rol']<3){
	  $sql.=" AND id_usuario=".$_SESSION['id_usuario'];
  }
  $c=0;
  $res=abredatabase(g_BaseDatos,$sql);
  while ($row=dregistro($res)){
	$c+=1;  
	?>
  <tr>
    <td ><?php echo $c; ?> </td>
    <td ><?php echo $row['tx_nombre']; ?></td>
    <td><?php echo $row['tx_ruc']; ?></td>
    <td ><div align="center"><?php echo $row['fecha']; ?></div></td>
    <td><div align="center"><?php echo $row['usuario']; ?></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="right"></div></td>
  </tr>
  <?php } ?>
</table>
</div>
</div>
<script src="../../lib/js/jquery.1.6.1.js"></script>
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