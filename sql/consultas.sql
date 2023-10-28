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

SELECT id_Usuario, codigo_Tiquet, numero_Asiento, nombre AS nombreLinea, horaSalida_S_T_Asiento, horaLlegada_L_T_Asiento,
	numero_U_T_Asiento, estado, ROUND(SUM(Asiento.precio), 2) AS precio, metodo_MetodoPago, fecha, fechaLimite 
FROM Reserva 
INNER JOIN Tiquet ON Reserva.codigo_Tiquet = Tiquet.codigo
INNER JOIN Linea ON Reserva.codigo_L_R_T_Asiento = Linea.codigo
INNER JOIN Asiento ON Reserva.numero_Asiento = Asiento.numero AND Reserva.numero_U_T_Asiento = Asiento.numero_U_Transita 
	AND Reserva.idInicial_T_R_T_Asiento = Asiento.idInicial_T_R_Transita AND Reserva.idFinal_T_R_T_Asiento = Asiento.idFinal_T_R_Transita
    AND Reserva.codigo_L_R_T_Asiento = Asiento.codigo_L_R_Transita AND Reserva.horaSalida_S_T_Asiento = Asiento.horaSalida_S_Transita 
	AND Reserva.horaLlegada_L_T_Asiento = Asiento.horaLlegada_L_Transita
WHERE id_Usuario = 2
GROUP BY codigo_Tiquet, numero_Asiento, codigo_L_R_T_Asiento, horaSalida_S_T_Asiento, horaLlegada_L_T_Asiento,
	numero_U_T_Asiento, estado, metodo_MetodoPago, fecha, fechaLimite; -- Muestra las reservas de forma estilizadas segun el id del usuario solitado, junto con el precio total.

SELECT DISTINCT(apodo), direccion, codigo_Tiquet, numero_Asiento, fecha, horaSalida_S_T_Asiento, horaLlegada_L_T_Asiento, fechaLimite FROM Parada
INNER JOIN Usuario ON Parada.id = Usuario.id
INNER JOIN Reserva ON Usuario.id = Reserva.id_Usuario
WHERE Usuario.id = "1";

SELECT * FROM Linea
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

SELECT distinct U.*
FROM Unidad U
INNER JOIN Transita T ON U.numero = T.numero_Unidad
INNER JOIN Linea L ON T.codigo_L_Recorre = L.codigo
WHERE L.nombre = 'L1'
AND T.horaSalida_Salida = '18:00';

SELECT * FROM Caracteristica WHERE numero_unidad = "2";

SELECT numero_Asiento, 
            idInicial_T_R_T_Asiento,
            idFinal_T_R_T_Asiento 
            FROM Reserva 
            WHERE idInicial_T_R_T_Asiento >= 1 
            AND idFinal_T_R_T_Asiento <= 19
            AND codigo_L_R_T_Asiento = 1 
            AND numero_U_T_Asiento = 2 
            AND horaSalida_S_T_Asiento = "06:00:00"
            AND horaLlegada_L_T_Asiento = "07:30:00" 
            AND fecha = "2023-12-01";