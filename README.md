# mahalo-php-v3

[![forthebadge](http://forthebadge.com/images/badges/built-with-love.svg)](http://forthebadge.com)

Documentation et exemples pour utiliser les API Mahalo V3

## Pour commencer

Renommer le fichier param.exemple.php en param.php et renseigner les valeurs requises.

### Pré-requis

Ce qu'il est requis pour commencer avec votre projet...

- PHP v5.2

## Dossier 'client' 
Partie donnant des exemples pour la création, modification ou consultation d'un contact.
### Recherche de contacts
getClient.php : exemple d'une recherche en fonction du codeClient
getClientCreatedToday.php  : exemple pour récupérer les clients créés aujourd'hui depuis minuit
rechercheClient.php : exemples de recherche de client en fonction d'un seul critère (email, téléphone, portable, ancienCode)
rechercheClientCriteresMultiples.php : exemples de recherche de client en fonction de plusieurs critères 
rechercheClientEnFonctionDuType.php : exemples de recherche en fonction du type de client (type 0 : client - 1 : tiers - 2 : payé par)

### Création d'un contact
creationClient.php : création d'un contact de type 'client'
creationClientPayePar.php : création d'un contact de type 'payé par' (le code client du tiers est obligatoire)
creationClientTiers.php : création d'un contact de type 'tiers'

### Mise à jour d'un contact
Dans ces cas, le CodeClient est obligatoire et on ajoute uniquement des données qu'on veut modifier
majMdpClient.php : modification du mot de passe du contact
modificationClient.php : exemple de donnée d'un contact qu'on peut modifier

### Optin
creationOptinClient.php : exemple pour créer un optin sur un contact
getOptinClient.php : exemple pour récupérer la liste des optins d'un contact


## Dossier 'Commande'
Partie donnant différents exemples pour la création d'une commande pour un contact.

Une fois la commande passée, il n'est pas possible de la modifier par WS.

Le paramètre : nePasModifierClient 
- 0 : écrase les données client lors de la validation de la commande. Il faut bien remettre toutes les données du client car celles absentes seront supprimées dans ce cas.
- 1 : ne pas écraser les données client lors de la validation de la commande

commandeAboAdresseLiv.php : exemple d'une commande avec différents abonnements et différents types d'adresse de livraison 
typeAdresseLiv : paramètre qui va gérer l'adresse de livraison en fonction de sa valeur 
- 0 : adresse de livraison du 'codeClient'
- 2 : nouvelle adresse de livraison avec création d'un nouveau client. Il faut ajouter les paramètres : civiliteLiv, nomLiv, prenomLiv, adresse2Liv, cpLiv, villeLiv, codeIsoPaysLiv (Obligatoire).
- 5 : nouvelle adresse temporaire de livraison sans création d'un nouveau client. Il faut ajouter les paramètres : civiliteLiv, nomLiv, prenomLiv, adresse2Liv, cpLiv, villeLiv, codeIsoPaysLiv (Obligatoire).
- 7 : adresse de livraison du beneficiaire identifie par le 'codeClientLiv'. Il faut ajouter le paramètre : codeClientLiv (Obligatoire).

modePaiement : paramètre qui va gérer le mode de paiement de la commande
- 1 : paiement par chèque 
- 2 : paiement CB One shot (cf commandeSimpleMultiOneShot.php)
- 3 : paiement par prélèvement SEPA / RIB (creation de Mandat necessaire en amont) ce mode de paiement est lié à la clé système ‘CREATE_REGLEMENT_FOR_RIB_COMMANDE’. (cf commandeAboAvecMandatSepa.php)
- 4 : paiement par virement 
- 5 : paiement Paypal 
- 6 : paiement par prélèvement CB (création de la CB necessaire en amont) (cf commandeAboADLStripe.php)

commandeAboAvecPns.php : exemple pour forcer le Premier Numéro à Servir (pns) lors d'un abonnement ou d'un réabonnement
pns : paramètre à ajouter sur la commande
Si la clé système 'COMMANDES_FIND_ABONNEMENTS_ECHUS' vaut True alors on ne tient pas compte du pns car il est calculé tout seul coté Aboweb et il n'y a pas besoin d'ajouter la paramètre refAboEchu (paramètre qui permet de donner la référence de l'abonnement à réabonner cf commandePourReabo.php). 
La clé système : 'WS_FORCE_DEBUT_ABO', permet de forcer le pns pour un abonnement quand 'COMMANDES_FIND_ABONNEMENTS_ECHUS' vaut False.
La clé système : 'WS_REABO_FORCE_PNS', permet de forcer le pns pour un réabonnement sur un tarif simple (ne fonctionne pas sur une formule)

commandeAboALDirectAvecCS.php : exemple de commande avec des Codes de Sélection (CS) 
refCs : référence du parametre CS obtenu par l'api aidesaisie
Il est possible d'ajouter un CS sur un client, une facture, une ligne de facture ou un abonnement.


