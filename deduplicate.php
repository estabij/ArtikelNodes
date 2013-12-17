<?php
/*
 * The purpose of this script is 
 * to get the event and brand from
 * ArtikelEvents and to extend the
 * item list with this. 
 * This result is then matched with 
 * the browser node file
 */

$sep = ";";

// get the command line parameters
parse_str(implode('&', array_slice($argv, 1)), $_GET);

// some sanity checks..
// check if the format is correct
if ( count($_GET) ==0 ) {
  die('FORMAT: deduplicate.php i=[path]/file 1');
}

$inputfile = $_GET['i']; 

$lines = file($inputfile);

$lines2 = array_unique($lines);
$lines = $lines2;

$fh = fopen($inputfile."-deduped", "w");
foreach($lines as $line) {
  fprintf($fh, "%s", $line);
}
fclose($fh);
