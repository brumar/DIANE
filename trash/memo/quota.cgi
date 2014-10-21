#!/usr/bin/perl

print "Content-type: text/html\n\n";

my $quotaLine = `quota | tail -n1` ;
$quotaLine =~ /^\ +(\d+)\ +(\d+)\ +\d+\ +\d+\ +(\-*\d)/;


my $blockSize;
my $megaSize;
if ($3 == -1)
{
        $blockSize = 16;
        $megaSize  = 1024;
}
else
{
        $blockSize = 1;
        $megaSize  = 1000;
}


my $used_Ko  = sprintf "%d", $1 * $blockSize;
my $used_Mo  = sprintf "%.2f", ($1 * $blockSize)/$megaSize;

my $total_Ko = sprintf "%.0f", $2 * $blockSize;
my $total_Mo = sprintf "%d", ($2 * $blockSize)/$megaSize;

my $remain_Ko = sprintf "%.0f", $total_Ko - $used_Ko;
my $remain_Mo = sprintf "%.2f", ($total_Ko - $used_Ko)/$megaSize;

my $pc 	      = sprintf "%.2f", ($1/$2)*100;


my $requetes_auj  = "--";
my $octets_auj    = "--";
my $requetes_hier = "--";
my $octets_hier   = "--";
my $octets_mois   = "--";
my $ladate;
my $ladate2;

if ( -d "../../requetes")
{
	my ($sec,$min,$heure,$mjour,$mois,$annee) = localtime(time);
	$mois++;
	$annee+=1900;

	if ($mois =~ /^[1-9]$/)  { $mois  = "0$mois";}; 
	if ($mjour =~ /^[1-9]$/) { $mjour = "0$mjour";};
	$ladate ="$annee\-$mois\-$mjour";

	$requetes_auj =`awk '{SOMME += \$1;}; END{printf("%f", SOMME);}' ../../requetes/$ladate/*requetes`;
	$octets_auj   =`awk '{SOMME += \$1;}; END{printf("%f", SOMME);}' ../../requetes/$ladate/*octets`;
	chomp $requetes_auj; 
	chomp $octets_auj; 
	$octets_auj/=1000000;

	my ($sec,$min,$heure,$mjour,$mois,$annee) = localtime(time-24*60*60);
	$mois++;
	$annee+=1900;

	if ($mois =~ /^[1-9]$/)  { $mois  = "0$mois";}; 
	if ($mjour =~ /^[1-9]$/) { $mjour = "0$mjour";};
	$ladate = "$annee\-$mois\-$mjour";

	$requetes_hier = `awk '{SOMME += \$1;}; END{printf("%f", SOMME);}' ../../requetes/$ladate/*requetes`;
	$octets_hier   = `awk '{SOMME += \$1;}; END{printf("%f", SOMME);}' ../../requetes/$ladate/*octets`;
	chomp $requetes_hier; 
	chomp $octets_hier; 
	$octets_hier /= 1000000;

	$ladate2     = "$annee\-$mois";
	$octets_mois = `awk '{SOMME += \$1;}; END{printf("%f", SOMME);}' ../../requetes/$ladate2-*/*octets`;
	chomp $octets_mois; 
	$octets_mois /= 1000000000;
}





print "<html><head><title>Espace disque</title></head><body>\n";

print "<table border=0 align=center cellspacing=3>\n";
print "<tr><td colspan=2 align=center><h1>Etat de votre espace disque</h1></td></tr>\n";
print "<tr><td>&nbsp;</td></tr>";
print "<tr><th align=right> Espace total disponible :</th><th align=left> $total_Mo Mo</th></tr>\n";
print "<tr><th align=right> Espace utilis&eacute; :</th><td>  $used_Ko Ko ($used_Mo Mo) ($pc%)</td></tr>\n";
print "<tr><th align=right> Espace restant :</th><td>  $remain_Ko Ko ($remain_Mo Mo) </td></tr>\n";
print "<tr><td>&nbsp;</td></tr>";
print "<tr><td>&nbsp;</td></tr>";
print "<tr><td colspan=2 align=center><h1>Requêtes et Transfert</h1></td></tr>\n";
print "<tr><td>&nbsp;</td></tr>";
print "<tr><th align=right> Nombre des requêtes du $ladate :</th><th align=left> $requetes_hier</th></tr>\n";
print "<tr><th align=right> Nombre des requêtes aujourd'hui :</th><th align=left> $requetes_auj</th></tr>\n";
print "<tr><td>&nbsp;</td></tr>";
print "<tr><th align=right> Transfert de votre site du $ladate :</th><th align=left> $octets_hier Mo</th></tr>\n";
print "<tr><th align=right> Transfert de votre site aujourd'hui :</th><th align=left> $octets_auj Mo</th></tr>\n";
print "<tr><td>&nbsp;</td></tr>";
print "<tr><th align=right> Transfert de votre site du mois $ladate2 :</th><th align=left> $octets_mois Go</th></tr>\n";
print "</table>\n";

print "</body></html>";

