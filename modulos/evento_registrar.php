<?php require_once('common.php'); checkUser(); 



// ************************************************************
// * Modulo de Configurar Licencia - Cambio Clave	          *
// ************************************************************
if ($_REQUEST['modulo']==3){
	$sql="SELECT id_usuario,tx_contrasena FROM cfg_usuario WHERE id_usuario=".$_REQUEST['id']." and tx_contrasena='".trim(md5($_REQUEST['pass']))."'";
	$res=abredatabase(g_BaseDatos,$sql);
	if (dnumerofilas($res)>0){
		$sql_cambio="UPDATE cfg_usuario SET tx_contrasena='".trim(md5($_REQUEST['nuevo_pass']))."' WHERE id_usuario=".$_REQUEST['id'];
		$res_cambio=abredatabase(g_BaseDatos,$sql_cambio);
		echo "Cambio de Clave Exitosa";
		sleep(2);
		echo "<script> cerrar_cambio_clave(); </script>";
	}else{
		Echo "Error Clave de usuario vuelva intentar";
	}
	
	
}


