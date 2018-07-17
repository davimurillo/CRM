<?php
require_once('common.php'); checkUser(); //chequeo de usuario entrante

  $sql2="SELECT id_oportunidad, fe_inicio, fe_probable_cierre, tx_documento, tx_status, nu_avance, (SELECT CASE WHEN nu_tiempo<nu_tiempo_avance THEN '<label style=\"color:#888\">A TIEMPO</label>' ELSE '<label style=\"color:#FF3300\">A DESTIEMPO</label>' END AS estatus_tiempo FROM vie_seguimiento_control_oportunidad WHERE id_oportunidad=vie_oportunidad.id_oportunidad ORDER BY nu_avance DESC LIMIT 1) AS estatus_tiempo, (SELECT nu_tiempo FROM vie_seguimiento_control_oportunidad WHERE id_oportunidad=vie_oportunidad.id_oportunidad ORDER BY nu_avance DESC LIMIT 1) AS nu_tiempo, (SELECT nu_tiempo_avance FROM vie_seguimiento_control_oportunidad WHERE id_oportunidad=vie_oportunidad.id_oportunidad ORDER BY nu_avance DESC LIMIT 1) AS nu_tiempo_avance, (SELECT tbl_contacto.id_contacto FROM tbl_contacto,tbl_oportunidad WHERE tbl_contacto.id_contacto=tbl_oportunidad.id_contacto and tbl_oportunidad.id_oportunidad=vie_oportunidad.id_oportunidad  ) as contacto, (SELECT (tbl_contacto.tx_contacto || ' (' || tx_cargo || ')') FROM tbl_contacto,tbl_oportunidad WHERE tbl_contacto.id_contacto=tbl_oportunidad.id_contacto and tbl_oportunidad.id_oportunidad=vie_oportunidad.id_oportunidad  ) as nombre_contacto,
  (SELECT (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_tipo_moneda)  FROM tbl_oportunidad WHERE tbl_oportunidad.id_oportunidad=vie_oportunidad.id_oportunidad  ) as moneda,
  (SELECT nu_valor_oportunidad FROM tbl_oportunidad WHERE tbl_oportunidad.id_oportunidad=vie_oportunidad.id_oportunidad  ) as valor_estimado,
  (SELECT TO_CHAR(fe_actuali,'DD/MM/YYYY') FROM tbl_oportunidad WHERE tbl_oportunidad.id_oportunidad=vie_oportunidad.id_oportunidad  ) as fecha_actualizacion,
  (SELECT tx_nombre_apellido FROM cfg_usuario,tbl_oportunidad WHERE cfg_usuario.id_usuario=tbl_oportunidad.id_usuario and tbl_oportunidad.id_oportunidad=vie_oportunidad.id_oportunidad  ) as usuario FROM vie_oportunidad WHERE id_oportunidad=".$_POST['id'];


$res2=abredatabase(g_BaseDatos,$sql2);
$row2=dregistro($res2);
$configuracion_n_oportunidad="000000";
$valor_oportunidad=$row2['id_oportunidad']; 
$tipo_oportunidad=$row2['tx_documento']; 
$contacto=0;

if ($row2['contacto']>0){ $contacto=1; }

?>
<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style="margin-top:10px" >		
<div class="panel panel-default" style="background-color:#fff;border-color:#ccc">
  <div class="panel-body">
    
	<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6' >	
		<i class="fa fa-cube" style="font-size:18px; color: #666666;"></i> 
		<label style="font-size:18px; color: #666666;" >
			<?php  echo "Oportunidad #"; if ($row2['tx_documento']=='Carta de Presentación'){ echo "CP-"; }else{ echo "CO-"; } echo substr($configuracion_n_oportunidad,1,strlen($configuracion_n_oportunidad)-strlen($valor_oportunidad)).$valor_oportunidad; ?> 
		</label>
		<br>
		<label style="font-size:16px; color: #666666; margin-top:-5px"> 
			<?php echo $row2['tx_documento']; ?>
		</label>
		
	</div>
	<div align="right" class='col-lg-6 col-md-6 col-sm-6 col-xs-6' style="font-size:20px; color: #666666; " >
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'  >
			<?php echo $row2['tx_status']; ?>
		</div>
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style="font-size:10px"  >
			Ultima Revisión: <?php echo $row2['fecha_actualizacion']; ?>
		</div>
		
	</div>
	<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style="margin-top:-15px" >
		<hr>
	</div>
	
<div class='col-lg-6 col-md-5 col-sm-12 col-xs-12' style=" font-size:12px; color:#888; margin-top:-10px" >
	<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' >
		Inicio: <?php echo $row2['fe_inicio']; ?>   
		<span style="margin-left:10px"> Cierre: <?php echo $row2['fe_probable_cierre']; ?> </span>
	</div>
	
	<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' >
		<label style="font-size:20px"><?php echo $row2['estatus_tiempo']; ?> </label> 
	</div>
	
	<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style=" font-size:12px; color:#888; margin-top:-10px" >
		Contacto: <?php echo $row2['nombre_contacto']; ?> 
	</div>
	<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style=" font-size:12px; color:#888" >
		Asignado: <?php echo $row2['usuario']; ?>  
	</div>
	
	<!--(  <label><?php   if ($row2['nu_tiempo_avance']!=0) { echo number_format(($row2['nu_tiempo']/$row2['nu_tiempo_avance']),2)." DESVIO"; }else { echo "Sin Avance"; }?> </label> ) -->
	
</div>
<div align="center" class='col-lg-6 col-md-7 col-sm-12 col-xs-12' style=" margin-top:-14px; color:#888" >
	<div align="right" class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style="font-size:20px" >
		VALOR ESTIMADO
	</div>
	<div align="right" class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style="font-size:20px" >
		<?php echo $row2['moneda']." ".number_format($row2['valor_estimado'],2,'.',','); ?>
	</div>
	<div align="right" class='col-lg-12 col-md-12 col-sm-12 col-xs-12' >
		<div class="progress" style="width:45%; text-align:center; font-size:10px; color:#ccc; ">
            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $row2['nu_avance']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row2['nu_avance']; ?>%; color:#6666">
                <span ><?php echo $row2['nu_avance']; ?>% Completado</span>
            </div>
			<label style="margin-top:3px; color:#999">% de Avance</label>
        </div>
	</div>

</div>	

  </div>
</div>
</div>
<?php cierradatabase(); 

 
				$c=0;
				$actividad=0;
				$d=0;
				$sql2="
				SELECT id_seguimiento, tx_descripcion,id_status, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_seguimiento.id_status) AS id_estatus_valor, nu_dias, nu_avance,  to_char(fe_cierre,'DD/MM/YYYY') AS fe_cierre_tarea, to_char(fe_plan,'DD/MM/YYYY') AS fe_plan, CASE WHEN (SELECT id_seguimiento FROM tbl_seguimiento WHERE id_status<>58 and id_oportunidad=".$_POST['id']." ORDER BY id_seguimiento DESC LIMIT 1)=id_seguimiento THEN 1 ELSE 0  END AS activa  FROM tbl_seguimiento WHERE  id_oportunidad=".$_POST['id']." ORDER BY fe_cierre ASC";
				$res2=abredatabase(g_BaseDatos,$sql2);
				$total_registros=dnumerofilas($res2);
?>

<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 animated fadeIn' >	
<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"  >	  
					<i class="fa fa-check-square-o"></i> 
					Tareas (<?php echo $total_registros; ?>)
				</div>
				<div align="right" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="font-size:22px; color:#fff" >
							<i id="agregar_tarea" class="fa fa-plus-square-o" title="Agregar Nueva Tarea" ></i> 
				</div>
			</div>
		</div>
		<div  class="panel-body">
				
			
<?php
				while ($row2=dregistro($res2)){
				?>
				  <div  class="list-group-item" style="font-size:12px"  >
					<div class="row">
					<div align="right" class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="font-size:24px">
					    
						<?php 
						$c+=1;
						if ($contacto!=0){
							if ($row2['id_status']==59 && $row2['activa']==0 && $d==0 && $c!=$total_registros){?>
								<i  class="fa fa-check-square" title="Tarea Completada" style="color: green" ></i>
							<?php $actividad=0; } 
						
						if ($row2['id_status']==59 && $row2['activa']==1 && $d==0 && $actividad=1 && $c!=$total_registros ){ 
						$actividad=0;  ?> 
						
							<i  class="fa fa-check-square" title="Marcar como Tarea Completada" style="color:<?php if ($row2['id_status']==58){echo 'orange'; }else{ echo 'green'; } ?>;" onclick="javascript:check_seguimiento(<?php echo $row2['id_seguimiento'].','.$_POST['id']; ?>);"></i>
						<?php }
						
						if ($row2['id_status']==58 && $row2['activa']==0 && $d==0 && $actividad==0 && $c!=$total_registros ){ 
						$actividad=1; $d=1; ?> 
						
							<i  class="fa fa-check-square" title="Marcar como Tarea Completada" style="color:<?php if ($row2['id_status']==58){echo 'orange'; }else{ echo 'green'; } ?>;" onclick="javascript:check_seguimiento(<?php echo $row2['id_seguimiento'].','.$_POST['id']; ?>);"></i>
						<?php }
						
						if ($c==$total_registros &&  $d==0 && $actividad==0){ ?>
							
							<i  class="fa fa-check-square" title="Marcar como Tarea Completada" style="color:orange;" onclick="javascript:check_seguimiento_cierre(<?php echo $row2['id_seguimiento'].','.$_POST['id']; ?>);"></i>
						<?php }
						if ($c==$total_registros &&  $d==1 && $actividad==1){ ?>
							
							<i  class="fa fa-check-square" title="Marcar como Tarea Completada" style="color:red;" ></i>
								
						<?php }
						} ?>
					</div>
					
						<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8" style="margin-top:7px; font-size:12px; <?php if ($row2['id_status']==59 ){  echo "text-decoration: line-through"; }?>" >
						
							<?php echo $row2['tx_descripcion'];?>
							
						</div>
						<div align="right" class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="margin-top:7px; font-size:20px" >
							<?php if($row2['id_status']==58){?><i class="fa fa-edit" onclick="javascript:editar_tarea(<?php echo $row2['id_seguimiento']; ?>);"></i>
							<?php } ?>
						</div>
					
					
					<div align="left" class="col-lg-1 col-md-1 col-sm-1 col-xs-1" >
					</div>
					<div align="left" class="col-lg-11 col-md-11 col-sm-11 col-xs-11" >
						<span style="font-size:10px">
							Inicio: <?php echo $row2['fe_plan'];?> 
							Cierre: <?php echo $row2['fe_cierre_tarea'];?> 
							(<?php echo $row2['nu_dias'];?> Días) 
						<span>
						
					</div>
					</div>
				  </div>
				  
<?php } ?>
</div>
</div>
</div>
<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12' >	
<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >	  
					<i class="fa fa-calendar"></i> 
					Eventos
				</div>
				<div align="right" class='col-lg-8 col-md-8 col-sm-8 col-xs-8' style="font-size:9px; margin-top:5px; margin-bottom:5px" >
					<div class="btn-group" role="group" aria-label="...">
						<button id="nota" class="btn btn-default btn-xs">
							<i class="fa fa-comment"></i> Note
						</button>
						<button id="mail_oport" class="btn btn-default btn-xs">
							<i class="fa fa-envelope-o"></i> Email
						</button>
						<button id="llamada" class="btn btn-default btn-xs">
						<i class="fa fa-phone"></i> Llamada 
						</button> 				
					</div>	
				</div>	
			</div>
		</div>
		<div id="registro_eventos"  class="panel-body">
				<?php 

				$sql2="SELECT id_evento, tx_evento, id_tipo_evento, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_eventos.id_tipo_evento) as tipo_evento, (SELECT tx_nombre_apellido FROM cfg_usuario WHERE id_usuario=tbl_eventos.id_useact) 	AS usuario, (SELECT tx_foto_usuario FROM cfg_usuario WHERE id_usuario=tbl_eventos.id_useact) 	AS foto_usuario, fe_actuali	FROM tbl_eventos WHERE  id_oportunidad=".$_POST['id']." ORDER BY fe_actuali DESC";
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
						<div align="center" class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="font-size:10px">
							 <img class="user-perfil" src="<?php echo $foto; ?>" title="<?php echo $row2['usuario']; ?>">  
							 <a href="javascript:eliminar_nota(<?php echo $row2['id_evento']; ?>);" style="margin-top:5px">Eliminar</a>
													 
					   </div>
					   
					   </div>
					   
					   </div>
				<?php } ?>
		
</div>
</div>


	
	<script>
	
	//editar tareas de la oportunidad
	function editar_tarea(id){
		
	  $('#myModal_modificar_tarea').modal('show');
	  $('#modificar_form_tarea').load('sys_evento.php',{'id':id,'f':'5','a':'5'})
	}
	
	//Registra los datos basico de la empresa
	$('#nota').on('click',function(){
		$('#nota_oportunidad').val('');
	  if (<?php echo $contacto; ?>==0){
		  alert('Debe crear un contacto y asociarlo a la oportunidad');
	  }else{
	  $('#myModal_nota_oportunidad').modal('show');
	  }
	});
	
	//Registra los datos basico de la empresa
	$('#mail_oport').on('click',function(){
	  $('#correos').val('');
	  $('#asunto_mail').val('');
	  $('#descripcion_mail').val('');
	   if (<?php echo $contacto; ?>==0){
		  alert('Debe crear un contacto y asociarlo a la oportunidad');
	  }else{
	  $('#myModal_mail_oportunidad').modal('show');
	  }
	});
	
	//Registra los datos basico de la empresa
	$('#llamada').on('click',function(){
		$('#llamada_oportunidad').val('');
	   if (<?php echo $contacto; ?>==0){
		  alert('Debe crear un contacto y asociarlo a la oportunidad');
	  }else{
	  $('#myModal_llamada_oportunidad').modal('show');
	  }
	});
	
	//Registra tareas
	$('#agregar_tarea').on('click',function(){
	   
	  $('#tipo_tarea').val('');
	  $('#estatus_tarea').val('');
	  $('#fecha_inicio').val('');
	  $('#fecha_cierre').val('');
	  $('#n_avance').val('');
	  $('#n_dias').val('');
	  $('#descripcion').val('');
	  $('#observacion').val('');
	  $('#registro_tarea').html('');
	  
	  
	  $('#myModal_agregar_tarea').modal('show');
	 
	});
	//Registra tareas
	function registra_tarea(){
			
			$('#registro_tarea').load('sys_evento.php',{id:<?php echo $_POST['id']; ?>,tipo:$('#tipo_tarea').val(),estatus:$('#estatus_tarea').val(),'fe_inicio':$('#fecha_inicio').val(), 'fe_cierre':$('#fecha_cierre').val(), n_avance:$('#n_avance').val(),n_dias:$('#n_dias').val(), descripcion:$('#descripcion').val(), observacion:$('#observacion').val(),'f':'3','a':'3'});
		}
	
	
	
	
	
	//Registra eventos
	$('#agregar_evento').on('click',function(){
	   
	  $('#myModal_agregar_evento').modal('show');
	});
	
	//Registra notas eventos para oportunidad
	function registro_nota(){
			
			$('#registro_nota').load('sys_evento.php',{id:<?php echo $_POST['id']; ?>,descripcion:$('#nota_oportunidad').val(),'f':'4','a':'1'});
		}
		
	//Eliminar notas eventos para oportunidad
	function eliminar_nota(id){
			
			$('#registro_nota').load('sys_evento.php',{'id':<?php echo $_POST['id']; ?>,evento:id,descripcion:$('#nota_oportunidad').val(),'f':'4','a':'5'});
		}
	
	//Registra llamadas eventos para oportunidad
	function registro_llamada(){
			
			$('#registro_nota').load('sys_evento.php',{id:<?php echo $_POST['id']; ?>,descripcion:$('#llamada_oportunidad').val(),'f':'4','a':'3'});
		}
		
	//Registra email eventos para oportunidad
	function registro_email(){
			
			$('#edit_mail_oportunidad').load('sys_evento.php',{id:<?php echo $_POST['id']; ?>,correo:$('#correos').val(), asunto:$('#asunto_mail').val(),descripcion:$('#descripcion_mail').val(),'f':'4','a':'4'});
			
			$('#edit_mail_oportunidad').load('correo.php',{sento:$('#correos').val(), asunto:$('#asunto_mail').val(),contenido:$('#descripcion_mail').val(),'tipo_correo':'6'});
			
		}
		
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
			  
			
			
           
     
		  
		  
	</script>