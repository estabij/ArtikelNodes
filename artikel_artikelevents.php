<?php

//log our actions
$fhLog = fopen('log.log', "w");
$mappedcounter = 0;

$sep = ";";

// get the command line parameters
parse_str(implode('&', array_slice($argv, 1)), $_GET);

// some sanity checks..
// check if the format is correct
if ( count($_GET) ==0 ) {
  die('FORMAT: artikel_artikelevents.php i=[path]/items.csv ae=[path]/ae.csv > events.csv');
}

// check if the article file is specified
if (!isset($_GET['i'])) {
  die( 'ERROR: no article file specified!');
}

// check if the article events file is specified
if (!isset($_GET['ae'])) {
  die( 'ERROR: no article events file specified!');
}

$ItemsFileName          = $_GET['i']; 
$ArtikelEventsFileName  = $_GET['ae'];

// read the article file
$linecount=0;
$iData = array();
if (($handle = fopen($ItemsFileName, "r")) !== FALSE) {
  fgetcsv($handle, 1000, $sep); //skip first line
  while (($line = fgetcsv($handle, 1000, $sep)) !== FALSE) {
    $linecount++;
    if(count($line)==9) {
      $iData[] = array(  'artnr' => $line[0], 'color'  => $line[1], 
                         'prodtree' => $line[2], 'brand' => $line[3],
                         'ev1' => $line[4], 'ev2' => $line[5],
                         'ev3' => $line[6], 'ev4' => $line[7],              
                         'ev5' => $line[8] );
    } else {
      echo "ERROR: columns of items file not 9 at line ".$linecount."!\n";
    }
  }
} else {
  die('ERROR: Cannot open article file!');
}
fclose($handle);

// read the article events file
$linecount=0;
$aeData = array();
if (($handle = fopen($ArtikelEventsFileName, "r")) !== FALSE) {
  fgetcsv($handle, 1000, $sep); //skip first line
  while (($line = fgetcsv($handle, 1000, $sep)) !== FALSE) {
    $linecount++;
    if(count($line)==6) {
      $aeData[] = array(  'event' => $line[0], 'description'  => $line[1], 
                          'item'  => $line[2], 'company'      => $line[3],
                          'brand' => $line[4], 'itemname'     => $line[5] );
    } else {
      echo "ERROR: columns of artikelevents file not 6 at line ".$linecount."!\n";
    }
  }
} else {
  die('ERROR: Cannot open article events file!');
}
fclose($handle);


        
// extend the article items with the events
$mapping = array();
foreach ($iData as $iDataLine) {
  $mapped = false;
  foreach ( $aeData as $aeDataLine ) {  
    
    $a = intval( $iDataLine['artnr'] );
    $b = intval( $aeDataLine['item'] );
    if ( $a == $b ) {
     
      if ( $iDataLine['ev1'] ) {
         $event = $iDataLine['ev1'];
      } else {
        $event = $aeDataLine['event'];         
      }
  
      if ( $iDataLine['brand'] ) {
        $brand = $iDataLine['brand'];
      } else {
        $brand = $aeDataLine['brand'];         
      }
        
      $mapping[] =  array( 
                  'artnr'   => $iDataLine['artnr'], 
                  'color'   => $iDataLine['color'],
                  'prodtree'=> $iDataLine['prodtree'],
                  'brand'   => $brand,
                  'ev1'     => $event,
                  'ev2'     => $iDataLine['ev2'],
                  'ev3'     => $iDataLine['ev3'],
                  'ev4'     => $iDataLine['ev4'],
                  'ev5'     => $iDataLine['ev5'] );
              
      $mapped = true;
    }
  }
  if ( !$mapped ) {
    $mapping[] =  array( 
                  'artnr'   => $iDataLine['artnr'], 
                  'color'   => $iDataLine['color'],
                  'prodtree'=> $iDataLine['prodtree'],
                  'brand'   => $iDataLine['brand'],
                  'ev1'     => $iDataLine['ev1'],
                  'ev2'     => $iDataLine['ev2'],
                  'ev3'     => $iDataLine['ev3'],
                  'ev4'     => $iDataLine['ev4'],
                  'ev5'     => $iDataLine['ev5'] );

  }
  fwrite($fhLog, "mapped $mappedcounter\n"); $mappedcounter++;
}

$hdr = array( 'artnr', 'color', 'prodtree', 'brand', 'ev1', 'ev2', 'ev3', 'ev4', 'ev5' );

foreach ($hdr as $columnname) {
  echo $columnname.$sep;
}
echo "\n";

foreach($mapping as $line) {
  foreach ($line as $word) {
    echo $word.$sep;
  }
  echo "\n";
}

fclose($fhLog);