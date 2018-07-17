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
	<link id="switcher" href="../lib/css/theme-color/lite-blue-theme.css" rel="stylesheet">
	<link id="switcher" href="../lib/css/custom.css" rel="stylesheet">
	<style>
	 .edit_oportunidad:hover{
		 background-color:#C7DDEF;
		 cursor:pointer;
	 }
	 .editar_contacto:hover{
		 background-color:#F7F7F7;
		 cursor:pointer;
	 }
	 .editar_empresa:hover{
		 background-color:#F7F7F7;
		 cursor:pointer;
	 }
	 .user-perfil {
			width: 20px;
			height: 20px;
			border-radius: 50%;
			
	}
	.daterangepicker{z-index:1600;}
			
	</style>
</head>
<body style="background-color:#EAEAEA; font-family:Arial">
<div class="container-fluid">
<?php include('cfg_encabezado.php'); ?>
 
	
	<?php 
		$sql="SELECT tx_nombre, tx_url, tx_correo, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_empresa.id_estatus) AS estatus FROM tbl_empresa WHERE id_empresa=".$_GET['id'];
		$res=abredatabase(g_BaseDatos,$sql);
		$row=dregistro($res);
		$nombre_cliente=$row['tx_nombre']; 
		
		$sql2="SELECT count(id_contacto) as nu_contacto FROM tbl_contacto WHERE id_empresa=".$_GET['id'];
		$res2=abredatabase(g_BaseDatos,$sql2);
		$row2=dregistro($res2);
		$total_contactos=$row2['nu_contacto'];
		
	?>
		 <!-- 
		 ############################
	     # Sessión Cliente          #
		 ############################
		 -->
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 animated slideInLeft" >
			
			<div class="list-group " >
				<div id="tabla_objeto" class="list-group-item active" >
					<div class="row" >
						<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" >
							<i class="fa fa-building"></i> Cliente
						</div>
						<div align="right" class="col-lg-7 col-md-7 col-sm-7 col-xs-7" style="font-size:17px" >
							
							<i class="fa fa-map-marker" style="margin-right:5px; cursor:pointer" title="Agregar Dirección de Ubicación" onclick="javascript:abrir_direccion(<?php echo $_GET['id']; ?>);"></i>
							 <i class="fa fa-phone" title="Agregar Teléfonos" onclick="javascript:abrir_telefonos(<?php echo $_GET['id']; ?>);" style="margin-right:5px; cursor:pointer"></i>
							 
							
							<i class="fa fa-search" title="Buscar Clientes" onclick="javascript:abrir_lista_clientes(<?php echo $_GET['id']; ?>);" style="cursor:pointer"></i>
							
							<i class="fa fa-bar-chart" title="Estadística del Cliente" onclick="javascript:location.href='mod_seguimiento.php?id=<?php echo $_GET['id']; ?>';" style="cursor:pointer"></i>
												
						</div>
						
						
					</div>
					
			  </div>
			  <div class="list-group-item"  >
					<div id="editar_empresa" class="row editar_empresa"   >
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="font-size:20px"> <?php echo $nombre_cliente; ?> 
						</div>
						<div id="datos_empresa" align="right"  class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="font-size:15px" title="Click para Editar"> <span style="font-size:10px; color:#888">Editar</span><a href="#" > <i class="fa fa-edit" style="color:#888"></i></a> 
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:12px"> <i class="fa fa-envelope-o"></i>  <?php echo $row['tx_correo']; ?> 
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:12px"> <i class="fa fa-link"></i> <a href="http://<?php echo $row['tx_url']; ?>" target="_new" > <?php echo $row['tx_url']; ?> </a>
						</div>
						
					</div>
					
				</div>
		 
		 <!-- 
		 ############################
	     # Sessión Oportunidad      #
		 ############################ 
		 -->
		   <div id="tabla_objeto" class="list-group-item active" >
				<div class="row" >
				   	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" >
						<i class="fa fa-cube"></i> Oportunidad
					</div>
					<div  align="right" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="font-size:17px"  >
						<i id="filtro_oportunidad" class="fa fa-filter" title="Aplicar Filtro Oportunidad" style="cursor:pointer"></i>
						<i id="registrar_oportunidad" class="fa fa-plus-square-o"title="Agregar Nueva Oportunidad" style="cursor:pointer" ></i>
					</div>
					
				</div>
				
		  </div>
		  
		  <?php 
		  
				$configuracion_n_oportunidad="000000";
				$sql2="SELECT id_oportunidad, tx_detalle,  (SELECT SUM(nu_avance) FROM tbl_seguimiento WHERE id_oportunidad=tbl_oportunidad.id_oportunidad AND id_status=59) AS nu_avance, to_char(fe_probable_cierre,'DD/MM/YYYY') as fe_probable_cierre, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_status) AS id_status, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_tipo_doc) AS tipo_doc, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_tipo_moneda) AS moneda, (SELECT tx_nombre_apellido FROM cfg_usuario WHERE id_usuario=tbl_oportunidad.id_usuario) AS usuario, (SELECT tx_foto_usuario FROM cfg_usuario WHERE id_usuario=tbl_oportunidad.id_usuario) AS foto_usuario, nu_valor_oportunidad, nu_confianza_valor, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_condicion) AS id_condicion, (SELECT  (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_cotizacion.id_moneda)  FROM tbl_cotizacion WHERE id_oportunidad=tbl_oportunidad.id_oportunidad ORDER BY id_cotizacion DESC LIMIT 1) AS moneda_cotiza, (SELECT  nu_monto FROM tbl_cotizacion WHERE id_oportunidad=tbl_oportunidad.id_oportunidad ORDER BY id_cotizacion DESC LIMIT 1) AS monto_cotiza, (SELECT  nu_revision  FROM tbl_cotizacion WHERE id_oportunidad=tbl_oportunidad.id_oportunidad ORDER BY id_cotizacion DESC LIMIT 1) AS revision_cotiza FROM tbl_oportunidad WHERE id_empresa=".$_GET['id'];
				if (isset($_GET['est_opor']) and $_GET['est_opor']>0){
					$sql2.=" AND id_status=".$_GET['est_opor'];
				}else { 
					$sql2.=" AND (id_status<>151 AND id_status<>137)";
				}
				if (isset($_GET['tipo_opor']) and $_GET['tipo_opor']>0){
					$sql2.=" AND id_tipo_doc=".$_GET['tipo_opor'];
				}
				if (isset($_GET['cod_opor']) and $_GET['cod_opor']>0){
					$sql2.=" AND id_condicion=".$_GET['cod_opor'];
				}
				$sql2.=" ORDER BY id_oportunidad";
				$res2=abredatabase(g_BaseDatos,$sql2);
				
				while ($row2=dregistro($res2)){ 
				
				$foto=$row2['foto_usuario'];
				if ($foto==""){
					$foto="../img/fotos/img.jpg";	
				}else{
					$foto="repositorio/fotos_usuario/".$foto;
				}
				
				$id_oportunidad=$row2['id_oportunidad']; 
				$tipo_oportunidad=$row2['tipo_doc']; 
				
		?>
					<div id="edit_oportunidad_<?php echo $row2['id_oportunidad']; ?>" class="list-group-item edit_oportunidad" >
						<div class="row"  onclick="javascript:abrir_oportunidad(<?php echo $row2['id_oportunidad']; ?>);" style="margin-top=5px">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn-primary" style="font-size:14px;" >
							<i class="fa fa-cube" ></i> #<?php  if ($row2['tipo_doc']=='Carta de Presentación'){ echo "CP-"; }else{ echo "CO-"; } echo substr($configuracion_n_oportunidad,1,strlen($configuracion_n_oportunidad)-strlen($row2['id_oportunidad'])).$row2['id_oportunidad']; ?> 
						</div>
						<div align="right" class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="font-size:16px;" >
							<span style="font-size:10px; color:#888">Editar</span><a href="javascript:editar_oportunidad(<?php echo $row2['id_oportunidad']; ?>);" > <i class="fa fa-edit" style="color:#888"></i></a>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:5px; margin-bottom:10px font-size:13px; font-weight:bold; color:#337AB7">
							<?php echo $row2['tipo_doc']; ?>
						</div>
						<div align="left" class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="font-size:9px" >
							<?php echo $row2['id_status']; ?>
						</div>
						<div align="right" class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="font-size:10px">
							<div class="progress" style="width:80%; text-align:center; font-size:9px; color:#888; ">
								<div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $row2['nu_avance']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row2['nu_avance']; ?>%; color:#6666">
										<span ><?php echo $row2['nu_avance']; ?>% Completado</span>
								</div>
								<label style="margin-top:3px; color:#999">% de Avance</label>
							</div>
							
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:12px; margin-top:-30px" title="Fecha Probable de Cierre de la Oportunidad">
									<label style="font-size:10px"><i class="fa fa-calendar" ></i> <Label> 
									<?php echo $row2['fe_probable_cierre']; ?>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:11px;margin-top:-10px " >
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:10px">
									 <label>Valor Estimado:</label> <?php echo $row2['moneda']." ".number_format($row2['nu_valor_oportunidad'],2,'.',','); ?> | <span style="font-size:8px"><?php echo $row2['nu_confianza_valor']; ?> % </span>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:10px; ">
									 <label>Cotización:</label> <?php echo $row2['moneda_cotiza']." ".number_format($row2['monto_cotiza'],2,'.',','); ?> | <span style="font-size:7px"><?php echo "REV. ".$row2['revision_cotiza']; ?>  </span>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:12px;">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
									<label><img class="user-perfil" src="<?php echo $foto; ?>">  <?php echo $row2['usuario']; ?> </label>
								</div>
								<div align="right" class="col-lg-6 col-md-6 col-sm-6 col-xs-6" onclick="agregar_cotizacion(<?php echo $row2['id_oportunidad']; ?>)" >
									<?php  if ($tipo_oportunidad=='Cotización'){?>
									<button id="agregar_cotizacion" class="btn btn-warning btn-sm">
										<i class="fa fa-laptop"></i> Cotización 
									</button>
									<?php }?>
								</div>
							</div>	
						</div>
					</div>
				    
				</div>
				
				
		<?php
				} cierradatabase();
		  ?>
		<!-- 
		 ############################
	     # Sessión Contactos      	#
		 ############################ 
		 -->
			<div id="tabla_objeto" class="list-group-item active" >
				<div class="row" >
				    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" >
						<i class="fa fa-user"></i> Contactos
					</div>
					<div id="registrar_contacto" align="right" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="font-size:17px; cursor:pointer" title="Agregar Contacto" onclick="javascript:abrir_contacto(<?php echo $_GET['id']; ?>);">
						<i class="fa fa-plus-square-o"></i>
					</div>
				</div>
				
			</div>
		   <?php 
				$sql2="SELECT id_contacto, tx_contacto, tx_cargo,(SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_contacto.id_condicion) AS id_condicion, tx_correo_primario FROM tbl_contacto WHERE  id_empresa=".$_GET['id'];
				$res2=abredatabase(g_BaseDatos,$sql2);
				if (dnumerofilas($res2)>0){ 
				while ($row2=dregistro($res2)){
		?>
				<div id="tabla_objeto" class="list-group-item" >
				<div class="row editar_contacto" id="<?php echo $row2['id_contacto']; ?>"  >
				    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" >
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:11px">
									<?php echo $row2['tx_contacto']; ?>
								</div>
								
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
									<span style="font-size:10px"><?php echo $row2['tx_cargo']; ?> (<?php echo $row2['id_condicion']; ?>) </span>
								</div>
							</div>
					</div>
					
					<div align="right" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="font-size:18px">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:17px; margin-top:5px">
									 <button class="btn btn.default btn-xs" title="Registrar LLamada" onclick="javascript:envio_llamada_contacto('<?php echo "Contacto:".$row2['tx_contacto']." Cargo:".$row2['tx_cargo']; ?>');">
									 <i class="fa fa-phone"></i>
									 </button> 
									<button  class="btn btn.default btn-xs" title="Enviar Correo" onclick="javascript:envio_mail_contacto('<?php echo $row2['tx_correo_primario']; ?>');">
									<i class="fa fa-envelope-o"></i>
									</button>
								</div>
								
							</div>
					</div>
				</div>
				
			</div>
				
				
		<?php
				}} else {
		  ?>
		       <div align="center" id="tabla_objeto" class="list-group-item" style="color:orange; cursor:pointer" onclick="javascript:abrir_contacto(<?php echo $_GET['id']; ?>);">
			     <i class="fa fa-info-circle" style="font-size:140px"></i> 
				 <br><span > Es importante tener contactos, haga clik aquí o haga click en el icono <i class="fa fa-plus-square-o" style="font-size:18px"></i> para agregar contactos
			   </div >
		  <?php
				}cierradatabase();
		  ?>
			
		</div>
	</div>
	
	 <!-- 
		 #########################################
	     # Sessión Contenido del Seguimiento     #
		 ######################################### 
	-->
	<div id="informacion" class="col-lg-9 col-md-9 col-sm-8 col-xs-12" style="background-color:#fff; " >
			<div class="row"  id="seguimiento_tareas">
			
			</div>
	</div>
</div>
</div>
</div>
</div>

<!-- Ventana Modal para Edicion de elementos del Seguimiento -->
<div class="modal fade"   id="myModal_seguimiento" role="dialog" style="color:#999;">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="modal-title" id="titulo"></h3>
		  </div>
		  
		  <div id="edicion_seguimiento" class="modal-body" >
		   
		  </div>
		  
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Ventana para incluir Direcciones -->
	<div class="modal fade" tabindex="-1" id="myModal_direccion" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title" ><span class="fa fa-map-marker" style="margin-right:10px"></span><label >Dirección de la Empresa</label></h2>
		  </div>
		  <div class="modal-body" >
		   
				<iframe id="direccion_data" src="" height="250px" width="100%" allowtransparency="1" frameborder="0"></iframe>
			
		  </div>
		  <div class="modal-footer"  style="text-align:center">
				  
			
			
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana para incluir Telefonos -->
	<div class="modal fade" tabindex="-1" id="myModal_telefonos" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title" ><span class="fa fa-phone" style="margin-right:10px"></span><label >Teléfonos de la Empresa</label ></h2>
		  </div>
		  <div class="modal-body" >
		 
				<iframe id="telefonos_data" src="" height="250px" width="100%" allowtransparency="1" frameborder="0"></iframe>
			
		  </div>
		  <div class="modal-footer"  style="text-align:center">
				  
			
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana para incluir contactos -->
	<div class="modal fade" tabindex="-1" id="myModal_contacto" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title" ><span class="fa fa-user" style="margin-right:10px"></span><label >Contacto Empresa</label ></h2>
		  </div>
		  <div class="modal-body" >
		 
				<iframe id="contacto_data" src="" height="350px" width="100%" allowtransparency="1" frameborder="0"></iframe>
			
		  </div>
		  <div class="modal-footer"  style="text-align:center">
				  
			
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana para cliente -->
	<div class="modal fade" tabindex="-1" id="myModal_lista_clientes" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title" ><span class="fa fa-building" style="margin-right:10px"></span><label>Lista de Clientes</label></h2>
		  </div>
		  <div class="modal-body" >
			<div id="lista_cliente"></div>
			
			
		  </div>
		 
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana para tareas -->
	<div class="modal fade" tabindex="-1" id="myModal_agregar_tarea" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-check-square-o" style="margin-right:10px"></span>Nueva Tarea</h2>
		  </div>
		  <div class="modal-body" >
			<div id="tareas">
				<form name="form_registro_tarea" method="post" action="javascript:registra_tarea();" data-parsley-validate >
					<div class="row">
		
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<label >Tipo de Tarea *:</label>
								<select class="form-control"  id="tipo_tarea" required="required">
								<?php 
									 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM vie_tipo_seguimiento ORDER BY nu_predeterminado DESC";
									 $res2=abredatabase(g_BaseDatos,$sql2);
									 while ($row2=dregistro($res2)){?>
									<option value="<?php echo $row2['id_tipo_objeto']; ?>" ><?php echo $row2['tx_tipo']; ?></option>		
								<?php }
									cierradatabase();
								?>
								</select>
							</div>
			
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<label >Estatus *:</label>
								<select class="form-control"  id="estatus_tarea" required="required">
									
									<?php 
										 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM vie_status_seguimiento ORDER BY nu_predeterminado DESC";
										 $res2=abredatabase(g_BaseDatos,$sql2);
										 while ($row2=dregistro($res2)){?>
										<option value="<?php echo $row2['id_tipo_objeto']; ?>" ><?php echo $row2['tx_tipo']; ?></option>		
									<?php }
										cierradatabase();
									?>
								</select>
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<label >Fecha de Inicio *:</label>
										<input id="fecha_inicio" class="date-picker form-control col-md-7 col-xs-12" required="required" >
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<label >Fecha de Cierre *:</label>
										<input id="fecha_cierre" class="date-picker form-control col-md-7 col-xs-12" required="required" >
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<label >Avance % *:</label>
										<input id="n_avance" class="form-control col-md-7 col-xs-12" required="required" >
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<label >N° de Dias*:</label>
										<input id="n_dias" class="form-control col-md-7 col-xs-12" required="required" >
							</div>
							
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
								<label >Descripción : </label >
								<textarea id="descripcion" class="form-control"   required="required" ></textarea>
							</div>
							
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
								<label >Observación : </label >
								<textarea id="observacion" class="form-control"   ></textarea>
							</div>
							
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<hr>
						</div>
						
						<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary"  >Guardar</button>
							
						  </div>
				
			
				</div>
				</form>
	
			</div>
		</div>
	</div>
	<div id="registro_tarea"></div>
	
	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	
	<!-- Ventana para modificar tareas -->
	<div class="modal fade" tabindex="-1" id="myModal_modificar_tarea" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-check-square-o" style="margin-right:10px"></span>Editar Tarea</h2>
		  </div>
		  <div class="modal-body" >
			<div id="tareas_modificar">
				<form name="form_modificar_tarea" method="post" action="javascript:modificar_tarea();" data-parsley-validate >
					<div class="row" >
					
					<div id="modificar_form_tarea" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
					</div>
					
				     <div id="modificar_tarea"></div>
				    </div>
					
				</form>
	
			</div>
		</div>
	</div>
	
	
	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	
	<!-- Ventana para eventos -->
	<div class="modal fade" tabindex="-1" id="myModal_agregar_evento" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-check-square-o" style="margin-right:10px"></span>Nueva Evento</h2>
		  </div>
		  <div class="modal-body" >
			<div id="evento"></div>
			
			
		  </div>
		 <div id="registro_evento"></div>
			</div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana para cotizaciones de oportunidades -->
	<div class="modal fade"  id="myModal_cotizacion" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-file-text" style="margin-right:10px"></span>Cotizaciones</h2>
		  </div>
		  <div class="modal-body" >
		 
				<iframe id="cotizaciones" src="" height="350px" width="100%" allowtransparency="1" frameborder="0"></iframe>
			
		  </div>
		  <div class="modal-footer"  style="text-align:center">
				  
			
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana de cierre de oportunidades -->
	<div class="modal fade"  id="myModal_cierre_oportunidad" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-cube" style="margin-right:10px"></span>Cierre de Oportunidad</h2>
		  </div>
		  <div id="cierre_oportunidad" class="modal-body" >
				
		  </div>
		  
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana de cierre de oportunidades para orden de servicio -->
	<div class="modal fade"  id="myModal_cierre_oportunidad_orden" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-cube" style="margin-right:10px"></span>Orden de Servicio</h2>
		  </div>
		  <div id="cierre_oportunidad_orden" class="modal-body" >
				<iframe id="orden_servicio" src="" height="350px" width="100%" allowtransparency="1" frameborder="0"></iframe>
		  </div>
		   
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana nota de oportunidades -->
	<div class="modal fade"  id="myModal_nota_oportunidad" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-comment" style="margin-right:10px"></span>Notas a la Oportunidad</h2>
		  </div>
			<div class="modal-body" >
			  <div class="row">
			    <form action="javascript:registro_nota();" >
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<textarea id="nota_oportunidad" class="form-control" placeholder="Agrege una nueva nota a la oportunidad"></textarea> 
					
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<hr>
					</div>
			
					<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary"  >Guardar</button>
						<div id="registro_nota"></div>
					</div>
				</form>
				</div>
			</div>
		  
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana mail de oportunidades -->
	<div class="modal fade"  id="myModal_mail_oportunidad" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-envelope-o" style="margin-right:10px"></span>Enviar Mail</h2>
		  </div>
			<div class="modal-body" >
			  <div class="row">
			   <form action="javascript:registro_email();">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label>Contactos</label>
					<input id="correos" type="email" class="form-control" placeholder="agregar correo" required="required">
					
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label>Asunto</label>
					<input id="asunto_mail" type="textbox" class="form-control" placeholder="Asunto del correo" required="required">
					
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label>Contenido</label>
					<textarea id="descripcion_mail" rows="6" class="form-control" placeholder="Agrege contenido del correo"></textarea> 
					
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<hr>
					</div>
		
					<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary"  >Guardar</button>
						<div id="edit_mail_oportunidad"></div>
					  </div>
					</form>
				</div>
			</div>
		  
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Ventana llamada de oportunidades -->
	<div class="modal fade"  id="myModal_llamada_oportunidad" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-phone" style="margin-right:10px"></span>Registro de Llamadas</h2>
		  </div>
			<div class="modal-body" >
			  <div class="row">
			   <form action="javascript:registro_llamada();">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<textarea id="llamada_oportunidad" class="form-control" placeholder="Agrege datos de la llamada"></textarea> 
					
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<hr>
					</div>
			
					<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary"  >Guardar</button>
						<div id="llamadas_eventos"></div>
					</div>
				</form>
				</div>
			</div>
		  
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Ventana llamada de oportunidades -->
	<div class="modal fade"  id="myModal_filtro_oportunidad" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-filter" style="margin-right:10px"></span>Aplicar Filtro</h2>
		  </div>
			<div class="modal-body" >
			  <div class="row">
			   
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-top:10px">
					Tipo de Oportunidad:
					<select class="form-control"  id="filtro_tipo_oportunidad">
					<option value="0">Todos</option>
					<?php 
					     
						$sql = "SELECT id_tipo_objeto,tx_tipo FROM vie_tipo_oportunidad";
						 
						 $res=abredatabase(g_BaseDatos,$sql);
						 while ($row=dregistro($res)){?>
						<option value="<?php echo $row['id_tipo_objeto']; ?>"><?php echo $row['tx_tipo']; ?></option>		
					<?php }
					cierradatabase();
					?>
					</select>	
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-top:10px">
					Estatus de Oportunidad:
					<select class="form-control"  id="filtro_estatus_oportunidad">
					<option value="0">Todos</option>
					<?php 
					     
						$sql = "SELECT id_tipo_objeto,tx_tipo FROM vie_status_oportunidad";
						 
						 $res=abredatabase(g_BaseDatos,$sql);
						 while ($row=dregistro($res)){?>
						<option value="<?php echo $row['id_tipo_objeto']; ?>"><?php echo $row['tx_tipo']; ?></option>		
					<?php }
					cierradatabase();
					?>
					</select>	
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="margin-top:10px">
					Condición:
					<select class="form-control"  id="filtro_tipo_condicion">
					<option value="0">Todos</option>
					<?php 
					     
						$sql = "SELECT id_tipo_objeto,tx_tipo FROM vie_tipo_condicion_oportunidad";
						 
						 $res=abredatabase(g_BaseDatos,$sql);
						 while ($row=dregistro($res)){?>
						<option value="<?php echo $row['id_tipo_objeto']; ?>"><?php echo $row['tx_tipo']; ?></option>		
					<?php }
					cierradatabase();
					?>
					</select>	
				</div>
				<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    <hr>
				</div>
					<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						<button id="evento_filtro_oportunidad" type="button" class="btn btn-primary"  >Guardar</button>
						
					</div>
				
				</div>
			</div>
		  
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana nota de oportunidad sobre el contacto -->
	<div class="modal fade"  id="myModal_llamado_alusuario" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-user" style="margin-right:10px"></span>Alerta al Usuario</h2>
		  </div>
			<div class="modal-body" >
			  <div class="row">
			   
					<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					  <i class="fa fa-frown-o" style="font-size:82px"></i><br>
					  Error: No existe contacto asociado a la oportunidad
					  <hr>
					  
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label>Posibles Problemas: </label><br>
					  1) No existen contactos debe crear un contacto, tiene que ir a crear uno o mas contactos en la sección de contactos debajo de la sección de la oportunidad. <br>
					  2) La oportunidad no tiene asignado un contacto, debe editar la oportunidad y asignarle un contacto para continuar con la ejecución de las actividades de la oportunidad. 
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<hr>
					</div>
			
					<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
						
					</div>
				
				</div>
			</div>
		  
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<!-- Librerias JS -->
<script src="../lib/js/jquery.min.js"></script>
<script src="../lib/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="../lib/js/moment/moment.min.js"></script>
<script type="text/javascript" src="../lib/js/datepicker/daterangepicker.js"></script>
<script src="../lib/js/knob/jquery.knob.min.js"></script>
<script src="../lib/js/bootstrap.min.js" ></script>

 

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


<!-- script del sistema -->
<script>
	$('#seguimiento_tareas').load('mod_seguimiento_resumen.php',{'id':<?php echo $_GET['id']; ?>});

	// modificacion de tareas
	function modificar_tarea_evento(id){
		$('#modificar_tarea').load('sys_evento.php',{'id':id,'tipo_tarea':$('#tipo_tarea_modificar').val(),'estatus_tarea':$('#estatus_tarea_modificar').val(),'fe_inicio':$('#fecha_inicio_modificar').val(),'fe_cierre':$('#fecha_cierre_modificar').val(),'n_avance':$('#n_avance_modificar').val(),'n_dias':$('#n_dias_modificar').val(),'descripcion':$('#descripcion_modificar').val(),'observacion':$('#observacion_modificar').val(),'f':'5', 'a':'6'});
	}
	
	function seguimiento_cierre_definitivo(id){
		if (id>0){
			$('#titulo').html('');
			$('#edicion_seguimiento').html('');
			$('#titulo').html('<i class="fa fa-cube"></i> Registrar Oportunidad');
			$('#edicion_seguimiento').load('sys_evento.php',{'id':'<?php echo $_GET['id']; ?>', 'f':'2','a':'1','id_padre':id});
			$('#myModal_seguimiento').modal('show');
		}else {
			location.reload();
		}
	}
	
	function check_seguimiento_evento_cierre_cotizacion(id,id_oportunidad,id_tipo_doc) {
		if ($('input[name=options_cierre]:checked').val()==1){
				
		$('#myModal_cierre_oportunidad').modal('hide');
		$('#myModal_cierre_oportunidad_orden').modal('show');
		$('#orden_servicio').attr('src','mod_seguimiento_orden_servicio.php?id_oportunidad='+id_oportunidad+'&id='+id+'&observacion='+$('#observacion').val()+'&id_tipo_doc='+id_tipo_doc);
		}else{
			check_seguimiento_evento_cierre(id,id_oportunidad);
		}
	}
	
	function check_seguimiento_cierre(id,id_oportunidad) {
		$('#myModal_cierre_oportunidad').modal('show');
		$('#cierre_oportunidad').load('mod_seguimiento_cierre.php',{'id':id,'id_oportunidad':id_oportunidad});
	}
	
	function check_seguimiento_evento_cierre(id,id_oportunidad,id_tipo_doc) {
		
		
		$('#cierre_oportunidad').load('sys_evento.php',{'f':'3','a':'5','id':id, 'id_oportunidad':id_oportunidad,'tipo_condicion':$('input[name=options_cierre]:checked').val(),'observacion':$('#observacion').val(),'id_tipo_doc':id_tipo_doc});
	}
	
	function check_seguimiento(id,id_oportunidad) {
		$('#seguimiento_tareas').load('sys_evento.php',{'f':'3','a':'1','id':id, 'id_oportunidad':id_oportunidad});
	}

	
	function abrir_oportunidad(id) {
		$('#seguimiento_tareas').load('mod_seguimientos_tareas.php',{'id':id});
		
		
	}
	function abrir_direccion(id) {
			$('#myModal_direccion').modal('show');
			url="mod_posible_cliente_direccion.php?id="+id;
			$('#direccion_data').attr('src',url);
	}
	function abrir_telefonos(id) {
			$('#myModal_telefonos').modal('show');
			url="mod_posible_cliente_telefonos.php?id="+id;
			$('#telefonos_data').attr('src',url);
	}
	
	function abrir_lista_clientes(id) {
			$('#myModal_lista_clientes').modal('show');
			 $('#lista_cliente').load('mod_lista_cliente.php?buscar');
	}
	
	//Registra los datos basico de la empresa
	$('#datos_empresa').on('click',function(){
	    $('#titulo').html('');
		$('#edicion_seguimiento').html('');
	  
	   $('#titulo').html('<i class="fa fa-building"></i> Editar Datos del Cliente');
	   
	  $('#edicion_seguimiento').load('sys_evento.php',{id:'<?php echo $_GET['id']; ?>', 'f':'1','a':'2'});
	  $('#myModal_seguimiento').modal('show');
	 // $(this).find('input:text:visible:first').focus();
	});
	
	//Editar los datos basico de la oportunidad
	function editar_oportunidad(id){
	   $('#titulo').html('');
		$('#edicion_seguimiento').html('');
	   $('#titulo').html('<i class="fa fa-cube"></i> Editar Oportunidad #'+id);
	  $('#edicion_seguimiento').load('sys_evento.php',{'id':id, 'f':'2','a':'2'});
	  $('#myModal_seguimiento').modal('show');
	 // $(this).find('input:text:visible:first').focus();
	}
	
	//Registra los datos basico de la oportunidad
	$('#registrar_oportunidad').on('click',function(){
	   $('#titulo').html('');
		$('#edicion_seguimiento').html('');
	   $('#titulo').html('<i class="fa fa-cube"></i> Registrar Oportunidad');
	  $('#edicion_seguimiento').load('sys_evento.php',{'id':'<?php echo $_GET['id']; ?>', 'f':'2','a':'1','id_padre':0});
	  $('#myModal_seguimiento').modal('show');
	 
	});
	
	//filtrar oportunidad
	$('#filtro_oportunidad').on('click',function(){
		$('#myModal_filtro_oportunidad').modal('show');
	});
	
	//filtrar oportunidad
	$('#evento_filtro_oportunidad').on('click',function(){
	location.href="mod_seguimiento.php?id="+<?php echo $_GET['id']; ?>+"&est_opor="+$('#filtro_estatus_oportunidad').val()+"&cod_opor="+$('#filtro_tipo_condicion' ).val()+"&tipo_opor="+$('#filtro_tipo_oportunidad').val();
	});
	
	function abrir_contacto(id) {
			$('#myModal_contacto').modal('show');
			url="mod_contactos.php?empresa="+id+"&f=1";
			$('#contacto_data').attr('src',url);
	}
	
	
	//Registra email de contactos
	function envio_mail_contacto(variable){
	 
	  $('#correos').val(variable);
	
	  $('#myModal_mail_oportunidad').modal('show');
	  
	}
	
	//Registra llamda de contactos
	function envio_llamada_contacto(variable){
	 
	  $('#llamada_oportunidad').val(variable);
	
	  $('#myModal_llamada_oportunidad').modal('show');
	  
	}
	
	//Registra cotizacion
	function agregar_cotizacion(id){
			
			$('#myModal_cotizacion').modal('show');
			url="mod_cotizacion.php?id="+id+"&f=1";
			$('#cotizaciones').attr('src',url);
			
	}
	
	/*Registra notas eventos para empresa
	function registro_nota(){
			
			$('#registro_nota').load('sys_evento.php',{id:<?php echo $_GET['id']; ?>,descripcion:$('#nota_oportunidad').val(),'f':'4','a':'1'});
		}
	
	//Registra llamadas eventos para empresa
	function registro_llamada(){
			
			$('#registro_nota').load('sys_evento.php',{id:<?php echo $_GET['id']; ?>,descripcion:$('#llamada_oportunidad').val(),'f':'4','a':'3'});
		}
		
	//Registra email eventos para empresa
	function registro_email(){
			
			$('#edit_mail_oportunidad').load('sys_evento.php',{id:<?php echo $_GET['id']; ?>,correo:$('#correos').val(), asunto:$('#asunto_mail').val(),descripcion:$('#descripcion_mail').val(),'f':'4','a':'4'});
		}
	*/
	
	
	 $('#fecha_inicio').daterangepicker({
                singleDatePicker: true,
				"locale": {
					"format": "DD/MM/YYYY",
            "separator": " - ",
			"applyLabel": "Aplicar",
			"cancelLabel": "Cerrar",
			"fromLabel": "Desde",
			"toLabel": "Hasta",
			"customRangeLabel": "Custom",
			"weekLabel": "S",
			"daysOfWeek": [
				"Do",
				"Lu",
				"Ma",
				"Mi",
				"Ju",
				"Vi",
				"Sa"
			],
			"monthNames": [
				"Ene",
				"Feb",
				"Mar",
				"Abr",
				"May",
				"Jun",
				"Jul",
				"Ago",
				"Sep",
				"Oct",
				"Nov",
				"Dic"
			]
			}
              });
			  
			 $('#fecha_cierre').daterangepicker({
                singleDatePicker: true,
				"locale": {
					"format": "DD/MM/YYYY",
            "separator": " - ",
			"applyLabel": "Aplicar",
			"cancelLabel": "Cerrar",
			"fromLabel": "Desde",
			"toLabel": "Hasta",
			"customRangeLabel": "Custom",
			"weekLabel": "S",
			"daysOfWeek": [
				"Do",
				"Lu",
				"Ma",
				"Mi",
				"Ju",
				"Vi",
				"Sa"
			],
			"monthNames": [
				"Ene",
				"Feb",
				"Mar",
				"Abr",
				"May",
				"Jun",
				"Jul",
				"Ago",
				"Sep",
				"Oct",
				"Nov",
				"Dic"
			]
			}
              });
  
</script>
<?php if (isset($_GET['id_opor'])){ ?>
	<script>
		abrir_oportunidad(<?php echo $_GET['id_opor']; ?> );
	</script>
<?php } ?>	

<body>
<html>