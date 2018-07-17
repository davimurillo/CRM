<?php
require_once('common.php'); checkUser(); //chequeo de usuario entrante
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../lib/css/bootstrap.min.css" >
	<link href="../lib/fonts/css/font-awesome.min.css" rel="stylesheet">

</head>
<body>

	<div class="container-fluid">
	<div class="col-lg-12 col-md-12 col-sd-12 col-xs-12">

		<?php

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
  $DB_HOST=g_ServidorBaseDatos;       
  $DB_NAME=g_BaseDatos;  
     

ob_start();
  $db_conn = DB::factory($DB_BASE); 
  $db_conn -> connect(DB::parseDSN($DB_BASE.'://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));


##  *** put a primary key on the first place 
	

	$sql="SELECT id_cotizacion, id_oportunidad, nu_revision, nu_monto, tx_observacion, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_cotizacion.id_status) AS id_status, ('<i class=\"fa fa-check-square-o\" style=\"font-size:18px\"></i>') as orden_compra, ('<i class=\"fa fa-file-text\" style=\"font-size:18px\"></i>') as archivo,tx_archivo, (SELECT tx_tipo FROM cfg_tipo_objeto WHERE id_tipo_objeto=tbl_cotizacion.id_moneda) as moneda FROM tbl_cotizacion WHERE id_oportunidad=".$_GET['id'];
##  *** set needed options
  $debug_mode = false;
  $messaging = true;
  $unique_prefix = "f_";  
  $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
##  *** set data source with needed options
  $default_order_field = "fe_actuali";
//  $default_order_field = "direccion,primer_apellido";
  $default_order_type = "DESC";
  $dgrid->dataSource($db_conn, $sql, $default_order_field, $default_order_type);	    

## +---------------------------------------------------------------------------+
## | 2. General Settings:                                                      | 
## +---------------------------------------------------------------------------+
##  *** set encoding and collation (default: utf8/utf8_unicode_ci)

$postback_method = "GET";
$dgrid->SetPostBackMethod($postback_method);

$dgrid->firstFieldFocusAllowed = "true";

 $dg_encoding = "utf8";
 $dg_collation = "utf8_unicode_ci";
 $dgrid->setEncoding($dg_encoding, $dg_collation);



$modes = array(
  "add"     =>array("view"=>1, "edit"=>0, "type"=>"image"),
  "edit"    =>array("view"=>true, "edit"=>true, "type"=>"image"),
  "cancel"  =>array("view"=>true, "edit"=>true, "type"=>"image"),
  "details" =>array("view"=>false, "edit"=>false, "type"=>"image"),
  "delete"  =>array("view"=>0, "edit"=>0, "type"=>"image")
);
$dgrid->setModes($modes);



 $multirow_option = false;
 $dgrid->allowMultirowOperations($multirow_option);
 $multirow_operations = array(
    "delete"  => array("view"=>false),
    "details" => array("view"=>false),
	"edit" => array("view"=>true)
 );
 $dgrid->setMultirowOperations($multirow_operations); 

$http_get_vars = array("id");
$dgrid->SetHttpGetVars($http_get_vars);

##  *** set interface language (default - English)
##  *** (en) - English     (de) - German     (se) Swedish     (hr) - Bosnian/Croatian
##  *** (hu) - Hungarian   (es) - Espanol    (ca) - Catala    (fr) - Francais
##  *** (nl) - Netherlands/"Vlaams"(Flemish) (it) - Italiano  (pl) - Polish
##  *** (ch) - Chinese     (sr) - Serbian
 $dg_language = "es";  
 $dgrid->setInterfaceLang($dg_language);

#
##  *** set layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized
#
  $layouts = array("view"=>"0", "edit"=>"1", "details"=>"1", "filter"=>"1");
#
  $dgrid->SetLayouts($layouts);
  
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
$pages_array = array("10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000", "2000"=>"2000");
$default_page_size = 10;
$paging_arrows = array("first"=>"|<<", "previous"=>"<<", "next"=>">>", "last"=>">>|");
$dgrid->setPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size);



##
## +---------------------------------------------------------------------------+
## | 5. Filter Settings:                                                       | 
## +---------------------------------------------------------------------------+
##  *** set filtering option: true or false(default)
 $filtering_option = false;
 $dgrid->allowFiltering($filtering_option);
##  *** set aditional filtering settings
 
  $filtering_fields = array( 
  "Nombre del Contacto"  =>array("table"=>"a", "field"=>"tx_contacto", "source"=>"self","operator"=>false, "default_operator"=>"%like%", "type"=>"textbox", "autocomplete"=>false,"case_sensitive"=>true,  "comparison_type"=>"string") );
  $dgrid->setFieldsFiltering($filtering_fields);
##
## 


## +---------------------------------------------------------------------------+
## | 6. View Mode Settings:                                                    | 
## +---------------------------------------------------------------------------+
##  *** set columns in view mode
   //$dgrid->setAutoColumnsInViewMode(true);  
  $vm_table_properties = array("width"=>"100%","sortable"=>false);
  $dgrid->SetViewModeTableProperties($vm_table_properties); 
		
 
 	$vm_colimns = array(
	"id_oportunidad"  =>array("header"=>"N° de Cotización","header_align"=>"center","type"=>"label", "width"=>"20%", "align"=>"left",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"nu_revision"  =>array("header"=>"N° de Revisión","header_align"=>"center","type"=>"label", "width"=>"25%", "align"=>"center",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"moneda"  =>array("header"=>"Moneda","header_align"=>"center","type"=>"label", "width"=>"10%", "align"=>"center",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"nu_monto"  =>array("header"=>"Monto","header_align"=>"center","type"=>"money", "decimal_places"=>"2", "dec_separator"=>"." ,
	"thousands_separator"=>",", "width"=>"35%", "align"=>"right",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"id_status"  =>array("header"=>"Estatus","header_align"=>"center","type"=>"label", "width"=>"5%", "align"=>"center",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"archivo"=>array("header"=>"Ver", "type"=>"link","align"=>"center", "width"=>"5%", "wrap"=>"wrap", "text_length"=>"-1", "tooltip"=>"true","tooltip_type"=>"floating", "case"=>"normal", "summarize"=>"false", "sort_type"=>"numeric", "sort_by"=>"","visible"=>"true", "on_js_event"=>"", "field_key"=>"tx_archivo", "field_data"=>"archivo", "rel"=>"", "title"=>"Ver Archivo adjunto a la cotización", "target"=>"_new", "href"=>"repositorio/importes/{0}")
  );
  
  $dgrid->setColumnsInViewMode($vm_colimns);
## +---------------------------------------------------------------------------+
## | 7. Add/Edit/Details Mode settings:                                        | 
## +---------------------------------------------------------------------------+
##  ***  set settings for edit/details mode
 $ultima_revision=1;
  if ($mode=="add" && $rid==-1){
 
  
  $sql2="SELECT nu_revision FROM tbl_cotizacion WHERE id_oportunidad=".$_GET['id']." ORDER BY nu_revision DESC LIMIT 1";
  $res2=abredatabase(g_BaseDatos,$sql2);
  $row2=dregistro($res2);
	  if (dnumerofilas($res2)>0){
		  $ultima_revision=$row2['nu_revision']+1; 
	  }
  }
  
  //*****ARREGLO PARA CAMPO ESTATUS******//
	 $tema_array_sql = "SELECT tx_tipo,id_tipo_objeto FROM cfg_tipo_objeto WHERE tx_objeto='tipo moneda' ORDER BY nu_predeterminado desc";
	$especial_array_str = crearArregloDataGrid2($tema_array_sql,"moneda_array",g_BaseDatos);
	eval($especial_array_str);		
	//******FIN DE ARREGLO******///

  $table_name = "tbl_cotizacion";
  $primary_key = "id_cotizacion";
  $condition = "";
  $em_columns=array();
  $dgrid->setTableEdit($table_name, $primary_key, $condition);
  $dgrid->setAutoColumnsInEditMode(false);
   if ($mode=="add" && $rid==-1){
   $em_columns = array(
 	
	"id_moneda" =>array("header"=>"Moneda", "type"=>"enum",  "source"=>$moneda_array, "view_type"=>"dropdownlist", "width"=>"210px", "req_type"=>"ry", "title"=>"Seleccione tipo de moneda", "unique"=>false),
	
	"nu_monto" =>array("header"=>"Monto", "type"=>"textbox", "width"=>"210px", "req_type"=>"rny", "title"=>"Coloque el Monto de la Cotización", "unique"=>false),
	
	

	"tx_observacion" =>array("header"=>"Observaciones", "type"=>"textarea", "width"=>"100%", "req_type"=>"sty",  "unique"=>false),
	"id_status" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>'138', "visible"=>"false", "unique"=>false),
	
	"tx_archivo" =>array("header"=>"Archivo Adjunto", "type"=>"file", "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/importes/", "max_file_size"=>"2M", "host"=>"local"),
	
	"nu_revision" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$ultima_revision, "visible"=>"false", "unique"=>false),
	
	"id_oportunidad" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_GET['id'], "visible"=>"false", "unique"=>false),
	
	"id_useact" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_SESSION['id_usuario'], "visible"=>"false", "unique"=>false)
											
  );
	}else{
   $em_columns = array(
   
   "id_moneda" =>array("header"=>"Moneda", "type"=>"enum",  "source"=>$moneda_array, "view_type"=>"dropdownlist", "width"=>"210px", "req_type"=>"ry", "title"=>"Seleccione tipo de moneda", "unique"=>false),
 	
	"nu_monto" =>array("header"=>"Monto", "type"=>"textbox", "width"=>"210px", "req_type"=>"rny", "title"=>"Coloque el Monto de la Cotización", "unique"=>false),
	
	

	"tx_observacion" =>array("header"=>"Observaciones", "type"=>"textarea", "width"=>"100%", "req_type"=>"sty",  "unique"=>false),
	"id_status" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>'138', "visible"=>"false", "unique"=>false),
	
	"tx_archivo" =>array("header"=>"Archivo Adjunto", "type"=>"file", "req_type"=>"rt", "width"=>"210px", "title"=>"", "readonly"=>"false", "maxlength"=>"-1", "default"=>"", "unique"=>"false", "unique_condition"=>"", "visible"=>"true", "on_js_event"=>"", "target_path"=>"repositorio/importes/", "max_file_size"=>"2M", "host"=>"local"),
	
	"id_oportunidad" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_GET['id'], "visible"=>"false", "unique"=>false),
	
	"id_useact" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_SESSION['id_usuario'], "visible"=>"false", "unique"=>false)
											
  );
	}
$dgrid->setColumnsInEditMode($em_columns);
  

  
##  *** set auto-genereted eName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"

  
## +---------------------------------------------------------------------------+
## | 8. Bind the DataGrid:                                                     | 
## +---------------------------------------------------------------------------+
##  *** set debug mode & messaging options
	
	
    $dgrid->bind();        
    ob_end_flush();
	
	if ($mode=="update" && $rid==-1){
		 $sql2="UPDATE tbl_cotizacion SET id_status=139 WHERE id_oportunidad=".$_GET['id']." and id_cotizacion<(SELECT id_cotizacion FROM tbl_cotizacion ORDER BY id_cotizacion DESC LIMIT 1 )";
		$res2=abredatabase(g_BaseDatos,$sql2);
		
		
		echo "<script> 
		parent.$('#edit_oportunidad_".$_GET['id']."').load('mod_seguimiento_oportunidad.php',{'id':".$_GET['id']."});
		</script>";
		
		echo "<script>location.href='mod_cotizacion.php?id=".$_GET['id']."';</script>";
	}

?>
	</div>
	</div>
	
	
	
	
 <script src="../lib/js/jquery.min.js"></script>
<script src="../lib/js/bootstrap.min.js" ></script>

 

<body>
<html>