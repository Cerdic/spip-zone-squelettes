<?php

/// Revisa si tiene que a–adir ? o &

 $enlace=quote_amp($GLOBALS["clean_link"]->getUrl()) ;
 if(ereg("\?",$enlace)){
	$enlace=$enlace."&";
	}
	else{
	$enlace=$enlace."?";
	}
$partes=explode("esqueleto",$enlace);
$enlace=$partes[0];
$enlace .= "esqueleto=";

// Guarda en una cookie el esqueleto seleccionado por un a–o o lo utiliza si existe
// Comprueba qu exista y si no deja el "por_defecto"


// Preparamos el menœ desplegable

//definimos el path de acceso
$path = "esqueletos";

//abrimos el directorio
$dir = opendir($path);

?>

<div class="modulo_form" style="text-align:center;">
<table width="100%" cellpading="0" cellspacing="0" border="0"><tr><td>

<form method="get" action="ver_esqueletos.php">
	<select name="select" onChange="if (options[selectedIndex].value) { location =
			options[selectedIndex].value; }" style="width:100%; text-align:center; color:green; font-size:70%; border: 1px solid silver;">
			<option selected>Cambiar visualizaci&oacute;n</option>
		<?php
		
			while ($esqueleto = readdir($dir))
			{
				if (!is_file($esqueleto) and $esqueleto!="." and $esqueleto!=".."){
 					$enlace_esqueleto= "esqueletos/".$esqueleto;
 					if ($enlace_esqueleto==$dossier_squelettes){
					echo "<option value='$enlace$esqueleto' style='text-align:center; color:maroon; text-decoration: underline; font-weight: bold;'>&bull; ".$esqueleto." &bull;</option>";
					}
					else {
					echo "<option value='$enlace$esqueleto' style='text-align:center; color:maroon; font-weight:normal;'>".$esqueleto."</option>";

					}
				}
			}

	//Cerramos el directorio
	closedir($dir);

	?>
	
</select>
</form>

</td></tr></table>
</div>