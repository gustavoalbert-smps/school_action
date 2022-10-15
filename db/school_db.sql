-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10-Out-2022 às 16:34
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `school_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `gradebooks`
--

CREATE TABLE `gradebooks` (
  `id` int(11) NOT NULL,
  `note1` double DEFAULT NULL,
  `note2` double DEFAULT NULL,
  `note3` double DEFAULT NULL,
  `note4` double DEFAULT NULL,
  `note5` double DEFAULT NULL,
  `note6` double DEFAULT NULL,
  `note7` double DEFAULT NULL,
  `note8` double DEFAULT NULL,
  `situation` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `matter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `matters`
--

CREATE TABLE `matters` (
  `id` int(11) NOT NULL,
  `matter` text NOT NULL,
  `workload` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `matters`
--

INSERT INTO `matters` (`id`, `matter`, `workload`, `class_id`, `teacher_id`) VALUES
(1, 'matemática', 80, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `birth_date` text NOT NULL,
  `gender` text NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `people`
--

INSERT INTO `people` (`id`, `name`, `birth_date`, `gender`, `admin`) VALUES
(1, 'admin', '2001/01/01', 'outros', 1),
(2, 'Patota', '2001/01/01', 'f', 0),
(3, 'Gustavo Albert', '2000-09-23', 'masculino', 0),
(4, 'Girafales Silva', '1985-06-12', 'masculino', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `school_classes`
--

CREATE TABLE `school_classes` (
  `id` int(11) NOT NULL,
  `year` text NOT NULL,
  `identifier` text NOT NULL,
  `shift` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `school_classes`
--

INSERT INTO `school_classes` (`id`, `year`, `identifier`, `shift`) VALUES
(1, '7', 'A', 'manha');

-- --------------------------------------------------------

--
-- Estrutura da tabela `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `students`
--

INSERT INTO `students` (`id`, `people_id`, `class_id`) VALUES
(1, 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `teachers`
--

INSERT INTO `teachers` (`id`, `people_id`) VALUES
(1, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` text NOT NULL,
  `password` text NOT NULL,
  `teacher` int(11) NOT NULL,
  `people_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `teacher`, `people_id`) VALUES
(3, 'admin', 'admin', 1, 1),
(4, 'gustavo', '123456', 0, 3),
(5, 'girafales', '123456', 1, 4);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `gradebooks`
--
ALTER TABLE `gradebooks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `matter_id` (`matter_id`);

--
-- Índices para tabela `matters`
--
ALTER TABLE `matters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Índices para tabela `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `school_classes`
--
ALTER TABLE `school_classes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `people_id` (`people_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Índices para tabela `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `people_id` (`people_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `people_id` (`people_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `gradebooks`
--
ALTER TABLE `gradebooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `matters`
--
ALTER TABLE `matters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `school_classes`
--
ALTER TABLE `school_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `gradebooks`
--
ALTER TABLE `gradebooks`
  ADD CONSTRAINT `gradebooks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `gradebooks_ibfk_2` FOREIGN KEY (`matter_id`) REFERENCES `matters` (`id`);

--
-- Limitadores para a tabela `matters`
--
ALTER TABLE `matters`
  ADD CONSTRAINT `matters_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Limitadores para a tabela `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`);

--
-- Limitadores para a tabela `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
