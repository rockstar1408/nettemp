<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 
$hostname=gethostname(); 
$minute=date('i');

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
	include("$ROOT/receiver.php");
	$query = $db->query("SELECT * FROM snmp");
    $result= $query->fetchAll();
    foreach($result as $s) {
		$community=$s['community'];
		$host=$s['host'];
		$oid=$s['oid'];
		$divider=$s['divider'];
		$local_type=$s['type'];
		$version=$s['version'];
		if($version=='1'){
			$out = snmpget($host, $community, $oid);
			$out=explode(" ",$out);
			$output=number_format($out[1], $divider, '.', ',');
		} elseif($version=='2') {
			$out = snmp2_get($host, $community, $oid);
			$out=explode(" ",$out);
			$output=number_format($out[1], $divider, '.', ',');
		}
		$local_val=
		$local_rom="snmp_".$host."_".$local_type;
		$device='';
		$current='';
		echo $date." Host:".$host." Rom:".$local_rom." Type:".$local_type." Value:".$output."\n";
		db($local_rom,$local_val,$local_type,$device,$current);
	}
} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>