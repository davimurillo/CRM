<?php require_once('common.php'); checkUser(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="pragma" content="no-cache"> 
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">	
	
	<!-- Libreria CSS -->
     <link href="../lib/css/bootstrap.min.css" rel="stylesheet">
	 <link href="../lib/fonts/css/font-awesome.min.css" rel="stylesheet">
     <link href="../lib/css/animate.min.css" rel="stylesheet">
	
   
		
</head>
<body>
	<!-- CONTENIDO -->
	<div class="container-fluid">
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
				$sql="SELECT id_grupos_usuarios, (SELECT nombre_grupo FROM cfg_grupos WHERE id_grupo=a.id_grupo) AS grupo FROM cfg_grupos_usuarios a WHERE id_usuario=".$_GET['id'];
			##  *** set needed options
			  $debug_mode = false;
			  $messaging = true;
			  $unique_prefix = "f_";  
			  $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
			##  *** set data source with needed options
			  $default_order_field = "grupo";
			//  $default_order_field = "direccion,primer_apellido";
			  $default_order_type = "ASC";
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


			if ($_SESSION['rol']>=3){
			$modes = array(
			  "add"     =>array("view"=>1, "edit"=>0, "type"=>"image"),
			  "edit"    =>array("view"=>true, "edit"=>true, "type"=>"image"),
			  "cancel"  =>array("view"=>true, "edit"=>true, "type"=>"image"),
			  "details" =>array("view"=>false, "edit"=>false, "type"=>"image"),
			  "delete"  =>array("view"=>1, "edit"=>0, "type"=>"image")
			);
			}else{
				$modes = array(
			  "add"     =>array("view"=>0, "edit"=>0, "type"=>"image"),
			  "edit"    =>array("view"=>0, "edit"=>0, "type"=>"image"),
			  "cancel"  =>array("view"=>true, "edit"=>true, "type"=>"image"),
			  "details" =>array("view"=>false, "edit"=>false, "type"=>"image"),
			  "delete"  =>array("view"=>0, "edit"=>0, "type"=>"image")
			);
				
			}
			$dgrid->setModes($modes);

			$http_get_vars = array("id");
			$dgrid->SetHttpGetVars($http_get_vars);

			 $multirow_option = false;
			 $dgrid->allowMultirowOperations($multirow_option);
			 $multirow_operations = array(
				"delete"  => array("view"=>false),
				"details" => array("view"=>false),
				"edit" => array("view"=>true)
			 );
			 $dgrid->setMultirowOperations($multirow_operations); 

			//$http_get_vars = array("id","nodeidtree","padre","ano");
			//$dgrid->SetHttpGetVars($http_get_vars);

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

			$paging_option = false;
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
				"grupo"  =>array("header"=>"Grupo","header_align"=>"center","type"=>"label", "width"=>"100%", "align"=>"left",    "wrap"=>"wrap", "text_length"=>"-1", "case"=>"normal")				
			  );
			  
			  $dgrid->setColumnsInViewMode($vm_colimns);
			## +---------------------------------------------------------------------------+
			## | 7. Add/Edit/Details Mode settings:                                        | 
			## +---------------------------------------------------------------------------+
			##  ***  set settings for edit/details mode
			 
				 date_default_timezone_set('America/Caracas');
				$fecha=date('Y-m-d H:i:s');
	   
				//*****ARREGLO PARA CAMPO GRUPOS******//
				 $tema_array_sql = "SELECT nombre_grupo,id_grupo FROM cfg_grupos";
				$especial_array_str = crearArregloDataGrid($tema_array_sql,"grupos_array",g_BaseDatos);
				eval($especial_array_str);		
				//******FIN DE ARREGLO******///
				
						 
			  $table_name = "cfg_grupos_usuarios";
			  $primary_key = "id_grupos_usuarios";
			  $condition = "";
			  $dgrid->setTableEdit($table_name, $primary_key, $condition);
			  $dgrid->setAutoColumnsInEditMode(false);
			   $em_columns = array(
				
				"id_grupo" =>array("header"=>"Grupo", "type"=>"enum",  "source"=>$grupos_array, "view_type"=>"dropdownlist", "width"=>"210px", "req_type"=>"ry", "title"=>"Seleccione un grupo al cual quiera asociar al usuario", "unique"=>false),
				"fe_creacion" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$fecha, "visible"=>"false", "unique"=>false),
				"id_usuario" =>array("header"=>"",       "type"=>"hidden",    "req_type"=>"st", "default"=>$_GET['id'], "visible"=>"false", "unique"=>false)
														
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
			 

		?>
	</div>
	</div>
	
	
 <script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js" ></script>

<body>
<html>