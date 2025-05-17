-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: esboco_hamburgueria
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bairro`
--

DROP TABLE IF EXISTS `bairro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bairro` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `frete` decimal(10,2) NOT NULL,
  `cidade_id` tinyint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`),
  KEY `fk_bairro_cidade1_idx` (`cidade_id`),
  CONSTRAINT `fk_bairro_cidade1` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bairro`
--

LOCK TABLES `bairro` WRITE;
/*!40000 ALTER TABLE `bairro` DISABLE KEYS */;
INSERT INTO `bairro` VALUES (1,'Vila Washington Beleza',2.00,1),(2,'CDHU',4.00,1),(3,'Centro',2.00,1),(4,'Distrito Industrial II',4.00,1),(5,'Itagaçaba',2.00,1),(6,'Jardim América',2.00,1),(7,'Jardim Europa',2.00,1),(8,'Jardim Imperial',3.00,1),(9,'Jardim Paraíso',2.00,1),(10,'Jardim Primavera',2.00,1),(11,'Jardim São José',2.00,1),(12,'Lagoa Dourada I',2.00,1),(13,'Lagoa Dourada II',2.00,1),(14,'Lavrinhas - Jardim Mavisou',7.00,2),(15,'Lavrinhas - Vila Campestre',5.00,2),(16,'Lavrinhas Centro',7.00,2),(17,'Loteamento Bela Vista',3.00,1),(18,'Metalúrgicos',3.00,1),(19,'Parque Dona Arminda Candida de Jesus',2.00,1),(20,'Parque Pimavera',2.00,1),(21,'Reserva do Vale',2.00,1),(22,'Residencial Metalúrgico',3.00,1),(23,'Residencial Santa Cecília',3.00,1),(24,'Retiro Da Mantiqueira',2.00,1),(25,'Retiro Da Mantiqueira I',2.00,1),(26,'Retiro Da Mantiqueira II',2.00,1),(27,'Vila Abgail',2.00,1),(28,'Vila Ana Rosa Novais',2.00,1),(29,'Vila Batista Parte Alta',2.00,1),(30,'Vila Batista Parte Baixa',2.00,1),(31,'Vila Bionde',2.00,1),(32,'Vila Brasil',2.00,1),(33,'Vila Canevari',2.00,1),(34,'Vila Celestina',2.00,1),(35,'Vila Esmeralda',2.00,1),(36,'Vila Expedicionários Cruzeirenses',2.00,1),(37,'Vila Grispim',2.00,1),(38,'Vila Juvenal',3.00,1),(39,'Vila Loyelo',2.00,1),(40,'Vila Maria',3.00,1),(41,'Vila Paulista',2.00,1),(42,'Vila Paulo Romeu',2.00,1),(43,'Vila Pontilhão',2.00,1),(44,'Vila Regina Célia',2.00,1),(45,'Vila Rica',2.00,1),(46,'Vila Romana',2.00,1),(47,'Vila Sueli',2.00,1),(48,'Vila Virgílio Antunes de Oliveira',2.00,1);
/*!40000 ALTER TABLE `bairro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cidade`
--

DROP TABLE IF EXISTS `cidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cidade` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cidade`
--

LOCK TABLES `cidade` WRITE;
/*!40000 ALTER TABLE `cidade` DISABLE KEYS */;
INSERT INTO `cidade` VALUES (1,'Cruzeiro'),(2,'Lavrinhas'),(3,'Pinheiros');
/*!40000 ALTER TABLE `cidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco`
--

DROP TABLE IF EXISTS `endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `rua` varchar(60) NOT NULL,
  `numero` varchar(7) NOT NULL,
  `complemento` varchar(80) DEFAULT NULL,
  `cep` varchar(10) NOT NULL,
  `bairro_id` tinyint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_endereco_bairro1_idx` (`bairro_id`),
  CONSTRAINT `fk_endereco_bairro1` FOREIGN KEY (`bairro_id`) REFERENCES `bairro` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco`
--

LOCK TABLES `endereco` WRITE;
/*!40000 ALTER TABLE `endereco` DISABLE KEYS */;
/*!40000 ALTER TABLE `endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_pagamento`
--

DROP TABLE IF EXISTS `forma_pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forma_pagamento` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_pagamento`
--

LOCK TABLES `forma_pagamento` WRITE;
/*!40000 ALTER TABLE `forma_pagamento` DISABLE KEYS */;
INSERT INTO `forma_pagamento` VALUES (3,'Cartão de Crédito'),(4,'Cartão de Débito'),(1,'Dinheiro'),(2,'PIX');
/*!40000 ALTER TABLE `forma_pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `data_pedido` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nome` varchar(60) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `endereco_id` int unsigned NOT NULL,
  `forma_pagamento_id` int unsigned NOT NULL,
  `status` enum('nao_iniciado','em_preparo','finalizado','entregue') NOT NULL DEFAULT 'nao_iniciado',
  `observacao_pagamento` varchar(150) DEFAULT NULL,
  `observacao_produto` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_pedidos_endereco1_idx` (`endereco_id`),
  KEY `fk_pedidos_forma_pagamento1_idx` (`forma_pagamento_id`),
  CONSTRAINT `fk_pedidos_endereco1` FOREIGN KEY (`endereco_id`) REFERENCES `endereco` (`id`),
  CONSTRAINT `fk_pedidos_forma_pagamento1` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `forma_pagamento` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos_has_produtos`
--

DROP TABLE IF EXISTS `pedidos_has_produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos_has_produtos` (
  `pedidos_id` int unsigned NOT NULL,
  `produtos_id` int unsigned NOT NULL,
  `quantidade` smallint NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`pedidos_id`,`produtos_id`),
  KEY `fk_pedidos_has_produtos_produtos1_idx` (`produtos_id`),
  KEY `fk_pedidos_has_produtos_pedidos1_idx` (`pedidos_id`),
  CONSTRAINT `fk_pedidos_has_produtos_pedidos1` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`),
  CONSTRAINT `fk_pedidos_has_produtos_produtos1` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_has_produtos`
--

LOCK TABLES `pedidos_has_produtos` WRITE;
/*!40000 ALTER TABLE `pedidos_has_produtos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos_has_produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissoes`
--

DROP TABLE IF EXISTS `permissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissoes` (
  `id` tinyint unsigned NOT NULL,
  `tipo` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `tipo_UNIQUE` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissoes`
--

LOCK TABLES `permissoes` WRITE;
/*!40000 ALTER TABLE `permissoes` DISABLE KEYS */;
INSERT INTO `permissoes` VALUES (1,'admin'),(2,'comum');
/*!40000 ALTER TABLE `permissoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  `tipo_produto_id` int unsigned NOT NULL,
  `disponibilidade` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_produtos_tipo_produto_idx` (`tipo_produto_id`),
  CONSTRAINT `fk_produtos_tipo_produto` FOREIGN KEY (`tipo_produto_id`) REFERENCES `tipo_produto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (3,'sal',8.00,'8','uploads/',1,1);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_produto`
--

DROP TABLE IF EXISTS `tipo_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_produto` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_produto`
--

LOCK TABLES `tipo_produto` WRITE;
/*!40000 ALTER TABLE `tipo_produto` DISABLE KEYS */;
INSERT INTO `tipo_produto` VALUES (1,'Bebidas'),(2,'Lanches');
/*!40000 ALTER TABLE `tipo_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `permissoes_id` tinyint unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_usuarios_permissoes1_idx` (`permissoes_id`),
  CONSTRAINT `fk_usuarios_permissoes1` FOREIGN KEY (`permissoes_id`) REFERENCES `permissoes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (2,'Lucas Meirelles','$2y$10$rCtcxeC7xWX2zaxr6d3mdeDV1583qKUq3mEpzWoDW4v/MD4mXmGE6','lucas@gmail.com',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-17 19:15:31
