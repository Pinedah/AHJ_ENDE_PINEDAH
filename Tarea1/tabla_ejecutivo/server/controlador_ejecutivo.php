<?php
include '../inc/conexion.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$action = escape($_POST['action'], $connection);
	
	switch($action) {

		case 'obtener_ejecutivos':
			$filtro = isset($_POST['filtro']) ? escape($_POST['filtro'], $connection) : '';
			$query ="SELECT id_eje, nom_eje, tel_eje 
					 FROM ejecutivo 
					 WHERE nom_eje LIKE '%$filtro%'
					 ORDER BY nom_eje ASC";

			$datos = ejecutarConsulta($query, $connection);

			if($datos !== false) {
				echo respuestaExito($datos, 'Ejecutivos obtenidos correctamente');
			} else {
				echo respuestaError('Error al consultar ejecutivos: ' . mysqli_error($connection) . ' Query: ' . $query);
			}
		break;

		case 'obtener_citas':
			$filtro = isset($_POST['filtro']) ? escape($_POST['filtro'], $connection) : '';
			$query = "SELECT c.id_cit, c.nom_cit, e.nom_eje 
					 FROM cita c
					 LEFT JOIN ejecutivo e ON c.id_eje2 = e.id_eje
					 WHERE c.nom_cit LIKE '%$filtro%'
					 ORDER BY c.nom_cit ASC";

			$datos = ejecutarConsulta($query, $connection);

			if($datos !== false) {
				echo respuestaExito($datos, 'Citas obtenidas correctamente');
			} else {
				echo respuestaError('Error al consultar citas: ' . mysqli_error($connection) . ' Query: ' . $query);
			}
		break;

		case 'guardar_ejecutivo':
			$nom_eje = escape($_POST['nom_eje'], $connection);
			$tel_eje = escape($_POST['tel_eje'], $connection);

			$query = "INSERT INTO ejecutivo (nom_eje, tel_eje) 
					 VALUES ('$nom_eje', '$tel_eje')";

			if(mysqli_query($connection, $query)) {
				echo respuestaExito(['id' => mysqli_insert_id($connection)], 'Ejecutivo guardado correctamente');
			} else {
				echo respuestaError('Error al guardar ejecutivo: ' . mysqli_error($connection) . ' Query: ' . $query);
			}
		break;

		case 'guardar_cita':
			$nom_cit = escape($_POST['nom_cit'], $connection);
			$id_eje2 = escape($_POST['id_eje2'], $connection);

			$query = "INSERT INTO cita (nom_cit, id_eje2) 
					 VALUES ('$nom_cit', '$id_eje2')";

			if(mysqli_query($connection, $query)) {
				echo respuestaExito(['id' => mysqli_insert_id($connection)], 'Cita guardada correctamente');
			} else {
				echo respuestaError('Error al guardar cita: ' . mysqli_error($connection) . ' Query: ' . $query);
			}
		break;

		default:
			echo respuestaError('Acción no válida');
		break;
	}

	mysqli_close($connection);
	exit;
}
?>