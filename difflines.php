<?php
/*
 * difflines file1 file2 > results
 * returns the changes needed to make the old file into the new file
 * + are the additions, - are the lines to be removed
 */
if ( count($argv) != 3) {
  die('Usage: difflines.php oldfile newfile > result');
}

$oldFileName = $argv[1];
$newFileName = $argv[2];

$old = file($oldFileName);
if (!$old) {
  die('ERROR: Cannot read '.$oldFileName."\n");
}

//read file produced with new method
$new = file($newFileName);
if (!$new) {
  die('ERROR: Cannot read '.$newFileName."\n");
}

function diff($old, $new){
    $matrix = array();
    $maxlen = 0;
    foreach($old as $oindex => $ovalue){
        $nkeys = array_keys($new, $ovalue);
        foreach($nkeys as $nindex){
            $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
            if($matrix[$oindex][$nindex] > $maxlen){
                $maxlen = $matrix[$oindex][$nindex];
                $omax = $oindex + 1 - $maxlen;
                $nmax = $nindex + 1 - $maxlen;
            }
        }
    }
    if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
    return array_merge(
        diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
        array_slice($new, $nmax, $maxlen),
        diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
}

$result = diff($old, $new);

foreach($result as $k) {
    if(is_array($k)) {
        $d = empty($k['d']) ? '' : '-'.implode(' ',$k['d']);
        $a = empty($k['i']) ? '' : '+'.implode(' ',$k['i']);
        echo $d;
        if ($a) { echo PHP_EOL; }
        echo $a;
    }
}
