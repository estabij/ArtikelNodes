<?php

$sep = ";";

include_once 'outputResults.php';

// get the command line parameters
parse_str(implode('&', array_slice($argv, 1)), $_GET);

// some sanity checks..
// check if the format is correct
if ( count($_GET) ==0 ) {
  die('FORMAT: artikelevents_node.php n=[path]/node.csv e=[path]/events.csv > results.csv');
}

// check if the browsernode file is specified
if (!isset($_GET['n'])) {
  die( 'ERROR: no browsernode file specified!');
}

// check if the article file is specified
if (!isset($_GET['e'])) {
  die( 'ERROR: no events file specified!');
}

$NodeFileName           = $_GET['n']; 
$EventsFileName         = $_GET['e']; 

// read the events file
$iData = array();
if (($handle = fopen($EventsFileName, "r")) !== FALSE) {
  $linecount=0;
  fgetcsv($handle, 1000, $sep); //skip first line
  while (($line = fgetcsv($handle, 1000, $sep)) !== FALSE) {
    $linecount++;
    if(count($line)==9) {
      $iData[] = array(  'artnr' => $line[0], 'color'  => $line[1], 
                         'prodtree' => $line[2], 'brand' => $line[3],
                         'ev1' => $line[4], 'ev2' => $line[5],
                         'ev3' => $line[6], 'ev4' => $line[7],              
                         'ev5' => $line[8]  );
    }
    else {
      echo "ERROR: Column count in eventsfile is not 9 but ".count($line)." at ".$linecount."!\n";
    }
  }
} else {
  die('ERROR: Cannot open article file!');
}
fclose($handle);

// read the browser node file
$nData = array();
if (($handle = fopen($NodeFileName, "r")) !== FALSE) {
  $linecount=0;
  fgetcsv($handle, 1000, $sep); //skip first line
  while (($line = fgetcsv($handle, 1000, $sep)) !== FALSE) {
    $linecount++;
    if(count($line)==6) {
      $nData[] = array(  'node'     => $line[0], 'description'  => $line[1], 
                         'prodtree' => $line[2], 'ev1'          => $line[3],
                         'ev2'      => $line[4], 'brand'        => $line[5] );
    }  
    else {
      echo "ERROR: Column count in nodefile is not 6 at ".$linecount."!\n";
    }	
  }
} else {
  die('ERROR: Cannot browser node file!');
}
fclose($handle);

//print_r($nData);

//echo header
$line = array(        'node' => '', 
                     'artnr' => '', 
                     'color' => '',  
                     'prodtree' => '', 
                     'event' => '', 
                     'event2' => '', 
                     'brand' => '' );
foreach($line as $key => $value ) {
   echo $key.$sep;
}
echo "\n";     

outputResults(  $iData, $nData );
