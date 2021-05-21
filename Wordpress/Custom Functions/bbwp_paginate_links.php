<?php
/* used in projects
1- http://localhost/warraichtraders/wp-admin/admin.php?page=loanborrower
/*

/* CSS For Style
.pagination {
	display: inline-block;
	padding-left: 0;
	margin: 20px 0;
	border-radius: 4px;
}

.pagination span, .pagination a {
	background-color: #fafafa;
	border: 1px solid #dddddd;
	color: #444;
	float: left;
	line-height: 20px;
	margin-right: 5px;
	padding: 4px 12px;
	text-decoration: none;
}

.pagination a:hover{
	background: #fafafa;
	border-color: #999;
	color: #23282d;
}

.pagination span.current {
	color: #a0a5aa!important;
    border-color: #ddd!important;
    background: #f7f7f7!important;
}
*/


	/******************************************/
  /***** wpbb_paginate_links **********/
  /******************************************/
  if(!function_exists("wpbb_paginate_links")){
    function wpbb_paginate_links($args, $linkArgs = array()){

			global $wpdb;

			$defaults = array(
				'query_var' => 'paged',
				'items_per_page' => '10',
				'output' => '',
			);
		
			$args = wp_parse_args( $args, $defaults );
			$args['total_rows_found'] = 0;

			$total_query = "SELECT COUNT(1) FROM (".$args['sql'].") AS combined_table";
			$total = $wpdb->get_var( $total_query );
			
			$page = isset( $_GET[$args['query_var']] ) ? abs( (int) $_GET[$args['query_var']] ) : 1;
			$offset = ( $page * $args['items_per_page'] ) - $args['items_per_page'];
			$totalPage = ceil($total / $args['items_per_page']);

			if($total && $total >= 1){
				
				$args['total_rows_found'] = $total;
				$args['sql'] .= " LIMIT ${offset}, ".$args['items_per_page'];

				if($totalPage > 1){
						$defaultsLinkArgs = array(
							'base' => add_query_arg( $args['query_var'], '%#%' ),
							'format' => '',
							'prev_text' => __('&laquo; Previous'),
							'next_text' => __('Next &raquo;'),
							'total' => $totalPage,
							'current' => $page
						);
						$linkArgs = wp_parse_args( $linkArgs, $defaultsLinkArgs );
						$args['output'] = '<div class="bbwp-pagination pagination"><span class="page-total">Page '.$page.' of '.$totalPage.'</span>'.paginate_links($linkArgs).'</div>';
					}
			}
			
			
			return $args;
    }
  }
