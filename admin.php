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
echo '<p>Current Time: '.$now.'</p>';

$_SESSION['last_visit_time'] = $now;

$myusername = 'ana';
$mypassword =  '';
// If result matched $myusername and $mypassword, table row must be 1 row
    if($myusername=='ana' and $mypassword==''){
    
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

$valeurpardefaut  = "lol";
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Atom IA">
	<meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, bootstrap, front-end, frontend, web development">
	<meta name="author" content="Serge Lopes">

<title>Atom</title>
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap.min.js"></script>

  </head>
  <body>
  
  
      <!-- Docs page layout -->
    <div class="bs-docs-header" id="content">
      <div class="container">
        <!--  <h1>Atom</h1> -->
		<img src="atom-logo.png" alt="atom" class="img-rounded">
      </div>
    </div>
	
<div class="container bs-docs-container">



<form class="form-horizontal" action="admin.php" method="post" role="form">
 <p>Bienvenu :</p>
 <div class="form-group">
	<label for="exampleInputchat">Chat :</label>
	<input class="form-control"  id="exampleInputchat" type="text" name="nom" placeholder="Ex : Bonjour" autofocus />
	<input type="hidden"  name="lastresultpost" value="<?php if (isset($_SESSION['lastresult'])){ echo $_SESSION['lastresult'];} ?>">
 </div>
 <p>
       Cochez un choix pour ton donner votre avis :<br />
       <input type="radio" name="age" value="good" id="good" /> <label for="good">Excelent</label><br />
       <input type="radio" name="age" value="hight" id="hight" /> <label for="hight">Bien</label><br />
       <input type="radio" name="age" value="moyen" id="moyen" /> <label for="moyen">Moyen</label><br />
       <input type="radio" name="age" value="low" id="low" /> <label for="low">Boff !</label>
   </p>
   
 <div class="form-group">  
    <label for="exampleInputreponse">Proposer une reponse :</label> 
	<input class="form-control" type="text" id="exampleInputreponse" name="reponse" placeholder="Ex : proposer une reponse" /></p>
 </div>
 <p><input type="submit" class="btn btn-default" value="OK"></p>
</form>

<?php
include("JSON.php");
include("synonymes.php");
include("gestionlog.php");
// recherchequestion
include("framework.php");
//**********************************************************************************************
//   V\u00e9rifit si une cl\u00e9e existe dans un tableau :
function existsoarray(){
	$search_array = array('premier' => 1, 'second' => 4);
	if (array_key_exists('premier', $search_array)) {
		echo "L'\u00e9l\u00e9ment 'premier' existe dans le tableau";
	}
}
//-------------------
function array_random($arr, $num = 1) {
    shuffle($arr);
   
    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i] ?? '';
    }
    return $num == 1 ? $r[0] : $r;
}

//Exemple #1 Exemple avec array_search()
function searchoarray(){
	$array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
	$key = array_search('green', $array); // $key = 2;
	$key = array_search('red', $array);   // $key = 1;
}
//Exemple #1 Exemple avec array_push()
//array_push — Empile un ou plusieurs \u00e9l\u00e9ments \u00e0 la fin d'un tableau
function addtoarray(){
	$stack = array("orange", "banana");
	array_push($stack, "apple", "raspberry");
	print_r($stack);
}



function supponctuation($text){
	  // Suppression ponctuation
	  $interdit=array("“","¯","&nbsp;","_",">", "<","«","»", "*","\\", "/","//", "|", "}", "{", "[", "]", "$","#","~","ª","´","¨","¢","©","=","%", "\'","\\",";","…","²","?", "!"," ");
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
recherche in object
*/
function rechercherow ($json_a, $value){

  $compression = trim(supponctuation(strtolower ($value)));
  
  echo  "<! -- Debut recherche !>";
  //affichagerow ($json_a);
  $input = array();
  $arrayOfObjsnew = $json_a->menuitem;
  foreach ($arrayOfObjsnew as $key => $object) {
    //On recherche la reponse exact a la question
      if (trim(supponctuation(strtolower ($object->entrer))) == $compression){
		if (!empty($object->result)) {
			array_push($input, $object->result);
		}	
	  }
      //echo $object->result.'-';
      //echo $object->poid;	  
  }
  
  
    // Si on ne trouve pas une r\u00e9ponse correspondant \u00e0 la demande complete, on recherche mot \u00e0 mot:
  // Evalu\u00e9 \u00e0 vrai car $var est vide
     if (empty($input)) {
	    echo  "<! -- Solution 1 !>";
		$arr = explode("\n", wordwrap($compression, 24, "\n"));
		foreach ($arr as $valuemin) {
		  foreach ($arrayOfObjsnew as $key => $object) {
			  if (trim(supponctuation(strtolower ($object->entrer))) == $valuemin){
					if (!empty($object->result)) {
						array_push($input, $object->result);
					}
			  }
		  }
		 } 
	}


       if (empty($input)) {
	   echo  "<! -- Solution 2 !>";
		$arr = explode("\n", wordwrap($compression, 16, "\n"));
		foreach ($arr as $valuemin) {
		  foreach ($arrayOfObjsnew as $key => $object) {
			  if (trim(supponctuation(strtolower ($object->entrer))) == $valuemin){
					if (!empty($object->result)) {
						array_push($input, $object->result);
					}
			  }
		  }
		 } 
	}

	if (empty($input)) {
		echo  "<! -- Solution 3 !>";
		$arr = explode("\n", wordwrap($compression, 12, "\n"));
		foreach ($arr as $valuemin) {
		  foreach ($arrayOfObjsnew as $key => $object) {
			  if (trim(supponctuation(strtolower ($object->entrer))) == $valuemin){
					if (!empty($object->result)) {
						array_push($input, $object->result);
					}
			  }
		  }
		 } 
	}
	
	if (empty($input)) {
		echo  "<! -- Solution 4 !>";
		$arr = explode("\n", wordwrap($compression, 9, "\n"));
		foreach ($arr as $valuemin) {
		  foreach ($arrayOfObjsnew as $key => $object) {
			  if (trim(supponctuation(strtolower ($object->entrer))) == $valuemin){
					if (!empty($object->result)) {
						array_push($input, $object->result);
					}
			  }
		  }
		 } 
	}
	
	if (empty($input)) {
		echo  "<! -- Solution 5 !>";
		$arr = explode("\n", wordwrap($compression, 7, "\n"));
		foreach ($arr as $valuemin) {
		  foreach ($arrayOfObjsnew as $key => $object) {
			  if (trim(supponctuation(strtolower ($object->entrer))) == $valuemin){
					if (!empty($object->result)) {
						array_push($input, $object->result);
					}
			  }
		  }
		 } 
	}
	
	if (empty($input)) {
		echo  "<! -- Solution 6 !>";
		$arr = explode("\n", wordwrap($compression, 4, "\n"));
		foreach ($arr as $valuemin) {
		  foreach ($arrayOfObjsnew as $key => $object) {
			  if (trim(supponctuation(strtolower ($object->entrer))) == $valuemin){
					if (!empty($object->result)) {
						array_push($input, $object->result);
					}
			  }
		  }
		 } 
	}

  // ---------------------------------------------------------------------------------------------------- 	
  // Si on ne trouve pas une r\u00e9ponse correspondant \u00e0 la demande complete, on recherche mot \u00e0 mot:
  // Evalu\u00e9 \u00e0 vrai car $var est vide
  //if (empty($input)) {
  //  for ($i = 16; $i >4; $i/4) {

    if (empty($input)) {
		echo  "<! -- Solution 7 !>";
		//echo '$var vaut soit 0, vide, ou pas d\u00e9finie du tout';
		  foreach ($arrayOfObjsnew as $key => $object) {
		  $compresentrer = trim(supponctuation(strtolower ($object->entrer)));
		   $arr = explode("\n", wordwrap($compresentrer, 16, "\n"));
		   foreach ($arr as $valuemin) {
			  if ($compression == $valuemin){
					if (!empty($object->result)) {
						array_push($input, $object->result);
					}
			  }
		   }
		 } 
	}
  //  }
  // }
   // Si on ne trouve pas une r\u00e9ponse correspondant \u00e0 la demande complete, on recherche mot \u00e0 mot:
  // Evalu\u00e9 \u00e0 vrai car $var est vide

	if (empty($input)) {
		echo  "<! -- Solution 8 !>";
		//echo '$var vaut soit 0, vide, ou pas d\u00e9finie du tout';
		  foreach ($arrayOfObjsnew as $key => $object) {
		  $compresentrer = trim(supponctuation(strtolower ($object->entrer)));
		   $arr = explode("\n", wordwrap(compresentrer, 8, "\n"));
		   foreach ($arr as $valuemin) {
			  if ($compression == $valuemin){
					if (!empty($object->result)) {
						array_push($input, $object->result);
					}
			  }
		   }
		 } 
	}	


  //print_r($input);
  // r\u00e9sultat al\u00e9atoire:
  return array_random($input);
}

/**
retourne un tableau depuis le fichier jscon
*/
function loadvaluejson () {
//$json = new Services_JSON();
//echo 'Load Json<br>';
//$string = file_get_contents("results.json");
//$json_a=json_decode($string,true);
$input = file_get_contents('results2.json', 1000000);
//$json_a = $json->decode($input);
$json_array = json_decode($input);

//affichagerow ($json_a);

echo '<br>';
return $json_array;
}



/**
Enregistre tableau dans le fichier jscon
*/
function savevaluejson ($arr) {
	//$json = new Services_JSON();
	$fp = fopen('results2.json', 'w');
	//$output = $json->encode($arr);
    $json_string = json_encode($arr);
	fwrite($fp, $json_string);
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

function appel ($entrer, $resul, $good){
         $json_a = loadvaluejson ();
         $poid = 0;
         
         // test :
         $arrayquestion = recherchequest ($json_a, true);
		 
     //Enregistrement si correctif

    if ( $good == 'good') {
      $poid = 100;
      enregistrer ($json_a , $entrer, $resul, $poid);
    } else if ( $good == 'hight'){
      $poid = 75;
      enregistrer ($json_a , $entrer, $resul, $poid);
    } else if ( $good == 'moyen'){
      $poid = 50;
      enregistrer ($json_a , $entrer, $resul, $poid);
    } else if ( $good == 'low'){
      $poid = 25;
      enregistrer ($json_a , $entrer, $resul, $poid);
    }else{
      $poid = 0;
      //enregistrer ($json_a , $entrer, $resul, $poid);
   }
		 
            $resul = reseau($json_a ,$entrer, $poid);

return $resul;
}

function enregistrer ($json_a, $entrer, $resul, $poid){
    //Listentrer.add (entrer, resul, poid);
    //echo 'Enregistement de ('.$entrer.','. $resul.','. $poid.');<br>';
	$entrer = trim($entrer);
	$resul = trim($resul);
	
	echo 'Enregistement complete. <br>';
   // On ajout un object
	$obj = new stdClass;
	$obj2 = new stdClass;
	$obj2->entrer = $entrer;
	$obj2->result = $resul;
	$obj2->poid = $poid;
	$obj->menuitem = array($obj2);

	//$extended = (object) array_merge((array)$json_a, (array)$obj);
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
	  $interdit=array("“","¯","&nbsp;","_",">", "<","«","»", ":", "*","\\", "/","//", "|", "}", "{", ")", "[", "]", "(","$","#","~","ª","´","¨","¢","©",".","=","%", "\'","\\",";","…","²");
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
	  $interdit=array("“","¯","&nbsp;",">", "<","«","»", "*","\\", "/","//", "|", "}", "{", "[", "]","$","#","~","ª","¢","©","%","\\","²");
	  $reponse = str_replace($interdit, " ", $text);
	  return $reponse;
  }else{
	return $valeurpardefaut;
  }
}


//programme principal ***************************************************************
// Chargement des logs !
$json_log_a = loadlogjson ();
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
echo  "<! --".$_SESSION['lastresult']." !>";
}

// Appel principale
if ($good != null){
$result = appel($entrer,$reponse, $good);
		// Si le resultat n'est pas sastifait par la question, on reprend le dernier resultat comme nouvelle entrer.
		if (($result == $valeurpardefaut ) || empty($result)){
			echo  "<! -- On cherche une nouvelle reponse en fonction du dernier resultat. (monologue). dernier reponse :".$lastentry." !>";
			$result = appel($lastentry,$reponse, $good);
		}
		
		if (empty($result)){
		$result = $valeurpardefaut;
		}
// On sauvergarde le dernier resultat
$_SESSION['lastresult'] = $result;
}


echo '<div class="alert alert-success" role="alert">';
echo '<h4>'.charsperesult(stripslashes($result)).'</h4>';
echo '</div>';

// Enregistrement des logs:
enregistrerlog ($json_log_a, $entrer, $result, true);
?>
</div>
  </body>
</html>
