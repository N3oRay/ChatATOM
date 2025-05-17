<?php


function recherchequestion ($json_a){
  return recherchequest ($json_a, false);
}

/** apprentisage */
function recherchequest ($json_a, $admin){
echo  "<! -- Debut recherche une question sans reponse !>\n";
  $input = array();
  $final = array();

  //if (menuitem ?? null)  
  $arrayOfObjsnew = $json_a->menuitem;

  foreach ($arrayOfObjsnew as $key => $object) {
    $keyentrer =  $object->entrer;
               //On recherche les questions sans reponses
		if (empty($object->result)) {
                      // On ajout la question qui na pas de reponse:
			array_push($input, $keyentrer);
		}else{
                  // pour les question avec reponse on verifit
  		      // Si l'enregistrement exite dans la liste de valeur selectioné :
                   /*
  		   if (in_array($keyentrer,$input)) { echo  "<! -- la question suivante existe deja: ".$keyentrer." !>\n";}
                    */

                  $key = array_search($keyentrer, $input);
                  if (($key != null) || ($key != FALSE)){
                   //echo  "<! -- on supprime l'enregistrement de la liste : ".$keyentrer." key: ".$key." !>\n";
                         unset($input[$key]);
                         $input = array_merge($input);
                  }

                }
  }
 
 // Suppression des doublons.
 $tableaufinal = array_unique($input);
// Affichage tableaufinal : Liste des questions sans réponses:   *****************************
if ($admin){
  affichagerecord ($tableaufinal);
}
return array_random($tableaufinal);

}
/***************************************************************************************************/

function affichagerecord ($tableaufinal){
   echo "<br>Questions sans reponses : <br>";
   echo '<div id="div_histo" style="height:250px; overflow-y:scroll; border:2px inset #ffffff; background-color:#ffffff; padding:5px">';
    foreach ($tableaufinal as $key => $value) {
        echo nl2br('<span class="text-info">'.$value.'</span><br>');
    }
    echo '</div>';
    echo '<br>Nombre de questions sans reponses : '.count($tableaufinal)." <br>";
}

?>
