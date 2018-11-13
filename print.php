<?php
/*
	$arg = 'T';

	$vehicle = ( ( $arg == 'B' ) ? 'bus' : 'no bus');
	echo $vehicle;

	$vehicle = ( ( $arg === 'B' ) ? 'bus' : 
				( $arg === 'A' ) ? 'airplane' :
				( $arg === 'T' ) ? 'train' :
				( $arg === 'C' ) ? 'car' :
				( $arg === 'H' ) ? 'horse' : 'feet' );
*/

	$arg = 2;
		
	$vehicle = ( ( $arg === 1 ) ? 'bus' : 
				( $arg === 2 ) ? 'airplane' :
				( $arg === 3 ) ? 'train' :
				( $arg === 4 ) ? 'car' :
				( $arg === 5 ) ? 'horse' : 'feet' );

	echo $vehicle;
	function foo() {
		$val = 41;
		$a = 1;
		$b = 2;

		return $val == 42 ? $a : $b;
	}

	echo "<br />\r\n";
	echo foo();
// */
//	phpinfo();
?>