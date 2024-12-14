-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Време на генериране: 14 дек 2024 в 16:35
-- Версия на сървъра: 10.4.32-MariaDB
-- Версия на PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данни: `job_platform`
--

-- --------------------------------------------------------

--
-- Структура на таблица `applications`
--

CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `cv_file` varchar(255) DEFAULT NULL,
  `motivation_letter` text DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `applications`
--

INSERT INTO `applications` (`application_id`, `user_id`, `job_id`, `phone_number`, `cv_file`, `motivation_letter`, `application_date`) VALUES
(1, 4, 1, '0889325251', 'uploads/cvs/Упражнение 1 - XAMPP.pdf', 'желая да бъда част от компанията', '2024-12-13 20:28:46'),
(2, 2, 1, '0889325251', 'uploads/cvs/L1.pdf', 'Бих желал да работя при Вас!', '2024-12-13 20:57:45'),
(3, 4, 5, '0889325251', 'uploads/cvs/Упражнение 2 - Основи на PHP.pdf', 'кандидатсвам ', '2024-12-14 13:42:43');

-- --------------------------------------------------------

--
-- Структура на таблица `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` enum('Frontend','Backend','Fullstack','Mobile') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `jobs`
--

INSERT INTO `jobs` (`job_id`, `title`, `description`, `salary`, `location`, `company`, `created_at`, `category`) VALUES
(1, 'iOS Developer', 'What You’ll Do\r\n\r\nBuild reusable mobile components used by applications teams.\r\nCollaborate across multiple product teams locally and in remote locations.\r\nContribute to and drive all aspects of the development lifecycle, including requirements verification, solution building and alignments with stakeholders, architectural design, implementation, testing to meet quality criteria, and processes to deliver the best solutions to our customers.\r\nExecute with an enterprise cloud mindset to deliver on security, compliance, and infrastructure initiatives with engineering program management.\r\nResponsibility for ensuring high-quality results. Create and execute test cases, reviews of specifications, design reviews, and code reviews.', 1500.00, 'София', 'SAP', '2024-12-13 20:43:40', 'Mobile'),
(2, 'Android Developer', 'What you’ll do:\r\n\r\nDeveloping and enhancing core mobile frameworks for SAP Business Technology Platform (BTP), with a focus on UI and security.\r\nImplementing and optimizing security features for mobile applications, ensuring high protection and performance.\r\nCollaborating with cross-functional teams to design and build mobile solutions that support both SAP application teams and customers.\r\nContributing to creating a secure, user-friendly platform that meets the business-critical needs of SAP.\r\nPlaying a pivotal role in shaping the mobile security landscape within SAP.', 1500.00, 'София', 'SAP', '2024-12-13 21:03:45', 'Mobile'),
(3, 'Senior Full-Stack Developer with WordPress', 'About the Role\r\nWe’re looking for an talented Senior Full-Stack Developer with WordPress expertise to join our growing team at Harbinger Marketing, play a key role in our team and contribute to its continuous growth.\r\n\r\nThis position offers exciting opportunities to work on challenging international projects, actively participate in process development, improve toolsets, mentor junior team members, conduct code reviews, and take part in other vital activities that shape the team’s success.\r\n\r\nAs a Senior Developer at Harbinger Marketing, you’ll be more than just a technical expert. You’ll be a problem solver, a consultant, and a constant learner. You’ll play a crucial role in projects, converting stunning web designs into functional, top-notch websites in line with project specifications and our standards. Maintenance and assistance with ongoing work on the websites we build will also be key tasks, ensuring our customers’ sites remain secure and up-to-date.\r\n\r\nYour role will encompass a wide range of skills and responsibilities, all aimed at delivering the best digital experience for our clients. You’ll need to approach problems and tasks with a systematic, logical mindset, continually improving your coding skills to create high-quality and efficient websites. Excellent communication will be essential, effectively sharing information, ideas, and progress with team members, and fostering an environment of teamwork.', 6000.00, 'Варна', 'Harbinger Marketing', '2024-12-13 21:08:28', 'Fullstack'),
(4, '(Senior) Full Stack Engineer (TypeScript/Python) (m/w/d)', 'Your profile\r\n\r\nFull Stack Experience: You have several years of experience writing production backend code in Python and frontend code in TypeScript. You have experience working with frameworks in the frontend (e.g. React or Vue) and backend (FastAPI, Flask or Django) but are not dependent on them. We mostly use Python 3.11 with type hints, and pre-commit hooks to ensure consistency.\r\nClean Code: You write clean, well-documented and easy to understand code but know when to be pragmatic to ship features efficiently.\r\nTooling: You’re skilled with Docker and proficient in working with git and CI/CD pipelines. Ideally you know your way around Linux systems, ensuring reliable development and deployment.\r\nOwnership & Monitoring: You embrace a “you build it you run it” attitude and make sure the systems that you develop are properly monitored (Prometheus and Grafana are no strangers to you).\r\nFast Paced Development: You thrive in a fast-paced environment, turning high-level requirements into actionable tasks, and you actively collaborate with colleagues across departments', 6700.00, 'София', 'Yoummday Bulgaria', '2024-12-13 21:11:25', 'Fullstack'),
(5, 'Frontend Developer (Angular)', '✅  Responsibilities:\r\n\r\n✔️ Develop a complex iGaming platform using Angular 15 and Typescript;\r\n\r\n✔️ Write high-quality, scalable, testable, and high-performant code;\r\n\r\n✔️ Participate in software system testing and validation procedures, programming, and documentation;\r\n\r\n✔️ Potentially lead assigned projects, including assigning tasks, coordinating efforts, and monitoring performance;\r\n\r\n✔️ Provide technical advice and assist in solving programming problems;\r\n\r\n✔️ Perform code reviews and provide feedback to ensure code quality.', 2000.00, 'София', 'Sofia Stars', '2024-12-13 21:14:24', 'Frontend'),
(6, 'HTML/CSS Developer', '✅Qualifications:\r\n\r\n✔️Previous experience in a similar positions;\r\n\r\n✔️Great knowledge of HTML, CSS;\r\n\r\n✔️Understanding of UI/UX design and cross-browser layout;\r\n\r\n✔️Good knowledge in CSS/JS animation;\r\n\r\n✔️Experience working with CSS Pre-Processors: Sass/Less;\r\n\r\n✔️Understanding of web application performance optimization;\r\n\r\n✔️Experience with Figma/Sketch/Photoshop;\r\n\r\n✔️At least Intermediate level of English.', NULL, 'София', 'Sofia Stars', '2024-12-13 21:15:26', 'Frontend'),
(7, 'Backend Engineer (PHP)', 'Some of the core duties include:\r\n\r\nDefining, interpreting and developing software to written requirements and technical specifications\r\nSuggesting improvements to existing products and implementing them across our platform.\r\nTroubleshooting, testing and maintaining the core product and databases to ensure it is functional and scalable\r\nAssist QA to define acceptance tests and perform troubleshooting\r\nSupport the creation and maintenance of technical documentation\r\nWrite clean, well-designed code, following coding standards and best practices\r\nWorking with globally distributed and multi-disciplinary teams\r\nParticipate in mentoring and knowledge sharing activities', 5000.00, 'Remote', 'Reward Gateway', '2024-12-13 21:17:58', 'Backend'),
(8, 'Backend Developer with PHP', 'Your Contribution:\r\n\r\nUnderstand business requirements and feature specifications and translate them into elegant, high-quality code that delivers the required features\r\nMaintain the high quality of your own contributions\r\nParticipate in code reviews and knowledge-sharing sessions\r\nMaintain a clean and understandable code base\r\nContinuously improve the code quality of our product', 5900.00, 'София/ Hybrid', 'AMPECO', '2024-12-13 21:19:21', 'Backend'),
(9, 'Senior Java Developer', 'Role and responsibilities:\r\n\r\n• Take ownership and apply in-depth knowledge and expertise in any step of the software development lifecycle, from design through maintenance.\r\n\r\n• Deliver high quality and well-structured code, while working and collaborating in a team environment.\r\n\r\n• Extend testing capabilities by writing unit tests and assisting in basic QA testing during new feature development.\r\n\r\n• Assist with the technical design, planning and estimation of the documentation provided by product and design team members.\r\n\r\n• Help to identify gaps in the design, as well as assess risks in the planning and execution.\r\n\r\n• Cooperate and assist the QA teams to ensure faults and other problems are identified and fixed quickly.\r\n\r\n• Perform code reviews and assist with onboarding of new team members.\r\n\r\n• Set-up best practices, process improvements as well as related documentation.\r\n\r\n• Stay up-to date with the latest technology trends.', 3000.00, 'София', 'GeoWealth Development', '2024-12-13 22:17:30', 'Frontend');

-- --------------------------------------------------------

--
-- Структура на таблица `job_ads`
--

CREATE TABLE `job_ads` (
  `job_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` enum('Front End','Back End','Full Stack','Mobile Dev') NOT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `role` enum('employer','candidate') NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_role` enum('employer','candidate') NOT NULL DEFAULT 'candidate',
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `full_name`, `phone_number`, `role`, `registration_date`, `user_role`, `name`, `phone`) VALUES
(1, 'petar', '$2y$10$dLj9eO8fQQP1oK5csLhSmOfWyHqbXj2XDIaudiQtHpBIFHg3pHFCq', 'petar@gmail.com', '', NULL, 'employer', '2024-12-13 15:59:05', 'employer', '', NULL),
(2, 'buket', '$2y$10$JF4Tepb4jlpYa9zDIIPaOuGzAZJ8VGMNh4Q3IqJyLv0RI1NO0JYni', 'buket@abv.bg', '', NULL, 'employer', '2024-12-13 16:08:58', 'candidate', '', NULL),
(3, 'ivan', '$2y$10$lvCE8I4JemXBHkkCpJ5RhufKYMxoQr9vGNUEaskSmPrpgBANe59j.', 'ivan@gmail.com', '', NULL, 'employer', '2024-12-13 20:34:27', 'candidate', '', NULL),
(4, 'vanesa', '$2y$10$Sbnd6xoetcdOOybfG3E0XedToMmJ2rwuYUvAjnjzPbYBFfL5p6/.2', 'vanesa@abv.bg', '', NULL, 'candidate', '2024-12-13 20:40:30', 'candidate', '', NULL),
(5, 'petko', '$2y$10$TgNu0M1KwblZkwOR9ZZt0.1xcePx/xM/a004faJXNqgL7L6mt7N9W', 'petko@abv.bg', '', NULL, 'candidate', '2024-12-14 14:57:53', 'candidate', '', NULL),
(6, 'nelina', '$2y$10$DRP25TLUQaRcE7EjoSGgSOviRI.7kJVTnT7hGmwr89RU6XGYXPZuC', 'nelina@abv.bg', '', NULL, 'candidate', '2024-12-14 14:59:13', 'candidate', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Индекси за таблица `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Индекси за таблица `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Индекси за таблица `job_ads`
--
ALTER TABLE `job_ads`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Индекси за таблица `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `job_ads`
--
ALTER TABLE `job_ads`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`);

--
-- Ограничения за таблица `job_ads`
--
ALTER TABLE `job_ads`
  ADD CONSTRAINT `job_ads_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
