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
  $artikelBrand     = $iDataLine['brand'];
  $artikelEvent     = $iDataLine['ev1'];
  $artikelEvent2    = $iDataLine['ev2'];


  $line = array( 'node'     => $nodeNode, 
                 'artnr'    => $artikelNr, 
                 'color'    => $artikelColor,  
                 'prodtree' => $artikelProdtree, 
                 'event'    => $artikelEvent, 
                 'event2'   => $artikelEvent2, 
                 'brand'    => $artikelBrand );

  foreach ($line as $word) {
     echo $word.$sep;
  }
  echo "\n";  
}

function outputNodeLine ( $iData, $nDataLine ) {
    
  $nodeNode        = $nDataLine['node']; 
  $nodeProdtree     = $nDataLine['prodtree']; 
  $nodeEvent1       = $nDataLine['ev1']; 
  $nodeEvent2       = $nDataLine['ev2']; 
  $nodeBrand        = $nDataLine['brand'];
  
  echo "node=".$nodeNode."\n";
  echo "nodeProdTree=".$nodeProdtree."\n";
  echo "nodeEvent1=".$nodeEvent1."\n";
  echo "nodeEvent2=".$nodeEvent2."\n";
  echo "nodeBrand=".$nodeBrand."\n";
      
  foreach ( $iData as $iDataLine ) { 
    
    $artikelProdtree  = $iDataLine['prodtree'];
    $artikelBrand     = $iDataLine['brand'];   
    $artikelEvent     = $iDataLine['ev1'];
    $artikelEvent2    = $iDataLine['ev2'];
    
    echo "artikelProdtree=".$artikelProdtree."\n";
    echo "artikelBrand=".$artikelBrand."\n";
    echo "artikelEvent=".$artikelEvent."\n";
    echo "artikelEvent2=".$artikelEvent2."\n";
         
    if ( $nodeEvent2 )
    {
      echo "nodeEvent2=".$nodeEvent2."\n";
      echo "nodeProdtree=".$nodeProdtree."\n";
      echo "nodeEvent1=".$nodeEvent1."\n";
      echo "nodeBrand=".$nodeBrand."\n";
      
      //1001
      if ( (!$nodeProdtree) && (!$nodeEvent1) && $nodeBrand ) {
        echo "1001\n";
        if (( $artikelEvent2 == $nodeEvent2 ) && ( $nodeBrand  == $artikelBrand ))  {
          outputLine ( $iDataLine, $nDataLine );
        }
      } 

      //1010
      else if ( (!$nodeProdtree) && $nodeEvent1 && (!$nodeBrand) ) {
        echo "1010\n";
        if ( ( $artikelEvent2 == $nodeEvent2 ) && ( $nodeEvent1 == $artikelEvent ) )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      } 

      //1011
      else if ( (!$nodeProdtree) && $nodeEvent1 && $nodeBrand ) {
        echo "1011\n";
        if ( ( $artikelEvent2 == $nodeEvent2 ) && ( $nodeEvent1 == $artikelEvent ) && ( $nodeBrand  == $artikelBrand ) )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      } 

      //1100
      else if ( $nodeProdtree && (!$nodeEvent1) && (!$nodeBrand) ) {
        echo "1100\n";
        if (( $artikelEvent2 == $nodeEvent2 ) && ( $nodeProdtree == $artikelProdtree )) {
          outputLine ( $iDataLine, $nDataLine );
        }
      }

      //1101
      else if ( $nodeProdtree && (!$nodeEvent1) && $nodeBrand ) {echo "1101\n";
        if ( ( $artikelEvent2 == $nodeEvent2 ) && ( $nodeProdtree == $artikelProdtree ) && ( $nodeBrand  == $artikelBrand ) )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      } 

      //1110
      else if ( $nodeProdtree && $nodeEvent1 && (!$nodeBrand) ) {echo "1110\n";
        if ( ( $artikelEvent2 == $nodeEvent2 ) && ( $nodeProdtree == $artikelProdtree ) && ( $nodeEvent1 == $artikelEvent ) )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      }    

      //1111
      else if ( $nodeProdtree && $nodeEvent1 && $nodeBrand ) {echo "1111\n";
        if ( ( $artikelEvent2 == $nodeEvent2 ) && ( $nodeProdtree == $artikelProdtree ) && ( $nodeEvent1 == $artikelEvent ) && ( $nodeBrand  == $artikelBrand ) )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      }  
    } else {
     
      //0001
      if ( (!$nodeProdtree) && (!$nodeEvent1) && $nodeBrand ) { echo "0001\n";
        if ( $nodeBrand  == $artikelBrand )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      } 

      //0010    
      else if ( (!$nodeProdtree) && $nodeEvent1 && (!$nodeBrand) ) {echo "0010\n";
        if ( $nodeEvent1 == $artikelEvent )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      } 

      //0011      
      else if ( (!$nodeProdtree) && $nodeEvent1 && $nodeBrand ) {echo "0011\n";
        if ( ( $nodeEvent1 == $artikelEvent ) && ( $nodeBrand  == $artikelBrand ) )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      } 

      //0100    
      else if ( $nodeProdtree && (!$nodeEvent1) && (!$nodeBrand) ) {echo "0100\n";
        if ( $nodeProdtree == $artikelProdtree ) {
          outputLine ( $iDataLine, $nDataLine );
        }
      }

      //0101  
      else if ( $nodeProdtree && (!$nodeEvent1) && $nodeBrand ) {echo "0101\n";
        if ( ( $nodeProdtree == $artikelProdtree ) && ( $nodeBrand  == $artikelBrand ) )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      } 

      //0110
      else if ( $nodeProdtree && $nodeEvent1 && (!$nodeBrand) ) {echo "0110\n";
        if ( ( $nodeProdtree == $artikelProdtree ) && ( $nodeEvent1 == $artikelEvent ) )  {
          outputLine ( $iDataLine, $nDataLine );
        }
      }    

      //0111     
      else if ( $nodeProdtree && $nodeEvent1 && $nodeBrand ) {
        echo "0111\n";
        echo "VOOR\n";
                 echo $nodeProdtree.'-'.$artikelProdtree.' -- '.$nodeEvent1.'-'.$artikelEvent.' -- '.$nodeBrand.'-'.$artikelBrand."\n";
 
        if ( ( $nodeProdtree == $artikelProdtree ) && ( $nodeEvent1 == $artikelEvent ) && ( $nodeBrand  == $artikelBrand ) )  {
          outputLine ( $iDataLine, $nDataLine );
          echo "PRINTLINE\n";
        }
        echo "NA\n";
      }  

    }
  }
}

function outputResults(  $iData, $nData ) {

  foreach ( $nData as $nDataLine ) { 

//      $nodeNode        = $nDataLine['node']; 
//  $nodeProdtree     = $nDataLine['prodtree']; 
//  $nodeEvent1       = $nDataLine['ev1']; 
//  $nodeEvent2       = $nDataLine['ev2']; 
//  $nodeBrand        = $nDataLine['brand'];
//  
//  echo "-node=".$nodeNode."\n";
//  echo "-nodeProdTree=".$nodeProdtree."\n";
//  echo "-nodeEvent1=".$nodeEvent1."\n";
//  echo "-nodeEvent2=".$nodeEvent2."\n";
//  echo "-nodeBrand=".$nodeBrand."\n";
  
    outputNodeLine ( $iData, $nDataLine );        

  }  
  
}
