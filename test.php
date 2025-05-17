
<?php

include("synonymes.php");

/**
* Fonction simple identique à celle en PHP 5 qui va suivre
*/
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function caltempsexec ($timestamp_debut){
		 // timestamp en millisecondes de la fin du script
		$timestamp_fin = microtime_float(); //microtime(true);
		// diffÃ©rence en millisecondes entre le dÃ©but et la fin
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

Où est ce que tu travail ?
Dans quel lieu tu travail ?
A quel endroit tu travail ?

brin apparence  pas : guère, peu, à peine, brin, doigt, faiblement, fétu, filet, goutte, grain, gramme, guère, imperceptiblement, insuffisamment, larme, légèrement, lueur,
maigrement, mal, médiocrement, miette, modérément, modestement, 
moins que rien, ombre, once, pas beaucoup, pas grand-chose, pas très, peu de chose, pointe, rarement, soupçon, tantinet, trace, vaguement, Tu as fait quoi cette après-midi ?


    absent
    amusé
    changé
    débauché
    dérangé
    déridé
    dissipé
    diverti
    écervelé
    égayé
    étourdi
    inappliqué
    inattentif
    léger
    négligent
    prélevé
    retranché
    rêveur
    séparé
    trompé
12345678

/* apparence : abord éclat écorce affectation air allure épiderme appareil apparemment aspect bienséance bouille brillant
cachet caractère carnation contenance convenance 
décor dehors endroit extérieur extérieurement façade
face faciès fantôme faux-semblant figure forme front habit idée imitation jour livrée
look masque mine mirage montre ombre ostentation paraître phénomène phase physionomie plausibilité 
prétexte pronostic rayon ressemblance semblance semblant simulacre singerie soupçon superficie surface
symbole tape-à-l'oeil touche tournure trait type vernis vestige visage visibilité voile vraisemblance */
   123456789
léger : aéré aérien écervelé agile agréable égrillard ailé élégant élancé
alerte allégé allègre anodin arachnéen ardent éthéré étourdi étourneau évaporé 
éventé badin bénin bel esprit capricieux cavaleur changeant chiche clair coureur 
creux croustillant débarrassé dégagé délesté délié délicat démuni déraisonnable désinvolte 
détaché digeste digestible discret dispos dissipé distrait doux enfantin enjoué
fatigué fin flou fluet folâtre frêle fragile fringant frivole futile gaillard galant grêle gracieux 
gracile grivois guilleret immatériel imperceptible impondérable imprévoyant inattentif inaudible
inconséquent inconscient inconsidéré inconsistant inconstant indécelable indiscernable infidèle infime 
infirme ingambe insensible insignifiant insouciant instable  irréfléchi irresponsable je-m'en-fichiste 
 lège lascif leste libre licencieux menu  minime mobile mondain mousseux négligeable oublieux pétillant 
petit philosophe portatif preste pur sémillant sensuel sommaire souple
spirituel succinct superficiel svelte téméraire ténu transparent vain véniel vaporeux versatile vide vif volage ";

/*
$phrase = " arr1 = array   boueux  ,   cochon  ,   cracra  ,   crado  ,   crasseux  ,   dissolu  ,   douteux  ,   excessif  ,   crade  ,   abject  ,   affreux  ,   amer  ,   breneux   ;   "
." arr2 = array   ivoirin  ,   infect  ,   impur  ,   impudique  ,   immonde  ,   ignoble  ,   honteux  ,   grivois  ,   graveleux  ,   graisseux  ,   fichu  ,   fangeux  ,   gras   ;  "
." arr3 = array   sagouin  ,   pouacre  ,   pornographique  ,   porc  ,   poisseux  ,   pisseux  ,   ordurier  ,   maudit  ,   louche  ,   licencieux  ,   leste  ,   laid  ,   lactescent   ; "
." arr4 = array   vil  ,   turpide  ,   trouble  ,   trivial  ,   terreux  ,   terni  ,   terne  ,   suspect  ,   surfait  ,   souillon  ,   sordide  ,   salope  ,   salingue   ;"

." sale   dégueu  dégueulasse  acide  égrillard  équivoque barbouillé damné désagréable désordonné   encrassé exagéré  fâcheux"
."  infâme  lascif méchant maculé  méprisable maudit nauséabond obscène ord osé pâle pénible pimenté poivré pollué poussiéreux répugnant sacré salé satané saumâtre souillé "
." admettre analyser apercevoir assister aviser commercer comprendre concevoir confer constater contempler croiser discerner"
." distinguer dominer entrevoir examiner figurer imaginer inspecter inventorier jauger juger lire loucher mater mirer observer  percevoir "
." voir chouf  dikave  mater   regarder  remarquer rencontrer revoir se figurer suivre surprendre survenir veiller viser visionner visualiser "
." nourriture bouffe bouffer boustifaille  graille - juif feuj  youde  youpin  youtre - jeune djeuns neujeu - jambe beuje canne gambette guibole."
." -- fatiguer tuer.gitan rabouin, romano, tanj.goinfre Voir glouton.groupe crew, posser.>> posse >>--fort balèze, stocma, stoko, stokos, stokoip- hôpital hosto. incompétent baltringue  bite  brêle  burne  tache ----- mère daronne rèm  reum  reumé vieille.";


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
    echo "Un résultat a été trouvé.";
} else {
    echo "Aucun résultat n'a été trouvé.";
}

?>
