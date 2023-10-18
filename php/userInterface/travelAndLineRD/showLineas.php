<?php
include_once('../../dataAccess/connection.php');
include_once('../../dataAccess/lineaLink.php');
include_once('../../dataAccess/transitaLink.php');
include_once('../../dataAccess/paradaLink.php');
include_once('../../dataAccess/tramoLink.php');
include_once('../../dataAccess/linea_diaHabilLink.php');

$lineaLink = new LineaLink($conn);
$lineasArr = $lineaLink->getLineas();

$transitaLink = new TransitaLink($conn);
$transitasArr = $transitaLink->getTransitas();
$indice = 0;



$paradaLink = new ParadaLink($conn);
$tramoLink = new TramoLink($conn);
$linea_diaHabilLink = new Linea_diaHabilLink($conn);

$array = array();

foreach ($lineasArr as $linea) {

    $codigoLinea = $linea->getCodigo();

    if (array_key_exists($indice, $transitasArr)) {

        $indicePrevio = $indice;
        $horaSalida = $transitasArr[$indice]->getHoraSalida_Salida();
        $linea_diasHabilesArr = $linea_diaHabilLink->getLinea_diaHabilByCodigo_Linea($linea->getCodigo());

        echo "<div class = 'lineAndTravels travelAndLinePage shadow'><div class = line>";
        echo "<div class = lineLeft><h3  class = subtitle>" . $linea->getNombre() . " - " . $linea->getOrigen() . " " . $linea->getDestino() . "</h3> ";
        echo "<p>";
        foreach ($linea_diasHabilesArr as $linea_diasHabil) {
            echo $linea_diasHabil->getDia() . " ";
        }
        echo "</p></div><div id = lineToggle></div>";
        echo "</div>";
        echo "<div class = 'travels travelAndLine'><div class = 'lineData'></div><div class = 'desplegableSection travelAndLinePage'>";

        $fstLine = true;
        $fstTravel = true;
        
        while ($indice < count($transitasArr)) {
            if ($codigoLinea == $transitasArr[$indice]->getCodigo_L_Recorre()) {
                if ($horaSalida == $transitasArr[$indice]->getHoraSalida_Salida()) {
                    if ($fstLine) {
                        $fstLine = false;    
                        transitasContent($transitasArr, $indice);
                    }
                    if($fstTravel){
                        $array[$codigoLinea]["Salidas"][]  =  $transitasArr[$indice]->getIdInicial_T_Recorre();
                        $array[$codigoLinea]["Llegadas"][]  =  $transitasArr[$indice]->getIdFinal_T_Recorre();
                    }
                    /* en esta parte se puede trabajar con cada tramo especifico */
                } else {
                    echo "
                        </div>
                    </div>
                    <div class = 'desplegableSection travelAndLinePage'>";
                    transitasContent($transitasArr, $indice);
                    $horaSalida = $transitasArr[$indice]->getHoraSalida_Salida();
                    $indice -= 1;
                    $fstTravel = false;
                }
            } else {
                $horaSalida = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
                break;
            }
            $indice += 1;

        }

        echo "
                    </div>
                </div>
            </div>
        </div>";
        /*  <div class ='button wIcon'><div class = 'icons plus'></div></div> */

    }
}

?>

<script>
    let stopsIds = <?php echo json_encode(array_values($array)); ?>;
    let allLineData = document.querySelectorAll('.lineData');

    allLineData.forEach((lineData, i) => {
        let formattedData = 'Tramos: ';

        for (let j = 0; j < stopsIds[i].Salidas.length; j++) {
            formattedData += `(${stopsIds[i].Salidas[j]}, ${stopsIds[i].Llegadas[j]})`;
            if (j < stopsIds[i].Salidas.length - 1) {
                formattedData += ' ';
            }
        }

        lineData.innerHTML = `<p> ${formattedData} </p>`;
    });
</script>

<?php


function transitasContent($transitasArr, $indice)
{
    echo "
    <div class = desplegableTitle>
        <div class = desplegableSubtitle> 
            <p> Unidad: " . $transitasArr[$indice]->getNumero_Unidad() . "</p>
            <p> Salida: " . $transitasArr[$indice]->getHoraSalida_Salida() . "</p>
        </div>
    <div id='toggleArrow'></div>
</div>
<div class ='desplegableContent'>
<p class = salida> Salida: " . $transitasArr[$indice]->getHoraSalida_Salida() . "</p>
<p class = llegada> Llegada:" . $transitasArr[$indice]->getHoraLlegada_Llegada() . "</p>
<div class = busInfo>

</div>";
}
?>