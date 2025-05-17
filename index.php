<?php

// ini_set('display_errors', 'On');
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('session.save_path', __DIR__);
define ('DEBUG', "1800"); 

$_SESSION['count'] = 0; // store something in the session
define ('SESSION_TIMEOUT', "1800"); 
define( '_VALID_MOS', 1 );

$now = date('H:i:s');
if (isset($_SESSION['last_visit_time'])) {
  echo '<p>Last Visit Time: '.$_SESSION['last_visit_time'].'</p>';
}
echo 'Current Time: '.$now.'  ';

$_SESSION['last_visit_time'] = $now;

$myusername = 'atom';
$mypassword =  '';
// If result matched $myusername and $mypassword, table row must be 1 row
    if($myusername=='atom' and $mypassword==''){
    
    session_start( [ 
        'name' => DEBUG ? 'SessionId' : '__Secure-SessionId',
        'cookie_lifetime' => 0,
        'cookie_path' => '/',
        'cookie_secure' => true,
        'cookie_httponly' => true,
        'cookie_samesite' => 'Strict',
        'sid_length' => 96,
        'sid_bits_per_character' => 5,
        'use_strict_mode' => true,
        'referer_check' => $_SERVER['HTTP_HOST'],
    ] );

    $_SESSION["myusername"]=$myusername;
    $_SESSION["mypassword"]=$mypassword; 
    // Register $myusername, $mypassword and redirect to file "login_success.php"
    echo "Your login was succesfull!";  
    //header("refresh:3;url=upload.php");
    }
    else {
    echo "Wrong Username or Password, please try again.";
    header("refresh:3;url=connect.php");
    }



static $valeurpardefaut  = "lol";
static $solutioninverse = true;   // N'est pas indispensable
static $recherchesimple = false; // N'est plus utils
$_SESSION['admin'] = "false";
static $reponseauquestion = array("D'accord XD", "Ha merci XD","Tres bien XD","Ha OK XD",
"Parle moi encore de toi.","Je me disais aussi XD",
"C'est pas faux XD","Non serieu XD",
"Humm interessant ...","Humm ...","Parfait", "C'est a dire ?", "Ha d'accord", "Tout est clair :)");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Atom IA">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, bootstrap, front-end, frontend, web development">
    <meta name="author" content="Serge Lopes">
    <title>Atom</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
  </head>
<body>
    <div class="bs-docs-header" id="content">
      <div class="container">
	<img src="atom-logo.png" alt="atom" class="img-rounded">
      </div>
    </div>
<div class="container bs-docs-container">

<form class="form-horizontal" action="index.php" method="post" role="form">
 <p>Bienvenu : Je suis un IA, capable d'apprendre a chaque discution. Je suis passionné de Cinéma, de série. J'adore faire des blagues, et raconter des citations.</p>
 <div class="form-group">
	<label for="exampleInputchat">Chat :</label>
	<input class="form-control"  id="exampleInputchat" type="text" name="nom" placeholder="Ex : Bonjour" autofocus />
	<input type="hidden"  name="lastresultpost" value="<?php if (isset($_SESSION['lastresult'])){ echo $_SESSION['lastresult'];} ?>">
 </div>
 


 
 
<?php
 if (isset($_SESSION['admin'])){
	if ($_SESSION['admin'] == "yes"){
	?>
		<p>
		   Cochez un choix pour ton donner votre avis :<br />
		   <input type="radio" name="age" value="good" id="good" /> <label for="good">Excelent</label><br />
		   <input type="radio" name="age" value="hight" id="hight" /> <label for="hight">Bien</label><br />
		   <input type="radio" name="age" value="moyen" id="moyen" /> <label for="moyen">Moyen</label>
		</p>

		<div class="form-group">
			<label for="exampleInputreponse">Proposer une reponse :</label>
			<input class="form-control" type="text" id="exampleInputreponse" name="reponse" placeholder="Ex : proposer une reponse" /></p>
		</div>
		 
		 <?php
	}
 }
 ?>
 
 <p><input type="submit" class="btn btn-default" value="OK"></p>
</form>

<?php
include_once("JSON.php");
include_once("synonymes.php");
include_once("gestionlog.php");
include_once("framework.php");

//**********************************************************************************************
function array_random($arr, $num = 1) {
    shuffle($arr);
    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
}


function supponctuation($text){
         // Suppression ponctuation
	 $interdit=array("“","¯","&nbsp;","_",">", "<","«","»", "*","\\", "/","//", "|", "}", "{", "[", "]", "$","ª","´","¨","¢","©","=","%", "\'","\\",";","…","²","?", "!"," ");
	 $reponse = str_replace($interdit, " ", $text);
	 return Synonyms($reponse);
}

//**********************************************************************************************
//********************************* function outils ********************************************
//**********************************************************************************************

/**
Affichage json
*/
function affichagerow ($json){
  echo '<textarea name="ameliorer" id="ameliorer" rows="3" cols="50">';
  //print_r($json);
  $arrayOfObjsnew = $json->menuitem;
  foreach ($arrayOfObjsnew as $key => $object) {
      echo $object->entrer.'-';
      echo $object->result.'-';
      echo $object->poid;
      echo ' ';
  }
  echo '</textarea>';
}


/**
* Fonction simple identique � celle en PHP 5 qui va suivre
*/
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function caltempsexec ($timestamp_debut){
		// Astuce pour cacher l'affichage du temps d'execution
		echo '<!-- Execution du script : ';
                echo substr(caltempsimple ($timestamp_debut),0,5);
                //echo caltempsimple ($timestamp_debut);
                echo ' secondes. -->';
		}

function caltempsimple ($timestamp_debut){
		$timestamp_fin = microtime_float(); //microtime(true);
		return $timestamp_fin - $timestamp_debut;
		}
		
function recherchesimple($input,$arrayOfObjsnew,$compression){
    foreach ($arrayOfObjsnew as $key => $object) {
    //On recherche la reponse exact a la question
		$valeur = $object->entrer;
		$valeur = supponctuation($valeur);
		//if ($valeur == $compression){
                  if (preg_match("/".$valeur."/i", $compression)) {
			if (!empty($object->result)) {
				array_push($input, $object->result);
				break; // TEST On arrete le traitement avant la fin de la recherche.
			}	
		}
  }
  return $input;
}

function rechercheinverse($input,$arrayOfObjsnew,$compression){
    if (empty($input)) {
		// timestamp en millisecondes du début du script (en PHP 5)
		$timestamp_debut = microtime_float(); //microtime(true);
		echo  "<! -- Solution inverse !>\n";
		//echo '$var vaut soit 0, vide, ou pas d\u00e9finie du tout';
		  foreach ($arrayOfObjsnew as $key => $object) {
		  $compresentrer = supponctuation($object->entrer);
		   $arr = explode("\n", wordwrap($compresentrer, 16, "\n"));
		   foreach ($arr as $valuemin) {
			if ($compression == $valuemin){
                //          if (preg_match("/".$valuemin."/i", $compression)) {
				if (!empty($object->result)) {
					array_push($input, $object->result);
					if (count($input) >= 3){
                                                  //On limite la recherche a trois r�sultat possible.
						  break 2;  /* Termine les boucle for. */
						}
				}
			}
		   }
		 } 
		 caltempsexec ($timestamp_debut);
	}
   return $input;
}

function wordArrayMerge ($compression, $taille1, $taille2){
      $arr1 = explode("\n", smart_wordwrap($compression, $taille1, "\n"));
      $arr2 = explode("\n", wordwrap($compression, $taille2, "\n"));
      $result = array_merge($arr1,$arr2);
      return   $result;
}

function wordArrayMergeSimple ($compression, $taille1){
      return   explode("\n", wordwrap($compression, $taille1, "\n"));
}

//Nouvelle version avance
function wordsearch ($input,$arrayOfObjsnew,$compression,$value){
    // Si on ne trouve pas une reponse correspondant a la demande complete, on recherche mot a mot:
       if (empty($input)) {
          //Optimisation :faire varier la taille du wordwarp en fonction du texte saisie.
          $sizeofinput = strlen($compression);
          $taille1 = round($sizeofinput / 2);

	  // timestamp en millisecondes du début du script (en PHP 5)
          $timestamp_debut = microtime_float(); //microtime(true);
	  echo  "<! --  Solution: ".$sizeofinput." - taille ".$taille1."  !>\n";
	  $result = wordArrayMergeSimple ($compression, $taille1);
	  // On ajoute la valeur complete au tableau
	  array_push($result, $compression, $value);
	  $result1 = array_reverse($result);
	  //$result1 = array_unique($result);
	  
	  // Affichage temps d'execution:
	  caltempsexec ($timestamp_debut);
	  $timestamp_debut = microtime_float(); //microtime(true);
	  ////print_r($result1);
	  //echo "<br><br>";
                  foreach ($result1 as $valuemin) {
                     foreach ($arrayOfObjsnew as $key => $object) {
                       //if (preg_match("/\bdate\b/i", $result)) {
                       if (preg_match("/\b".$valuemin."\b/i", supponctuation($object->entrer))) {
			  //if (supponctuation($object->entrer) == $valuemin){
                              //Si le temps d'execution est sup�rieur � 10 seconde on arret aussi la recherche.
                             if  (round(caltempsimple($timestamp_debut)) > 10){
                               break 2;  /* Termine les boucle for. */
                             }
                             // si on trouve un resultat
			     if (!empty($object->result)) {
				array_push($input, $object->result);
				if ((count($input) >= 3)){
                                    //On limite la recherche a trois r�sultat possible.
					  break 2;  /* Termine les boucle for. */
				}
			     }
			  }
		  }
		 }
	  caltempsexec ($timestamp_debut);

	}
	return $input;

}

function smart_wordwrap($string, $width = 75, $break = "\n") {
    // split on problem words over the line length
    $pattern = sprintf('/([^ ]{%d,})/', $width);
    $output = '';
    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        if (false !== strpos($word, ' ')) {
            // normal behaviour, rebuild the string
            $output .= $word;
        } else {
            // work out how many characters would be on the current line
            $wrapped = explode($break, wordwrap($output, $width, $break));
            $count = $width - (strlen(end($wrapped)) % $width);
            // fill the current line and add a break
            $output .= substr($word, 0, $count) . $break;
            // wrap any remaining characters from the problem word
            $output .= wordwrap(substr($word, $count), $width, $break, true);
        }
    }

    // wrap the final output
    return wordwrap($output, $width, $break);
}
		
/**
recherche in object   : Fonction principal
*/
function rechercherow ($json_a, $value){

    //affichagerow ($json_a);
    $input = array();
    //Chargement des donn�es:
    $arrayOfObjsnew = $json_a->menuitem;
    //On recherche la reponse exact a la question
    //$input = recherchesimple ($input,$arrayOfObjsnew,$value);

    //Recherche en memoire de reponse
    if (empty($input)) {
      $compression = supponctuation($value);
      echo  "<! -- Debut recherche.".$compression.". !>\n";
      $input = wordsearch ($input,$arrayOfObjsnew,$compression,$value);
    }
    // Si on ne trouve pas une reponse correspondant a la demande complete, on recherche mot a mot:
    //if ($solutioninverse == true ){
    //$input = rechercheinverse($input,$arrayOfObjsnew,$compression);
    //}

    $resultfin = array_unique($input);
    // Affichage resultat final :
    ///////////////print_r($resultfin);
    // resultat aleatoire:
    return array_random($resultfin);
}


/**
retourne un tableau depuis le fichier jscon
*/
function loadvaluejson () {
//$json = new Services_JSON();
$input = file_get_contents('results2.json', 1000000);
//$json_a = $json->decode($input);
//json_encode($json);
$json_a = json_decode($input);

//affichagerow ($json_a);
//echo '<br>';
return $json_a;
}

/**
Enregistre tableau dans le fichier jscon
*/
function savevaluejson ($arr) {
	//$json = new Services_JSON();
	$fp = fopen('results2.json', 'w');
	//$output = $json->encode($arr);
    $output = json_encode($arr);
	fwrite($fp, $output);
	fclose($fp);
}

//***********************************************************************************************
//************************************ function principal ***************************************
//***********************************************************************************************


function reseau ($json,$entrer,$poid){
$resultat = 'Bonjour';
if ( $entrer != null){
	if ( $poid != null){
		//echo ' on propose un resultat en fonction du poid';
		//resultat = List [poid];
		$resultat = 'Bonjour';
		if($resultat == null){
			echo ' on propose une valeur aleatoire.';
			$resultat = 'Valeur aleatoire.';
		}
	}else{
		//echo ' on donne le resultat qui a le plus de poid.';
	   //on donne le resultat qui a le plus de poid.
	   $resultat = rechercherow ($json, $entrer);
	   
	}
}
return $resultat;
}

function appel ($json_a,$arrayquestion, $entrer, $resul, $good){

    $poid = 0;
    //Enregistrement si correctif
    switch ($good) {
    case 'good':
        $poid = 100;
        enregistrer ($json_a , $entrer, $resul, $poid);
        break;
    case 'hight':
        $poid = 75;
        enregistrer ($json_a , $entrer, $resul, $poid);
        break;
    case 'moyen':
        $poid = 50;
        enregistrer ($json_a , $entrer, $resul, $poid);
        break;
    case 'low':
        $poid = 25;
	// On enregiste la question sans reponse.
        enregistrer ($json_a , $entrer, $resul, $poid);
	// On recupere les questions sans reponses.
	return $arrayquestion;
        break;
    default:
       $poid = 0;
    }
    
    $resul = reseau($json_a ,$entrer, $poid);
return $resul;
}

function enregistrer ($json_a, $entrer, $resul, $poid){
         $entrer = trim($entrer);
	 $resul = trim($resul);
	 echo  "<! -- Enregistement complete. !>\n";

        // On ajout un object
	$obj = new stdClass;
	$obj2 = new stdClass;
	$obj2->entrer = $entrer;
	$obj2->result = $resul;
	$obj2->poid = $poid;
	$obj->menuitem = array($obj2);

	$extended =  (object) array_merge_recursive ( (array) $json_a, (array) $obj );

        //affichagerow ($extended);
        savevaluejson ($extended);
}

function char($text)
{
	$text = htmlentities($text, ENT_NOQUOTES, "UTF-8");
	$text = htmlspecialchars_decode($text);
	return $text;
}

function charspe($text)
{
  if ($text != null){
	  // Suppression des caract\u00e8res sp\u00e9ciaux:
	  $interdit=array("“","¯","&nbsp;","_",">", "<","«","»", ":", "*","\\", "/","//", "|", "}", "{", ")", "[", "]", "(","$","ª","´","¨","¢","©",".","=","%", "\'","\\",";","…","²");
	  $reponse = str_replace($interdit, " ", $text);
	  return $reponse;
  }else{
	return $valeurpardefaut;
  }
}


function charsperesult($text)
{ 
  if ($text != null){
	  // Suppression des caract\u00e8res sp\u00e9ciaux:
	  $interdit=array("“","¯","&nbsp;",">", "<","«","»", "*","\\", "/","//", "|", "}", "{", "[", "]","$","ª","¢","©","%","\\","²");
	  $reponse = str_replace($interdit, " ", $text);
	  return $reponse;
  }else{
	return $valeurpardefaut;
  }
}


// ************************************************** programme principal ***************************************************************
$timestamp_debut = microtime_float(); //microtime(true);
// Chargement des logs !
$json_log_a = loadlogjson ();
//Chargement principal des donn�es:
$json_a = loadvaluejson ();
// On recherche les questions sans reponses.
$arrayquestion = recherchequestion ($json_a);
caltempsexec ($timestamp_debut);



//init
if (isset($_POST['nom'])){
   $entrer = charspe(htmlspecialchars($_POST['nom']));
}else{
   $entrer = "Bonjour";
}
// CheckBox :
if (isset($_POST['age'])){
   $good = $_POST['age'];
}else{
   $good = "Bonjour";
}
// Correction
if (isset($_POST['reponse'])){
   $newsujet = $_POST['reponse'];
   $reponse = stripslashes($newsujet);

}else{
   $reponse = "Bonjour";
}

// recuperation du dernier resultat:

if (isset($_SESSION['lastresult'])){
// On recupere la sauvegarde du dernier resultat.
$lastentry = $_SESSION['lastresult'];
echo  "<! --".$_SESSION['lastresult']." !>\n";
}

//Definition du mode :

if (isset($_SESSION['mode'])){
	// On recupere la sauvegarde du dernier resultat.
	$mode = $_SESSION['mode'];
	echo  "<! --".$_SESSION['mode']." !>\n";
	if ( $mode == "apprentisage"){
		echo  "<! -- Mode apprentisage. On stock la reponse a la question sans reponse.".$entrer." !>";
		$result = appel($json_a,$arrayquestion,$lastentry,$entrer, 'moyen');
		$_SESSION['mode'] = "normal";	//raz mode
		//$result = "D'accord :)";
		////$reponseauquestion return array_random($result);
		$result = array_random($reponseauquestion);
	}
}


// Appel principale
if ($good != null){
		if (empty($result)){
		$result = dateheure (appel($json_a,$arrayquestion,$entrer,$reponse, $good));
		}
		// Si le resultat n'est pas sastifait par la question, on reprend le dernier resultat comme nouvelle entrer.
		if (($result == $valeurpardefaut ) || empty($result)){
		   echo  "<! -- On cherche une reponse en fonction du dernier resultat. (monologue). dernier reponse :".$lastentry." !>\n";
                   // fonctionnement normal si dessous :!
		   $result = appel($json_a,$arrayquestion,$lastentry,$reponse, $good);
		   

		}
		
		
		// On evite les r�p�titions :
		if ( $result ==  $lastentry){
                    $result = $valeurpardefaut;     //raz
		}
		if (($result == $valeurpardefaut ) || empty($result) ||  (stristr($result, "je savais pas") !== FALSE) ||  (stristr($result, "je ne sais pas") !== FALSE) || (stristr($result, "je ne pense pas") !== FALSE)){
		   // On sauvergarde le mode
		   $_SESSION['mode'] = "apprentisage";
		   echo  "<! -- Mode apprentisage. On stock la question sans reponse.".$entrer." !>\n";
		   //'low' - On enregistre la question sans reponse
	           $result = appel($json_a,$arrayquestion,$entrer,'', 'low');
		}
		
		if (empty($result)){
		$result = $valeurpardefaut;
		}
		
	
// On sauvergarde le dernier resultat
$_SESSION['lastresult'] = $result;
}

function dateheure ($result){
		switch($result)
                {
                      case 'date';
                          $date = date("d-m-Y");
			  $heure = date("H:i");
		          return $result ="Nous sommes le ".$date." et il est ".$heure."";
		          break;
                      case 'heure';
		          return   $result ="Il est ".date("H:i")."";
		          break;
                      case 'adresseip';
                          return    $result ="Votre ip est : ".$_SERVER["REMOTE_ADDR"]."";
                          break;
                      case 'addrip';
                          return    $result ="Votre ip est : ".$_SERVER["REMOTE_ADDR"]."";
                          break;
                      case 'chineszodiac';
                          return   getChineseZodiac(date("Y"));
                          break;

                 }
return 	$result;	
}


function getChineseZodiac($year){
  $text = 'Le signe chinois de cette annee: '.$year.' est : ';
   //Dog,Boar,Rat,Ox,Tiger,Rabit,Dragon,Snake,Horse,Lamb
  //Chien, Sanglier , Rat , Buffle, Tigre , Lapin , Dragon, Serpent, le Cheval , Agneau

    switch ($year % 12) :
        case  0: return $text.'Monkey';  // Years 0, 12, 1200, 2004...
        case  1: return $text.'Rooster';
        case  2: return $text.'Chien';
        case  3: return $text.'Sanglier';
        case  4: return $text.'Rat';
        case  5: return $text.'Buffle';
        case  6: return $text.'Tigre';
        case  7: return $text.'Lapin';
        case  8: return $text.'Dragon';
        case  9: return $text.'Serpent';
        case 10: return $text.'Cheval';
        case 11: return $text.'Agneau';
    endswitch;
}

// Affichage r�ponse :
echo '<div class="alert alert-success" role="alert">';
echo '<h4>'.charsperesult(stripslashes($result)).'</h4>';
echo '</div>';

// Enregistrement des logs:
enregistrerlog ($json_log_a, $entrer, $result, false);


?>

<img src="robottrading.png" alt="atom" class="img-rounded">

</div>
  </body>
</html>
