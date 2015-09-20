<?php
function	insert_answer($answer)
{
	$con = mysqli_connect("demo.local.42.fr","root","coucou","diane_adelie", "3301");
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	mysqli_query($con, "INSERT INTO answers (`string`) VALUES ('$answer')")
		or die(mysqli_error($con));
	$id_answer = mysqli_insert_id($con);
	mysqli_close($con);
	return $id_answer;
}
function	insert_formula($id_answer, $formula, $type_operation, $type_resolution, $miscalculation)
{
	$con = mysqli_connect("demo.local.42.fr","root","coucou","diane_adelie", "3301");
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	mysqli_query($con, "INSERT INTO formulas (`id_answer`, `string`, `type_operation`, `type_resolution`, `miscalculation`)
		VALUES ('$id_answer', '$formula', '$type_operation', '$type_resolution', '$miscalculation')")
		or die(mysqli_error($con));
	mysqli_close($con);
}
?>
