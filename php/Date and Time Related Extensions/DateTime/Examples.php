<?php
/*
Add any number of Minutes, Days, Months or Years in current date or any date
PT75M = 75 Minutes
P2M = add 2 Months
P17D = add 17 days
P2Y = add 2 years 
*/
	$plusTwoMonth = new DateTime('now');
	//$plusTwoMonth = new DateTime('2003-4-9');
	$plusTwoMonth->add(new DateInterval('P2M'));
	echo $plusTwoMonth->format('y-m-d');
	
	
	
/*
get Time Stamp of current date object
*/
echo $plusTwoMonth->getTimestamp();

	
?>
