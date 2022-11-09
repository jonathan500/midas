CREATE DATABASE midas;
USE midas;


CREATE TABLE midas_usuarios(
usuario_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
usuario_email VARCHAR(255) NOT NULL UNIQUE,
usuario_senha TEXT NOT NULL,
usuario_nome VARCHAR(255) NOT NULL,
usuario_cpf CHAR(14) NULL
);

