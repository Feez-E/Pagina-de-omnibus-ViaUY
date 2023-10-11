import {createBusLookUpButtons, paradasLoopThrough, paradasCustomIcons, newMap } from './map.js';

// Crea un mapa Leaflet y establece la vista en una ubicación específica
var map = newMap("stopsMap");
// Crea íconos personalizados para los marcadores
var { customIcon, customIconFalse } = paradasCustomIcons();
// Itera a través de un array de paradas y crea marcadores en el mapa para cada una
paradasLoopThrough(map, customIcon, customIconFalse, "busLookUp");