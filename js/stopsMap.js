import { stopsMapOnClick, paradasLoopThrough, paradasCustomIcons, newMap } from './map.js';

// Crea un mapa Leaflet y establece la vista en una ubicación específica
var map = newMap("stopsMap");
// Crea íconos personalizados para los marcadores
var { customIcon, customIconFalse } = paradasCustomIcons();
// Itera a través de un array de paradas y crea marcadores en el mapa para cada una
var {id} = paradasLoopThrough(map, customIcon, customIconFalse);

// Agrega un evento de clic al mapa
map.on("click", (e) => {
    stopsMapOnClick(e, map, customIcon, id);
});
