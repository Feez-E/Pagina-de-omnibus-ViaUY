<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'unidad.php');
include_once(DATA_PATH . 'unidadLink.php');
include_once(BUSINESS_PATH . 'caracteristica.php');
include_once(DATA_PATH . 'caracteristicaLink.php');
include_once(DATA_PATH . 'connection.php');

$unidadLink = new UnidadLink($conn);
$caracteristicaLink = new CaracteristicaLink($conn);



$unidades = [];
$unidadesGral = $unidadLink->getUnidades();


foreach ($unidadesGral as $key => $unidad) {
    $caracteristicas = $caracteristicaLink->getCaracteristicasByNumeroUnidad($unidad->getNumero());


    $unidad = array(
        "numero" => $unidad->getNumero(),
        "matricula" => $unidad->getMatricula(),
        "numeroChasis" => $unidad->getNumeroChasis(),
        "capacidadPrimerPiso" => $unidad->getCapacidadPrimerPiso(),
        "capacidadSegundoPiso" => $unidad->getCapacidadSegundoPiso(),
        "vigencia" => $unidad->getVigencia()
    );

    foreach ($caracteristicas as $key => $caracteristica) {
        $unidad["caracteristicas"][] = array(
            "caracteristica" => $caracteristica->getPropiedad(),
            "multiplicador" => $caracteristica->getMultiplicador()
        );
    }

    $unidades[] = $unidad;
}

?>