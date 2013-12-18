<?php

//read file produced with old method
$oldlines = file("data/combined_oldmethod.csv");
if (!$oldlines) {
  die("ERROR: Cannot read lines produced with the old method!\n");
}

//read file produced with new method
$newlines = file("data/combined.csv");
if (!$newlines) {
  die("ERROR: Cannot read lines produced with the new method!\n");
}

//write file containing the difference between the newlines and the oldlines

if (($handle = fopen("data/diff.csv", "w")) !== FALSE) {
  foreach($newlines as $newline) {
    $found = false;
    foreach($oldlines as $oldline) {
      if ( $oldline == $newline ) {
        $found = true;
        break;
      }
    }
    if ( !$found) {
      fprintf($handle, "%s\n", $newline);
    }
  }
}
fclose($handle);
?>
