<?echo"<html>
<head>
<title>moteur de recherche</title>
<style type=text/css>
a:link{color:000000;
text-decoration:none;
font-family:verdana,tahoma,arial;
font-size:8pt}
a:visited{color:333333;
text-decoration:none;
font-family:verdana,tahoma,arial;
font-size:8pt}
a:hover{color:000000;
text-decoration:underline;
font-family:verdana,tahoma,arial;
font-size:8pt}
body,td,input{
font-family:verdana,tahoma,arial;
font-size:8pt}
.lapagemagique46{
font-family:verdana,tahoma,arial;
font-size:16pt;
font-weight:bold;
color:#86aed7}
.lapagemagique45{
color:ffffff;
font-weight:bold;
background-color:#86aed7}
</style>
</head>
<body>
<table width=60% align=center cellpadding=5 cellspacing=0
style='border-style:solid;border-width:1;border-color:444444'>
<tr><td>";
//configuration du script
# nombre maximum de mots dans une phrase pour une recherche
$lapagemagique1=10;
# nombre de résultats à afficher par page
$lapagemagique2=10;
# extensions des pages dans lesquels se feront la recherche, à vous d'en ajouter ou d'en supprimer !
$lapagemagique3=array("html","htm","php","php3","phtml","txt","doc","xml");
# nom des répertoires dans lesquels s'effectura la recherche
$lapagemagique4="./,repertoire1/,repertoire1/sousrepertoire1/,repertoire2/,repertoire3/";
# Nombre maximum de caractères à afficher pour la description de la page
$lapagemagique5=2000;
# Nombre maximum de caractères à afficher pour les autres mots compris dans la page
$lapagemagique6=2000;
if (!isset($lapagemagique7)) { $lapagemagique7=0; }
if (!isset($lapagemagique8)) { $lapagemagique8=0; }
if (!isset($lapagemagique9)) { $lapagemagique9=0; }
$lapagemagique10=trim(stripslashes($lapagemagique10));
if ($lapagemagique7==0) {$lapagemagique10=strtolower($lapagemagique10); }
$lapagemagique10=ereg_replace(","," ",$lapagemagique10);
# effacement des virgules lors de la recherche
$lapagemagique12=array(); $lapagemagique11=array();
$lapagemagique12=explode(" ",$lapagemagique10);
# effacement des espaces lors de la recherche
foreach ($lapagemagique12 as $lapagemagique13){
if (($lapagemagique13!="") && (count($lapagemagique11)<=($lapagemagique1-1)) && (!in_array($lapagemagique13,$lapagemagique11)))
{ array_push($lapagemagique11,$lapagemagique13); }}
$lapagemagique10=implode(" ",$lapagemagique11);?>
<form action=<? echo "$PHP_SELF"; ?> method=post>
<table width=100% cellpadding=5 cellspacing=0 border=0 bgcolor=86aed7>
<tr><td>
<?echo "<input type=text name=lapagemagique10 style='width:167'";
$browser=$HTTP_USER_AGENT;
if (1*strpos(strtolower($browser),"msie")>0) { echo "25"; } else { echo "14"; }
echo "\" value=\"".$lapagemagique10."\"><br><br>";
# lignes de séparations entre le champ de recherche et le bouton de recherche
?>
<input type=submit value=Rechercher style='width:167'></td>
<td><font color=ffffff><b>Majuscules et minuscules</b><br>
<input type="radio" name="lapagemagique7" value="1"
<? if ($lapagemagique7==1) echo "checked"; ?>>différencier<br>
<input type="radio" name="lapagemagique7" value="0"
<? if ($lapagemagique7==0) echo "checked"; ?>>ne pas différencier
</td><td><b><font color=ffffff>Type de recherche</b><br>
<input type="radio" name="lapagemagique8" value="1"
<? if ($lapagemagique8==1) echo "checked"; ?>>mots complets<br>
<input type="radio" name="lapagemagique8" value="0"
<? if ($lapagemagique8==0) echo "checked"; ?>>portions de mots
</td></tr></table></form>
<?if ($lapagemagique10!="")
{ lapagemagique14();lapagemagique15(); }
function lapagemagique14(){
global $lapagemagique11,
$lapagemagique7,$lapagemagique8,$lapagemagique28nummer,
$lapagemagique21,$lapagemagique5,$lapagemagique6;
global $lapagemagique3,$lapagemagique4;$lapagemagique17=0;
$lapagemagique21=array();$lapagemagique18=array();
$lapagemagique18=explode(",",$lapagemagique4);
foreach ($lapagemagique18 as $lapagemagique19){
$lapagemagique20=opendir($lapagemagique19);
while ($lapagemagique22=readdir($lapagemagique20)){
$name=$lapagemagique19.$lapagemagique22;
$lapagemagique23=explode(".",$lapagemagique22);
if (in_array($lapagemagique23[1],$lapagemagique3)){
$lapagemagique24=0;
$lapagemagique25=0;
$lapagemagique26=array();
$lapagemagique28=fopen($name,"r");
while (!feof($lapagemagique28)){
$lapagemagique30=fgetss($lapagemagique28,10000,"");
if ($lapagemagique7==0)
{$lapagemagique30=strtolower($lapagemagique30);}
$lapagemagique32=explode(" ",$lapagemagique30);
foreach ($lapagemagique32 as $lapagemagique34){
foreach ($lapagemagique11 as $lapagemagique33){
if ($lapagemagique8==0){
if (strstr($lapagemagique34,$lapagemagique33)){
if (!in_array($lapagemagique33,$lapagemagique26))
{ array_push($lapagemagique26,$lapagemagique33); }
$lapagemagique24++;
$lapagemagique21["lapagemagique36"][$lapagemagique17]++;
if ($lapagemagique24==1){
$lapagemagique21["lapagemagique28_url"][$lapagemagique17]=$name;
$lapagemagique27=strpos($lapagemagique30,$lapagemagique34);
$lapagemagique29=strlen($lapagemagique34);
$lapagemagique39=strlen($lapagemagique30);
if ($lapagemagique39>$lapagemagique5){
$lapagemagique31=$lapagemagique27-(($lapagemagique5-$lapagemagique29)/2);
$lapagemagique38=$lapagemagique31+$lapagemagique5;
if ($lapagemagique31<0)
{ $lapagemagique38=$lapagemagique38-$lapagemagique31;
$lapagemagique31=0; }
if ($lapagemagique38>$lapagemagique39)
{ $lapagemagique38=$lapagemagique39; }
}else{$lapagemagique31=0; $lapagemagique38=$lapagemagique39; }
$position=substr($lapagemagique30,
$lapagemagique31,
$lapagemagique38-$lapagemagique31);
$position=ereg_replace($lapagemagique34,"
<font class=lapagemagique45>".$lapagemagique34."</font>",$position);
$position="...".$position."...";
$lapagemagique21["lapagemagique37"][$lapagemagique17]=$position;
}else if ($lapagemagique24==2)
{ $lapagemagique44=ereg_replace(",","",$lapagemagique44);
$lapagemagique35=$lapagemagique44; }
else if ($lapagemagique24>2){
if (strlen($lapagemagique35)<$lapagemagique6)
{ if ($lapagemagique35=="") { $lapagemagique49="";
}else{$lapagemagique49=", "; }
$lapagemagique34=ereg_replace(", ","",$lapagemagique34);
$lapagemagique35.=$lapagemagique49.$lapagemagique34; }
else { if ($lapagemagique25!=1)
{$lapagemagique35=$lapagemagique35." ...";
$lapagemagique25=1;} }}}}
else{if ($lapagemagique34==$lapagemagique33){
if (!in_array($lapagemagique33,$lapagemagique26))
{ array_push($lapagemagique26,$lapagemagique33); }
$lapagemagique24++;
$lapagemagique21["lapagemagique36"][$lapagemagique17]++;
if ($lapagemagique24==1){
$lapagemagique21["lapagemagique28_url"][$lapagemagique17]=$name;
$lapagemagique27=strpos($lapagemagique30,$lapagemagique34);
$lapagemagique29=strlen($lapagemagique34);
$lapagemagique39=strlen($lapagemagique30);
if ($lapagemagique39>$lapagemagique5){
$lapagemagique31=$lapagemagique27-(($lapagemagique5-$lapagemagique29)/2);
$lapagemagique38=$lapagemagique31+$lapagemagique5;
if ($lapagemagique31<0)
{ $lapagemagique38=$lapagemagique38-$lapagemagique31; $lapagemagique31=0; }
if ($lapagemagique38>$lapagemagique39) { $lapagemagique38=$lapagemagique39; }
}else{ $lapagemagique31=0; $lapagemagique38=$lapagemagique39; }
$position=substr($lapagemagique30,$lapagemagique31,$lapagemagique38-$lapagemagique31);
$position=" ".$position." ";
$position=ereg_replace(" ".$lapagemagique34." ","
<span class=lapagemagique45>".$lapagemagique34."</span> ",$position);
$position="...".$position."...";
$lapagemagique21["lapagemagique37"][$lapagemagique17]=$position;
}else if ($lapagemagique24==2)
{ $lapagemagique44=ereg_replace(",","",$lapagemagique44);
$lapagemagique35=$lapagemagique44;
}else if ($lapagemagique24>2){
if (strlen($lapagemagique35)<$lapagemagique6)
{ if ($lapagemagique35=="") { $lapagemagique49="";
}else { $lapagemagique49=", ";
} $lapagemagique34=ereg_replace(", ","",$lapagemagique34);
$lapagemagique35.=$lapagemagique49.$lapagemagique34;
}else { if ($lapagemagique25!=1)
{$lapagemagique35=$lapagemagique35." ..."; $lapagemagique25=1;} }
}}}}}}
fclose($lapagemagique28);
$lapagemagique21["lapagemagique32"][$lapagemagique17]=count($lapagemagique26);
$lapagemagique21["lapagemagique35"][$lapagemagique17]=$lapagemagique35;
if (count($lapagemagique26)>0)
{ $lapagemagique17++; }}}
closedir($lapagemagique20);}}
function lapagemagique15(){
global $lapagemagique21,
$lapagemagique17,$PHP_SELF,$lapagemagique9,$SERVER_NAME,$lapagemagique2,$lapagemagique11,
$lapagemagique10,$lapagemagique7,$lapagemagique8;
echo "<table width=100% border=0><tr><td>\nRésultat de la recherche<br>\n";
$lapagemagique21_lapagemagique24=count($lapagemagique21["lapagemagique28_url"]);
if ($lapagemagique21_lapagemagique24==0) {
echo "<br><br>Aucun résultat pour votre recherche !<br><br></td></tr></table>\n"; }
else{@array_multisort($lapagemagique21["lapagemagique32"],
SORT_DESC,$lapagemagique21["lapagemagique36"],SORT_DESC,
$lapagemagique21["lapagemagique28_url"],
$lapagemagique21["lapagemagique37"],$lapagemagique21["lapagemagique35"]);
$lapagemagique10=ereg_replace(" ",", ",$lapagemagique10);
if (count($lapagemagique11)>1){echo "Vous recherchiez les termes suivants : ";
}else{echo "Vous recherchiez le terme suivant : ";}
echo "<font class=lapagemagique45>$lapagemagique10</font><br><br>\n";
$lapagemagique40=$lapagemagique9*$lapagemagique2+1;
$lapagemagique41=$lapagemagique40+$lapagemagique2-1;
if ($lapagemagique41>$lapagemagique21_lapagemagique24)
{ $lapagemagique41=$lapagemagique21_lapagemagique24; }
echo "Page $lapagemagique40-$lapagemagique41 sur un total de
$lapagemagique21_lapagemagique24 page(s), résultats de la recherche
classés par pertinence<br><br>
</td></tr></table>\n";
for ($lapagemagique48=0;$lapagemagique48<$lapagemagique2;$lapagemagique48++){
$calculer=$lapagemagique9*$lapagemagique2+$lapagemagique48;
$lapagemagique47=$calculer+1;
if ($lapagemagique47<=$lapagemagique41)
{echo "<table width=100% cellpadding=0 cellspacing=0
style='border-style:solid;border-width:1;border-color:666666'>\n";
$lapagemagique43=1;
$lapagemagique21["lapagemagique28_url"]
[$calculer]=ereg_replace("\./","",$lapagemagique21["lapagemagique28_url"][$calculer]);
$lapagemagique28=fopen($lapagemagique21["lapagemagique28_url"][$calculer],"r");
while ($lapagemagique43<7){
$lapagemagique30=fgetss($lapagemagique28,1000,"");
$lapagemagique30=trim($lapagemagique30);
if ($lapagemagique30!=""){
echo "<tr><td height=16 colspan=2>
<span class=lapagemagique46>".$lapagemagique47.".</span>
<a href=".$lapagemagique21["lapagemagique28_url"][$calculer].">
".$lapagemagique30."</a><br>";break;}
$lapagemagique43++;}fclose($lapagemagique28);
if ($lapagemagique21["lapagemagique32"][$calculer]==1)
{ $lapagemagique32="</font>occurence<font color=5E94ca>";
}else{$lapagemagique32="</font>occurences<font color=5E94ca>";}
if ($lapagemagique21["lapagemagique36"][$calculer]==1)
{ $lapagemagique36="</font>mot dans le texte<font color=5E94ca>";
}else{$lapagemagique36="</font>mots dans le texte"; }
echo"\n";
echo $lapagemagique21["lapagemagique37"][$calculer]."<br>\n";
echo "<br>Mots identiques compris dans le texte de la page : <b><font color=5E94ca>
".$lapagemagique21["lapagemagique35"][$calculer]."</b><br>"
.$lapagemagique21["lapagemagique32"][$calculer].
"&nbsp;".$lapagemagique32." |
".$lapagemagique21["lapagemagique36"][$calculer]."&nbsp;".$lapagemagique36."</td>\n";
echo "<tr><td valign=top><br><a href=http://".$SERVER_NAME."/scripts/demo642/"
.$lapagemagique21["lapagemagique28_url"][$calculer]." target=_blank>\n";
# le repertoire courant est ici moteur : donc http://localhost/moteur
echo "http://".$SERVER_NAME."/scripts/demo642/"
.$lapagemagique21["lapagemagique28_url"][$calculer]."</a></td>\n";
echo "</td></tr></table><br>\n";}}}
if ($lapagemagique21_lapagemagique24>0){ echo "Page :<font color=5E94ca>\n"; }
$j=ceil($lapagemagique21_lapagemagique24/$lapagemagique2)-1;
for ($calculer=0;$calculer<=$j;$calculer++){
$lapagemagique42=$calculer+1;
if (($lapagemagique9+1)!=$lapagemagique42)
{echo "<a href=$PHP_SELF?lapagemagique10=$lapagemagique10&lapagemagique9=
".$calculer."&lapagemagique7=".$lapagemagique7."&lapagemagique8=".$lapagemagique8.">"; }
echo $lapagemagique42;
if (($lapagemagique9+1)!=$lapagemagique42){echo "</a>";}
echo "&nbsp;";}
if ($lapagemagique21_lapagemagique24>0){echo "\n"; }}?>
</td></tr></table>
</body>
</html>