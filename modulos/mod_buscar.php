<?php 	require_once('common.php');	checkUser(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script type='text/javascript'>
function disableselect(e){
return false
}
function reEnable(){
return true
}
document.onselectstart=new Function ("return false");
if (window.sidebar){
document.onmousedown=disableselect
document.onclick=reEnable
}
</script>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="pragma" content="no-cache"> 
	<title>Ápices | CRM</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">	
	
	<!-- Libreria CSS -->
      <link href="../lib/css/bootstrap.min.css" rel="stylesheet">
	  <link href="../lib/fonts/css/font-awesome.min.css" rel="stylesheet">
	  <link href="../lib/css/animate.min.css" rel="stylesheet">
	  <link href="../lib/css/custom.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="../lib/css/progressbar/bootstrap-progressbar-3.3.0.css">
	 <style >
		#unidad:hover{
			background-color:#FAFAFA;			
		}
	 </style>
</head>

  <script>
		var antes=(new Date ()).getTime();
		function tdc(){ // tiempo de carga
			var despues=(new Date()).getTime();
			var segundos=(despues-antes)/1000;
			document.getElementById('tdc').innerHTML="(" + segundos + " seg.)";
		}
  </script>
  <body onload="tdc();" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">

  
	<div class="container" >
		
		<!-- CABEZADO -->
		<?php include_once('cfg_encabezado.php'); ?>
      	  
		<!-- CONTENIDO -->  
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center" style="font-size:28px; font-weight:bold; margin:20px 0px 20px 0px; ">
				<i class="fa fa-search"> </i> BUSCADOR
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="color:#888">
				Búsqueda rápida de la información de los clientes registrados:
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px">
				<form id="form1" action="">
					<input type="text" id="buscar" name="buscar" class="form-control" placeholder="Nombre del Cliente" autofocus>
				</form>
			</div>
			<div id="resultado" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px">
			
			<?php 
			// BUSCA DATOS DE LAS UNIDADES ORGANIZATIVA ------------------- //
				if (isset($_GET['buscar'])){
					 $SQL="SELECT id_empresa,  tx_nombre, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=vie_usuario_empresa.id_estatus) AS estatus, (SELECT tx_nombre_apellido FROM cfg_usuario WHERE id_usuario=vie_usuario_empresa.id_usuario) AS nombre_usuario, (SELECT tx_contacto FROM tbl_contacto WHERE id_empresa=vie_usuario_empresa.id_empresa LIMIT 1) AS contacto FROM vie_usuario_empresa WHERE  (upper(tx_nombre) LIKE ('%".strtoupper($_GET['buscar'])."%') or upper((SELECT tx_contacto FROM tbl_contacto WHERE id_empresa=vie_usuario_empresa.id_empresa LIMIT 1)) LIKE ('%".strtoupper($_GET['buscar'])."%') or upper((SELECT tx_nombre_apellido FROM cfg_usuario WHERE id_usuario=vie_usuario_empresa.id_usuario)) LIKE ('%".strtoupper($_GET['buscar'])."%'))";
					if ($_SESSION['rol']==3 or $_SESSION['rol']==2 ){
						$SQL.=" AND id_usuario IN (select id_usuario FROM cfg_grupos_usuarios WHERE id_grupo IN (select id_grupo FROM cfg_grupos_usuarios WHERE id_usuario=".$_SESSION['id_usuario']." ))";
					}
					if ($_SESSION['rol']==1){
						$SQL.=" AND id_usuario=".$_SESSION['id_usuario'];
					}
					 $SQL.=" ORDER BY tx_nombre ASC";
					$RES=abredatabase(g_BaseDatos,$SQL);
					if (dnumerofilas($RES)==0){ echo "No existen Empresas con esta información '".$_GET['buscar']."' que busca";}else{
						echo "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'  style='color:#ccc;' >Palabra Buscada: '".$_GET['buscar']."'</div>";
						echo "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'  style='color:#ccc;' >Cerca de (".dnumerofilas($RES).") resultados encontrados <span id='tdc'><span></div>";
			?>
			<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'  style="margin-top:20px">
			<table class="table table-hover">
			<thead>
			<tr>
				<th width="40%">Empresa</th>
				<th width="22%">Contacto</th>
				<th width="33%" style="text-align:center">Asignado A</th>
				<th width="5%">Estatus</th>
				
			</tr>
			</thead>
			<tbody>
			<?php 
			
			while($ROW=dregistro($RES)){ 
			
			?>
			<tr>
				<td><a href="mod_seguimiento.php?id=<?php echo $ROW['id_empresa']; ?>"><?php echo $ROW['tx_nombre']; ?></a></td>
				<td><?php echo $ROW['contacto']; ?></td>
				<td align="center"><?php echo $ROW['nombre_usuario']; ?></td>
				<td><?php echo $ROW['estatus']; ?></td>
				
			</tr>
			
			
					
			<?php } ?>
			</tbody>
					</table>	
				</div>
			<?php
					}
				}
			?>
			</div>
		</div>
		<script language="JavaScript">
			function checkKey(evt) {
				if (evt.ctrlKey)
				alert("Alerta que se le dara al usuario al tocar la tecla Ctrl en nuestra web");
			}
		</script> 
		
		<!-- JS -->
		<script src="../lib/js/jquery.min.js" ></script>
		<script src="../lib/js/bootstrap.min.js" ></script>
</body>
</html>