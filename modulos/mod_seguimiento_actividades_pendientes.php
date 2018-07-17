<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>APICES|CRM ® </title>

	<link href="../img/logos/apices.png" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="../lib/css/bootstrap.min.css" >
	<link rel="stylesheet" href="../lib/css/animate.css" >
	<link href="../lib/fonts/css/font-awesome.min.css" rel="stylesheet">
	
	<!-- Slick slider -->
    <link rel="stylesheet" type="text/css" href="../assets/css/slick.css"/> 
     <!-- Theme color -->
    <link id="switcher" href="../assets/css/theme-color/lite-blue-theme.css" rel="stylesheet">
	
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	
	<link rel="stylesheet" href="../lib/js/funnel/style.css">
	
	  
	   <!-- Main Style -->
    <link href="../style.css" rel="stylesheet">
	
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/funnel.js"></script>
	<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
	<style>
		#usuario_perfil {
			width: 60px;
			height: 60px;
			border-radius: 50%;
			margin-right: 10px;
			-moz-border-radius: 50%;
			-webkit-border-radius: 50%;
		    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		}
		.session { 
	
	-moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);}
  
     .taper1 {
    width: 250px;
    height: 0px;
    border-color: #ff0000 transparent;
    border-style: solid;
    border-width: 50px 25px 0 25px;
}
.taper2 {
    width: 200px;
    height: 0px;
    border-color: #ff8c00 transparent;
    border-style: solid;
    border-width: 50px 25px 0 25px;
    margin-top:5px
    
}
.taper3 {
    width: 150px;
    height: 0px;
    border-color: #66cd00 transparent;
    border-style: solid;
    border-width: 50px 25px 0 25px;
    margin-top:5px
    
}
.taper4 {
    width: 100px;
    height: 0px;
    border-color: #7ac5cd transparent;
    border-style: solid;
    border-width: 50px 25px 0 25px;
    margin-top:5px
    
}
.taper5 {
    width: 50px;
    height: 0px;
    border-color: #8b4789 transparent;
    border-style: solid;
    border-width: 50px 25px 0 25px;
    margin-top:5px
    
}

  </style>
		
		
	</style>
	
	
</head>
<body style="background-Color:#EAEAEA">

<?php include('cfg_encabezado.php'); ?>

 <!-- BEGAIN PRELOADER -->
  <div id="preloader">
    <div class="loader" ></div>
  </div>
<!-- END PRELOADER -->
<div class="container-fluid">
<?php 
  
 

  date_default_timezone_set($_SESSION['zona_horario']);
   ?>
	<!-- Actividades para hoy --->
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
		<?php
			$sql_actividad="select a.id_empresa, b.id_oportunidad,  id_seguimiento, tx_nombre, c.tx_descripcion, fe_plan,fe_cierre   FROM  tbl_oportunidad b, tbl_seguimiento c, tbl_empresa a where a.id_empresa=b.id_empresa and b.id_oportunidad=c.id_oportunidad and EXTRACT(YEAR FROM fe_cierre)=EXTRACT(YEAR FROM NOW()) AND  b.id_status<>151  and c.fe_plan <= now()::date and c.fe_cierre>=now()::date ";
			
			$res_actividad=abredatabase(g_BaseDatos,$sql_actividad);	
			$numero_registro=dnumerofilas($res_actividad);
			?>
		<div class="panel panel-default session" >
			<div class="panel-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<label>	Actividades para Hoy (<?php echo $numero_registro; ?>)
					</label>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<hr>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				  <?php 
				    
					while ($row_actividad=dregistro($res_actividad)){
					?>
					<div class="col-xs-1"> 
						<i class="fa  fa-arrow-circle-right"></i>
					</div>
					<div class="col-xs-10" style="font-size:9px"> 
						<a href="mod_seguimiento.php?id=<?php echo $row_actividad['id_empresa']; ?>&id_opor=<?php echo $row_actividad['id_oportunidad']; ?>">
						<?php echo $row_actividad['tx_nombre']; ?> <br>
						<?php echo $row_actividad['tx_descripcion']; ?>
						</a>
					</div>
					<div class="col-xs-1"> 
						
					</div>
									
					<div class="col-xs-12" style="font-size:9px">
						  <hr>
					</div>
					
					
					<?php }
					cierradatabase($res_actividad)
					?>
					
				</div>
				
			</div>
		</div>
	</div>
				
	
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" >
		<?php 
			
				    $sql_actividad="SELECT  a.id_oportunidad,   b.id_empresa,  b.tx_nombre,   (SELECT  c.id_seguimiento  FROM 	public.tbl_seguimiento c  WHERE	c.id_oportunidad=a.id_oportunidad and 	c.id_status = 58   ORDER BY   c.fe_cierre ASC  LIMIT 1) AS id_seguimiento,(SELECT c.tx_descripcion FROM public.tbl_seguimiento c  WHERE	c.id_oportunidad=a.id_oportunidad and 	c.id_status = 58 ORDER BY  c.fe_cierre ASC LIMIT 1) AS tx_descripcion,   (SELECT c.fe_cierre FROM public.tbl_seguimiento c WHERE	c.id_oportunidad=a.id_oportunidad and c.id_status = 58 ORDER BY   c.fe_cierre ASC  LIMIT 1) AS fe_cierre FROM public.tbl_oportunidad a,   public.tbl_empresa b WHERE a.id_empresa = b.id_empresa AND   a.id_status<>151 and (SELECT c.id_seguimiento FROM 	public.tbl_seguimiento c WHERE c.id_oportunidad=a.id_oportunidad and 	c.id_status = 58 ORDER BY c.fe_cierre ASC LIMIT 1) >0  ";
					 $res_actividad=abredatabase(g_BaseDatos,$sql_actividad);
					 $numero_registro=dnumerofilas($res_actividad);
		?>
		<div class="panel panel-default session" >
			<div class="panel-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<label>	Actividades Pendientes (<?php echo $numero_registro; ?>)
					</label>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<hr>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				  <?php 
					while ($row_actividad=dregistro($res_actividad)){
					?>
					<div class="col-xs-1"> 
						<i class="fa  fa-arrow-circle-right"></i>
					</div>
					<div class="col-xs-10" style="font-size:9px"> 
						<a href="mod_seguimiento.php?id=<?php echo $row_actividad['id_empresa']; ?>&id_opor=<?php echo $row_actividad['id_oportunidad']; ?>">
						<?php echo $row_actividad['tx_nombre']; ?> <br>
						<?php echo $row_actividad['tx_descripcion']; ?> | <?php echo "Fecha de Cierre: ".$row_actividad['fe_cierre']; ?>
						</a>
					</div>
					<div class="col-xs-1"> 
						
					</div>
									
					<div class="col-xs-12" style="font-size:9px">
						  <hr>
					</div>
					
					
					<?php }
					cierradatabase($res_actividad)
					?>
					
				</div>
				
				
			</div>
		</div>
	</div>

 

			</div>
			

		
		
		


	
 
  <script src="../lib/js/bootstrap.min.js" ></script>

  <script src="../lib/js/moment/moment.min.js"></script>

  <!-- Slick Slider -->
  <script type="text/javascript" src="../assets/js/slick.js"></script>
  
  <!-- Counter -->
  <script type="text/javascript" src="../assets/js/waypoints.js"></script>
  
  <script type="text/javascript" src="../assets/js/jquery.counterup.js"></script>
  
   <!-- mixit slider -->
  <script type="text/javascript" src="../assets/js/jquery.mixitup.js"></script>
  
  <!-- Add fancyBox -->        
  <script type="text/javascript" src="../assets/js/jquery.fancybox.pack.js"></script>

  <!-- Required D3 library -->
  <script src="../lib/js/funnel/d3.v4.js"></script>

  <!-- D3Funnel source file -->
  <script src="../lib/js/funnel/d3-funnel.js"></script>
  <!-- Wow animation -->
  <script type="text/javascript" src="../assets/js/wow.js"></script> 

<script type="text/javascript" src="../assets/js/custom.js"></script>

  <script src="../lib/js/chartjs/chart.min.js"></script>
  
    

<body>
<html>