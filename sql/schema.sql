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
multiplicador FLOAT NOT NULL
);

CREATE TABLE Tramo(
idInicial INT,
FOREIGN KEY(idInicial) REFERENCES Parada(id),
idFinal INT,
FOREIGN KEY(idFinal) REFERENCES Parada(id),
tiempo TIME NOT NULL,
distancia FLOAT NOT NULL, 	
estado_Estado ENUM('R','M','N','B','E'),
FOREIGN KEY(estado_Estado) REFERENCES Estado(estado),
PRIMARY KEY (idInicial, idFinal)
);

CREATE TABLE Linea(
codigo INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(15) UNIQUE KEY NOT NULL,
origen VARCHAR(30) NOT NULL,
destino VARCHAR(30) NOT NULL,
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
orden INT NOT NULL,
PRIMARY KEY (idInicial_Tramo, idFinal_Tramo, codigo_Linea)
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
multiplicador INT NOT NULL,
PRIMARY KEY(numero_Unidad, propiedad)
);

CREATE TABLE Horario(
horaSalida TIME NOT NULL,
horaLlegada TIME NOT NULL,
PRIMARY KEY(horaSalida, horaLlegada)
);

CREATE TABLE Transita(
idInicial_T_Recorre INT,
idFinal_T_Recorre INT,
codigo_L_Recorre INT,
FOREIGN KEY(idInicial_T_Recorre, idFinal_T_Recorre, codigo_L_Recorre) REFERENCES Recorre (idInicial_Tramo, idFinal_Tramo, codigo_Linea),
numero_Unidad INT,
FOREIGN KEY(numero_Unidad) REFERENCES Unidad (numero),
horaSalida_Horario TIME,
horaLlegada_Horario TIME,
FOREIGN KEY(horaSalida_Horario, horaLlegada_Horario) REFERENCES Horario (horaSalida, horaLlegada),
PRIMARY KEY(idInicial_T_Recorre, idFinal_T_Recorre, codigo_L_Recorre, numero_Unidad, horaSalida_Horario, horaLlegada_Horario)
);

CREATE TABLE Parametro(
nombre VARCHAR(20) PRIMARY KEY NOT NULL
);

CREATE TABLE ParametroBoolean(
nombre_Parametro VARCHAR(20) PRIMARY KEY NOT NULL,
FOREIGN KEY(nombre_Parametro) REFERENCES Parametro (nombre),
valorBoolean BOOLEAN
);

CREATE TABLE ParametroInt(
nombre_Parametro VARCHAR(20) PRIMARY KEY NOT NULL,
FOREIGN KEY(nombre_Parametro) REFERENCES Parametro (nombre),
valorInt INT
);

CREATE TABLE ParametroVarchar(
nombre_Parametro VARCHAR(20) PRIMARY KEY NOT NULL,
FOREIGN KEY(nombre_Parametro) REFERENCES Parametro (nombre),
valorVarchar VARCHAR(50)
);

CREATE TABLE ParametroTime(
nombre_Parametro VARCHAR(20) PRIMARY KEY NOT NULL,
FOREIGN KEY(nombre_Parametro) REFERENCES Parametro (nombre),
valorTime TIME
);

CREATE TABLE Asiento(
numero INT NOT NULL,
idInicial_T_R_Transita INT,
idFinal_T_R_Transita INT,
codigo_L_R_Transita INT,
numero_U_Transita INT,
FOREIGN KEY(idInicial_T_R_Transita, idFinal_T_R_Transita, codigo_L_R_Transita, numero_U_Transita) REFERENCES Transita (idInicial_T_Recorre, idFinal_T_Recorre, codigo_L_Recorre, numero_Unidad),
horaSalida_H_Transita TIME,
horaLlegada_H_Transita TIME,
FOREIGN KEY(horaSalida_H_Transita, horaLlegada_H_Transita) REFERENCES Transita (horaSalida_Horario, horaLlegada_Horario),
nombre_P_ParametroInt VARCHAR(30),
FOREIGN KEY(nombre_P_ParametroInt) REFERENCES ParametroInt (nombre_Parametro),
precio INT NOT NULL,
disponibilidad BOOLEAN,
PRIMARY KEY(numero, idInicial_T_R_Transita, idFinal_T_R_Transita, codigo_L_R_Transita, numero_U_Transita, horaSalida_H_Transita, horaLlegada_H_Transita)
);

CREATE TABLE Permiso (
nombre VARCHAR(25) PRIMARY KEY NOT NULL,
descripcion VARCHAR(100) NOT NULL,
url VARCHAR(50)
);

CREATE TABLE Rol (
nombre VARCHAR(20) PRIMARY KEY NOT NULL,
descripcion VARCHAR(100) NOT NULL
);

CREATE TABLE Tiene (
nombre_Rol VARCHAR(20),
FOREIGN KEY(nombre_Rol) REFERENCES Rol (nombre),
nombre_Permiso VARCHAR(40),
FOREIGN KEY(nombre_Permiso) REFERENCES Permiso (nombre),
PRIMARY KEY(nombre_Rol, nombre_Permiso)
);

CREATE TABLE Usuario (
id INT AUTO_INCREMENT PRIMARY KEY,
apodo VARCHAR(32) UNIQUE KEY NOT NULL,
nombre VARCHAR(20) NOT NULL,
apellido VARCHAR(25) NOT NULL,
correo VARCHAR(64) NOT NULL,
contrasena VARCHAR(64) NOT NULL,
telefono VARCHAR(10) NOT NULL,
fechaNac DATE NOT NULL,
nombre_Rol VARCHAR(20),
FOREIGN KEY(nombre_Rol) REFERENCES Rol(nombre)
);

CREATE TABLE MetodoPago (
metodo VARCHAR(25) PRIMARY KEY
);

CREATE TABLE Tiquet (
codigo INT PRIMARY KEY
);

CREATE TABLE Reserva(
numero_Asiento INT,
idInicial_T_R_T_Asiento INT,
idFinal_T_R_T_Asiento INT,
codigo_L_R_T_Asiento INT,
numero_U_T_Asiento INT,
FOREIGN KEY(numero_Asiento, idInicial_T_R_T_Asiento, idFinal_T_R_T_Asiento, codigo_L_R_T_Asiento, numero_U_T_Asiento) REFERENCES Asiento (numero, idInicial_T_R_Transita, idFinal_T_R_Transita, codigo_L_R_Transita, numero_U_Transita),
horaSalida_H_T_Asiento TIME,
horaLlegada_H_T_Asiento TIME,
FOREIGN KEY(horaSalida_H_T_Asiento, horaLlegada_H_T_Asiento) REFERENCES Asiento (horaSalida_H_Transita, horaLlegada_H_Transita),
id_Usuario INT,
FOREIGN KEY(id_Usuario) REFERENCES Usuario(id),
nombre_P_ParametroTime VARCHAR(20),
FOREIGN KEY(nombre_P_ParametroTime) REFERENCES ParametroTime(nombre_Parametro),
fechaLimite DATE,
metodo_MetodoPago VARCHAR(25),
FOREIGN KEY(metodo_MetodoPago) REFERENCES MetodoPago(metodo),
estado ENUM("Pago", "En espera", "Cancelado", "Anulado"),
fecha DATE,
hora TIME,
codigo_Tiquet INT,
FOREIGN KEY(codigo_Tiquet) REFERENCES Tiquet(codigo),
PRIMARY KEY(codigo_Tiquet, numero_Asiento, idInicial_T_R_T_Asiento, idFinal_T_R_T_Asiento, codigo_L_R_T_Asiento, numero_U_T_Asiento, horaSalida_H_T_Asiento, horaLlegada_H_T_Asiento)
);