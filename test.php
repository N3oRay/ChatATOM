
<?php

include("synonymes.php");

/**
* Fonction simple identique � celle en PHP 5 qui va suivre
*/
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function caltempsexec ($timestamp_debut){
		 // timestamp en millisecondes de la fin du script
		$timestamp_fin = microtime_float(); //microtime(true);
		// différence en millisecondes entre le début et la fin
		// Astuce pour cacher l'affichage du temps d'execution
		echo '<!-- Execution du script : ';
                echo substr(($timestamp_fin - $timestamp_debut),0,5);
                echo ' secondes. -->';
		}
		
$timestamp_debut = microtime_float(); //microtime(true);


$phrase = "

Qu'est que tu fais ?
Tu travail dans quoi ?
Quel est ton travail ?

O� est ce que tu travail ?
Dans quel lieu tu travail ?
A quel endroit tu travail ?

brin apparence  pas : gu�re, peu, � peine, brin, doigt, faiblement, f�tu, filet, goutte, grain, gramme, gu�re, imperceptiblement, insuffisamment, larme, l�g�rement, lueur,
maigrement, mal, m�diocrement, miette, mod�r�ment, modestement, 
moins que rien, ombre, once, pas beaucoup, pas grand-chose, pas tr�s, peu de chose, pointe, rarement, soup�on, tantinet, trace, vaguement, Tu as fait quoi cette apr�s-midi ?


    absent
    amus�
    chang�
    d�bauch�
    d�rang�
    d�rid�
    dissip�
    diverti
    �cervel�
    �gay�
    �tourdi
    inappliqu�
    inattentif
    l�ger
    n�gligent
    pr�lev�
    retranch�
    r�veur
    s�par�
    tromp�
12345678

/* apparence : abord �clat �corce affectation air allure �piderme appareil apparemment aspect biens�ance bouille brillant
cachet caract�re carnation contenance convenance 
d�cor dehors endroit ext�rieur ext�rieurement fa�ade
face faci�s fant�me faux-semblant figure forme front habit id�e imitation jour livr�e
look masque mine mirage montre ombre ostentation para�tre ph�nom�ne phase physionomie plausibilit� 
pr�texte pronostic rayon ressemblance semblance semblant simulacre singerie soup�on superficie surface
symbole tape-�-l'oeil touche tournure trait type vernis vestige visage visibilit� voile vraisemblance */
   123456789
l�ger : a�r� a�rien �cervel� agile agr�able �grillard ail� �l�gant �lanc�
alerte all�g� all�gre anodin arachn�en ardent �th�r� �tourdi �tourneau �vapor� 
�vent� badin b�nin bel esprit capricieux cavaleur changeant chiche clair coureur 
creux croustillant d�barrass� d�gag� d�lest� d�li� d�licat d�muni d�raisonnable d�sinvolte 
d�tach� digeste digestible discret dispos dissip� distrait doux enfantin enjou�
fatigu� fin flou fluet fol�tre fr�le fragile fringant frivole futile gaillard galant gr�le gracieux 
gracile grivois guilleret immat�riel imperceptible impond�rable impr�voyant inattentif inaudible
incons�quent inconscient inconsid�r� inconsistant inconstant ind�celable indiscernable infid�le infime 
infirme ingambe insensible insignifiant insouciant instable  irr�fl�chi irresponsable je-m'en-fichiste 
 l�ge lascif leste libre licencieux menu  minime mobile mondain mousseux n�gligeable oublieux p�tillant 
petit philosophe portatif preste pur s�millant sensuel sommaire souple
spirituel succinct superficiel svelte t�m�raire t�nu transparent vain v�niel vaporeux versatile vide vif volage ";

/*
$phrase = " arr1 = array   boueux  ,   cochon  ,   cracra  ,   crado  ,   crasseux  ,   dissolu  ,   douteux  ,   excessif  ,   crade  ,   abject  ,   affreux  ,   amer  ,   breneux   ;   "
." arr2 = array   ivoirin  ,   infect  ,   impur  ,   impudique  ,   immonde  ,   ignoble  ,   honteux  ,   grivois  ,   graveleux  ,   graisseux  ,   fichu  ,   fangeux  ,   gras   ;  "
." arr3 = array   sagouin  ,   pouacre  ,   pornographique  ,   porc  ,   poisseux  ,   pisseux  ,   ordurier  ,   maudit  ,   louche  ,   licencieux  ,   leste  ,   laid  ,   lactescent   ; "
." arr4 = array   vil  ,   turpide  ,   trouble  ,   trivial  ,   terreux  ,   terni  ,   terne  ,   suspect  ,   surfait  ,   souillon  ,   sordide  ,   salope  ,   salingue   ;"

." sale   d�gueu  d�gueulasse  acide  �grillard  �quivoque barbouill� damn� d�sagr�able d�sordonn�   encrass� exag�r�  f�cheux"
."  inf�me  lascif m�chant macul�  m�prisable maudit naus�abond obsc�ne ord os� p�le p�nible piment� poivr� pollu� poussi�reux r�pugnant sacr� sal� satan� saum�tre souill� "
." admettre analyser apercevoir assister aviser commercer comprendre concevoir confer constater contempler croiser discerner"
." distinguer dominer entrevoir examiner figurer imaginer inspecter inventorier jauger juger lire loucher mater mirer observer  percevoir "
." voir chouf  dikave  mater   regarder  remarquer rencontrer revoir se figurer suivre surprendre survenir veiller viser visionner visualiser "
." nourriture bouffe bouffer boustifaille  graille - juif feuj  youde  youpin  youtre - jeune djeuns neujeu - jambe beuje canne gambette guibole."
." -- fatiguer tuer.gitan rabouin, romano, tanj.goinfre Voir glouton.groupe crew, posser.>> posse >>--fort bal�ze, stocma, stoko, stokos, stokoip- h�pital hosto. incomp�tent baltringue  bite  br�le  burne  tache ----- m�re daronne r�m  reum  reum� vieille.";


 */





echo Synonyms($phrase);
echo Synonyms($phrase);
echo Synonyms($phrase);
caltempsexec ($timestamp_debut);


//$array = array('Alpha tu', 'Alpha toi', 'Alpha toi et moi', 'Alpha', 'atomic', 'Beta', 'bank');
//$array_lowercase = array_map('strtolower', $array);
//array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $array);
//print_r($array);

$face = "toto";

if (preg_match("/".$face."/i", Synonyms($phrase))) {
    echo "Un r�sultat a �t� trouv�.";
} else {
    echo "Aucun r�sultat n'a �t� trouv�.";
}

?>
