<form action="print.php" method="post">
 <p>Rechercher: <input type="text" name="nom" /></p>
 <p><input type="submit" value="OK"></p>
</form>

<a href="http://www.plafond-tendu.net/atom/print.php?action=print">

    Afficher liste.

</a>
<?php

/* http://www.plafond-tendu.net/atom/print.php?action=recherche&q=mot
*/
$filename = 'tagliste.v2';      // pour créer une nouvelle liste changer le nom ici.
$action = $_GET['action'];
$index = $_GET['q'];

if (htmlspecialchars($_POST['nom']) != null){
$index = htmlspecialchars($_POST['nom']);
$action = 'recherche';
}

if ($action == 'recherche' && $filename != null){
	$somecontent = jecherche($index,$filename);
}else{
	if ($action == 'print'){
		$somecontent = generation('',$filename);
	}
}


function multiexplode ($delimiters,$string) {
   
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}



function jecherche ($text,$filename) {

  echo 'Chargement du fichier: '.$filename;
  // On récupère la liste actuel:
  $html = file_get_contents($filename);

  // suppression des chiffres
  $testexplode =ereg_replace("[0-9]","",$html);
  //Suppression saut de ligne
  $testexplode = strtr($testexplode, "\r\n\t\s", ",,,,");
  // Création du tableau des valeurs:   entre 15 et 35
  $testexplode = wordwrap($testexplode, 20, ",", false);
  $keywords = multiexplode(array(",",".","|",":"," ","~"),$testexplode);

  // suppression des valeurs null
  $keywords = array_filter($keywords);
  //--------------------------------------------------------------------------------------------------------------  
  echo '<br>'.'Nombre de mots actuellement connus: '.count($keywords).'<br>';
  // filtre des doublons
  $keywords = array_unique($keywords);
  
	$key = array_search(strtolower($text),array_map('strtolower',$keywords)); 

//$key = array_search($text, $keywords); // $key = 2;

echo '<br>';

if ($key == null){
	echo 'valeur inconnu'.'<br>';
}else{
	echo $keywords[$key].'<br>';
	echo 'valeur connu'.'<br>';
	print_r ($key);
	
}


  
return $key;

}

 


// *******************************************************************************************************************************
// *******************************************************************************************************************************
// Rechercher sur Spin
function SpinSearch($txt, $rechercher){

    function filter_by_value ($array, $value){
        if(is_array($array) && count($array)>0) 
        {
           $keynew =0;
            foreach(array_keys($array) as $key){
                $temp[$key] = $array[$key];
                //$regx = '/'.$rechercher.'/';
                // if (preg_match($regx,$keywords)){
                if (stristr($temp[$key], $value)){
                    $newarray[$keynew] = $array[$key];
                    $keynew = $keynew+1;
                }
            }
          }
      return $newarray;
    }


$pattern = '#\{([^{}]*)\}#msi';
$test = preg_match_all($pattern, $txt, $out);

$toFind = Array();
$toReplace = Array();

foreach($out[0] AS $id => $match){
$choices = explode("~", $out[1][$id]);
// On filtre la liste de valeur:
$choices = filter_by_value($choices,$rechercher);
ksort($choices);
//$choices = array_filter($choices ,'is_string');
//print_r ($choices);
//echo "<br>";
$toFind[]=$match;
$toReplace[]=trim($choices[rand(0, count($choices)-1)]);

}

return str_replace($toFind, $toReplace, $txt);
}

// Cette fonction permet de remplacer automatique du text en fonction des mots proposés en remplacement.
function Spin($txt){

$pattern = '#\{([^{}]*)\}#msi';
$test = preg_match_all($pattern, $txt, $out);

$toFind = Array();
$toReplace = Array();

foreach($out[0] AS $id => $match){
$choices = explode("~", $out[1][$id]);
$toFind[]=$match;
$toReplace[]=trim($choices[rand(0, count($choices)-1)]);
}

return str_replace($toFind, $toReplace, $txt);
}

   // ON EXCULS LES VALEURS NON DESIRER:
function valeurExclu ($element) {
   $retour = true;
   //Liste des mots exclus
   $regex = "#luxtend|waitloading|Ã|adsense|hover|showdlg|showfullscreenset|ebay|autoclose|barrisol|maxeftv|musikprojektes|calvados|ii|displaymodefull|paylantint|topbarkeywords|preload|trackpageview|mouseover|www|clipso|copyright|enabledefaults|myform|bruno|function|ready|doctype|tooltip|var|newmat|simcity|cscript|javascript|script|pagetracker|gettracker|trackpageviewsetaccount|setdomainname|trackpageloadtime|loadingtime|gettime#";
   if (preg_match($regex,$element)){
   $retour = False;
   }
   
   //Régle des mots composés
   //#^guitare# 	La chaîne doit commencer par "-"
   if (preg_match("#^-#",$element)){
   $retour = False;
   }
    //#guitare$# 	La chaîne ne doit pas se terminer par "-"
   if (preg_match("#-$#",$element)){
   $retour = False;
   }
   // suppression des valeurs inférieur à 3 caractères
   //if (strlen($element)-   substr_count($element, ' ') <= 2){
   if (strlen(utf8_decode($element))<= 5){
   $retour = False;
   }
   // On compte le nombre de blanc:  si suppérieurs à 4. On exclus la valeur.
   $test = explode(' ', $element);
   if (count($test)>= 4){
   $retour = False;
   }

   //suppression des valeur suppérieur à 35 max: anticonstitutionnellement
    if (strlen(utf8_decode($element))>= 35){
   $retour = False;
   }
   return $retour;
}

function antispamtexte($texte){
    $retour = True;
    $nombres_de_lettes_max = 3;
    // les consonnes
    $consonnes = array("b","c","d","f","g","h","j","k","m","n",
                       "p","q","r","s","t","v","w","x","z");
    // les voyelles
    $voyelles  = array("a","e","i","o","u","y");
    // les exceptions en 4 lettres (comme le $nombres_de_lettes_max)
    $exceptions = array("http","aaaa","uuuu");

    // votre texte
    /*
    $texte = "hello worrrrrdddd come to seeeee myyyy webtrhdtgrbvx
              aaaaaat  http://www.helloword.com siiiiite";      */

    // variables
    $i=0; $v=0; $c=0; $stock_consonne='';$stock_voyelle='';

    while ($i<=strlen($texte)) {
    // on sauvegarde le contenu de last_var pour refaire une comparaison
    $last_var_sub = $last_var;
    // on gere les consonnes
    if (in_array($texte[$i],$consonnes))
        {$stock_consonne .= $texte[$i]; $i++;$c++;$last_var='consonne';}
    // on gere les voyelles
    elseif (in_array($texte[$i],$voyelles))
            {$stock_voyelle .= $texte[$i]; $i++; $v++; $last_var='voyelles';}
    // si c'est un caratere autre on met tout a zero
    else{$v=0;$c=0;$i++;$stock_consonne=''; $stock_voyelle='';}
    // test sur les egalités
    if ($c==$nombres_de_lettes_max) {
                                    if (!in_array($stock_consonne,$exceptions))
                                    //echo 'spam consonne -> '.$stock_consonne.'<br />';
                                    $retour = false;
                                    $v=0;$c=0;$stock_consonne='';
                                         }
    if ($v==$nombres_de_lettes_max) {
                                    if (!in_array($stock_voyelle,$exceptions))
                                    //echo 'spam voyelle -> '.$stock_voyelle.'<br />';
                                    $retour = false;
                                    $v=0;$c=0;$stock_voyelle='';
                                          }
    // si la lettre est differente on reinitialise
    if ($last_var_sub != $last_var)
    {$v=0;$c=0; $stock_consonne=''; $stock_voyelle='';}
    }
 return $retour;
}


// *******************************************************************************************************************************







function generation ($aCharger,$filename) {
  
  echo 'Chargement du fichier: '.$filename;
  // On récupère la liste actuel:
  $html = file_get_contents($filename);

  $url = '';
  if  ($aCharger != '' && $aCharger != null){
 // On charge l'url à traiter:
       if( false == ($str=file_get_contents((string)$aCharger))){
           echo 'Erreur de chargement :'.$aCharger.'\r\n';
           return null;
      }else{
            echo 'On charge :'.$aCharger.'<br>';
            $html =  $html.$str;
      }
  }


  // On lance les regex
  // 1- On vire le code entre <head> et </head> qui contient en général tout les trucs qui ne nous intéressent pas ici (feuille de style, javascript...)
  // 2- On vire le javascript pour éviter les bugs au cas ou une partie nous aurait échappée
  // 3- On vire les attributs de style pour les mêmes raisons
  $html = preg_replace('`<head.*?/head>`', '', $html);
  $html = preg_replace('`<script.*?/script>`', '', $html);
  $html = preg_replace('`<style.*?/style>`', '', $html);

  // ON CHARGE L ENSEMBLE DE LA PAGE A SCANNER PUIS ON SUPPRIMER TOUT LES CHARACTERES INDESIRABLES:
  // suppression des commentaires:    Récupération uniquement des balises html connu:
  $allow = '<p><a><ul><li><b><strong><td>';
  $html = strip_tags($html, $allow);


  // Remplacement des caractères html pure:
  $html = html_entity_decode($html);
  //replace MS special characters first
  $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
  $replace = array('\'', '\'', '"', '"', '-');
  $html = preg_replace($search, $replace, $html);

  // remplacement des caractères spéciaux:
  $modif = array("®","‰","@","+","&","™","§","€","!");
  $amodif = array(" "," "," "," "," "," "," "," "," ");
  $newsujet = str_replace($modif,$amodif,$html);

  
  // to en minuscul -------- et prise en charge des caractères html
  $newsujet = strtolower ($newsujet);
  // Flitrage complexe
  $newsujet =strtr(trim(strip_tags($newsujet)), array_flip(get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES)));

  // Suppression des caractères spéciaux:
  $interdit=array("“","¯","Â","&nbsp;","_",">", "<","«","»", ":", "*","\\", "/", "|", "?", "}", "{", ")", "[", "]", "(","$","#","~","ª","´","¨","¢","©",".","=","%", "\"",";","…","²");
  //$interdit=array("“","¯","Â","&nbsp;","_",">", "<","«","»", ":", "*","\\", "/", "|", "?", "}", "{", ")", "[", "]", "(","$","#","~","ª","´","¨","¢","©",".","=","'","%", "\"",";","…","²");
  $new_array = str_replace($interdit, " ", $newsujet);
  //------------------------------------------------------------------------------------------------------------
  $testexplode =$new_array;
  // suppression des chiffres
  $testexplode =ereg_replace("[0-9]","",$testexplode);
  //Suppression saut de ligne
  $testexplode = strtr($testexplode, "\r\n\t\s", ",,,,");
  // Création du tableau des valeurs:   entre 15 et 35
  $testexplode = wordwrap($testexplode, 20, ",", false);

  $keywords = explode(",", $testexplode);
  // suppression des valeurs null
  $keywords = array_filter($keywords);
  //--------------------------------------------------------------------------------------------------------------
  $keywords = array_values(array_filter($keywords, "antispamtexte"));
  $keywords = array_values(array_filter($keywords, "valeurExclu"));
  // filtre des doublons
  $keywords = array_unique($keywords);
  // tri des réponses
  //$keywords = ksort($keywords);
  // méclange d'un tableau
  shuffle($keywords);
  
  //******************** Affichage résultat ***********************************
  //Compte tous les éléments d'un tableau ou quelque chose d'un objet.
  
  echo 'Nombre de mots actuellement connus: '.count($keywords).'<br>';
  
  //print_r ($keywords);
  
  $valspin= "{";
  foreach ($keywords as $value) {
    // trim suppression des espaces à droite et à gauche
      $valspin.= trim(strtr($value," &nbsp",""))."~";
  }
  $valspin.= "Plafond}";
  
  //echo $valspin;
  //****************************************************************************
  echo 'Controle Spint - Nouveau mots au hazard: '.Spin($valspin).'<br>';
  echo 'On recherche la valeur Spint: '.SpinSearch($valspin, 'plafond').'<br>';
  //echo 'Liste complête de mots : '.$valspin.'<br>';
  return $valspin;
  
  }
  
  ?>