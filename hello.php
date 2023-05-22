<h1>Web Scriping</h1>

<?php
require 'vendor/autoload.php'; // se mandan llamar las dependencias de goutte

use Goutte\Client; 

$client = new Client();


$url = 'https://siat.sat.gob.mx/app/qr/faces/pages/mobile/validadorqr.jsf?D1=10&D2=1&D3=14120128811_MAMA701030KZ3';

$crawler = $client->request('GET', $url);


$tbody = $crawler->filter("[id='ubicacionForm:j_idt12:0:j_idt13:j_idt16_data']"); // Selector actualizado// Selector para el tbody
$tbody2 = $crawler->filter("[id='ubicacionForm:j_idt12:1:j_idt13:j_idt16_data']");
$tbody3 = $crawler->filter("[id='ubicacionForm:j_idt12:2:j_idt13:j_idt16_data']");

$rows = $tbody->filter('tr'); // Filtrar las filas dentro del tbody
$rows2 = $tbody2->filter('tr');
$rows3 = $tbody3->filter('tr');

$data = array();
$data2 = array();
$data3 = array();



$rows->each(function ($row) use (&$data) {
    $columns = $row->filter('td'); // Filtrar las columnas dentro de cada fila
    $key = trim($columns->eq(0)->text()); // Obtener el texto de la primera columna y eliminar espacios en blanco
    $value = trim($columns->eq(1)->text()); // Obtener el texto de la segunda columna y eliminar espacios en blanco
    $data[$key] = $value; // Agregar el par clave-valor al array de datos
});

$rows2->each(function ($row) use (&$data2) {
    $columns = $row->filter('td'); 
    $key = trim($columns->eq(0)->text()); 
    $value = trim($columns->eq(1)->text()); 
    $data2[$key] = $value; 
});

$rows3->each(function ($row) use (&$data3) {
    $columns = $row->filter('td');
    $rowData = array();
    
    $columns->each(function ($column) use (&$rowData) {
        $text = trim($column->text());
        $rowData[] = $text;
    });
    
    $data3[] = $rowData;
});


$curp = $data['CURP:'];
$nombre = $data['Nombre:'];
$apellidoPaterno = $data['Apellido Paterno:'];
$apellidoMaterno = $data['Apellido Materno:'];
$fechaDeNacimiento = $data['Fecha Nacimiento:'];
$fechaDeInicioDeOperaciones = $data['Fecha de Inicio de operaciones:'];
$situacionDelContribuyente = $data['Situación del contribuyente:'];
$fechaUltimoCambioDeSituacion = $data['Fecha del último cambio de situación:'];


$entidadFederativa = $data2['Entidad Federativa:'];
$municipioODelegacion = $data2['Municipio o delegación:'];
$colonia = $data2['Colonia:'];
$tipoDeVialidad = $data2['Tipo de vialidad:'];
$nombreDeLaVialidad = $data2['Nombre de la vialidad:'];
$numeroExterior = $data2['Número exterior:'];
$cp = $data2['CP:'];
$correoElectronico = $data2['Correo electrónico:'];
$al = $data2['AL:'];

$data3Values = array_values($data3);



$regimen = $data3[0][1];
$fechadealta =$data3Values[1][1];
$regimen2 = $data3[2][1];
$fechadealta2 =$data3Values[3][1];
$regimen3 = $data3[4][1];
$fechadealta3 =$data3Values[5][1];



foreach ($data as $key => $value) {
    echo $key . ": " . $value . "\n";
}

foreach ($data2 as $key => $value) {
    echo $key . ": " . $value . "\n" ;
}

foreach ($data3 as $subarray) {  //con este podemos ver todos los subarrays que hay por si hay necesidad de mas regimenes.
    echo $subarray[1] . "\n";
}


?>