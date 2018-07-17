<?php require_once('common.php'); checkUser(); //chequeo de usuario entrante > ?>

<?php 
		 
				$configuracion_n_oportunidad="000000";
				$sql2="SELECT id_oportunidad, tx_detalle, (SELECT SUM(nu_avance) FROM tbl_seguimiento WHERE id_oportunidad=tbl_oportunidad.id_oportunidad AND id_status=59) AS nu_avance, to_char(fe_probable_cierre,'DD/MM/YYYY') as fe_probable_cierre, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_status) AS id_status, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_tipo_doc) AS tipo_doc, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_tipo_moneda) AS moneda, (SELECT tx_nombre_apellido FROM cfg_usuario WHERE id_usuario=tbl_oportunidad.id_usuario) AS usuario, (SELECT tx_foto_usuario FROM cfg_usuario WHERE id_usuario=tbl_oportunidad.id_usuario) AS foto_usuario, nu_valor_oportunidad, nu_confianza_valor, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_oportunidad.id_condicion) AS id_condicion, (SELECT  (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_cotizacion.id_moneda)  FROM tbl_cotizacion WHERE id_oportunidad=tbl_oportunidad.id_oportunidad ORDER BY id_cotizacion DESC LIMIT 1) AS moneda_cotiza, (SELECT  nu_monto FROM tbl_cotizacion WHERE id_oportunidad=tbl_oportunidad.id_oportunidad ORDER BY id_cotizacion DESC LIMIT 1) AS monto_cotiza, (SELECT  nu_revision  FROM tbl_cotizacion WHERE id_oportunidad=tbl_oportunidad.id_oportunidad ORDER BY id_cotizacion DESC LIMIT 1) AS revision_cotiza FROM tbl_oportunidad WHERE id_oportunidad=".$_POST['id']." AND id_condicion=132 ORDER BY id_oportunidad ";
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
					
					<div class="row"  onclick="javascript:abrir_oportunidad(<?php echo $row2['id_oportunidad']; ?>);" style="margin-top=5px">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn-primary" style="font-size:14px;" >
					<i class="fa fa-cube" ></i> #<?php echo substr($configuracion_n_oportunidad,1,strlen($configuracion_n_oportunidad)-strlen($row2['id_oportunidad'])).$row2['id_oportunidad']; ?> 
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
										<div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $row2['nu_avance']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row2['nu_avance']; ?>%; color:#fff">
										<span ><?php if ($row2['nu_avance']==null) { echo '0';}else { echo $row2['nu_avance'];} ?> %</span>
										</div>
										<label style="margin-top:3px">% de Avance</label>
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
				    
				
				
				
		<?php
				} cierradatabase();
		  ?>