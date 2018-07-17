<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>APICES|CRM ® </title>

	<link href="../img/logos/apices.png" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="../lib/css/bootstrap.min.css" >
	<link href="../lib/fonts/css/font-awesome.min.css" rel="stylesheet">
	<link id="switcher" href="../lib/css/theme-color/lite-blue-theme.css" rel="stylesheet">
</head>
<body>
<?php include('cfg_encabezado.php'); ?>
	<!-- seccion de configuracion del sistema -->
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style=" width:100%; font-size:18px; color:#888;" >

			<a href="index.php">Inicio</a> | Posibles Clientes <img class="ayuda" src="../img/botones/ayuda.png" title="Ayuda al Usuario" style="margin-left:8px; margin-top:-2px" /> 
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px" >
	  <hr>
	</div>
	<div class="col-lg-2 col-md-3 col-sm-3 col-xs-5" >
		<div class="list-group">
		  <span class="list-group-item active">Acceso</span>
		  <a href="#" id="tabla_objeto" class="list-group-item">Posible Clientes</a>
		  <a href="#" id="tabla_objeto" class="list-group-item">Oportunidades</a>
		  <a href="#" id="tabla_objeto" class="list-group-item">Reportes</a>
		  
		</div>
	</div>
	<div id="contenedor" class="col-lg-10 col-md-9 col-sm-9 col-xs-12" >
		<div class="panel panel-default">
		<div class="panel-heading">Posibles Clientes</div>
			<div id="informacion" class="panel-body">
				
			</div>
		</div>
		
	</div>
</div>
 <script src="../lib/js/jquery.min.js"></script>
<script src="../lib/js/bootstrap.min.js" ></script>
<script>
	$('#informacion').load('mod_posibles_clientes.php');
	$('#tabla_objeto').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_tabla_objetos.php");
			$('#encabezado').html('Tabla Objeto');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	
</script>
<body>
<html>