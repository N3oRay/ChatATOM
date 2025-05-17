<?php

//**********************************************************************************************
//********************************* function outils ********************************************
//**********************************************************************************************


include("JSON.php");

/**
retourne un tableau depuis le fichier jscon
*/
function loadvaluejson () {
$json = new Services_JSON();
echo 'Load Json<br>';
//$string = file_get_contents("results.json");
//$json_a=json_decode($string,true);
$input = file_get_contents('results.json', 1000000);
$json_a = $json->decode($input);

print_r ($json_a);

echo '<br />';
$arrayOfObjs = $json_a->menuitem;

foreach ($arrayOfObjs as $key => $object) {
    echo $object->entrer;
	echo $object->result;
	echo $object->poid;
	echo '<br />';
}
// On ajout un object
$obj = new stdClass;
$obj2 = new stdClass;
$obj2->entrer = "Hihi";
$obj2->result = "Hooo";
$obj2->poid = "50";
$obj->menuitem = array($obj2);

//$extended = (object) array_merge((array)$json_a, (array)$obj);
$extended =  (object) array_merge_recursive ( (array) $json_a, (array) $obj );

$arrayOfObjsnew = $extended->menuitem;	
echo '<br />';
foreach ($arrayOfObjsnew as $key => $object) {
    echo $object->entrer;
	echo $object->result;
	echo $object->poid;
	echo '<br />';
}	

// This will create an object from an array
/*
$monkey_array = array('title'=>'Spider Monkey', 'src'=>'monkey.jpg');
$monkey_object = (object) $monkey_array;
print $monkey_object->title . ' ' . $monkey_object->src;
*/

print_r($extended);

echo '<br>';
return $extended;
}

/**
Enregistre tableau dans le fichier jscon
*/
function savevaluejson ($arr) {
	$json = new Services_JSON();
	$fp = fopen('results2.json', 'w');
	$output = $json->encode($arr);
	fwrite($fp, $output);
	fclose($fp);
}

//***********************************************************************************************
//************************************ function principal ***************************************
//***********************************************************************************************


function reseau ($entrer,$poid){

if ( $entrer != null){
	if ( $poid != null){
		echo ' on propose un resultat en fonction du poid';
		//resultat = List [poid];
		$resultat = 'Bonjour';	
		if($resultat == null){
			echo ' on propose une valeur aléatoire.';
			//resultat = Listchoix [random];
			//poid = 0;
		}
	}else{
		echo ' on donne le resultat qui a le plus de poid.';
	   //resultat = List.maxvalue;
	}
}
return $resultat;
}

function appel ($entrer, $resul, $good){


$json_a = loadvaluejson ();
savevaluejson ($json_a);

 
   if ($resul == null){
   $resul = reseau($entrer, $poid);
   }
   // YF.JCEP8J.ISV.10
   if ( $good = 'good') {
   $poid = 100;
   //Listentrer.add (entrer, resul, poid);
   echo 'Enregistement de Listentrer.add ('.$entrer.','. $resul.','. $poid.');<br>';
  } else if ( $good = 'hight'){
   $poid = 75;
   //Listentrer.add (entrer, resul, poid);
   echo 'Enregistement de Listentrer.add ('.$entrer.','. $resul.','. $poid.');<br>';
  } else if ( $good = 'moyen'){
   $poid = 50;
   //Listentrer.add (entrer, resul, poid);
   echo 'Enregistement de Listentrer.add ('.$entrer.','. $resul.','. $poid.');<br>';
  } else if ( $good = 'low'){
   $poid = 25;
   //Listentrer.add (entrer, resul, poid);
   echo 'Enregistement de Listentrer.add ('.$entrer.','. $resul.','. $poid.');<br>';
  }else{
	$poid = 0;
   //Listentrer.add (entrer, resul, poid);
   echo 'Enregistement de Listentrer.add ('.$entrer.','. $resul.','. $poid.');<br>';
 }
return $resul;
}



//programme principal ***************************************************************
//init
$entrer = "Bonjour";
$resul = "Bonjour";
$good = 'good';
if ($good != null){
$result = appel($entrer,$resul, $good);

}

echo $result;

?>