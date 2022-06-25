-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03-Jan-2021 às 18:58
-- Versão do servidor: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jornal_web`
--
CREATE DATABASE jornal_web;

use jornal_web;
-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `noticia` text NOT NULL,
  `data` date NOT NULL,
  `grupo` text NOT NULL,
  `likes` int(11) NOT NULL,
  `deslikes` int(11) NOT NULL,
  `reacoes` int(11) NOT NULL,
  `comentarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `noticia`, `data`, `grupo`, `likes`, `deslikes`, `reacoes`, `comentarios`) VALUES
(4, 'ConfusÃ£o na Sala', 'milique, ipsam ex sit saepe facilis odit ipsa! Ut maxime quidem dolor dolorum at a ipsum eligendi tempore molestias cupiditate harum explicabo nemo, dolore facilis! Sed quas rem numquam.\nUt cupiditate temporibus est ducimus repudiandae molestiae, similique deserunt voluptatibus pariatur accusantium quam illo iusto ab, reiciendis ex modi ea tempora maiores veniam dignissimos optio? Et voluptate saepe harum repellat!\nRepellendus vel odio temporibus quasi facilis nam, dolorem veniam aliquam, voluptatum, porro fuga nesciunt doloribus! Excepturi nobis accusamus cumque, et placeat dolorem eaque omnis dolor, dolorum ipsa porro, cupiditate expedita!\nError recusandae nam cumque, ducimus nobis repellat maxime quas, consequatur enim asperiores fugiat voluptas neque repudiandae molestiae,', '2020-12-25', 'A', 1, 2, 3, 0),
(5, 'Nova ordem para Professores', 'Non minima nihil quisquam aspernatur quae in aut pariatur, tempora adipisci tempore doloribus, nam dolores. Consectetur architecto ad sapiente numquam. Optio eos nulla, officia iusto dolorem iste nihil dolores praesentium.\nTenetur, quibusdam voluptatem soluta iusto blanditiis dolor explicabo neque vero minima itaque repellat id! Doloribus asperiores, velit voluptatem modi dignissimos culpa provident, accusantium dolorem similique eum ex laboriosam non. Recusandae.', '2020-12-25', 'P', 0, 1, 1, 0),
(6, 'Alunos suspensos atÃ© Fevereiro', 'Explicabo voluptatem cumque veniam ab ullam sint facilis, esse saepe perspiciatis reiciendis! Vitae nesciunt, unde animi veritatis voluptas eos perferendis! Assumenda nobis sapiente similique illum repellat aliquid perferendis doloribus dolor.\nVoluptates necessitatibus laboriosam vitae, officiis eius tempora accusamus consequuntur impedit harum voluptatum fugiat odio incidunt eligendi nobis maxime? Consequatur enim totam cupiditate aut facilis praesentium sed nihil consequuntur laudantium culpa?', '2020-12-25', 'T', 1, 1, 2, 2),
(8, 'Provas comeÃ§am em Fevereiro', 'Similique veniam, minima officiis libero, eos provident repellendus placeat uatur mollitia eaque ratione vero nam?', '2020-12-25', 'P', 1, 0, 1, 3),
(11, 'Noticia de teste', 'Esta eh uma noticia de teste, isso eh uma noticia de teste\nEsta eh uma noticia de teste, isso eh uma noticia de teste\nEsta eh uma noticia de teste, isso eh uma noticia de teste\nEsta eh uma noticia de teste, isso eh uma noticia de teste', '2020-12-25', 'T', 1, 1, 2, 1),
(12, 'Ola Mundo', 'Esta eh uma noticia de teste!\nTeste 2', '2020-12-27', 'A', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_comentarios`
--

CREATE TABLE `noticias_comentarios` (
  `id` int(11) NOT NULL,
  `id_noticia` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `comentario` text,
  `data_hora` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `noticias_comentarios`
--

INSERT INTO `noticias_comentarios` (`id`, `id_noticia`, `id_usuario`, `comentario`, `data_hora`) VALUES
(5, 8, 116, 'Ola Mundo!', '2020-12-26 17:48:39'),
(10, 11, 115, '!', '2020-12-27 12:01:27'),
(11, 8, 115, 'Ola mundo!', '2020-12-27 12:02:36'),
(12, 8, 0, 'ESte eh um comentario do ADM!', '2020-12-27 12:08:31'),
(15, 6, 115, 'testando\ntestando\no nl2br', '2020-12-27 14:14:09'),
(16, 6, 117, 'Ola mundo!', '2020-12-27 16:30:03'),
(17, 12, 117, 'Ola Mundo!', '2020-12-30 20:27:30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_guardadas`
--

CREATE TABLE `noticias_guardadas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_noticia` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `noticias_guardadas`
--

INSERT INTO `noticias_guardadas` (`id`, `id_usuario`, `id_noticia`, `data`) VALUES
(8, 116, 5, '2020-12-26'),
(21, 117, 4, '2021-01-03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia_reacoes`
--

CREATE TABLE `noticia_reacoes` (
  `id` int(11) NOT NULL,
  `id_noticia` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `noticia_reacoes`
--

INSERT INTO `noticia_reacoes` (`id`, `id_noticia`, `id_usuario`, `estado`) VALUES
(19, 8, 116, 1),
(20, 11, 116, 2),
(21, 6, 116, 1),
(22, 5, 116, 2),
(23, 4, 116, 2),
(24, 4, 115, 1),
(25, 11, 115, 1),
(26, 6, 115, 2),
(27, 4, 114, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `genero` text NOT NULL,
  `dataNasc` date NOT NULL,
  `email` text NOT NULL,
  `numId` int(9) NOT NULL,
  `senha` text NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `classe` text NOT NULL,
  `curso` text NOT NULL,
  `periodo` text NOT NULL,
  `disciplina` text NOT NULL,
  `foto` text NOT NULL,
  `permitido` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `genero`, `dataNasc`, `email`, `numId`, `senha`, `tipo`, `classe`, `curso`, `periodo`, `disciplina`, `foto`, `permitido`) VALUES
(114, 'Alicia Andrade', 'F', '2019-10-08', 'email@gmail.com', 111111111, '96e79218965eb72c92a549dd5a330112', 'A', '11Âª', 'Contabiblidade', 'Manha', '', 'foto114.jpg', 'sim'),
(115, 'Antonia Emanuel', 'F', '2019-06-05', 'antonia12@gmail.com', 912349848, 'e3ceb5881a0a1fdaad01296d7554868d', 'P', '', '', '', 'FAI', 'foto115.jpg', 'sim'),
(116, 'Felipe Gomes', 'M', '2020-12-15', 'felipe@gmail.com', 333333333, '96e79218965eb72c92a549dd5a330112', 'P', '', '', '', 'IAG', 'user.jpg', 'sim'),
(117, 'Adelina Tchapua', 'F', '2019-10-22', 'tchapua@gmail.com', 943848238, '96e79218965eb72c92a549dd5a330112', 'A', '12Âª', 'Informatica de Gestao', 'Tarde', '', 'foto117.jpg', 'sim');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticias_comentarios`
--
ALTER TABLE `noticias_comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticias_guardadas`
--
ALTER TABLE `noticias_guardadas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticia_reacoes`
--
ALTER TABLE `noticia_reacoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `noticias_comentarios`
--
ALTER TABLE `noticias_comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `noticias_guardadas`
--
ALTER TABLE `noticias_guardadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `noticia_reacoes`
--
ALTER TABLE `noticia_reacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
