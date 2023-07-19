<?php
	print "-- refFacture sur l'abo";
    print "-- Récupération du dernier prel effectué sur le client :";
    print "-- https://api-preprod.mahalo-app.io/aboweb/editeur/946/reglement?filters={\"refFacture\":{\"matchMode\":\"equals\",\"value\":68284},\"typeReglement\":{\"matchMode\":\"in\",\"value\":[\"2\",\"6\"]},\"prelevementOk\":{\"matchMode\":\"equals\",\"value\":true}}&maxResults=1&sortField=dateRemise&sortOrder=-1";
    print "-- Si refReglementRejet <> null alors il y a eu un rejet et on récupére le libellé via le call ci-dessous :";
    print "-- https://api-preprod.mahalo-app.io/aboweb/editeur/946/reglement/306785";
    print "-- \"libRejet\": \"Pas d autorisation / Absence de mandat\",";
?>