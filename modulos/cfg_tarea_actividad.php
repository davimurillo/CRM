<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../lib/css/bootstrap.min.css" >
	<link href="../lib/fonts/css/font-awesome.min.css" rel="stylesheet">
	<script src="../lib/js/jquery.min.js"></script>
<script src="../lib/js/bootstrap.min.js" ></script>
</head>
<body>
<?php require_once('common.php'); checkUser(); ?>
<div class="col_lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px">
<label>Importancia </label>
<select id="importancia" class="form-control" onchange="javascript:location.href='cfg_tarea_actividad.php?importancia='+this.value+'&tipo_documento='+$('#tipo_documento').val();">
<option value="0">--Seleccione--</option>
<?php 
$valor="";
$sql="SELECT id_tipo_objeto, tx_tipo, CASE WHEN nu_predeterminado=TRUE THEN 'True' ELSE 'False' END AS nu_predeterminado FROM vie_tipo_importancia ORDER BY nu_predeterminado DESC";
$res=abredatabase(g_BaseDatos,$sql);
while ($row=dregistro($res)){
if (isset($_GET['importancia'])){
	if ($row['id_tipo_objeto']==$_GET['importancia']){
		$valor="selected";
	}else{
		$valor="";
	}
}
?>
<option value="<?php echo $row['id_tipo_objeto']; ?>" <?php echo $valor; ?>><?php echo $row['tx_tipo']; ?></option>
<?php } 
cierradatabase();
?>
</select>
 </div>
 
 <div class="col_lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px"> 
<label>Tipo de Documento </label>
<select id="tipo_documento" class="form-control" onchange="javascript:location.href='cfg_tarea_actividad.php?importancia='+$('#importancia').val()+'&tipo_documento='+this.value;">
<option value="0">--Seleccione--</option>
<?php 
$valor="";
$sql="SELECT id_tipo_objeto, tx_tipo, CASE WHEN nu_predeterminado=TRUE THEN 'Verdadero' ELSE 'Falso' END AS nu_predeterminado FROM vie_tipo_documento ORDER BY nu_predeterminado DESC";
$res=abredatabase(g_BaseDatos,$sql);
while ($row=dregistro($res)){
if (isset($_GET['tipo_documento'])){
	if ($row['id_tipo_objeto']==$_GET['tipo_documento']){
		$valor="selected";
	}else{
		$valor="";
	}
}
?>
<option value="<?php echo $row['id_tipo_objeto']; ?>" <?php echo $valor; ?>><?php echo $row['tx_tipo']; ?></option>
<?php } 
cierradatabase();
?>
</select>
 </div>
 
 <div class="col_lg-12 col-md-12 col-sm-12 col-xs-12">
	<hr>
</div>
 <div class="col_lg-12 col-md-12 col-sm-12 col-xs-12">
<?php
if (isset($_GET["importancia"])){
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

	$sql="SELECT id_tarea_actividad, tx_descripcion, nu_orden, nu_avance, nu_dias FROM cfg_tareas_actividades WHERE id_importancia=".$_GET['importancia']." and id_tipo_documento=".$_GET['tipo_documento'];

##  *** set needed options
  $debug_mode = false;
  $messaging = true;
  $unique_prefix = "f_";  
  $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
##  *** set data source with needed options
  $default_order_field = "id_tarea_actividad, nu_orden ";
  $default_order_type = "ASC, ASC";
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
  "delete"  =>array("view"=>1, "edit"=>0, "type"=>"image")
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

$http_get_vars = array("importancia","tipo_documento");
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
$pages_array = array("5"=>"5","10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000", "2000"=>"2000");
$default_page_size = 5;
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
 
  $filtering_fields = array( );
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
	
	"tx_descripcion"  =>array("header"=>"Tarea o Actividad","header_align"=>"center","type"=>"label", "width"=>"60%", "align"=>"left",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"nu_orden"  =>array("header"=>"Orden","header_align"=>"center","type"=>"label", "width"=>"10%", "align"=>"center",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"nu_avance"  =>array("header"=>"% de Avance","header_align"=>"center","type"=>"label", "width"=>"10%", "align"=>"right",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal", "summarize"=>true),
	"nu_dias"  =>array("header"=>"Nº de Días","header_align"=>"center","type"=>"label", "width"=>"20%", "align"=>"right",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal", "summarize"=>true)
	
  );
  
  $dgrid->setColumnsInViewMode($vm_colimns);
## +---------------------------------------------------------------------------+
## | 7. Add/Edit/Details Mode settings:                                        | 
## +---------------------------------------------------------------------------+
##  ***  set settings for edit/details mode
 

  $table_name = "cfg_tareas_actividades";
  $primary_key = "id_tarea_actividad";
  $condition = "";
  $dgrid->setTableEdit($table_name, $primary_key, $condition);
  $dgrid->setAutoColumnsInEditMode(false);
   $em_columns = array(
 	
	"tx_descripcion" =>array("header"=>"Descripción", "type"=>"textbox", "width"=>"100%", "req_type"=>"rty", "title"=>"", "unique"=>false),
	"nu_orden" =>array("header"=>"Nº de Orden", "type"=>"textbox", "width"=>"100%", "req_type"=>"rny", "title"=>"", "unique"=>false),
	"nu_avance" =>array("header"=>"Nº de Avance", "type"=>"textbox", "width"=>"100%", "req_type"=>"rny", "title"=>"", "unique"=>false),
	"nu_dias" =>array("header"=>"Nº de Día(s)", "type"=>"textbox", "width"=>"100%", "req_type"=>"rny", "title"=>"", "unique"=>false),
	"id_importancia" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_GET['importancia'], "visible"=>"false", "unique"=>false),
	"id_tipo_documento" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_GET['tipo_documento'], "visible"=>"false", "unique"=>false),
	"id_useact" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_SESSION['id_usuario'], "visible"=>"false", "unique"=>false)
	
												
												
  );
$dgrid->setColumnsInEditMode($em_columns);
  

  
##  *** set auto-genereted eName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
##  *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"

  
## +---------------------------------------------------------------------------+
## | 8. Bind the DataGrid:                                                     | 
## +---------------------------------------------------------------------------+
##  *** set debug mode & messaging options
	
	
    $dgrid->bind();        
    ob_end_flush();
 
}
?>
</div>
</body>
</html>






