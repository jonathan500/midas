CREATE DATABASE midas;
USE midas;


CREATE TABLE midas_usuarios(
usuario_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
usuario_email VARCHAR(255) NOT NULL UNIQUE,
usuario_senha TEXT NOT NULL,
usuario_nome VARCHAR(255) NOT NULL
);

CREATE TABLE midas_categorias(
categoria_id INT(11) NOT NULL PRIMARY KEY,
categoria_descricao VARCHAR(255) NOT NULL,
categoria_situacao ENUM('A','N') NOT NULL DEFAULT 'N'
);

CREATE TABLE midas_cartoes(
cartao_id INT(11) NOT NULL PRIMARY KEY,
cartao_descricao TEXT NOT NULL
);

CREATE TABLE midas_movimentacoes(
movimentacao_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
movimentacao_usuario_id INT(11) NOT NULL,
movimentacao_categoria_id INT(11) NOT NULL ,
movimentacao_cartao_id INT(11) NOT NULL ,
movimentacao_descricao TEXT NOT NULL,
movimentacao_data DATE NOT NULL,
movimentacao_valor FLOAT NOT NULL,
FOREIGN KEY(movimentacao_usuario_id) REFERENCES midas_usuarios(usuario_id),
FOREIGN KEY(movimentacao_categoria_id) REFERENCES midas_categorias(categoria_id),
FOREIGN KEY(movimentacao_cartao_id) REFERENCES midas_cartoes(cartao_id)
);
