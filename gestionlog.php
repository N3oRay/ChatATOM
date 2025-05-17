<?php
//include_once("JSON.php");
/************************************ GESTION DES LOGS ********************************************************/


function getIp(): string
{
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { // Support Cloudflare
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR']) === true) {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (preg_match('/^(?:127|10)\.0\.0\.[12]?\d{1,2}$/', $ip)) {
            if (isset($_SERVER['HTTP_X_REAL_IP'])) {
                $ip = $_SERVER['HTTP_X_REAL_IP'];
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
    } else {
        $ip = '127.0.0.1';
    }
    if (in_array($ip, ['::1', '0.0.0.0', 'localhost'], true)) {
        $ip = '127.0.0.1';
    }
    $filter = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    if ($filter === false) {
        $ip = '127.0.0.1';
    }

    return $ip;
}

/**
Affichage json
*/
function affichagelogrow ($json){
   $ip = getIp(); 
   echo '<div id="div_histo" style="height:250px; overflow-y:scroll; border:2px inset #ffffff; background-color:#ffffff; padding:5px">';
  $assoc_array = json_decode($json, true);
  $arrayOfObjsnew = $assoc_array["menuitem"];
  $reversed = array_reverse(array($arrayOfObjsnew));

  
      foreach ($reversed[0] as $key => $object) {
                if ($ip == $object["ip"]){
                  echo nl2br('<span class="text-info"><b>Atom : </b>'.$object["result"].'</span><br>');
                  echo nl2br('<span class="text-primary"><b>Vous : </b>'.$object["log"].'</span><br>');
                }
      }
    echo '</div>';
    echo 'Vous savez, votre adresse IP est ' . $ip . '?<br>';
    echo 'PHP version: ' . phpversion();
}

function affichagelogadminrow ($json){
   $ip = getIp(); 
   echo '<div id="div_histo" style="height:250px; overflow-y:scroll; border:2px inset #ffffff; background-color:#ffffff; padding:5px">';
  $assoc_array = json_decode($json, true);
  $arrayOfObjsnew = $assoc_array["menuitem"];
  $reversed = array_reverse(array($arrayOfObjsnew));
      foreach ($reversed[0] as $key => $object) {
          echo nl2br('<span class="text-info"><b>Atom : '.$object["date"].' </b>'.$object["result"].'</span><br>');
          echo nl2br('<span class="text-primary"><b>Vous : '.$object["ip"].' </b>'.$object["log"].'</span><br>');
      }
    //}
    echo '</div>';
    echo 'Vous savez, votre adresse IP est ' . $ip . '?<br>';
    echo 'PHP version: ' . phpversion();

}
/**
retourne un tableau depuis le fichier jscon
*/
function loadlogjson () {
//$json = new Services_JSON();

$input = file_get_contents('logatom.json', 1000000);
//$json_a = $json->decode($input);
//json_encode($json);
$json_a = json_decode($input);
return $json_a;
}

/**
Enregistre tableau dans le fichier de log json
param stdClass $json_string
*/
function savelogjson ($json_string) {
	//$json = new Services_JSON();
	$fp = fopen('logatom.json', 'w');
	//$output = $json->encode($arr);
    //json_encode($json);
    //$a = (array)$json_string_in_array[0];
    $json_array = json_decode($json_string);
    $json_string2 = json_encode($json_array);
	fwrite($fp, $json_string2 ?? '');
	fclose($fp);
}

function enregistrerlog ($json_log_a, $entrer, $resul,$admin){
	$entrer = trim($entrer);
	$resul = trim($resul);
	//$ip = $_SERVER["REMOTE_ADDR"];
    $ip = getIp(); 
	$Datecourante = date('d-m-Y H:i:s');
	echo  "<! -- Enregistement log: ".$ip." date: ".$Datecourante." !>\n";

        // On ajout un object
	$obj = new stdClass;
	$obj2 = new stdClass;
	$obj2->log = $entrer;
	$obj2->result = $resul;
	$obj2->ip = $ip;
	$obj2->date = $Datecourante;
	$obj->menuitem = array($obj2);

	$json_array =  (object) array_merge_recursive ( (array) $json_log_a, (array) $obj );
    //$json_array = json_decode($extended, true);
    $json_string2 = json_encode($json_array);
    if ($admin){
	   affichagelogadminrow ($json_string2);
	}else{
       affichagelogrow ($json_string2);
    }
    savelogjson ($json_string2);
}
/********************************************************************************************/

?>
