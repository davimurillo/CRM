<?php
//------------------------------------------------------------------------------             
//*** Arabic (ar)
//------------------------------------------------------------------------------
function setLanguage(){ 
    $lang['='] = "=";  // "equal"; 
    $lang['>'] = ">";  // "bigger"; 
    $lang['<'] = "<";  // "smaller";            
    $lang['add'] = "ЕЦЗЭЙ"; 
    $lang['add_new'] = "ЕЦЗЭЙ МПнПЙ +"; 
    $lang['add_new_record'] = "ЕЦЗЭЙ УМб МПнП";
    $lang['add_new_record_blocked'] = "Security check: attempt of adding a new record! Check your settings, the operation is not allowed!";
    $lang['adding_operation_completed'] = " !ЪгбнЙ ЗбЕЦЗЭЙ КгК ИдМЗН ";
    $lang['adding_operation_uncompleted'] = " !ЪгбнЙ ЗбЕЦЗЭЙ бг ККг ";
    $lang['alert_perform_operation'] = "Are you sure you want to carry out this operation?";
    $lang['alert_select_row'] = "You need to select one or more rows to carry out this operation!";
    $lang['and'] = "and";
    $lang['any'] = "any";                                                 
    $lang['ascending'] = "КСКнИ КХЗЪПн"; 
    $lang['back'] = "СМжЪ"; 
    $lang['cancel'] = "ЕбЫЗБ";
    $lang['cancel_creating_new_record'] = " еб ГдК гКГЯП гд ЕбЫЗБ ЪгбнЙ ЕдФЗБ УМб МПнПї ";
    $lang['check_all'] = "КНПнП Яб ЗбУМбЗК ";
    $lang['clear'] = "Clear";
    $lang['click_to_download'] = "Click to Download";
    $lang['clone_selected'] = "Clone selected";
    $lang['cloning_record_blocked'] = "Security check: attempt of cloning a record! Check your settings, the operation is not allowed!";
    $lang['cloning_operation_completed'] = "The cloning operation completed successfully!";
    $lang['cloning_operation_uncompleted'] = "The cloning operation uncompleted!";                                    
    $lang['create'] = "ЕдФЗБ"; 
    $lang['create_new_record'] = "ЕдФЗБ УМб МПнП "; 
    $lang['current'] = "ЗбНЗбн"; 
    $lang['delete'] = "гУН "; 
    $lang['delete_record'] = "гУН УМб ";
    $lang['delete_record_blocked'] = "Security check: attempt of deleting a record! Check your settings, the operation is not allowed!";
    $lang['delete_selected'] = "гУН ЗбУМбЗК ЗбгОКЗСЙ ";
    $lang['delete_selected_records'] = "еб ГдК гКГЯП гд ЕЯгЗб ЪгбнЙ гУН ЗбУМбЗК ЗбгОКЗСЙї ";
    $lang['delete_this_record'] = "еб ГдК гКГЯП гд ЕЯгЗб ЪгбнЙ гУН еРЗ ЗбУМб!"; 
    $lang['deleting_operation_completed'] = " !ЪгбнЙ ЗбгУН КгК ИдМЗН ";
    $lang['deleting_operation_uncompleted'] = " !ЪгбнЙ ЗбгУН бг КЯКгб ";                                    
    $lang['descending'] = "КСКнИ КдЗТбн";
    $lang['details'] = "КЭЗХнб ЗбУМб ";
    $lang['details_selected'] = "гФЗеПЙ ЗбУМбЗК ЗбгОКЗСЙ ";
    $lang['download'] = "Download";    
    $lang['edit'] = "КЪПнб ";
    $lang['edit_selected'] = "КЪПнб ЗбУМбЗК ЗбгОКЗСЙ ";
    $lang['edit_record'] = "КЪПнб ЗбУМб "; 
    $lang['edit_selected_records'] = "еб ГдК гКГЯП гд ЕЯгЗб ЪгбнЙ КЪПнб ЗбУМбЗК ЗбгОКЗСЙї ";         
    $lang['errors'] = "ОШГ "; 
    $lang['export_to_excel'] = "Excel КХПнС Ебн гбЭ  ";
    $lang['export_to_pdf'] = "PDF КХПнС Ебн гбЭ  ";
    $lang['export_to_xml'] = "XML КХПнС Ебн гбЭ ";
    $lang['export_message'] = "<label class='default_dg_label'>The file _FILE_ is ready. After you finish downloading,</label> <a class='default_dg_error_message' href='javascript: window.close();'>close this window</a>.";
    $lang['field'] = "ЕУг ЗбНЮб "; 
    $lang['field_value'] = "ЗбгНКжнЗК";
    $lang['file_find_error'] = "еРЗ ЗбгбЭ бЗнжМП  <b>_FILE_</b>. <br>ЗбСМЗБ ЗбКГЯП гд жМжП ЗбгбЭ жЗбгУЗС ";         
    $lang['file_opening_error'] = "бЗнгЯд ЭКН еРЗ ЗбгбЭ КГЯП гд ЗбХбЗНнЗК";
    $lang['file_extension_error'] = "File upload error: file extension not allowed for upload. Please select another file.";
    $lang['file_writing_error'] = "бЗнгЯд ЗбЯКЗИЙ Эн еРЗ ЗбгбЭ.КГЯП гд ХбЗНнЗК ЗбЯКЗИЙ!";
    $lang['file_invalid_file_size'] = "ОШГ Эн НМг ЗбгбЭ";
    $lang['file_uploading_error'] = "нжМП ОШГ Эн ЪгбнЙ ЗбКНгнб ...НЗжб гСЙ ГОСн!";
    $lang['file_deleting_error'] = "ЪРСЗр нжМП ОШГ ГЛдЗБ ЪгбнЙ ЗбгУН ";
    $lang['first'] = "first";
    $lang['generate'] = "Generate";
    $lang['handle_selected_records'] = "еб ГдК гКГЯП гд ЕЯгЗб ЪгбнЙ ЗбгЪЗбМЙ ббУМбЗК ЗбгОКЗСЙ?";
    $lang['hide_search'] = "ЕОЭЗБ ЗбИНЛ ";
    $lang['item'] = "البند";
    $lang['items'] = "البنود";
    $lang['last'] = "last";
    $lang['like'] = "like";
    $lang['like%'] = "like%";  // "begins with"; 
    $lang['%like'] = "%like";  // "ends with";
    $lang['%like%'] = "%like%";  
    $lang['loading_data'] = "МЗСн КНгнб ЗбИнЗдЗК...";
    $lang['max'] = "max";
	$lang['max_number_of_records'] = "لقد تجاوزت الحد الأقصى لعدد السجلات سمحت!";
	$lang['move_down'] = "تحرك لأسفل";
	$lang['move_up'] = "تحريك للأعلى";
    $lang['move_operation_completed'] = "The moving row operation completed successfully!";
    $lang['move_operation_uncompleted'] = "The moving row operation uncompleted!";
    $lang['next'] = "next";
    $lang['no'] = "No";                                
    $lang['no_data_found'] = "бЗКжМП ИнЗдЗК ";
    $lang['no_data_found_error'] = "No data found! Please, check carefully your code syntax!<br>It may be case sensitive or there are some unexpected symbols.";                                
    $lang['no_image'] = "No Image";
    $lang['not_like'] = "not like";
    $lang['of'] = "гд";
    $lang['operation_was_already_done'] = "The operation was already completed! You cannot retry it again.";            
    $lang['or'] = "or";                
    $lang['pages'] = "ЗбХЭНЗК";    
    $lang['page_size'] = "НМг ЗбХЭНЙ "; 
    $lang['previous'] = "previous"; 
    $lang['printable_view'] = "гФЗеПЙ гНКжнЗК ЮЗИбЙ ббШИЪ ";
    $lang['print_now'] = "Print Now";
    $lang['print_now_title'] = "Click here to print this page";
    $lang['record_n'] = "Record #";
    $lang['refresh_page'] = "Refresh Page";	
    $lang['remove'] = "ЕТЗбЙ";
    $lang['reset'] = "ЕбЫЗБ "; 
    $lang['results'] = "ЗбдКЗЖМ";
    $lang['required_fields_msg'] = " гШбжИ ЕПОЗб Яб ЗбНЮжб ЗбгФЗС ЕбнеЗ ИдМгЙ НгСЗБ   <font color='#cd0000'>*</font>";
    $lang['search'] = "ИНЛ"; 
    $lang['search_d'] = "жХЭ ЗбИНЛ"; // (description) 
    $lang['search_type'] = "джЪ ЗбИНЛ ";
    $lang['select'] = "select";
    $lang['set_date'] = "Set date";
    $lang['sort'] = "Sort";    	
    $lang['test'] = "Test";    	
    $lang['total'] = "ЗбгМгжЪ";
    $lang['turn_on_debug_mode'] = "For more information, turn on debug mode.";
    $lang['uncheck_all'] = "ЕбЫЗБ ЗбКНПнП ";
    $lang['unhide_search'] = "ЕЩеЗС ЗбИНЛ";
    $lang['unique_field_error'] = "The field _FIELD_ allows only unique values - please reenter!";           
    $lang['update'] = "КЪПнб "; 
    $lang['update_record'] = "КЪПнб УМб ";
    $lang['update_record_blocked'] = "Security check: attempt of updating a record! Check your settings, the operation is not allowed!";
    $lang['updating_operation_completed'] = " !ЪгбнЙ КЪПнб ЗбУМб КгК ИдМЗН ";
    $lang['updating_operation_uncompleted'] = "  !ЪгбнЙ КЪПнб ЗбУМб бг КЯКгб ";                        
    $lang['upload'] = "КНгнб ";
    $lang['uploaded_file_not_image'] = "The uploaded file doesn't seem to be an image.";
    $lang['view'] = "гФЗеПЙ "; 
    $lang['view_details'] = "гФЗеПЙ ЗбКЭЗХнб ";
    $lang['warnings'] = "Warnings";            
    $lang['with_selected'] = " ЕОКЗС ЪгбнЙ жЗНПЙ ИЪП КНПнП ЗбУМб / ЗбУМбЗК";
    $lang['wrong_field_name'] = "ОШГ Эн ЕУг ЗбНЮб";
    $lang['wrong_parameter_error'] = "ОШГ Эн ЮнгЙ ЗбНЮб.. <b>_FIELD_</b>: _VALUE_";
    $lang['yes'] = "Yes";                
  
    // date-time
    $lang['day']    = "day";
    $lang['month']  = "month";
    $lang['year']   = "year";
    $lang['hour']   = "hour";
    $lang['min']    = "min";
    $lang['sec']    = "sec";
    $lang['months'][1] = "January";
    $lang['months'][2] = "February";
    $lang['months'][3] = "March";
    $lang['months'][4] = "April";
    $lang['months'][5] = "May";
    $lang['months'][6] = "June";
    $lang['months'][7] = "July";
    $lang['months'][8] = "August";
    $lang['months'][9] = "September";
    $lang['months'][10] = "October";
    $lang['months'][11] = "November";
    $lang['months'][12] = "December";
    
    return $lang;
}
?>