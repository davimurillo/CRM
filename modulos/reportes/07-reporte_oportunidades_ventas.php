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
<?php require_once('cfg_cabecera.php'); 

  date_default_timezone_set($_SESSION['zona_horario']);?>


<div id="dvData" style="margin-top:50px">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div id="print" align="left" ><h3>RESUMEN DE VENTAS POR USUARIO</h3><hr></div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px">
<table class="table table-bordered" style="font-size:12px; width:100%" >
  
  <tr class="active">
    <th  style="text-align:center">EMPRESA</th>
    <th style="text-align:center">SERVICIO</th>
    <th style="text-align:center">MONTO</th>
	<th style="text-align:center">FECHA DE CIERRE</th>
	<th style="text-align:center">ESTATUS</th>
	<th style="text-align:center">USUARIO</th>
  </tr>
  
 
  <?php 
   $sql="SELECT tx_nombre, tx_tipo_servicio, fe_probable_cierre, nu_valor_oportunidad, tx_nombre_apellido, tx_status_opor FROM vie_seguimiento_control_oportunidad a WHERE 1=1";
  /*if ($_SESSION['rol']<3){
	  $sql.=" AND id_usuario=".$_SESSION['id_usuario'];
  }*/
  $sql.="  ORDER BY fe_probable_cierre DESC";
  $res=abredatabase(g_BaseDatos,$sql);
  while ($row=dregistro($res)){
	
	?>
	
  <tr>
    <td  ><?php echo $row['tx_nombre']; ?> </td>
    <td style="text-align:left"><?php echo $row['tx_tipo_servicio'];  ?></td>
    <td style="text-align:right"><?php echo  number_format($row['nu_valor_oportunidad'],2,',','.'); ?></td>
    <td style="text-align:center"><?php echo date('d/m/Y', strtotime($row['fe_probable_cierre']));  ?></td>
	<td  style="text-align:center"><?php echo $row['tx_status_opor']; ?> </td>
	<td  style="text-align:left"><?php echo $row['tx_nombre_apellido']; ?> </td>
  </tr>
  <?php } ?>
   
</table>
</div>
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