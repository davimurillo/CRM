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
	<!-- seccion de configuracion del sistema -->
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style=" width:100%; font-size:18px; color:#888;" >

			<a href="index.php">Inicio</a> | Configuración del Sistema <img class="ayuda" src="../img/botones/ayuda.png" title="Ayuda al Usuario" style="margin-left:8px; margin-top:-2px" /> </i>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px" >
	  <hr>
	</div>
	<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6" >
		<div class="list-group">
		  <span class="list-group-item active">Configuración</span>
		  <a href="#" id="configuracion_general" class="list-group-item">General</a>
		   <a href="#" id="servicios" class="list-group-item">Servicios</a>
		 <a href="#" id="posible_clientes" class="list-group-item">Posibles Clientes</a>	
		
		  <a href="#" id="contacto" class="list-group-item">Contacto</a>
		  <a href="#" id="condicion_opor" class="list-group-item">Oportunidad</a>
		   <a href="#" id="seguimiento" class="list-group-item">Seguimiento</a>
		   <a href="#" id="cotizacion" class="list-group-item">Cotización</a>
		  <a href="#" id="cfg_reportes" class="list-group-item">Reportes</a>
		  
		</div>
	</div>
	<div id="contenedor_mi_empresa" class="col-lg-9 col-md-8 col-sm-8 col-xs-6" >
		<div class="panel panel-default">
			<div id="encabezado" class="panel-heading"><i class="fa fa-edit" style="font-size:18px"></i></div>
				<div class="panel-body">
					<iframe id="contenedor_data" src="" width="100%" allowtransparency="1" frameborder="0"  style="height:340px"></iframe>
				</div>
			</div>
		</div>
	</div>
	
</div>
 <script src="../lib/js/jquery.min.js"></script>
<script src="../lib/js/bootstrap.min.js" ></script>
<script>
	
	$('#tabla_objeto').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_tabla_objetos.php");
			$('#encabezado').html('Tabla Objeto');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	$('#configuracion_general').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_configuracion_general.html");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> <label>Configurar General del Sistema</label>');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	$('#servicios').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_tabla_servicio.php");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> <label>Configurar Servicios</label>');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	$('#posible_clientes').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_configuracion_posible_clientes.html");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> <label>Configurar Posible Clientes</label>');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	$('#contacto').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_configuracion_contactos.html");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> <label>Configurar Contacto</label>');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	
	
	$('#seguimiento').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_configuracion_seguimiento.html");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> <label>Configurar  Seguimiento</label>');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	$('#condicion_opor').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_configuracion_oportunidad.html");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> <label>Configurar  Oportunidades</label>');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	$('#cotizacion').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_configuracion_cotizacion.html");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> <label>Configurar Cotización</label>');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	$('#cfg_reportes').click( function (){
		if (<?php echo $_SESSION['rol']; ?>==4){
			$('#contenedor_data').attr('src', "cfg_reportes.php");
			$('#encabezado').html('<i class="fa fa-edit" style="font-size:18px"></i> <label>Configurar Reportes</label>');
		}
		else{
			alert('Acceso no permitido debe contactar al administrador del sistema');
		}
	});
	
	 //reconfigura el tamaño de la pantalla
		function alertSize() {
		  var myWidth = 0, myHeight = 0;
		  if( typeof( window.innerWidth ) == 'number' ) {
			//Non-IE
			myWidth = window.innerWidth;
			myHeight = window.innerHeight;
		  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
			//IE 6+ in 'standards compliant mode'
			myWidth = document.documentElement.clientWidth;
			myHeight = document.documentElement.clientHeight;
		  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			//IE 4 compatible
			myWidth = document.body.clientWidth;
			myHeight = document.body.clientHeight;
		  }
		 // window.alert( 'Width = ' + myWidth );
		//  window.alert( 'Height = ' + myHeight );
		  document.getElementById('contenedor_data').style.height=(myHeight-230) + "px";
		  
		  
		  
		}

		alertSize();

		function Resize()
		{
		alertSize();
		}

		window.onresize=Resize;
	
</script>
<body>
<html>