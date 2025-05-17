
<?php

   // ON EXCULS LES VALEURS NON DESIRER:
function valeurExclu ($element) {
   $retour = true;
   //Liste des mots exclus
   $regex = "#luxtend|waitloading|�|adsense|hover|showdlg|showfullscreenset|ebay|autoclose|barrisol|maxeftv|musikprojektes|calvados|ii|displaymodefull|paylantint|topbarkeywords|preload|trackpageview|mouseover|www|clipso|copyright|enabledefaults|myform|bruno|function|ready|doctype|tooltip|var|newmat|simcity|cscript|javascript|script|pagetracker|gettracker|trackpageviewsetaccount|setdomainname|trackpageloadtime|loadingtime|gettime#";
   if (preg_match($regex,$element)){
   $retour = False;
   }
   
   //R�gle des mots compos�s
   //#^guitare# 	La cha�ne doit commencer par "-"
   if (preg_match("#^-#",$element)){
   $retour = False;
   }
    //#guitare$# 	La cha�ne ne doit pas se terminer par "-"
   if (preg_match("#-$#",$element)){
   $retour = False;
   }
   // suppression des valeurs inf�rieur � 3 caract�res
   //if (strlen($element)-   substr_count($element, ' ') <= 2){
   if (strlen(utf8_decode($element))<= 5){
   $retour = False;
   }
   // On compte le nombre de blanc:  si supp�rieurs � 4. On exclus la valeur.
   $test = explode(' ', $element);
   if (count($test)>= 4){
   $retour = False;
   }

   //suppression des valeur supp�rieur � 35 max: anticonstitutionnellement
    if (strlen(utf8_decode($element))>= 35){
   $retour = False;
   }
   return $retour;
}

function Writefile($filename, $somecontent)
{
// Assurons nous que le fichier est accessible en �criture
if (is_writable($filename)) {

  //'a'  	 Ouvre en �criture seule ; place le pointeur de fichier � la fin du fichier. Si le fichier n'existe pas, on tente de le cr�er.
  //'r'  	 Ouvre en lecture seule, et place le pointeur de fichier au d�but du fichier.
  //'w'  	 Ouvre en �criture seule ; place le pointeur de fichier au d�but du fichier et r�duit la taille du fichier � 0. Si le fichier n'existe pas, on tente de le cr�er.

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est plac� � la fin du fichier
    // c'est l� que $somecontent sera plac�
    if (!$handle = fopen($filename, 'w')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Impossible d'�crire dans le fichier ($filename)";
        exit;
    }

    //echo "L'�criture de ($somecontent) dans le fichier ($filename) a r�ussi.\r\n";
    echo "L'�criture dans le fichier ($filename) a r�ussi.\r\n";

    fclose($handle);
    return True;
} else {
    echo "Le fichier $filename n'est pas accessible en �criture.";
}
}


function http_response($url, $status = null, $wait = 3)
{
        $time = microtime(true);
        $expire = $time + $wait;
        
        
        if (! function_exists('pcntl_fork')) die('PCNTL functions not available on this PHP installation');

        // we fork the process so we don't have to wait for a timeout
        $pid = pcntl_fork();
        if ($pid == -1) {
            die('could not fork');
        } else if ($pid) {
            // we are the parent
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $head = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
           
            if(!$head)
            {
                return FALSE;
            }
           
            if($status === null)
            {
                if($httpCode < 400)
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
            elseif($status == $httpCode)
            {
                return TRUE;
            }
           
            return FALSE;
            pcntl_wait($status); //Protect against Zombie children
        } else {
            // we are the child
            while(microtime(true) < $expire)
            {
            sleep(0.5);
            }
            return FALSE;
        }
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
    // test sur les egalit�s
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
//for case insensitive array_search you could use:
function array_search_i($str,$array){
    foreach($array as $key => $value) {
        if(stristr($str,$value)) return $key;
    }
    return false;
}
// *******************************************************************************************************************************
// Cette fonction permet de remplacer automatique du text en fonction des mots propos�s en remplacement.
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
// *******************************************************************************************************************************
function normaliza ($string){
    $a = '�������������������������������
��������������������������������Rr';
    $b = 'zaaaaaaac����ii��dnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $string = utf8_decode($string);    
    $string = strtr($string, utf8_decode($a), $b);
    $string = strtolower($string);
    return utf8_encode($string);
}
// *******************************************************************************************************************************

function normalization ($string){
  // Detection automatique et convertion de text au format ISO:
  return  mb_detect_encoding($string, "auto");
}


function curPageURL() {
$pageURL = 'http';
if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else {
$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}
return $pageURL;
}

  function filtrage_url ($element) {
   $retour = true;
   //La cha�ne ne doit pas commencer par ":"
   if (preg_match("#^:#",$element)){
   $retour = False;
   }
   // suppression des valeurs inf�rieur � 5 caract�res
   if (strlen(utf8_decode($element))<= 5){
   $retour = False;
   }
   return $retour;
  }
//--------------------------------------------------------------------------------------------------------
//********************************************************************************************************
//$sitemap = file_get_contents('prodecobt.lm');
//$contenu = file_get_contents('listesite.lm');
//$contenu = file_get_contents('prodecobt.lm');
//$contenu = file_get_contents('google.lm');

$contenu = file_get_contents('wiki1.lm');
 
$contenu = str_replace(CHR(13),'~',$contenu);
$contenu= str_replace(CHR(10),'~',$contenu);
///Suppression saut de ligne
$contenu = strtr($contenu, " \r\n\t\s", "~");
$contenu = str_replace("http:","~http:",$contenu);
$siteliste = array_map('trim',explode("~",$contenu));
$siteliste = array_values(array_filter($siteliste, "filtrage_url"));
// suppression des valeurs null
$siteliste = array_filter($siteliste);

//echo curPageURL();  // Permet de r�cup�rer l'url de la page
echo 'Nbre de page total:'.count($siteliste).'<br>';
//exit;


$filename = 'tagliste.v2';      // pour cr�er une nouvelle liste changer le nom ici.

function generation ($aCharger,$filename) {
  
 /*
  if (http_response((string)$aCharger)){
  // url ok
  echo 'Url OK :'.$aCharger.'<br>';
  }else{
  return null;
  }
 */
  // On r�cup�re la liste actuel:
  $html = file_get_contents($filename);

  $url = '';
  if  ($aCharger != '' && $aCharger != null){
 // On charge l'url � traiter:
       if( false == ($str=file_get_contents((string)$aCharger))){
           echo 'Erreur de chargement :'.$aCharger.'\r\n';
           return null;
      }else{
            echo 'On charge :'.$aCharger.'<br>';
            //$html =  $html.normaliza ($str);
            $html =  $html.$str;
      }
  }


  // On lance les regex
  // 1- On vire le code entre <head> et </head> qui contient en g�n�ral tout les trucs qui ne nous int�ressent pas ici (feuille de style, javascript...)
  // 2- On vire le javascript pour �viter les bugs au cas ou une partie nous aurait �chapp�e
  // 3- On vire les attributs de style pour les m�mes raisons
  $html = preg_replace('`<head.*?/head>`', '', $html);
  $html = preg_replace('`<script.*?/script>`', '', $html);
  $html = preg_replace('`<style.*?/style>`', '', $html);

  // ON CHARGE L ENSEMBLE DE LA PAGE A SCANNER PUIS ON SUPPRIMER TOUT LES CHARACTERES INDESIRABLES:
  // suppression des commentaires:    R�cup�ration uniquement des balises html connu:
  $allow = '<p><a><ul><li><b><strong><td>';
  $html = strip_tags($html, $allow);
  $html =  $html.normalization ($html);

  // Remplacement des caract�res html pure:
  $html = html_entity_decode($html);
  //replace MS special characters first
  $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
  $replace = array('\'', '\'', '"', '"', '-');
  $html = preg_replace($search, $replace, $html);

  // remplacement des caract�res sp�ciaux:
  $modif = array("�","�","@","+","&","�","�","�","!");
  $amodif = array(" "," "," "," "," "," "," "," "," ");
  $newsujet = str_replace($modif,$amodif,$html);

  
  // to en minuscul -------- et prise en charge des caract�res html
  $newsujet = strtolower ($newsujet);
  // Flitrage complexe
  $newsujet =strtr(trim(strip_tags($newsujet)), array_flip(get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES)));

  // Suppression des caract�res sp�ciaux:
  $interdit=array("�","�","�","&nbsp;","_",">", "<","�","�", ":", "*","\\", "/", "|", "?", "}", "{", ")", "[", "]", "(","$","#","~","�","�","�","�","�",".","=","%", "\"",";","�","�");
  //$interdit=array("�","�","�","&nbsp;","_",">", "<","�","�", ":", "*","\\", "/", "|", "?", "}", "{", ")", "[", "]", "(","$","#","~","�","�","�","�","�",".","=","'","%", "\"",";","�","�");
  $new_array = str_replace($interdit, " ", $newsujet);
  //------------------------------------------------------------------------------------------------------------
  $testexplode =$new_array;
  // suppression des chiffres
  $testexplode =ereg_replace("[0-9]","",$testexplode);
  //Suppression saut de ligne
  $testexplode = strtr($testexplode, "\r\n\t\s", ",,,,");
  // Cr�ation du tableau des valeurs:   entre 15 et 35
  $testexplode = wordwrap($testexplode, 20, ",", false);

  $keywords = explode(",", $testexplode);
  // suppression des valeurs null
  $keywords = array_filter($keywords);
  //--------------------------------------------------------------------------------------------------------------
  $keywords = array_values(array_filter($keywords, "antispamtexte"));
  $keywords = array_values(array_filter($keywords, "valeurExclu"));
  // filtre des doublons
  $keywords = array_unique($keywords);
  // tri des r�ponses
  //$keywords = ksort($keywords);
  // m�clange d'un tableau
  shuffle($keywords);
  
  //******************** Affichage r�sultat ***********************************
  //Compte tous les �l�ments d'un tableau ou quelque chose d'un objet.
  echo 'Nombre de mots actuellement connus: '.count($keywords).'<br>';
  
  $valspin= "{";
  foreach ($keywords as $value) {
    // trim suppression des espaces � droite et � gauche
      $valspin.= trim(strtr($value," &nbsp",""))."~";
  }
  $valspin.= "Plafond}";
  
  //echo $valspin;
  //****************************************************************************
  echo 'Controle Spint - Nouveau mots au hazard: '.Spin($valspin).'<br>';
  echo 'On recherche la valeur Spint: '.SpinSearch($valspin, 'plafond').'<br>';
  //echo 'Liste compl�te de mots : '.$valspin.'<br>';
  return $valspin;
  
  }




//******************************************* G�n�ration automatique *******************************
$action = $_GET['action'];
 if ($siteliste != null && $action == 'generation' && $filename != null){
   
   if (isset($_GET['index'])){
     $index = $_GET['index'];
    }else{
                    

                     $somecontent = generation('',$filename);
                                 if ($somecontent != null){
                                    Writefile($filename, $somecontent);
                                   }
          // Debut g�n�ration.
            echo '<script language="Javascript">
              <!--
              document.location.replace("http://www.plafond-tendu.net/atom/test5.php?action=generation&index=0");
              // -->
              </script>';
              exit;
    }

   if ($index < count($siteliste)){
          if ($siteliste[$index] != null && $siteliste[$index] !=""){

                  $somecontent = generation($siteliste[$index],$filename);
                                 if ($somecontent != null){
                                    if (Writefile($filename, $somecontent) == true ){
                                      $index=$_GET['index']+1;
                                      echo "<br>Location: http://www.plafond-tendu.net/atom/test5.php?action=generation&index=".$index."";
                                      echo '<script language="Javascript">
                                      <!--
                                      document.location.replace("http://www.plafond-tendu.net/atom/test5.php?action=generation&index='.$index.'");
                                      // -->
                                      </script>';
                                      exit;

                                    }
                                   }else{
                                      $index=$_GET['index']+1;
                                      echo "<br>Erreur de chargement de la page pr�c�dente.";
                                      echo "<br>Location: http://www.plafond-tendu.net/atom/test5.php?action=generation&index=".$index."";
                                      echo '<script language="Javascript">
                                      <!--
                                      document.location.replace("http://www.plafond-tendu.net/atom/test5.php?action=generation&index='.$index.'");
                                      // -->
                                      </script>';
                                      exit;
                                   }
          }


   }

}
//****************************************************************************************************************

?>