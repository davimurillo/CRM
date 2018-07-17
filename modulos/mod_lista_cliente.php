<?php 	require_once('common.php');	checkUser(); ?>

			
			
			<?php 
			// BUSCA DATOS DE LAS UNIDADES ORGANIZATIVA ------------------- //
				if (isset($_GET['buscar'])){
					 $SQL="SELECT id_empresa,  tx_nombre, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=vie_usuario_empresa.id_estatus) AS estatus,(SELECT tx_contacto FROM tbl_contacto WHERE id_empresa=vie_usuario_empresa.id_empresa LIMIT 1) AS contacto FROM vie_usuario_empresa WHERE  tx_nombre LIKE ('%".$_GET['buscar']."%')";
					if ($_SESSION['rol']==3 or $_SESSION['rol']==2 ){
						$SQL.=" AND id_usuario IN (select id_usuario FROM cfg_grupos_usuarios WHERE id_grupo IN (select id_grupo FROM cfg_grupos_usuarios WHERE id_usuario=".$_SESSION['id_usuario']." ))";
					}
					if ($_SESSION['rol']==1){
						$SQL.=" AND id_usuario=".$_SESSION['id_usuario'];
					}
					$RES=abredatabase(g_BaseDatos,$SQL);
					
			?>
			
			<table class="table table-hover">
			<thead>
			<tr>
				<th width="55%">Empresa</th>
				<th width="40%">Contacto</th>
				<th width="5%">Estatus</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			
			while($ROW=dregistro($RES)){ 
			
			?>
			<tr>
				<td><a href="mod_seguimiento.php?id=<?php echo $ROW['id_empresa']; ?>"><?php echo $ROW['tx_nombre']; ?></a></td>
				<td><?php echo $ROW['contacto']; ?></td>
				<td><?php echo $ROW['estatus']; ?></td>
				
			</tr>
			
			
					
			<?php } ?>
			</tbody>
					</table>	
				
			<?php
					
				}
			?>
		
	
</body>
</html>