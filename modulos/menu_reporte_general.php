<?php require_once('common.php'); checkUser(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache"> 
   <title>Menu Reporte</title>
   
    <!-- Libreria Ajax  -->
   <script language="JavaScript" type="text/javascript" src="<?php echo  g_dir; ?>lib/js/ajax.js"></script>

	<script>
		function modulos_funcion(valor)
		{
				
			FAjax('lista_reporte.php?id='+valor,'reportes','','GET');  
			return false;
		}
		function entes_funcion(valor)
		{
			FAjax('lista_ente.php?id='+valor,'entes','','GET');  
			return false;
		}
		
		function reporte_funcion()
		{
			
			window.open('reportes/'+document.getElementById('reporte').value+'?organizacion='+document.getElementById('organizacion').value+'&ente='+document.getElementById('ente').value+'&ano='+document.getElementById('ano').value+'&porcentaje=0'+'&n_proyectos='+document.getElementById('n_proyectos').value+'&n_acciones='+document.getElementById('n_acciones').value+'&metas='+document.getElementById('metas').value+'&distribucion='+document.getElementById('distribucion').value+'&mostrar_acciones='+document.getElementById('mostrar_acciones').value+'&total_proyectos='+document.getElementById('total_proyectos').value+'&ministerio='+document.getElementById('ministerio').value+'&plan='+document.getElementById('plan').value+'&meses='+document.getElementById('meses').value+'&cuenta='+document.getElementById('cuenta').value+'&trimestre='+document.getElementById('trimestre').value);
			return false;
		}
	</script>


<link href="../css/estilos.css" rel="stylesheet" type="text/css" />

</head>

<body  style=" font:normal 12px Trebuchet MS">
  
  		<div id="cabecera" ><div style="float:left; margin-right:10px"><img src="../img/botones/imprimir.png" /></div><div style="float:left; margin-top:5px">Reportes Impresos - Generales</div><div style="float:left; margin-left:10px; margin-top:10px"><img src="../img/botones/ayuda.png" title="Ayuda al Usuario" /></div></div>
      
	<div id="" style="float:left; height:35px; margin-bottom:10px; margin-left:10px; margin-top:10px ">
          <table width="1024" border="0">
            
            
            <tr>
              <td >Reporte</td>
              <td colspan="5"><div id="reportes">
                <select name="reporte" class="editor_field" id="reporte" >
                  <option value="0" class="input_tabla">-- Seleccione ---</option>
                  <?php 
							// Se Cargan los usuarios que envia la Campaña ---------------- //
							
							$select="SELECT * FROM reportes  ";
							if (isset($_GET['modulo'])){
								if ($_GET['modulo']!=8){
								$select.=" WHERE modulo=".$_GET['modulo'];}
							}
							$select.=" ORDER BY reporte";
							$sql = $select;
							$res=abredatabase(g_BaseDatos,$sql);
							while ($row=dregistro($res))
							{
							?>
                  <option value="<?php echo $row[2]; ?>" ><?php echo $row[1]; ?></option>
                  <?php 
							}
							cierradatabase();
							
							// Fin de la Carga de usuarios que envia la Campaña -------------- //
							?>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>Año Fiscal <span class="requerido">(*)</span> </td>
              <td colspan="5"><select name="ano" class="editor_field" id="ano">
                 
                  <?php 
							// Se Cargan los usuarios que envia la Campaña ---------------- //
							
							$select="SELECT id_ano,ano FROM cfg_anos ORDER BY ano DESC";
							$sql = $select;
							$res=abredatabase(g_BaseDatos,$sql);
							while ($row=$rs=dregistro($res))
							{
							?>
                  <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                  <?php 
							}
							cierradatabase();
							
							// Fin de la Carga de usuarios que envia la Campaña -------------- //
							?>
              </select></td>
            </tr>
            <tr>
              <td>Ministerio <span class="requerido">(*) </span></td>
              <td colspan="5"><select name="ministerio" class="editor_field" id="ministerio">
                <option value="0">-- AMBOS ---</option>
                <?php // Se Cargan los usuarios que envia la Campaña ---------------- //
							
							$select="SELECT * FROM ministerio";
							$sql = $select;
							$res=abredatabase(g_BaseDatos,$sql);
							while ($row=$rs=dregistro($res))
							{
							?>
                <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                <?php }
							cierradatabase();
							
							// Fin de la Carga de usuarios que envia la Campaña -------------- //
							?>
              </select></td>
            </tr>
            
            <tr>
              <td>Organización <span class="requerido">(*) </span></td>
              <td colspan="5"><label>
                <select name="organizacion" class="editor_field" id="organizacion" onchange="javascript:entes_funcion(this.value);">
                  <option value="0">-- Ambos ---</option>
                  
                  <?php 
							// Se Cargan los usuarios que envia la Campaña ---------------- //
							
							$select="SELECT * FROM organizacion";
							$sql = $select;
							$res=abredatabase(g_BaseDatos,$sql);
							while ($row=$rs=dregistro($res))
							{
							?>
							<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                  <?php 
							}
							cierradatabase();
							
							// Fin de la Carga de usuarios que envia la Campaña -------------- //
							?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td>Ente o Dirección </td>
              <td colspan="5"><div id="entes">
                  <select id="ente" name="ente" class="form-control"   onchange="javascript:abrir_unidad();" >
                 
                    <option value="0" >--- Seleccione ---</option>
                   
                    <?php 	
						$titulo="";
						$titulo2="";
					$select="SELECT (SELECT cod_onapre FROM cfg_licencia WHERE id_licencia=a.id_licencia) as codigo, (SELECT nombre FROM cfg_licencia WHERE id_licencia=a.id_licencia) as licencia, id_ente_direccion,cod_responsable,ente_direccion FROM cfg_estructura_organizativa a, cfg_usuario b WHERE a.id_licencia=b.id_licencia and b.id_usuario=".$_SESSION['id_usuario']." and id_ente_direccion =ANY(string_to_array(b.id_responsable,  ',')::int[]) ORDER BY cod_responsable,ente_direccion";
                        echo $sql = $select;
                        $res=abredatabase(g_BaseDatos,$sql);
                        while ($row=dregistro($res))
                        {	
							if ($titulo!=$row['licencia']){
									
									$titulo=$row['licencia'];
									echo "<optgroup label='".$row['codigo']." - ".$row['licencia']."'>";
//									
							}
							
							
							
							?>
            
                        <option value="<?php echo $row['id_ente_direccion']; ?>"  ><?php echo $row['cod_responsable']." - ".$row['ente_direccion']; ?></option>
                    <?php 	} cierradatabase();?>
                    </select> 
				  
				  
				 
              </div></td>
            </tr>
            <tr>
              <td>Tipo de Plan (MPPP) </td>
              <td colspan="5"><select name="plan" class="editor_field" id="plan">
                <option value="0">-- Seleccione ---</option>
                <?php // Se Cargan los usuarios que envia la Campaña ---------------- //
							
							$select="SELECT id_presupuesto,presupuesto FROM presupuesto";
							$sql = $select;
							$res=abredatabase(g_BaseDatos,$sql);
							while ($row=$rs=dregistro($res))
							{
							?>
                <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                <?php }
							cierradatabase();
							
							// Fin de la Carga de usuarios que envia la Campaña -------------- //
							?>
              </select></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" style="color:#900; font-weight:bold">Opciones</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td>Mostrar Acciones Específicas </td>
              <td width="40"><label>
                <input name="mostrar_acciones" type="checkbox" id="mostrar_acciones" value="1" checked="checked" />
              </label></td>
              <td width="192">Mostrar Numero de Acciones </td>
              <td width="220"><label>
                <input name="n_acciones" type="checkbox" id="n_acciones" value="1" checked="checked" />
              </label></td>
              <td width="120">Meses a Calcular</td>
              <td width="195"><select name="meses" class="editor_field" id="meses">
                <option value="0">-- Seleccione---</option>
				<option value="12">-- DOCE MESES ---</option>
                <option value="11">-- ONCE MESES ---</option>
                <option value="10">-- DIEZ MESES ---</option>
                <option value="9">-- NUEVE MESES ---</option>
                <option value="8">-- OCHO MESES ---</option>
                <option value="7">-- SIETE MESES ---</option>
                <option value="6">-- SEIS MESES ---</option>
                <option value="5">-- CINCO MESES ---</option>
                <option value="4">-- CUATRO MESES ---</option>
                <option value="3">-- TRES MESES ---</option>
                <option value="2">-- DOS MESES ---</option>
                <option value="1">-- UN MESES ---</option>
                
               
              </select></td>
            </tr>
            <tr>
              <td>Mostrar  Total de Proyecto por Plan </td>
              <td><label>
                <input name="total_proyectos" type="checkbox" id="total_proyectos" value="1" checked="checked" />
              </label></td>
              <td>Mostrar Trimestres de Metas </td>
              <td><input name="metas" type="checkbox" id="metas" value="1" checked="checked" /></td>
              <td>Partida</td>
              <td><label for="textfield"></label>
              <input type="text" name="textfield" id="cuenta" /></td>
            </tr>
            <tr>
              <td>Mostrar Numero de Proyectos </td>
              <td><label>
                <input name="n_proyectos" type="checkbox" id="n_proyectos" value="1" checked="checked" />
              </label></td>
              <td>Mostrar Distribución del Monto </td>
              <td><input name="distribucion" type="checkbox" id="distribucion" value="1" checked="checked" /></td>
              <td>Trimestres</td>
              <td><select name="TRIMESTRE" class="editor_field" id="trimestre">
                <option value="0">-- Seleccione---</option>
                <option value="1">-- 1ER TRIMESTRE ---</option>
                <option value="2">-- 2DO TRIMESTRE ---</option>
                <option value="3">-- 3ER TRIMESTRE ---</option>
                <option value="4">-- 4TO TRIMESTRE ---</option>
                
              </select></td>
            </tr>

            <tr>
              <td height="81" colspan="6"><label>
                  <div align="center">
                    <input id="botones" name="Button" type="button" class="grid_button" value="Vista Previa" onclick="javascript:reporte_funcion();" />
                  </div>
                </label></td>
            </tr>
        </table>
      </div>
	
</body>   
</html>



