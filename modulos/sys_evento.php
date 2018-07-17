<?php require_once('common.php'); checkUser(); //chequeo de usuario entrante 

//Registro Basico de Empresas
if ($_POST['f']==1 && $_POST['a']==1){

	//Guarda los Datos
	$sql="INSERT INTO tbl_empresa(tx_nombre,tx_correo,id_estatus,id_importancia, id_useact) VALUES('".$_POST['nombre']."','".$_POST['correo']."',42,".$_POST['importancia'].",".$_SESSION['id_usuario'].")";
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
	
	//Busca la empresa creada
	$sql="SELECT id_empresa FROM tbl_empresa WHERE id_useact=".$_SESSION['id_usuario']." ORDER BY id_empresa DESC LIMIT 1 ";
	$res=abredatabase(g_BaseDatos,$sql);
	$row=dregistro($res);
	echo "<script> location.href='mod_seguimiento.php?id=".$row['id_empresa']."'; </script>";
	cierradatabase();
}

//Editar de Datos de Empresas
if ($_POST['f']==1 && $_POST['a']==2){
	//Busca la empresa creada
	$sql="SELECT id_empresa,tx_nombre, tx_ruc, tx_descripcion, tx_correo,id_tipo_empresa,id_importancia,tx_url,id_estatus, (SELECT id_usuario FROM vie_usuario_empresa WHERE id_empresa=tbl_empresa.id_empresa) AS id_usuario FROM tbl_empresa WHERE id_empresa=".$_POST['id'];
	$res=abredatabase(g_BaseDatos,$sql);
	$row=dregistro($res);
	if (dnumerofilas($res)>0){
?>
	<form name="form_registro_empresa_editar" action="javascript:enviar_editar_empresa();" data-parsley-validate >
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<label >Nombre * :</label>
			<input type="textbox" class="form-control" required="required"   id="nombre_empresa_editar"  placeholder="Nombre" value="<?php echo $row['tx_nombre']; ?>">
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<label >Estatus :</label>
					<select class="form-control" required="required" id="estatus_empresa">
					
					<?php 
						 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM vie_status_empresa";
						 $res2=abredatabase(g_BaseDatos,$sql2);
						 while ($row2=dregistro($res2)){?>
						<option value="<?php echo $row2['id_tipo_objeto']; ?>" <?php if ($row2['id_tipo_objeto']==$row['id_estatus']){ echo 'Selected'; } ?>><?php echo $row2['tx_tipo']; ?></option>		
					<?php }
					 
					?>
					</select>	 
		</div>
		
		
	
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<label >N° RUC:</label>
			<input type="textbox" class="form-control"   id="ruc"  placeholder="N° RUC" value="<?php echo $row['tx_ruc']; ?>">
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<label >URL:</label>
			<input type="textbox" class="form-control"   id="url"  placeholder="URL" value="<?php echo $row['tx_url']; ?>">
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label >Tipo de Importancia * :</label>
					<select class="form-control" required="required" id="tipo_importancia_editar">
					
					<?php 
						 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM vie_tipo_importancia";
						 $res2=abredatabase(g_BaseDatos,$sql2);
						 while ($row2=dregistro($res2)){?>
						<option value="<?php echo $row2['id_tipo_objeto']; ?>" <?php if ($row2['id_tipo_objeto']==$row['id_importancia']){ echo 'Selected'; } ?>><?php echo $row2['tx_tipo']; ?></option>		
					<?php }
					 
					?>
					</select>	 
			
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label >Tipo de Empresa *:</label>
					<select class="form-control"  id="tipo_empresa" required="required">
					<option value="">Seleccione</option>
					<?php 
						 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM vie_tipo_empresa ";
						 $res2=abredatabase(g_BaseDatos,$sql2);
						 while ($row2=dregistro($res2)){?>
						<option value="<?php echo $row2['id_tipo_objeto']; ?>" <?php if ($row2['id_tipo_objeto']==$row['id_tipo_empresa']){ echo 'Selected'; } ?>><?php echo $row2['tx_tipo']; ?></option>		
					<?php }
						
					?>
					</select>	 
			
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<label >Correo Electrónico:</label>
			<input type="textbox" class="form-control"   id="correo_editar"  placeholder="Correo Electrónico" value="<?php echo $row['tx_correo']; ?>">
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label style="color: red;">Usuario Asignado *:</label>
					<select class="form-control"  id="usuario_empresa" required="required">
					<option value="">Seleccione</option>
					<?php 
							 $sql2 = "SELECT id_usuario, tx_nombre_apellido FROM cfg_usuario ORDER BY tx_nombre_apellido";
							 $res2=abredatabase(g_BaseDatos,$sql2);
							 while ($row2=dregistro($res2)){?>
							 
							<option value="<?php echo $row2['id_usuario']; ?>" <?php if ($row2['id_usuario']==$row['id_usuario']){ echo 'Selected'; } ?>><?php echo $row2['tx_nombre_apellido']; ?></option>		
						<?php }
							
						?>
					</select>	 
			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label >Descripción:</label>
			<input type="textbox" class="form-control"   id="descripcion"  placeholder="Descripción" value="<?php echo $row['tx_descripcion']; ?>">
		</div>
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<hr>
		</div>
		
		<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary" >Actualizar</button>
		  </div>
		 <script>
		 function enviar_editar_empresa(){
			if ($('#nombre_empresa_editar').val()!="" && $('#tipo_importancia_editar').val()!="" ){
				$('#editar_empresa').load('sys_evento.php',{id:<?php echo $_POST['id']; ?>,'nombre':$('#nombre_empresa_editar').val(),'correo':$('#correo_editar').val(),'ruc':$('#ruc').val(),'url':$('#url').val(),'tipo_importancia':$('#tipo_importancia_editar').val(),'tipo_empresa':$('#tipo_empresa').val(), 'descripcion':$('#descripcion').val(), 'estatus':$('#estatus_empresa').val(),'usuario_empresa':$('#usuario_empresa').val(),'f':'1','a':'5'});
			}
		 }
		  
		 </script>
	</div>
	</form>
	<?php }
	cierradatabase();
}
//Actualiza los Datos de Empresas
if ($_POST['f']==1 && $_POST['a']==5){
	 // actualiza la tabla tbl_empresa (posible clientes)
	 $sql="UPDATE tbl_empresa SET tx_nombre='".$_POST['nombre']."', tx_ruc='".$_POST['ruc']."', tx_descripcion='".$_POST['descripcion']."', tx_correo='".$_POST['correo']."',id_tipo_empresa='".$_POST['tipo_empresa']."',id_importancia='".$_POST['tipo_importancia']."',tx_url='".$_POST['url']."', id_estatus=".$_POST['estatus']."  WHERE id_empresa=".$_POST['id'];
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
	
	 // actualiza la tabla tbl_usuario_empresa (posible clientes)
	$sql="UPDATE tbl_usuario_empresa SET id_usuario='".$_POST['usuario_empresa']."'  WHERE id_empresa=".$_POST['id'];
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
	
	$sql="SELECT tx_nombre, tx_url, tx_correo, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_empresa.id_estatus) AS estatus FROM tbl_empresa WHERE id_empresa=".$_POST['id'];
		$res=abredatabase(g_BaseDatos,$sql);
		$row=dregistro($res);
	
	echo	'<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="font-size:20px">'.$row['tx_nombre'].'</div>';
	echo 	'<div align="right"  class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="font-size:15px"> <span style="font-size:10px; color:#888">Editar</span><a href="#" > <i class="fa fa-edit" style="color:#888"></i></a></div>';
	echo 	'<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size:12px"> <i class="fa fa-envelope-o"></i>'.$row['tx_correo'].'</div>';	
	
	cierradatabase();
	echo "<script> $('#myModal_seguimiento').modal('hide');</script>";
}

//Editar datos de la oportunidad
if ($_POST['f']==2 && $_POST['a']==2){
	
	
	//Busca la oportunidad creada
	$sql="SELECT id_oportunidad,id_servicio, tx_detalle, id_condicion, tx_observacion, nu_valor_oportunidad, nu_confianza_valor, fe_creacion, to_char(fe_inicio,'DD/MM/YYYY') AS fe_inicio, to_char(fe_probable_cierre,'DD/MM/YYYY') as fe_probable_cierre, id_tipo_doc, id_status,id_tipo_moneda, id_useact, (SELECT tx_nombre_apellido FROM cfg_usuario WHERE id_usuario=tbl_oportunidad.id_usuario) AS usuario,id_usuario, (SELECT SUM(nu_avance) FROM tbl_seguimiento WHERE id_oportunidad=tbl_oportunidad.id_oportunidad AND id_status=59) AS nu_avance ,id_empresa, id_contacto, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_status) as estatus, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_condicion) as condicion, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_tipo_doc) as documento FROM tbl_oportunidad WHERE id_oportunidad=".$_POST['id'];
	$res=abredatabase(g_BaseDatos,$sql);
	$row=dregistro($res);
	if (dnumerofilas($res)>0){
?>
	<form  name="form_registro_oportunidad_editar" method="post" action="javascript:enviar_editar_oportunidad();" data-parsley-validate >
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div  class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label >Oportunidad:</label>
				<?php echo $row['documento']; ?>
				
				
			</div>
			<div align="right"  class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label >Condición:</label>
						<?php echo $row['condicion']; ?> 
						 <br> <label >Estatus:</label>
					<?php echo $row['estatus']; ?>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div  class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
				<label >Descripción:</label >
				<textarea id="detalle" class="form-control"><?php echo $row['tx_detalle']; ?></textarea>
			</div>
			<div  class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
				<label >Fecha Inicio *:</label>
				<input id="fecha_inicio_opor" class="date-picker form-control" required value="<?php echo $row['fe_inicio']; $fecha=$row['fe_inicio']; ?>" >
			</div>
		</div>
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<hr>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label >Servicio *:</label>
					<select class="form-control"  id="servicio_opor" required>
					
					<?php 
						 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM vie_servicio";
						 $res2=abredatabase(g_BaseDatos,$sql2);
						 while ($row2=dregistro($res2)){?>
						<option value="<?php echo $row2['id_tipo_objeto']; ?>" <?php if ($row2['id_tipo_objeto']==$row['id_servicio']){ echo 'Selected'; } ?>><?php echo $row2['tx_tipo']; ?></option>		
					<?php }
						cierradatabase();
					?>
					</select>	 
			
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label >Contacto Principal:</label>
						<select class="form-control"  id="contacto_opor" >
						<option value="0">Seleccione</option>
						<?php 
							 $sql2 = "SELECT id_contacto, tx_contacto, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_contacto.id_condicion) as tipo FROM tbl_contacto WHERE id_empresa=".$row['id_empresa']." ORDER BY tx_contacto";
							 $res2=abredatabase(g_BaseDatos,$sql2);
							 while ($row2=dregistro($res2)){?>
							<option value="<?php echo $row2['id_contacto']; ?>" <?php if ($row2['id_contacto']==$row['id_contacto']){ echo 'Selected'; } ?>> <?php echo $row2['tx_contacto']." (".$row2['tipo'].")"; ?></option>		
						<?php }
							cierradatabase();
						?>
						</select>	 
				
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label >Usuario Asignado *:</label>
						<select class="form-control"  id="usuario_opor" required>
						<option value="0">-- Seleccione --</option>
						
						<?php 
							 $sql2 = "SELECT id_usuario, tx_nombre_apellido FROM cfg_usuario ORDER BY tx_nombre_apellido";
							 $res2=abredatabase(g_BaseDatos,$sql2);
							 while ($row2=dregistro($res2)){?>
							 
							<option value="<?php echo $row2['id_usuario']; ?>" <?php if ($row2['id_usuario']==$row['id_usuario']){ echo 'Selected'; } ?>><?php echo $row2['tx_nombre_apellido']; ?></option>		
						<?php }
							cierradatabase();
						?>
						</select>	 
				
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <label >Valor Estimado *:</label>
                    
					<div class="input-group">
				<span class="input-group-addon">
					<select id="moneda" title="Tipo de Moneda">
						<?php 
						 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM cfg_tipo_objeto WHERE tx_objeto='tipo moneda' ORDER BY nu_predeterminado DESC, nu_orden ASC";
						 $res2=abredatabase(g_BaseDatos,$sql2);
						 while ($row2=dregistro($res2)){?>
						<option value="<?php echo $row2['id_tipo_objeto']; ?>" <?php if ($row2['id_tipo_objeto']==$row['id_tipo_moneda']){ echo 'Selected'; } ?> ><?php echo $row2['tx_tipo']; ?></option>		
					<?php }
						cierradatabase();
					?>
					</select>
				</span>
				<input type="number" id="valor_estimado" class="form-control"  value="<?php if ($row['nu_valor_oportunidad']==null){ echo "0"; }else{ echo $row['nu_valor_oportunidad'];} ?>" style="text-align:right">
			</div><!-- /input-group -->
            </div>
        
			<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px" title="Valor de Confianza de la Oportunidad">
                   
                    <input id="confianza" class="knob" data-width="103" data-height="103" data-angleOffset=30 data-linecap=round data-fgColor="#26B99A" value="<?php if ($row['nu_confianza_valor']==null) { echo '0'; } else { echo $row['nu_confianza_valor'];} ?>" >
			</div>
			
		</div>
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<hr>
		</div>
		
		<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  <button id="anular" type="button" class="btn btn-warning" data-dismiss="modal" style="width:90px">Anular</button> 
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary" >Actualizar</button>
		  </div>
		  </form>
		  <div id="edit_oportunidad"></div>
		 <script>
		  //Evento click anular oportunidad
			$('#anular').on('click',function(){
				$('#edit_oportunidad').load('sys_evento.php',{id:<?php echo $_POST['id']; ?>,'f':'2','a':'6'});
			});
		 
		  function enviar_editar_oportunidad(){
			   
				$('#edit_oportunidad').load('sys_evento.php',{id:<?php echo $_POST['id']; ?>,'servicio':$('#servicio_opor').val(),'valor_estimado':$('#valor_estimado').val(),'confianza':$('#confianza').val(), 'usuario':$('#usuario_opor').val(),'contacto':$('#contacto_opor').val(), 'moneda':$('#moneda').val(), 'detalle':$('#detalle').val(), 'fe_inicio':$('#fecha_inicio_opor').val(),'f':'2','a':'5'});
			
		  }
		 </script>
		  
	</div>
	
	<?php }
	
}

//Actualiza los Datos de la oportunidad
if ($_POST['f']==2 && $_POST['a']==5){
	   
	   $fecha=substr($_POST['fe_inicio'],6,4)."-".substr($_POST['fe_inicio'],3,2)."-".substr($_POST['fe_inicio'],0,2);
	   
	    
	   
	
	    echo  $sql="UPDATE tbl_oportunidad SET id_servicio='".$_POST['servicio']."',  nu_confianza_valor='".$_POST['confianza']."', nu_valor_oportunidad='".$_POST['valor_estimado']."' ,id_useact='".$_SESSION['id_usuario']."',id_usuario='".$_POST['usuario']."', id_contacto=".$_POST['contacto'].",  id_tipo_moneda=".$_POST['moneda'].", tx_detalle='".$_POST['detalle']."', fe_inicio='".$fecha."'   WHERE id_oportunidad=".$_POST['id'];
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
	
	
	//echo "<script> location.reload();</script>";
}

//Anular de los Datos de la oportunidad
if ($_POST['f']==2 && $_POST['a']==6){
	$sql="UPDATE tbl_oportunidad SET id_status=151 WHERE id_oportunidad=".$_POST['id'];
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
	echo "<script> location.reload();</script>";
}

//Registrar los Datos de la oportunidad
if ($_POST['f']==2 && $_POST['a']==1){ ?>
<form name="form_registro_oportunidad" method="post" action="javascript:registrar_oportunidad_nueva();" data-parsley-validate >
	<div class="row">
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
					<label >Tipo de Oportunidad *:</label>
						<select class="form-control"  id="tipo_opor" required="required">
						
						<?php 
							 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM cfg_tipo_objeto WHERE tx_objeto='tipo oportunidad' ORDER BY nu_predeterminado DESC, nu_orden ASC";
							 $res2=abredatabase(g_BaseDatos,$sql2);
							 while ($row2=dregistro($res2)){?>
							<option value="<?php echo $row2['id_tipo_objeto']; ?>" ><?php echo $row2['tx_tipo']; ?></option>		
						<?php }
							cierradatabase();
						?>
						</select>	 
			</div>
			
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label >Fecha de Inicio *:</label>
						<input id="fecha_inicio_op_new" class="date-picker form-control col-md-7 col-xs-12" required="required" >
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label >Descripción : </label >
			<textarea id="detalle" class="form-control"   ></textarea>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<hr>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label >Servicio *:</label>
					<select class="form-control"  id="servicio_opor_nuevo" >
					
					<?php 
						 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM vie_servicio";
						 $res2=abredatabase(g_BaseDatos,$sql2);
						 while ($row2=dregistro($res2)){?>
						<option value="<?php echo $row2['id_tipo_objeto']; ?>" ><?php echo $row2['tx_tipo']; ?></option>		
					<?php }
						cierradatabase();
					?>
					</select>	 
			
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label >Contacto Principal:</label>
						<select class="form-control"  id="contacto_opor" >
						 <option value=0>Seleccione</option>
						<?php 
							 $sql2 = "SELECT id_contacto, tx_contacto FROM tbl_contacto WHERE id_empresa=".$_POST['id']." ORDER BY tx_contacto";
							 $res2=abredatabase(g_BaseDatos,$sql2);
							 while ($row2=dregistro($res2)){?>
							<option value="<?php echo $row2['id_contacto']; ?>"> <?php echo $row2['tx_contacto']; ?></option>		
						<?php }
							cierradatabase();
						?>
						</select>	 
				
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label >Usuario Asignado *:</label>
						<select class="form-control"  id="usuario_opor" required="required">
						
						<?php 
							 $sql2 = "SELECT id_usuario, tx_nombre_apellido FROM cfg_usuario ORDER BY tx_nombre_apellido";
							 $res2=abredatabase(g_BaseDatos,$sql2);
							 while ($row2=dregistro($res2)){?>
							<option value="<?php echo $row2['id_usuario']; ?>" <?php if ($row2['id_usuario']==$_SESSION['id_usuario']){ echo 'Selected'; } ?>><?php echo $row2['tx_nombre_apellido']; ?></option>		
						<?php }
							cierradatabase();
						?>
						</select>	 
				
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <label >Valor Estimado *:</label>
                    
					<div class="input-group">
				<span class="input-group-addon">
					<select id="moneda" title="Tipo de Moneda">
						<?php 
						 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM cfg_tipo_objeto WHERE tx_objeto='tipo moneda' ORDER BY nu_predeterminado DESC, nu_orden ASC";
						 $res2=abredatabase(g_BaseDatos,$sql2);
						 while ($row2=dregistro($res2)){?>
						<option value="<?php echo $row2['id_tipo_objeto']; ?>" ><?php echo $row2['tx_tipo']; ?></option>		
					<?php }
						cierradatabase();
					?>
					</select>
				</span>
				<input type="number" id="valor_estimado" class="form-control"  value="0" style="text-align:right">
			</div><!-- /input-group -->
            </div>
        
			<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px" title="Valor de Confianza de la Oportunidad">
                   
                    <input id="confianza" class="knob" data-width="103" data-height="103" data-angleOffset=30 data-linecap=round data-fgColor="#26B99A" value="0" >
			</div>
			
			
		</div>
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<hr>
		</div>
		
		<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<input id="id_padre" type="hidden" value="<?php echo $_POST['id_padre']; ?>"		>
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary"  >Guardar</button>
			<div id="edit_oportunidad"></div>
		  </div>
		  </form>
		  <script>
		  function registrar_oportunidad_nueva(){
				
				$('#edicion_seguimiento').load('sys_evento.php',{id:<?php echo $_POST['id']; ?>,'fe_inicio':$('#fecha_inicio_op_new').val(),'tipo_opor':$('#tipo_opor').val(),'servicio':$('#servicio_opor_nuevo').val(),'valor_estimado':$('#valor_estimado').val(),'confianza':$('#confianza').val(), 'usuario':$('#usuario_opor').val(),'contacto':$('#contacto_opor').val(), 'moneda':$('#moneda').val(), 'detalle':$('#detalle').val(),'f':'2','a':'3','id_padre':$('#id_padre').val()});
			
		  }
		  </script>
		
<?php }

//Registra los Datos de la oportunidad
if ($_POST['f']==2 && $_POST['a']==3){
	  $fecha=substr($_POST['fe_inicio'],6,4)."-".substr($_POST['fe_inicio'],3,2)."-".substr($_POST['fe_inicio'],0,2);
	
	$sql="SELECT COUNT(id_contacto) FROM tbl_contacto WHERE id_empresa=".$_POST['id'];
	$res=abredatabase(g_BaseDatos,$sql);
	if (dnumerofilas($res)>0){ $estatus=37; }else{
		$sql2="SELECT id_tipo_objeto FROM vie_status_oportunidad LIMIT 1";
		$res2=abredatabase(g_BaseDatos,$sql2);
		$row=dregistro($res2);
		$estatus=$row2['id_tipo_objeto'];
	}
	cierradatabase();
	
	$sql="SELECT id_tipo_objeto FROM vie_tipo_condicion_oportunidad LIMIT 1";
	$res=abredatabase(g_BaseDatos,$sql);
	$row=dregistro($res);
	$condicion=$row['id_tipo_objeto'];
	cierradatabase();
	
	
	 $sql="INSERT INTO tbl_oportunidad (id_servicio, id_tipo_serv, id_condicion, nu_confianza_valor, nu_valor_oportunidad, id_status, id_useact, id_empresa,  fe_inicio, fe_creacion, id_tipo_doc, id_contacto, id_tipo_moneda, tx_detalle, id_usuario,id_oport_padre)   VALUES('".$_POST['servicio']."','".$_POST['servicio']."','".$condicion."','".$_POST['confianza']."','".$_POST['valor_estimado']."','".$estatus."' ,'".$_SESSION['id_usuario']."','".$_POST['id']."','".$fecha."', '".$fecha."', '".$_POST['tipo_opor']."','".$_POST['contacto']."', '".$_POST['moneda']."', '".$_POST['detalle']."', '".$_POST['usuario']."','".$_POST['id_padre']."')"  ;
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
	
	?>
	<div class="row">
		<div align="center" class="col-lg-12" style="font-size:180px; color:green">
			<i class="fa fa-check-circle-o"></i>
		</div>
		<div align="center" class="col-lg-12" style="font-size:20px">
			REGISTRO DE OPORTUNIDAD EXITOSA!
		</div>
		
		<div align="center" class="col-lg-12" style="margin-top:20px; margin-bottom:30px; ">
			<button class="btn btn-success" onclick="javascript:location.reload();">Aceptar</button>
		</div>
	</div>
	
	
<?php	
}
//Cambia de Estatus una Tarea
if ($_POST['f']==3 && $_POST['a']==1){
	
	
	$sql="UPDATE tbl_seguimiento a SET id_status=(SELECT CASE WHEN id_status=58 then 59 else 58 END AS id_estatus FROM tbl_seguimiento b WHERE a.id_seguimiento=b.id_seguimiento) WHERE id_seguimiento=".$_POST['id'];
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
	
	
?>
<script>

  $('#edit_oportunidad_<?php echo $_POST['id_oportunidad']; ?>').load('mod_seguimiento_oportunidad.php',{'id':<?php echo $_POST['id_oportunidad']; ?>});

  $('#seguimiento_tareas').load('mod_seguimientos_tareas.php',{'id':<?php echo $_POST['id_oportunidad']; ?>});
</script>
	<?php } 


//Registrar Nueva Tarea
if ($_POST['f']==3 && $_POST['a']==3){
	
	$fecha_inicio=substr($_POST['fe_inicio'],6,4)."-".substr($_POST['fe_inicio'],3,2)."-".substr($_POST['fe_inicio'],0,2);
	
	  $fecha_cierre=substr($_POST['fe_cierre'],6,4)."-".substr($_POST['fe_cierre'],3,2)."-".substr($_POST['fe_cierre'],0,2);
	
	
	  $sql="INSERT INTO tbl_seguimiento (id_oportunidad, tx_descripcion, tx_observacion, fe_seguimiento, fe_plan, fe_cierre, id_tipo, id_status, id_useact, nu_avance, nu_dias)   VALUES('".$_POST['id']."','".$_POST['descripcion']."','".$_POST['observacion']."','".$fecha_inicio."','".$fecha_inicio."' ,'".$fecha_cierre."','".$_POST['tipo']."','".$_POST['estatus']."','".$_SESSION['id_usuario']."', '".$_POST['n_avance']."', '".$_POST['n_dias']."')"  ;
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
?>
	<script>
	
	$('#myModal_agregar_tarea').modal('hide');
	 $('#seguimiento_tareas').load('mod_seguimientos_tareas.php',{'id':<?php echo $_POST['id']; ?>});
	</script>
<?php } 


//Registrar Nueva nota
if ($_POST['f']==4 && $_POST['a']==1){
	
	
	  $sql="INSERT INTO tbl_eventos (id_oportunidad, tx_evento, id_useact, id_tipo_evento)   VALUES('".$_POST['id']."','".$_POST['descripcion']."','".$_SESSION['id_usuario']."','145')"  ;
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
?>
<script>


  $('#registro_eventos').load('sys_evento.php',{'id':<?php echo $_POST['id']; ?>,'f':'4','a':'2'});

  $('#myModal_nota_oportunidad').modal('hide');


</script>

<?php } 


//Registrar Nueva nota
if ($_POST['f']==4 && $_POST['a']==2){
	

				

				$sql2="SELECT id_evento, tx_evento, id_tipo_evento, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_eventos.id_tipo_evento) as tipo_evento, (SELECT tx_nombre_apellido FROM cfg_usuario WHERE id_usuario=tbl_eventos.id_useact) 	AS usuario, (SELECT tx_foto_usuario FROM cfg_usuario WHERE id_usuario=tbl_eventos.id_useact) 	AS foto_usuario, fe_actuali FROM tbl_eventos WHERE  id_oportunidad=".$_POST['id']." ORDER BY fe_actuali DESC";
				$res2=abredatabase(g_BaseDatos,$sql2);
				while ($row2=dregistro($res2)){
					$foto=$row2['foto_usuario'];
				if ($foto==""){
					$foto="../img/fotos/img.jpg";	
				}else{
					$foto="repositorio/fotos_usuario/".$foto;
				}
				if ($row2['id_tipo_evento']==145){ 
					$icono='<i class="fa fa-comment" style="font-size:18px"></i>';
					$tipo="Nota:";
				}
				if ($row2['id_tipo_evento']==146){ 
					$icono='<i class="fa fa-envelope-o" style="font-size:18px"></i>';
					$tipo="EMail:";
				}
				if ($row2['id_tipo_evento']==147){ 
					$icono='<i class="fa fa-phone" style="font-size:18px"></i>';
					$tipo="Llamada:";
				}
				?>
				  <div class="list-group-item" style="font-size:12px" >
					<div class="row">
					  
						<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
							
								<?php echo $icono;?> 
							
						</div>
						<?php 
						date_default_timezone_set($_SESSION['zona_horario']);
						$datetime1 = new DateTime("now");
						$datetime2 = new DateTime($row2['fe_actuali']);
						$interval = date_diff($datetime2, $datetime1);
						$dia=$interval->format('%R%a días');
						$hora=$interval->format('%H');
						$min=$interval->format('%I');
												
												
						
					  ?>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<label><?php echo $tipo;?> </label>
							<?php echo $row2['tx_evento'];?><br> <span style="font-size:10px">Creada por: <?php echo $row2['usuario']; ?> | <?php echo "<i class='fa fa-calendar'></i> hace "; if ($dia!=0){ echo $dia; } elseif ($hora!=0){ echo $hora.' Hora'; } elseif ($min!=0){ echo $min.' Min'; } ?> </span>
						</div>
						<div align="center" class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
							 <img class="user-perfil" src="<?php echo $foto; ?>" title="<?php echo $row2['usuario']; ?>"> 
							 <a href="javascript:eliminar_nota(<?php echo $row2['id_evento']; ?>);" style="margin-top:5px">Eliminar</a>
					   </div>
					   </div>
					   
					   </div>
				<?php } 
	cierradatabase();

}
//Registrar Nueva llamada
if ($_POST['f']==4 && $_POST['a']==3){
	
	
	  $sql="INSERT INTO tbl_eventos (id_oportunidad, tx_evento, id_useact, id_tipo_evento)   VALUES('".$_POST['id']."','".$_POST['descripcion']."','".$_SESSION['id_usuario']."','147')"  ;
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
?>
<script>


  $('#registro_eventos').load('sys_evento.php',{'id':<?php echo $_POST['id']; ?>,'f':'4','a':'2'});

  $('#myModal_llamada_oportunidad').modal('hide');


</script>

<?php } 

//Registrar Nuevo email
if ($_POST['f']==4 && $_POST['a']==4){
	
	  
	  $sql="INSERT INTO tbl_eventos (id_oportunidad, tx_evento, id_useact, id_tipo_evento)   VALUES('".$_POST['id']."','".$_POST['descripcion']."','".$_SESSION['id_usuario']."','146')"  ;
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
?>
<script>

  
   
  $('#registro_eventos').load('sys_evento.php',{'id':<?php echo $_POST['id']; ?>,'f':'4','a':'2'});

  $('#myModal_mail_oportunidad').modal('hide');


</script>

<?php } 

//Eliminar Evento
if ($_POST['f']==4 && $_POST['a']==5){
	
	  
	  $sql="DELETE FROM tbl_eventos WHERE id_evento=".$_POST['evento'];
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
?>
<script>

  
   
  $('#registro_eventos').load('sys_evento.php',{'id':<?php echo $_POST['id']; ?>,'f':'4','a':'2'});

  $('#myModal_mail_oportunidad').modal('hide');


</script>

<?php } 
//Cierre de Oportunidad
if ($_POST['f']==3 && $_POST['a']==5){
	//actualiza la actividad
	$sql="UPDATE tbl_seguimiento a SET id_status=(SELECT CASE WHEN id_status=58 then 59 else 58 END AS id_estatus FROM tbl_seguimiento b WHERE a.id_seguimiento=b.id_seguimiento) WHERE id_seguimiento=".$_POST['id'];
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
	//actualiza la condicion de la oportunidad
	if ($_POST['tipo_condicion']==1){ $condicion=47; } else{ $condicion=48; }
	$sql="UPDATE tbl_oportunidad a SET id_condicion=".$condicion.", id_status=137, tx_observacion='".$_POST['observacion']."' WHERE id_oportunidad=".$_POST['id_oportunidad'];
	$res=abredatabase(g_BaseDatos,$sql);
	cierradatabase();
?>
	<div align="center" class="row">
		<?php if ($_POST['tipo_condicion']==1){ ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px" >
			<i class="fa fa-check-circle-o" style="font-size:258px; color:#5CB85C" ></i><br>
			Oportunidad esta Cerrada como Ganada
			
		</div>
		
		<?php } else{ ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px" >
			<i class="fa fa-ban" style="font-size:258px; color:#D9534F" ></i>
			<br>
			Oportunidad esta Cerrada como Perdida
			
		</div>
		
		<?php }
		if ($_POST['id_tipo_doc']==49){?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<button type="submit" class="btn btn-success" data-dismiss="modal" onclick="javascript:seguimiento_cierre_definitivo(<?php echo $_POST['id_oportunidad']; ?>);" >Aceptar</button>
				</div>
		<?php }else{ ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<button type="submit" class="btn btn-success" data-dismiss="modal" onclick="javascript:seguimiento_cierre_definitivo(0);" >Aceptar</button>
				</div>

		<?php } ?>
	</div>
	
 
<?php } 
 
//editar actividad
if ($_POST['f']==5 && $_POST['a']==5){
 $sql="SELECT id_seguimiento, id_tarea_actividad, tx_descripcion, tx_observacion, fe_plan, fe_cierre, id_tipo, id_status, nu_avance, nu_dias FROM tbl_seguimiento WHERE id_seguimiento=".$_POST['id'];
 $res=abredatabase(g_BaseDatos,$sql);
 $row=dregistro($res);
 ?>
 <form name="form_modificar_tarea" method="post" action="javascript:modificar_tarea_evento(<?php echo $_POST['id']; ?>);" data-parsley-validate >
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<label >Tipo de Tarea *:</label>
								<select class="form-control"  id="tipo_tarea_modificar" required="required">
								<?php 
									 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM vie_tipo_seguimiento ORDER BY nu_predeterminado DESC";
									 $res2=abredatabase(g_BaseDatos,$sql2);
									 while ($row2=dregistro($res2)){?>
									<option value="<?php echo $row2['id_tipo_objeto']; ?>" <?php if($row2['id_tipo_objeto']==$row['id_tipo']){ echo 'selected=selected'; } ?> ><?php echo $row2['tx_tipo']; ?></option>		
								<?php }
									cierradatabase();
								?>
								</select>
							</div>
			
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<label >Estatus *:</label>
								<select class="form-control"  id="estatus_tarea_modificar" required="required">
									
									<?php 
										 $sql2 = "SELECT tx_tipo,id_tipo_objeto FROM vie_status_seguimiento ORDER BY nu_predeterminado DESC";
										 $res2=abredatabase(g_BaseDatos,$sql2);
										 while ($row2=dregistro($res2)){?>
										<option value="<?php echo $row2['id_tipo_objeto']; ?>"  <?php if($row2['id_tipo_objeto']==$row['id_status']){ echo 'selected=selected'; } ?>><?php echo $row2['tx_tipo']; ?></option>		
									<?php }
										cierradatabase();
									?>
								</select>
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<label >Fecha de Inicio *:</label>
										<input id="fecha_inicio_modificar" class="date-picker form-control col-md-7 col-xs-12" required="required" value="<?php echo $row['fe_plan']; ?>">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<label >Fecha de Cierre *:</label>
										<input id="fecha_cierre_modificar" class="date-picker form-control col-md-7 col-xs-12" required="required"  value="<?php echo $row['fe_cierre']; ?>">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<label >Avance % *:</label>
										<input id="n_avance_modificar" class="form-control col-md-7 col-xs-12" required="required"  value="<?php echo $row['nu_avance']; ?>">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<label >N° de Dias*:</label>
										<input id="n_dias_modificar" class="form-control col-md-7 col-xs-12" required="required"  value="<?php echo $row['nu_dias']; ?>">
							</div>
							
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
								<label >Descripción : </label >
								<textarea id="descripcion_modificar" class="form-control"   required="required" ><?php echo $row['tx_descripcion']; ?></textarea>
							</div>
							
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
								<label >Observación : </label >
								<textarea id="observacion_modificar" class="form-control"   ><?php echo $row['tx_observacion']; ?></textarea>
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
 <?php

} 
 
//actualizar la tarea
if ($_POST['f']==5 && $_POST['a']==6){
 $sql="UPDATE tbl_seguimiento SET  tx_descripcion='".$_POST['descripcion']."', tx_observacion='".$_POST['observacion']."', fe_plan='".$_POST['fe_inicio']."', fe_cierre='".$_POST['fe_cierre']."', id_tipo=".$_POST['tipo_tarea'].", id_status=".$_POST['estatus_tarea'].", nu_avance=".$_POST['n_avance'].", nu_dias=".$_POST['n_dias']."  WHERE id_seguimiento=".$_POST['id'];
 $res=abredatabase(g_BaseDatos,$sql);
 $row=dregistro($res);
 echo "Acualización con exito";
}
?>
 
		<script type="text/javascript">
			
			
		
		
			$(function() {
				$(".knob").knob();
			});
			
			  $('#fecha_inicio_opor').daterangepicker({
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
			  
			  $('#fecha_inicio_op_new').daterangepicker({
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
	<style>
				.daterangepicker{z-index:1600;}
			</style>
 <?php if (isset($fecha) && $fecha!="" ) {?>
	 
	 <script> $('#fecha_inicio').val('<?php echo $fecha; ?>'); </script>
 <?php } ?>
</body>
</html>