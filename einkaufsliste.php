<?php
include 'mysqllogin2.php';
//Abfrage-------------------------------------------------------------------------------------------------------------------------
$query="SELECT 
			`bezeichnung`,
			`menge`,
			`einheit`,
			`datum`,
			`vkpreis`
		FROM 
			`warenbestand`
		WHERE
			`menge` < '20'";
		$ergebnis=mysqli_query($db,$query);

$bezeichnung=array();
$menge=array();
$einheit=array();
$datum=array();
$vkpreis=array();
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" media="all" type="text/css" href="./style/style_bericht.css">
<title>Einkaufsliste</title>
</head>
<body>

	<form action="<?php echo $_SERVER ['PHP_SELF'];?>" method="get">
	<!--  <img src="../ge_monogram_primary_blue_RGB.gif" alt="" width="80" height="80" />  -->
	<div style="font-weight: bold;font-size: 24pt; text-align: center;">E I N K A U F S L I S T E</div>
	<div style="font-weight: bold;font-size: 24pt; text-align: center; color: green">1. MGC Lohfelden 1997 e.V.</div>
	
</form>
<table>
<thead>
<tr style="border-bottom: 3px solid black; text-align: center">
	<td>Bezeichnung</td>
	<td>Menge</td>
	<td>Einheit</td>
	<td>Letzte &Auml;nderung</td>
	<td>Verkaufpreis</td>
	<td>Summe</td>
</tr>
</thead>
<tbody>
<?php 
	$I = 0;
	while($fetch = mysqli_fetch_assoc($ergebnis)){
		$bezeichnung[$I]=$fetch['bezeichnung'];
	   	$menge[$I] = $fetch['menge'];
	   	$einheit[$I] = $fetch['einheit'];
	   	$datum[$I] = $fetch['datum'];
	   	$vkpreis[$I] = $fetch['vkreis'];
	   
	   	echo '<tr>';
			echo '<th style="border-bottom: 1px solid black; text-align: center">' . $bezeichnung[$I] . '</th>';
			echo '<th style="border-bottom: 1px solid black; text-align: center">' . $menge[$I] . '</th>';
			echo '<th style="border-bottom: 1px solid black; text-align: center">' . $einheit[$I] . '</th>';
			echo '<th style="border-bottom: 1px solid black; text-align: center">' . date("d.m.Y", strtotime( $datum[$I] )) . '</th>';
			echo '<th style="border-bottom: 1px solid black; text-align: center">' . $vkpreis[$I] . '</th>';
			echo '</tr>';
			
		}
	$I++;
?>
</tbody>
</table>
</html>
