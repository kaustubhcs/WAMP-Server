<?php

// Page créé par Shepard [Fabian Pijcke] <Shepard8@laposte.net>
// Arno Esterhuizen <arno.esterhuizen@gmail.com>
// et Romain Bourdon <rromain@romainbourdon.com>
// et Hervé Leclerc <herve.leclerc@alterway.fr>
//  
// Mise à jour par Herve Leclerc herve.leclerc@alterway.fr
// Icônes par Mark James <http://www.famfamfam.com/lab/icons/silk/>
//------
//[modif oto] Modifications Dominique Ottello (Otomatic)
//Suppression des vhosts, le dossier n'étant plus créé à l'installation
//Affichage des Outils, Projets et Alias sur trois colonnes
//   - Recodage en utf-8
//   - Modification des styles : ajout .third .left et .right
//   - Ajouts d'index dans $langues['en'] et ['fr'] :
//       'locale' pour set_locale
//       'docp' url des documentations PHP
//       'docm' url des documentations MySQL
//       'doca2.2' url de la documentation Apache 2.2
//       'doca2.4' url de la documentation Apache 2.4
//       'server' Server Software
//   - Classement alphabétique des extensions PHP en fonction de la localisation
//   - Liens sur les documentations Apache, PHP et MySQL
//   - Ajout variable $suppress_localhost = true;
//   - Conformité W3C par ajout de <li>...</li> sur les variables
//     $aliasContents et $projectContents si vides

//[modif oto] - Pour supprimer niveau localhost dans les url 
$suppress_localhost = false;
// avec modification de la ligne
//$projectContents .= '<li><a href="'.$file.'">'.$file.'</a></li>';
//Par :
//$projectContents .= '<li><a href="'.($suppress_localhost ? 'http://' : '').$file.'">'.$file.'</a></li>';
//-----
//[modif oto] Ajout $server_dir pour un seul remplacement
// si déplacement www hors de Wamp et pas d'utilisation des jonctions
//Par défaut la valeur est "../"
//$server_dir = "WAMPROOT/";
$server_dir = "../";
//Fonctionne à condition d'avoir ServerSignature On et ServerTokens Full dans httpd.conf
$server_software = $_SERVER['SERVER_SOFTWARE'];

$wampConfFile = $server_dir.'wampmanager.conf';
//chemin jusqu'aux fichiers alias
$aliasDir = $server_dir.'alias/';

// on charge le fichier de conf locale
if (!is_file($wampConfFile))
    die ('Unable to open WampServer\'s config file, please change path in index.php file');
$fp = fopen($wampConfFile,'r');
$wampConfFileContents = fread ($fp, filesize ($wampConfFile));
fclose ($fp);


// on récupère les versions des applis
preg_match('|phpVersion = (.*)\n|',$wampConfFileContents,$result);
$phpVersion = str_replace('"','',$result[1]);
preg_match('|apacheVersion = (.*)\n|',$wampConfFileContents,$result);
$apacheVersion = str_replace('"','',$result[1]);
$doca_version = 'doca'.substr($apacheVersion,0,3);
preg_match('|mysqlVersion = (.*)\n|',$wampConfFileContents,$result);
$mysqlVersion = str_replace('"','',$result[1]);
preg_match('|wampserverVersion = (.*)\n|',$wampConfFileContents,$result);
$wampserverVersion = str_replace('"','',$result[1]);

// répertoires à ignorer dans les projets
$projectsListIgnore = array ('.','..');

// textes
$langues = array(
	'en' => array(
		'langue' => 'English',
		'locale' => 'english',
		'autreLangue' => 'Version Française',
		'autreLangueLien' => 'fr',
		'titreHtml' => 'KTB SERVER Homepage',
		'titreConf' => 'Kaustubh Shivdikar Server Configuration ',
		'versa' => 'Apache Version :',
		'doca2.2' => 'httpd.apache.org/docs/2.2/en/',
		'doca2.4' => 'httpd.apache.org/docs/2.4/en/',
		'versp' => 'PHP Version :',
		'server' => 'Server Software:',
		'docp' => 'www.php.net/manual/en/',
		'versm' => 'MySQL Version :',
		'docm' => 'dev.mysql.com/doc/index.html',
		'phpExt' => 'Loaded Extensions : ',
		'titrePage' => 'Tools',
		'txtProjet' => 'Your Projects',
		'txtNoProjet' => 'No projects yet.<br />To create a new one, just create a directory in \'www\'.',
		'txtAlias' => 'Your Aliases',
		'txtNoAlias' => 'No Alias yet.<br />To create a new one, use the WAMPSERVER menu.',
		'faq' => 'http://www.en.wampserver.com/faq.php'
	),
	'fr' => array(
		'langue' => 'Français',
		'locale' => 'french',
		'autreLangue' => 'English Version',
		'autreLangueLien' => 'en',
		'titreHtml' => 'Accueil WAMPSERVER',
		'titreConf' => 'Configuration Serveur',
		'versa' => 'Version Apache:',
		'doca2.2' => 'httpd.apache.org/docs/2.2/fr/',
		'doca2.4' => 'httpd.apache.org/docs/2.4/fr/',
		'versp' => 'Version de PHP:',
		'server' => 'Server Software:',
		'docp' => 'www.php.net/manual/fr/',
		'versm' => 'Version de MySQL:',
		'docm' => 'dev.mysql.com/doc/index.html',
		'phpExt' => 'Extensions Chargées: ',
		'titrePage' => 'Outils',
		'txtProjet' => 'Vos Projets',
		'txtNoProjet' => 'Aucun projet.<br /> Pour en ajouter un nouveau, créez simplement un répertoire dans \'www\'.',
		'txtAlias' => 'Vos Alias',
		'txtNoAlias' => 'Aucun alias.<br /> Pour en ajouter un nouveau, utilisez le menu de WAMPSERVER.',
		'faq' => 'http://www.wampserver.com/faq.php'
	)
);

// images
$pngFolder = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAABhlBMVEX//v7//v3///7//fr//fj+/v3//fb+/fT+/Pf//PX+/Pb+/PP+/PL+/PH+/PD+++/+++7++u/9+vL9+vH79+r79+n79uj89tj89Nf889D88sj78sz78sr58N3u7u7u7ev777j67bL67Kv46sHt6uP26cns6d356aP56aD56Jv45pT45pP45ZD45I324av344r344T14J734oT34YD13pD24Hv03af13pP233X025303JL23nX23nHz2pX23Gvn2a7122fz2I3122T12mLz14Xv1JPy1YD12Vz02Fvy1H7v04T011Py03j011b01k7v0n/x0nHz1Ejv0Hnuz3Xx0Gvz00buzofz00Pxz2juz3Hy0TrmznzmzoHy0Djqy2vtymnxzS3xzi/kyG3jyG7wyyXkwJjpwHLiw2Liw2HhwmDdvlXevVPduVThsX7btDrbsj/gq3DbsDzbrT7brDvaqzjapjrbpTraojnboTrbmzrbmjrbl0Tbljrakz3ajzzZjTfZijLZiTJdVmhqAAAAgnRSTlP///////////////////////////////////////8A////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////9XzUpQAAAAlwSFlzAAALEgAACxIB0t1+/AAAAB90RVh0U29mdHdhcmUATWFjcm9tZWRpYSBGaXJld29ya3MgOLVo0ngAAACqSURBVBiVY5BDAwxECGRlpgNBtpoKCMjLM8jnsYKASFJycnJ0tD1QRT6HromhHj8YMOcABYqEzc3d4uO9vIKCIkULgQIlYq5haao8YMBUDBQoZWIBAnFtAwsHD4kyoEA5l5SCkqa+qZ27X7hkBVCgUkhRXcvI2sk3MCpRugooUCOooWNs4+wdGpuQIlMDFKiWNbO0dXTx9AwICVGuBQqkFtQ1wEB9LhGeAwDSdzMEmZfC0wAAAABJRU5ErkJggg==
EOFILE;
$pngFolderGo = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJISURBVDjLpZPLS5RhFIef93NmnMIRSynvgRF5KWhRlmWbbotwU9sWLupfCBeBEYhQm2iVq1oF0TKIILIkMgosxBaBkpFDmpo549y+772dFl5bBIG/5eGch9+5KRFhOwrYpmIAk8+OjScr29uV2soTotzXtLOZLiD6q0oBUDjY89nGAJQErU3dD+NKKZDVYpTChr9a5sdvpWUtClCWqBRxZiE/9+o68CQGgJUQr8ujn/dxugyCSpRKkaw/S33n7QQigAfxgKCCitqpp939mwCjAvEapxOIF3xpBlOYJ78wQjxZB2LAa0QsYEm19iUQv29jBihJeltCF0F0AZNbIdXaS7K6ba3hdQey6iBWBS6IbQJMQGzHHqrarm0kCh6vf2AzLxGX5eboc5ZLBe52dZBsvAGRsAUgIi7EFycQl0VcDrEZvFlGXBZshtCGNNa0cXVkjEdXIjBb1kiEiLd4s4jYLOKy9L1+DGLQ3qKtpW7XAdpqj5MLC/Q8uMi98oYtAC2icIj9jdgMYjNYrznf0YsTj/MOjzCbTXO48RR5XaJ35k2yMBCoGIBov2yLSztNPpHCpwKROKHVOPF8X5rCeIv1BuMMK1GOI02nyZsiH769DVcBYXRneuhSJ8I5FCmAsNomrbPsrWzGeocTz1x2ht0VtXxKj/Jl+v1y0dCg/vVMl4daXKg12mtCq9lf0xGcaLnA2Mw7hidfTGhL5+ygROp/v/HQQLB4tPlMzcjk8EftOTk7KHr1hP4T0NKvFp0vqyl5F18YFLse/wPLHlqRZqo3CAAAAABJRU5ErkJggg==
EOFILE;
$gifLogo = <<< EOFILE
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
EOFILE;
$pngPlugin = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsSAAALEgHS3X78AAAABGdBTUEAALGOfPtRkwAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAABmklEQVR42mL4//8/AyUYIIDAxK5du1BwXEb3/9D4FjBOzZ/wH10ehkF6AQIIw4B1G7b+D09o/h+X3gXG4YmteA0ACCCsLghPbPkfm9b5PzK5439Sdg9eAwACCEyANMBwaFwTGIMMAOEQIBuGA6Mb/qMbABBAEAOQnIyMo1M74Tgiqf2/b3gVhgEAAQQmQuKa/8ekdYMxyLCgmEYMHJXc9t87FNMAgACCGgBxIkgzyDaQU5FxQGQN2AUBUXX/vULKwdgjsOQ/SC9AAKEEYlB03f+oFJABdSjYP6L6P0guIqkVjt0DisEGAAQQigEgG0AhHxBVi4L9wqvBBiEHtqs/xACAAAIbEBBd/x+Eg2ObwH4FORmGfYCaQRikCUS7B5YBNReBMUgvQABBDADaAtIIwsEx9f/Dk9pQsH9kHTh8XANKMAIRIIDAhF9ELTiQQH4FaQAZCAsskPNhyRpkK7oBAAEEMSC8GsVGkEaYIlBghcU3gbGzL6YBAAEEJnzCgP6EYs/gcjCGKQI5G4Z9QiswDAAIIAZKszNAgAEAHgFgGSNMTwgAAAAASUVORK5CYII=
EOFILE;
$pngWrench = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAABO1BMVEXu7u7n5+fk5OTi4uLg4ODd3d3X19fV1dXU1NTS0tLPz8+7z+/MzMy6zu65ze65zu7Kysq3zO62zO3IyMjHx8e1yOiyyO2yyOzFxcXExMSyxue0xuexxefDw8OtxeuwxOXCwsLBwcGuxOWsw+q/v7+qweqqwuqrwuq+vr6nv+qmv+m7u7ukvumkvemivOi5ubm4uLicuOebuOeat+e0tLSYtuabtuaatuaXteaZteaatN6Xs+aVs+WTsuaTsuWRsOSrq6uLreKoqKinp6elpaWLqNijo6OFpt2CpNyAo92BotyAo9+dnZ18oNqbm5t4nt57nth7ntp4nt15ndp3nd6ZmZmYmJhym956mtJzm96WlpaVlZVwmNyTk5Nvl9lultuSkpKNjY2Li4uKioqIiIiHh4eGhoZQgtVKfNFdha6iAAAAaXRSTlMA//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////914ivwAAAACXBIWXMAAAsSAAALEgHS3X78AAAAH3RFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyA4tWjSeAAAAKFJREFUGJVjYIABASc/PwYkIODDxBCNLODEzGiQgCwQxsTlzJCYmAgXiGKVdHFxYEuB8dkTOIS1tRUVocaIWiWI8IiIKKikaoD50kYWrpwmKSkpsRC+lBk3t2NEMgtMu4wpr5aeuHcAjC9vzadjYyjn7w7lK9kK6tqZK4d4wBQECenZW6pHesEdFC9mbK0W7otwsqenqmpMILIn4tIzgpG4ADUpGMOpkOiuAAAAAElFTkSuQmCC
EOFILE;
$favicon = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAAB8AAAAfCAYAAAAfrhY5AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJ
bWFnZVJlYWR5ccllPAAAA2RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdp
bj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6
eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEz
NDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJo
dHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlw
dGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEu
MC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVz
b3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1N
Ok9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo1ODg0QkM3NUZBMDhFMDExODkyQ0U2NkE5ODVB
M0Q2OSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoxRkI1ODNGRTA5MDMxMUUwQjAwNEEwODc0
OTk5N0ZEOCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoxRkI1ODNGRDA5MDMxMUUwQjAwNEEw
ODc0OTk5N0ZEOCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3Mi
PiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1ODg0QkM3NUZB
MDhFMDExODkyQ0U2NkE5ODVBM0Q2OSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1ODg0QkM3
NUZBMDhFMDExODkyQ0U2NkE5ODVBM0Q2OSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRG
PiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PiUukzAAAAHHSURBVHja5FfRccIwDLVz
/W+7QdggbJBM0HQCwg+/LRNwTJDymx9ggmYDsgEZwRuUDVI5ET1XyE5CuIa76k7ABVtPluQnRVZV
JcYST4woD85/ZRbC5wxUf/sdbZagBehGVAvlNM+GXWYaaIugQ+QDdA1OnLqByyyAzwPo042iqyMx
BwdKN7jMNODREWKFyonv2KdPPqERoDlPGQMKQ7drPWPjfAy6Inb080/QiK/2Js8JMacBpzWwzGIs
QFdxhujkFMNtSkj3m1ftjTnxEg0f0XNXAYb1mmatwFPSFM1s4NTwuUp18QU9CiyonWj2rhkHWXAK
kNeh7gdMQ5wzRdnKcAo9DwZcsRBtqL70qm7Ior3B/5zbI0IKrvv8mxarhXSsXtrY8m5OfjB+F5SN
BkhKrpi8635uaxAvkO9HpgZSB/v57f2cFpEQzz+UeZ28Yvq+bMXpkb5rSgwLc+Z5Fylwb+y68x4p
MlNW2CLnPUmnrE/d7F1dOGXJ+Qb0neQqre9ptZiAscTI38ng7YTQ8g6Budlg75pktkxPV9idctss
1mGYOKciupsxatQB8pJkmkUTpgCvHZ0jDtg+t4/60vAf3tVGBf8WYAC3Rq8Ub3mHyQAAAABJRU5E
rkJggg==
EOFILE;


//affichage du phpinfo
if (isset($_GET['phpinfo']))
{
	phpinfo();
	exit();
}


//affichage des images
if (isset($_GET['img']))
{
    switch ($_GET['img'])
    {
        case 'pngFolder' :
        header("Content-type: image/png");
        echo base64_decode($pngFolder);
        exit();
        
        case 'pngFolderGo' :
        header("Content-type: image/png");
        echo base64_decode($pngFolderGo);
        exit();
        
        case 'gifLogo' :
        header("Content-type: image/gif");
        echo base64_decode($gifLogo);
        exit();
        
        case 'pngPlugin' :
        header("Content-type: image/png");
        echo base64_decode($pngPlugin);
        exit();
        
        case 'pngWrench' :
        header("Content-type: image/png");
        echo base64_decode($pngWrench);
        exit();
        
        case 'favicon' :
        header("Content-type: image/x-icon");
        echo base64_decode($favicon);
        exit();
    }
}



// Définition de la langue et des textes 

if (isset ($_GET['lang']))
{
  $langue = htmlspecialchars($_GET['lang'],ENT_QUOTES);
  if ($langue != 'en' && $langue != 'fr' ) {
		$langue = 'fr';
  }
  }
elseif (isset ($_SERVER['HTTP_ACCEPT_LANGUAGE']) AND preg_match("/^fr/", $_SERVER['HTTP_ACCEPT_LANGUAGE']))
{
	$langue = 'fr';
}
else
{
	$langue = 'en';
}

//initialisation
$aliasContents = '';

// récupération des alias
if (is_dir($aliasDir))
{
    $handle=opendir($aliasDir);
    while (($file = readdir($handle))!==false) 
    {
	    if (is_file($aliasDir.$file) && strstr($file, '.conf'))
	    {		
		    $msg = '';
		    $aliasContents .= '<li><a href="'.str_replace('.conf','',$file).'/">'.str_replace('.conf','',$file).'</a></li>';
	    }
    }
    closedir($handle);
}
if (empty($aliasContents))
	$aliasContents = "<li>".$langues[$langue]['txtNoAlias']."</li>\n";

// récupération des projets
$handle=opendir(".");
$projectContents = '';
while (($file = readdir($handle))!==false) 
{
	if (is_dir($file) && !in_array($file,$projectsListIgnore)) 
	{		
		//[modif oto] Ajout éventuel de http:// pour éviter le niveau localhost dans les url
		$projectContents .= '<li><a href="'.($suppress_localhost ? 'http://' : '').$file.'">'.$file.'</a></li>';
	}
}
closedir($handle);
if (empty($projectContents))
	$projectContents = "<li>".$langues[$langue]['txtNoProjet']."</li>\n";;


//initialisation
$phpExtContents = '';

// récupération des extensions PHP
$loaded_extensions = get_loaded_extensions();
// [modif oto] classement alphabétique des extensions
setlocale(LC_ALL,"{$langues[$langue]['locale']}");
sort($loaded_extensions,SORT_LOCALE_STRING);
foreach ($loaded_extensions as $extension)
	$phpExtContents .= "<li>${extension}</li>";


//header('Status: 301 Moved Permanently', false, 301);      
//header('Location: /aviatechno/index.php');      
//exit();        

$pageContents = <<< EOPAGE
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
	<title>{$langues[$langue]['titreHtml']}</title>
	<meta http-equiv="Content-Type" content="txt/html; charset=utf-8" />

	<style type="text/css">
* {
	margin: 0;
	padding: 0;
}

html {
	background: #ddd;
}
body {
	margin: 1em 10%;
	padding: 1em 3em;
	font: 80%/1.4 tahoma, arial, helvetica, lucida sans, sans-serif;
	border: 1px solid #999;
	background: #eee;
	position: relative;
}
#head {
	margin-bottom: 1.8em;
	margin-top: 1.8em;
	padding-bottom: 0em;
	border-bottom: 1px solid #999;
	letter-spacing: -500em;
	text-indent: -500em;
	height: 125px;
	background: url(index.php?img=gifLogo) 0 0 no-repeat;
}
.utility {
	position: absolute;
	right: 4em;
	top: 145px;
	font-size: 0.85em;
}
.utility li {
	display: inline;
}

h2 {
	margin: 0.8em 0 0 0;
}

ul {
	list-style: none;
	margin: 0;
	padding: 0;
}
#head ul li, dl ul li, #foot li {
	list-style: none;
	display: inline;
	margin: 0;
	padding: 0 0.4em;
}
ul.aliases, ul.projects, ul.tools {
	list-style: none;
	line-height: 24px;
}
ul.aliases a, ul.projects a, ul.tools a {
	padding-left: 22px;
	background: url(index.php?img=pngFolder) 0 100% no-repeat;
}
ul.tools a {
	background: url(index.php?img=pngWrench) 0 100% no-repeat;
}
ul.aliases a {
	background: url(index.php?img=pngFolderGo) 0 100% no-repeat;
}

dl {
	margin: 0;
	padding: 0;
}
dt {
	font-weight: bold;
	text-align: right;
	width: 11em;
	clear: both;
}
dd {
	margin: -1.35em 0 0 12em;
	padding-bottom: 0.4em;
	overflow: auto;
}
dd ul li {
	float: left;
	display: block;
	width: 16.5%;
	margin: 0;
	padding: 0 0 0 20px;
	background: url(index.php?img=pngPlugin) 2px 50% no-repeat;
	line-height: 1.6;
}
a {
	color: #024378;
	font-weight: bold;
	text-decoration: none;
}
a:hover {
	color: #04569A;
	text-decoration: underline;
}
#foot {
	text-align: center;
	margin-top: 1.8em;
	border-top: 1px solid #999;
	padding-top: 1em;
	font-size: 0.85em;
}
.third {
  width:32%;
  float:left;
}
.left {float:left;}
.right {float:right;}
</style>
	<link rel="shortcut icon" href="index.php?img=favicon" type="image/ico" />
</head>

<body>
	<div id="head">
		<h1><abbr title="Windows">W</abbr><abbr title="Apache">A</abbr><abbr title="MySQL">M</abbr><abbr title="PHP">P</abbr></h1>
		<ul>
			<li>PHP 5</li>
			<li>Apache 2</li>
			<li>MySQL 5</li>
		</ul>
	</div>

	<ul class="utility">
		<li>Version ${wampserverVersion}</li>
		<li><a href="?lang={$langues[$langue]['autreLangueLien']}">{$langues[$langue]['autreLangue']}</a></li>
	</ul>

	<h2> {$langues[$langue]['titreConf']} </h2>

	<dl class="content">
		<dt>{$langues[$langue]['versa']}</dt>
		<dd>${apacheVersion}&nbsp;&nbsp;-&nbsp;<a href='http://{$langues[$langue][$doca_version]}'>Documentation</a></dd>
		<dt>{$langues[$langue]['versp']}</dt>
		<dd>${phpVersion}&nbsp;&nbsp;-&nbsp;<a href='http://{$langues[$langue]['docp']}'>Documentation</a></dd>
		<dt>{$langues[$langue]['server']}</dt>
		<dd>${server_software}</dd>
		<dt>{$langues[$langue]['phpExt']}</dt> 
		<dd>
			<ul>
			${phpExtContents}
			</ul>
		</dd>
		<dt>{$langues[$langue]['versm']}</dt>
		<dd>${mysqlVersion} &nbsp;-&nbsp; <a href='http://{$langues[$langue]['docm']}'>Documentation</a></dd>
	</dl>
	<div style="margin-top:5px;border-top:1px solid #999;"></div>
	<div class="third left">
	<h2>{$langues[$langue]['titrePage']}</h2>
	<ul class="tools">
		<li><a href="?phpinfo=1">phpinfo()</a></li>
		<li><a href="phpmyadmin/">phpmyadmin</a></li>
	</ul>
	</div>
	<div class="third left">
	<h2>{$langues[$langue]['txtProjet']}</h2>
	<ul class="projects">
	$projectContents
	</ul>
	</div>
	<div class="third right">
	<h2>{$langues[$langue]['txtAlias']}</h2>
	<ul class="aliases">
	${aliasContents}			
	</ul>
	</div>
	<div style="clear:both;"></div>
	<ul id="foot">
		<li><a href="http://www.wampserver.com">WampServer</a></li>
    <li><a href="http://www.wampserver.com/en/donations.php">Donate</a></li>
		<li><a href="http://www.alterway.fr">Alter Way</a></li>
	</ul>
</body>
</html>
EOPAGE;

echo $pageContents;
?>