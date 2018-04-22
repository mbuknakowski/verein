<?php
include 'mysqllogin2.php';
include 'function.php';
//--------------------------------------------------------------------------------------------

$menge = (isset($_POST["menge"]) && is_string($_POST["menge"])) ? $_POST["menge"] : "";
$ekpreis = (isset($_POST["ekpreis"]) && is_string($_POST["ekpreis"])) ? $_POST["ekpreis"] : "";

//--------------------------------------------------------------------------------------------

$query = "SELECT * FROM warenbestand ORDER BY id";
$ergebnis = mysqli_query ( $db, $query );

$FILTER_warenbestand= array ();

while ( $spalte = mysqli_fetch_array ( $ergebnis ) ) {
	$warenbestand_ID = $spalte ['id'];
	$warenbestand= $spalte ['bezeichnung'];
	$FILTER_warenbestand["$warenbestand_ID"] = "$warenbestand";
}
mysqli_free_result ( $ergebnis );

//-------------------------------------------------------------------------------------------
$ok = false;
if (!empty($_POST["Abschicken"])){
	$ok = true;
	if (!isset($_POST["menge"]) ||
			!is_string($_POST["menge"])||
			trim($_POST["menge"])==""){
				$ok = false;
				$errMenge= "Bitte Menge eingeben";
	}
	if (!isset($_POST["ekpreis"]) ||
			!is_string($_POST["ekpreis"])||
			trim($_POST["ekpreis"])==""){
				$ok = false;
				$errEkpreis = "Bitte Einkaufspreis eingeben";
	}
	
	if ($ok == false){
		
	}else{
		
		$insert = "INSERT INTO `wareneinkauf`(
	`warenbestand_id`,
	`ekpreis`,
	`menge`
	) VALUES (
	'$warenbestand_ID',
	'$ekpreis',
	'$menge'
	)";
	mysqli_query ( $db, $insert );
	
	$query="SELECT
	`id`,
	`menge`
	FROM
	`warenbestand`
	WHERE
	`warenbestand`.`id` = $warenbestand_ID";
	$ergebnis1V=mysqli_query($db,$query);
	
	$fetch = mysqli_fetch_assoc($ergebnis1V);
	$EVVN = $fetch['menge'];
	
	$menge1 = $EVVN + $menge;
	
	?>
		<span class="error"> <b><?php printf ("erfolgreich angelegt unter %d \n", mysqli_insert_id ( $db ) )?> </b></span>
		<?php 
		$query = 'UPDATE `warenbestand`
		SET
		`menge` = "'.$menge1.'"
		WHERE `id` = "'.$_POST['warenbestand_id'].'"';
		mysqli_query ( $db, $query );
	
	}
}
unset($menge);
unset($ekpreis);
unset($_POST['Abschicken']);

//-------------------------------------------------------------------------------------------


?>

<?php include './html/header.php';?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<div>
			<label for="vorn">Ware: </label> <select id="vorn" name="warenbestand_id">
			
			<?php

			foreach ( $FILTER_warenbestand as $FILTER_warenbestand_ID => $FILTER_warenbestand) {
				if ($FILTER_warenbestand_ID!=$_POST['warenbestand_id']){
					echo "<option value=\"$FILTER_warenbestand_ID\">$FILTER_warenbestand</option>";
				}else{
					echo "<option value=\"$FILTER_warenbestand_ID\" selected>$FILTER_warenbestand</option>";
				}
			
			}
			?>
			
			</select>	 
		</div>
		<div>
			<label for="vorn">Menge: </label> <input id="vorn" type="text" 
				name="menge" value="<?php  echo htmlspecialchars($menge)?>" size="40">
				<span class="error">* <?php echo $errMenge;?></span>	
		</div>		
		<div>
			<label for="vorn">Einkaufspreis pro St&uuml;ck: </label> <input id="vorn" type="text"
				name="ekpreis" value="<?php  echo htmlspecialchars($ekpreis)?>" size="40">
				<span class="error">* <?php echo $errEkpreis;?></span>
		</div>
		
		<div>
			<input type="submit" value="Abschicken" name="Abschicken">
		</div><br>
		</form>

<?php include './html/footer.php';?>