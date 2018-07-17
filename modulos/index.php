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
		
		

	
	
</head>
<body style="background-Color:#EAEAEA">
<?php 

	

	?>
<?php include('cfg_encabezado.php'); ?>

 <!-- BEGAIN PRELOADER -->
  <div id="preloader">
    <div class="loader" ></div>
  </div>
<!-- END PRELOADER -->
<div class="container-fluid">
<?php 
  
  

  date_default_timezone_set($_SESSION['zona_horario']);
   $sql_query="";
   $sql="SELECT tx_nombre_apellido, 
   (SELECT COUNT(id_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE  id_usuario=a.id_usuario ) AS n_oportunidad, 

   (SELECT COUNT(id_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE nu_tiempo<nu_tiempo_avance and id_usuario=a.id_usuario ) AS a_tiempo,

    (SELECT sum(nu_valor_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE nu_tiempo<nu_tiempo_avance and id_usuario=a.id_usuario and id_tipo_moneda=135 ) AS soles_a_tiempo,

    (SELECT sum(nu_valor_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE nu_tiempo<nu_tiempo_avance and id_usuario=a.id_usuario and id_tipo_moneda=136 ) AS dolar_a_tiempo,

    (SELECT COUNT(id_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE nu_tiempo>nu_tiempo_avance and id_usuario=a.id_usuario  ) AS a_destiempo, 
    
   (SELECT sum(nu_valor_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE nu_tiempo>nu_tiempo_avance and id_usuario=a.id_usuario and id_tipo_moneda=135  ) AS soles_a_destiempo, 

   (SELECT sum(nu_valor_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE nu_tiempo>nu_tiempo_avance and id_usuario=a.id_usuario and id_tipo_moneda=136  ) AS dolar_a_destiempo, 
   
   (SELECT sum(nu_valor_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE id_usuario=a.id_usuario and id_tipo_moneda=135 ) as total_monto_SOLES,

   (SELECT sum(nu_valor_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE id_usuario=a.id_usuario and id_tipo_moneda=136 ) as total_monto_USD,
   
   (SELECT count(id_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=47 ) as ganadas,

   (SELECT sum(nu_valor_oportunidad)  FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=47 and  id_tipo_moneda=135 ) as soles_ganadas,

   (SELECT sum(nu_valor_oportunidad)  FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=47 and  id_tipo_moneda=136 ) as dolar_ganadas,
   
   (SELECT count(id_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=48 ) as perdida,

    (SELECT sum(nu_valor_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=48 and  id_tipo_moneda=135) as soles_perdida,

     (SELECT sum(nu_valor_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=48 and  id_tipo_moneda=136) as dolar_perdida,
   
	(SELECT count(id_oportunidad) FROM vie_seguimiento_control_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=132 ) as activas,   
	
	(SELECT sum(nu_valor_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=132 and  id_tipo_moneda=135) as soles_activas,

     (SELECT sum(nu_valor_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=132 and  id_tipo_moneda=136) as dolar_activas,
   
	
	(SELECT COUNT(id_empresa) FROM vie_usuario_empresa WHERE id_usuario=a.id_usuario) as total_clientes, 

	(SELECT count(id_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_status=143 ) as por_activar, 

	(SELECT sum(nu_valor_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=143 and  id_tipo_moneda=135) as soles_por_activar,

     (SELECT sum(nu_valor_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_condicion=143 and  id_tipo_moneda=136) as dolar_por_activar,
	
	
	(SELECT count(id_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_status=37 ) as activas_oportunidad, 

	(SELECT count(id_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_status=38 ) as enviadas, 
	
	(SELECT count(id_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_status=39 ) as recibidas, 
	
	(SELECT count(id_oportunidad) FROM tbl_oportunidad WHERE id_usuario=a.id_usuario and id_status=137 ) as cerradas 

	FROM vie_seguimiento_control_oportunidad a WHERE 1=1";
  if ($_SESSION['rol']<3){
	  $sql_query.=" AND a.id_usuario=".$_SESSION['id_usuario'];
  }
  if (isset($_REQUEST['filtro']) and $_REQUEST['filtro']==1){
	  $sql_query.=" AND a.fe_actuali >= '".date('Y-m-d 00:00:00')."' AND a.fe_actuali <= '".date('Y-m-d 24:00:00')."'";
  }
  if (isset($_REQUEST['filtro']) and $_REQUEST['filtro']==5){
	  $fecha = date('Y-m-j');
	  $nuevafecha = strtotime ( '-5 day' , strtotime ( $fecha ) ) ;
	  $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
	  $sql_query.=" AND a.fe_actuali >= '".$nuevafecha."' AND a.fe_actuali <= '".date('Y-m-d')."'";
  }
  if (isset($_REQUEST['filtro']) and $_REQUEST['filtro']==30){
	  $fecha = date('Y-m-j');
	  $nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
	  $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
	  $sql_query.=" AND a.fe_actuali >= '".$nuevafecha."' AND a.fe_actuali <= '".date('Y-m-d')."'";
  }
  if (isset($_REQUEST['filtro']) and $_REQUEST['filtro']==360){
	  $fecha = date('Y-m-j');
	  $nuevafecha = strtotime ( '-360 day' , strtotime ( $fecha ) ) ;
	  $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
	  $sql_query.=" AND a.fe_actuali >= '".$nuevafecha."' AND a.fe_actuali <= '".date('Y-m-d')."'";
  }
   $sql.=$sql_query." GROUP BY id_usuario, tx_nombre_apellido ORDER BY tx_nombre_apellido";
  $c=0;
  $total=0;
  $total_clientes=0;
  $total_monto_SOLES=0;
  $total_monto_USD=0;
  $total_atiempo=0;
  $total_soles_atiempo=0;
  $total_dolar_atiempo=0;
  $total_adestiempo=0;
  $total_soles_adestiempo=0;
  $total_dolar_adestiempo=0;
  $total_ganadas=0;
  $total_soles_ganadas=0;
  $total_dolar_ganadas=0;
  $total_perdida=0;
  $total_soles_perdida=0;
  $total_dolar_perdida=0;
  $total_activas=0;
  $total_soles_activas=0;
  $total_dolar_activas=0;
  $total_por_activar=0;
  $total_soles_por_activar=0;
  $total_dolar_por_activar=0;
  $total_activa=0;
  $total_enviadas=0;
  $total_recibidas=0;
  $total_cerradas=0;
  $data="";
  $data_bar="";
  $res=abredatabase(g_BaseDatos,$sql);
  while ($row=dregistro($res)){
	$c+=1;  
	$total_clientes+=$row['total_clientes'];
	$total_por_activar+=$row['por_activar'];
	$total_activa+=$row['activas_oportunidad'];
	$total_enviadas+=$row['enviadas'];
	$total_recibidas+=$row['recibidas'];
	$total_cerradas+=$row['cerradas'];
	?>
	<?php 
	
	$total+=$row['por_activar']+$row['activas_oportunidad']+$row['enviadas']+$row['recibidas']+$row['cerradas'];
	$total_atiempo+=$row['a_tiempo'];
	$total_soles_atiempo+=$row['soles_a_tiempo'];
	$total_dolar_atiempo+=$row['dolar_a_tiempo'];
	$total_adestiempo+=$row['a_destiempo'];
	$total_soles_adestiempo+=$row['soles_a_destiempo'];
	$total_dolar_adestiempo+=$row['dolar_a_destiempo'];
	$total_monto_SOLES+=$row['total_monto_soles'];
	$total_monto_USD+=$row['total_monto_usd'];
	$total_ganadas+=$row['ganadas'];
	$total_soles_ganadas+=$row['soles_ganadas'];
	$total_dolar_ganadas+=$row['dolar_ganadas'];
	$total_perdida+=$row['perdida'];
	$total_soles_perdida+=$row['soles_perdida'];
	$total_dolar_perdida+=$row['dolar_perdida'];
	$total_activas+=$row['activas'];
	} ?>
	
	<!-- Actividades para hoy --->
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
	
	
		<div class="panel panel-default session" style="height:323px">
			<div class="panel-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<label>	Actividades para Hoy
					</label>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<hr>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				  <?php 
				    $sql_actividad="select a.id_empresa, b.id_oportunidad,  id_seguimiento, tx_nombre, c.tx_descripcion, fe_plan,fe_cierre   FROM  tbl_oportunidad b, tbl_seguimiento c, tbl_empresa a where a.id_empresa=b.id_empresa and b.id_oportunidad=c.id_oportunidad and EXTRACT(YEAR FROM fe_cierre)=EXTRACT(YEAR FROM NOW()) AND  b.id_status<>151  and c.fe_plan <= now()::date and c.fe_cierre>=now()::date LIMIT 3";
					 $res_actividad=abredatabase(g_BaseDatos,$sql_actividad);
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
				<div  class="col-xs-12" style="font-size:9px">
						 <a href="mod_seguimiento_actividades_pendientes.php">Mostrar Todas ....</a>
				</div>
			</div>
		</div>
	</div>
	<!-- tunel de ventas --->
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	
	
		<div class="panel panel-default session">
			<div class="panel-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<label>	Tunel de Ventas
					</label>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<hr>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
<?php 
$c=1;
	$sql_funnel="(SELECT ('1') AS ID, ('TRAFICO') as nombre, sum(nu_valor_oportunidad) as monto FROM tbl_oportunidad a WHERE id_tipo_doc=49 ".$sql_query.")

	UNION (SELECT ('2') AS ID,  ('POSIBLE CLIENTE') as nombre, sum(nu_valor_oportunidad) as monto FROM tbl_oportunidad a WHERE id_tipo_doc=50 ".$sql_query.")

	UNION (SELECT ('3') AS ID,  ('CLIENTE') as nombre, sum(nu_valor_oportunidad) as monto FROM tbl_oportunidad a, tbl_cotizacion b, tbl_orden_servicio c  WHERE id_tipo_doc=50 AND a.id_oportunidad=b.id_oportunidad and c.id_cotizacion=b.id_cotizacion AND (SELECT COUNT(id_ord_serv) FROM tbl_orden_servicio WHERE id_cotizacion=b.id_cotizacion)=1 ".$sql_query.") 

	UNION (SELECT ('4') AS ID,  ('CUENTA') as nombre, sum(nu_valor_oportunidad) as monto FROM tbl_oportunidad a, tbl_cotizacion b, tbl_orden_servicio c  WHERE id_tipo_doc=50 AND a.id_oportunidad=b.id_oportunidad and c.id_cotizacion=b.id_cotizacion AND (SELECT COUNT(id_ord_serv) FROM tbl_orden_servicio WHERE id_cotizacion=b.id_cotizacion)>1 ".$sql_query.")

	ORDER BY ID";
	
	 
	$res_funnel=abredatabase(g_BaseDatos,$sql_funnel);
	
	
?>					

  <div align="center">
  <?php 
			  while($row_funnel=dregistro($res_funnel)){ ?>
			   <div class="taper<?php echo $c; $c+=1; ?>" style="color:#fff; font-size:10px; ">
			   </div>
			   <div style="margin-top:-40px; margin-bottom:15px; font-size:10px; color:#fff"><?php echo $row_funnel['nombre']; ?><br>
						<?php echo number_format($row_funnel['monto'],2); ?>
			   </div>
				<?php } ?>

			   </div>

			</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="font-size:9px">
		
			<div class="panel panel-default session">
				<div class="panel-body">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:12px; height:35px" >
						<label>	Resumen Oportunidades
						</label>
						
				<select  onchange="location.href='index.php?filtro='+this.value;"  >
					<option value="1" <?php if (isset($_REQUEST['filtro']) and $_REQUEST['filtro']==1){ echo "selected"; } ?>  >Hoy</option>
					<option value="5" <?php if (isset($_REQUEST['filtro']) and $_REQUEST['filtro']==5){ echo "selected"; } ?> >Semanal</option>
					<option value="30" <?php if (isset($_REQUEST['filtro']) and $_REQUEST['filtro']==30){ echo "selected"; } ?> >Mensual</option>
					<option value="360" <?php if (isset($_REQUEST['filtro']) and $_REQUEST['filtro']==360){ echo "selected"; } ?> >Anual</option>
				</select>
					</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-13px " >
							<hr>
						</div>
					
						<div align="left" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="border-right:1px solid #ccc; margin-top:-13px; height:20px  " >
							<label>TOTAL</label>
							
						</div>
						<div align="center" class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="border-right:1px solid #ccc; margin-top:-13px; height:20px  " >
							<?php echo $total; ?>
						</div>
						<div align="right" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="margin-top:-13px " >
							S/. <?php echo number_format($total_monto_SOLES,2,',','.'); ?>
						</div>
						
					
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-13px "  >
							<hr>
						</div>
						
						<div align="left" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="border-right:1px solid #ccc; margin-top:-13px; height:20px  " >
							<label>GANADAS</label>
							
						</div>
						<div align="center" class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="border-right:1px solid #ccc; margin-top:-13px; height:20px " >
							 <?php echo $total_ganadas; ?>
						</div>
						<div align="right" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="margin-top:-13px " >
							S/. <?php echo number_format($total_soles_ganadas,2,',','.'); ?>
						</div>
					
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-13px " >
							<hr>
						</div>
						
						<div align="left" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="border-right:1px solid #ccc; margin-top:-13px; height:20px  " >
							<label>PERDIDAS</label>
							
						</div>
						<div align="center" class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="border-right:1px solid #ccc; margin-top:-13px; height:20px  " >
							<?php echo $total_perdida; ?>
						</div>
						<div align="right" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="margin-top:-13px " >
							S/. <?php echo number_format($total_soles_perdida,2,',','.'); ?>
						</div>

					
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-13px " >
							<hr>
						</div>
					
						<div align="left" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="border-right:1px solid #ccc; margin-top:-13px; height:20px   " >
							<label>ABIERTAS</label>
							
						</div>
						<div align="center" class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-top:-13px; border-right:1px solid #ccc; height:20px   " >
							 <?php echo $total-($total_ganadas+$total_perdida); ?>
						</div>
						<div align="right" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="margin-top:-13px " >
							S/. <?php echo number_format($total_soles_activas,2,',','.'); ?>
						</div>

					
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-13px " >
							<hr>
						</div>
						
						<div align="left" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="border-right:1px solid #ccc; margin-top:-13px; height:20px   " >
							<label>A TIEMPO</label>							
						</div>
						<div align="center" class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-top:-13px; border-right:1px solid #ccc; height:20px  " >
							<?php echo $total_atiempo; ?>
						</div>
						<div align="right" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="margin-top:-13px " >
							S/. <?php echo number_format($total_soles_atiempo,2,',','.'); ?>
						</div>
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-13px "  >
							<hr>
						</div>
							
						<div align="left" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="border-right:1px solid #ccc; margin-top:-13px; height:20px  " >
							<label>A DESTIEMPO</label>
							
						</div>
						<div align="center" class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-top:-13px; border-right:1px solid #ccc; height:20px  " >
							 <?php echo $total_adestiempo; ?>
						</div>
						<div align="right" class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="margin-top:-13px " >
							S/. <?php echo number_format($total_soles_adestiempo,2,',','.'); ?>
						</div>
						
					
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-13px " >
							<hr>
						</div>
						
						<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-13px " >
							<label>	EFECTIVIDAD</label><BR>
						<?php if ($total>0){ echo number_format(($total_atiempo/$total)*100,2);} else { echo "0.00"; } ?> %
						</div>
					
					
			
				</div>
			</div>
			
			
			
	</div>
	
	<!-- ULTIMOS MOVIMIENTOS --->
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	
	
		<div class="panel panel-default session">
			<div class="panel-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<label>	Ultimos Movimiento
					</label>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<hr>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
				  <?php 
				    $sql_actividad="select 
					id_oportunidad,
					tx_nombre,
					id_empresa,
					tx_tipo_documento,
					tx_tipo_servicio,
					tx_detalle,
					fe_creacion,
					fe_inicio,
					fe_probable_cierre,
					fe_actuali,
					tx_status_empresa	
					from vie_seguimiento_control_oportunidad 
					WHERE
					EXTRACT(YEAR FROM  fe_actuali)= EXTRACT(YEAR FROM NOW())  ORDER BY fe_actuali LIMIT 5 ";
					 $res_actividad=abredatabase(g_BaseDatos,$sql_actividad);
					 $configuracion_n_oportunidad="000000";
					while ($row_actividad=dregistro($res_actividad)){
					?>
					<div class="col-xs-1"> 
						<i class="fa  fa-calendar"></i>
					</div>
					<div class="col-xs-10" style="font-size:9px"> 
						<?php echo "Oportunidad #"; if ($row2['tx_documento']=='Carta de Presentación'){ echo "CP-"; }else{ echo "CO-"; } echo substr($configuracion_n_oportunidad,1,strlen($configuracion_n_oportunidad)-strlen($row_actividad['id_oportunidad'])).$row_actividad['id_oportunidad']; ?> 
						<br>
						<?php echo $row_actividad['tx_nombre']; ?> <br>
						<?php echo $row_actividad['tx_status_empresa']; ?> | Actualizada: <?php echo $row_actividad['fe_actuali']; ?>
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
	<!-- tunel de ventas --->
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
	
	
		<div class="panel panel-default session">
			<div class="panel-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<label>	Proyección de Ventas
					</label>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<hr>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
<?php 
$c=1;
	$sql_ventas="SELECT 
  EXTRACT(MONTH FROM fe_probable_cierre) as mes, sum(nu_valor_oportunidad) as monto
FROM 
vie_seguimiento_control_oportunidad
WHERE 
EXTRACT(YEAR FROM fe_probable_cierre)=EXTRACT(YEAR FROM NOW())
GROUP BY EXTRACT(MONTH FROM fe_probable_cierre) ORDER BY EXTRACT(MONTH FROM fe_probable_cierre) ";
	
	 
	$res_ventas=abredatabase(g_BaseDatos,$sql_ventas);
	
	
?>					

  <div align="center">
  <canvas id="myChart"  ></canvas>
  <?php 
	$mes=array("1"=>"Ene","2"=>"Feb","3"=>"Mar","4"=>"Abr","5"=>"May","6"=>"Jun","7"=>"Jul","8"=>"Ago","9"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dic");
	$label="";
	$data="";
			  while($row_ventas=dregistro($res_ventas)){ 
				$label.='"'.$mes[$row_ventas['mes']].'",';
				$data.=$row_ventas['monto'].",";
				} 
				
	?>
  

			   </div>

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
  
  <script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $label; ?>],
        datasets: [{
            label: 'Monto S/. ',
            data: [<?php echo $data; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
  
  

<body>
<html>