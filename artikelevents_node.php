<?php

$sep = ";";

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
    if(count($line)==16) {
      $iData[] = array(  'artnr' => $line[0], 'color'  => $line[1], 
                         'prodtree' => $line[2], 'brand1' => $line[3],
                         'ev1' => $line[4], 'ev2' => $line[5],
                         'ev3' => $line[6], 'ev4' => $line[7],              
                         'ev5' => $line[8], 'event' => $line[9],
			 'description' => $line[10], 'item' => $line[11], 
			 'company' => $line[12], 'brand2' => $line[13], 
			 'itemname' => $line[14], 'dummy' => $line[15] );
    }
    else {
      echo "ERROR: Column count in eventsfile is not 16 but ".count($line)." at ".$linecount."!\n";
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

//echo header
$line = array( 'node' => '', 
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

// extend the (article-events) items with the browsernodes
foreach ($iData as $mappingLine) {
  
  $found = false;
/*
 * mapping = ( 'artnr', 'color', 'prodtree', 'brand1', 'ev1', 'ev2', 'ev3', 'ev4', 'ev5',
 *              'event', 'description', 'item, 'company', 'brand2', 'itemname' )
 * 
 * nData   = ( 'node', 'description', 'prodtree', 'ev1', 'ev2', 'brand' );
 */

  $artnr    = $mappingLine['artnr'];
  $color    = $mappingLine['color'];
  $prodtree = $mappingLine['prodtree'];

  if ( isset($mappingLine['event'])) {
    $event    = $mappingLine['event'];
  } else {
    $event = '';  
  }
  
  if (isset($mappingLine['brand2'])) {
    $brand    = $mappingLine['brand2'];
  } else {
    $brand = '';
  }

  //en en - 1 van 1
  if ( !$found ) {   
    foreach ( $nData as $nDataLine ) { 

      $node       = $nDataLine['node'];
      $prodtree2  = $nDataLine['prodtree']; 
      $ev1        = $nDataLine['ev1']; 
      $ev2        = $nDataLine['ev2']; 
      $brand2     = $nDataLine['brand']; 

      if ( ( $prodtree == $prodtree2 ) && ( $event == $ev1 ) && ( $brand == $brand2 ) ) {

        $line = array( 'node' => $node, 
                             'artnr' => $artnr, 
                             'color' => $color,  
                             'prodtree' => $prodtree, 
                             'event' => $ev1, 
                             'event2' => $ev2, 
                             'brand' => $brand );

        foreach ($line as $word) {
           echo $word.$sep;
        }
        echo "\n";  
        $found = true;
        break;
      }        
    }
  }
  
  // en - 1 van 3 - prodtree, event
  if ( !$found ) {   
    foreach ( $nData as $nDataLine ) { 

      $node       = $nDataLine['node'];
      $prodtree2  = $nDataLine['prodtree']; 
      $ev1        = $nDataLine['ev1']; 
      $ev2        = $nDataLine['ev2']; 
      $brand2     = $nDataLine['brand']; 

      if ( ( $prodtree == $prodtree2 ) && ( $event == $ev1 ) ) {

        $line = array( 'node' => $node, 
                             'artnr' => $artnr, 
                             'color' => $color,  
                             'prodtree' => $prodtree, 
                             'event' => $ev1, 
                             'event2' => $ev2, 
                             'brand' => $brand );

        foreach ($line as $word) {
           echo $word.$sep;
        }
        echo "\n";  
        $found = true;
        break;
      }        
    }
  }
  
  // en - 2 van 3 - prodtree, brand
  if ( !$found ) {   
    foreach ( $nData as $nDataLine ) { 

      $node       = $nDataLine['node'];
      $prodtree2  = $nDataLine['prodtree']; 
      $ev1        = $nDataLine['ev1']; 
      $ev2        = $nDataLine['ev2']; 
      $brand2     = $nDataLine['brand']; 

      if ( ( $prodtree == $prodtree2 ) && ( $brand == $brand2 ) ) {

        $line = array( 'node' => $node, 
                             'artnr' => $artnr, 
                             'color' => $color,  
                             'prodtree' => $prodtree, 
                             'event' => $ev1, 
                             'event2' => $ev2, 
                             'brand' => $brand );

        foreach ($line as $word) {
           echo $word.$sep;
        }
        echo "\n";    
        $found = true;
        break;
      }        
    }
  }  
  
  // en - 3 van 3 - brand, event
  if ( !$found ) {   
    foreach ( $nData as $nDataLine ) { 

      $node       = $nDataLine['node'];
      $prodtree2  = $nDataLine['prodtree']; 
      $ev1        = $nDataLine['ev1']; 
      $ev2        = $nDataLine['ev2']; 
      $brand2     = $nDataLine['brand']; 

      if ( ( $event == $ev1 ) && ( $brand == $brand2 ) ) {

        $line = array( 'node' => $node, 
                             'artnr' => $artnr, 
                             'color' => $color,  
                             'prodtree' => $prodtree, 
                             'event' => $ev1, 
                             'event2' => $ev2, 
                             'brand' => $brand );

        foreach ($line as $word) {
           echo $word.$sep;
        }
        echo "\n";  
        $found = true;
        break;
      }        
    }
  }
  
  // or or - 1 van 1
  if ( !$found) {   
    foreach ( $nData as $nDataLine ) { 

      $node       = $nDataLine['node'];
      $prodtree2  = $nDataLine['prodtree']; 
      $ev1        = $nDataLine['ev1']; 
      $ev2        = $nDataLine['ev2']; 
      $brand2     = $nDataLine['brand']; 

      if (
              ( ($prodtree2==$prodtree) && $ev1=='' && $ev2=='' && $brand2=='' ) ||
              ( ($brand == $brand2)     && $ev1=='' && $ev2=='' && $prodtree2=='' ) ||
              ( ($event == $ev1)        && $prodtree2=='' && $brand2=='' )) {
     
        $line = array( 'node' => $node, 
                             'artnr' => $artnr, 
                             'color' => $color,  
                             'prodtree' => $prodtree, 
                             'event' => $ev1, 
                             'event2' => $ev2, 
                             'brand' => $brand );

        foreach ($line as $word) {
           echo $word.$sep;
        }
        echo "\n";   
        $found = true;
        break;
      }        
    }
  }
//  if ( !$found) {
//    echo "DEBUG: NOT FOUND!\n";
//    print_r($mappingLine);
//  }
}


