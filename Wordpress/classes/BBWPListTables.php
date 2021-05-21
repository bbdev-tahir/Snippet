<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BBWPListTables{

  public $columns = array();
  public $items = array();
  public $sortable = array();
  public $actions = array();
  public $bulk_actions = array();


/******************************************/
/***** get_columns **********/
/******************************************/
	public function get_columns($columns = array()){

    if(isset($columns) && is_array($columns) && count($columns) >= 1)
      $this->columns = $columns;

	}// get_columns method end here

/******************************************/
/***** prepare_items **********/
/******************************************/
	public function prepare_items($data = array()) {

    if(isset($data) && is_array($data) && count($data) >= 1)
      $this->items = $data;

	}// prepare_items method end here

  /******************************************/
  /***** prepare_items **********/
  /******************************************/
  	public function display() {

      if(isset($this->items) && count($this->items) >= 1 && isset($this->columns) && count($this->columns) >= 1){

				$thead = '<tr>';
				
        if(count($this->bulk_actions) >= 1){

					$thead .= '<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="bb-select-all-checkbox" data-name="fields" type="checkbox"></td>';

					$tablenavtop = '<div class="tablenav top">';
          $tablenavtop .= '<div class="alignleft actions bulkactions"><select name="bulk_action" id="bulk-action-selector-top"><option value="">Bulk Actions</option>';
          foreach ($this->bulk_actions as $key => $value) {
            $tablenavtop .= '<option value="'.$key.'">'.$value.'</option>';
          }
					$tablenavtop .= '</select><input type="submit" id="doaction" class="button action" value="Apply"></div>';
					$tablenavtop .= '</div>';
        }
        
				
        $i = 1;
        foreach($this->columns as $key=>$value){
          $primarycolumn = '';
          if($i == 1)
            $primarycolumn = 'column-primary';

          if(is_array($this->sortable) && in_array($key, $this->sortable))
            $thead .= '<th scope="col" id="'.$key.'" class="sortable asc manage-column column-'.$key.' '.$primarycolumn.'"><a href="#"><span>'.$value.'</span><span class="sorting-indicator"></span></a></th>';
          else
            $thead .= '<th scope="col" id="'.$key.'" class="manage-column column-'.$key.' '.$primarycolumn.'">'.$value.'</th>';
          $i++;
        }
        $thead .= "</tr>";

        $i = 1;
        $tbody = "";
        foreach($this->items as $values){
          if(is_array($values) && count($values) >= 1){
						
						$tbody .= '<tr>';
            $j = 1;
						
						foreach($values as $key=>$value){

              if(!array_key_exists($key, $this->columns)){
                continue;
              }
              
              $primarycolumn = '';
              if($j == 1)
								$primarycolumn = 'column-primary';
							if(count($this->bulk_actions) >= 1){
                $tbody .= '<th scope="row" class="check-column"><input id="cb-select-'.$value.'" type="checkbox" name="fields[]" value="'.$value.'">
                <div class="locked-indicator"></div>
                </th>';
							}
							$action = $this->ActionsHtml($key, $value, $values);

              $tbody .= '<td class="'.$key.' column-'.$key.' has-row-actions '.$primarycolumn.'" data-colname="'.$key.'">'.$value.$action.'</td>';
              $j++;
            }
            $tbody .= "</tr>";
          }
          $i++;
        }


        echo $tablenavtop.'<table class="wp-list-table widefat fixed striped"><thead>'.$thead.'</thead><tbody class="bytebunch-wp-sortable">'.$tbody.'</tbody><tfoot>'.$thead.'</tfoot></table>';

        }
  	}// prepare_items method end here


/******************************************/
/***** get_sortable_columns **********/
/******************************************/
public function get_sortable_columns($column = false) {
  if(isset($column) && count($column) >= 1){
    $this->sortable = $column;
  }
}

/******************************************/
/***** ActionsHtml **********/
/******************************************/
public function ActionsHtml($key = NULL, $value = NULL, $values = NULL) {

	$action = '';

	if(isset($this->actions) && is_array($this->actions) && count($this->actions) >= 1){
		$action .= '<div class="row-actions">';				
		
		foreach($this->actions as $action_values){
			if($action_values['display'] == $key){
				
				if(isset($action_values['url']))
					$url = add_query_arg(array('action' => $action_values['key'], $action_values['column'] => $values[$action_values['column']]), $action_values['url']);
				else
					$url = '?page='.$_REQUEST['page'].'&action='.$action_values['key'].'&'.$action_values['column']."=".$values[$action_values['column']];
				
				$action .= '<span class="'.$action_values['key'].'"><a href="'.$url.'">'.$action_values['title'].'</a></span>'."  | ";
			}
		}

		$action = trim($action, "| ");
		$action .= '</div>';
		
	}

	return $action;

}


}// class Booking_List_Table end here
