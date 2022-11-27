/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.24-MariaDB : Database - midas
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`midas` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `midas`;

/*Table structure for table `midas_bandeiras` */

DROP TABLE IF EXISTS `midas_bandeiras`;

CREATE TABLE `midas_bandeiras` (
  `bandeira_id` int(11) NOT NULL,
  `bandeira_descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `midas_bandeiras` */

insert  into `midas_bandeiras`(`bandeira_id`,`bandeira_descricao`) values 
(1,'VISA'),
(2,'MASTERCARD'),
(3,'MAESTRO'),
(4,'ELO'),
(5,'ALELO'),
(6,'AMERICAN EXPRESS'),
(7,'BANCO DO BRASIL'),
(8,'HIPERCARD'),
(9,'DINERS CLUB INTERNATIONAL');

/*Table structure for table `midas_cartoes` */

DROP TABLE IF EXISTS `midas_cartoes`;

CREATE TABLE `midas_cartoes` (
  `cartao_id` int(11) NOT NULL AUTO_INCREMENT,
  `cartao_descricao` text NOT NULL,
  `cartao_usuario_id` int(11) NOT NULL,
  `cartao_bandeira_id` int(11) NOT NULL,
  `cartao_data_validade` date DEFAULT NULL,
  PRIMARY KEY (`cartao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `midas_cartoes` */

insert  into `midas_cartoes`(`cartao_id`,`cartao_descricao`,`cartao_usuario_id`,`cartao_bandeira_id`,`cartao_data_validade`) values 
(1,'teste',0,2,'0000-00-00'),
(2,'teste',0,2,'2022-11-18'),
(3,'teste',0,2,'2022-11-18'),
(4,'teste',0,2,'2022-11-18'),
(5,'tstfdsafdsaf',1,2,'2022-11-25'),
(6,'tstfdsafdsaf',1,2,'2022-11-25'),
(7,'teste',1,5,'2022-12-09'),
(8,'o brasil',1,7,'2022-11-08'),
(9,'fdasfdsafdsafdsa',1,2,'2022-12-01');

/*Table structure for table `midas_categorias` */

DROP TABLE IF EXISTS `midas_categorias`;

CREATE TABLE `midas_categorias` (
  `categoria_id` int(11) NOT NULL,
  `categoria_descricao` varchar(255) NOT NULL,
  `categoria_situacao` enum('A','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `midas_categorias` */

insert  into `midas_categorias`(`categoria_id`,`categoria_descricao`,`categoria_situacao`) values 
(1,'RECEBIMENTOS','A'),
(2,'DESPESA DE CASA','A'),
(3,'DESPESA COM LAZER','A'),
(4,'DESPESA EXTRA','A'),
(5,'INVESTIMENTO','A'),
(6,'ANTECIPAÇÃO DE LUCRO','A');

/*Table structure for table `midas_metas` */

DROP TABLE IF EXISTS `midas_metas`;

CREATE TABLE `midas_metas` (
  `meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_nome` varchar(100) NOT NULL,
  `meta_descricao` text DEFAULT NULL,
  `meta_data` date NOT NULL,
  `meta_valor` float NOT NULL,
  `meta_usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `midas_metas_FK` (`meta_usuario_id`),
  CONSTRAINT `midas_metas_FK` FOREIGN KEY (`meta_usuario_id`) REFERENCES `midas_usuarios` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `midas_metas` */

insert  into `midas_metas`(`meta_id`,`meta_nome`,`meta_descricao`,`meta_data`,`meta_valor`,`meta_usuario_id`) values 
(1,'Comprar um carro','Quero juntar dinheiro para comprar um carro','2022-11-27',4000,1),
(2,'Celular ','quero comprar um celular','2022-11-30',6000,1);

/*Table structure for table `midas_movimentacoes` */

DROP TABLE IF EXISTS `midas_movimentacoes`;

CREATE TABLE `midas_movimentacoes` (
  `movimentacao_id` int(11) NOT NULL AUTO_INCREMENT,
  `movimentacao_usuario_id` int(11) NOT NULL,
  `movimentacao_categoria_id` int(11) NOT NULL,
  `movimentacao_cartao_id` int(11) NOT NULL,
  `movimentacao_descricao` text NOT NULL,
  `movimentacao_data` date NOT NULL,
  `movimentacao_valor` float NOT NULL,
  PRIMARY KEY (`movimentacao_id`),
  KEY `movimentacao_usuario_id` (`movimentacao_usuario_id`),
  KEY `movimentacao_categoria_id` (`movimentacao_categoria_id`),
  KEY `movimentacao_cartao_id` (`movimentacao_cartao_id`),
  CONSTRAINT `midas_movimentacoes_ibfk_1` FOREIGN KEY (`movimentacao_usuario_id`) REFERENCES `midas_usuarios` (`usuario_id`),
  CONSTRAINT `midas_movimentacoes_ibfk_2` FOREIGN KEY (`movimentacao_categoria_id`) REFERENCES `midas_categorias` (`categoria_id`),
  CONSTRAINT `midas_movimentacoes_ibfk_3` FOREIGN KEY (`movimentacao_cartao_id`) REFERENCES `midas_cartoes` (`cartao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4;

/*Data for the table `midas_movimentacoes` */

insert  into `midas_movimentacoes`(`movimentacao_id`,`movimentacao_usuario_id`,`movimentacao_categoria_id`,`movimentacao_cartao_id`,`movimentacao_descricao`,`movimentacao_data`,`movimentacao_valor`) values 
(135,1,2,8,'tese','2022-12-01',1111.11),
(136,1,2,8,'tese','2022-12-01',1111.11),
(137,1,2,8,'tese','2022-12-01',1111.11),
(138,1,2,8,'tese','2022-11-27',1111.11),
(139,1,2,8,'tese','2022-12-01',-1111.11),
(140,1,2,8,'tese','2022-11-27',-1111.11),
(141,1,4,8,'a','2022-11-17',-220),
(142,1,4,8,'a','2022-11-17',-300),
(143,1,4,8,'a','2022-11-01',300),
(144,1,4,8,'a','2022-11-02',300),
(145,1,4,8,'a','2022-11-03',300),
(146,1,4,8,'a','2022-11-04',300),
(147,1,4,8,'a','2022-11-05',300),
(148,1,4,8,'a','2022-11-07',800),
(149,1,4,8,'a','2022-11-18',800),
(150,1,4,8,'a','2022-11-30',800),
(151,1,1,8,'f','2010-06-26',10);

/*Table structure for table `midas_usuarios` */

DROP TABLE IF EXISTS `midas_usuarios`;

CREATE TABLE `midas_usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_email` varchar(255) NOT NULL,
  `usuario_senha` text NOT NULL,
  `usuario_nome` varchar(255) NOT NULL,
  `usuario_cpf` char(14) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_email` (`usuario_email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `midas_usuarios` */

insert  into `midas_usuarios`(`usuario_id`,`usuario_email`,`usuario_senha`,`usuario_nome`,`usuario_cpf`) values 
(1,'admin@gmail.com','admin','Administrador','488.298.248-01'),
(6,'fdsafd','safdsafds','fdsafdsfdsa',NULL),
(7,'ad2min@gmail.com','admin','fdsafdsafdsafdsa',NULL),
(8,'fdsafdsafds@gmail.com','admin','etste',NULL),
(9,'fdsafdsafdsafdsa@gmail.com','adminf','dsafdsafds',NULL),
(10,'fdsafdsafdsafd@gmail.com','admisafdsafdsafdsan','testestestsetset',NULL),
(11,'fdsafdsafdsafds@gmail.com','adminfdsafdsaf','fsdafdsadsafdsafdsaf',NULL),
(12,'teste@gmail.com','adminfdsafdsaf','teste',NULL);

/*Table structure for table `teste` */

DROP TABLE IF EXISTS `teste`;

CREATE TABLE `teste` (
  `abcd` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`abcd`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `teste` */

insert  into `teste`(`abcd`) values 
(1),
(2),
(3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
