Tout petit squelette � appeler avec ?page=test.

Objectif : montrer que m�me si un squelette (balinclure) contient des <INCLURE> en principe dynamiques,
si (balinclure) est inclus par #INCLURE, alors, ses inclusions dynamiques deviennent statiques (par h�ritage).

Souhait : que #INCLURE ne rendre statique *que* le squelette #inclus, et *pas* les sous squelettes <inclus>
Autrement dit : pas d'h�ritage du caract�re statique.