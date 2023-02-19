<?php
require("seguridad.php");
require("rintera-config.php");


$column = array("idseguro", "tag", "cantidad_asegurada", "costo","nmeses");

$query = "SELECT * FROM seguros_config ";

if(isset($_POST["search"]["value"]))
{
    // $query .= '
    // WHERE tag LIKE "%'.$_POST["search"]["value"].'%" 
    // OR cantidad_asegurada LIKE "%'.$_POST["search"]["value"].'%" 
    // OR costo LIKE "%'.$_POST["search"]["value"].'%" 
    // ';
    $query .= '
 WHERE tag LIKE "%'.$_POST["search"]["value"].'%" 
 
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY tag asc ';
}
$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $db1_pdo->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$statement = $db1_pdo->prepare($query . $query1);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

foreach($result as $row)
{
 $sub_array = array();
 $sub_array[] = $row['idseguro'];
 $sub_array[] = $row['tag'];
 $sub_array[] = $row['cantidad_asegurada'];
 $sub_array[] = $row['costo'];
 $sub_array[] = $row['nmeses'];
 $data[] = $sub_array;
}

function count_all_data($db1_pdo)
{
 $query = "SELECT * FROM seguros_config";
 $statement = $db1_pdo->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}

$output = array(
 'draw'   => intval($_POST['draw']),
 'recordsTotal' => count_all_data($db1_pdo),
 'recordsFiltered' => $number_filter_row,
 'data'   => $data
);

echo json_encode($output);
?>