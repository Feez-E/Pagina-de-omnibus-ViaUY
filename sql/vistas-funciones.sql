USE ViaUY;

SELECT valorDouble FROM ParametroDouble WHERE nombre_Parametro = "precioKm"; -- Devuelve el valor del kilometro en base a su parametro.
SELECT distancia FROM Tramo WHERE idInicial = 1 AND idFinal = 2; -- Devuelve el largo de un tramo, la distancia entre una parada y otra
SELECT multiplicador FROM Tramo INNER JOIN Estado ON Tramo.estado_Estado = Estado.estado WHERE idInicial = 1 AND idFinal = 2; -- Devuelve el multiplicador asociado al estado de un tramo
SELECT ROUND(SUM(multiplicador)-(COUNT(*)-1), 2) FROM Caracteristica WHERE numero_Unidad = 2; -- Devuelve el multiplicador general de todas las caracteristicas de una unidad, redondeandolo.

