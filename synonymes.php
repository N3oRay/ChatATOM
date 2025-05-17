<?php

define("MAXSIZE", 300);

/*
 * @Entrée : $string un string et $c un caractère
 * @Sortie : (int) nombre de mot dans $string contenant la caractère $c 
 * qu'il soit majuscule ou minuscule (insensible à la case)
 */
function countWordsWithCharCaseInsensitive($string,$c){
    $mots = preg_split("/[\s,;\.!\?:]+/", $string);
    $count = 0;
    foreach($mots as $mot){
        if(preg_match("/$c/i",$mot,$result)){
            $count++;
        }
    }
    return $count;
}

// RETOURNE UNE CHAINE AVEC LE NOMBRE MAXIMUM DE MOTS PASSÉ EN PRAMÈTRE
function getMaxWord($p_chaine, $p_maxWord){
    $array = explode(' ',$p_chaine);
    if(count($array)<=$p_maxWord){
        return $p_chaine;
    }
    
    $chaine = "";
    for($i=0; $i<$p_maxWord;$i++){
        $chaine .= $array[$i]." ";
    }
    return $chaine."...";
}

/*
vexer
    aigrir
    blesser
    brimer
    contrarier
    dépiter
    froisser
    heurter
    mortifier
    offenser
    offusquer
    
    
    
        empathie, 5 synonymes
    compassion
    identification
    transfert
    sympathie
    altruisme
    
    
     projet, 14 synonymes

    ambition
    but
    dessein
    ébauche
    entreprise
    idée
    intention
    préméditation
    programme
    propos
    schéma
    suggestion
    plan
    esquisse



     cynique, 5 synonymes

    débauché
    effronté
    éhonté
    immoral
    impudent


     agnostique, 7 synonymes

    athée
    incroyant
    irréligieux
    non-croyant
    païen
    sceptique
    déiste




     hypocrite, 19 synonymes

    artificieux
    captieux
    chafouin
    comédien
    déloyal
    dissimulé
    fourbe
    insidieux
    jésuite
    judas
    mielleux
    papelard
    patelin
    perfide
    sournois
    sucré
    tartufe
    tortueux
    trompeur



       bucolique, 8 synonymes

    agreste
    campagnard
    champêtre
    idylle
    pastoral
    paysan
    rural
    rustique



     union, 18 synonymes

    alliance
    amalgame
    association
    bloc
    coït
    combinaison
    communion
    concubinage
    confédération
    conjugaison
    fédération
    front
    fusion
    fusionnement
    liaison
    symbiose
    symphonie
    syndicat


      urbain, 2 synonymes

    citadin
    mondain


    

    */

/*
Synonyms	Synonyms	Synonyms			Synonyms	Synonyms		Synonyms	Synonyms	Synonyms	Synonyms	Synonyms	Synonyms	Synonyms	Synonyms	Synonyms
adresse		t\u00e9l\u00e9phone	musique	login		distance	h\u00e9ros			le th\u00e8me	joue		travail		r\u00eave		mesure		mail	docteur	feuilles
habite		num\u00e9ro		chanson	password	longueur	h\u00e9ro\u00efne			le sujet	acteur		travaille	voudrait	taille		email	m\u00e9decin	fiches
boulevard				morceau	passe		largeur		personnage		raconte		acteurs		m\u00e9tier		aimerait	hauteur						documents
rue						music	code		loin		protagoniste	histoire	actrice		profession	passion		grandeur					fichier
o\u00f9						mp3		clef		proche		actrices											int\u00e9r\u00eat		cime			
								identifiant	\u00e9loign\u00e9		est jou\u00e9											envie		altitude			
								cl\u00e9			kilom\u00e8tres														hobby		m\u00e8tres			
											diam\u00e8tre
													
*/


function Synonyms($phrase){
//On met tout en minuscul
$phrase = trim(strtolower($phrase));

$phrase = ' '. $phrase; 
static $p_maxWord = MAXSIZE;   // On limite la phrase à 25 mots.
//$phrase = getMaxWord($phrase, $p_maxWord);

//$phrase = substr($phrase,0,$p_maxWord);
//$phrase = wordwrap($phrase, $p_maxWord -5, "\n");
$phrase = substr($phrase,0,$p_maxWord);

// est-ce : est ce
static $a01 = array(" '",".",",","#",":","-","\n","*"," ! ", " & ", " &amp ","_","/","?");
static $a02   = array("'"," "," "," "," "," "," "," ","","","","","","");
$phrase = str_replace($a01, $a02, $phrase);

// est-ce : est ce
static $b01 = array("est ce ");
static $b02   = "est-ce ";
$phrase = str_replace($b01, $b02, $phrase);

// Où est-ce qu'aura lieu votre réunion ? (ou mieux : où aura lieu votre réunion ?).
static $c01 = array(" est-ce qu'");
static $c02   = " ";
$phrase = str_replace($c01, $c02, $phrase);

// est-ce que vous avez
static $d01 = array("est-ce que vous ", "est-ce que tu ");
static $d02   = "tu ";
$phrase = str_replace($d01, $d02, $phrase);

/* pas : guère, peu, à peine, brin, doigt, faiblement, fétu, filet, goutte, grain, gramme, guère, imperceptiblement, insuffisamment, larme, légèrement, lueur,
maigrement, mal, médiocrement, miette, modérément, modestement, 
moins que rien, ombre, once, pas beaucoup, pas grand-chose, pas très, peu de chose, pointe, rarement, soupçon, tantinet, trace, vaguement*/

static $p01 = array(' &agrave; peine ', ' pas ', ' faiblement ', ' goutte ', ' grain ', ' gramme ', ' miette ',' modestement ', 
' guère ', ' légèrement ', ' médiocrement ',' pas beaucoup ',' pas grand-chose ', ' peu de chose ', ' rarement ', ' vaguement ',' insuffisamment ',
' peu ', ' imperceptiblement ', ' vaguement ');
static $pf   = ' pas ';
$phrase = str_replace($p01, $pf, $phrase);

/* quiconque
être chacune chaque homme n'importe n'importe qui que qui soit
qui que ce soit */
static $e01 = array(" chaque homme ", " n'importe qui ", " qui que ce soit ", " chacune ", " chacun ");
static $e02   = " quiconque ";
$phrase = str_replace($e01, $e02, $phrase);


// brusquement
// abruptement à brûle-pourpoint à l'improviste brûle-pourpoint brutalement dare-dare ex abrupto
// hâtivement inopinément nerveusement net précipitamment raide sèchement soudainement subito vite.
static $f01 = array(' brusquement ', ' abruptement ', ' brutalement ', ' dare-dare ', ' nerveusement ', 
' vite ', ' soudainement ', ' hâtivement ', ' inopinément ', ' précipitamment ', ' subito ');
static $f02   = ' net ';
$phrase = str_replace($f01, $f02, $phrase);

// ceci : cela    // farte     //  a chaque
static $g01 = array(' ceci ',' cela ',' farte ',' baigne ',' roule ', ' boom ',' a chaque ');
static $g02 = array(' cela ',' cela ',' va ',' va ',' va ', ' va ',' de ');
$phrase = str_replace($g01, $g02, $phrase);

//  laquelle, lesquels, lesquelles : dont, qu, que, qui, quoi
// à laquelle, auquel, auxquelles, auxquels, de laquelle, desquelles, desquels, duquel, quoi
// une proposition introduite par "de ce que" au lieu de la simple conjonction "que".
static $i01 = array(' de ce que ',' laquelle ', ' lesquels ', ' lesquelles ', ' dont ', ' que ', ' qui ', 
' quoi ', ' auquel ', ' auxquelles ', ' auxquels ', ' de laquelle ', ' desquelles ', ' desquels ', ' duquel ' );
static $i02   = ' que ';
$phrase = str_replace($i01, $i02, $phrase);


/* conjugaison :http://sourceforge.net/projects/phptrainer/
http://leconjugueur.lefigaro.fr/frlistedeverbe.php*/

/* devoir : faut - dois - exemple : Il ne faut pas / Il ne faudrais pas / Nous ne devrions pas / Vous ne devriez pas
/ Elle ne doit pas / Nous ne devons pas / Vous ne devez pas */

/* je dois, tu dois, il doit, nous devons, vous devez, ils doivent
je devais, tu devais, il devait, nous devions, vous deviez, ils devaient
je devrai, tu devras, il devra, nous devrons, vous devrez, ils devront
je devrais, tu devrais, il devrait, nous devrions, vous devriez, ils devraient */

/* falloir :
il faut, il fallait, il fallut, il faudra,il faudrait, qu'il faille */




/* normalement : correctement, habituellement, logiquement, naturellement, ordinairement, régulièrement */
static $l01 = array(' correctement ', ' habituellement ', ' logiquement ', ' naturellement ',' ordinairement ',' régulièrement ');
static $l02   = ' normalement ';
$phrase = str_replace($l01, $l02, $phrase);

/* reponse : apologie, contrecoup, défense, écho, justification, objection, oracle, réaction, récrimination, réfutation, repartie, réplique, rescrit, résultat, rétorsion, riposte, solution, verdict */
static $m01 = array(' apologie ', ' contrecoup ', ' defense ', ' echo ',' justification ', ' objection ',' oracle ',' reaction ',' repartie ',' rescrit ',' resultat ',' riposte ',' solution ',' verdict ');
static $m02   = ' reponse ';
$phrase = str_replace($m01, $m02, $phrase);



/* magie : alchimie, diablerie, divination, ensorcellement, hermétisme, occultisme, philtre, sorcellerie, sortilège, thaumaturgie, théurgie */
//charme, influence, prestige, séduction
// attiré, captivé, enchanté, enivré, enjôlé, ensorcelé, fasciné, grisé, ravi, réjoui, séduit
static $ma1 = array(' alchimie ', ' diablerie ', ' divination ', ' ensorcellement ',' occultisme ',' philtre ', ' sorcellerie ',' thaumaturgie ');
static $ma2 = array(' charme ', ' influence ', ' prestige ', ' séduction ', ' attiré ', ' captivé ', ' enchanté ', ' ravi ', ' séduit ');
static $ma0   = ' magie ';
$ma = array_merge ($ma1,$ma2);
$phrase = str_replace($ma, $ma0, $phrase);

/* question : affaire, article, chapitre, charade, colle, controverse, délibération, demande, devinette, difficulté, discussion, énigme, épreuve, examen, géhenne, gêne, hic, information, 
interpellation, interrogation, matière, point, problématique, problème, punition, questionnement, revendication, sujet, supplice, thème, torture*/

//affaire biz, business, deal, djèse, nesbi.
static $n01 = array(' biz ',' deal ',' nesbi ',' business ',' affaire ', ' article ', ' chapitre ', ' charade ',' colle ',
' controverse ', ' demande ',' devinette ',' discussion ',' examen ',' information ',' interpellation ',' interrogation ',
' point ',' punition ',' questionnement ',' revendication ',' supplice ',' torture ',' theme ',' probleme ');
static $n02   = ' question ';
$phrase = str_replace($n01, $n02, $phrase);

/* apparence : chimère, clair-obscur, conjecture, crainte, doute, erreur, 
éventualité, hypothèse, illusion, incertitude, indécision, indétermination, pari, perplexité, probabilité, risque, scepticisme, soupçon, vacillation, vraisemblance*/

static $o1 = array(' clair-obscur ', ' conjecture ', ' crainte ', ' doute ',' erreur ',' illusion ', ' pari ',' scepticisme ',' vacillation ',' vraisemblance ');
static $o2   = ' apparence ';
$phrase = str_replace($o1, $o2, $phrase);

/* apparence : abord éclat écorce affectation air allure épiderme appareil apparemment aspect bienséance bouille brillant
cachet caractère carnation contenance convenance 
décor dehors endroit extérieur extérieurement façade
face faciès fantôme faux-semblant figure forme front habit idée imitation jour livrée
look masque mine mirage montre ombre ostentation paraître phénomène phase physionomie plausibilité 
prétexte pronostic rayon ressemblance semblance semblant simulacre singerie soupçon superficie surface
symbole tape-à-l'oeil touche tournure trait type vernis vestige visage visibilité voile vraisemblance */

static $p1 = array(' apparence ', ' abord ', ' affectation ', ' air ',' allure ',' apparemment ', ' aspect ',' contenance ',' convenance ', ' faux-semblant ', ' mirage ', 
' faciès ', ' bouille ',' figure ', ' forme ', ' front ', ' habit ', ' imitation ', ' look ', ' masque ', ' ombre ', ' ostentation ',' physionomie ', 
' ressemblance ', ' semblance ',' semblant ', ' simulacre ', ' symbole ', ' trait ', ' type ', ' vernis ', ' vestige ', ' visage ', ' vraisemblance ', 
' superficie ', ' façade ', ' épiderme ');
static $p0   = ' face ';
$phrase = str_replace($p1, $p0, $phrase);

/* couleur   :éclat allure animation étiquette bariolage brillant caractère carnation côté colorant coloration 
coloris demi-teinte dire drapeau enluminure enseigne extérieur fard figure force franchement gouache motif nuance 
oriflamme pavillon peinture physionomie pigment
pittoresque prétexte raison sous teint teinte teinture ton tonalité tour tournure truculence vie vigueur  */

static $q01 = array(' allure ', ' brillant ', ' colorant ', ' coloration ',' coloris ',' demi-teinte ', ' gouache ',' nuance ',' teint ',' teinte ',' teinture ');
static $q02   = ' couleur ';
$phrase = str_replace($q01, $q02, $phrase);

/* certitude : assurance, autorité, clarté, confirmation, conviction, croyance, dogme, espérance, 
espoir, évidence, fermeté, foi, infaillibilité, netteté, opinion, parole d'évangile, persuasion, réalité, stabilité, sûreté, vérité*/

static $r01 = array(' assurance ', ' confirmation ', ' conviction ', ' croyance ',' dogme ',' espoir ', ' foi ',' opinion ',' persuasion ');
static $r02   = ' certitude ';
$phrase = str_replace($r01, $r02, $phrase);

/* pose : affectation, affèterie, application, apprêt, assiette, attitude, cambrure, coffrage, établissement, extérieur, façon, installation, manière, 
maniérisme, mise en place, modèle, orgueil, pédantisme, photographie, posage, position, posture, prétention, recherche, snobisme, sottise*/

static $s01 = array(' affectation ', ' application ', ' attitude ', ' installation ',' mise en place ',' photographie ', ' posage ',' position ',
' posture ',' recherche ',' snobisme ',' sottise ',' orgueil ',' cambrure ');
static $s02   = ' pose ';
$phrase = str_replace($s01, $s02, $phrase);


static $legume1 = array(' légume ', ' aubergine ', ' chou ', ' gousse ',' gros bonnet ',' huile ', ' notabilité ',' personnalité ',' primeur ');
static $legume2   = ' legume ';
$phrase = str_replace($legume1, $legume2, $phrase);

/* drole : amusant, badin, beau, bidonnant, bizarre, bon, bouffon, bougre, briscard, cocasse, comique, coquin, curieux, désopilant, diable, divertissant, 
drolatique, égayant, enfant, étonnant, étrange, extraordinaire, extravagant, facétieux, fantastique, farce, farceur, farfelu, fichu, fier, folichon, 
fripouille, gai, gaillard, gamin, garçon, gondolant, gosse, hilarant, homme, impayable, inénarrable, insolite, lascar, le plus beau, maraud, marrant, 
numéro, original, pierrot, pittoresque, plaisant, poilant, polisson, récréatif, réjouissant, ridicule, 
rigolo, risible, rocambolesque, rude, sensationnel, singulier, spirituel, surprenant, tordant, truand, truculent, turlupin, type, vaurien */

static $t01 = array(' amusant ', ' badin ', ' bidonnant ', ' bizarre ',' bouffon ',' bougre ',' briscard ',' cocasse ',' comique ',' coquin ',
' curieux ',' diable ',' divertissant ',' drolatique ',' enfant ',' extravagant ',' fantastique ',' farce ',' farceur ',' fichu ',' folichon ',
' fripouille ',' gai ',' gaillard ',' gamin ',' gosse ',' hilarant ',' impayable ',' insolite ',' lascar ',' maraud ',' marrant ',' original ',
' pittoresque ',' plaisant ',' poilant ',' ridicule ',' rigolo ',' risible ',' rocambolesque ',' sensationnel ',' singulier ',' surprenant ',
' tordant ',' truand ',' truculent ',' turlupin ',' type ',' vaurien ');
static $t02   = ' drole ';
$phrase = str_replace($t01, $t02, $phrase);

// 	dangereux, dramatique, grave, inqui\u00e9tant, menace, appliqu\u00e9, attentif, r\u00e9fl\u00e9chi
// avertissement, bravade, chantage, commination, danger, défi, fulmination, grondement, insulte, intimidation, péril, point noir, présage, pression, provocation, réprimande, risque, rodomontade, sommation, spectre, ultimatum
static $u01 = array(' dangereux ', ' dramatique ', ' grave ', ' inqui\u00e9tant ', ' menace ',' appliqu\u00e9 ',' attentif ',
' r\u00e9fl\u00e9chi ', ' s\u00e9rieux ', ' serieux ',' avertissement ',' chantage ',' danger ',' grondement ',' insulte ',
' intimidation ',' pression ',' provocation ',' risque ',' sommation ',' ultimatum ');
static $u02   = ' dure ';
$phrase = str_replace($u01, $u02, $phrase);

/* léger : aéré aérien écervelé agile agréable égrillard ailé élégant élancé 
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
spirituel succinct superficiel svelte téméraire ténu transparent vain véniel vaporeux versatile vide vif volage */

static $v1 = array(' pas dure ', ' creux ', ' digeste ', ' digestible ', ' discret ',' discret ',' doux ',' enfantin ',' souple ', ' flou ', ' fluet ', ' fragile ', ' fringant ', ' minime ', ' philosophe ');
static $v2 = array(' léger ', ' agile ', ' agréable ', ' élégant ', ' élancé ',' allégé ',' allègre ',' anodin ',' bel esprit ', ' délicat ', ' frêle ', ' futile ', ' inaudible ', ' inconséquent ', ' inconsidéré ');
static $v3 = array(' indécelable ', ' indiscernable ', ' infime ', ' lège ', ' mondain ',' négligeable ',' portatif ',' sommaire ',' habile ', ' succinct ', ' superficiel ', ' transparent ', ' vaporeux ');
static $v0   = ' fin ';
$v = array_merge ($v1,$v2,$v3);
$phrase = str_replace($v, $v0, $phrase);

/* érotisme bas-ventre clitoris con cul entrecuisse féminité membre viril 
nature nymphes organes génitaux pénis parties pubis quéquette queue sexualité vagin verge virilité vulve chnek*/

static $w01 = array(" bite ", " chatte ", " clitoris ", " cul "," entrecuisse "," pubis "," vagin "," foufoune ", " vulve ", " chnek ", " schneck ");
static $w02   = " sexe ";
$phrase = str_replace($w01, $w02, $phrase);

//  distrait
static $x1 = array(' irréfléchi ', ' irresponsable ', ' insouciant ', ' infidèle ', ' inconscient ',' impondérable ',' imprévoyant ',' inattentif ',' oublieux ', ' je m\'en fichiste ', ' oublieux ', ' frivole ', ' trompé ');
static $x2 = array(' étourdi ', ' absent ', ' imprudent ', ' inattentif ', ' indifférent ',' insouciant ',' irréfléchi ',' nonchalant ',' oublieux ', ' écervelé ', ' frivole ', ' dissipé ', ' changeant ', ' singerie ');
static $x3 = array(' capricieux ', ' cavaleur ', ' négligent ', ' amusé ', ' changé ', ' débauché ', ' dérangé ', ' déridé ', ' diverti ', ' égayé ', ' inappliqué ', ' prélevé ', ' retranché ', ' rêveur ', ' séparé ');
static $x0   = ' distrait ';
$x = array_merge ($x1,$x2,$x3);
$phrase = str_replace($x, $x0, $phrase);

/* con : aberrant, ballot, benêt, bêta, bête, chatte, connard, couillon, crétin, cul, dinde, emmanché, foufoune, idiot, imbécile, niais, sexe, sot, vulve 
aberrant abruti absurde ahuri andouille arriéré bêta bête ballot borné bouché brute cloche con corniaud cornichon
 crétin cruche cul débile dégénéré déraisonnable emmanché faible d'esprit fou gâteux ignorant imbécile inconséquent
inepte inintelligent injuste innocent insensé jacques manche minus niais nul retardé simple simple d'esprit sot
bite, blaire, branque, con, conno, connard, couillon, deb, dèbe, gogol, gol, golio, golmon, mongol, mongolito, nouille, tebé.
*/
static $con1 = array(' aberrant ', ' ballot ', ' connard ', ' couillon ',' idiot ',' niais ',' abruti ',' andouille ',' corniaud ',' ignorant ',' minus ',' sot ', ' crétin ');
static $con2 = array(' stupide ', ' bite ', ' blaire ', ' branque ', ' conno ', ' connard ', ' couillon ', ' gogol ', ' golmon ', ' mongol ', ' mongolito ', ' nouille ', '  tebé ');
static $con3 = array(' vide ', ' ahuri ', ' brute ', ' cloche ', ' cornichon ', ' cruche ', ' d\'esprit vide ', ' inepte ', ' inintelligent ', ' innocent ', ' manche ', ' simple d\'esprit ');
static $con4 = array(' stupide ', ' deb ', ' gol gol ', ' débile ', ' dégénéré ', ' déraisonnable ', ' emmanché ', ' borné ', ' bouché ',' gâteux ', ' bête ', ' arriéré ', ' imbécile ');
static $con   = ' con ';
$conarray = array_merge($con1,$con2,$con3,$con4);
$phrase = str_replace($conarray, $con, $phrase);

/* impossible  : absurde, acariâtre, bizarre, chimérique, contradictoire, difficile, dur, épineux, 
extravagant, fou, idéal, illusoire, imaginaire, immatériel, impensable, impraticable, inabordable, 
inaccessible, inadmissible, inapplicable, incompatible, inconcevable, inconciliable, incroyable, indu, 
inexcusable, inexécutable, inextricable, infaisable, inimaginable, inouï, insensé, insociable, insoluble, insoutenable, insupportable, 
insurmontable, intenable, intolérable, intraitable, invivable, invraisemblable, irréalisable, irrecevable, malcommode, odieux, pénible, 
revêche, ridicule, rocambolesque, utopique, vain*/

static $vain1 = array(' absurde ', ' bizarre ', ' contradictoire ', ' difficile ',' impossible ',' extravagant ',' fou ',' illusoire ',' imaginaire ',' impensable ',' impraticable ',' inabordable ',' inaccessible ',' inadmissible ',' inapplicable ',' incompatible ',' inconcevable ',' inconciliable ',' incroyable ',' indu ',' inexcusable ',' inextricable ',' infaisable ',' inimaginable ',' insociable ',' insoluble ',' insoutenable ',' insupportable ',' insurmontable ',' intenable ',' intraitable ',' invivable ',' invraisemblable ',' irrecevable ',' malcommode ',' odieux ',' ridicule ',' rocambolesque ',' utopique ',' vain ');
static $vain2   = ' vain ';
$phrase = str_replace($vain1, $vain2, $phrase);

/* possible : abordable, acceptable, accessible, admissible, buvable, 
commode, contingent, convenable, correct, croyable, décent, envisageable, éventuel, 
exécutable, facile, faisable, futur, imaginable, loisible, mangeable, passable, pensable, permis, peut-être, plausible, potable, potentiel, 
praticable, pratique, prévisible, probable, réalisable, sortable, soutenable, supportable, tolérable, toléré, virtualité, virtuel, vivable, vraisemblable*/

static $facile1 = array(' abordable ', ' acceptable ', ' accessible ', ' admissible ',' buvable ',' commode ',' contingent ',' convenable ',' correct ',' croyable ',' envisageable ',' possible ',' faisable ',' imaginable ',' loisible ',' passable ',' permis ',' plausible ',' potable ',' potentiel ',' praticable ',' pratique ',' probable ',' sortable ',' soutenable ',' supportable ',' vivable ',' vraisemblable ');
static $facile2   = ' facile ';
$phrase = str_replace($facile1, $facile2, $phrase);


/* choses : action, affaire, babiole, bagatelle, batifolage, bidule, bricole, capital, circonstance, condition, esclave, évènement, fourbi, 
instrument, machin, objet, patrimoine, phénomène, possession, propriété, réalité, richesse, sujet, truc, trucmuche */

static $chose1 = array(' action ', ' affaire ', ' babiole ', ' bagatelle ',' batifolage ',' bidule ',' bricole ',' capital ',' circonstance ',' condition ',' esclave ',' fourbi ',' instrument ',' machin ',' objet ',' patrimoine ',' possession ',' richesse ',' sujet ',' truc ',' trucmuche ');
static $chose2   = ' choses ';
$phrase = str_replace($chose1, $chose2, $phrase);

/* nullement: pas du tout, pas le moins du monde, point, que nenni */

static $null1 = array(' pas du tout ', ' que nenni ', ' pas le moins du monde ', ' certainnement pas ', ' vraiment pas ');
static $null2   = ' nullement ';
$phrase = str_replace($null1, $null2, $phrase);


/* formidable : admirable, architectural, baron, beau, boeuf, bon, chic, chope, colossal, considérable, dantesque, dément, démesuré, demi, du tonnerre, 
effrayant, énorme, épatant, époustouflant, épouvantable, étonnant, extraordinaire, extravagant, fabuleux, fameux, fantasmagorique, fantastique, faramineux, 
fort, fumant, génial, gigantesque, gros, immense, impeccable, imposant, impressionnant, incalculable, inouï, invraisemblable, le plus beau, magnifique, 
marrant, méchant, merveilleux, mirifique, mirobolant, monstrueux, monumental, notable, phénoménal, prestigieux, prodigieux, redoutable, 
remarquable, renversant, rocambolesque, sensationnel, signalé, soufflant, stupéfiant, super, supérieur, surprenant, terrible, titanesque, verre

super : aspirer, aux pommes, dingue, épatant, étonnant, formidable, génial, gober, merveilleux, s'obstruer, se boucher, supercarburant, surprenant
étonnant beau dingue essence extraordinaire  formidable génial gober lamentable merveilleuse miraculeux sensationnelle surnaturelle
*/

static $super1 = array(' admirable ', ' architectural ', ' baron ', ' chic ',' colossal ',' dantesque ',' extravagant ',' fabuleux ',' fameux ',' fantasmagorique ');
static $super2 = array(' fantastique ',' faramineux ',' gigantesque ',' immense ',' impeccable ',' imposant ',' impressionnant ',' incalculable ',' magnifique ',' mirifique ');
static $super3 = array(' monumental ',' notable ',' prestigieux ',' prodigieux ',' redoutable ',' remarquable ',' renversant ',' rocambolesque ',' sensationnel ',' soufflant ');
static $super4 = array(' titanesque ',' mirobolant ',' terrible ', ' considérable ', ' dément ',' démesurédu ',' tonnerre ',' effrayant ',' inouï ',' démesuré ',' supérieur ');
static $super5 = array(' énorme ',' épatant ',' époustouflant ',' épouvantable ',' étonnant ',' extraordinaire ',' formidable ',' merveilleuse ',' remarquable ',' phénoménal ');
static $super6 = array(' dingue ', ' formidable ', ' merveilleux ', ' surprenant ', ' sensationnelle ', ' surnaturelle ', ' génial ',' miraculeux ',' stupéfiant ', ' remarquable ');
$super = array_merge ($super1,$super2,$super3,$super4,$super5,$super6);
static $super0   = ' super ';
$phrase = str_replace($super, $super0, $phrase);

/* bas : faible abattu, aboulique, accommodant, adynamique, affaibli, amour, anéanti, anémié, anémique, apathique, asthénique, attaquable, attirance, avorton, aztèque*, bas, bénin, blèche, blême,
bonasse, borné, bouché, branlant, cacochyme, caduc, cassant, cassé, chancelant, chétif, complaisance, complaisant, cotonneux, coulant, crevé, critiquable, débile, débonnaire, défaillant, défaut, 
déficient, délabré, délicat, délié, déprimé, dérisoire, désarmé, difforme, douteux, doux, ébranlable, entraînable, épuisé, étiolé, étouffé, étroit, exsangue, fade, faiblard, faiblesse, 
falot, fatigué, fluet, frêle, freluquet, goût, grêle, gringalet, imbécile, imperceptible, imperfection, impersonnel, impotent, impuissant, incertain, inclination, incolore, inconsistant, 
inconstant, indécis, inefficace, inerte, infériorité, infirme, influençable, insignifiant, instable, insuffisant, invalide, labile, lâche, lamentable, languissant, las, léger, limité, 
lymphatique, maigre, maladif, malheureux, malingre, malléable, manie, mauvais, mauviette, méchant, médiocre, menu, minable, mince, modéré, mollasse, mou, mourant, moyen, 
négligeable, nul, obtus, ouaté, pâle, patraque, pauvre, penchant, pente, petit, piètre, pitoyable, pliant, précaire, prédilection, préférence, propension, pusillanime, rabougri, ramolli, 
réduit, réfutable, sans volonté, simple, souffreteux, sympathie, tendre, titubant, travers, vacillant, vague, velléitaire, veule, vice, volage, vulnérable
*/

static $bas1 = array(" abattu ", " affaibli ", " commun ", " apathique ", " attaquable "," avorton ", " faible "," caduc "," cassant "," chancelant "," critiquable "," douteux "," fade "," faiblard "," faiblesse "," falot "," fluet "," freluquet "," gringalet "," imperceptible "," imperfection "," impersonnel "," impotent "," impuissant "," incertain "," inconsistant "," indigent "," inefficace "," inerte "," infirme "," insignifiant "," insuffisant "," inconstant "," instable "," invalide "," labile "," lamentable "," languissant "," las "," lymphatique "," maigre "," maladif "," malheureux "," malingre "," mauvais "," mauviette "," menu "," minable "," mince "," mollasse "," mou "," mourant "," obtus "," patraque "," petit "," pitoyable "," pliant "," ramolli "," simple "," souffreteux "," tendre "," travers "," vacillant "," vague "," veule "," vice "," volage ");
static $bas2   = " bas ";
$phrase = str_replace($bas1, $bas2, $phrase);

/* moyen : acceptable, agent, arme, art, artifice, astuce, banal, béquille, biais, bon, bourgeois, calcul, canal, capacité, cause, chance, chemin, combinaison, combine, commun, lambda, médian, médiocre, mémoire, mesure, 
méthode, mitoyen, modalité, mode, modéré, modeste, modique, mûr, normal, occasion, opération, passable, pauvre, piège, plan, planche de salut, porte, possibilité, potable, pouvoir, prétexte, procédé, procédure, quelconque, terne, tolérable*/
static $moyen1 = array(" acceptable ", " banal ", " commun ", " juste ", " lambda "," modeste ", " modique "," passable "," potable "," quelconque "," terne ");
static $moyen2   = " moyen ";
$phrase = str_replace($moyen1, $moyen2, $phrase);

/* haut : aigu, altier, ancien, apogée, arrogant, beau, bon, céleste, colline, comble, considérable, 
couronnement, crête, culminant, dédaigneux, démesuré, dessus, digne, dominant, dressé, éclatant, édifiant, élancé, élévation, élevé, éloigné, éminence, 
éminent, épicé, éthéré, exagéré, exemplaire, extrême, faîte, fier, flèche, fort, fortement, fortuné, franchement, front, grand, gros, hautain, hautement, 
hauteur, héroïque, important, intense, intensément, levé, loin, long, nettement, noble, noeud, orgueilleux, ouvertement, perçant, perché, pinacle, pointe, 
proéminent, profond, publiquement, puissant, reculé, relevé, remarquable, renchéri, résonnant, retentissant, ronflant, 
sommet, sommité, sonore, sourcilleux, soutenu, sublime, superbe, supérieur, suprême, surélevé, tête, toiture, tonitruant, transcendant, vibrant, vieux, vif*/

static $haut1 = array(" aigu ", " ancien ", " colline ", " comble "," dessus "," digne "," dominant "," hautement "," hauteur "," important "," intense "," nettement "," pointe "," profond "," publiquement "," puissant "," remarquable "," retentissant "," sommet "," sublime "," superbe "," toiture "," tonitruant "," transcendant "," vibrant "," vieux "," vif ");
static $haut2   = " haut ";
$phrase = str_replace($haut1, $haut2, $phrase);

/* normal : aisé, arrêté, bien portant, calculé, canonique, classique, compréhensible, correct, courant, décidé, déterminé, dispos,
 exact, fixé, habituel, honnête, inné, journalier, légitime, logique, mesuré, méthodique, moyen, naturel, ordinaire, ordonné, organisé, perpendiculaire,
 ponctuel, prévisible, quotidien, raisonnable, rangé, rationnel, réglé, régulier, robuste, sain, solide, systématique, traditionnel, valable*/
 
static $normal1 = array(" bien portant ", " canonique ", " classique ", " correct "," courant "," dispos "," exact "," habituel "," journalier "," logique "," moyen "," naturel "," ordinaire "," perpendiculaire "," ponctuel "," quotidien "," raisonnable "," rationnel "," robuste "," sain "," solide "," traditionnel ", " valable ");
static $normal2   = " normal ";
$phrase = str_replace($normal1, $normal2, $phrase);
  
 /* dramatique : burlesque, caricatural, cocasse, comique, grotesque, ridicule, théâtral
  	bouffonne, calamiteuse, catastrophique, dangereux, grave, gravissime, passionnant, pénible, sérieuse, sérieux, tragique     */
  
static $veux1 = array("voudrais", "d\u00e9sire", "d\u00e9sires", "voeux","souhaits","serments","promesses");
static $veux2   = "veux";
$phrase = str_replace($veux1, $veux2, $phrase);
  
/* aimé : adoré, affectionné, apprécié, chéri, estimé, goûté, idolâtré, raffolé, vénéré */

static $aime1 = array("aim\u00e9", "ador\u00e9", "affectionn\u00e9", "appr\u00e9ci\u00e9", "ch\u00e9ri","estim\u00e9","goût\u00e9","idolâtr\u00e9","raffol\u00e9","v\u00e9n\u00e9r\u00e9");
static $aime2   = "aime";
$phrase = str_replace($aime1, $aime2, $phrase);

static $matrix1 = array(" neo ", " morpheus ", " trinity ", " cypher ", " tank ");
static $matrix2   = " matrix ";
$phrase = str_replace($matrix1, $matrix2, $phrase);


/* lire :déchiffrer, épeler, bouquiner, compulser, consulter, dévorer, feuilleter, parcourir, relire,énoncer, réciter, déchiffrer, décoder
	diffuser, transcrire, découvrir, deviner */
		
static $lire1 = array("bouquiner", "compulser", "consulter", "feuilleter", "parcourir", "relire","conseiller","diffuser","deviner");
static $lire2   = "lire";
$phrase = str_replace($lire1, $lire2, $phrase);

static $ecrire1 = array("\u00e9crire", "griffonner","accentuer", "consigner", "exposer","exprimer", "griffonner", "raviver", "correspondre", "d\u00e9crire","inscrire", "libeller", "marquer", "noter", "pondre","pondre", "r\u00e9diger", "tartiner", "transcrire", "conjuguer","orthographier","composer", "concevoir", "controuver", "engendrer","exprimer", "faire", "forger", "produire","enregistrer","inscrire", "esquisser", "inscrire", "marquer", "ecrire");
static $ecrire2   = "ecrire";
$phrase = str_replace($ecrire1, $ecrire2, $phrase);

//Antonymes : annihiler, annuler, biffer, effacer, gratter, racheter*/

/*
être: entité, existence

	abstraction
Antonymes : non-être, âme, entité
Antonymes : néant

	créature, individu, personne
(en être à) se voir réduit à
(être de) provenir
(être sans) manquer de

accomplir, exister, réaliser, subsister, vivre
appartenir, résider, tenir, trouver */



// c\u00e9der, marchander, monnayer, r\u00e9troc\u00e9der, revendre
/*
 échanger écouler adjuger aliéner bazarder brader brocanter céder cameloter
conserver débarrasser débiter défaire dénoncer détailler donner exporter faire fournir laisser lessiver 
liquider livrer marchander mévendre monnayer négocier offrir placer prostituer réaliser rétrocéder revendre 
sacrifier s'aliéner se débarrasser se défaire s'enlever servir se séparer solder trafiquer trahir
*/
static $vendre1 = array(' c\u00e9der ', ' marchander ', ' monnayer ',' r\u00e9troc\u00e9der ', ' revendre ', ' trafiquer ', ' bazarder ', ' brader ', ' brocanter ', ' solder ');
static $vendre2   = ' vendre ';
$phrase = str_replace($vendre1, $vendre2, $phrase);


// "attendu que", "comme", "en effet", "\u00e9tant donn\u00e9 que", "parce que", "puisque", "vu que"
static $car1 = array(" attendu que ", " comme ", " en effet ", " \u00e9tant donn\u00e9 que ", " parce que ", " puisque ", " vu que ");
static $car2   = " car ";
$phrase = str_replace($car1, $car2, $phrase);


// agripper, appr\u00e9hender, attraper, choper, empoigner, emprunter, extraire, \u00f4ter, pr\u00e9lever, puiser, saisir
static $prendre1 = array("agripper", "appr\u00e9hender", "attraper","choper", "empoigner", "emprunter", "extraire", "\u00f4ter", "pr\u00e9lever", "puiser", "saisir");
static $prendre2   = "prendre";
$phrase = str_replace($prendre1, $prendre2, $phrase);

// assur\u00e9, audacieux, brave, courageux, \u00e9nergique, ferme, hardi, intr\u00e9pide, r\u00e9gl\u00e9, r\u00e9solu, risque-tout
static $ferme1 = array("assur\u00e9", "audacieux", "brave","courageux", "\u00e9nergique", "d\u00e9cid\u00e9", "hardi", "intr\u00e9pide", "r\u00e9gl\u00e9", "r\u00e9solu", "risque-tout");
static $ferme2   = "ferme";
$phrase = str_replace($ferme1, $ferme2, $phrase);

/*
acte, acte authentique, annales, archives, contrat, copie, dossier, écrit, feuille, justificatif, maquette, matériau, original, papier, pièce, preuve, renseignement, témoignage, texte, titre
*/
static $doc1 = array(" feuilles ", " fiches ", " documents "," fichier ", " note "," acte "," contrat "," dossier "," feuille "," papier "," texte "," titre ", " document");
static $doc2   = " doc ";
$phrase = str_replace($doc1, $doc2, $phrase);

// accoucheur, allopathe, chirurgien, doctoresse, hom\u00e9opathe, l\u00e9giste, omnipraticien, ost\u00e9opathe, psychiatre, toubib
static $docteur1 = array("docteur", "m\u00e9decin", "g\u00e9n\u00e9raliste","accoucheur","allopathe","chirurgien","doctoresse","hom\u00e9opathe","l\u00e9giste","omnipraticien","ost\u00e9opathe","psychiatre","toubib");
static $docteur2   = "docteur";
$phrase = str_replace($docteur1, $docteur2, $phrase);

/* agent de liaison, article, avant-courrier, bateau, car, chronique, coche, coin, correspondance, dépêche, estafette, expédition, lettre, messager, messagerie, paquet, porteur, poste */
static $mail1 = array(" mail ", " email ", " courriel ", " courrier ", " poste "," lettre "," correspondance "," article "," messager "," messagerie "," porteur "," articles ");
static $mail2   = " mail ";
$phrase = str_replace($mail1, $mail2, $phrase);

// 	dire : discuter, communiquer, converser, deviser, dialoguer, parler
/* annoncer, apprendre, commander, confier, correspondre, déclarer, découvrir, desservir, 
divulguer, donner, échanger, écrire, enflammer, enseigner, envahir, envoyer, épancher, être en rapport, 
faire connaître, faire part de, faire savoir, flanquer, gagner, imprégner, imprimer, indiquer, infuser, inoculer, inspirer, insuffler, jeter, livrer, mander, notifier, 
partager, passer, prêter, propager, publier, relier, révéler, s'aboucher, s'écrire, s'entendre, s'ouvrir, se commander, signaler, signifier, transmettre*/

static $dire1 = array(" discuter ", " communiquer ", " converser "," deviser ", " dialoguer ", " parler "," annoncer "," commander "," confier "," correspondre "," divulguer "," donner "," enflammer "," enseigner "," envahir "," envoyer "," imprimer "," infuser "," inspirer "," insuffler "," jeter "," livrer "," mander "," notifier "," partager "," passer "," propager "," publier "," relier "," s'entendre "," signaler "," signifier "," transmettre ");
static $dire2   = " dire ";
$phrase = str_replace($dire1, $dire2, $phrase);

/*
accord échelle économe économie acte anthropométrie appréciation 
approximation équilibre étalon évaluation batterie borne cadence calcul calculé 
capacité charge circonspect circonspection combinaison comparaison contenance contre-mesure cote 
cruchon détermination degré dimension discret disposition dose estimation force gabarit grandeur 
habilité importance jaugeage juste milieu ménagement manière métré mètre métrique métrologie mensuration mesurage 
milieu modéré modération mouvement moyen norme penchant poésie poids point pondération pot précaution précautionneux 
précision préparatif profondeur proportion prudence prudent quantification quantité quart récipient règle rapport 
réserve ration retenue rythme sagesse sens sobriété statistique stature taille tasse tempérament tempérance tempo 
terme toise tonneau unité valeur vers versification
*/

static $metres1 = array(" contenance "," mesure ", " taille ", " hauteur ", " grandeur ", " cime "," altitude ", " m\u00e8tres "," metres ", " stature ", " valeur ", " poids ", " mesurage ");
static $metres2   = " metres ";
$phrase = str_replace($metres1, $metres2, $phrase);

// J'ai envis, j'aimerait, je r\u00eave, ma passion, mon envie, mes
static $hobby1 = array(" r\u00eave ", " voudrait ", " aimerait ", " int\u00e9r\u00eat ", " interet "," envie ", " hobby "," passion "," passions ", " manie ");
static $hobby2   = " hobby ";
$phrase = str_replace($hobby1, $hobby2, $phrase);

/*
accouchement, activité, affaire, amortissement, application, art, besogne, 
boulot, bras, bricolage, bricole, brocante, business, canevas, casse-tête, cassement,
. chef-d'oeuvre, cheminement, corvée, devoir, difficulté, écrit, effort, élaboration, emploi, enfantement,
 entraînement, entreprise, état, étude, études, exécution, exercice, façon, facture, fatigue, fermentation,
 fonction, fonctionnement, force, forme, gagne-pain, gauchissement, gésine, gymnastique, huile de coude, industrie,
 intérim, job, labeur, livre, main-d'oeuvre, mal, mal d'enfant, marche, mastic, métier, mission, occupation, oeuvre, opération,
 ouvrage, peine, pensum, place, plan, poste, prestation, production, 
profession, programme, recherche, réparation, rôle, sape, service, situation, soin, spécialité, sueur, tâche, tintouin, turbin, veille, zèle*/

static $job1 = array(' travail ', ' travaille ', ' m\u00e9tier ', ' profession ', ' boulot ',' job ', ' travailler ',' bricole ',
' brocante ',' business ',' devoir ',' effort ',' emploi ',' entreprise ',' exercice ',' fermentation ',' fonction ',' fonctionnement ',
' industrie ',' labeur ',' mission ',' occupation ',' ouvrage ',' peine ',' production ',' situation ',' turbin ',' service ',' recherche ',' fatigue ');
static $job2   = ' job ';
$phrase = str_replace($job1, $job2, $phrase);


static $fruit1 = array(' aboutissement ', ' agrume ', ' akène ', ' avantage ', ' boulot ',' baie ', ' bénéfice ',' conclusion ',
' conséquence ',' couronnement ',' dénouement ',' effet ',
' grain ',' graine ',' moisson ',' pomme ',' production ',' produit ',' profit ',' rançon ',' recette ',
' rejeton ',' ressource ',' revenu ',' suite ',' situation ',' usufruit ');
static $fruit2   = ' fruit ';
$phrase = str_replace($fruit1, $fruit2, $phrase);



/* vie : histoire,accroc, affaire, affectation, allégorie, anecdote, anicroche, annales, archéologie, archives, autobiographie, aventure, bagou, baliverne, bateau, bavardage, bible, 
biographie, blague, bobard, boniment, bruit, cas, chicane, chronique, chronologie, comédie, commentaire, complication, confessions, conte, craque, description, détour, 
difficulté, diplomatique, dit, écho, embarras, ennui, épisode, étude, évangile, évènement, évocation, évolution, existence, fable, façon, fastes, feuilleton, généalogie, 
geste, hagiographie, heuristique, historiette, incident, intrigue, invention, légende, machin, manière, mémoires, mensonge, menstrues, mésaventure, musique, mythe, mythologie, narration, paléographie, 
parabole, passé, peinture, préhistoire, problème, propos, protohistoire, querelle, récit, relation, roman, salade, sornette, souvenir, sujet, tirage, truc, version, vie */

static $vie1 = array(" le th\u00e8me ", " le sujet ", " raconte ", " histoire ", " anecdote "," annales "," archives ",
" aventure "," baliverne "," bible "," biographie "," boniment "," chronique "," chronologie "," commentaire "," complication ",
" confessions "," conte "," description "," diplomatique "," existence "," fable "," feuilleton "," incident "," intrigue ",
" invention "," mensonge "," narration "," parabole "," propos "," querelle "," relation "," roman "," souvenir "," truc "," version "," histoire ");
static $vie2   = " vie ";
$phrase = str_replace($vie1, $vie2, $phrase);

// ignorant, incomp\u00e9tent, null, minable, nullard
static $null3 = array(" ignorant ", " incomp\u00e9tent ", " null ", " minable ", " nullard ");
static $null4   = " null ";
$phrase = str_replace($null3, $null4, $phrase);

static $acteur1 = array(" h\u00e9ros ", " h\u00e9ro\u00efne ", " personnage ", " protagoniste ", " actrices "," est jou\u00e9 ", 
" heros ", " acteur ", " acteurs ", " actrice ", " joue ");
static $acteur2   = " acteur ";
$phrase = str_replace($acteur1, $acteur2, $phrase);

/* loin: abîme, absence, amplitude, aversion, chemin, course, déclinaison, dédain, différence, discrimination, disparité, 
disproportion, dissemblance, distinction, écart, écartement, élévation, éloignement, élongation, espace, espacement, étendue, froideur, horizon, interstice, intervalle, 
lointain, marge, mépris, nuance, opposition, parcours, périmètre, portée, profondeur, rayon, recul, réprobation, route, traite, trajet, vide*/

static $loin1 = array(" distance ", " longueur ", " largeur ", " loin ", " proche "," \u00e9loign\u00e9 "," kilom\u00e8tres ",
" diam\u00e8tre "," chemin "," distinction "," espacement "," interstice "," intervalle "," lointain "," marge "," parcours ",
" profondeur "," rayon "," trajet "," route ");
static $loin2   = " loin ";
$phrase = str_replace($loin1, $loin2, $phrase);

static $login1 = array(" login ", " password ", " passe ", " code ", " clef "," identifiant "," cl\u00e9 "," cl\u00e9e ");
static $login2   = " login ";
$phrase = str_replace($login1, $login2, $phrase);

// audition, festival, foire, musicographie, musicologie, r\u00e9cital
static $musique1 = array("musique ", "chanson ", "morceau ", "music ", "mp3 ","CD ","audition ","festival ","foire ",
"musicographie ","musicologie ","r\u00e9cital ","tube ", "audio ");
static $musique2   = "musique ";
$phrase = str_replace($musique1, $musique2, $phrase);

// blague, b\u00eatise, canular, craque, gal\u00e9jade, h\u00e2blerie, plaisanterie, attrape, gaffe, sottise, humour, satire, moquerie
static $blague1 = array("blague ", "b\u00eatise ", "canular ", "gal\u00e9jade ", "h\u00e2blerie ","plaisanterie ","attrape ",
"gaffe ","sottise ","humour ","satire ","moquerie ", "blagues ");
static $blague2   = "blague ";
$phrase = str_replace($blague1, $blague2, $phrase);

//  cogiter, combiner, gamberger, m\u00e9diter, raisonner, recueillir, r\u00e9fl\u00e9chir, r\u00eaver, songer, sp\u00e9culer
static $penser1 = array("cogiter", "combiner", "gamberger", "m\u00e9diter", "raisonner","recueillir","r\u00e9fl\u00e9chir","r\u00eaver","songer","sp\u00e9culer","penser","imaginer");
static $penser2   = "penser";
$phrase = str_replace($penser1, $penser2, $phrase);

/*
adresse, berceau, canton, cas, catégorie, cause, coin, colin, domicile, emplacement, endroit, espace, étape, extraction, lieu-dit, localité, maison, matière, merlan, milieu, objet, occasion, origine, parages, part, 
passage, pays, place, point, position, poste, prétexte, quelque part, raison, rang, région, résidence, secteur, séjour, site, situation, sujet, terrain, terre, théâtre, zone */

static $lieu1 = array(" adresse ", " habite ", " boulevard ", " rue ", " o\u00f9 "," lieu "," cite "," avenue "," canton "," coin "," domicile "," emplacement "," endroit "," espace "," maison "," milieu "," origine "," parages "," passage "," pays "," place "," point "," poste "," secteur "," site "," situation "," sujet "," terrain "," terre "," zone ");
static $lieu2   = " lieu ";
$phrase = str_replace($lieu1, $lieu2, $phrase);

// abandonn\u00e9, d\u00e9sert, d\u00e9sert\u00e9, inoccup\u00e9, solitaire, vide, inhabit\u00e9, n\u00e9ant
/* à sec, abandon, abandonné, absence, ampoulé, apathie, apathique, aride, baie, bête, blanc, boursoufflé, 
case, cavité, chambre, creux, débarrassé, défaut, dégarni, démeublé, démuni, dénudé, dénué, dépeuplé, 
dépouillé, dépourvu, désempli, désert, déserté, disponible, emphatique, enflé, ennui, espace, évacué, 
excavation, exempt, fente, fissure, frivole, fumée, futile, futilité, impeuplé, improductif, inanité, inconsistant, 
inculte, infréquenté, inhabité, inintéressant, inoccupé, insignifiant, insipide, inutile, lacune, léger,
libre, manque, morne, mort, néant, net, nu, nul, nullité, omission, ouverture, pauvre, perte, phraséologie, plat, prétentieux, privation, privé, rien, 
sans, sec, solitaire, soufflé, stérile, superficiel, terne, trou, vacant, vacuité, vacuum, vague, vain, vanité, viduité, zéro*/
static $vide1 = array(" abandonn\u00e9 ", " d\u00e9sert ", " d\u00e9sert\u00e9 ", " inoccup\u00e9 ", " solitaire "," vide ",
" inhabit\u00e9 "," n\u00e9ant ", " ennui "," rien "," pauvre "," nul "," abandon "," apathie "," absence ", " emphatique ",
" manque ", " morne ", " mort "," inutile "," vain "," sans ");
static $vide2   = " vide ";
$phrase = str_replace($vide1, $vide2, $phrase);

// congé, désoeuvrement, disponibilité, interruption, liberté, loisir, vacation, vacuité
static $vacance1 = array(' congé ', ' désoeuvrement ', ' disponibilité ', ' interruption ', ' liberté ',' loisir ',' vacation ',' vacuité ');
static $vacance2   = ' vacance ';
$phrase = str_replace($vacance1, $vacance2, $phrase);

// ce jour, jadis, maintenant, pr\u00e9sentement aujourd'hui / actuellement
static $maintenant1 = array("ce jour", "jadis", "maintenant", "pr\u00e9sentement", "aujourd'hui","actuellement","imm\u00e9diatement","directement", "sur-le-champ");
static $maintenant2   = "maintenant";
$phrase = str_replace($maintenant1, $maintenant2, $phrase);

// cin\u00e9ma, cin\u00e9matographe, cin\u00e9rama, cinoche, documentaire, \u00e9cran, projection, spectacle
// bande, clip, couche, émulsion, évolution, navet, pellicule, péplum, processus, production, super-production, thriller, typon, western
static $film1 = array(" cin\u00e9ma ", " cinéma ", " cin\u00e9matographe ", " cin\u00e9rama ", " cinoche ", " documentaire "," \u00e9cran "," projection "," spectacle "," bande "," clip "," navet "," pellicule "," production "," thriller "," western ");
static $film2   = " film ";
$phrase = str_replace($film1, $film2, $phrase);

// aise, b\u00e9at, bienheureux, bon, combl\u00e9, content, enchant\u00e9, joyeux, radieux, ravi, satisfait
static $bon1 = array(" aise ", " b\u00e9at ", " bienheureux ", " heureux ", " combl\u00e9 "," content "," enchant\u00e9 "," joyeux "," radieux "," ravi "," satisfait "," chanceux ");
static $bon2   = " bon ";
$phrase = str_replace($bon1, $bon2, $phrase);

static $num1 = array(" t\u00e9l\u00e9phone ", " num\u00e9ro ", " num ", " rue ", " o\u00f9 ", " numéro ");
static $num2   = " num ";
$phrase = str_replace($num1, $num2, $phrase);

// http://www.crisco.unicaen.fr/des/synonymes/boire

/* toi - tu */
static $tu1 = array(" toi-m\u00eame ", " toi "," vous ");
static $tu2   = " tu ";
$phrase = str_replace($tu1, $tu2, $phrase);

/* dommage : tant pis, fâcheux, regrettable 
altération atteinte avarie bête brèche calamité coup dégât dégradation dam désavantage détérioration détriment 
endommagement  entorse grabuge grief injure injustice
intérêt lésion méfait mal nuisance outrage perte préjudice ravage regrettable ribordage sévices sinistre tant pis tort
*/

static $dommage1 = array(" tant pis ", " regrettable "," f\u00e2cheux ", " atteinte ", " avarie ", " endommagement ", " injure ", " injustice ", " nuisance ", " outrage ", " tort ", " sinistre ");
static $dommage2   = " dommage ";
$phrase = str_replace($dommage1, $dommage2, $phrase);

/* parfait :
absolu, accompli, achevé, adéquat, admirable, adorable, angélique, beau, bien, bon, 
bravo, céleste, chenu, complet, consommé, désintéressé, déterminé, digne, divin, double, élégant, 
entier, étonnant, exact, excellent, exceptionnel, exemplaire, exquis, extraordinaire, fameux, fieffé, 
fini, formé, franc, glace, hors ligne, idéal, idyllique, impeccable, inattaquable, incomparable, infaillible, 
infini, inimitable, irréprochable, magistral, merveilleux, modèle, non pareil, notable, optimal, oui, paradisiaque, pommé, précieux, prétérit, pur, 
raffiné, remarquable, renforcé, respectable, réussi, rigoureux, royal, 
sacré, sensationnel, signalé, singulier, souverain, splendide, strict, sublime, succulent, superfin, supérieur, superlatif, suprême, total, très bien, triple, unique, vrai*/

static $parfait1 = array(" absolu ", " accompli "," admirable "," parfait "," exact "," excellent "," incomparable "," inimitable "," remarquable "," respectable "," royal "," sublime "," succulent "," unique "," paradisiaque "," sensationnel ");
static $parfait2   = " parfait ";
$phrase = str_replace($parfait1, $parfait2, $phrase);

/* bien 

absolument, achèvement, acquêt, admirablement, 
adroitement, agréable, agréablement, aimable, aisément, amplement, apanage, approximativement, 
argent, artistement, assurément, attentivement, au moins, au poil, avantage, avantageusement, 
avec bonheur, avoir, bath, beau, beaucoup, bellement, bénédiction, bénéfice, bien-être, bienfait,
bigrement, bon, bonheur, bonnement, bonté, bougrement, bravo, capital, certes, chance, charité, cheptel, 
chic, choisi, chose, comme il faut, commode, commodément, compétent, complètement, confortablement, conquêt, 
conquête, consciencieux, considérablement, convenable, convenablement, cool, copieusement, correct, correctement, 
couramment, délicatement, devoir, digne, dignement, distingué, divin, domaine, don, dotation, droit, drôlement, dûment, 
effectivement, élégamment, élégant, éminemment, en totalité, entièrement, environ, estimable, excellemment, excellent, 
expressément, extrêmement, fameusement, faveur, favorablement, félicité, ferme, fermement, fonds, formellement, 
formidablement, fort, fortune, fruit, gentiment, grâce, gracieusement, habilement, héritage, heureusement, heureux, honnête, 
honnêtement, honneur, honorable, honorablement, idéal, immeuble, impeccablement, intégralement, intensément, intérêt, joli, 
joliment, judicieusement, judicieux, juste, justice, largement, logiquement, louable, magistralement, merveilleusement, méthodiquement, 
moral, morale, nettement, noblement, O.K., oui, parfait, parfaitement, pas mal, patrimoine, perfection, peut-être, pleinement, 
possession, présent, produit, profit, profondément, propice, proprement, propriété, prospérité, prudemment, purement, raisonnablement, 
rationnellement, récolte, réellement, remarquablement, rente, richesse, sagement, salement, sans bavure, satisfaction, satisfaisant, 
secours, sélect, sensiblement, sérieusement, service, seyant, soigneusement, soit, sortable, soulagement, souverain bien, succès, succession, sûr, sûrement, terre, totalement, tout, 
tout à fait, très, très bien, trop, un grand nombre, utilement, utilité, vachement, valeur, véritablement, vertu, violemment, vivement, volontiers, vraiment
*/

static $bien1 = array(" ben ", " absolument "," admirablement ", " adroitement "," aimable "," amplement "," approximativement "," argent "," avantage "," bon "," bonnement "," bravo "," chance "," commode "," joli "," jolie "," joliment "," juste "," parfait "," satisfaction "," satisfaisant "," vachement "," fort "," remarquablement ");
static $bien2   = " bien ";
$phrase = str_replace($bien1, $bien2, $phrase);


/* âme soeur : amante, bien-aimée */
static $amante1 = array(" \u00e2me soeur ", " amante "," bien\u002daim\u00e9e ", " ame\u002dsoeur ", " ame soeur ");
static $amante2   = " amante ";
$phrase = str_replace($amante1, $amante2, $phrase);



/* balbutiement : début, commencement, commence.

ébauche abc éclosion adolescence élément éléments alpha amorce apparition 
arrivée attaque aube aurore avènement axiome b.a.-ba bégaiement balbutiement berceau 
bord bourgeon bout création début déclenchement départ embryon enfance entame entrée 
esquisse essai exorde extrémité fleur fondement germe inauguration introduction 
liminaire limite lisière naissance orée origine ouverture point point initial postulat préambule préface préliminaires
prélude prémices prémisse premier premier pas primeur principe prologue provenance racine seuil source
 */
static $debut1 = array(" balbutiement ", " commencement ", " d\u00e9but ", " balbutiments ", " intro ", " introduction ", " naissance ", " commence ", " racine ", " premier ", " ouverture ", " fondement ");
static $debut2   = " debut ";
$phrase = str_replace($debut1, $debut2, $phrase);

/* nouveau: à la mode, à la page, actuel, apprenti, audacieux, autre, bizut, bleu, changé, dans le vent, 
débutant, dernier, dernier cri, différent, extraordinaire, frais, hardi, in, inaccoutumé, inattendu, inconnu, 
inédit, inexpérimenté, inexploré, inhabituel, inimaginé, inouï, insolite, insoupçonné, inusité, 
jeune, métamorphosé, moderne, néophyte, neuf, nouveauté, novateur, novice, original, 
osé, personnel, primeur, printanier, récent, second, surprenant, truculent, ultramoderne, up to date, vierge*/

static $neuf1 = array(" actuel ", " apprenti "," audacieux ", " autre "," insolite "," jeune "," moderne ", " nouveau "," novateur ", " original "," primeur ", " vierge "," novice ", " ultramoderne ", " r\u00e9cent ", " récent ");
static $neuf2   = " neuf ";
$phrase = str_replace($neuf1, $neuf2, $phrase);

/* usage - application : 
adaptation, affectation, antécédent, applique, art, assemblage, assiduité, 
attachement, attention, attribution, bijection, concentration, conscience, contention, correspondance, curiosité, 
effet, effort, emploi, empreinte, étude, exactitude, exécution, exercice, expérimentation, 
fomentation, homomorphisme, image, impression, imputation, injection, mal, méditation, mise en pratique, placage, pose, pratique, réalisation, 
recueillement, réflexion, régularité, relation, sérieux, soin, superposition, surjection, tension, travail, usage, utilisation, vigilance, vigueur, zèle*/

static $usage1 = array(" adaptation ", " affectation "," applique ", " assemblage ", " attention ", " attribution "," bijection ", " concentration ", " conscience "," contention "," correspondance "," effet "," exactitude "," exercice "," image "," impression "," pratique "," usage "," utilisation "," vigilance ", " vigueur ");
static $usage2   = " usage ";
$phrase = str_replace($usage1, $usage2, $phrase);

/* ambiance :
atmosphère, aura, climat, compagnie, décor, entourage, environnement, influence, milieu, temps */

static $ambiance1 = array("climat", "environnement", "compagnie", "entourage","influence","milieu");
static $ambiance2   = "ambiance";
$phrase = str_replace($ambiance1, $ambiance2, $phrase);


/* sortir :
abandonner, aérer, affleurer, apparaître, arracher, baguenauder, balader, bondir, couler, 
débarrasser le plancher, débiter, déborder, déboucher, débouquer, débucher, débusquer, décamper, découler, dégager, déguerpir, 
déloger, dépasser, dépêtrer, déraciner, descendre, dévier, dire, échapper, éclore, éditer, éliminer, émaner, émerger, enlever,
être frais émoulu, être issu, être né de, être publié, évacuer, excéder, exhiber, exhumer, expectorer, expulser, extirper, 
extraire, extravaser, fabriquer, faire, faire abstraction, faire irruption, jaillir, lâcher, lancer, libérer, naître, ôter, 
outrepasser, paraître, partir, passer, percer, poindre, pousser, prendre, prendre l'air, procéder, produire, proférer, promener, 
provenir, publier, quitter, raconter, réchapper, remonter, ressortir, résulter, retirer, revenir, s'absenter, s'aérer, s'écarter, 
s'éclipser, s'écouler, s'éloigner, s'enfuir, s'esquiver, s'évader, s'exhaler, saillir, se balader, se dégager, se départir, se détacher, se libérer, se manifester, se montrer, se promener, 
se répandre, se retirer, se sauver, se tirer, se traîner, sourdre, suivre, surgir, tirer, tomber, transgresser, venir, vidanger, vider, virer*/

static $sortir1 = array(" abandonner ", " arracher "," balader "," descendre "," partir "," quitter "," retirer "," revenir "," tirer "," virer "," promener "," outrepasser ", " se manifester ");
static $sortir2   = " sortir ";
$phrase = str_replace($sortir1, $sortir2, $phrase);

/*vraiment */
static $vraiment1 = array("absolument","bellement","certainement","effectivement","en effet","exactement","fortement","franchement","indubitablement","loyalement","positivement","proprement","assur\u00e9ment","en v\u00e9rit\u00e9","pr\u00e9cis\u00e9ment","r\u00e9ellement","s\u00e9rieusement","sinc\u00e8rement","v\u00e9ritablement");
static $vraiment2   = "vraiment";
$phrase = str_replace($vraiment1, $vraiment2, $phrase);

/* rire */
static $rire1 = array(" amuser ", " badiner ", " baratiner ", " blaguer ", " brocarder ", " cachinnation ", " d\u00e9daigner ", " \u00e9clater ", " enjouement ", " fou rire ", " gaiet\u00e9 ", " glousser ", " hilarit\u00e9 ", " ironiser ", " joie ", " jouer ", " luire ", " m\u00e9priser ", " narguer ", " nasarder ", " persiffler ", " plaisanter "," pouffer ", " prendre du bon temps ", " railler ", " raillerie ", " ricanement ", " ricaner ", " rictus ", " ridiculiser ", " rigolade ", " rigolbocher ", " rigoler ", " rioter ", " ris ", " ris\u00e9e ", " risette ", " s'amuser ", " s'\u00e9gayer ", " s'en payer ", " s'esclaffer ", " s'\u00e9tourdir ", " se bidonner ", " se boyauter ", " se d\u00e9rider ", " se d\u00e9sopiler ", " se distraire ", " se divertir ", " se fendre la poire ", " se fendre la pipe ", " se gausser ", " se gondoler ", " se jouer ", " se marrer ", " se moquer ", " se poiler ", " se r\u00e9jouir ", " se rire ", " se tirebouchonner ", " se tordre ", " sourire ", " souris ", " tourner en ridicule ");
static $rire2   = " rire ";
$phrase = str_replace($rire1, $rire2, $phrase);

/* boire */
static $boire1 = array(" abreuver ", " arroser ", " aspirer ", " biberonner ", " bidonner ", " boissonner ", " buvoter ", " chopiner ");
static $boire2 = array(" ivrogner ", " lamper ", " laper "," licher ", " lipper ", " picoler ", " pictancher ", " picter ", " pictonner ", " pinter ", " pomper ", " rincer ");
static $boire3 = array(" s'abreuver ", " s'affûter "," s'alcooliser ", " s'aviner ", " s'enivrer ", " s'humecter ", " s'imbiber ", " s'imprégner ", " s'inonder ", " sabler ");
static $boire4 = array(" savourer ", " se cocarder ", " se d\u00e9salt\u00e9rer ", " se gargariser", " se lester", " se rafraichir", " se remplir", " se souler ");
static $boire5 = array(" se taper ", " siffler ", " siroter ", " t\u00e9ter ", " trinquer ");
static $boire   = " boire ";
$boires = array_merge ($boire1,$boire2,$boire3,$boire4,$boire5);
$phrase = str_replace($boires, $boire, $phrase);

//alcool bibine, pillave, tise, zeti.
static $alcool1 = array(" bibine ", " pillave "," tise "," zeti ");
static $alcool2   = " alcool ";
$phrase = str_replace($alcool1, $alcool2, $phrase);

//ami cops, pote, poteau, srab, tepo.
static $ami1 = array(" cops ", " pote "," poteau "," srab "," tepo ");
static $ami2   = " ami ";
$phrase = str_replace($ami1, $ami2, $phrase);

//anus fion, oignon, rondelle, trou de balle.
$healthy = array(" fion ", " oignon "," rondelle "," trou de balle ");
$yummy   = " anus ";
$phrase = str_replace($healthy, $yummy, $phrase);


// automobile bagnole, caisse, gamos, gova, poubelle, tire, titine, turvoi, vago.
$healthy = array(" automobile ", " bagnole "," caisse "," gamos "," gova "," poubelle "," tire "," titine "," turvoi "," vago ");
$yummy   = " auto ";
$phrase = str_replace($healthy, $yummy, $phrase);

//avare crevard, pince, racho, rapiat. 
$healthy = array(" crevard ", " pince "," racho "," rapiat ");
$yummy   = " avare ";
$phrase = str_replace($healthy, $yummy, $phrase);

//beau bien foutu, frais, michto, top.
$healthy = array(" bien foutu ", " frais "," michto "," top ");
$yummy   = " beau ";
$phrase = str_replace($healthy, $yummy, $phrase);

//bien bonnard, cool, frais, good, michto, nickel, tip-top, top.
$healthy = array(" bonnard ", " cool "," frais "," good "," michto "," nickel "," tip-top "," top ");
$yummy   = " bien ";
$phrase = str_replace($healthy, $yummy, $phrase);

//belle bonne, fraîche, yes.
//beaucoup gavé, grave, max, vachement.
//caleçon calbar, calbute, calcif, calfouète. 
//cunnilingus broute-minou, cunni.
////// cunnilingus (pratiquer un) bouffer une chatte, descendre à la cave.
$healthy = array(" cunnilingus ", " broute-minou "," broute minou "," cunnis "," bouffer une chatte ");
$yummy   = " cunni ";
$phrase = str_replace($healthy, $yummy, $phrase);

//débile deb, gogol, gol, golio, golmon, mongol, mongolito, narvalo, tebé.
$healthy = array(" gogol ", " golio "," golmon "," mongol "," mongolito "," narvalo ");
$yummy   = " gol ";
$phrase = str_replace($healthy, $yummy, $phrase);

//difficile auche, chaud, dar, darre, hard. 
// 	ardu, délicat, embarrassant, emmerdant, envahissant, gênant, incommode, laborieux, malaisé, pénible, rude
$healthy = array(" hard ", " chaud "," darre "," dar "," auche "," difficile ", " embarrassant ", " emmerdant ", " envahissant ", " incommode ", " laborieux ", " difficile ");
$yummy   = " rude ";
$phrase = str_replace($healthy, $yummy, $phrase);

//dispute clash, embrouille, engueulade. 
//altercation, bagarre, chamaille, chamaillerie, discorde, dissension, escarmouche, heurt, incident, polémique, querelle, trouble
$healthy = array(" dispute ", " embrouille "," engueulade "," mongol "," mongolito "," narvalo ", " altercation "," narvalo "," bagarre "," chamaille "," discorde "," dissension "," escarmouche "," heurt "," incident "," querelle ");
$yummy   = " clash ";
$phrase = str_replace($healthy, $yummy, $phrase);
//dormir pieuter, pioncer, roupiller, se pieuter. 
$healthy = array(" pieuter ", " pioncer "," roupiller "," se pieuter "," se reposer "," pause ");
$yummy   = " dormir ";
$phrase = str_replace($healthy, $yummy, $phrase);
//eau flotte. 
//éjaculer chécra, cracher, dégorger le poireau, juter, lâcher la purée, se vider les couilles. 
//enfant chiard, lardon, merdeux, minot, môme, morpion, mouflet, moutard, tipeu. 
$healthy = array(" chiard ", " merdeux "," minot "," morpion "," mouflet "," moutard "," tipeu ");
$yummy   = " enfant ";
$phrase = str_replace($healthy, $yummy, $phrase);

//ennuyeux chiant, chiatique, gonflant, relou. 
/*
faim ainf, dalle.
? avoir faim avoir les crocs. 

fainéant cossard, glandeur, glandouillard, ramier.   */

//femme belette, caille, chnek, fatma, femelle, fente, feum, feumeu, frangine, gadji, go, gonze, gonzesse, greluche, grosse, loute, meuf, nana, poule, poulette, racli, rate, schneck, tera, zessegon.
$healthy = array(' belette ', ' caille ',' chnek ',' fatma ',' femelle ',' feum ',' feumeu ',' frangine ',' gadji ',' gonze ',' gonzesse ',' greluche ',' loute ',' meuf ',' nana ',' poule ',' poulette ',' racli ',' schneck ',' tera ',' zessegon ');
$yummy   = ' femme ';
$phrase = str_replace($healthy, $yummy, $phrase);


//fille belette, caille, chnek, fifna, frangine, gadji, gonze,
//gonzesse, gorette, meuf, minch, nana, nénette, pain, pisseuse, poulette, racli, rate, tera, yeufi, zessegon.
static $fille1 = array(' belette ', ' caille ', ' chnek ', ' fifna ', ' frangine ', ' gadji ', ' gonze ');
static $fille2 = array(' gonzesse ', ' gorette ', ' meuf ', ' minch ', ' nana ', ' nénette ', ' pisseuse ', ' poulette ', ' racli ', ' rate ', ' tera ', ' zessegon ');
static $fille   = ' fille ';
$healthy = array_merge ($fille1,$fille2);
$phrase = str_replace($healthy, $fille, $phrase);

//fumiste bolosse, bouffon, branleur, branquignol, charlot, chlague, donbi, fomblard, fonbou, gueuche, gueuchla, mickey, roloto.
static $fumiste1 = array(' bolosse ', ' bouffon ', ' branleur ', ' branquignol ', ' charlot ', ' chlague ', ' donbi ');
static $fumiste2 = array(' fomblard ', ' fonbou ', ' gueuche ', ' gueuchla ', ' mickey ', ' roloto ');
static $fumiste   = ' fumiste ';
$healthy = array_merge ($fumiste1,$fumiste2);
$phrase = str_replace($healthy, $fumiste, $phrase);

// hasch, haschisch chichon, dyname, ganja, kif, popo, shit, teuche, teuchi, teushi, teuteu, zetla, zotla.
static $hasch1 = array(" haschisch ", " chichon "," dyname "," ganja "," kif "," popo "," shit "," teuche "," teuche "," teushi "," teuteu "," zetla "," zotla ");
static $hasch2   = " hasch ";
$phrase = str_replace($hasch1, $hasch2, $phrase);
 
// homme gadjo, gonze, keum, keumé, mec, nombo, raclo.
//créature, être, hominidé, hominien, humain, individu, mortel, personne
// 	bonhomme, coco, créature, garçon, gonze, individu, mâle, mari, mec, quidam, type
static $homme1 = array(" gadjo ", " gonze "," keum "," mec "," nombo "," raclo ", " personne ", " individu ", " mortel ", " humain ", " hominien ", " bonhomme ", " coco ");
static $homme2   = " homme ";
$phrase = str_replace($homme1, $homme2, $phrase);
 
//homo,  homosexuel chbeb, dèp, fiotte, folle, , lope, lopette, pédale, pédé, pédoque, phoque, tafiole, tante, tantouse, tantouze, tapette, tarlouze, zamel.
$healthy = array(" homosexuel ", " chbeb "," fiotte "," folle "," lope "," lopette "," phoque "," tafiole "," tante "," tantouse "," tantouze "," tapette "," tarlouze "," zamel ");
$yummy   = " homo ";
$phrase = str_replace($healthy, $yummy, $phrase);

// honte affiche, bif, chouf, haine (avoir la), latche, tehon.
$healthy = array(" affiche ", " bif "," chouf "," latche "," tehon ");
$yummy   = " honte ";
$phrase = str_replace($healthy, $yummy, $phrase);

// ivre avoir un coup dans le nez, beurré, bituré, bourré, chlasse, cramé, déchiré, fracasse, murgé, pété, torché.
$healthy = array(" avoir un coup dans le nez ", " chlasse "," fracasse ");
$yummy   = " ivre ";
$phrase = str_replace($healthy, $yummy, $phrase);

// lâche faux derche, faux-cul, femmelette, fiotte, fomblard, gonzesse, lope ou lopette, pétochard, e, sans-couille, tafiole, tapette, tarlouze.
 
// laid cheum, dégueu, lassedeg, moche,affreux, difforme, disgracieux, hideux, moche, monstrueux, repoussant, vilain
$healthy = array(" cheum ", " lassedeg "," moche "," affreux "," difforme "," disgracieux "," hideux "," monstrueux "," repoussant "," vilain ");
$yummy   = " laid ";
$phrase = str_replace($healthy, $yummy, $phrase);
//? personne laide cadavre, cageot, cratère, mocheté, thon.

//lit paddock, pieu, plumard.
//main paluche, patoche, pogne.
$healthy = array(" paluche ", " patoche "," pogne ");
$yummy   = " main ";
$phrase = str_replace($healthy, $yummy, $phrase);

// manger bâfrer, becqueter, bouffer, criave, damer, gaméler, grailler, se taper, s'empiffrer.
$healthy = array(" becqueter ", " bouffer "," criave "," damer "," grailler "," se taper ");
$yummy   = " manger ";
$phrase = str_replace($healthy, $yummy, $phrase);

// mentir balnaver, baratiner, barber, charlater, mythoner, pipeauter.
$healthy = array(" balnaver ", " baratiner "," barber "," charlater "," mythoner "," pipeauter ");
$yummy   = " mentir ";
$phrase = str_replace($healthy, $yummy, $phrase);

// se moquer casser, chambrer, gazer, se foutre de la gueule de qqn, tailler un costard à qqn, vanner.
$healthy = array(" se moquer ", " chambrer "," gazer "," se foutre de la gueule de "," tailler un costard "," vanner ");
$yummy   = " casser ";
$phrase = str_replace($healthy, $yummy, $phrase);

// mourir canner, clamser, claquer, crever.
$healthy = array(" canner ", " clamser "," claquer "," crever ");
$yummy   = " mourir ";
$phrase = str_replace($healthy, $yummy, $phrase);
 
// musclé baraqué, scleum, stoc, stoko.
//? homme musclé armoire à glace, baraque, dalle, masse, stocma, stokosse.

//musique zic, zicmu, zik, zizique.

//nez blase, blaze, pif, tarin, zen.

//parler pénave, tchatcher.
// moto bécane, meule.
// misère hagra, zermi.

//pénis biroute, bistouquette, bite, braquemard, braquos, chibre, dard, gourdin, kiki, mandrin, noeud, nouille, 
//pine, poireau, quéquette, queue, teub, zboub, zézette, zguègue, zigounette, zizi, zobe.


//? faire peur foutre les jetons.

// avoir peur avoir les chocottes, avoir les jetons, baliser, chier dans son froc, flipper, péfli, péfly, pisser dans son froc.
$healthy = array(" avoir les chocottes ", " avoir les jetons ", " baliser ", " chier dans son froc ", " flipper ", " pisser dans son froc ");
$yummy   = " avoir peur ";
$phrase = str_replace($healthy, $yummy, $phrase);

//peur flip, frousse, pétoche, reup, trouille, affolement, alarme, appréhension, crainte, émotion, épouvante, frayeur, frisson, panique, phobie
// angoisse, appréhension, épouvante,angoisser bader, bad-triper, flipper, péfli, péfly, psychoter, phobie
// affolement, alarme, appr\u00e9hension, crainte, \u00e9motion, \u00e9pouvante, frayeur, frisson, panique, phobie
static $peur1 = array(' flip ', ' frousse ', ' reup ', ' trouille ', ' affolement ', ' alarme ', ' crainte ', ' frayeur ', ' frisson ', ' panique ',' péfli ', ' péfly ');
static $peur2 = array(' bader ', ' bad-triper ',' flipper ',' psychoter ',' angoisser ', ' pétoche ', ' appréhension ', ' phobie ', ' angoisse ', ' épouvante ');
static $peur3 = array(' affolement ', ' alarme ', ' appr\u00e9hension ',' crainte ', ' \u00e9motion ', ' \u00e9pouvante ', ' frayeur ', ' initimidation ');
static $peur   = ' peur ';
$healthy = array_merge ($peur1,$peur2,$peur3);
$phrase = str_replace($healthy, $peur, $phrase);


/*prostituée biatch, gagneuse, gueuse, michetonneuse, pouf, poufiasse, putain, pute, radasse, radeuse, tchebi, tcheubi, teup, teupu, timpe.   */
$healthy = array(" gagneuse ", " gueuse "," michetonneuse "," pouf "," poufiasse "," putain "," biatch "," radasse "," radeuse "," tchebi "," tcheubi "," teup "," teupu ");
$yummy   = " pute ";
$phrase = str_replace($healthy, $yummy, $phrase);

//puer chlinguer, dauber, fouetter, poquer, upe.
$healthy = array(" chlinguer ", " dauber ", " fouetter ", " poquer ", " upe ");
$yummy   = " puer ";
$phrase = str_replace($healthy, $yummy, $phrase);
//regarder chouf, dicave, dikave, mater, rodave, téma, viser, zieuter, zyeuter.

//laisser : renvoyer dégommer, lourder, virer.
//abandonner, abdiquer, calter, débiner, décaniller, déguerpir, délaisser, déménager, dénicher, échapper, 
//embarquer, émigrer, enfuir, évacuer, fuir, lâcher, rompre, soustraire, voyager
static $laisser1 = array(' renvoyer ', ' dégommer ', ' lourder ', ' virer ');
static $laisser2 = array(' abandonner ', ' abdiquer ',' calter ',' débiner ',' décaniller ', ' déguerpir ', ' délaisser ', ' déménager ', ' dénicher ', ' échapper ');
static $laisser3 = array(' embarquer ', ' émigrer ', ' enfuir ',' évacuer ', ' fuir ', ' lâcher ', ' rompre ', ' soustraire ', ' voyager ');
static $laisser   = ' laisser ';
$healthy = array_merge ($laisser1,$laisser2,$laisser3);
$phrase = str_replace($healthy, $laisser, $phrase);

//riche blindé, cheuri, pété de tunes, pété d'oseille.

//rien foye, keud ou queude, peanuts, que dalle, que tchi, queude, walou.
$healthy = array(" foye ", " keud ", " queude ", " peanuts ", " que dalle ", " que tchi ", " queude ", " walou ");
$yummy   = " rien ";
$phrase = str_replace($healthy, $yummy, $phrase);

//saluer checker.accueillir applaudir fêter, honorer ,incliner     prosterner  rendre hommage   rendre visite  respecter       se prosterner
$healthy = array(" checker ", " accueillir ", " applaudir ", " honorer ", " incliner ", " prosterner ", " rendre hommage ", " rendre visite ", " respecter ", " se prosterner ");
$yummy   = " saluer ";
$phrase = str_replace($healthy, $yummy, $phrase);

//sein bzèze, insse, loches, lolo, néné, nibard, nichon, roberts, roploplo, tété.
$healthy = array(" insse ", " loches ", " lolo ", " nibard ", " nichon ", " roberts ", " roploplo ");
$yummy   = " sein ";
$phrase = str_replace($healthy, $yummy, $phrase);

//testicule boule, burne, coucougnette, couille, roubignole, valseuse, yecou, yoc.
$healthy = array(" testicule ", " burne ", " coucougnette ", " couille ", " roubignole ", " valseuse ", " yecou ", " yoc ");
$yummy   = " boule ";
$phrase = str_replace($healthy, $yummy, $phrase);

//toilette cagouince, chiotte, gogues.
$healthy = array(" cagouince ", " chiotte ", " gogues ", " toilette ");
$yummy   = " wc ";
$phrase = str_replace($healthy, $yummy, $phrase);

//travailler bosser, cravacher, gratter, taffer, trimer.
$healthy = array(" bosser ", " cravacher ", " gratter ", " taffer ", " trimer ");
$yummy   = " travailler ";
$phrase = str_replace($healthy, $yummy, $phrase);
/*
 travail chaffrave, taf, turbin.
? travail non déclaré black, blackos, kebla.      */
$healthy = array(" chaffrave ", " taf ", " turbin ", " black ", " blackos ", " kebla ");
$yummy   = " travail ";
$phrase = str_replace($healthy, $yummy, $phrase);

 //tuer bousiller, buter, charcler, déglinguer, dégommer, descendre, dessouder, flinguer, fumer, plomber, refroidir, rétamer, sécher, shooter, zigouiller.
$healthy = array(" bousiller ", " buter ", " charcler ", " descendre ", " dessouder ", " flinguer ", " fumer ", " plomber ", " refroidir ", " shooter ", " zigouiller ");
$yummy   = " tuer ";
$phrase = str_replace($healthy, $yummy, $phrase);

 //vanter (se) béflan, faire crari, flamber, frimer, se la donner, se la jouer, se la péter, se la raconter.
$healthy = array(" faire crari ", " flamber ", " frimer ", " se la donner ", " se la jouer ", " se la raconter ");
$yummy   = " vanter ";
$phrase = str_replace($healthy, $yummy, $phrase);

 //ventre bide, bidon, brioche.
$healthy = array(' bide ', ' bidon ', ' brioche ');
$yummy   = ' ventre ';
$phrase = str_replace($healthy, $yummy, $phrase);

 //viande barbaque, bidoche.
$healthy = array(' barbaque ', ' bidoche ');
$yummy   = ' viande ';
$phrase = str_replace($healthy, $yummy, $phrase);

//*********************************************************************************************************
// fatiguer tuer.
// gitan rabouin, romano, tanj.
// goinfre Voir glouton.
// groupe crew, posse.
//fort balèze, stocma, stoko, stokos.
// hôpital hosto.
// incompétent baltringue, bite, brêle, burne, tache.
// mère daronne rèm  reum  reumé vieille.
// jambe beuje canne gambette guibole.
// jeune djeuns neujeu
// juif feuj  youde  youpin  youtre
//nourriture bouffe, boustifaille, graille.
//parents darons, rempes, vieux.
$patterns = array();
$patterns[0] = '/fatiguer/';
$patterns[1] = '/rabouin/';
$patterns[2] = '/romano/';
$patterns[3] = '/tanj/';
$patterns[4] = '/glouton/';
$patterns[5] = '/posse /';
$patterns[6] = '/crew/';
$patterns[7] = '/balèze/';
$patterns[8] = '/stocma/';
$patterns[9] = '/stokos/';
$patterns[10] = '/stoko/';
$patterns[11] = '/hosto /';
$patterns[12] = '/baltringue /';
$patterns[13] = '/bite /';
$patterns[14] = '/brêle /';
$patterns[15] = '/burne /';
$patterns[16] = '/tache /';
$patterns[17] = '/ daronne /';
$patterns[18] = '/ rèm /';
$patterns[19] = '/ reum /';
$patterns[20] = '/ reumé /';
$patterns[21] = '/ vieille /';
$patterns[22] = '/ beuje /';
$patterns[23] = '/ canne /';
$patterns[24] = '/ gambette /';
$patterns[25] = '/ guibole /';
$patterns[26] = '/ djeuns /';
$patterns[27] = '/ neujeu /';
$patterns[28] = '/ feuj /';
$patterns[29] = '/ youde /';
$patterns[30] = '/ youpin /';
$patterns[31] = '/ youtre /';
$patterns[32] = '/ bouffe /';
$patterns[33] = '/ boustifaille /';
$patterns[34] = '/ graille /';
$patterns[35] = '/ darons /';
$patterns[36] = '/ rempes /';
$patterns[37] = '/ vieux /';


$replacements = array();
$replacements[0] = 'tuer';
$replacements[1] = 'gitan';
$replacements[2] = 'gitan';
$replacements[3] = 'gitan';
$replacements[4] = 'goinfre';
$replacements[5] = 'groupe ';
$replacements[6] = 'groupe';
$replacements[7] = 'fort';
$replacements[8] = 'fort';
$replacements[9] = 'fort';
$replacements[10] = 'fort';
$replacements[11] = 'hopital ';
$replacements[12] = 'incompetent ';
$replacements[13] = 'incompetent ';
$replacements[14] = 'incompetent ';
$replacements[15] = 'incompetent ';
$replacements[16] = 'incompetent ';
$replacements[17] = ' mere ';
$replacements[18] = ' mere ';
$replacements[19] = ' mere ';
$replacements[20] = ' mere ';
$replacements[21] = ' mere ';
$replacements[22] = ' jambe ';
$replacements[23] = ' jambe ';
$replacements[24] = ' jambe ';
$replacements[25] = ' jambe ';
$replacements[26] = ' jeune ';
$replacements[27] = ' jeune ';
$replacements[28] = ' juif ';
$replacements[29] = ' juif ';
$replacements[30] = ' juif ';
$replacements[31] = ' juif ';
$replacements[32] = ' nourriture ';
$replacements[33] = ' nourriture ';
$replacements[34] = ' nourriture ';
$replacements[35] = ' parents ';
$replacements[36] = ' parents ';
$replacements[37] = ' parents ';
$phrase = preg_replace($patterns, $replacements, $phrase);



/* juger, s'imaginer,commercer,arriver, admettre,analyser,apercevoir,assister,aviser,commercer,comprendre,concevoir,confer,constater,contempler,croiser,discerner
  distinguer,dominer,entrevoir,examiner,figurer,imaginer,inspecter,inventorier,jauger,juger,lire,loucher,mater,mirer,observer, percevoir
  voir chouf, dikave, mater.  regarder, remarquer,rencontrer,revoir,se figurer,suivre,surprendre,survenir,veiller,viser,visionner,visualiser,         */
$arr0 = array(' percevoir ', ' regarder ', ' contempler ',' observer ', ' examiner ',' remarquer ',' recevoir ',' rencontrer ',' hanter ',' visiter ',' apercevoir ',' entrevoir ');
$arr1 = array(' concevoir ',' discerner ',' constater ',' remarquer ',' d\u00e9couvrir ',' appr\u00e9cier ',' se voir ',' se figurer ',' se fr\u00e9quenter ',' se produire ',' se mirer ');
$arr2 = array(' admettre ', ' analyser ',' apercevoir ',' assister ',' aviser ',' commercer ',' comprendre ',' concevoir ',' confer ',' constater ',' contempler ',' croiser ',' discerner ');
$arr3 = array(' juger ',' loucher ',' distinguer ', ' dominer ',' entrevoir ',' examiner ',' figurer ',' imaginer ',' inspecter ',' inventorier ',' jauger ',' mirer ',' observer ',' percevoir ');
$arr4 = array(' chouf ', ' dikave ',' mater ', ' regarder ',' remarquer ',' rencontrer ',' revoir ',' se figurer ',' suivre ',' surprendre ',' survenir ',' veiller ',' viser ',' visionner ',' visualiser ');
$yummy   = ' voir ';
$healthy = array_merge ($arr0,$arr1,$arr2,$arr3,$arr4);
$result1 = array_unique($healthy);
$phrase = str_replace($result1, $yummy, $phrase);



//sale , dégueu, dégueulasse,,acide,,égrillard,,équivoque,barbouillé,damné,désagréable,désordonné,,,encrassé,exagéré,,fâcheux
$arr1 = array(' boueux ', ' cracra ', ' crado ', ' crasseux ', ' dissolu ', ' douteux ', ' excessif ', ' crade ', ' abject ', ' affreux ', ' amer ', ' breneux ');
$arr2 = array(' ivoirin ', ' impur ', ' impudique ', ' immonde ', ' ignoble ', ' honteux ', ' grivois ', ' graveleux ', ' graisseux ', ' fichu ', ' fangeux ', ' gras ');
//  infâme, lascif,méchant,maculé, méprisable,maudit,nauséabond,obscène,ord,osé,pâle,pénible,pimenté,poivré,pollué,poussiéreux,répugnant,sacré,salé,satané,saumâtre,souillé
$arr3 = array(' sagouin ', ' porc ', ' poisseux ', ' pisseux ', ' ordurier ', ' maudit ', ' louche ', ' licencieux ', ' leste ', ' laid ', ' lactescent ');
$arr4 = array(' vil ', ' trouble ', ' trivial ', ' terreux ', ' terni ', ' terne ', ' suspect ', ' surfait ', ' souillon ', ' sordide ', ' salope ', ' salingue ');
$arr5 = array(' acide ', ' turpide ', ' pouacre ', ' pornographique ', ' infect ', ' cochon ', ' lascif ' );

$yummy   = ' sale ';
$healthy = array_merge ($arr1,$arr2,$arr3,$arr4,$arr5);
$phrase = str_replace($healthy, $yummy, $phrase);

//*********************************************************************************************************

//vol braco, braquo, carotte, choure, dépouille, fauche, gruge, rotka, tape.
$healthy = array(" braco ", " braquo "," carotte "," choure "," fauche "," gruge "," rotka "," tape ");
$yummy   = " vol ";
$phrase = str_replace($healthy, $yummy, $phrase);

 //voler barber, barboter, bébar, bicrave, carotter, choucrave, choucrouter, chouraver, chourer, dépouiller, faucher, gauler, péta, piquer, rotka, taper, tirer.
$healthy = array(" barber ", " barboter "," bicrave "," carotter "," choucrave "," choucrouter "," chouraver "," chourer "," faucher "," gauler "," piquer "," rotka "," taper "," tirer ");
$yummy   = " voler ";
$phrase = str_replace($healthy, $yummy, $phrase);
 

// vulve chatte, choune, fente, fouf, foufoune, foufounette, foune, minou, moule, schneck, teuche.
$healthy = array(" chatte ", " choune "," fente "," fouf "," foufoune "," foufounette "," minou "," moule "," schneck "," teuche ");
$yummy   = " vulve ";
$phrase = str_replace($healthy, $yummy, $phrase);

//amour (faire l') baiser, bouillave, bourrer, bourriner, bouyave, défourailler, donner, emmancher, fourrer, foutre, kène, kéner, limer, mettre, niquer, piner, pointer, sauter, se taper, taper, taro, tartiner, tirer, tringler, troncher, trouer, zéber, zobe, zober.
$healthy = array(" baiser ", " bouillave "," bourrer "," bourriner "," bouyave "," emmancher "," fourrer "," foutre "," limer "," mettre "," niquer "," piner "," pointer "," sauter "," se taper "," taper "," taro "," tartiner "," tirer "," tringler "," troncher "," trouer "," zobe "," zober ");
$yummy   = " amour ";
$phrase = str_replace($healthy, $yummy, $phrase);

//arriver débouler, pointer, rappliquer, se rabouler, se radiner.
$healthy = array(" pointer ", " rappliquer "," se rabouler "," se radiner ");
$yummy   = " arriver ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* manger - diner */
$healthy = array("alimentation","absorber","attaquer","avaler","becqueter","bouffer","boulotter","boustifailler","bredouiller","brouter","collationner","consommer","consumer","croquer","d\u00e9guster","d\u00e9jeuner","d\u00e9vorer","engloutir", "engouffrer", "entamer", "festoyer", "fricasser", "grignoter", "gueuletonner","ingurgiter","mastiquer","ronger","se gaver","se goinfrer","se restaurer", "souper", "diner", "bouffer");
$yummy   = "manger";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
apprendre :
approfondir, assimiler, éclairer, éveiller, renseigner, débrouiller, dégrossir, éduquer, enseigner,expliquer, farcir, guider, habituer, inculquer, initier, professer
*/

$healthy = array(" approfondir "," assimiler "," \u00e9clairer "," \u00e9veiller "," renseigner "," d\u00e9brouiller "," d\u00e9grossir "," \u00e9duquer "," enseigner "," expliquer "," farcir "," guider "," habituer "," inculquer "," initier "," professer ");
$yummy   = " apprendre ";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
comprendre:
admettre, comporter, compter, contenir, embrasser, inclure, incorporer, renfermer,appréhender, concevoir, déchiffrer, interpréter, pénétrer, saisir,réaliser, discerner, sentir, ouvrir, suivre */

$healthy = array(" admettre "," comporter "," compter "," contenir "," embrasser "," inclure "," incorporer "," renfermer "," appr\u00e9hender "," concevoir "," d\u00e9chiffrer "," interpr\u00e9ter "," p\u00e9n\u00e9trer "," saisir "," r\u00e9aliser "," discerner "," sentir "," ouvrir "," suivre ");
$yummy   = " comprendre ";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
ignorer :
méconnaître, méjuger,excepter, exclure, impliquer, négliger, omettre, ignorance, inaptitude
*/

$healthy = array("m\u00e9conna\u00eetre","m\u00e9juger","excepter","exclure","impliquer","n\u00e9gliger","omettre","ignorance","inaptitude", "se moquer");
$yummy   = "ignorer";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
savoir: 
acquis, aptitude, cognition, conception, connaissance, culture, doctrine, érudition, escient, expérience, humanisme, idée, lumières, omniscience, sagesse, science
connaître, posséder,dominer, pouvoir */

$healthy = array(" acquis "," aptitude "," cognition "," conception "," connaissance "," culture "," doctrine "," \u00e9rudition "," escient "," exp\u00e9rience "," humanisme "," id\u00e9e "," lumi\u00e8res "," omniscience "," sagesse "," science "," conna\u00eetre "," poss\u00e9der "," dominer "," pouvoir ");
$yummy   = " savoir ";
$phrase = str_replace($healthy, $yummy, $phrase);


// qu'es tu as fais aujourd'hui
// qu'est-ce que tu as fais aujourd'hui

/* météo : air, atmosphère, ciel, météorologie, nuage, pression, température, vent */
/* âge, air, ambiance, an, ancienneté, antériorité, atmosphère, aujourd'hui, avenir, brouillard, bruine, brume, cas, catégorie, 
chance, ciel, circonstance, climat, conjoncture, conjugaison, cycle, date, délai, demain, durée, éclaircie, embellie, époque, ère, 
espace, étape, étendue, évènement, facilité, futur, génération, hasard, instant, intempérie, jadis, jour, jours, marge, météo, météorologie, 
minute, mouvement, nuage, occasion, opportunité, orage, palier, passé, période, possibilité, postériorité, 
présent, régime, répit, rythme, saison, siècle, silence, stade, succession, sursis, température, temporalité, vent*/

$healthy = array(" m\u00e9t\u00e9o "," air "," atmosph\u00e8re "," ciel "," m\u00e9t\u00e9orologie "," nuage "," pression "," temp\u00e9rature "," vent "," bruine "," brouillard "," climat "," orage "," saison ");
$yummy   = " meteo ";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
intelligent: adroit, astucieux, capable, doué, éveillé, fort, habile, ingénieux, malin, perspicace, clairvoyant, judicieux, spirituel, subtil
*/

$healthy = array(' adroit ',' astucieux ',' capable ',' dou\u00e9 ',' \u00e9veill\u00e9 ',' fort ',' intelligent ',' ing\u00e9nieux ',' malin ',' perspicace ',' clairvoyant ',' judicieux ',' spirituel ',' subtil ');
$yummy   = ' habile ';
$phrase = str_replace($healthy, $yummy, $phrase);

/* alors à ce moment-là, adonc, ainsi, alors que, cependant, dans ces conditions, donc, eh, eh bien, en ce cas, en ce temps-là, et, lors, pour lors, puis, sur ces entrefaites */

$healthy = array(' adonc ',' ainsi ',' alors que ',' cependant ',' dans ces conditions ',' donc ',' en ce cas ',' ing\u00e9nieux ',' lors ',' puis ',' sur ces entrefaites ');
$yummy   = ' alors ';
$phrase = str_replace($healthy, $yummy, $phrase);

/*
temps: année, cycle, durée, heure, jour, minute, mois, seconde, siècle,époque, intervalle, après-midi, date, demain, ère, 
lendemain, matinée, moment, nuit, période, prochainement, rapidement, sans tarder, soirée, veille, saison */

$healthy = array(' ann\u00e9e ',' cycle ',' dur\u00e9e ',' heure ',' jour ',' minute ',' mois ',' seconde ',' si\u00e8cle ',' \u00e9poque ',' intervalle ',' apr\u00e8s-midi ',' date ',' demain ',' \u00e8re ',' lendemain ',' matin\u00e9e ',' moment ',' nuit ',' p\u00e9riode ',' prochainement ',' rapidement ',' sans tarder ',' soirée ',' veille ');
$yummy   = ' temps ';
$phrase = str_replace($healthy, $yummy, $phrase);


//argent artiche, biffeton, bifton, blé, boule, caillasse, flouze, fric, gengen, genhar, keusse, maille, neuthu, oseille, pépette, pèze, pognon, rond, thune, tune, zeillo, zeyo.
static $argent1 = array(' artiche ',' biffeton ',' bifton ',' boule ',' caillasse ',' flouze ',' fric ',' gengen ',' genhar ',' keusse ',' maille ',' neuthu ',' cailoseillelasse ',' pognon ',' rond ',' rond ',' thune ',' tune ');
static $argent2   = ' argent ';
$phrase = str_replace($argent1, $argent2, $phrase);

/* hein : comment, eh, hem, n'est-ce pas, pardon, plaît-il, quoi */
$healthy = array(" hein "," comment "," eh "," hem "," pardon ");
$yummy   = " quoi ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* sauf : à cela près, à l'exception de, à l'exclusion de, à la réserve de, bon, excepté, fors, hormis, hors, indemne, intact, moins, ôté, 
préservé, rescapé, sain, sain et sauf, sauvé, si, sinon, survivant, tiré d'affaire */

$healthy = array(" hormis ", " hors ", " indemne ", " moins "," si "," sinon ", " survivant ");
$yummy   = " sauf ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* cigarette : cibiche, clope, pipe, sèche, tige, tronc*/

$healthy = array(" cigarette ", " pipe ", " tige ", " tronc "," cigare ");
$yummy   = " clope ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* encore : aussi, avec cela, bis, cependant, davantage, de nouveau, de plus, du moins, mais, même, par surcroît, plus, rebelote, si seulement, toujours, une fois de plus */
$healthy = array(" aussi ", " bis "," cependant ", " davantage ", " mais ", " plus ", " toujours ");
$yummy   = " encore ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* voici : voila */
$healthy = array(" voici ", " voila ");
$yummy   = " voila ";
$phrase = str_replace($healthy, $yummy, $phrase);

// définition , spécification, explication, etymologie, signification, sens
$healthy = array(" signification "," explication "," etymologie ", " definition ");
$yummy   = " sens ";
$phrase = str_replace($healthy, $yummy, $phrase);


/*
être averti être calé être compétent être expert être informé être savant 
apercevoir apprécier appréhender
éprouver assavoir avoir connaissance avoir l'usage comprendre concevoir considérer constater discerner 
embrasser endurer entendre entrevoir estimer expérimenter juger pénétrer penser percevoir posséder pratiquer 
prendre reconnaître ressentir s'apercevoir sentir se préoccuper s'occuper subir supporter tenir de

*/
// sais
$healthy = array(' connais ', ' percois ', ' sais qui est ', ' apercevoir ', ' avoir connaissance ', ' ressentir ', ' supporter ');
$yummy   = ' sais ';
$phrase = str_replace($healthy, $yummy, $phrase);


$healthy = array('quelle est ', 'quel est ');
$yummy   = 'tu sais ';
$phrase = str_replace($healthy, $yummy, $phrase);

static $des1 = array(' des ', ' les ',' un ', ' le ',' une ', ' la ');
static $des2   = array(' des ', ' des ',' un ', ' un ',' la ', ' la ');
$phrase = str_replace($des1, $des2, $phrase);

static $ton1 = array(' ton ', ' ta ', ' tes ', ' tien ',' mon ', ' ma ', ' mes ', ' mien ');
static $ton2   = array(' ton ', ' ton ', ' ton ', ' ton ',' mon ', ' mon ', ' mon ', ' mon ');
$phrase = str_replace($ton1, $ton2, $phrase);

// le la
$healthy = array(' un ', ' la ');
$yummy   = ' le ';
$phrase = str_replace($healthy, $yummy, $phrase);


// le la
$healthy = array(' ils ', ' elles ');
$yummy   = ' les ';
$phrase = str_replace($healthy, $yummy, $phrase);

// simulées
$healthy = array(' simul\u00e9es ', ' simulation ', ' dissimulation ', ' simulacre ');
$yummy   = ' ruse ';
$phrase = str_replace($healthy, $yummy, $phrase);

$phrase = ltrim($phrase);
return $phrase;
}

?>
