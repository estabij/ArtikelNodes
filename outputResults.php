<?php

$sep = ";";

function outputLine ( $iDataLine, $nDataLine ) {
  
  global $sep;
  
  $nodeNode         = $nDataLine['node'];
  $nodeProdtree     = $nDataLine['prodtree']; 
  $nodeEvent1       = $nDataLine['ev1']; 
  $nodeEvent2       = $nDataLine['ev2']; 
  $nodeBrand        = $nDataLine['brand'];
  
  $artikelNr        = $iDataLine['artnr'];
  $artikelColor     = $iDataLine['color'];
  $artikelProdtree  = $iDataLine['prodtree'];
  if ( isset($iDataLine['event'])) {
    $artikelEvent   = $iDataLine['event'];
  } else {
    $artikelEvent   = '';  
  }
  if (isset($iDataLine['brand2'])) {
    $artikelBrand   = $iDataLine['brand2'];
  } else {
    $artikelBrand   = '';
  }  
  
  $line = array( 'node'     => $nodeNode, 
                 'artnr'    => $artikelNr, 
                 'color'    => $artikelColor,  
                 'prodtree' => $artikelProdtree, 
                 'event'    => $artikelEvent, 
                 'event2'   => $nodeEvent2, 
                 'brand'    => $artikelBrand );

  foreach ($line as $word) {
     echo $word.$sep;
  }
  echo PHP_EOL;  
}

function outputNodeLine ( $iData, $nDataLine ) {
    
  $nodeNode         = $nDataLine['node'];
  $nodeProdtree     = $nDataLine['prodtree']; 
  $nodeEvent1       = $nDataLine['ev1']; 
  $nodeEvent2       = $nDataLine['ev2']; 
  $nodeBrand        = $nDataLine['brand'];
  
  foreach ( $iData as $iDataLine ) { 
    
    $artikelNr        = $iDataLine['artnr'];
    $artikelColor     = $iDataLine['color'];
    $artikelProdtree  = $iDataLine['prodtree'];
    if ( isset($iDataLine['event'])) {
      $artikelEvent   = $iDataLine['event'];
    } else {
      $artikelEvent   = '';  
    }
    if (isset($iDataLine['brand2'])) {
      $artikelBrand   = $iDataLine['brand2'];
    } else {
      $artikelBrand   = '';
    }    

    //001
    if ( !$nodeProdtree && !$nodeEvent1 && $nodeBrand ) {
      if ( $nodeBrand  == $artikelBrand )  {
        outputLine ( $iDataLine, $nDataLine );
      }
    } 

    //010
    else if ( !$nodeProdtree && $nodeEvent1 && !$nodeBrand ) {
      if ( $nodeEvent1 == $artikelEvent )  {
        outputLine ( $iDataLine, $nDataLine );
      }
    } 

    //011
    else if ( !$nodeProdtree && $nodeEvent1 && $nodeBrand ) {
      if ( ( $nodeEvent1 == $artikelEvent ) && ( $nodeBrand  == $artikelBrand ) )  {
        outputLine ( $iDataLine, $nDataLine );
      }
    } 

    //100
    else if ( $nodeProdtree && !$nodeEvent1 && !$nodeBrand ) {
      if ( $nodeProdtree == $artikelProdtree ) {
        outputLine ( $iDataLine, $nDataLine );
      }
    }

    //101
    else if ( $nodeProdtree && !$nodeEvent1 && $nodeBrand ) {
      if ( ( $nodeProdtree == $artikelProdtree ) && ( $nodeBrand  == $artikelBrand ) )  {
        outputLine ( $iDataLine, $nDataLine );
      }
    } 

    //110
    else if ( $nodeProdtree && $nodeEvent1 && !$nodeBrand ) {
      if ( ( $nodeProdtree == $artikelProdtree ) && ( $nodeEvent1 == $artikelEvent ) )  {
        outputLine ( $iDataLine, $nDataLine );
      }
    }    

    //111
    else if ( $nodeProdtree && $nodeEvent1 && $nodeBrand ) {
      if ( ( $nodeProdtree == $artikelProdtree ) && ( $nodeEvent1 == $artikelEvent ) && ( $nodeBrand  == $artikelBrand ) )  {
        outputLine ( $iDataLine, $nDataLine );
      }
    }  
  }
}

function outputResults(  $iData, $nData ) {

  foreach ( $nData as $nDataLine ) { 

    outputNodeLine ( $iData, $nDataLine );        

  }  
  
}
