<?php

define("MAXSIZE", 300);

/*
 * @Entr�e : $string un string et $c un caract�re
 * @Sortie : (int) nombre de mot dans $string contenant la caract�re $c 
 * qu'il soit majuscule ou minuscule (insensible � la case)
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

// RETOURNE UNE CHAINE AVEC LE NOMBRE MAXIMUM DE MOTS PASS� EN PRAM�TRE
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
    d�piter
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
    �bauche
    entreprise
    id�e
    intention
    pr�m�ditation
    programme
    propos
    sch�ma
    suggestion
    plan
    esquisse



     cynique, 5 synonymes

    d�bauch�
    effront�
    �hont�
    immoral
    impudent


     agnostique, 7 synonymes

    ath�e
    incroyant
    irr�ligieux
    non-croyant
    pa�en
    sceptique
    d�iste




     hypocrite, 19 synonymes

    artificieux
    captieux
    chafouin
    com�dien
    d�loyal
    dissimul�
    fourbe
    insidieux
    j�suite
    judas
    mielleux
    papelard
    patelin
    perfide
    sournois
    sucr�
    tartufe
    tortueux
    trompeur



       bucolique, 8 synonymes

    agreste
    campagnard
    champ�tre
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
    co�t
    combinaison
    communion
    concubinage
    conf�d�ration
    conjugaison
    f�d�ration
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
static $p_maxWord = MAXSIZE;   // On limite la phrase � 25 mots.
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

// O� est-ce qu'aura lieu votre r�union ? (ou mieux : o� aura lieu votre r�union ?).
static $c01 = array(" est-ce qu'");
static $c02   = " ";
$phrase = str_replace($c01, $c02, $phrase);

// est-ce que vous avez
static $d01 = array("est-ce que vous ", "est-ce que tu ");
static $d02   = "tu ";
$phrase = str_replace($d01, $d02, $phrase);

/* pas : gu�re, peu, � peine, brin, doigt, faiblement, f�tu, filet, goutte, grain, gramme, gu�re, imperceptiblement, insuffisamment, larme, l�g�rement, lueur,
maigrement, mal, m�diocrement, miette, mod�r�ment, modestement, 
moins que rien, ombre, once, pas beaucoup, pas grand-chose, pas tr�s, peu de chose, pointe, rarement, soup�on, tantinet, trace, vaguement*/

static $p01 = array(' &agrave; peine ', ' pas ', ' faiblement ', ' goutte ', ' grain ', ' gramme ', ' miette ',' modestement ', 
' gu�re ', ' l�g�rement ', ' m�diocrement ',' pas beaucoup ',' pas grand-chose ', ' peu de chose ', ' rarement ', ' vaguement ',' insuffisamment ',
' peu ', ' imperceptiblement ', ' vaguement ');
static $pf   = ' pas ';
$phrase = str_replace($p01, $pf, $phrase);

/* quiconque
�tre chacune chaque homme n'importe n'importe qui que qui soit
qui que ce soit */
static $e01 = array(" chaque homme ", " n'importe qui ", " qui que ce soit ", " chacune ", " chacun ");
static $e02   = " quiconque ";
$phrase = str_replace($e01, $e02, $phrase);


// brusquement
// abruptement � br�le-pourpoint � l'improviste br�le-pourpoint brutalement dare-dare ex abrupto
// h�tivement inopin�ment nerveusement net pr�cipitamment raide s�chement soudainement subito vite.
static $f01 = array(' brusquement ', ' abruptement ', ' brutalement ', ' dare-dare ', ' nerveusement ', 
' vite ', ' soudainement ', ' h�tivement ', ' inopin�ment ', ' pr�cipitamment ', ' subito ');
static $f02   = ' net ';
$phrase = str_replace($f01, $f02, $phrase);

// ceci : cela    // farte     //  a chaque
static $g01 = array(' ceci ',' cela ',' farte ',' baigne ',' roule ', ' boom ',' a chaque ');
static $g02 = array(' cela ',' cela ',' va ',' va ',' va ', ' va ',' de ');
$phrase = str_replace($g01, $g02, $phrase);

//  laquelle, lesquels, lesquelles : dont, qu, que, qui, quoi
// � laquelle, auquel, auxquelles, auxquels, de laquelle, desquelles, desquels, duquel, quoi
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




/* normalement : correctement, habituellement, logiquement, naturellement, ordinairement, r�guli�rement */
static $l01 = array(' correctement ', ' habituellement ', ' logiquement ', ' naturellement ',' ordinairement ',' r�guli�rement ');
static $l02   = ' normalement ';
$phrase = str_replace($l01, $l02, $phrase);

/* reponse : apologie, contrecoup, d�fense, �cho, justification, objection, oracle, r�action, r�crimination, r�futation, repartie, r�plique, rescrit, r�sultat, r�torsion, riposte, solution, verdict */
static $m01 = array(' apologie ', ' contrecoup ', ' defense ', ' echo ',' justification ', ' objection ',' oracle ',' reaction ',' repartie ',' rescrit ',' resultat ',' riposte ',' solution ',' verdict ');
static $m02   = ' reponse ';
$phrase = str_replace($m01, $m02, $phrase);



/* magie : alchimie, diablerie, divination, ensorcellement, herm�tisme, occultisme, philtre, sorcellerie, sortil�ge, thaumaturgie, th�urgie */
//charme, influence, prestige, s�duction
// attir�, captiv�, enchant�, enivr�, enj�l�, ensorcel�, fascin�, gris�, ravi, r�joui, s�duit
static $ma1 = array(' alchimie ', ' diablerie ', ' divination ', ' ensorcellement ',' occultisme ',' philtre ', ' sorcellerie ',' thaumaturgie ');
static $ma2 = array(' charme ', ' influence ', ' prestige ', ' s�duction ', ' attir� ', ' captiv� ', ' enchant� ', ' ravi ', ' s�duit ');
static $ma0   = ' magie ';
$ma = array_merge ($ma1,$ma2);
$phrase = str_replace($ma, $ma0, $phrase);

/* question : affaire, article, chapitre, charade, colle, controverse, d�lib�ration, demande, devinette, difficult�, discussion, �nigme, �preuve, examen, g�henne, g�ne, hic, information, 
interpellation, interrogation, mati�re, point, probl�matique, probl�me, punition, questionnement, revendication, sujet, supplice, th�me, torture*/

//affaire biz, business, deal, dj�se, nesbi.
static $n01 = array(' biz ',' deal ',' nesbi ',' business ',' affaire ', ' article ', ' chapitre ', ' charade ',' colle ',
' controverse ', ' demande ',' devinette ',' discussion ',' examen ',' information ',' interpellation ',' interrogation ',
' point ',' punition ',' questionnement ',' revendication ',' supplice ',' torture ',' theme ',' probleme ');
static $n02   = ' question ';
$phrase = str_replace($n01, $n02, $phrase);

/* apparence : chim�re, clair-obscur, conjecture, crainte, doute, erreur, 
�ventualit�, hypoth�se, illusion, incertitude, ind�cision, ind�termination, pari, perplexit�, probabilit�, risque, scepticisme, soup�on, vacillation, vraisemblance*/

static $o1 = array(' clair-obscur ', ' conjecture ', ' crainte ', ' doute ',' erreur ',' illusion ', ' pari ',' scepticisme ',' vacillation ',' vraisemblance ');
static $o2   = ' apparence ';
$phrase = str_replace($o1, $o2, $phrase);

/* apparence : abord �clat �corce affectation air allure �piderme appareil apparemment aspect biens�ance bouille brillant
cachet caract�re carnation contenance convenance 
d�cor dehors endroit ext�rieur ext�rieurement fa�ade
face faci�s fant�me faux-semblant figure forme front habit id�e imitation jour livr�e
look masque mine mirage montre ombre ostentation para�tre ph�nom�ne phase physionomie plausibilit� 
pr�texte pronostic rayon ressemblance semblance semblant simulacre singerie soup�on superficie surface
symbole tape-�-l'oeil touche tournure trait type vernis vestige visage visibilit� voile vraisemblance */

static $p1 = array(' apparence ', ' abord ', ' affectation ', ' air ',' allure ',' apparemment ', ' aspect ',' contenance ',' convenance ', ' faux-semblant ', ' mirage ', 
' faci�s ', ' bouille ',' figure ', ' forme ', ' front ', ' habit ', ' imitation ', ' look ', ' masque ', ' ombre ', ' ostentation ',' physionomie ', 
' ressemblance ', ' semblance ',' semblant ', ' simulacre ', ' symbole ', ' trait ', ' type ', ' vernis ', ' vestige ', ' visage ', ' vraisemblance ', 
' superficie ', ' fa�ade ', ' �piderme ');
static $p0   = ' face ';
$phrase = str_replace($p1, $p0, $phrase);

/* couleur   :�clat allure animation �tiquette bariolage brillant caract�re carnation c�t� colorant coloration 
coloris demi-teinte dire drapeau enluminure enseigne ext�rieur fard figure force franchement gouache motif nuance 
oriflamme pavillon peinture physionomie pigment
pittoresque pr�texte raison sous teint teinte teinture ton tonalit� tour tournure truculence vie vigueur  */

static $q01 = array(' allure ', ' brillant ', ' colorant ', ' coloration ',' coloris ',' demi-teinte ', ' gouache ',' nuance ',' teint ',' teinte ',' teinture ');
static $q02   = ' couleur ';
$phrase = str_replace($q01, $q02, $phrase);

/* certitude : assurance, autorit�, clart�, confirmation, conviction, croyance, dogme, esp�rance, 
espoir, �vidence, fermet�, foi, infaillibilit�, nettet�, opinion, parole d'�vangile, persuasion, r�alit�, stabilit�, s�ret�, v�rit�*/

static $r01 = array(' assurance ', ' confirmation ', ' conviction ', ' croyance ',' dogme ',' espoir ', ' foi ',' opinion ',' persuasion ');
static $r02   = ' certitude ';
$phrase = str_replace($r01, $r02, $phrase);

/* pose : affectation, aff�terie, application, appr�t, assiette, attitude, cambrure, coffrage, �tablissement, ext�rieur, fa�on, installation, mani�re, 
mani�risme, mise en place, mod�le, orgueil, p�dantisme, photographie, posage, position, posture, pr�tention, recherche, snobisme, sottise*/

static $s01 = array(' affectation ', ' application ', ' attitude ', ' installation ',' mise en place ',' photographie ', ' posage ',' position ',
' posture ',' recherche ',' snobisme ',' sottise ',' orgueil ',' cambrure ');
static $s02   = ' pose ';
$phrase = str_replace($s01, $s02, $phrase);


static $legume1 = array(' l�gume ', ' aubergine ', ' chou ', ' gousse ',' gros bonnet ',' huile ', ' notabilit� ',' personnalit� ',' primeur ');
static $legume2   = ' legume ';
$phrase = str_replace($legume1, $legume2, $phrase);

/* drole : amusant, badin, beau, bidonnant, bizarre, bon, bouffon, bougre, briscard, cocasse, comique, coquin, curieux, d�sopilant, diable, divertissant, 
drolatique, �gayant, enfant, �tonnant, �trange, extraordinaire, extravagant, fac�tieux, fantastique, farce, farceur, farfelu, fichu, fier, folichon, 
fripouille, gai, gaillard, gamin, gar�on, gondolant, gosse, hilarant, homme, impayable, in�narrable, insolite, lascar, le plus beau, maraud, marrant, 
num�ro, original, pierrot, pittoresque, plaisant, poilant, polisson, r�cr�atif, r�jouissant, ridicule, 
rigolo, risible, rocambolesque, rude, sensationnel, singulier, spirituel, surprenant, tordant, truand, truculent, turlupin, type, vaurien */

static $t01 = array(' amusant ', ' badin ', ' bidonnant ', ' bizarre ',' bouffon ',' bougre ',' briscard ',' cocasse ',' comique ',' coquin ',
' curieux ',' diable ',' divertissant ',' drolatique ',' enfant ',' extravagant ',' fantastique ',' farce ',' farceur ',' fichu ',' folichon ',
' fripouille ',' gai ',' gaillard ',' gamin ',' gosse ',' hilarant ',' impayable ',' insolite ',' lascar ',' maraud ',' marrant ',' original ',
' pittoresque ',' plaisant ',' poilant ',' ridicule ',' rigolo ',' risible ',' rocambolesque ',' sensationnel ',' singulier ',' surprenant ',
' tordant ',' truand ',' truculent ',' turlupin ',' type ',' vaurien ');
static $t02   = ' drole ';
$phrase = str_replace($t01, $t02, $phrase);

// 	dangereux, dramatique, grave, inqui\u00e9tant, menace, appliqu\u00e9, attentif, r\u00e9fl\u00e9chi
// avertissement, bravade, chantage, commination, danger, d�fi, fulmination, grondement, insulte, intimidation, p�ril, point noir, pr�sage, pression, provocation, r�primande, risque, rodomontade, sommation, spectre, ultimatum
static $u01 = array(' dangereux ', ' dramatique ', ' grave ', ' inqui\u00e9tant ', ' menace ',' appliqu\u00e9 ',' attentif ',
' r\u00e9fl\u00e9chi ', ' s\u00e9rieux ', ' serieux ',' avertissement ',' chantage ',' danger ',' grondement ',' insulte ',
' intimidation ',' pression ',' provocation ',' risque ',' sommation ',' ultimatum ');
static $u02   = ' dure ';
$phrase = str_replace($u01, $u02, $phrase);

/* l�ger : a�r� a�rien �cervel� agile agr�able �grillard ail� �l�gant �lanc� 
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
spirituel succinct superficiel svelte t�m�raire t�nu transparent vain v�niel vaporeux versatile vide vif volage */

static $v1 = array(' pas dure ', ' creux ', ' digeste ', ' digestible ', ' discret ',' discret ',' doux ',' enfantin ',' souple ', ' flou ', ' fluet ', ' fragile ', ' fringant ', ' minime ', ' philosophe ');
static $v2 = array(' l�ger ', ' agile ', ' agr�able ', ' �l�gant ', ' �lanc� ',' all�g� ',' all�gre ',' anodin ',' bel esprit ', ' d�licat ', ' fr�le ', ' futile ', ' inaudible ', ' incons�quent ', ' inconsid�r� ');
static $v3 = array(' ind�celable ', ' indiscernable ', ' infime ', ' l�ge ', ' mondain ',' n�gligeable ',' portatif ',' sommaire ',' habile ', ' succinct ', ' superficiel ', ' transparent ', ' vaporeux ');
static $v0   = ' fin ';
$v = array_merge ($v1,$v2,$v3);
$phrase = str_replace($v, $v0, $phrase);

/* �rotisme bas-ventre clitoris con cul entrecuisse f�minit� membre viril 
nature nymphes organes g�nitaux p�nis parties pubis qu�quette queue sexualit� vagin verge virilit� vulve chnek*/

static $w01 = array(" bite ", " chatte ", " clitoris ", " cul "," entrecuisse "," pubis "," vagin "," foufoune ", " vulve ", " chnek ", " schneck ");
static $w02   = " sexe ";
$phrase = str_replace($w01, $w02, $phrase);

//  distrait
static $x1 = array(' irr�fl�chi ', ' irresponsable ', ' insouciant ', ' infid�le ', ' inconscient ',' impond�rable ',' impr�voyant ',' inattentif ',' oublieux ', ' je m\'en fichiste ', ' oublieux ', ' frivole ', ' tromp� ');
static $x2 = array(' �tourdi ', ' absent ', ' imprudent ', ' inattentif ', ' indiff�rent ',' insouciant ',' irr�fl�chi ',' nonchalant ',' oublieux ', ' �cervel� ', ' frivole ', ' dissip� ', ' changeant ', ' singerie ');
static $x3 = array(' capricieux ', ' cavaleur ', ' n�gligent ', ' amus� ', ' chang� ', ' d�bauch� ', ' d�rang� ', ' d�rid� ', ' diverti ', ' �gay� ', ' inappliqu� ', ' pr�lev� ', ' retranch� ', ' r�veur ', ' s�par� ');
static $x0   = ' distrait ';
$x = array_merge ($x1,$x2,$x3);
$phrase = str_replace($x, $x0, $phrase);

/* con : aberrant, ballot, ben�t, b�ta, b�te, chatte, connard, couillon, cr�tin, cul, dinde, emmanch�, foufoune, idiot, imb�cile, niais, sexe, sot, vulve 
aberrant abruti absurde ahuri andouille arri�r� b�ta b�te ballot born� bouch� brute cloche con corniaud cornichon
 cr�tin cruche cul d�bile d�g�n�r� d�raisonnable emmanch� faible d'esprit fou g�teux ignorant imb�cile incons�quent
inepte inintelligent injuste innocent insens� jacques manche minus niais nul retard� simple simple d'esprit sot
bite, blaire, branque, con, conno, connard, couillon, deb, d�be, gogol, gol, golio, golmon, mongol, mongolito, nouille, teb�.
*/
static $con1 = array(' aberrant ', ' ballot ', ' connard ', ' couillon ',' idiot ',' niais ',' abruti ',' andouille ',' corniaud ',' ignorant ',' minus ',' sot ', ' cr�tin ');
static $con2 = array(' stupide ', ' bite ', ' blaire ', ' branque ', ' conno ', ' connard ', ' couillon ', ' gogol ', ' golmon ', ' mongol ', ' mongolito ', ' nouille ', '  teb� ');
static $con3 = array(' vide ', ' ahuri ', ' brute ', ' cloche ', ' cornichon ', ' cruche ', ' d\'esprit vide ', ' inepte ', ' inintelligent ', ' innocent ', ' manche ', ' simple d\'esprit ');
static $con4 = array(' stupide ', ' deb ', ' gol gol ', ' d�bile ', ' d�g�n�r� ', ' d�raisonnable ', ' emmanch� ', ' born� ', ' bouch� ',' g�teux ', ' b�te ', ' arri�r� ', ' imb�cile ');
static $con   = ' con ';
$conarray = array_merge($con1,$con2,$con3,$con4);
$phrase = str_replace($conarray, $con, $phrase);

/* impossible  : absurde, acari�tre, bizarre, chim�rique, contradictoire, difficile, dur, �pineux, 
extravagant, fou, id�al, illusoire, imaginaire, immat�riel, impensable, impraticable, inabordable, 
inaccessible, inadmissible, inapplicable, incompatible, inconcevable, inconciliable, incroyable, indu, 
inexcusable, inex�cutable, inextricable, infaisable, inimaginable, inou�, insens�, insociable, insoluble, insoutenable, insupportable, 
insurmontable, intenable, intol�rable, intraitable, invivable, invraisemblable, irr�alisable, irrecevable, malcommode, odieux, p�nible, 
rev�che, ridicule, rocambolesque, utopique, vain*/

static $vain1 = array(' absurde ', ' bizarre ', ' contradictoire ', ' difficile ',' impossible ',' extravagant ',' fou ',' illusoire ',' imaginaire ',' impensable ',' impraticable ',' inabordable ',' inaccessible ',' inadmissible ',' inapplicable ',' incompatible ',' inconcevable ',' inconciliable ',' incroyable ',' indu ',' inexcusable ',' inextricable ',' infaisable ',' inimaginable ',' insociable ',' insoluble ',' insoutenable ',' insupportable ',' insurmontable ',' intenable ',' intraitable ',' invivable ',' invraisemblable ',' irrecevable ',' malcommode ',' odieux ',' ridicule ',' rocambolesque ',' utopique ',' vain ');
static $vain2   = ' vain ';
$phrase = str_replace($vain1, $vain2, $phrase);

/* possible : abordable, acceptable, accessible, admissible, buvable, 
commode, contingent, convenable, correct, croyable, d�cent, envisageable, �ventuel, 
ex�cutable, facile, faisable, futur, imaginable, loisible, mangeable, passable, pensable, permis, peut-�tre, plausible, potable, potentiel, 
praticable, pratique, pr�visible, probable, r�alisable, sortable, soutenable, supportable, tol�rable, tol�r�, virtualit�, virtuel, vivable, vraisemblable*/

static $facile1 = array(' abordable ', ' acceptable ', ' accessible ', ' admissible ',' buvable ',' commode ',' contingent ',' convenable ',' correct ',' croyable ',' envisageable ',' possible ',' faisable ',' imaginable ',' loisible ',' passable ',' permis ',' plausible ',' potable ',' potentiel ',' praticable ',' pratique ',' probable ',' sortable ',' soutenable ',' supportable ',' vivable ',' vraisemblable ');
static $facile2   = ' facile ';
$phrase = str_replace($facile1, $facile2, $phrase);


/* choses : action, affaire, babiole, bagatelle, batifolage, bidule, bricole, capital, circonstance, condition, esclave, �v�nement, fourbi, 
instrument, machin, objet, patrimoine, ph�nom�ne, possession, propri�t�, r�alit�, richesse, sujet, truc, trucmuche */

static $chose1 = array(' action ', ' affaire ', ' babiole ', ' bagatelle ',' batifolage ',' bidule ',' bricole ',' capital ',' circonstance ',' condition ',' esclave ',' fourbi ',' instrument ',' machin ',' objet ',' patrimoine ',' possession ',' richesse ',' sujet ',' truc ',' trucmuche ');
static $chose2   = ' choses ';
$phrase = str_replace($chose1, $chose2, $phrase);

/* nullement: pas du tout, pas le moins du monde, point, que nenni */

static $null1 = array(' pas du tout ', ' que nenni ', ' pas le moins du monde ', ' certainnement pas ', ' vraiment pas ');
static $null2   = ' nullement ';
$phrase = str_replace($null1, $null2, $phrase);


/* formidable : admirable, architectural, baron, beau, boeuf, bon, chic, chope, colossal, consid�rable, dantesque, d�ment, d�mesur�, demi, du tonnerre, 
effrayant, �norme, �patant, �poustouflant, �pouvantable, �tonnant, extraordinaire, extravagant, fabuleux, fameux, fantasmagorique, fantastique, faramineux, 
fort, fumant, g�nial, gigantesque, gros, immense, impeccable, imposant, impressionnant, incalculable, inou�, invraisemblable, le plus beau, magnifique, 
marrant, m�chant, merveilleux, mirifique, mirobolant, monstrueux, monumental, notable, ph�nom�nal, prestigieux, prodigieux, redoutable, 
remarquable, renversant, rocambolesque, sensationnel, signal�, soufflant, stup�fiant, super, sup�rieur, surprenant, terrible, titanesque, verre

super : aspirer, aux pommes, dingue, �patant, �tonnant, formidable, g�nial, gober, merveilleux, s'obstruer, se boucher, supercarburant, surprenant
�tonnant beau dingue essence extraordinaire  formidable g�nial gober lamentable merveilleuse miraculeux sensationnelle surnaturelle
*/

static $super1 = array(' admirable ', ' architectural ', ' baron ', ' chic ',' colossal ',' dantesque ',' extravagant ',' fabuleux ',' fameux ',' fantasmagorique ');
static $super2 = array(' fantastique ',' faramineux ',' gigantesque ',' immense ',' impeccable ',' imposant ',' impressionnant ',' incalculable ',' magnifique ',' mirifique ');
static $super3 = array(' monumental ',' notable ',' prestigieux ',' prodigieux ',' redoutable ',' remarquable ',' renversant ',' rocambolesque ',' sensationnel ',' soufflant ');
static $super4 = array(' titanesque ',' mirobolant ',' terrible ', ' consid�rable ', ' d�ment ',' d�mesur�du ',' tonnerre ',' effrayant ',' inou� ',' d�mesur� ',' sup�rieur ');
static $super5 = array(' �norme ',' �patant ',' �poustouflant ',' �pouvantable ',' �tonnant ',' extraordinaire ',' formidable ',' merveilleuse ',' remarquable ',' ph�nom�nal ');
static $super6 = array(' dingue ', ' formidable ', ' merveilleux ', ' surprenant ', ' sensationnelle ', ' surnaturelle ', ' g�nial ',' miraculeux ',' stup�fiant ', ' remarquable ');
$super = array_merge ($super1,$super2,$super3,$super4,$super5,$super6);
static $super0   = ' super ';
$phrase = str_replace($super, $super0, $phrase);

/* bas : faible abattu, aboulique, accommodant, adynamique, affaibli, amour, an�anti, an�mi�, an�mique, apathique, asth�nique, attaquable, attirance, avorton, azt�que*, bas, b�nin, bl�che, bl�me,
bonasse, born�, bouch�, branlant, cacochyme, caduc, cassant, cass�, chancelant, ch�tif, complaisance, complaisant, cotonneux, coulant, crev�, critiquable, d�bile, d�bonnaire, d�faillant, d�faut, 
d�ficient, d�labr�, d�licat, d�li�, d�prim�, d�risoire, d�sarm�, difforme, douteux, doux, �branlable, entra�nable, �puis�, �tiol�, �touff�, �troit, exsangue, fade, faiblard, faiblesse, 
falot, fatigu�, fluet, fr�le, freluquet, go�t, gr�le, gringalet, imb�cile, imperceptible, imperfection, impersonnel, impotent, impuissant, incertain, inclination, incolore, inconsistant, 
inconstant, ind�cis, inefficace, inerte, inf�riorit�, infirme, influen�able, insignifiant, instable, insuffisant, invalide, labile, l�che, lamentable, languissant, las, l�ger, limit�, 
lymphatique, maigre, maladif, malheureux, malingre, mall�able, manie, mauvais, mauviette, m�chant, m�diocre, menu, minable, mince, mod�r�, mollasse, mou, mourant, moyen, 
n�gligeable, nul, obtus, ouat�, p�le, patraque, pauvre, penchant, pente, petit, pi�tre, pitoyable, pliant, pr�caire, pr�dilection, pr�f�rence, propension, pusillanime, rabougri, ramolli, 
r�duit, r�futable, sans volont�, simple, souffreteux, sympathie, tendre, titubant, travers, vacillant, vague, vell�itaire, veule, vice, volage, vuln�rable
*/

static $bas1 = array(" abattu ", " affaibli ", " commun ", " apathique ", " attaquable "," avorton ", " faible "," caduc "," cassant "," chancelant "," critiquable "," douteux "," fade "," faiblard "," faiblesse "," falot "," fluet "," freluquet "," gringalet "," imperceptible "," imperfection "," impersonnel "," impotent "," impuissant "," incertain "," inconsistant "," indigent "," inefficace "," inerte "," infirme "," insignifiant "," insuffisant "," inconstant "," instable "," invalide "," labile "," lamentable "," languissant "," las "," lymphatique "," maigre "," maladif "," malheureux "," malingre "," mauvais "," mauviette "," menu "," minable "," mince "," mollasse "," mou "," mourant "," obtus "," patraque "," petit "," pitoyable "," pliant "," ramolli "," simple "," souffreteux "," tendre "," travers "," vacillant "," vague "," veule "," vice "," volage ");
static $bas2   = " bas ";
$phrase = str_replace($bas1, $bas2, $phrase);

/* moyen : acceptable, agent, arme, art, artifice, astuce, banal, b�quille, biais, bon, bourgeois, calcul, canal, capacit�, cause, chance, chemin, combinaison, combine, commun, lambda, m�dian, m�diocre, m�moire, mesure, 
m�thode, mitoyen, modalit�, mode, mod�r�, modeste, modique, m�r, normal, occasion, op�ration, passable, pauvre, pi�ge, plan, planche de salut, porte, possibilit�, potable, pouvoir, pr�texte, proc�d�, proc�dure, quelconque, terne, tol�rable*/
static $moyen1 = array(" acceptable ", " banal ", " commun ", " juste ", " lambda "," modeste ", " modique "," passable "," potable "," quelconque "," terne ");
static $moyen2   = " moyen ";
$phrase = str_replace($moyen1, $moyen2, $phrase);

/* haut : aigu, altier, ancien, apog�e, arrogant, beau, bon, c�leste, colline, comble, consid�rable, 
couronnement, cr�te, culminant, d�daigneux, d�mesur�, dessus, digne, dominant, dress�, �clatant, �difiant, �lanc�, �l�vation, �lev�, �loign�, �minence, 
�minent, �pic�, �th�r�, exag�r�, exemplaire, extr�me, fa�te, fier, fl�che, fort, fortement, fortun�, franchement, front, grand, gros, hautain, hautement, 
hauteur, h�ro�que, important, intense, intens�ment, lev�, loin, long, nettement, noble, noeud, orgueilleux, ouvertement, per�ant, perch�, pinacle, pointe, 
pro�minent, profond, publiquement, puissant, recul�, relev�, remarquable, rench�ri, r�sonnant, retentissant, ronflant, 
sommet, sommit�, sonore, sourcilleux, soutenu, sublime, superbe, sup�rieur, supr�me, sur�lev�, t�te, toiture, tonitruant, transcendant, vibrant, vieux, vif*/

static $haut1 = array(" aigu ", " ancien ", " colline ", " comble "," dessus "," digne "," dominant "," hautement "," hauteur "," important "," intense "," nettement "," pointe "," profond "," publiquement "," puissant "," remarquable "," retentissant "," sommet "," sublime "," superbe "," toiture "," tonitruant "," transcendant "," vibrant "," vieux "," vif ");
static $haut2   = " haut ";
$phrase = str_replace($haut1, $haut2, $phrase);

/* normal : ais�, arr�t�, bien portant, calcul�, canonique, classique, compr�hensible, correct, courant, d�cid�, d�termin�, dispos,
 exact, fix�, habituel, honn�te, inn�, journalier, l�gitime, logique, mesur�, m�thodique, moyen, naturel, ordinaire, ordonn�, organis�, perpendiculaire,
 ponctuel, pr�visible, quotidien, raisonnable, rang�, rationnel, r�gl�, r�gulier, robuste, sain, solide, syst�matique, traditionnel, valable*/
 
static $normal1 = array(" bien portant ", " canonique ", " classique ", " correct "," courant "," dispos "," exact "," habituel "," journalier "," logique "," moyen "," naturel "," ordinaire "," perpendiculaire "," ponctuel "," quotidien "," raisonnable "," rationnel "," robuste "," sain "," solide "," traditionnel ", " valable ");
static $normal2   = " normal ";
$phrase = str_replace($normal1, $normal2, $phrase);
  
 /* dramatique : burlesque, caricatural, cocasse, comique, grotesque, ridicule, th��tral
  	bouffonne, calamiteuse, catastrophique, dangereux, grave, gravissime, passionnant, p�nible, s�rieuse, s�rieux, tragique     */
  
static $veux1 = array("voudrais", "d\u00e9sire", "d\u00e9sires", "voeux","souhaits","serments","promesses");
static $veux2   = "veux";
$phrase = str_replace($veux1, $veux2, $phrase);
  
/* aim� : ador�, affectionn�, appr�ci�, ch�ri, estim�, go�t�, idol�tr�, raffol�, v�n�r� */

static $aime1 = array("aim\u00e9", "ador\u00e9", "affectionn\u00e9", "appr\u00e9ci\u00e9", "ch\u00e9ri","estim\u00e9","go�t\u00e9","idol�tr\u00e9","raffol\u00e9","v\u00e9n\u00e9r\u00e9");
static $aime2   = "aime";
$phrase = str_replace($aime1, $aime2, $phrase);

static $matrix1 = array(" neo ", " morpheus ", " trinity ", " cypher ", " tank ");
static $matrix2   = " matrix ";
$phrase = str_replace($matrix1, $matrix2, $phrase);


/* lire :d�chiffrer, �peler, bouquiner, compulser, consulter, d�vorer, feuilleter, parcourir, relire,�noncer, r�citer, d�chiffrer, d�coder
	diffuser, transcrire, d�couvrir, deviner */
		
static $lire1 = array("bouquiner", "compulser", "consulter", "feuilleter", "parcourir", "relire","conseiller","diffuser","deviner");
static $lire2   = "lire";
$phrase = str_replace($lire1, $lire2, $phrase);

static $ecrire1 = array("\u00e9crire", "griffonner","accentuer", "consigner", "exposer","exprimer", "griffonner", "raviver", "correspondre", "d\u00e9crire","inscrire", "libeller", "marquer", "noter", "pondre","pondre", "r\u00e9diger", "tartiner", "transcrire", "conjuguer","orthographier","composer", "concevoir", "controuver", "engendrer","exprimer", "faire", "forger", "produire","enregistrer","inscrire", "esquisser", "inscrire", "marquer", "ecrire");
static $ecrire2   = "ecrire";
$phrase = str_replace($ecrire1, $ecrire2, $phrase);

//Antonymes : annihiler, annuler, biffer, effacer, gratter, racheter*/

/*
�tre: entit�, existence

	abstraction
Antonymes : non-�tre, �me, entit�
Antonymes : n�ant

	cr�ature, individu, personne
(en �tre �) se voir r�duit �
(�tre de) provenir
(�tre sans) manquer de

accomplir, exister, r�aliser, subsister, vivre
appartenir, r�sider, tenir, trouver */



// c\u00e9der, marchander, monnayer, r\u00e9troc\u00e9der, revendre
/*
 �changer �couler adjuger ali�ner bazarder brader brocanter c�der cameloter
conserver d�barrasser d�biter d�faire d�noncer d�tailler donner exporter faire fournir laisser lessiver 
liquider livrer marchander m�vendre monnayer n�gocier offrir placer prostituer r�aliser r�troc�der revendre 
sacrifier s'ali�ner se d�barrasser se d�faire s'enlever servir se s�parer solder trafiquer trahir
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
acte, acte authentique, annales, archives, contrat, copie, dossier, �crit, feuille, justificatif, maquette, mat�riau, original, papier, pi�ce, preuve, renseignement, t�moignage, texte, titre
*/
static $doc1 = array(" feuilles ", " fiches ", " documents "," fichier ", " note "," acte "," contrat "," dossier "," feuille "," papier "," texte "," titre ", " document");
static $doc2   = " doc ";
$phrase = str_replace($doc1, $doc2, $phrase);

// accoucheur, allopathe, chirurgien, doctoresse, hom\u00e9opathe, l\u00e9giste, omnipraticien, ost\u00e9opathe, psychiatre, toubib
static $docteur1 = array("docteur", "m\u00e9decin", "g\u00e9n\u00e9raliste","accoucheur","allopathe","chirurgien","doctoresse","hom\u00e9opathe","l\u00e9giste","omnipraticien","ost\u00e9opathe","psychiatre","toubib");
static $docteur2   = "docteur";
$phrase = str_replace($docteur1, $docteur2, $phrase);

/* agent de liaison, article, avant-courrier, bateau, car, chronique, coche, coin, correspondance, d�p�che, estafette, exp�dition, lettre, messager, messagerie, paquet, porteur, poste */
static $mail1 = array(" mail ", " email ", " courriel ", " courrier ", " poste "," lettre "," correspondance "," article "," messager "," messagerie "," porteur "," articles ");
static $mail2   = " mail ";
$phrase = str_replace($mail1, $mail2, $phrase);

// 	dire : discuter, communiquer, converser, deviser, dialoguer, parler
/* annoncer, apprendre, commander, confier, correspondre, d�clarer, d�couvrir, desservir, 
divulguer, donner, �changer, �crire, enflammer, enseigner, envahir, envoyer, �pancher, �tre en rapport, 
faire conna�tre, faire part de, faire savoir, flanquer, gagner, impr�gner, imprimer, indiquer, infuser, inoculer, inspirer, insuffler, jeter, livrer, mander, notifier, 
partager, passer, pr�ter, propager, publier, relier, r�v�ler, s'aboucher, s'�crire, s'entendre, s'ouvrir, se commander, signaler, signifier, transmettre*/

static $dire1 = array(" discuter ", " communiquer ", " converser "," deviser ", " dialoguer ", " parler "," annoncer "," commander "," confier "," correspondre "," divulguer "," donner "," enflammer "," enseigner "," envahir "," envoyer "," imprimer "," infuser "," inspirer "," insuffler "," jeter "," livrer "," mander "," notifier "," partager "," passer "," propager "," publier "," relier "," s'entendre "," signaler "," signifier "," transmettre ");
static $dire2   = " dire ";
$phrase = str_replace($dire1, $dire2, $phrase);

/*
accord �chelle �conome �conomie acte anthropom�trie appr�ciation 
approximation �quilibre �talon �valuation batterie borne cadence calcul calcul� 
capacit� charge circonspect circonspection combinaison comparaison contenance contre-mesure cote 
cruchon d�termination degr� dimension discret disposition dose estimation force gabarit grandeur 
habilit� importance jaugeage juste milieu m�nagement mani�re m�tr� m�tre m�trique m�trologie mensuration mesurage 
milieu mod�r� mod�ration mouvement moyen norme penchant po�sie poids point pond�ration pot pr�caution pr�cautionneux 
pr�cision pr�paratif profondeur proportion prudence prudent quantification quantit� quart r�cipient r�gle rapport 
r�serve ration retenue rythme sagesse sens sobri�t� statistique stature taille tasse temp�rament temp�rance tempo 
terme toise tonneau unit� valeur vers versification
*/

static $metres1 = array(" contenance "," mesure ", " taille ", " hauteur ", " grandeur ", " cime "," altitude ", " m\u00e8tres "," metres ", " stature ", " valeur ", " poids ", " mesurage ");
static $metres2   = " metres ";
$phrase = str_replace($metres1, $metres2, $phrase);

// J'ai envis, j'aimerait, je r\u00eave, ma passion, mon envie, mes
static $hobby1 = array(" r\u00eave ", " voudrait ", " aimerait ", " int\u00e9r\u00eat ", " interet "," envie ", " hobby "," passion "," passions ", " manie ");
static $hobby2   = " hobby ";
$phrase = str_replace($hobby1, $hobby2, $phrase);

/*
accouchement, activit�, affaire, amortissement, application, art, besogne, 
boulot, bras, bricolage, bricole, brocante, business, canevas, casse-t�te, cassement,
. chef-d'oeuvre, cheminement, corv�e, devoir, difficult�, �crit, effort, �laboration, emploi, enfantement,
 entra�nement, entreprise, �tat, �tude, �tudes, ex�cution, exercice, fa�on, facture, fatigue, fermentation,
 fonction, fonctionnement, force, forme, gagne-pain, gauchissement, g�sine, gymnastique, huile de coude, industrie,
 int�rim, job, labeur, livre, main-d'oeuvre, mal, mal d'enfant, marche, mastic, m�tier, mission, occupation, oeuvre, op�ration,
 ouvrage, peine, pensum, place, plan, poste, prestation, production, 
profession, programme, recherche, r�paration, r�le, sape, service, situation, soin, sp�cialit�, sueur, t�che, tintouin, turbin, veille, z�le*/

static $job1 = array(' travail ', ' travaille ', ' m\u00e9tier ', ' profession ', ' boulot ',' job ', ' travailler ',' bricole ',
' brocante ',' business ',' devoir ',' effort ',' emploi ',' entreprise ',' exercice ',' fermentation ',' fonction ',' fonctionnement ',
' industrie ',' labeur ',' mission ',' occupation ',' ouvrage ',' peine ',' production ',' situation ',' turbin ',' service ',' recherche ',' fatigue ');
static $job2   = ' job ';
$phrase = str_replace($job1, $job2, $phrase);


static $fruit1 = array(' aboutissement ', ' agrume ', ' ak�ne ', ' avantage ', ' boulot ',' baie ', ' b�n�fice ',' conclusion ',
' cons�quence ',' couronnement ',' d�nouement ',' effet ',
' grain ',' graine ',' moisson ',' pomme ',' production ',' produit ',' profit ',' ran�on ',' recette ',
' rejeton ',' ressource ',' revenu ',' suite ',' situation ',' usufruit ');
static $fruit2   = ' fruit ';
$phrase = str_replace($fruit1, $fruit2, $phrase);



/* vie : histoire,accroc, affaire, affectation, all�gorie, anecdote, anicroche, annales, arch�ologie, archives, autobiographie, aventure, bagou, baliverne, bateau, bavardage, bible, 
biographie, blague, bobard, boniment, bruit, cas, chicane, chronique, chronologie, com�die, commentaire, complication, confessions, conte, craque, description, d�tour, 
difficult�, diplomatique, dit, �cho, embarras, ennui, �pisode, �tude, �vangile, �v�nement, �vocation, �volution, existence, fable, fa�on, fastes, feuilleton, g�n�alogie, 
geste, hagiographie, heuristique, historiette, incident, intrigue, invention, l�gende, machin, mani�re, m�moires, mensonge, menstrues, m�saventure, musique, mythe, mythologie, narration, pal�ographie, 
parabole, pass�, peinture, pr�histoire, probl�me, propos, protohistoire, querelle, r�cit, relation, roman, salade, sornette, souvenir, sujet, tirage, truc, version, vie */

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

/* loin: ab�me, absence, amplitude, aversion, chemin, course, d�clinaison, d�dain, diff�rence, discrimination, disparit�, 
disproportion, dissemblance, distinction, �cart, �cartement, �l�vation, �loignement, �longation, espace, espacement, �tendue, froideur, horizon, interstice, intervalle, 
lointain, marge, m�pris, nuance, opposition, parcours, p�rim�tre, port�e, profondeur, rayon, recul, r�probation, route, traite, trajet, vide*/

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
adresse, berceau, canton, cas, cat�gorie, cause, coin, colin, domicile, emplacement, endroit, espace, �tape, extraction, lieu-dit, localit�, maison, mati�re, merlan, milieu, objet, occasion, origine, parages, part, 
passage, pays, place, point, position, poste, pr�texte, quelque part, raison, rang, r�gion, r�sidence, secteur, s�jour, site, situation, sujet, terrain, terre, th��tre, zone */

static $lieu1 = array(" adresse ", " habite ", " boulevard ", " rue ", " o\u00f9 "," lieu "," cite "," avenue "," canton "," coin "," domicile "," emplacement "," endroit "," espace "," maison "," milieu "," origine "," parages "," passage "," pays "," place "," point "," poste "," secteur "," site "," situation "," sujet "," terrain "," terre "," zone ");
static $lieu2   = " lieu ";
$phrase = str_replace($lieu1, $lieu2, $phrase);

// abandonn\u00e9, d\u00e9sert, d\u00e9sert\u00e9, inoccup\u00e9, solitaire, vide, inhabit\u00e9, n\u00e9ant
/* � sec, abandon, abandonn�, absence, ampoul�, apathie, apathique, aride, baie, b�te, blanc, boursouffl�, 
case, cavit�, chambre, creux, d�barrass�, d�faut, d�garni, d�meubl�, d�muni, d�nud�, d�nu�, d�peupl�, 
d�pouill�, d�pourvu, d�sempli, d�sert, d�sert�, disponible, emphatique, enfl�, ennui, espace, �vacu�, 
excavation, exempt, fente, fissure, frivole, fum�e, futile, futilit�, impeupl�, improductif, inanit�, inconsistant, 
inculte, infr�quent�, inhabit�, inint�ressant, inoccup�, insignifiant, insipide, inutile, lacune, l�ger,
libre, manque, morne, mort, n�ant, net, nu, nul, nullit�, omission, ouverture, pauvre, perte, phras�ologie, plat, pr�tentieux, privation, priv�, rien, 
sans, sec, solitaire, souffl�, st�rile, superficiel, terne, trou, vacant, vacuit�, vacuum, vague, vain, vanit�, viduit�, z�ro*/
static $vide1 = array(" abandonn\u00e9 ", " d\u00e9sert ", " d\u00e9sert\u00e9 ", " inoccup\u00e9 ", " solitaire "," vide ",
" inhabit\u00e9 "," n\u00e9ant ", " ennui "," rien "," pauvre "," nul "," abandon "," apathie "," absence ", " emphatique ",
" manque ", " morne ", " mort "," inutile "," vain "," sans ");
static $vide2   = " vide ";
$phrase = str_replace($vide1, $vide2, $phrase);

// cong�, d�soeuvrement, disponibilit�, interruption, libert�, loisir, vacation, vacuit�
static $vacance1 = array(' cong� ', ' d�soeuvrement ', ' disponibilit� ', ' interruption ', ' libert� ',' loisir ',' vacation ',' vacuit� ');
static $vacance2   = ' vacance ';
$phrase = str_replace($vacance1, $vacance2, $phrase);

// ce jour, jadis, maintenant, pr\u00e9sentement aujourd'hui / actuellement
static $maintenant1 = array("ce jour", "jadis", "maintenant", "pr\u00e9sentement", "aujourd'hui","actuellement","imm\u00e9diatement","directement", "sur-le-champ");
static $maintenant2   = "maintenant";
$phrase = str_replace($maintenant1, $maintenant2, $phrase);

// cin\u00e9ma, cin\u00e9matographe, cin\u00e9rama, cinoche, documentaire, \u00e9cran, projection, spectacle
// bande, clip, couche, �mulsion, �volution, navet, pellicule, p�plum, processus, production, super-production, thriller, typon, western
static $film1 = array(" cin\u00e9ma ", " cin�ma ", " cin\u00e9matographe ", " cin\u00e9rama ", " cinoche ", " documentaire "," \u00e9cran "," projection "," spectacle "," bande "," clip "," navet "," pellicule "," production "," thriller "," western ");
static $film2   = " film ";
$phrase = str_replace($film1, $film2, $phrase);

// aise, b\u00e9at, bienheureux, bon, combl\u00e9, content, enchant\u00e9, joyeux, radieux, ravi, satisfait
static $bon1 = array(" aise ", " b\u00e9at ", " bienheureux ", " heureux ", " combl\u00e9 "," content "," enchant\u00e9 "," joyeux "," radieux "," ravi "," satisfait "," chanceux ");
static $bon2   = " bon ";
$phrase = str_replace($bon1, $bon2, $phrase);

static $num1 = array(" t\u00e9l\u00e9phone ", " num\u00e9ro ", " num ", " rue ", " o\u00f9 ", " num�ro ");
static $num2   = " num ";
$phrase = str_replace($num1, $num2, $phrase);

// http://www.crisco.unicaen.fr/des/synonymes/boire

/* toi - tu */
static $tu1 = array(" toi-m\u00eame ", " toi "," vous ");
static $tu2   = " tu ";
$phrase = str_replace($tu1, $tu2, $phrase);

/* dommage : tant pis, f�cheux, regrettable 
alt�ration atteinte avarie b�te br�che calamit� coup d�g�t d�gradation dam d�savantage d�t�rioration d�triment 
endommagement  entorse grabuge grief injure injustice
int�r�t l�sion m�fait mal nuisance outrage perte pr�judice ravage regrettable ribordage s�vices sinistre tant pis tort
*/

static $dommage1 = array(" tant pis ", " regrettable "," f\u00e2cheux ", " atteinte ", " avarie ", " endommagement ", " injure ", " injustice ", " nuisance ", " outrage ", " tort ", " sinistre ");
static $dommage2   = " dommage ";
$phrase = str_replace($dommage1, $dommage2, $phrase);

/* parfait :
absolu, accompli, achev�, ad�quat, admirable, adorable, ang�lique, beau, bien, bon, 
bravo, c�leste, chenu, complet, consomm�, d�sint�ress�, d�termin�, digne, divin, double, �l�gant, 
entier, �tonnant, exact, excellent, exceptionnel, exemplaire, exquis, extraordinaire, fameux, fieff�, 
fini, form�, franc, glace, hors ligne, id�al, idyllique, impeccable, inattaquable, incomparable, infaillible, 
infini, inimitable, irr�prochable, magistral, merveilleux, mod�le, non pareil, notable, optimal, oui, paradisiaque, pomm�, pr�cieux, pr�t�rit, pur, 
raffin�, remarquable, renforc�, respectable, r�ussi, rigoureux, royal, 
sacr�, sensationnel, signal�, singulier, souverain, splendide, strict, sublime, succulent, superfin, sup�rieur, superlatif, supr�me, total, tr�s bien, triple, unique, vrai*/

static $parfait1 = array(" absolu ", " accompli "," admirable "," parfait "," exact "," excellent "," incomparable "," inimitable "," remarquable "," respectable "," royal "," sublime "," succulent "," unique "," paradisiaque "," sensationnel ");
static $parfait2   = " parfait ";
$phrase = str_replace($parfait1, $parfait2, $phrase);

/* bien 

absolument, ach�vement, acqu�t, admirablement, 
adroitement, agr�able, agr�ablement, aimable, ais�ment, amplement, apanage, approximativement, 
argent, artistement, assur�ment, attentivement, au moins, au poil, avantage, avantageusement, 
avec bonheur, avoir, bath, beau, beaucoup, bellement, b�n�diction, b�n�fice, bien-�tre, bienfait,
bigrement, bon, bonheur, bonnement, bont�, bougrement, bravo, capital, certes, chance, charit�, cheptel, 
chic, choisi, chose, comme il faut, commode, commod�ment, comp�tent, compl�tement, confortablement, conqu�t, 
conqu�te, consciencieux, consid�rablement, convenable, convenablement, cool, copieusement, correct, correctement, 
couramment, d�licatement, devoir, digne, dignement, distingu�, divin, domaine, don, dotation, droit, dr�lement, d�ment, 
effectivement, �l�gamment, �l�gant, �minemment, en totalit�, enti�rement, environ, estimable, excellemment, excellent, 
express�ment, extr�mement, fameusement, faveur, favorablement, f�licit�, ferme, fermement, fonds, formellement, 
formidablement, fort, fortune, fruit, gentiment, gr�ce, gracieusement, habilement, h�ritage, heureusement, heureux, honn�te, 
honn�tement, honneur, honorable, honorablement, id�al, immeuble, impeccablement, int�gralement, intens�ment, int�r�t, joli, 
joliment, judicieusement, judicieux, juste, justice, largement, logiquement, louable, magistralement, merveilleusement, m�thodiquement, 
moral, morale, nettement, noblement, O.K., oui, parfait, parfaitement, pas mal, patrimoine, perfection, peut-�tre, pleinement, 
possession, pr�sent, produit, profit, profond�ment, propice, proprement, propri�t�, prosp�rit�, prudemment, purement, raisonnablement, 
rationnellement, r�colte, r�ellement, remarquablement, rente, richesse, sagement, salement, sans bavure, satisfaction, satisfaisant, 
secours, s�lect, sensiblement, s�rieusement, service, seyant, soigneusement, soit, sortable, soulagement, souverain bien, succ�s, succession, s�r, s�rement, terre, totalement, tout, 
tout � fait, tr�s, tr�s bien, trop, un grand nombre, utilement, utilit�, vachement, valeur, v�ritablement, vertu, violemment, vivement, volontiers, vraiment
*/

static $bien1 = array(" ben ", " absolument "," admirablement ", " adroitement "," aimable "," amplement "," approximativement "," argent "," avantage "," bon "," bonnement "," bravo "," chance "," commode "," joli "," jolie "," joliment "," juste "," parfait "," satisfaction "," satisfaisant "," vachement "," fort "," remarquablement ");
static $bien2   = " bien ";
$phrase = str_replace($bien1, $bien2, $phrase);


/* �me soeur : amante, bien-aim�e */
static $amante1 = array(" \u00e2me soeur ", " amante "," bien\u002daim\u00e9e ", " ame\u002dsoeur ", " ame soeur ");
static $amante2   = " amante ";
$phrase = str_replace($amante1, $amante2, $phrase);



/* balbutiement : d�but, commencement, commence.

�bauche abc �closion adolescence �l�ment �l�ments alpha amorce apparition 
arriv�e attaque aube aurore av�nement axiome b.a.-ba b�gaiement balbutiement berceau 
bord bourgeon bout cr�ation d�but d�clenchement d�part embryon enfance entame entr�e 
esquisse essai exorde extr�mit� fleur fondement germe inauguration introduction 
liminaire limite lisi�re naissance or�e origine ouverture point point initial postulat pr�ambule pr�face pr�liminaires
pr�lude pr�mices pr�misse premier premier pas primeur principe prologue provenance racine seuil source
 */
static $debut1 = array(" balbutiement ", " commencement ", " d\u00e9but ", " balbutiments ", " intro ", " introduction ", " naissance ", " commence ", " racine ", " premier ", " ouverture ", " fondement ");
static $debut2   = " debut ";
$phrase = str_replace($debut1, $debut2, $phrase);

/* nouveau: � la mode, � la page, actuel, apprenti, audacieux, autre, bizut, bleu, chang�, dans le vent, 
d�butant, dernier, dernier cri, diff�rent, extraordinaire, frais, hardi, in, inaccoutum�, inattendu, inconnu, 
in�dit, inexp�riment�, inexplor�, inhabituel, inimagin�, inou�, insolite, insoup�onn�, inusit�, 
jeune, m�tamorphos�, moderne, n�ophyte, neuf, nouveaut�, novateur, novice, original, 
os�, personnel, primeur, printanier, r�cent, second, surprenant, truculent, ultramoderne, up to date, vierge*/

static $neuf1 = array(" actuel ", " apprenti "," audacieux ", " autre "," insolite "," jeune "," moderne ", " nouveau "," novateur ", " original "," primeur ", " vierge "," novice ", " ultramoderne ", " r\u00e9cent ", " r�cent ");
static $neuf2   = " neuf ";
$phrase = str_replace($neuf1, $neuf2, $phrase);

/* usage - application : 
adaptation, affectation, ant�c�dent, applique, art, assemblage, assiduit�, 
attachement, attention, attribution, bijection, concentration, conscience, contention, correspondance, curiosit�, 
effet, effort, emploi, empreinte, �tude, exactitude, ex�cution, exercice, exp�rimentation, 
fomentation, homomorphisme, image, impression, imputation, injection, mal, m�ditation, mise en pratique, placage, pose, pratique, r�alisation, 
recueillement, r�flexion, r�gularit�, relation, s�rieux, soin, superposition, surjection, tension, travail, usage, utilisation, vigilance, vigueur, z�le*/

static $usage1 = array(" adaptation ", " affectation "," applique ", " assemblage ", " attention ", " attribution "," bijection ", " concentration ", " conscience "," contention "," correspondance "," effet "," exactitude "," exercice "," image "," impression "," pratique "," usage "," utilisation "," vigilance ", " vigueur ");
static $usage2   = " usage ";
$phrase = str_replace($usage1, $usage2, $phrase);

/* ambiance :
atmosph�re, aura, climat, compagnie, d�cor, entourage, environnement, influence, milieu, temps */

static $ambiance1 = array("climat", "environnement", "compagnie", "entourage","influence","milieu");
static $ambiance2   = "ambiance";
$phrase = str_replace($ambiance1, $ambiance2, $phrase);


/* sortir :
abandonner, a�rer, affleurer, appara�tre, arracher, baguenauder, balader, bondir, couler, 
d�barrasser le plancher, d�biter, d�border, d�boucher, d�bouquer, d�bucher, d�busquer, d�camper, d�couler, d�gager, d�guerpir, 
d�loger, d�passer, d�p�trer, d�raciner, descendre, d�vier, dire, �chapper, �clore, �diter, �liminer, �maner, �merger, enlever,
�tre frais �moulu, �tre issu, �tre n� de, �tre publi�, �vacuer, exc�der, exhiber, exhumer, expectorer, expulser, extirper, 
extraire, extravaser, fabriquer, faire, faire abstraction, faire irruption, jaillir, l�cher, lancer, lib�rer, na�tre, �ter, 
outrepasser, para�tre, partir, passer, percer, poindre, pousser, prendre, prendre l'air, proc�der, produire, prof�rer, promener, 
provenir, publier, quitter, raconter, r�chapper, remonter, ressortir, r�sulter, retirer, revenir, s'absenter, s'a�rer, s'�carter, 
s'�clipser, s'�couler, s'�loigner, s'enfuir, s'esquiver, s'�vader, s'exhaler, saillir, se balader, se d�gager, se d�partir, se d�tacher, se lib�rer, se manifester, se montrer, se promener, 
se r�pandre, se retirer, se sauver, se tirer, se tra�ner, sourdre, suivre, surgir, tirer, tomber, transgresser, venir, vidanger, vider, virer*/

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
static $boire3 = array(" s'abreuver ", " s'aff�ter "," s'alcooliser ", " s'aviner ", " s'enivrer ", " s'humecter ", " s'imbiber ", " s'impr�gner ", " s'inonder ", " sabler ");
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

//belle bonne, fra�che, yes.
//beaucoup gav�, grave, max, vachement.
//cale�on calbar, calbute, calcif, calfou�te. 
//cunnilingus broute-minou, cunni.
////// cunnilingus (pratiquer un) bouffer une chatte, descendre � la cave.
$healthy = array(" cunnilingus ", " broute-minou "," broute minou "," cunnis "," bouffer une chatte ");
$yummy   = " cunni ";
$phrase = str_replace($healthy, $yummy, $phrase);

//d�bile deb, gogol, gol, golio, golmon, mongol, mongolito, narvalo, teb�.
$healthy = array(" gogol ", " golio "," golmon "," mongol "," mongolito "," narvalo ");
$yummy   = " gol ";
$phrase = str_replace($healthy, $yummy, $phrase);

//difficile auche, chaud, dar, darre, hard. 
// 	ardu, d�licat, embarrassant, emmerdant, envahissant, g�nant, incommode, laborieux, malais�, p�nible, rude
$healthy = array(" hard ", " chaud "," darre "," dar "," auche "," difficile ", " embarrassant ", " emmerdant ", " envahissant ", " incommode ", " laborieux ", " difficile ");
$yummy   = " rude ";
$phrase = str_replace($healthy, $yummy, $phrase);

//dispute clash, embrouille, engueulade. 
//altercation, bagarre, chamaille, chamaillerie, discorde, dissension, escarmouche, heurt, incident, pol�mique, querelle, trouble
$healthy = array(" dispute ", " embrouille "," engueulade "," mongol "," mongolito "," narvalo ", " altercation "," narvalo "," bagarre "," chamaille "," discorde "," dissension "," escarmouche "," heurt "," incident "," querelle ");
$yummy   = " clash ";
$phrase = str_replace($healthy, $yummy, $phrase);
//dormir pieuter, pioncer, roupiller, se pieuter. 
$healthy = array(" pieuter ", " pioncer "," roupiller "," se pieuter "," se reposer "," pause ");
$yummy   = " dormir ";
$phrase = str_replace($healthy, $yummy, $phrase);
//eau flotte. 
//�jaculer ch�cra, cracher, d�gorger le poireau, juter, l�cher la pur�e, se vider les couilles. 
//enfant chiard, lardon, merdeux, minot, m�me, morpion, mouflet, moutard, tipeu. 
$healthy = array(" chiard ", " merdeux "," minot "," morpion "," mouflet "," moutard "," tipeu ");
$yummy   = " enfant ";
$phrase = str_replace($healthy, $yummy, $phrase);

//ennuyeux chiant, chiatique, gonflant, relou. 
/*
faim ainf, dalle.
? avoir faim avoir les crocs. 

fain�ant cossard, glandeur, glandouillard, ramier.   */

//femme belette, caille, chnek, fatma, femelle, fente, feum, feumeu, frangine, gadji, go, gonze, gonzesse, greluche, grosse, loute, meuf, nana, poule, poulette, racli, rate, schneck, tera, zessegon.
$healthy = array(' belette ', ' caille ',' chnek ',' fatma ',' femelle ',' feum ',' feumeu ',' frangine ',' gadji ',' gonze ',' gonzesse ',' greluche ',' loute ',' meuf ',' nana ',' poule ',' poulette ',' racli ',' schneck ',' tera ',' zessegon ');
$yummy   = ' femme ';
$phrase = str_replace($healthy, $yummy, $phrase);


//fille belette, caille, chnek, fifna, frangine, gadji, gonze,
//gonzesse, gorette, meuf, minch, nana, n�nette, pain, pisseuse, poulette, racli, rate, tera, yeufi, zessegon.
static $fille1 = array(' belette ', ' caille ', ' chnek ', ' fifna ', ' frangine ', ' gadji ', ' gonze ');
static $fille2 = array(' gonzesse ', ' gorette ', ' meuf ', ' minch ', ' nana ', ' n�nette ', ' pisseuse ', ' poulette ', ' racli ', ' rate ', ' tera ', ' zessegon ');
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
 
// homme gadjo, gonze, keum, keum�, mec, nombo, raclo.
//cr�ature, �tre, hominid�, hominien, humain, individu, mortel, personne
// 	bonhomme, coco, cr�ature, gar�on, gonze, individu, m�le, mari, mec, quidam, type
static $homme1 = array(" gadjo ", " gonze "," keum "," mec "," nombo "," raclo ", " personne ", " individu ", " mortel ", " humain ", " hominien ", " bonhomme ", " coco ");
static $homme2   = " homme ";
$phrase = str_replace($homme1, $homme2, $phrase);
 
//homo,  homosexuel chbeb, d�p, fiotte, folle, , lope, lopette, p�dale, p�d�, p�doque, phoque, tafiole, tante, tantouse, tantouze, tapette, tarlouze, zamel.
$healthy = array(" homosexuel ", " chbeb "," fiotte "," folle "," lope "," lopette "," phoque "," tafiole "," tante "," tantouse "," tantouze "," tapette "," tarlouze "," zamel ");
$yummy   = " homo ";
$phrase = str_replace($healthy, $yummy, $phrase);

// honte affiche, bif, chouf, haine (avoir la), latche, tehon.
$healthy = array(" affiche ", " bif "," chouf "," latche "," tehon ");
$yummy   = " honte ";
$phrase = str_replace($healthy, $yummy, $phrase);

// ivre avoir un coup dans le nez, beurr�, bitur�, bourr�, chlasse, cram�, d�chir�, fracasse, murg�, p�t�, torch�.
$healthy = array(" avoir un coup dans le nez ", " chlasse "," fracasse ");
$yummy   = " ivre ";
$phrase = str_replace($healthy, $yummy, $phrase);

// l�che faux derche, faux-cul, femmelette, fiotte, fomblard, gonzesse, lope ou lopette, p�tochard, e, sans-couille, tafiole, tapette, tarlouze.
 
// laid cheum, d�gueu, lassedeg, moche,affreux, difforme, disgracieux, hideux, moche, monstrueux, repoussant, vilain
$healthy = array(" cheum ", " lassedeg "," moche "," affreux "," difforme "," disgracieux "," hideux "," monstrueux "," repoussant "," vilain ");
$yummy   = " laid ";
$phrase = str_replace($healthy, $yummy, $phrase);
//? personne laide cadavre, cageot, crat�re, mochet�, thon.

//lit paddock, pieu, plumard.
//main paluche, patoche, pogne.
$healthy = array(" paluche ", " patoche "," pogne ");
$yummy   = " main ";
$phrase = str_replace($healthy, $yummy, $phrase);

// manger b�frer, becqueter, bouffer, criave, damer, gam�ler, grailler, se taper, s'empiffrer.
$healthy = array(" becqueter ", " bouffer "," criave "," damer "," grailler "," se taper ");
$yummy   = " manger ";
$phrase = str_replace($healthy, $yummy, $phrase);

// mentir balnaver, baratiner, barber, charlater, mythoner, pipeauter.
$healthy = array(" balnaver ", " baratiner "," barber "," charlater "," mythoner "," pipeauter ");
$yummy   = " mentir ";
$phrase = str_replace($healthy, $yummy, $phrase);

// se moquer casser, chambrer, gazer, se foutre de la gueule de qqn, tailler un costard � qqn, vanner.
$healthy = array(" se moquer ", " chambrer "," gazer "," se foutre de la gueule de "," tailler un costard "," vanner ");
$yummy   = " casser ";
$phrase = str_replace($healthy, $yummy, $phrase);

// mourir canner, clamser, claquer, crever.
$healthy = array(" canner ", " clamser "," claquer "," crever ");
$yummy   = " mourir ";
$phrase = str_replace($healthy, $yummy, $phrase);
 
// muscl� baraqu�, scleum, stoc, stoko.
//? homme muscl� armoire � glace, baraque, dalle, masse, stocma, stokosse.

//musique zic, zicmu, zik, zizique.

//nez blase, blaze, pif, tarin, zen.

//parler p�nave, tchatcher.
// moto b�cane, meule.
// mis�re hagra, zermi.

//p�nis biroute, bistouquette, bite, braquemard, braquos, chibre, dard, gourdin, kiki, mandrin, noeud, nouille, 
//pine, poireau, qu�quette, queue, teub, zboub, z�zette, zgu�gue, zigounette, zizi, zobe.


//? faire peur foutre les jetons.

// avoir peur avoir les chocottes, avoir les jetons, baliser, chier dans son froc, flipper, p�fli, p�fly, pisser dans son froc.
$healthy = array(" avoir les chocottes ", " avoir les jetons ", " baliser ", " chier dans son froc ", " flipper ", " pisser dans son froc ");
$yummy   = " avoir peur ";
$phrase = str_replace($healthy, $yummy, $phrase);

//peur flip, frousse, p�toche, reup, trouille, affolement, alarme, appr�hension, crainte, �motion, �pouvante, frayeur, frisson, panique, phobie
// angoisse, appr�hension, �pouvante,angoisser bader, bad-triper, flipper, p�fli, p�fly, psychoter, phobie
// affolement, alarme, appr\u00e9hension, crainte, \u00e9motion, \u00e9pouvante, frayeur, frisson, panique, phobie
static $peur1 = array(' flip ', ' frousse ', ' reup ', ' trouille ', ' affolement ', ' alarme ', ' crainte ', ' frayeur ', ' frisson ', ' panique ',' p�fli ', ' p�fly ');
static $peur2 = array(' bader ', ' bad-triper ',' flipper ',' psychoter ',' angoisser ', ' p�toche ', ' appr�hension ', ' phobie ', ' angoisse ', ' �pouvante ');
static $peur3 = array(' affolement ', ' alarme ', ' appr\u00e9hension ',' crainte ', ' \u00e9motion ', ' \u00e9pouvante ', ' frayeur ', ' initimidation ');
static $peur   = ' peur ';
$healthy = array_merge ($peur1,$peur2,$peur3);
$phrase = str_replace($healthy, $peur, $phrase);


/*prostitu�e biatch, gagneuse, gueuse, michetonneuse, pouf, poufiasse, putain, pute, radasse, radeuse, tchebi, tcheubi, teup, teupu, timpe.   */
$healthy = array(" gagneuse ", " gueuse "," michetonneuse "," pouf "," poufiasse "," putain "," biatch "," radasse "," radeuse "," tchebi "," tcheubi "," teup "," teupu ");
$yummy   = " pute ";
$phrase = str_replace($healthy, $yummy, $phrase);

//puer chlinguer, dauber, fouetter, poquer, upe.
$healthy = array(" chlinguer ", " dauber ", " fouetter ", " poquer ", " upe ");
$yummy   = " puer ";
$phrase = str_replace($healthy, $yummy, $phrase);
//regarder chouf, dicave, dikave, mater, rodave, t�ma, viser, zieuter, zyeuter.

//laisser : renvoyer d�gommer, lourder, virer.
//abandonner, abdiquer, calter, d�biner, d�caniller, d�guerpir, d�laisser, d�m�nager, d�nicher, �chapper, 
//embarquer, �migrer, enfuir, �vacuer, fuir, l�cher, rompre, soustraire, voyager
static $laisser1 = array(' renvoyer ', ' d�gommer ', ' lourder ', ' virer ');
static $laisser2 = array(' abandonner ', ' abdiquer ',' calter ',' d�biner ',' d�caniller ', ' d�guerpir ', ' d�laisser ', ' d�m�nager ', ' d�nicher ', ' �chapper ');
static $laisser3 = array(' embarquer ', ' �migrer ', ' enfuir ',' �vacuer ', ' fuir ', ' l�cher ', ' rompre ', ' soustraire ', ' voyager ');
static $laisser   = ' laisser ';
$healthy = array_merge ($laisser1,$laisser2,$laisser3);
$phrase = str_replace($healthy, $laisser, $phrase);

//riche blind�, cheuri, p�t� de tunes, p�t� d'oseille.

//rien foye, keud ou queude, peanuts, que dalle, que tchi, queude, walou.
$healthy = array(" foye ", " keud ", " queude ", " peanuts ", " que dalle ", " que tchi ", " queude ", " walou ");
$yummy   = " rien ";
$phrase = str_replace($healthy, $yummy, $phrase);

//saluer checker.accueillir applaudir f�ter, honorer ,incliner     prosterner  rendre hommage   rendre visite  respecter       se prosterner
$healthy = array(" checker ", " accueillir ", " applaudir ", " honorer ", " incliner ", " prosterner ", " rendre hommage ", " rendre visite ", " respecter ", " se prosterner ");
$yummy   = " saluer ";
$phrase = str_replace($healthy, $yummy, $phrase);

//sein bz�ze, insse, loches, lolo, n�n�, nibard, nichon, roberts, roploplo, t�t�.
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
? travail non d�clar� black, blackos, kebla.      */
$healthy = array(" chaffrave ", " taf ", " turbin ", " black ", " blackos ", " kebla ");
$yummy   = " travail ";
$phrase = str_replace($healthy, $yummy, $phrase);

 //tuer bousiller, buter, charcler, d�glinguer, d�gommer, descendre, dessouder, flinguer, fumer, plomber, refroidir, r�tamer, s�cher, shooter, zigouiller.
$healthy = array(" bousiller ", " buter ", " charcler ", " descendre ", " dessouder ", " flinguer ", " fumer ", " plomber ", " refroidir ", " shooter ", " zigouiller ");
$yummy   = " tuer ";
$phrase = str_replace($healthy, $yummy, $phrase);

 //vanter (se) b�flan, faire crari, flamber, frimer, se la donner, se la jouer, se la p�ter, se la raconter.
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
//fort bal�ze, stocma, stoko, stokos.
// h�pital hosto.
// incomp�tent baltringue, bite, br�le, burne, tache.
// m�re daronne r�m  reum  reum� vieille.
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
$patterns[7] = '/bal�ze/';
$patterns[8] = '/stocma/';
$patterns[9] = '/stokos/';
$patterns[10] = '/stoko/';
$patterns[11] = '/hosto /';
$patterns[12] = '/baltringue /';
$patterns[13] = '/bite /';
$patterns[14] = '/br�le /';
$patterns[15] = '/burne /';
$patterns[16] = '/tache /';
$patterns[17] = '/ daronne /';
$patterns[18] = '/ r�m /';
$patterns[19] = '/ reum /';
$patterns[20] = '/ reum� /';
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



//sale , d�gueu, d�gueulasse,,acide,,�grillard,,�quivoque,barbouill�,damn�,d�sagr�able,d�sordonn�,,,encrass�,exag�r�,,f�cheux
$arr1 = array(' boueux ', ' cracra ', ' crado ', ' crasseux ', ' dissolu ', ' douteux ', ' excessif ', ' crade ', ' abject ', ' affreux ', ' amer ', ' breneux ');
$arr2 = array(' ivoirin ', ' impur ', ' impudique ', ' immonde ', ' ignoble ', ' honteux ', ' grivois ', ' graveleux ', ' graisseux ', ' fichu ', ' fangeux ', ' gras ');
//  inf�me, lascif,m�chant,macul�, m�prisable,maudit,naus�abond,obsc�ne,ord,os�,p�le,p�nible,piment�,poivr�,pollu�,poussi�reux,r�pugnant,sacr�,sal�,satan�,saum�tre,souill�
$arr3 = array(' sagouin ', ' porc ', ' poisseux ', ' pisseux ', ' ordurier ', ' maudit ', ' louche ', ' licencieux ', ' leste ', ' laid ', ' lactescent ');
$arr4 = array(' vil ', ' trouble ', ' trivial ', ' terreux ', ' terni ', ' terne ', ' suspect ', ' surfait ', ' souillon ', ' sordide ', ' salope ', ' salingue ');
$arr5 = array(' acide ', ' turpide ', ' pouacre ', ' pornographique ', ' infect ', ' cochon ', ' lascif ' );

$yummy   = ' sale ';
$healthy = array_merge ($arr1,$arr2,$arr3,$arr4,$arr5);
$phrase = str_replace($healthy, $yummy, $phrase);

//*********************************************************************************************************

//vol braco, braquo, carotte, choure, d�pouille, fauche, gruge, rotka, tape.
$healthy = array(" braco ", " braquo "," carotte "," choure "," fauche "," gruge "," rotka "," tape ");
$yummy   = " vol ";
$phrase = str_replace($healthy, $yummy, $phrase);

 //voler barber, barboter, b�bar, bicrave, carotter, choucrave, choucrouter, chouraver, chourer, d�pouiller, faucher, gauler, p�ta, piquer, rotka, taper, tirer.
$healthy = array(" barber ", " barboter "," bicrave "," carotter "," choucrave "," choucrouter "," chouraver "," chourer "," faucher "," gauler "," piquer "," rotka "," taper "," tirer ");
$yummy   = " voler ";
$phrase = str_replace($healthy, $yummy, $phrase);
 

// vulve chatte, choune, fente, fouf, foufoune, foufounette, foune, minou, moule, schneck, teuche.
$healthy = array(" chatte ", " choune "," fente "," fouf "," foufoune "," foufounette "," minou "," moule "," schneck "," teuche ");
$yummy   = " vulve ";
$phrase = str_replace($healthy, $yummy, $phrase);

//amour (faire l') baiser, bouillave, bourrer, bourriner, bouyave, d�fourailler, donner, emmancher, fourrer, foutre, k�ne, k�ner, limer, mettre, niquer, piner, pointer, sauter, se taper, taper, taro, tartiner, tirer, tringler, troncher, trouer, z�ber, zobe, zober.
$healthy = array(" baiser ", " bouillave "," bourrer "," bourriner "," bouyave "," emmancher "," fourrer "," foutre "," limer "," mettre "," niquer "," piner "," pointer "," sauter "," se taper "," taper "," taro "," tartiner "," tirer "," tringler "," troncher "," trouer "," zobe "," zober ");
$yummy   = " amour ";
$phrase = str_replace($healthy, $yummy, $phrase);

//arriver d�bouler, pointer, rappliquer, se rabouler, se radiner.
$healthy = array(" pointer ", " rappliquer "," se rabouler "," se radiner ");
$yummy   = " arriver ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* manger - diner */
$healthy = array("alimentation","absorber","attaquer","avaler","becqueter","bouffer","boulotter","boustifailler","bredouiller","brouter","collationner","consommer","consumer","croquer","d\u00e9guster","d\u00e9jeuner","d\u00e9vorer","engloutir", "engouffrer", "entamer", "festoyer", "fricasser", "grignoter", "gueuletonner","ingurgiter","mastiquer","ronger","se gaver","se goinfrer","se restaurer", "souper", "diner", "bouffer");
$yummy   = "manger";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
apprendre :
approfondir, assimiler, �clairer, �veiller, renseigner, d�brouiller, d�grossir, �duquer, enseigner,expliquer, farcir, guider, habituer, inculquer, initier, professer
*/

$healthy = array(" approfondir "," assimiler "," \u00e9clairer "," \u00e9veiller "," renseigner "," d\u00e9brouiller "," d\u00e9grossir "," \u00e9duquer "," enseigner "," expliquer "," farcir "," guider "," habituer "," inculquer "," initier "," professer ");
$yummy   = " apprendre ";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
comprendre:
admettre, comporter, compter, contenir, embrasser, inclure, incorporer, renfermer,appr�hender, concevoir, d�chiffrer, interpr�ter, p�n�trer, saisir,r�aliser, discerner, sentir, ouvrir, suivre */

$healthy = array(" admettre "," comporter "," compter "," contenir "," embrasser "," inclure "," incorporer "," renfermer "," appr\u00e9hender "," concevoir "," d\u00e9chiffrer "," interpr\u00e9ter "," p\u00e9n\u00e9trer "," saisir "," r\u00e9aliser "," discerner "," sentir "," ouvrir "," suivre ");
$yummy   = " comprendre ";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
ignorer :
m�conna�tre, m�juger,excepter, exclure, impliquer, n�gliger, omettre, ignorance, inaptitude
*/

$healthy = array("m\u00e9conna\u00eetre","m\u00e9juger","excepter","exclure","impliquer","n\u00e9gliger","omettre","ignorance","inaptitude", "se moquer");
$yummy   = "ignorer";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
savoir: 
acquis, aptitude, cognition, conception, connaissance, culture, doctrine, �rudition, escient, exp�rience, humanisme, id�e, lumi�res, omniscience, sagesse, science
conna�tre, poss�der,dominer, pouvoir */

$healthy = array(" acquis "," aptitude "," cognition "," conception "," connaissance "," culture "," doctrine "," \u00e9rudition "," escient "," exp\u00e9rience "," humanisme "," id\u00e9e "," lumi\u00e8res "," omniscience "," sagesse "," science "," conna\u00eetre "," poss\u00e9der "," dominer "," pouvoir ");
$yummy   = " savoir ";
$phrase = str_replace($healthy, $yummy, $phrase);


// qu'es tu as fais aujourd'hui
// qu'est-ce que tu as fais aujourd'hui

/* m�t�o : air, atmosph�re, ciel, m�t�orologie, nuage, pression, temp�rature, vent */
/* �ge, air, ambiance, an, anciennet�, ant�riorit�, atmosph�re, aujourd'hui, avenir, brouillard, bruine, brume, cas, cat�gorie, 
chance, ciel, circonstance, climat, conjoncture, conjugaison, cycle, date, d�lai, demain, dur�e, �claircie, embellie, �poque, �re, 
espace, �tape, �tendue, �v�nement, facilit�, futur, g�n�ration, hasard, instant, intemp�rie, jadis, jour, jours, marge, m�t�o, m�t�orologie, 
minute, mouvement, nuage, occasion, opportunit�, orage, palier, pass�, p�riode, possibilit�, post�riorit�, 
pr�sent, r�gime, r�pit, rythme, saison, si�cle, silence, stade, succession, sursis, temp�rature, temporalit�, vent*/

$healthy = array(" m\u00e9t\u00e9o "," air "," atmosph\u00e8re "," ciel "," m\u00e9t\u00e9orologie "," nuage "," pression "," temp\u00e9rature "," vent "," bruine "," brouillard "," climat "," orage "," saison ");
$yummy   = " meteo ";
$phrase = str_replace($healthy, $yummy, $phrase);

/*
intelligent: adroit, astucieux, capable, dou�, �veill�, fort, habile, ing�nieux, malin, perspicace, clairvoyant, judicieux, spirituel, subtil
*/

$healthy = array(' adroit ',' astucieux ',' capable ',' dou\u00e9 ',' \u00e9veill\u00e9 ',' fort ',' intelligent ',' ing\u00e9nieux ',' malin ',' perspicace ',' clairvoyant ',' judicieux ',' spirituel ',' subtil ');
$yummy   = ' habile ';
$phrase = str_replace($healthy, $yummy, $phrase);

/* alors � ce moment-l�, adonc, ainsi, alors que, cependant, dans ces conditions, donc, eh, eh bien, en ce cas, en ce temps-l�, et, lors, pour lors, puis, sur ces entrefaites */

$healthy = array(' adonc ',' ainsi ',' alors que ',' cependant ',' dans ces conditions ',' donc ',' en ce cas ',' ing\u00e9nieux ',' lors ',' puis ',' sur ces entrefaites ');
$yummy   = ' alors ';
$phrase = str_replace($healthy, $yummy, $phrase);

/*
temps: ann�e, cycle, dur�e, heure, jour, minute, mois, seconde, si�cle,�poque, intervalle, apr�s-midi, date, demain, �re, 
lendemain, matin�e, moment, nuit, p�riode, prochainement, rapidement, sans tarder, soir�e, veille, saison */

$healthy = array(' ann\u00e9e ',' cycle ',' dur\u00e9e ',' heure ',' jour ',' minute ',' mois ',' seconde ',' si\u00e8cle ',' \u00e9poque ',' intervalle ',' apr\u00e8s-midi ',' date ',' demain ',' \u00e8re ',' lendemain ',' matin\u00e9e ',' moment ',' nuit ',' p\u00e9riode ',' prochainement ',' rapidement ',' sans tarder ',' soir�e ',' veille ');
$yummy   = ' temps ';
$phrase = str_replace($healthy, $yummy, $phrase);


//argent artiche, biffeton, bifton, bl�, boule, caillasse, flouze, fric, gengen, genhar, keusse, maille, neuthu, oseille, p�pette, p�ze, pognon, rond, thune, tune, zeillo, zeyo.
static $argent1 = array(' artiche ',' biffeton ',' bifton ',' boule ',' caillasse ',' flouze ',' fric ',' gengen ',' genhar ',' keusse ',' maille ',' neuthu ',' cailoseillelasse ',' pognon ',' rond ',' rond ',' thune ',' tune ');
static $argent2   = ' argent ';
$phrase = str_replace($argent1, $argent2, $phrase);

/* hein : comment, eh, hem, n'est-ce pas, pardon, pla�t-il, quoi */
$healthy = array(" hein "," comment "," eh "," hem "," pardon ");
$yummy   = " quoi ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* sauf : � cela pr�s, � l'exception de, � l'exclusion de, � la r�serve de, bon, except�, fors, hormis, hors, indemne, intact, moins, �t�, 
pr�serv�, rescap�, sain, sain et sauf, sauv�, si, sinon, survivant, tir� d'affaire */

$healthy = array(" hormis ", " hors ", " indemne ", " moins "," si "," sinon ", " survivant ");
$yummy   = " sauf ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* cigarette : cibiche, clope, pipe, s�che, tige, tronc*/

$healthy = array(" cigarette ", " pipe ", " tige ", " tronc "," cigare ");
$yummy   = " clope ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* encore : aussi, avec cela, bis, cependant, davantage, de nouveau, de plus, du moins, mais, m�me, par surcro�t, plus, rebelote, si seulement, toujours, une fois de plus */
$healthy = array(" aussi ", " bis "," cependant ", " davantage ", " mais ", " plus ", " toujours ");
$yummy   = " encore ";
$phrase = str_replace($healthy, $yummy, $phrase);

/* voici : voila */
$healthy = array(" voici ", " voila ");
$yummy   = " voila ";
$phrase = str_replace($healthy, $yummy, $phrase);

// d�finition , sp�cification, explication, etymologie, signification, sens
$healthy = array(" signification "," explication "," etymologie ", " definition ");
$yummy   = " sens ";
$phrase = str_replace($healthy, $yummy, $phrase);


/*
�tre averti �tre cal� �tre comp�tent �tre expert �tre inform� �tre savant 
apercevoir appr�cier appr�hender
�prouver assavoir avoir connaissance avoir l'usage comprendre concevoir consid�rer constater discerner 
embrasser endurer entendre entrevoir estimer exp�rimenter juger p�n�trer penser percevoir poss�der pratiquer 
prendre reconna�tre ressentir s'apercevoir sentir se pr�occuper s'occuper subir supporter tenir de

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

// simul�es
$healthy = array(' simul\u00e9es ', ' simulation ', ' dissimulation ', ' simulacre ');
$yummy   = ' ruse ';
$phrase = str_replace($healthy, $yummy, $phrase);

$phrase = ltrim($phrase);
return $phrase;
}

?>
