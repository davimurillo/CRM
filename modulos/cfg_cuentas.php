<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>APICES|CRM ® </title>

	<link href="../img/logos/apices.png" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="../lib/css/bootstrap.min.css" >
	<link href="../lib/fonts/css/font-awesome.min.css" rel="stylesheet">
   </head>
 <body>
 <?php if (isset($_REQUEST['id'])==1){ include('cfg_encabezado.php'); ?>
 <div class="container-fluid">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style=" width:100%; font-size:18px; color:#888;" >

			<a href="index.php">Inicio</a> | Mi perfil <img class="ayuda" src="../img/botones/ayuda.png" title="Ayuda al Usuario" style="margin-left:8px; margin-top:-2px" /> </i>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px" >
	  <hr>
	</div>
	
 <?php }  ?>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
<?php require_once('common.php'); checkUser(); //chequeo de usuario entrante 

$mode = (isset($_GET['f_mode'])) ? $_GET['f_mode'] : ""; 
$rid = (isset($_GET['f_rid'])) ? $_GET['f_rid'] : ""; 

################################################################################   
## +---------------------------------------------------------------------------+
## | 1. Creating & Calling:                                                    | 
## +---------------------------------------------------------------------------+
##  *** only relative (virtual) path (to the current document)
  define ("DATAGRID_DIR", g_dir."lib/datagrid/");
  define ("PEAR_DIR", g_dir."lib/datagrid/pear/");
  
  require_once(DATAGRID_DIR.'datagrid.class.php');
  require_once(PEAR_DIR.'PEAR.php');
  require_once(PEAR_DIR.'DB.php');

##  *** creating variables that we need for database connection 
  $DB_BASE=g_TipoBaseDatos;
  $DB_USER=g_User;            
  $DB_PASS=g_Pass;      
  $DB_PORT=g_Port;     
  $DB_HOST=g_ServidorBaseDatos;       
  $DB_NAME=g_BaseDatos;  
     

ob_start();
  $db_conn = DB::factory($DB_BASE); 
  $db_conn -> connect(DB::parseDSN($DB_BASE.'://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.':'.$DB_PORT.'/'.$DB_NAME));


##  *** put a primary key on the first place 
  $sql=" SELECT "
   ."id_usuario, tx_documento,  "
   ."(tx_nombre_apellido) as nombre, tx_email, (SELECT tx_perfil FROM cfg_perfil WHERE id_perfil=a.id_perfil) as perfil, "
   ."CASE WHEN a.id_estatu=1 THEN 'Activo' WHEN a.id_estatu=0 THEN 'Inactivo' END AS estatus_usuario, ('<span class=\"fa fa-phone\"></span>') as contacto, ('<span class=\"fa fa-users\" style=\"font-size:18px\"></span>') as grupos, ('<span class=\"fa fa-lock\" style=\"font-size:18px\"></span>') as clave  "
   ." FROM cfg_usuario a WHERE 1=1";
	if (isset($_REQUEST['id'])==1){
		$sql.=" AND id_usuario=".$_SESSION['id_usuario'];
	}
	
   
##  *** set needed options
  $debug_mode = false;
  $messaging = true;
  $unique_prefix = "f_";  
  $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
##  *** set data source with needed options
  $default_order_field = "id_usuario";
//  $default_order_field = "direccion,primer_apellido";
  $default_order_type = "ASC";
  $dgrid->dataSource($db_conn, $sql, $default_order_field, $default_order_type);	    

## +---------------------------------------------------------------------------+
## | 2. General Settings:                                                      | 
## +---------------------------------------------------------------------------+
##  *** set encoding and collation (default: utf8/utf8_unicode_ci)
 $postback_method = "get";
$dgrid->SetPostBackMethod($postback_method);

$dgrid->firstFieldFocusAllowed = "true";

 $dg_encoding = "utf8";

 $dg_collation = "utf8_unicode_ci";

 $dgrid->setEncoding($dg_encoding, $dg_collation);


if ($_SESSION['rol']==3 or $_SESSION['rol']==2 or $_SESSION['rol']==4){
	if (isset($_REQUEST['id'])==1){
		$modes = array(
		  "add"     =>array("view"=>0, "edit"=>0, "type"=>"image"),
		  "edit"    =>array("view"=>true, "edit"=>true, "type"=>"image"),
		  "cancel"  =>array("view"=>true, "edit"=>true, "type"=>"image"),
		  "details" =>array("view"=>false, "edit"=>false, "type"=>"image"),
		  "delete"  =>array("view"=>0, "edit"=>0, "type"=>"image")
		);
	}else{
		$modes = array(
		  "add"     =>array("view"=>true, "edit"=>true, "type"=>"image"),
		  "edit"    =>array("view"=>true, "edit"=>true, "type"=>"image"),
		  "cancel"  =>array("view"=>true, "edit"=>true, "type"=>"image"),
		  "details" =>array("view"=>false, "edit"=>false, "type"=>"image"),
		  "delete"  =>array("view"=>true, "edit"=>false, "type"=>"image")
		);
	}
}else{
$modes = array(
  "add"     =>array("view"=>0, "edit"=>0, "type"=>"image"),
  "edit"    =>array("view"=>true, "edit"=>true, "type"=>"image"),
  "cancel"  =>array("view"=>true, "edit"=>true, "type"=>"image"),
  "details" =>array("view"=>false, "edit"=>false, "type"=>"image"),
  "delete"  =>array("view"=>0, "edit"=>false, "type"=>"image")
);	
}
$dgrid->setModes($modes);
if (isset($_REQUEST['id'])==1){
$http_get_vars = array("id");
$dgrid->SetHttpGetVars($http_get_vars);
}
if ($_SESSION['rol']==3 or $_SESSION['rol']==4){
	if (isset($_REQUEST['id'])==1){
		$multirow_option = false;
	}else{
		$multirow_option = true;
	}
	


$dgrid->allowMultirowOperations($multirow_option);
 

	$dgrid->AllowMultirowOperations($multirow_option);
	$multirow_operations = array(
	"delete"  => array("view"=>true),
	"details" => array("view"=>true),
	
	);   
$dgrid->setMultirowOperations($multirow_operations); 

}
##  *** set interface language (default - English)
##  *** (en) - English     (de) - German     (se) Swedish     (hr) - Bosnian/Croatian
##  *** (hu) - Hungarian   (es) - Espanol    (ca) - Catala    (fr) - Francais
##  *** (nl) - Netherlands/"Vlaams"(Flemish) (it) - Italiano  (pl) - Polish
##  *** (ch) - Chinese     (sr) - Serbian
 $dg_language = "es";  
 $dgrid->setInterfaceLang($dg_language);

 $css_class = "x-blue";
 if($css_class == "") $css_class = "default"; 
## "embedded" - use embedded classes, "file" - link external css file
 $css_type = "embedded"; 
 $dgrid->setCssClass($css_class, $css_type);
## +---------------------------------------------------------------------------+
## | 3. Printing & Exporting Settings:                                         | 
## +---------------------------------------------------------------------------+
##  *** set printing option: true(default) or false 
 $printing_option = false;
 $dgrid->allowPrinting($printing_option);
##  *** set exporting option: true(default) or false 
 $exporting_option = false;
 $dgrid->allowExporting($exporting_option);
##




##
    ## +---------------------------------------------------------------------------+
    ## | 4. Sorting & Paging Settings:                                             | 
    ## +---------------------------------------------------------------------------+
    ##  *** set sorting option: true(default) or false 


$paging_option = true;
$rows_numeration = false;
$numeration_sign = "N #";
$dgrid->allowPaging($paging_option, $rows_numeration, $numeration_sign);
$bottom_paging = array(
         "results"=>true, "results_align"=>"left", 
         "pages"=>true, "pages_align"=>"center", 
         "page_size"=>true, "page_size_align"=>"right");
$top_paging = array(
         "results"=>true, "results_align"=>"left",
         "pages"=>true, "pages_align"=>"center",
         "page_size"=>true, "page_size_align"=>"right");
$pages_array = array("5"=>"5","10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250");
$default_page_size = 5;
$paging_arrows = array("first"=>"|<<", "previous"=>"<<", "next"=>">>", "last"=>">>|");
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size);

##
## +---------------------------------------------------------------------------+
## | 5. Filter Settings:                                                       | 
## +---------------------------------------------------------------------------+
##  *** set filtering option: true or false(default)
## +---------------------------------------------------------------------------+
## | 5.1. ARREGLOS :														   |
## +---------------------------------------------------------------------------+

	
	
	
	
	
	
##  *** set filtering option: true or false(default)
if ($_SESSION['rol']>=3){
	if (isset($_REQUEST['id'])==1){ 
		$filtering_option = false;
	}else{
		$filtering_option = true;
	}
 $dgrid->allowFiltering($filtering_option);
##  *** set aditional filtering settings
  $filtering_fields = array(
	"Nombres y Apellidos"     =>array("table"=>"a", "field"=>"nombres", "source"=>"self","operator"=>false, "default_operator"=>"%like%", "type"=>"textbox", "autocomplete"=>false,"case_sensitive"=>true,  "comparison_type"=>"string"),
	"Correo Usuario"     =>array("table"=>"a", "field"=>"tx_email", "source"=>"self","operator"=>true, "default_operator"=>"%like%", "type"=>"textbox", "autocomplete"=>true, "case_sensitive"=>false,  "comparison_type"=>"string")
  );
  $dgrid->setFieldsFiltering($filtering_fields); 
  }
##
## 


## +---------------------------------------------------------------------------+
## | 6. View Mode Settings:                                                    | 
## +---------------------------------------------------------------------------+
##  *** set columns in view mode
   //$dgrid->setAutoColumnsInViewMode(true);  
   
   
  
 $vm_colimns = array(

	//"id_usuario"  =>array("header"=>"ID", "header_align"=>"center",      "type"=>"label", "width"=>"10%", "align"=>"center",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"tx_documento"  =>array("header"=>"N° de Documento", "header_align"=>"center",      "type"=>"label", "width"=>"10%", "align"=>"center",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"nombre"  =>array("header"=>"Nombres y Apellidos",   "header_align"=>"center",   "type"=>"label", "width"=>"60%", "align"=>"left",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	//"tx_email"  =>array("header"=>"Correo",      "type"=>"label", "width"=>"20%", "align"=>"left",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"estatus_usuario"  =>array("header"=>"Estatus",  "header_align"=>"center",    "type"=>"label", "width"=>"10%", "align"=>"center",    "wrap"=>"nowrap", "text_length"=>"-1", "case"=>"normal"),
	"perfil"  =>array("header"=>"Perfil", "header_align"=>"center",     "type"=>"label", "width"=>"5%", "align"=>"left",    "wrap"=>"nowrap", "text_length"=>"-1", "case"=>"normal"),
	"contacto"=>array("header"=>"Teléfonos", "header_align"=>"center", "type"=>"link",       
							"align"=>"center", "width"=>"5%", "wrap"=>"wrap", "text_length"=>"-1", "tooltip"=>"true", 
							"tooltip_type"=>"floating", "case"=>"normal", "summarize"=>"false", "sort_type"=>"numeric", "sort_by"=>"", 
							"visible"=>"true", "on_js_event"=>"", "field_key"=>"id_usuario",  
							"field_data"=>"contacto", "rel"=>"", "title"=>"Incluir Teléfonos", "target"=>"", "href"=>"javascript:abrir_telefonos({0});"),
	"grupos"=>array("header"=>"Grupo", "header_align"=>"center", "type"=>"link",       
							"align"=>"center", "width"=>"5%", "wrap"=>"wrap", "text_length"=>"-1", "tooltip"=>"true", 
							"tooltip_type"=>"floating", "case"=>"normal", "summarize"=>"false", "sort_type"=>"numeric", "sort_by"=>"", 
							"visible"=>"true", "on_js_event"=>"", "field_key"=>"id_usuario",  
							"field_data"=>"grupos", "rel"=>"", "title"=>"Ver Grupos de Usuarios", "target"=>"", "href"=>"javascript:abrir_grupo({0});"),
				"clave"=>array("header"=>"Clave", "header_align"=>"center", "type"=>"link",       
							"align"=>"center", "width"=>"5%", "wrap"=>"wrap", "text_length"=>"-1", "tooltip"=>"true", 
							"tooltip_type"=>"floating", "case"=>"normal", "summarize"=>"false", "sort_type"=>"numeric", "sort_by"=>"", 
							"visible"=>"true", "on_js_event"=>"", "field_key"=>"id_usuario",  
							"field_data"=>"clave", "rel"=>"", "title"=>"Cambiar Clave de Usuarios", "target"=>"", "href"=>"javascript:cambio_clave({0});")
			 
  );
  $dgrid->setColumnsInViewMode($vm_colimns);
## +---------------------------------------------------------------------------+
## | 7. Add/Edit/Details Mode settings:                                        | 
## +---------------------------------------------------------------------------+
##  ***  set settings for edit/details mode
  
  
   	
	 //*****ARREGLO PARA CAMPO ROLES******//
	 if ($_SESSION['rol']==4){
		$tema_array_sql = "SELECT tx_perfil,id_perfil FROM cfg_perfil";
	 }else{
		 $tema_array_sql = "SELECT tx_perfil,id_perfil FROM cfg_perfil WHERE id_perfil<4";
	 }
	$especial_array_str = crearArregloDataGrid($tema_array_sql,"roles_array",g_BaseDatos);
	eval($especial_array_str);		
	//******FIN DE ARREGLO PARA ROLES******///	
	
	  
   
  $table_name = "cfg_usuario";
  $primary_key = "id_usuario";
  $condition = "";
  $dgrid->setTableEdit($table_name, $primary_key, $condition);
  $dgrid->setAutoColumnsInEditMode(false);
  if(isset($_GET['f_mode']) && $_GET['f_mode']=="add" && $_GET['f_rid']==-1){
	  if ($_SESSION['rol']==4 ){
	$em_columns = array(
	"tx_foto_usuario"  =>array("header"=>"Foto del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"128px", "image_height"=>"128px", "resize_image"=>"true", "resize_width"=>"128px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"", "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
   "tx_documento" =>array("header"=>"N° de Identificación", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"N° de Identificación", "unique"=>false),
    "tx_nombre_apellido" =>array("header"=>"Nombres y Apellidos", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"Nombre", "unique"=>false),
	"tx_email" =>array("header"=>"Correo Elétronico principal", "type"=>"textbox", "width"=>"210px", "req_type"=>"rey", "title"=>"Correo Elétronico", "unique"=>true),
	"tx_email_secundario" =>array("header"=>"Correo Elétronico secundario", "type"=>"textbox", "width"=>"210px", "req_type"=>"sey", "title"=>"Correo Elétronico", "unique"=>true),
	"id_perfil" =>array("header"=>"Perfil", "type"=>"enum",  "source"=>$roles_array, "view_type"=>"dropdownlist", "width"=>"210px", "req_type"=>"ry", "title"=>"Perfil de Usuario", "unique"=>false),
	"tx_firma_usuario"  =>array("header"=>"Firma del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"40%", "image_height"=>"40%", "resize_image"=>"false", "resize_width"=>"328px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"firma_".$_SESSION['id_usuario'], "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
	"tx_contrasena" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"rp", "default"=>"123456", "visible"=>"false", "unique"=>false, "cryptography"=>true,"cryptography_type"=>"md5"),
	
	"id_estatu" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>"1", "visible"=>"false", "unique"=>false),
	"id_useact" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_SESSION['id_usuario'], "visible"=>"false", "unique"=>false)
  );
  }
  if ($_SESSION['rol']==3 ){
	$em_columns = array(
	"tx_foto_usuario"  =>array("header"=>"Foto del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"128px", "image_height"=>"128px", "resize_image"=>"true", "resize_width"=>"128px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"", "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
   "tx_documento" =>array("header"=>"N° de Identificación", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"N° de Identificación", "unique"=>false),
    "tx_nombre_apellido" =>array("header"=>"Nombres y Apellidos", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"Nombre", "unique"=>false),
	"tx_email" =>array("header"=>"Correo Elétronico principal", "type"=>"textbox", "width"=>"210px", "req_type"=>"rey", "title"=>"Correo Elétronico", "unique"=>true),
	"tx_email_secundario" =>array("header"=>"Correo Elétronico secundario", "type"=>"textbox", "width"=>"210px", "req_type"=>"sey", "title"=>"Correo Elétronico", "unique"=>true),
	
	"id_perfil" =>array("header"=>"Perfil", "type"=>"enum",  "source"=>$roles_array, "view_type"=>"dropdownlist", "width"=>"210px", "req_type"=>"ry", "title"=>"Perfil de Usuario", "unique"=>false),
	"tx_firma_usuario"  =>array("header"=>"Firma del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"40%", "image_height"=>"40%", "resize_image"=>"false", "resize_width"=>"328px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"firma_".$_SESSION['id_usuario'], "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
	"tx_contrasena" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"rp", "default"=>"123456", "visible"=>"false", "unique"=>false, "cryptography"=>true,"cryptography_type"=>"md5"),
	
	"id_estatu" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>"1", "visible"=>"false", "unique"=>false),
	"id_useact" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_SESSION['id_usuario'], "visible"=>"false", "unique"=>false)
  );
  }
  
  }else{
  if ($_SESSION['rol']==4 ){
	$em_columns = array(
	"tx_foto_usuario"  =>array("header"=>"Foto del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"128px", "image_height"=>"128px", "resize_image"=>"true", "resize_width"=>"128px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"", "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
   "tx_documento" =>array("header"=>"N° de Identificación", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"N° de Identificación", "unique"=>false),
    "tx_nombre_apellido" =>array("header"=>"Nombres y Apellidos", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"Nombre", "unique"=>false),
	"tx_email" =>array("header"=>"Correo Elétronico principal", "type"=>"textbox", "width"=>"210px", "req_type"=>"rey", "title"=>"Correo Elétronico", "unique"=>true),
	"tx_email_secundario" =>array("header"=>"Correo Elétronico secundario", "type"=>"textbox", "width"=>"210px", "req_type"=>"sey", "title"=>"Correo Elétronico", "unique"=>true),
	"id_perfil" =>array("header"=>"Perfil", "type"=>"enum",  "source"=>$roles_array, "view_type"=>"dropdownlist", "width"=>"210px", "req_type"=>"ry", "title"=>"Perfil de Usuario", "unique"=>false),
	"tx_firma_usuario"  =>array("header"=>"Firma del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"40%", "image_height"=>"40%", "resize_image"=>"false", "resize_width"=>"328px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"firma_".$_SESSION['id_usuario'], "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
	"id_estatu" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>"1", "visible"=>"false", "unique"=>false),
	"id_useact" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_SESSION['id_usuario'], "visible"=>"false", "unique"=>false)
  );
  }
  if ($_SESSION['rol']==3 ){
	$em_columns = array(
	"tx_foto_usuario"  =>array("header"=>"Foto del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"128px", "image_height"=>"128px", "resize_image"=>"true", "resize_width"=>"128px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"", "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
   "tx_documento" =>array("header"=>"N° de Identificación", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"N° de Identificación", "unique"=>false),
    "tx_nombre_apellido" =>array("header"=>"Nombres y Apellidos", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"Nombre", "unique"=>false),
	"tx_email" =>array("header"=>"Correo Elétronico principal", "type"=>"textbox", "width"=>"210px", "req_type"=>"rey", "title"=>"Correo Elétronico", "unique"=>true),
	"tx_email_secundario" =>array("header"=>"Correo Elétronico secundario", "type"=>"textbox", "width"=>"210px", "req_type"=>"sey", "title"=>"Correo Elétronico", "unique"=>true),
	
	"id_perfil" =>array("header"=>"Perfil", "type"=>"enum",  "source"=>$roles_array, "view_type"=>"dropdownlist", "width"=>"210px", "req_type"=>"ry", "title"=>"Perfil de Usuario", "unique"=>false),
	"tx_firma_usuario"  =>array("header"=>"Firma del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"40%", "image_height"=>"40%", "resize_image"=>"false", "resize_width"=>"328px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"firma_".$_SESSION['id_usuario'], "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
	"id_estatu" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>"1", "visible"=>"false", "unique"=>false),
	"id_useact" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_SESSION['id_usuario'], "visible"=>"false", "unique"=>false)
  );
  }
   if ($_SESSION['rol']==1 or $_SESSION['rol']==2){
$em_columns = array(
	"tx_foto_usuario"  =>array("header"=>"Foto del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"128px", "image_height"=>"128px", "resize_image"=>"true", "resize_width"=>"128px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"", "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
   "tx_documento" =>array("header"=>"N° de Identificación", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"N° de Identificación", "unique"=>false),
    "tx_nombre_apellido" =>array("header"=>"Nombres y Apellidos", "type"=>"textbox", "width"=>"210px", "req_type"=>"ry", "title"=>"Nombre", "unique"=>false),
	"tx_email" =>array("header"=>"Correo Elétronico principal", "type"=>"textbox", "width"=>"210px", "req_type"=>"rey", "title"=>"Correo Elétronico", "unique"=>true),
	"tx_email_secundario" =>array("header"=>"Correo Elétronico secundario", "type"=>"textbox", "width"=>"210px", "req_type"=>"sey", "title"=>"Correo Elétronico", "unique"=>true),
	"tx_firma_usuario"  =>array("header"=>"Firma del Usuario", "type"=>"image",      "req_type"=>"st", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/fotos_usuario/", "allow_image_updating"=>"false", "max_file_size"=>"2M", "image_width"=>"40%", "image_height"=>"40%", "resize_image"=>"false", "resize_width"=>"328px", "resize_height"=>"128px", "magnify"=>"false", "magnify_type"=>"lightbox", "magnify_power"=>"2", "file_name"=>"firma_".$_SESSION['id_usuario'], "host"=>"local", "allow_downloading"=>"false", "allowed_extensions"=>""),
	"id_estatu" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>"1", "visible"=>"false", "unique"=>false),
	"id_useact" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_SESSION['id_usuario'], "visible"=>"false", "unique"=>false)
	
	
  );
   }
}
   

  $dgrid->setColumnsInEditMode($em_columns);
##  *** set auto-genereted eName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"

  
## +---------------------------------------------------------------------------+
## | 8. Bind the DataGrid:                                                     | 
## +---------------------------------------------------------------------------+
##  *** set debug mode & messaging options
	/*echo "<b>Usuario:</b>".$_SESSION['nombre']."<br>";
	echo "<b>Unidad:</b>".$_SESSION['unidad'];
	echo "<br>";*/
	//hide_grid_before_search = "true";
	
    $dgrid->bind();        
	//$dgrid->"autocomplete"=>"on";
    ob_end_flush();
 
	if (isset($_GET['f_mode']) && $_GET['f_mode']=='update' && $_GET['f_rid']==-1){
		$sql="UPDATE cfg_usuario SET tx_contrasena=md5('123456') WHERE tx_email='".$_POST['reytx_email']."'";
		$res=abredatabase(g_BaseDatos,$sql);
	}
 
 
	
?>
</div>
</div>

<!-- Ventana para incluir grupos -->
	<div class="modal fade" tabindex="-1" id="myModal_grupos" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-sitemap" style="margin-right:10px"></span>Grupos de Usuarios</h2>
		  </div>
		  <div class="modal-body" >
		 
				<iframe id="grupo_usuario" src="" height="250px" width="100%" allowtransparency="1" frameborder="0"></iframe>
			
		  </div>
		  <div class="modal-footer"  style="text-align:center">
				  
			
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana para incluir telefonos -->
	<div class="modal fade" tabindex="-1" id="myModal_telefonos" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-phone" style="margin-right:10px"></span>Telefonos de Usuarios</h2>
		  </div>
		  <div class="modal-body" >
		 
				<iframe id="telefonos_usuario" src="" height="250px" width="100%" allowtransparency="1" frameborder="0"></iframe>
			
		  </div>
		  <div class="modal-footer"  style="text-align:center">
				  
			
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Ventana para cambiar de clave-->
	<div class="modal fade" tabindex="-1" id="myModal_clave" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-lock" style="margin-right:10px"></span>Cambio de Clave</h2>
		  </div>
		  <div class="modal-body" >
			<div class="container-fluid">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px"> 
					Clave Actual
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<input type="hidden" id="usuario_clave" >
					<input type="password" id="clave_actual" class="form-control">
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px"> 
					Nueva Clave
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<input type="password" id="nueva_clave" class="form-control">
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px"> 
					Confirmar Clave
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<input type="password" id="confirmar_clave" class="form-control">
				</div>
			</div>
				
				
			
		  </div>
		  <div class="modal-footer"  style="text-align:center">
			<div class="row" id="cambio_clave_confirmar" > </div>
			<button type="button" class="btn btn-success btn-lg" id="nueva_cambio_clave">Enviar</button>	  
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<script src="../lib/js/jquery.min.js"></script>
<script src="../lib/js/bootstrap.min.js" ></script>
<script>
$('.ayuda').click(function() {
			alert("Este modulo tiene el propósito de registrar las cuentas de usuarios que serán usadas en el manejo del sistema, además permite configurar los accesos, permisos y perfiles que estos requieran. Para mayor información consulte el Manual de Usuario del Sistema");
		});
</script>

<script>
		function abrir_grupo(id) {
			$('#myModal_grupos').modal('show');
			url="cfg_grupos_usuarios.php?id="+id;
			$('#grupo_usuario').attr('src',url);
		}
		
		function abrir_telefonos(id) {
			$('#myModal_telefonos').modal('show');
			url="cfg_cuentas_telefonos.php?id="+id;
			$('#telefonos_usuario').attr('src',url);
		}
		
		function cambio_clave(id) {
			$('#myModal_clave').modal('show');
			url="cfg_grupos_usuarios.php?id="+id;
			$('#clave_acceso').attr('src',url);
			$('#usuario_clave').val(id);
			 $('#clave_actual').focus()
		}
		
		
	
		$('#nueva_cambio_clave').click(function() {
			$error="";
			if ($('#clave_actual').val()==""){$error+="Error olvido colocar la clave actual<br>";}
			if ($('#nueva_clave').val()==""){$error+="Error olvido colocar la Nueva clave<br>";}
			if ($('#confirmar_clave').val()==""){$error+="Error olvido colocar la confirmación de la clave<br>";}
			if ($('#nueva_clave').val()!=$('#confirmar_clave').val()){ $error+="Error la claves son diferentes vuelva a intentar <br>";}
			if ($error!=""){ $('#cambio_clave_confirmar').html($error);  }else{
					$('#cambio_clave_confirmar').load('evento_registrar.php',{'id':$('#usuario_clave').val(), 'pass':$('#clave_actual').val(),'nuevo_pass':$('#nueva_clave').val(), 'nuevo_pass':$('#confirmar_clave').val(), 'modulo':'3'});
			}
		});
		function cerrar_cambio_clave(){
			$('#myModal_clave').modal('hide');
		}
	</script>
</body>
</html>




