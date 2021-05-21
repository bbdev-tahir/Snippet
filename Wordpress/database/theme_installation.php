<?php

global $wpdb;
$wpdb->borrowers = $wpdb->prefix . 'borrowers';
$wpdb->borrower_installments = $wpdb->prefix . 'borrower_installments';
$wpdb->borrower_guarranter = $wpdb->prefix . 'borrower_guarranter';


$wt_theme_version = 1;
$installed_ver = get_option('wt_theme_version');

if ( $installed_ver != $wt_theme_version ) {

	//$sql = "DROP TABLE wt_borrower_guarranter, wt_borrower_installments, wt_borrowers;";
	//$wpdb->query ($sql);

  update_option( 'wt_theme_version', $wt_theme_version );

  // installation of tables start from here
  function install_db_tables () {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE ".$wpdb->borrowers." (
      ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      account_number varchar(50) UNIQUE NOT NULL,
      account_status tinyint(1) NOT NULL,
			client_name varchar(255) NOT NULL,
			father_name varchar(255) NOT NULL,
			contact_number varchar(15) NOT NULL,
			address text NOT NULL,
			account_open_date date DEFAULT '0000-00-00' NOT NULL,
			amount int NOT NULL,
			interest_rate int NOT NULL,
			total_installments int NOT NULL,
			amount_each_installment int NOT NULL,
			account_closing_date date DEFAULT '0000-00-00' NOT NULL,
			due_date date DEFAULT '0000-00-00' NOT NULL,
			PRIMARY KEY  (ID)
		) $charset_collate;";
		
		$sql .= "CREATE TABLE ".$wpdb->borrower_installments." (
			ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			borrower_id bigint(20) unsigned NOT NULL,
			amount int NOT NULL,
			paid_date date DEFAULT '0000-00-00' NOT NULL,	
			PRIMARY KEY  (ID),
			FOREIGN KEY (borrower_id) REFERENCES ".$wpdb->borrowers."(ID) ON DELETE CASCADE
		) $charset_collate;";

		$sql .= "CREATE TABLE ".$wpdb->borrower_guarranter." (
			ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			borrower_id bigint(20) unsigned NOT NULL,
			name varchar(255) NOT NULL,
			father_name varchar(255) NOT NULL,
			contact_number varchar(15) NOT NULL,
			address text NOT NULL,
			PRIMARY KEY  (ID),
			FOREIGN KEY (borrower_id) REFERENCES ".$wpdb->borrowers."(ID) ON DELETE CASCADE
		) $charset_collate;";
		
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
	install_db_tables();
	
	$index = "CREATE INDEX client_name ON ".$wpdb->borrowers." (client_name);";
	$wpdb->query ($index);
	$index = "CREATE INDEX account_number ON ".$wpdb->borrowers." (account_number);";
	$wpdb->query ($index);

}