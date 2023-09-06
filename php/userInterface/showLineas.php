<?php
include_once('../dataAccess/connection.php');
include_once('../dataAccess/lineaLink.php');
include_once('../dataAccess/transitaLink.php');
include_once('../dataAccess/paradaLink.php');
include_once('../dataAccess/tramoLink.php');

$lineaLink = new LineaLink($conn);
$lineasArr = $lineaLink->getLineas();

$transitaLink = new TransitaLink($conn);
$transitasArr = $transitaLink->getTransitas();
$indice = 0;

$paradaLink = new ParadaLink($conn);
$tramoLink = new TramoLink($conn);

foreach ($lineasArr as $linea) {
    


    if (array_key_exists($indice, $transitasArr)) {
        
        if($linea->getVigencia()){
            echo"<div class = line>";
            echo "<h3  class = Subtitle>".$linea->getNombre()." ".$linea->getOrigen()." ".$linea->getDestino()."</h3> ";
            $fecha = new DateTime($transitasArr[$indice]->getHoraSalida_Salida());
        }
       
        
        while ($indice < count($transitasArr) && $transitasArr[$indice]->getCodigo_L_Recorre() == $linea->getCodigo()){
            if($linea->getVigencia()){
                echo "<br>";
                /* echo $transitasArr[$indice]->getOrden_Recorre(); */
                /*  echo $paradaLink->getParadaById($transitasArr[$indice]->getIdInicial_T_Recorre())->getDireccion(). " " .
                     $paradaLink->getParadaById($transitasArr[$indice]->getIdFinal_T_Recorre())->getDireccion(); */

                $paradaInicial =  $paradaLink -> getParadaById($transitasArr[$indice] -> getIdInicial_T_Recorre());
                $paradaFinal = $paradaLink -> getParadaById($transitasArr[$indice] -> getIdFinal_T_Recorre());
                $direccionInicial = $paradaInicial -> getDireccion();
                $direccionFinal = $paradaFinal -> getDireccion();
                $direccionInicialSeparada = explode(",", $direccionInicial);
                $direccionFinalSeparada = explode(",", $direccionFinal);
                $ciudadInicial = trim($direccionInicialSeparada[1]);
                $ciudadFinal = trim($direccionFinalSeparada[1]);
                $tramo = $tramoLink->getTramoByIdInicialAndIdFinal($paradaInicial->getId(), $paradaFinal->getId());
                $hora = (($tramo->getTiempo())->format('H:i:s'));
                list($horas, $minutos, $segundos) = explode(':', $hora);
                $fecha->add(new DateInterval("PT{$horas}H{$minutos}M{$segundos}S"));
                echo $ciudadInicial . " -> " . $ciudadFinal . " -> " . $fecha->format('H:i:s') ;

                
               
            }
            $indice += 1;
        
        }
        if($linea->getVigencia()){
        echo "</div>";
        }
    }
    
}
?>