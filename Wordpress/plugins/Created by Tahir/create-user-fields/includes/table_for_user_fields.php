<?php 
if(!class_exists('WP_List_Table')){

    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Booking_List_Table extends WP_List_Table {
	
	private $id_column = 'ID';
	private $title_column = 'field_title';
	private $title_header = 'Field Title';
	private $meta_key_column = 'meta_key';
	private $meta_key_header = 'Meta Key';
	private $field_type_column = 'field_type';
	private $field_type_header = 'Field Type';
	
/******************************************/
/***** get_columns **********/
/******************************************/
	function get_columns(){
	  $columns = array(
	 	$this->id_column => $this->id_column,
	  	$this->title_column => $this->title_header,
		$this->meta_key_column => $this->meta_key_header,
		$this->field_type_column => $this->field_type_header		
	  );
	  return $columns;
	}// get_columns method end here
	
/******************************************/
/***** prepare_items **********/
/******************************************/
	function prepare_items() {
		$hidden = array();
	  	$sortable = $this->get_sortable_columns();
		$columns = $this->get_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$all_fields_data = get_user_created_fileds_array();
		$this->items = $all_fields_data;
	}// prepare_items method end here
	
/******************************************/
/***** column_default **********/
/******************************************/
	function column_default( $item, $column_name ) {
	  switch( $column_name ) { 
		case $this->id_column:
		case $this->meta_key_column:
		case $this->title_column:
		case $this->field_type_column:
		  return $item[ $column_name ];
		default:
		  return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
	  }
	}
	


/******************************************/
/***** get_sortable_columns **********/
/******************************************/
public function get_sortable_columns() {
    return $sortable = array(
        $this->id_column=>$this->id_column
    );
}

/******************************************/
/***** Edit and dlete button on id column **********/
/******************************************/

function column_ID($item) {
  $actions = array(
            //'edit'      => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
        );
  return sprintf('%1$s %2$s', $item[$this->id_column], $this->row_actions($actions) );
}



}// class Booking_List_Table end here
