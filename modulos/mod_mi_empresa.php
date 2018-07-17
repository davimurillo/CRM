<?php require_once('common.php'); checkUser(); //chequeo de usuario entrante  ?>
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
<div class="container-fluid">
	<!-- seccion de configuracion del sistema -->
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style=" font-size:18px; color:#888;" >

			<a href="index.php">Inicio</a> | Configuración de Mi Empresa <img class="ayuda" src="../img/botones/ayuda.png" title="Ayuda al Usuario" style="margin-left:8px; margin-top:-2px" /> </i>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px" >
	  <hr>
	</div>
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6" >
		<div class="list-group">
		  <span class="list-group-item active">Configuración</span>
		  <a href="#" id=datos_de_mi_empresa class="list-group-item">Mi Empresa</a>
		  <a href="#" id=usuarios_grupos_perfiles class="list-group-item">Usuarios, Grupos y Perfiles</a>
		</div>
	</div>
	<div id="contenedor_mi_empresa" class="col-lg-9 col-md-8 col-sm-8 col-xs-6" >
		<div class="panel panel-default">
			<div id="encabezado" class="panel-heading"><i class="fa fa-edit" style="font-size:18px"></i></div>
				<div id="contenedor_data" class="panel-body">
					
				</div>
			</div>
		</div>
	</div>
</div>
</div>
 <script src="../lib/js/jquery.min.js"></script>
<script src="../lib/js/bootstrap.min.js" ></script>
<script>
	$('#usuarios_grupos_perfiles').click( function (){
		if (<?php echo $_SESSION['rol']; ?>>=3){
			$('#contenedor_data').load("cfg_configuracion_usuarios.html");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> Datos de usuarios, grupos y perfiles');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	$('#datos_de_mi_empresa').click( function (){
		if (<?php echo $_SESSION['rol']; ?>>=3){
			$('#contenedor_data').load("cfg_configuracion_mi_empresa.html");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> Datos de mi empresa');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
    
	
</script>
<body>
<html>