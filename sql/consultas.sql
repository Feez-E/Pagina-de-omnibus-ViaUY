USE ViaUY;

SELECT * FROM Permiso;
SELECT * FROM Usuario;
SELECT * FROM Linea;
SELECT * FROM Transita;
SELECT * FROM Asiento;
SELECT * FROM Reserva;

SELECT valorDouble FROM ParametroDouble WHERE nombre_Parametro = "precioKm"; -- Devuelve el valor del kilometro en base a su parametro.
SELECT distancia FROM Tramo WHERE idInicial = 1 AND idFinal = 2; -- Devuelve el largo de un tramo, la distancia entre una parada y otra
SELECT multiplicador FROM Tramo INNER JOIN Estado ON Tramo.estado_Estado = Estado.estado WHERE idInicial = 1 AND idFinal = 2; -- Devuelve el multiplicador asociado al estado de un tramo
SELECT ROUND(SUM(multiplicador)-(COUNT(*)-1), 2) FROM Caracteristica WHERE numero_Unidad = 2; -- Devuelve el multiplicador general de todas las caracteristicas de una unidad, redondeandolo.

SELECT ROUND((SELECT distancia FROM Tramo WHERE idInicial = 1 AND idFinal = 2)*
(SELECT multiplicador FROM Tramo INNER JOIN Estado ON Tramo.estado_Estado = Estado.estado WHERE idInicial = 3 AND idFinal = 4)*
(SELECT valorDouble FROM ParametroDouble WHERE nombre_Parametro = "precioKm")*
(SELECT ROUND(SUM(multiplicador)-(COUNT(*)-1), 2) FROM Caracteristica WHERE numero_Unidad = 2), 2); -- Calcula el precio de un tramo en base a las caracteristicas de la Unidad

SELECT * FROM Usuario;

SELECT DISTINCT(apodo), direccion, codigo_Tiquet, numero_Asiento, fecha, horaSalida_S_T_Asiento, horaLlegada_L_T_Asiento, fechaLimite FROM Parada
INNER JOIN Usuario ON Parada.id = Usuario.id
INNER JOIN Reserva ON Usuario.id = Reserva.id_Usuario
WHERE Usuario.id = "1";

SELECT *
FROM Linea;
SELECT *
FROM Linea
INNER JOIN Transita ON Linea.codigo = Transita.codigo_L_Recorre;

SELECT Linea.codigo, Linea.nombre, Linea.origen, Linea.destino, Linea.vigencia, Transita.orden_Recorre
FROM Linea
INNER JOIN Transita ON Linea.codigo = Transita.codigo_L_Recorre
GROUP BY Linea.codigo, Linea.nombre, Linea.origen, Linea.destino, Linea.vigencia, Transita.orden_Recorre
ORDER BY Transita.orden_Recorre;

SELECT *
FROM Linea;


SELECT *
FROM Transita
ORDER BY  codigo_L_Recorre, horaSalida_Salida ASC, orden_Recorre ASC;
