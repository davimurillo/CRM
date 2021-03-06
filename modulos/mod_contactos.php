﻿<!DOCTYPE html>
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
	<?php if(isset($_REQUEST['f']) && $_REQUEST['f']==1 ) {  require_once('common.php'); checkUser(); echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="">';}else{?>
	<?php include('cfg_encabezado.php'); ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style=" width:100%; font-size:18px; color:#888;" >

			<a href="index.php">Inicio</a> | Contactos <img class="ayuda" src="../img/botones/ayuda.png" title="Ayuda al Usuario" style="margin-left:8px; margin-top:-2px" /> <i class="fa fa-print" style="font-size:14px" title="Imprimir Reportes" onclick="javascript:reportes();"></i>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px" >
	  <hr>
	</div>
	
	<div class="col_lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px"> 
		<label>Empresas </label>
		<select id="empresa" class="form-control" onchange="javascript:location.href='mod_contactos.php?empresa='+this.value;">
		<option value="0">--Seleccione--</option>
		<?php 
		$valor="";
		$sql="SELECT id_empresa, tx_nombre FROM vie_usuario_empresa WHERE id_usuario=".$_SESSION['id_usuario'];
		$res=abredatabase(g_BaseDatos,$sql);
		while ($row=dregistro($res)){
			if (isset($_GET['empresa'])){
			if ($row['id_empresa']==$_GET['empresa']){
				$valor="selected";
			}else{
				$valor="";
			}
		}
		?>
		<option value="<?php echo $row['id_empresa']; ?>" <?php echo $valor; ?>><?php echo $row['tx_nombre']; ?></option>
		<?php } 
		cierradatabase();
		?>
		</select>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:25px">
	<?php } ?>

		<?php
if (isset($_GET['empresa'])){ $empresa=$_GET['empresa']; 
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
	

	$sql="SELECT id_contacto, tx_contacto, tx_cargo, tx_correo_primario,   (SELECT tx_tipo FROM cfg_tipo_objeto	WHERE id_tipo_objeto=a.id_estatus) AS id_estatus, ('<i class=\"fa fa-phone\" style=\"font-size:16px\"></i>') as telefono  FROM tbl_contacto a WHERE id_empresa=".$empresa;
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

$http_get_vars = array("empresa", "f");
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
	"tx_contacto"  =>array("header"=>"Contacto","header_align"=>"center","type"=>"label", "width"=>"50%", "align"=>"left",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"tx_cargo"  =>array("header"=>"cargo","header_align"=>"center","type"=>"label", "width"=>"20%", "align"=>"left",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"tx_correo_primario"  =>array("header"=>"Email","header_align"=>"center","type"=>"label", "width"=>"10%", "align"=>"left",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"id_estatus"  =>array("header"=>"Estatus","header_align"=>"center","type"=>"label", "width"=>"10%", "align"=>"center",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal"),
	"telefono"=>array("header"=>"Teléfonos", "type"=>"link","align"=>"center", "width"=>"5%", "wrap"=>"wrap", "text_length"=>"-1", "tooltip"=>"true","tooltip_type"=>"floating", "case"=>"normal", "summarize"=>"false", "sort_type"=>"numeric", "sort_by"=>"","visible"=>"true", "on_js_event"=>"", "field_key"=>"id_contacto", "field_data"=>"telefono", "rel"=>"", "title"=>"Incluir Telefonos", "target"=>"", "href"=>"javascript:abrir_telefonos({0});")
  );
  
  $dgrid->setColumnsInViewMode($vm_colimns);
## +---------------------------------------------------------------------------+
## | 7. Add/Edit/Details Mode settings:                                        | 
## +---------------------------------------------------------------------------+
##  ***  set settings for edit/details mode
 
	//*****ARREGLO PARA CAMPO ESTATUS******//
	 $tema_array_sql = "SELECT tx_tipo,id_tipo_objeto FROM vie_tipo_condicion_contacto";
	$especial_array_str = crearArregloDataGrid2($tema_array_sql,"condicion_array",g_BaseDatos);
	eval($especial_array_str);		
	//******FIN DE ARREGLO******///
	

  $table_name = "tbl_contacto";
  $primary_key = "id_contacto";
  $condition = "";
  $dgrid->setTableEdit($table_name, $primary_key, $condition);
  $dgrid->setAutoColumnsInEditMode(false);
   $em_columns = array(
 	
	"tx_contacto" =>array("header"=>"Nombre del Contacto", "type"=>"textbox", "width"=>"100%", "req_type"=>"rty", "title"=>"Coloque el Nombre del Contacto", "unique"=>false),
	"tx_cargo" =>array("header"=>"Cargo", "type"=>"textbox", "width"=>"100%", "req_type"=>"rty", "title"=>"escriba el cargo del nombre del contacto", "unique"=>false),
	"tx_correo_primario" =>array("header"=>"Correo Primario", "type"=>"textbox", "width"=>"100%", "req_type"=>"rey", "title"=>"escriba la dirección de correo primario", "unique"=>false),
	"tx_correo_alternativo" =>array("header"=>"Correo Alternativo", "type"=>"textbox", "width"=>"100%", "req_type"=>"sey", "title"=>"escriba la dirección de correo Alternativo", "unique"=>false),
	"id_condicion" =>array("header"=>"Tipo de Contacto", "type"=>"enum",  "source"=>$condicion_array, "view_type"=>"dropdownlist", "width"=>"210px", "req_type"=>"ry", "title"=>"Seleccione tipo de contacto", "unique"=>false),
	"id_estatus" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>133, "visible"=>"false", "unique"=>false),
	"id_empresa" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_GET['empresa'], "visible"=>"false", "unique"=>false),
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
	if ($mode=="update" and $rid==-1){
		echo "<script> parent.location.reload();</script>";
	}
?>
	</div>
	</div>
	
	
	<!-- Ventana para incluir Telefonos -->
	<div class="modal fade" tabindex="-1" id="myModal_telefonos" role="dialog" style="color:#999">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title"><span class="fa fa-phone" style="margin-right:10px"></span>Teléfonos del Contacto</h2>
		  </div>
		  <div class="modal-body" >
		 
				<iframe id="telefonos_data" src="" height="250px" width="100%" allowtransparency="1" frameborder="0"></iframe>
			
		  </div>
		  <div class="modal-footer"  style="text-align:center">
				  
			
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	
 <script src="../lib/js/jquery.min.js"></script>
<script src="../lib/js/bootstrap.min.js" ></script>
<script>
		
		function abrir_telefonos(id) {
			$('#myModal_telefonos').modal('show');
			url="mod_contactos_telefonos.php?id="+id;
			$('#telefonos_data').attr('src',url);
		}
	</script>
<body>
<html>