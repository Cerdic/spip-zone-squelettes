<?php

function beespip_header_prive($flux){
  $flux .= "<script src='".url_absolue(find_in_path('js/mColorPicker.min.js'))."' type=\"text/javascript\"></script>\n"
  ."<script type=\"text/javascript\" charset=\"UTF-8\">$.fn.mColorPicker.defaults.imageFolder = \"".url_absolue(_DIR_PLUGIN_BEESPIP.'prive/themes/spip/images/')."\";
  $.fn.mColorPicker.init.replace = '.beestyle'</script>";

	return $flux;
}

?>
