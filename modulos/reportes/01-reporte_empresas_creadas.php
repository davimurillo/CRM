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
<div id="print" align="left" ><h3>Reporte de Empresas Creadas</h3><hr></div>
<table class="table table-bordered" style="font-size:12px; width:100%" >
  
  <tr >
    <th width="5%" style="text-align:center" >No.</th>
    <th width="35%" >NOMBRE</th>
    <th width="20%" style="text-align:center">TIPO</th>
    <th width="15%" style="text-align:center" >RUC</th>
    <th width="5%" style="text-align:center" >FECHA </th>
    <th width="20%" style="text-align:center" >CREADO POR </th>
  </tr>
  
 
  <?php 
	
    $sql="SELECT id_empresa, tx_ruc, tx_nombre, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE cfg_tipo_objeto.id_tipo_objeto=vie_usuario_empresa.id_estatus) AS estatus, (SELECT tx_nombre_apellido FROM cfg_usuario WHERE cfg_usuario.id_usuario=vie_usuario_empresa.id_usuario) AS usuario, (SELECT to_char(fe_actuali,'DD/MM/YYYY') as fe_actuali FROM tbl_empresa WHERE tbl_empresa.id_empresa=vie_usuario_empresa.id_empresa) AS fecha, (SELECT tx_tipo_empresa FROM vie_empresa WHERE id_empresa=vie_usuario_empresa.id_empresa) as itx_importancia FROM vie_usuario_empresa WHERE 1=1";
  if ($_SESSION['rol']<3){
	  $sql.=" AND id_usuario=".$_SESSION['id_usuario'];
  }else{
	  if (isset($_REQUEST['usuario'])){
		  $sql.=" AND id_usuario=".$_REQUEST['usuario'];
	  }
  }
  if (isset($_REQUEST['desde'])){
	  $sql.=" AND ((SELECT to_char(fe_actuali,'DD/MM/YYYY') as fe_actuali FROM tbl_empresa WHERE tbl_empresa.id_empresa=vie_usuario_empresa.id_empresa) >= '".$_REQUEST['desde']."'";
  }
  if (isset($_REQUEST['hasta'])){
	   $sql.=" AND (SELECT to_char(fe_actuali,'DD/MM/YYYY') as fe_actuali FROM tbl_empresa WHERE tbl_empresa.id_empresa=vie_usuario_empresa.id_empresa) <= '".$_REQUEST['hasta']."')";
  }
   if (isset($_GET['empresa']) && $_GET['empresa']!=0){
	  $sql.=" AND id_empresa=".$_GET['empresa'];
  }
   $sql.=" ORDER BY tx_nombre";
  $c=0;
  $res=abredatabase(g_BaseDatos,$sql);
  while ($row=dregistro($res)){
	$c+=1;  
	?>
  <tr>
    <td style="text-align:center" ><?php echo $c; ?> </td>
    <td ><?php echo $row['tx_nombre']; ?></td>
    <td ><?php echo $row['itx_importancia']; ?></td>
    <td><?php echo $row['tx_ruc']; ?></td>
    <td style="text-align:center"><?php echo $row['fecha']; ?></td>
    <td><?php echo $row['usuario']; ?></td>
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