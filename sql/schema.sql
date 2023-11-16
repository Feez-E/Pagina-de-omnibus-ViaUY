DROP DATABASE IF EXISTS ViaUY;
CREATE DATABASE ViaUY;
USE ViaUY;

CREATE TABLE Parada (
id INT AUTO_INCREMENT PRIMARY KEY,
direccion VARCHAR(80) NOT NULL,
coordenadas VARCHAR(50) NOT NULL,
vigencia BOOLEAN
);

CREATE TABLE Estado (
estado ENUM('R','M','N','B','E') PRIMARY KEY,
multiplicador DOUBLE NOT NULL
);

CREATE TABLE Tramo(
idInicial INT,
FOREIGN KEY(idInicial) REFERENCES Parada(id),
idFinal INT,
FOREIGN KEY(idFinal) REFERENCES Parada(id),
tiempo TIME NOT NULL,
distancia DOUBLE NOT NULL, 	
estado_Estado ENUM('R','M','N','B','E'),
FOREIGN KEY(estado_Estado) REFERENCES Estado(estado),
PRIMARY KEY (idInicial, idFinal)
);

CREATE TABLE Linea(
codigo INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(15) UNIQUE KEY NOT NULL,
origen VARCHAR(40) NOT NULL,
destino VARCHAR(40) NOT NULL,
vigencia BOOLEAN
);

CREATE TABLE Linea_diaHabil(
codigo_Linea INT,
FOREIGN KEY(codigo_Linea) REFERENCES Linea(codigo),
dia ENUM('L','M','X','J','V','S','D'),
PRIMARY KEY (codigo_Linea, dia)
);

CREATE TABLE Recorre(
idInicial_Tramo INT,
idFinal_Tramo INT,
FOREIGN KEY(idInicial_Tramo, idFinal_Tramo) REFERENCES Tramo(idInicial, idFinal),
codigo_Linea INT,
FOREIGN KEY(codigo_Linea) REFERENCES Linea(codigo),
orden INT,
PRIMARY KEY (idInicial_Tramo, idFinal_Tramo, codigo_Linea, orden)
);

CREATE TABLE Unidad(
numero INT PRIMARY KEY,
matricula VARCHAR(7) NOT NULL,
numeroChasis VARCHAR(20) UNIQUE KEY NOT NULL,
capacidadPrimerPiso INT NOT NULL,
capacidadSegundoPiso INT,
vigencia BOOLEAN
);

CREATE TABLE Caracteristica(
numero_Unidad INT,
FOREIGN KEY(numero_Unidad) REFERENCES Unidad(numero),
propiedad VARCHAR(30),
multiplicador DOUBLE NOT NULL,
PRIMARY KEY(numero_Unidad, propiedad)
);

CREATE TABLE Salida(
horaSalida TIME PRIMARY KEY
);

CREATE TABLE Llegada(
horaLlegada TIME PRIMARY KEY
);

CREATE TABLE Transita(
idInicial_T_Recorre INT,
idFinal_T_Recorre INT,
codigo_L_Recorre INT,
orden_Recorre INT,
FOREIGN KEY(idInicial_T_Recorre, idFinal_T_Recorre, codigo_L_Recorre, orden_Recorre) REFERENCES Recorre (idInicial_Tramo, idFinal_Tramo, codigo_Linea, orden),
numero_Unidad INT,
FOREIGN KEY(numero_Unidad) REFERENCES Unidad (numero),
horaSalida_Salida TIME,
FOREIGN KEY(horaSalida_Salida) REFERENCES Salida (horaSalida),
horaLlegada_Llegada TIME,
FOREIGN KEY(horaLlegada_Llegada) REFERENCES Llegada (horaLlegada),
vigencia BOOLEAN DEFAULT TRUE,
PRIMARY KEY(idInicial_T_Recorre, idFinal_T_Recorre, codigo_L_Recorre, orden_Recorre, numero_Unidad, horaSalida_Salida, horaLlegada_Llegada)
);

CREATE TABLE Parametro(
nombre VARCHAR(30) PRIMARY KEY NOT NULL
);

CREATE TABLE ParametroBoolean(
nombre_Parametro VARCHAR(30) PRIMARY KEY,
FOREIGN KEY(nombre_Parametro) REFERENCES Parametro (nombre),
valorBoolean BOOLEAN NOT NULL
);

CREATE TABLE ParametroDouble(
nombre_Parametro VARCHAR(30) PRIMARY KEY,
FOREIGN KEY(nombre_Parametro) REFERENCES Parametro (nombre),
valorDouble DOUBLE NOT NULL
);

CREATE TABLE ParametroVarchar(
nombre_Parametro VARCHAR(30) PRIMARY KEY,
FOREIGN KEY(nombre_Parametro) REFERENCES Parametro (nombre),
valorVarchar VARCHAR(100) NOT NULL
);

CREATE TABLE ParametroTime(
nombre_Parametro VARCHAR(30) PRIMARY KEY,
FOREIGN KEY(nombre_Parametro) REFERENCES Parametro (nombre),
valorTime TIME NOT NULL
);

CREATE TABLE Asiento(
numero INT,
idInicial_T_R_Transita INT,
idFinal_T_R_Transita INT,
codigo_L_R_Transita INT,
orden_R_Transita INT,
numero_U_Transita INT,
horaSalida_S_Transita TIME,
horaLlegada_L_Transita TIME,
FOREIGN KEY(idInicial_T_R_Transita, idFinal_T_R_Transita, codigo_L_R_Transita, orden_R_Transita, numero_U_Transita, horaSalida_S_Transita, horaLlegada_L_Transita) REFERENCES Transita (idInicial_T_Recorre, idFinal_T_Recorre, codigo_L_Recorre, orden_Recorre, numero_Unidad, horaSalida_Salida, horaLlegada_Llegada),
PRIMARY KEY(numero, idInicial_T_R_Transita, idFinal_T_R_Transita, codigo_L_R_Transita, orden_R_Transita, numero_U_Transita, horaSalida_S_Transita, horaLlegada_L_Transita)
);

CREATE TABLE Permiso (
nombre VARCHAR(40) PRIMARY KEY NOT NULL,
descripcion VARCHAR(100) NOT NULL,
url VARCHAR(50)
);

CREATE TABLE Rol (
nombre VARCHAR(25) PRIMARY KEY NOT NULL,
descripcion VARCHAR(100) NOT NULL
);

CREATE TABLE Tiene (
nombre_Rol VARCHAR(25),
FOREIGN KEY(nombre_Rol) REFERENCES Rol (nombre),
nombre_Permiso VARCHAR(40),
FOREIGN KEY(nombre_Permiso) REFERENCES Permiso (nombre),
PRIMARY KEY(nombre_Rol, nombre_Permiso)
);

CREATE TABLE Usuario (
id INT AUTO_INCREMENT PRIMARY KEY,
apodo VARCHAR(32) UNIQUE KEY NOT NULL,
nombre VARCHAR(30) NOT NULL,
apellido VARCHAR(30) NOT NULL,
correo VARCHAR(64) NOT NULL,
contrasena VARCHAR(60) NOT NULL,
telefono VARCHAR(10) NOT NULL,
fechaNac DATE NOT NULL,
nombre_Rol VARCHAR(25),
FOREIGN KEY(nombre_Rol) REFERENCES Rol(nombre)
);

CREATE TABLE MetodoPago (
metodo VARCHAR(25) PRIMARY KEY
);

CREATE TABLE Tiquet (
codigo VARCHAR(16),
precio DOUBLE NOT NULL,
PRIMARY KEY(codigo)
);

CREATE TABLE Reserva(
numero_Asiento INT,
idInicial_T_R_T_Asiento INT,
idFinal_T_R_T_Asiento INT,
codigo_L_R_T_Asiento INT,
orden_R_T_Asiento INT,
numero_U_T_Asiento INT,
horaSalida_S_T_Asiento TIME,
horaLlegada_L_T_Asiento TIME,
FOREIGN KEY(numero_Asiento, idInicial_T_R_T_Asiento, idFinal_T_R_T_Asiento, codigo_L_R_T_Asiento, orden_R_T_Asiento, numero_U_T_Asiento, horaSalida_S_T_Asiento, horaLlegada_L_T_Asiento) REFERENCES Asiento (numero, idInicial_T_R_Transita, idFinal_T_R_Transita, codigo_L_R_Transita, orden_R_Transita, numero_U_Transita, horaSalida_S_Transita, horaLlegada_L_Transita),
id_Usuario INT,
FOREIGN KEY(id_Usuario) REFERENCES Usuario(id),
fechaLimite DATE,
metodo_MetodoPago VARCHAR(25),
FOREIGN KEY(metodo_MetodoPago) REFERENCES MetodoPago(metodo),
estado ENUM("Pagado", "En espera", "Cancelado", "Anulado"),
fecha DATE NOT NULL,
hora TIME NOT NULL,
codigo_Tiquet VARCHAR(16),
FOREIGN KEY(codigo_Tiquet) REFERENCES Tiquet(codigo),
PRIMARY KEY(numero_Asiento, idInicial_T_R_T_Asiento, idFinal_T_R_T_Asiento, codigo_L_R_T_Asiento, orden_R_T_Asiento, numero_U_T_Asiento, horaSalida_S_T_Asiento, horaLlegada_L_T_Asiento, hora, fecha)
);