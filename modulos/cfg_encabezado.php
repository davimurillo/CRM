<style>
		body { padding-top: 70px; height:100% }
		#contenedor {
			height:100vh;
		}
		#contenedor_data {
			height:80vh;
		}
		.user-profile img {
			width: 20px;
			height: 20px;
			border-radius: 50%;
			margin-right: 10px;
		}
	</style>
<?php 
//Busca Parametros generales del sistema
	$sql="SELECT tx_nombre_empresa,tx_logo FROM cfg_configuracion_general";
	$res=abredatabase(g_BaseDatos,$sql);
	$row=dregistro($res);
	$nombre_empresa=$row['tx_nombre_empresa'];
	$logo_empresa=$row['tx_logo'];
	cierradatabase();

//selecciona los modulos segun el tipo de usuario y asignaciones
	$sql="SELECT (tx_nombre_apellido) as nombre, tx_foto_usuario, (SELECT tx_telefono FROM cfg_usuario_telefono WHERE id_usuario=a.id_usuario LIMIT 1) AS telefono, CASE WHEN id_estatu=1 THEN 'Activo' ELSE 'Inactivo' END AS estatus, to_char(fe_ultima_actualizacion, 'DD/MM/YYYY a las HH:MI am') as fecha_actualizacion, (SELECT tx_perfil FROM cfg_perfil WHERE id_perfil=a.id_perfil) AS perfil FROM cfg_usuario a WHERE id_usuario=".$_SESSION['id_usuario'];
	$res=abredatabase(g_BaseDatos,$sql);
	$row=dregistro($res);
	$nombre_usuario=$row['nombre'];
	$telefono_usuario=$row['telefono'];
	$estatus_usuario=$row['estatus'];
	$perfil=$row['perfil'];
	$fecha_actualizacion=$row['fecha_actualizacion'];
	$foto=$row['tx_foto_usuario'];
	cierradatabase();
	
	if ($foto==""){
		$foto="../img/fotos/img.jpg";	
	}else{
		$foto="repositorio/fotos_usuario/".$foto;
	}
?>
<div class="container-fluid">
		<nav class="navbar navbar-default navbar-fixed-top" style="height:50px">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="margin-top:8px; margin-right:10px">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="index.php"><img src="repositorio/logos_cintillos/<?php echo $logo_empresa; ?>" width="149px" height="49px" style="margin-top:-15px; margin-left:-17px"></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  
			 
			  <ul class="nav navbar-nav navbar-right">
			  <form class="navbar-form navbar-left"  action="mod_buscar.php" >
				<div class="input-group "   >
				
					<input name="buscar" id="buscar" type="text" class="form-control" placeholder="Buscar Clientes" >
					<span class="input-group-btn">
						<button class="btn btn-default form-control" type="submit"><i class="fa fa-search"></i></button>
					</span>
				
				</div>
			</form>
			  <li ><button type="button" class="btn btn-primary btn-sm " id="nueva_empresa_boton" style="margin-top:8px" >+ Nuevo Cliente</button>
			  </li>
				<li   ><a href="index.php"><span class="fa fa-home"></span></a></li>
				
				<li class="" >
					<a href="javascript:;" class="" title="Reportes y Estadisticas" data-toggle="dropdown" aria-expanded="false">
					   <span class=" fa fa-th"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu animated fadeIn " >
						<?php 
						$sql2="SELECT tx_reporte, tx_archivo FROM cfg_reportes";
						$res2=abredatabase(g_BaseDatos,$sql2);
						while($row2=dregistro($res2)){
						?>
						<li><a href="reportes/<?php echo $row2['tx_archivo']; ?>" target="_new"><span class="fa fa-print"></span> <?php echo $row2['tx_reporte']; ?></a> </li>
						<?php } ?>
					</ul>
				
				</li>
				
				
				
				<li  ><a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false" style="font-size:16px; margin-top:2px"><i class="fa fa-bell dropdown-toggle" ></i><span class="badge" style="font-size:8px; margin-top:-15px; margin-left:-8px; background:#ccc"><?php echo "0"; ?></span></a>
					 <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeIn" role="menu">
						<?php 
							$sql="SELECT tx_objeto FROM tbl_notificaciones WHERE id_usuario=".$_SESSION['id_usuario']." and id_status=1";
						?>
						 <li style="font-size:12px;">
							<a href=""> No tiene notificaciones</a>
						 </li>
					 </ul>
				 </li>
				
				
			  <li class="" >
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="<?php echo $nombre_usuario; ?>" style="height:50px">
                  <img src="<?php echo $foto; ?>" >
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeIn">
                  <li>
				   <li ><a href="cfg_cuentas.php?id=1"><span class="fa fa-user"></span> Mi Perfil</a></li>
				   <?php if ($_SESSION['rol']>=3){ ?>
				  <li ><a href="mod_mi_empresa.php"><span class="fa fa-cog"></span> Mi Empresa</a></li>
				   <?php } 
				   
				    if ($_SESSION['rol']==4){ ?>
				  <li ><a href="configurar.php"><span class="fa fa-cogs"></span> Configuración</a></li>
				  <?php } ?>
                  <li>
					
                    <a href="javascript:;"><span class="fa fa-book"></span> Ayuda</a>
                  </li>
                  <li><a href="logout.php"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
                  </li>
				  </li>
                </ul>
			  </li>
              
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
	</nav>
	
	<div class="modal fade"  id="myModal_empresa" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="modal-title"><span class="fa fa-building" style="margin-right:10px"></span> Nuevo Posible Cliente</h3>
		  </div>
		  <form name="form_registro_empresa" action="javascript:enviar();" data-parsley-validate >
		  <div class="modal-body" >
		   <div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<input type="textbox" class="form-control"   id="nombre_empresa" required="required"   placeholder="Nombre" autofocus>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<input type="textbox" class="form-control"   id="correo_empresa"  placeholder="Correo Electrónico" >
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<select class="form-control" required="required" id="tipo_importancia">
					 <option value="">---Seleccione---</option>
					<?php 
						 $sql = "SELECT tx_tipo,id_tipo_objeto FROM vie_tipo_importancia";
						 $res=abredatabase(g_BaseDatos,$sql);
						 while ($row=dregistro($res)){?>
						<option value="<?php echo $row['id_tipo_objeto']; ?>"><?php echo $row['tx_tipo']; ?></option>		
					<?php }
					cierradatabase();
					?>
					</select>	 
				</div>
				
				<div id="sesion_nueva_empresa" style="margin-top:10px"></div>
				
			</div>
		  </div>
		  <div class="modal-footer"  style="text-align:center">
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary" id="enviar">Guardar</button>
		  </div>
		  </form>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../lib/js/jquery.min.js"></script>
	<script>
	$('#nueva_empresa_boton').on('click', function(){
		
		$('#myModal_empresa').modal('show');
		
		 $(this).find('input:text:visible:first').focus();
		
	});
	
	//Funcion Registra los datos basico de la empresa
	function enviar(){
	  	  
	  if ($('#nombre_empresa').val()!=""){
	  $('#sesion_nueva_empresa').load('sys_evento.php',{nombre:$('#nombre_empresa').val(), correo:$('#correo_empresa').val(),importancia:$('#tipo_importancia').val(),'f':'1','a':'1'});
	  }
	}
	
	
	</script>