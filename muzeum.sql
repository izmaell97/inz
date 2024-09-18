-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 14, 2024 at 01:52 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `muzeum`
--

-- --------------------------------------------------------



CREATE TABLE `archives` (
  `ID_ARCHIVES` int(11) NOT NULL,
  `LNG1` longtext NOT NULL,
  `LNG2` longtext NOT NULL,
  `LNG3` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `descryption`
--

CREATE TABLE `descryption` (
  `ID_DESC` int(11) NOT NULL,
  `LNG1` longtext DEFAULT NULL,
  `LNG2` longtext DEFAULT NULL,
  `LNG3` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------



--
-- Struktura tabeli dla tabeli `object`
--

CREATE TABLE `object` (
  `ID_OBJECT` int(11) NOT NULL,
  `TITLE` varchar(40) NOT NULL,
  `NOTE` text NOT NULL,
  `ID_PROJECT` int(11) DEFAULT NULL,
  `ID_PIC` int(11) DEFAULT NULL,
  `DESC_ID` int(11) DEFAULT NULL,
  `numberShown` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `picture`
--

CREATE TABLE `picture` (
  `ID_PICTURE` int(11) NOT NULL,
  `LINK` varchar(80) DEFAULT NULL,
  `NOTE` varchar(200) DEFAULT NULL,
  `ALT` varchar(200) DEFAULT NULL,
  `Owner` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projects`
--

CREATE TABLE `projects` (
  `ID_PROJECTS` int(11) NOT NULL,
  `EX_NAME` varchar(45) DEFAULT NULL,
  `CURRENT` tinyint(4) DEFAULT NULL,
  `NOTES` text DEFAULT NULL,
  `CREATION_DATE` date DEFAULT NULL,
  `STATS` int(11) DEFAULT NULL,
  `ID_PIC` int(11) DEFAULT NULL,
  `DESC_ID` int(11) DEFAULT NULL,
  `susp_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rooms`
--

CREATE TABLE `rooms` (
  `ID_ROOMS` int(11) NOT NULL,
  `TITLE` varchar(40) NOT NULL,
  `ID_PROJECT` int(11) DEFAULT NULL,
  `ID_PIC` int(11) DEFAULT NULL,
  `DESC_ID` int(11) DEFAULT NULL,
  `numberShown` int(11) NOT NULL,
  `NOTE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tokens`
--

CREATE TABLE `tokens` (
  `TokenID` int(11) NOT NULL,
  `Token` text NOT NULL,
  `DATE_OF_CREATION` date NOT NULL DEFAULT current_timestamp(),
  `User` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `to_archiv`
-- (See below for the actual view)
--
CREATE TABLE `to_archiv` (
`DESC_ID` int(11)
,`LNG1` longtext
,`LNG2` longtext
,`LNG3` longtext
);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `to_archiv_v2`
-- (See below for the actual view)
--
CREATE TABLE `to_archiv_v2` (
`DESC_ID` int(11)
,`LNG1` longtext
,`LNG2` longtext
,`LNG3` longtext
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `workers`
--

CREATE TABLE `workers` (
  `ID_WORKERS` int(11) NOT NULL,
  `NAM` varchar(45) DEFAULT NULL,
  `SURNAME` varchar(45) DEFAULT NULL,
  `userNam` varchar(45) DEFAULT NULL,
  `PASSWORD_HASH` varchar(100) DEFAULT NULL,
  `ISACTIVE` tinyint(4) DEFAULT NULL,
  `SUSPDATE` date DEFAULT NULL,
  `Privlage` int(11) NOT NULL DEFAULT 0,
  `num_of_wrong_login` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `workers`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `work_proj`
--

CREATE TABLE `work_proj` (
  `ID_WORK` int(11) NOT NULL,
  `ID_PROJ` int(11) NOT NULL,
  `STANOWISKO` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------


-- --------------------------------------------------------

--

--------------------------------------------------------


--
-- Struktura widoku `to_archiv`
--
DROP TABLE IF EXISTS `to_archiv`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `to_archiv`  AS SELECT DISTINCT `subquery`.`DESC_ID` AS `DESC_ID`, `descryption`.`LNG1` AS `LNG1`, `descryption`.`LNG2` AS `LNG2`, `descryption`.`LNG3` AS `LNG3` FROM ((select `object`.`DESC_ID` AS `DESC_ID` from `object` where `object`.`ID_PROJECT` in (select `projects`.`ID_PROJECTS` from `projects` where `projects`.`CURRENT` = 0 and to_days(current_timestamp()) - to_days(`projects`.`susp_date`) >= 30) union select `rooms`.`DESC_ID` AS `DESC_ID` from `rooms` where `rooms`.`ID_PROJECT` in (select `projects`.`ID_PROJECTS` from `projects` where `projects`.`CURRENT` = 0 and to_days(current_timestamp()) - to_days(`projects`.`susp_date`) >= 30)) `subquery` left join `descryption` on(`subquery`.`DESC_ID` = `descryption`.`ID_DESC`)) ;

-- --------------------------------------------------------

--
-- Struktura widoku `to_archiv_v2`
--
DROP TABLE IF EXISTS `to_archiv_v2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `to_archiv_v2`  AS   (select distinct `temp`.`DESC_ID` AS `DESC_ID`,`descryption`.`LNG1` AS `LNG1`,`descryption`.`LNG2` AS `LNG2`,`descryption`.`LNG3` AS `LNG3` from ((select `projects`.`DESC_ID` AS `DESC_ID` from `projects` where `projects`.`CURRENT` = 0 and to_days(current_timestamp()) - to_days(`projects`.`susp_date`) >= 30) `temp` left join `descryption` on(`temp`.`DESC_ID` = `descryption`.`ID_DESC`)))  ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`ID_ARCHIVES`);

--
-- Indeksy dla tabeli `descryption`
--
ALTER TABLE `descryption`
  ADD PRIMARY KEY (`ID_DESC`);


--
-- Indeksy dla tabeli `object`
--
ALTER TABLE `object`
  ADD PRIMARY KEY (`ID_OBJECT`),
  ADD KEY `OBJ_PROJ_idx` (`ID_PROJECT`),
  ADD KEY `OBJ_PIC_idx` (`ID_PIC`),
  ADD KEY `DESC_OBJ_idx` (`DESC_ID`);

--
-- Indeksy dla tabeli `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`ID_PICTURE`),
  ADD UNIQUE KEY `idPICTURE_UNIQUE` (`ID_PICTURE`);

--
-- Indeksy dla tabeli `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`ID_PROJECTS`),
  ADD UNIQUE KEY `idProjekty_UNIQUE` (`ID_PROJECTS`),
  ADD KEY `PROJ_PIC_idx` (`ID_PIC`),
  ADD KEY `PROJ_DESC_idx` (`DESC_ID`);

--
-- Indeksy dla tabeli `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`ID_ROOMS`),
  ADD KEY `fk_SALE_Projekty1_idx` (`ID_PROJECT`),
  ADD KEY `ROOMS_PIC_idx` (`ID_PIC`),
  ADD KEY `ROOMS_idx` (`DESC_ID`);

--
-- Indeksy dla tabeli `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`TokenID`),
  ADD KEY `USER_TOKEN` (`User`) USING BTREE;

--
-- Indeksy dla tabeli `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`ID_WORKERS`),
  ADD UNIQUE KEY `idPracownicy_UNIQUE` (`ID_WORKERS`),
  ADD UNIQUE KEY `userNam_UNIQUE` (`userNam`),
  ADD UNIQUE KEY `paswordhash_UNIQUE` (`PASSWORD_HASH`);

--
-- Indeksy dla tabeli `work_proj`
--
ALTER TABLE `work_proj`
  ADD PRIMARY KEY (`ID_WORK`,`ID_PROJ`),
  ADD KEY `fk_PRAC_PROJ_Pracownicy_idx` (`ID_WORK`),
  ADD KEY `fk_PRAC_PROJ_Projekty1_idx` (`ID_PROJ`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archives`
--
ALTER TABLE `archives`
  MODIFY `ID_ARCHIVES` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `descryption`
--
ALTER TABLE `descryption`
  MODIFY `ID_DESC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `object`
--
ALTER TABLE `object`
  MODIFY `ID_OBJECT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `ID_PICTURE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ID_PROJECTS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `TokenID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `ID_WORKERS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `object`
--
ALTER TABLE `object`
  ADD CONSTRAINT `OBJ_PIC` FOREIGN KEY (`ID_PIC`) REFERENCES `picture` (`ID_PICTURE`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `OBJ_PROJ` FOREIGN KEY (`ID_PROJECT`) REFERENCES `projects` (`ID_PROJECTS`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `desc_obj` FOREIGN KEY (`DESC_ID`) REFERENCES `descryption` (`ID_DESC`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `PROJ_PIC` FOREIGN KEY (`ID_PIC`) REFERENCES `picture` (`ID_PICTURE`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `proj_desc` FOREIGN KEY (`DESC_ID`) REFERENCES `descryption` (`ID_DESC`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `ROOMS_PIC` FOREIGN KEY (`ID_PIC`) REFERENCES `picture` (`ID_PICTURE`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `desc_rooms` FOREIGN KEY (`DESC_ID`) REFERENCES `descryption` (`ID_DESC`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_SALE_Projekty1` FOREIGN KEY (`ID_PROJECT`) REFERENCES `projects` (`ID_PROJECTS`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `USER_TOKEN` FOREIGN KEY (`User`) REFERENCES `workers` (`ID_WORKERS`);

--
-- Constraints for table `work_proj`
--
ALTER TABLE `work_proj`
  ADD CONSTRAINT `fk_PRAC_PROJ_Pracownicy` FOREIGN KEY (`ID_WORK`) REFERENCES `workers` (`ID_WORKERS`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_PRAC_PROJ_Projekty1` FOREIGN KEY (`ID_PROJ`) REFERENCES `projects` (`ID_PROJECTS`) ON DELETE CASCADE ON UPDATE NO ACTION;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `drop_users` ON SCHEDULE EVERY 1 WEEK STARTS '2024-04-26 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM workers WHERE workers.ISACTIVE=false AND DATEDIFF(CURDATE(), workers.SUSPDATE) = 30$$

CREATE DEFINER=`root`@`localhost` EVENT `delete_old_projects` ON SCHEDULE EVERY 1 WEEK STARTS '2024-05-15 17:51:18' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN

    INSERT INTO archives (LNG1, LNG2, LNG3)
    SELECT LNG1, LNG2, LNG3 FROM to_archiv;    
    INSERT INTO archives (LNG1, LNG2, LNG3)
    SELECT LNG1, LNG2, LNG3 FROM to_archiv_v2;
    DELETE FROM descryption WHERE ID_DESC IN (SELECT DESC_ID FROM to_archiv);
    DELETE FROM descryption WHERE ID_DESC IN (SELECT DESC_ID FROM to_archiv_v2);
END$$

CREATE DEFINER=`root`@`localhost` EVENT `log_out` ON SCHEDULE EVERY 1 DAY STARTS '2024-06-12 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM tokens$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
