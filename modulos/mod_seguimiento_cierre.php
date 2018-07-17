<link href="../lib/css/icheck/flat/blue.css" rel="stylesheet">
<?php require_once('common.php'); checkUser(); //chequeo de usuario entrante > 
	 $sql="SELECT id_tipo_doc, CASE WHEN (SELECT COUNT(id_cotizacion) FROM tbl_cotizacion WHERE id_oportunidad=tbl_oportunidad.id_oportunidad and id_status=138 GROUP BY id_cotizacion ORDER BY  id_cotizacion DESC LIMIT 1)>0 THEN 1 ELSE 0 END cotiza FROM tbl_oportunidad WHERE id_oportunidad=".$_POST['id_oportunidad'];
	$res=abredatabase(g_BaseDatos,$sql);
	$row=dregistro($res);
	$id_tipo_oportunidad=$row['id_tipo_doc'];
	$cotiza=$row['cotiza'];
	cierradatabase();
	if ($id_tipo_oportunidad==49){
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  "  >
		 Al Cerrar la oportunidad debe justificar el cierre, para ellos describa detenidamente en la observacion el porque cierra dicha oportunidad.
	</div>
	<form name="form_registro_empresa_editar" action="javascript:check_seguimiento_evento_cierre(<?php echo $_POST['id'].','.$_POST['id_oportunidad'].','.$id_tipo_oportunidad; ?>);" data-parsley-validate >
	<div  align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px" >
		
				
					<input type="radio" class="iradio_flat-blue" name="options_cierre" id="condicion_cierre" checked name="iCheck" autocomplete="off" value="1" > <label style="margin-top:10px; margin-right:10px">Ganada</label>
				

				<input type="radio" class="iradio_flat-blue" name="options_cierre" id="condicion_cierre" name="iCheck" autocomplete="off" value="0" > <label style="margin-top:10px">Perdida</label>
				
			
       
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px" >
		<label>Observación de Cierre de Oportunidad</label><br>
		<textarea class="form-control" id="observacion" width="100%"  required="required"></textarea>
	</div>
	<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px">
		
		 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary"  >Guardar</button>
	</div>
	</form>
</div>
	<?php } else { 
	if ($cotiza!=0){
	?>
	<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  "  >
		 Al Cerrar la oportunidad debe justificar el cierre, para ellos describa detenidamente en la observacion el porque cierra dicha oportunidad.
	</div>
	<form name="form_registro_empresa_editar" action="javascript:check_seguimiento_evento_cierre_cotizacion(<?php echo $_POST['id'].','.$_POST['id_oportunidad'].','.$id_tipo_oportunidad; ?>);" data-parsley-validate >
	<div  align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px" >
		
				
					<input type="radio" class="iradio_flat-blue" name="options_cierre" id="condicion_cierre" checked name="iCheck" autocomplete="off" value="1" > <label style="margin-top:10px; margin-right:10px">Ganada</label>
				

				<input type="radio" class="iradio_flat-blue" name="options_cierre" id="condicion_cierre" name="iCheck" autocomplete="off" value="0" > <label style="margin-top:10px">Perdida</label>
				
			
       
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px" >
		<label>Observación de Cierre de Oportunidad</label><br>
		<textarea class="form-control" id="observacion" width="100%"  required="required"></textarea>
	</div>
	<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px">
		
		 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-primary"  >Guardar</button>
	</div>
	</form>
</div>
	
	<?php }else{ ?>
	<div class="row" align="center">
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<i class="fa fa-exclamation-circle" style="font-size:258px; color:#F0AD4E" ></i> 
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  "  >
			 Para cerrar una Oportunidad debe tener al menos una cotización cargada para proceder a su cierre, vuelva a la pantalla de seguimiento y cargue una cotización
		</div>
		<div align="center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px">
			<button type="submit" class="btn btn-success" data-dismiss="modal"  >Aceptar</button>
		</div>
	</div>
	<?php }} ?>