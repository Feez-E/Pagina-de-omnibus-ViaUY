USE ViaUY;

SELECT * FROM Usuario;
SELECT * FROM Linea;
SELECT * FROM Transita;
SELECT * FROM Transita ORDER BY codigo_L_Recorre, horaSalida_Salida ASC, orden_Recorre ASC;
SELECT * FROM Tiquet;
SELECT * FROM Asiento;
SELECT * FROM Asiento ORDER BY horaSalida_S_Transita, horaLlegada_L_Transita, numero, idInicial_T_R_Transita, idFinal_T_R_Transita, codigo_L_R_Transita, orden_R_Transita, numero_U_Transita;
SELECT * FROM Reserva;

SELECT t.nombre_rol, p.nombre, p.descripcion, p.url FROM Permiso p JOIN Tiene t ON p.nombre = t.nombre_permiso WHERE nombre_rol = "Cliente" ; -- Muestra todos los permisos de un rol.

SELECT DISTINCT U.*
FROM Unidad U
INNER JOIN Transita T ON U.numero = T.numero_Unidad
INNER JOIN Linea L ON T.codigo_L_Recorre = L.codigo
WHERE L.nombre = 'L1' AND T.horaSalida_Salida = '18:00'; -- Muestra la información de una unidad que transitan un linea en un hora.

SELECT * 
FROM Caracteristica
WHERE numero_unidad = "2"; -- Muestra todas las caracteristicas de una unidad y su multiplicador

SELECT valorDouble FROM ParametroDouble WHERE nombre_Parametro = "precioKm"; -- Devuelve el valor del kilometro en base a su parametro.
SELECT distancia FROM Tramo WHERE idInicial = 1 AND idFinal = 3; -- Devuelve el largo de un tramo, la distancia entre una parada y otra
SELECT multiplicador FROM Tramo INNER JOIN Estado ON Tramo.estado_Estado = Estado.estado WHERE idInicial = 1 AND idFinal = 3; -- Devuelve el multiplicador asociado al estado de un tramo
SELECT ROUND(SUM(multiplicador)-(COUNT(*)-1), 2) FROM Caracteristica WHERE numero_Unidad = 2; -- Devuelve el multiplicador general de todas las caracteristicas de una unidad, redondeandolo.

SELECT ROUND((SELECT distancia FROM Tramo WHERE idInicial = 1 AND idFinal = 3)*
(SELECT multiplicador FROM Tramo INNER JOIN Estado ON Tramo.estado_Estado = Estado.estado WHERE idInicial = 1 AND idFinal = 3)*
(SELECT valorDouble FROM ParametroDouble WHERE nombre_Parametro = "precioKm")*
(SELECT ROUND(SUM(multiplicador)-(COUNT(*)-1), 2) FROM Caracteristica WHERE numero_Unidad = 2), 2); -- Calcula el precio de un tramo en base a las caracteristicas de la Unidad.

SELECT id_Usuario, codigo_Tiquet, numero_Asiento, nombre AS nombreLinea, horaSalida_S_T_Asiento, horaLlegada_L_T_Asiento,
	numero_U_T_Asiento, estado, Tiquet.precio AS precio, metodo_MetodoPago, fecha, fechaLimite 
FROM Reserva 
INNER JOIN Tiquet ON Reserva.codigo_Tiquet = Tiquet.codigo
INNER JOIN Linea ON Reserva.codigo_L_R_T_Asiento = Linea.codigo
INNER JOIN Asiento ON Reserva.numero_Asiento = Asiento.numero AND Reserva.numero_U_T_Asiento = Asiento.numero_U_Transita 
	AND Reserva.idInicial_T_R_T_Asiento = Asiento.idInicial_T_R_Transita AND Reserva.idFinal_T_R_T_Asiento = Asiento.idFinal_T_R_Transita
    AND Reserva.codigo_L_R_T_Asiento = Asiento.codigo_L_R_Transita AND Reserva.horaSalida_S_T_Asiento = Asiento.horaSalida_S_Transita 
	AND Reserva.horaLlegada_L_T_Asiento = Asiento.horaLlegada_L_Transita
WHERE id_Usuario = 1
GROUP BY id_Usuario, codigo_Tiquet, numero_Asiento, codigo_L_R_T_Asiento, horaSalida_S_T_Asiento, horaLlegada_L_T_Asiento,
	numero_U_T_Asiento, estado, precio, metodo_MetodoPago, fecha, fechaLimite; -- Muestra las reservas de forma estilizadas segun el id del usuario, junto con el precio total.

SELECT codigo_L_R_T_Asiento AS codigoLinea, Linea.nombre, COUNT(DISTINCT(codigo_Tiquet)) AS reservasPorLinea
FROM Reserva
INNER JOIN Linea ON Reserva.codigo_L_R_T_Asiento = Linea.codigo
WHERE fecha BETWEEN '2023-01-01' AND '2023-12-31' 
GROUP BY codigo_L_R_T_Asiento
ORDER BY reservasPorLinea DESC
LIMIT 1; -- Muestra la línea más reservada entre dos fechas establecidas.

SELECT numero_U_T_Asiento AS unidad, COUNT(DISTINCT(codigo_Tiquet)) AS reservasPorUnidad
FROM Reserva
GROUP BY numero_U_T_Asiento
ORDER BY reservasPorUnidad DESC
LIMIT 1; -- Muestra la unidad con menos reservas vendidas.

SELECT codigo_Tiquet, Linea.nombre AS codigoLinea, numero_U_T_Asiento, numero_Asiento, orden_R_T_Asiento, fecha, hora,
	idInicial_T_R_T_Asiento, idFinal_T_R_T_Asiento, tiempo, distancia, estado_Estado,
    Parada.id AS 'idParada', Parada.direccion AS 'direccionParada', Parada.vigencia AS 'vigenciaParada'
FROM Reserva
INNER JOIN Linea ON Reserva.codigo_L_R_T_Asiento = Linea.codigo
INNER JOIN Tramo ON Reserva.idInicial_T_R_T_Asiento = Tramo.idInicial AND Reserva.idFinal_T_R_T_Asiento = Tramo.idFinal
INNER JOIN Parada ON Tramo.idInicial = Parada.id OR Tramo.idFinal = Parada.id
WHERE id_Usuario = 1
ORDER BY codigo_Tiquet, orden_R_T_Asiento ASC, 'idParada' DESC; -- Muestra los recorrido detallados de las reservas de un cliente.