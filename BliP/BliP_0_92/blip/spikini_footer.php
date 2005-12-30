</div><!--  fin corps texte -->

</div><!-- fin contenu_principal_wiki -->

	<?php
		if ($this->GetConfigValue("debug")=="yes")
		{
			echo "<span class=\"debug\"><b>Query log :</b><br />\n";
			$t_SQL=0;
		foreach ($this->queryLog as $query)
			{
				echo $query["query"]." (".round($query["time"],4).")<br />\n";
				$t_SQL = $t_SQL + $query["time"];
			}
			echo "</span>\n";
			echo "<span class=\"debug\">".round($t_SQL, 4)." s (total SQL time)</span><br />\n";
			list($g2_usec, $g2_sec) = explode(" ",microtime());
			define ("t_end", (float)$g2_usec + (float)$g2_sec);
			echo "<span class=\"debug\"><b>".round(t_end-t_start, 4)." s (total time)</b></span><br />\n";
			echo "<span class=\"debug\">SQL time represent : ".round((($t_SQL/(t_end-t_start))*100),2)."% of total time</span>\n";
		}
	?> 



	<?php
	include ("blip/inclusions/inc_structure_pied_de_page_wiki.php3");
	?> 	

</div><!-- fin page -->

</body>
</html>
