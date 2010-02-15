<?php

function no_notes($texte) {
  return preg_replace(',\[\[.*\]\],Uims', '', $texte);
}
?>