<?php
	require_once("../resttbs.php");

	print "<br>Ajout d'un code de sélection de type pièce jointe <br>";

	print "<br>Etape 1 : upload du fichier <br>";

	$newFichier = [];
	$newFichier["type"] = "piecejointe";
	//Fichier encodé en base 64
	$newFichier["uri"] = " data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAI0AAAAmCAYAAAD5hRiIAAAABGdBTUEAALGPC/xhBQAAAAlwSFlzAAAOwgAADsIBFShKgAAABSRJREFUeF7tmc2vXlMUh/0ppgbMmDDriBGjGiAMbidtkBDKyG18DG6iEjVUGhPxGQaCNhGDBo0wasOIYNSYNNH0XtoefU7Puvf3rq59ztnnHHXVepKV9z37+937t9de+z03NUlSSYomqSZFk1STokmqSdEk1aRokmpSNEk1KZqkmhRNUk2KJqlmtmgunz3bbG0cbi48sq/ZPPB4+5205MZllmgu//RzK5YLex9YtStpu104p8/80rz34cnm6LETzdenfmzOnTvf5SRDzBLN1nPPXyuYzrY2Xu5Klbn5lrUq2/vgRlezv+6+A681X33zQ1dyFcRy/0MbYb1DL73dlUr6mCWaSCxqQ0QL12djRWP22fHvutJXQTC33fFoWNbsyWfe6EonJaaL5o/zoVDUhkAEanffu76ygD5//cUdT6DlDr/60bbduefp7fS79hzsSl9FPQx9ISo8Eu1aOubFlqwyy9Ns7n8sFAu2+dSzXanxsIC6eH2UyhGb3Hr7jjfBuwCfloawfAzz+rHjbR51EV9SZpZoLp36NhQMdun0ma7UeJYQDeCVLM9Eo22THzHFw3x+4vvmlSMft2ZxFIE1Zn0DIrX0X3/7vU3jO/XsWbF2OS755DnC2sQ8UZ6Ow8bHhcB+Q6kfZZZooBXOw2s7grnynbQpLCEa71EMJkvrcGuaA/1w/GmbGIts31Wc+ts4Du+579D2s4kNaFfz1Ej3AtN8T5Sn4+CIjvrid6ngPbNFY3D9xuYwVTTEKmaa7j2HeiAz6rDQ7LaxsHBDATVWEo2va6JB2EPtsqB6tGqeJ8rzc1wy34+ymGiWYKpoIsPVelhsH2yrDe0w44mDR7fr0J7VQaQaT5VEg1GOdoifzHuU2qWujrt0IfBEeX4c1g8CefeDkyvjJ86LuCFEw+JgenPCouszk8NklMTDTo9iDEW9gS/LxFten2gicfa1y7PlUc6wNMwT5flxeG+C8C1Px6+MFs3FL75sXxFsrb/QXPzk0/bKvTRTRaMwuSoIFrEEE0af7FzdYez4Pqwc/Xho0/JLookWo1RP0d9l2LOmGVHe0DjA8lWcyijRRP/88p5p6VcFS4gG7PqMre0/0qaxswl++bc4Qj0Ex1QfVg7z0I/l1YhGPUlpMUm3MuYh7BnzRHk1omEjRQyK5q933r9GMGZ4nSX5J0RjE6MTHnkf7VtvXRG64/25P+b2NLRYmD821BPpYpbqaHnM0HHgSXw/Y8Y5KBr+pIsEY7bkMbWEaPifQWMDW1QVEvl6W2KX69Vz6HhSr4ThvQi8/fW1VjQaCHOrswXlU2+GOj7asnSN4VS8mOHnmHLWD15Sf4PfEMagaCKhqM29ZitTRVMydqTupFLwq0YdH4RG6AL7+va9VjT0q/Uxjkp99uPj9qX5JTP8HJvpRsP83CmDoul7k40tyZKi4YjxNxQmQXemNyaKMYwFj6NCJH6aGtMY1PfCMSM9+k3RZqBsFDjrOJijqK+oH2VQNH2vCoh3loQdZC8eh97/aDlvQwtPPp6CxTPDFZd2lodyHG/RawddFAvCQX9b340OaJ/x1IxPy3MbpD/6sT4NL17KUX5sPzAoGoiC4T/ffKvL/f9hk45L9ztSYw8WYLfhRTOFUaIBrtf8V4MtGcf8F2Fn2sQjHAJhTOMPXPxYz3U9ua6iSXZADH1B9VBM8G+iotFjq4YUzQyIGdittggElhZP7FYQs8UuU0nRJNWkaJJqUjRJNSmapJoUTVJNiiappGn+BpIgmn4XNdEBAAAAAElFTkSuQmCC";

	//TRAITEMENT DES CALL API
	
	$token = getToken(LOGIN,CREDENTIAL);

	print_r($newFichier);
	
	print "<br>Ajout du fichier de type ".$newFichier["type"]." <br>";
	$response = callApiPost("/editeur/".REF_EDITEUR."/fichier", $token, $newFichier);
	print "refFichier du nouveau fichier = ".$response->value->refFichier."<br><br>";

	print "<br>Etape 2 : ajout du cs sur le client avec comme valeur refFichier=$refFichier<br>";
	print "<br>Voir le fichier createCodeSelection.php ou la variable $newLibelle doit prendre la valeur de la refFichier=$refFichier<br>";

?>
