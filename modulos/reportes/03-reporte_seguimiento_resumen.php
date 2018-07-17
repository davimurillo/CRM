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
<div id="print" align="left" ><h3>Resumen de Oportunidades por Cliente</h3><hr></div>
<table class="table table-bordered" style="font-size:12px; width:100%" >
  
  <tr class="active" >
    <th  width="5%"  style="text-align:center">N°</th>
    <th  width="30%" style="text-align:center">CLIENTE</th>
    <th  width="12%" style="text-align:center">RUC</th>
    <th  width="23%" style="text-align:center">USUARIO</th>
    <th  width="20%" style="text-align:center">N° DE OPORTUNIDAD </th>
  </tr>
  
 
  <?php 
   $sql="SELECT tx_nombre, tx_ruc, (SELECT tx_nombre_apellido FROM cfg_usuario, vie_usuario_empresa WHERE id_empresa= vie_seguimiento_control_oportunidad.id_empresa and  cfg_usuario.id_usuario=vie_usuario_empresa.id_usuario) AS usuario, COUNT(id_oportunidad) as n_oportunidad FROM vie_seguimiento_control_oportunidad WHERE 1=1  ";
  //if ($_SESSION['rol']<3){
	//  $sql.=" AND id_usuario=".$_SESSION['id_usuario'];
  //}
   if ($_SESSION['rol']<3){
	  $sql.=" AND id_usuario=".$_SESSION['id_usuario'];
  }
  if (isset($_GET['empresa']) && $_GET['empresa']!=0){
	  $sql.=" AND id_empresa=".$_GET['empresa'];
  }
  if (isset($_GET['tipo_contacto']) && $_GET['tipo_contacto']!=0){
	  $sql.=" AND id_condicion=".$_GET['tipo_contacto'];
  }
  $sql.="GROUP BY tx_nombre, tx_ruc, usuario";
  $c=0;
  $total=0;
  $res=abredatabase(g_BaseDatos,$sql);
  while ($row=dregistro($res)){
	$c+=1;  
	?>
  <tr>
    <td style="text-align:center"><?php echo $c; ?> </td>
    <td ><?php echo $row['tx_nombre']; ?></td>
    <td><?php echo $row['tx_ruc']; ?></td>
    <td ><?php echo $row['usuario']; ?></td>
    <td style="text-align:center"><?php echo $row['n_oportunidad']; $total+=$row['n_oportunidad']; ?></td>
  </tr>
  <?php } ?>
  <tr class="active">
    <th  colspan="4">TOTAL N° DE OPORTUNIDADES</th>
    
    <th style="text-align:center" ><?php echo $total; ?></th>
  </tr>
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