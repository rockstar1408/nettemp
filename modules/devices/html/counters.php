<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Counters </h3></div>

<div class="table-responsive">
<table class="table table-hover table-condensed small" border="0">
	
<thead>
<th>Name</th>
<th>Type</th>
<th>Counters</th>
</thead>

<?php
$sum = isset($_POST['sum']) ? $_POST['sum'] : '';
$sum1 = isset($_POST['sum1']) ? $_POST['sum1'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';


if ($sum1 == 'sum2'){
    $db = new PDO('sqlite:dbf/nettemp.db');
    $db->exec("UPDATE sensors SET sum='$sum' WHERE id='$id'") or die ($db->lastErrorMsg());
	//header("location: " . $_SERVER['REQUEST_URI']);
	//exit();
}

$db = new PDO('sqlite:dbf/nettemp.db');
$rows = $db->query("SELECT * FROM sensors WHERE type='elec'");
$row = $rows->fetchAll();
foreach ($row as $a) { 	?>
<tr>
    <td class="col-md-0">
		<?php echo $a["name"]; ?>
	</td>
	<td class="col-md-0">
		<?php echo $a["type"]; ?>
	</td>
	<td class="col-md-10">
		<form action="" method="post" style="display:inline!important;">
			<input type="text" name="sum" size="16" maxlength="30" value="<?php echo $a["sum"]; ?>" required=""/>
			<button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span> </button>
			<input type="hidden" name="id" value="<?php echo $a["id"]; ?>" />
			<input type="hidden" name="sum1" value="sum2"/>
    </form>
	</td>
</tr>
<?php
	}
?>

</table>



</div>

