Tout petit squelette à appeler avec ?page=test.

Objectif : montrer que même si un squelette (balinclure) contient des <INCLURE> en principe dynamiques,
si (balinclure) est inclus par #INCLURE, alors, ses inclusions dynamiques deviennent statiques (par héritage).

Souhait : que #INCLURE ne rendre statique *que* le squelette #inclus, et *pas* les sous squelettes <inclus>
Autrement dit : pas d'héritage du caractère statique.