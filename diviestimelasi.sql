-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ago 23, 2022 alle 10:03
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diviestimelasi`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `autore`
--

CREATE TABLE `autore` (
  `IDutente` int(11) NOT NULL,
  `IDblog` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `autore`
--

INSERT INTO `autore` (`IDutente`, `IDblog`) VALUES
(65, 197),
(65, 198),
(65, 199),
(65, 200),
(65, 216),
(66, 201),
(66, 202),
(67, 203),
(67, 204),
(68, 205),
(68, 206),
(68, 207),
(69, 208),
(69, 209),
(70, 210),
(70, 211),
(71, 212),
(71, 213),
(71, 217),
(73, 214),
(73, 215);

-- --------------------------------------------------------

--
-- Struttura della tabella `blog`
--

CREATE TABLE `blog` (
  `IDblog` int(11) NOT NULL,
  `titolo` varchar(63) NOT NULL,
  `limiteEta` tinyint(1) NOT NULL DEFAULT 0,
  `data` date NOT NULL,
  `numPost` int(4) NOT NULL DEFAULT 0,
  `numIscritti` int(5) NOT NULL DEFAULT 0,
  `presentazione` text NOT NULL,
  `immagine` varchar(63) NOT NULL,
  `archiviato` tinyint(1) NOT NULL,
  `IDstile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `blog`
--

INSERT INTO `blog` (`IDblog`, `titolo`, `limiteEta`, `data`, `numPost`, `numIscritti`, `presentazione`, `immagine`, `archiviato`, `IDstile`) VALUES
(197, 'Divina Commedia', 0, '2022-07-29', 7, 7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '197.jpg', 0, 2),
(198, 'Vita Nova', 0, '2022-07-29', 2, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '198.jpg', 0, 2),
(199, 'Convivio', 0, '2022-07-29', 2, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '199.png', 1, 2),
(200, 'De vulgari eloquentia', 0, '2022-07-29', 1, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '200.jpg', 1, 2),
(201, 'Decameron', 0, '2022-07-29', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '201.jpg', 0, 3),
(202, 'Trattatello in Laude di Dante', 0, '2022-07-29', 3, 1, 'Blog sulla prima biografia su Dante.', '202.jpg', 0, 1),
(203, 'Canzoniere', 0, '2022-07-29', 2, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '203.jpg', 0, 2),
(204, 'De viris illustribus', 1, '2022-07-29', 2, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '204.jpg', 0, 1),
(205, 'Orlando furioso', 1, '2022-07-29', 0, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et libero iaculis, ornare nunc vitae, sollicitudin orci. Fusce lorem enim, placerat sed interdum a, maximus a sem. Fusce faucibus felis leo, sed eleifend ex dapibus ut. Vestibulum vulputate, dolor eget hendrerit dapibus, lorem ante sodales turpis, sit amet ornare eros purus sit amet velit. Aliquam dapibus in ligula at consequat.', '205.jpg', 0, 3),
(206, 'Il negromante', 0, '2022-07-29', 0, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et libero iaculis, ornare nunc vitae, sollicitudin orci. Fusce lorem enim, placerat sed interdum a, maximus a sem. Fusce faucibus felis leo, sed eleifend ex dapibus ut. Vestibulum vulputate, dolor eget hendrerit dapibus, lorem ante sodales turpis, sit amet ornare eros purus sit amet velit. Aliquam dapibus in ligula at consequat.', '206.jpg', 1, 2),
(207, 'Satire', 0, '2022-07-29', 0, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et libero iaculis, ornare nunc vitae, sollicitudin orci. Fusce lorem enim, placerat sed interdum a, maximus a sem. Fusce faucibus felis leo, sed eleifend ex dapibus ut. Vestibulum vulputate, dolor eget hendrerit dapibus, lorem ante sodales turpis, sit amet ornare eros purus sit amet velit. Aliquam dapibus in ligula at consequat.', '207.jpg', 0, 1),
(208, 'Canti', 0, '2022-07-29', 5, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et libero iaculis, ornare nunc vitae, sollicitudin orci. Fusce lorem enim, placerat sed interdum a, maximus a sem. Fusce faucibus felis leo, sed eleifend ex dapibus ut. Vestibulum vulputate, dolor eget hendrerit dapibus, lorem ante sodales turpis, sit amet ornare eros purus sit amet velit. Aliquam dapibus in ligula at consequat.', '208.jpg', 0, 2),
(209, 'Operette morali', 0, '2022-07-29', 1, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et libero iaculis, ornare nunc vitae, sollicitudin orci. Fusce lorem enim, placerat sed interdum a, maximus a sem. Fusce faucibus felis leo, sed eleifend ex dapibus ut. Vestibulum vulputate, dolor eget hendrerit dapibus, lorem ante sodales turpis, sit amet ornare eros purus sit amet velit. Aliquam dapibus in ligula at consequat.', '209.jpg', 0, 2),
(210, 'Myricae', 0, '2022-07-30', 2, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eleifend libero eget lacus iaculis, et dapibus ante accumsan. Maecenas et elit egestas velit convallis eleifend at eu ligula. Donec dapibus, ante et mollis varius, tellus odio elementum ex, sit amet consequat massa tellus vel diam. Maecenas nec ipsum odio. Aliquam vel porttitor lectus.', '210.jpg', 0, 3),
(211, 'Canti di Castelvecchio', 0, '2022-07-30', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pellentesque in orci nec scelerisque. Integer finibus egestas nibh, sit amet ultricies nibh commodo dictum. Quisque eu turpis porta, faucibus velit sed, rutrum neque. Mauris ultricies nisl nec quam accumsan egestas. Maecenas sed pellentesque enim.', '211.jpeg', 0, 1),
(212, 'Ossi di seppia', 0, '2022-07-30', 3, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pellentesque in orci nec scelerisque. Integer finibus egestas nibh, sit amet ultricies nibh commodo dictum. Quisque eu turpis porta, faucibus velit sed, rutrum neque. Mauris ultricies nisl nec quam accumsan egestas. Maecenas sed pellentesque enim.', '212.jpg', 0, 2),
(213, 'Satura', 0, '2022-07-30', 0, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pellentesque in orci nec scelerisque. Integer finibus egestas nibh, sit amet ultricies nibh commodo dictum. Quisque eu turpis porta, faucibus velit sed, rutrum neque. Mauris ultricies nisl nec quam accumsan egestas. Maecenas sed pellentesque enim', '213.jpg', 1, 1),
(214, 'Il Canzoniere', 0, '2022-07-30', 5, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet orci auctor, elementum mi vitae, iaculis velit. Sed non elit et nunc semper commodo. Sed finibus lobortis mollis. Donec quis convallis mauris. Sed placerat vestibulum ligula, consequat pellentesque erat. Curabitur pretium sagittis justo, eget cursus quam tempus vel. Nulla ultricies eleifend tellus sed sollicitudin. Etiam ut risus accumsan, dictum velit eget, tempus magna', '214.jpg', 0, 2),
(215, 'Storia e cronistoria del Canzoniere', 0, '2022-07-30', 0, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet orci auctor, elementum mi vitae, iaculis velit. Sed non elit et nunc semper commodo. Sed finibus lobortis mollis. Donec quis convallis mauris. Sed placerat vestibulum ligula, consequat pellentesque erat. Curabitur pretium sagittis justo, eget cursus quam tempus vel. Nulla ultricies eleifend tellus sed sollicitudin. Etiam ut risus accumsan, dictum velit eget, tempus magna', '215.jpg', 0, 3),
(216, 'Le tre corone', 0, '2022-07-30', 3, 0, 'Blog gestito dalle tre corone del 1300, padri della lingua italiana moderna.', '216.png', 0, 2),
(217, 'I poeti del 900', 0, '2022-07-30', 2, 0, 'Blog gestito dai grandi poeti del 900. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet orci auctor, elementum mi vitae, iaculis velit. Sed non elit et nunc semper commodo.', '217.jpg', 0, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `coautore`
--

CREATE TABLE `coautore` (
  `IDautore` int(11) NOT NULL,
  `IDblog` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `coautore`
--

INSERT INTO `coautore` (`IDautore`, `IDblog`) VALUES
(65, 202),
(66, 216),
(67, 197),
(67, 202),
(67, 216),
(73, 217);

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `IDcommento` int(11) NOT NULL,
  `testoCommento` text NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `dataModifica` timestamp NULL DEFAULT NULL,
  `numLike` int(11) NOT NULL,
  `IDpost` int(11) NOT NULL,
  `IDutente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `commento`
--

INSERT INTO `commento` (`IDcommento`, `testoCommento`, `data`, `dataModifica`, `numLike`, `IDpost`, `IDutente`) VALUES
(114, 'Che grande opera. Userò la tua poesia per sviluppare la mia prosa!', '2022-07-29 09:47:48', '2022-07-29 09:53:32', 4, 93, 66),
(115, 'Ancora meglio del primo canto della prima cantica!', '2022-07-29 09:54:11', NULL, 2, 98, 66),
(116, 'Ho scritto questo per aiutarti sulla ricostruzione della mia biografia', '2022-07-29 10:00:23', NULL, 0, 105, 65),
(117, 'La mia influenza in questa opera è notevole.', '2022-07-29 10:06:26', NULL, 3, 107, 65),
(118, 'Ottima analisi. Direi che si potrebbe parlare di una Commedia... Divina!', '2022-07-29 10:08:37', NULL, 4, 108, 66),
(119, 'Mi ispirerò alle tue parole d\\\'amore per Beatrice per trovare le parole per Laura.', '2022-07-29 10:10:20', NULL, 1, 99, 67),
(120, 'La tua Laura, come la mia Fiammetta', '2022-07-29 10:18:29', NULL, 1, 107, 66),
(121, 'Scriverò anch\\\'io una collezione di biografie, sulle donne importanti della storia.', '2022-07-29 10:19:14', NULL, 1, 109, 66),
(122, 'Anche se non sono toscano, scriverò nella tua lingua, tanto m\\\'aggrada!', '2022-07-29 17:31:13', NULL, 2, 93, 68),
(123, 'I tempi antichi! Che nostalgia.', '2022-07-29 17:58:27', NULL, 0, 109, 69),
(124, 'Molto affascinante. Ma secondo me, l\\\'\\\"anima di colui che fece per viltade il gran rifiuto\\\" resta Ponzio Pilato, non Celestino V.', '2022-07-30 10:22:14', NULL, 0, 108, 70),
(125, 'Che capolavoro. Un vero poeta fanciullino.', '2022-07-30 10:24:14', NULL, 2, 114, 70),
(126, 'Pascoli è un poeta certamente molto notevole, ma troppo dolciastro per il mio temperamento, troppo sentimentale.', '2022-07-30 10:43:41', NULL, 1, 120, 71),
(127, 'Chiamerò la mia raccolta poetica come la tua, tanto mi sento vicino a te', '2022-07-30 12:31:08', '2022-07-30 12:31:18', 1, 106, 73),
(128, 'Come te, disprezzo i \\\"poeti laureati\\\"', '2022-07-30 12:32:47', NULL, 1, 122, 73),
(129, 'Che gran poesia. È un onore essere tanto apprezzato da te.', '2022-07-30 12:33:23', NULL, 1, 124, 73),
(130, 'Una delle figure più importanti di fine \\\'800.', '2022-07-30 12:35:21', NULL, 0, 119, 73),
(131, 'Tu ti rivolgi alla luna... io ad una capra. \nInfinite le strade della poesia.', '2022-07-30 12:36:35', NULL, 2, 117, 73),
(132, 'La lezione di Leopardi è immortale.', '2022-07-30 12:37:30', NULL, 1, 114, 73),
(133, 'Mi spiace che tuo padre sia stato assassinato... pensa che mio padre è stato per me l\'assassino.', '2022-07-30 12:38:11', '2022-07-30 12:39:40', 0, 120, 73),
(134, 'Un poeta da cui ho indubbiamente imparato molto. Poesia strepitosa.', '2022-07-30 12:43:49', NULL, 1, 117, 71),
(135, 'Ci voleva Pisa a farti uscire dal lungo silenzio poetico, eh?', '2022-07-30 12:44:19', NULL, 1, 115, 71),
(136, 'Le rose e le viole non fioriscono nella stessa stagione. Ma questa non è una distrazione, ma un\\\'altra dimostrazione della grandezza di un poeta che usa l\\\'immaginazione più della vista.', '2022-07-30 12:46:43', NULL, 0, 113, 70),
(137, 'Che prosa. Ma preferisco la poesia, specialmente la dantesca.', '2022-07-30 12:49:25', NULL, 1, 104, 70),
(138, 'La lussuria! Non capisco proprio questo peccato.', '2022-07-30 12:50:38', NULL, 0, 97, 70),
(140, 'Quanti personaggi antichi ed importanti in questo canto. Che gran nostalgia.', '2022-07-30 13:15:52', NULL, 0, 96, 69),
(141, 'Canto fondamentale. La figura di dante è imponente, come il suo monumento che si preparava in Firenze', '2022-07-30 13:16:57', NULL, 0, 94, 69),
(142, 'È con la maturità che arrivano i veri problemi esistenziali dell\\\'uomo. Siamo tutti condannati a rimpiangere la nostra fanciullezza.', '2022-07-30 13:17:54', NULL, 0, 111, 69),
(143, 'Ti capisco! La mia influenza in quest\\\'opera è evidente', '2022-07-30 13:19:22', NULL, 1, 123, 69),
(144, 'Non ti dico cos\\\'ho provato dopo la morte della mia Silvia...', '2022-07-30 13:20:28', NULL, 0, 107, 69),
(145, 'Prosa sicuramente innovativa... ma la mia è tutta su un altro livello.', '2022-07-30 13:21:45', NULL, 0, 100, 66),
(146, 'Un secolo dopo, cerco le parole nelle tue opere.', '2022-07-30 13:23:12', NULL, 0, 116, 73),
(147, 'Saluta il povero Astolfo!', '2022-07-30 13:24:29', NULL, 0, 117, 68);

-- --------------------------------------------------------

--
-- Struttura della tabella `giudizio`
--

CREATE TABLE `giudizio` (
  `IDutente` int(11) NOT NULL,
  `IDpost` int(11) NOT NULL,
  `voto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `giudizio`
--

INSERT INTO `giudizio` (`IDutente`, `IDpost`, `voto`) VALUES
(65, 108, 4),
(65, 129, 2),
(66, 93, 5),
(66, 109, 4),
(66, 110, 3),
(66, 130, 4),
(67, 93, 4),
(67, 98, 4),
(67, 105, 4),
(67, 111, 5),
(69, 123, 3),
(70, 93, 5),
(70, 104, 3),
(70, 108, 5),
(70, 109, 3),
(70, 111, 3),
(70, 113, 4),
(70, 114, 5),
(70, 115, 4),
(70, 116, 3),
(70, 117, 3),
(71, 119, 4),
(71, 120, 3),
(73, 93, 5),
(73, 106, 3),
(73, 108, 3),
(73, 114, 4),
(73, 115, 2),
(73, 116, 4),
(73, 117, 4),
(73, 119, 5),
(73, 120, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `iscritto`
--

CREATE TABLE `iscritto` (
  `IDutente` int(11) NOT NULL,
  `IDblog` int(11) NOT NULL,
  `dataIscrizione` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `iscritto`
--

INSERT INTO `iscritto` (`IDutente`, `IDblog`, `dataIscrizione`) VALUES
(66, 197, '2022-07-29'),
(66, 198, '2022-08-01'),
(66, 203, '2022-07-29'),
(66, 204, '2022-07-29'),
(67, 198, '2022-07-29'),
(68, 197, '2022-07-29'),
(68, 198, '2022-07-29'),
(68, 201, '2022-07-29'),
(68, 202, '2022-07-29'),
(68, 203, '2022-07-29'),
(68, 204, '2022-07-29'),
(69, 197, '2022-07-29'),
(69, 203, '2022-07-29'),
(70, 197, '2022-07-30'),
(70, 198, '2022-07-30'),
(70, 208, '2022-07-30'),
(71, 197, '2022-07-30'),
(71, 203, '2022-07-30'),
(71, 207, '2022-07-30'),
(71, 208, '2022-07-30'),
(71, 210, '2022-07-30'),
(73, 197, '2022-07-30'),
(73, 203, '2022-08-22'),
(73, 208, '2022-07-30'),
(73, 210, '2022-07-30'),
(73, 211, '2022-07-30'),
(73, 212, '2022-07-30');

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE `likes` (
  `IDutente` int(11) NOT NULL,
  `IDcommento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `likes`
--

INSERT INTO `likes` (`IDutente`, `IDcommento`) VALUES
(65, 114),
(65, 118),
(65, 119),
(65, 122),
(66, 117),
(66, 127),
(66, 137),
(67, 114),
(67, 115),
(67, 117),
(67, 118),
(67, 120),
(68, 114),
(68, 118),
(68, 131),
(68, 134),
(69, 121),
(70, 114),
(70, 115),
(70, 122),
(70, 135),
(71, 125),
(71, 128),
(71, 129),
(71, 131),
(71, 132),
(73, 117),
(73, 125),
(73, 126),
(73, 143);

-- --------------------------------------------------------

--
-- Struttura della tabella `pagamento`
--

CREATE TABLE `pagamento` (
  `IDpagamento` int(11) NOT NULL,
  `dataAbbonamento` date NOT NULL,
  `intestatario` varchar(50) NOT NULL,
  `numeroCarta` varchar(16) NOT NULL,
  `scadenzaCarta` varchar(12) NOT NULL,
  `IDutente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `pagamento`
--

INSERT INTO `pagamento` (`IDpagamento`, `dataAbbonamento`, `intestatario`, `numeroCarta`, `scadenzaCarta`, `IDutente`) VALUES
(20, '2022-07-30', 'Eugenio Montale', '1234123412341234', '2024-07', 71),
(39, '2022-08-02', 'Dante Alighieri', '1234123412341234', '2022-11', 65);

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `IDpost` int(11) NOT NULL,
  `titolo` varchar(63) NOT NULL,
  `sottotitolo` varchar(63) NOT NULL,
  `data` date NOT NULL,
  `testoPost` text NOT NULL,
  `immagine` varchar(63) NOT NULL,
  `numCommenti` int(11) NOT NULL,
  `mediaGiudizio` float NOT NULL,
  `IDblog` int(11) NOT NULL,
  `IDutente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`IDpost`, `titolo`, `sottotitolo`, `data`, `testoPost`, `immagine`, `numCommenti`, `mediaGiudizio`, `IDblog`, `IDutente`) VALUES
(93, 'Inferno I', 'Primo canto della prima cantica', '2022-07-29', 'Nel mezzo del cammin di nostra vita,\r\nmi ritrovai per una selva oscura,\r\nche la diritta via era smarrita', '93.jpg', 2, 4.75, 197, 65),
(94, 'Inferno II', 'Secondo canto della prima cantica', '2022-07-29', 'Lo giorno se n’andava, e l’aere bruno\r\ntoglieva li animai che sono in terra\r\nda le fatiche loro; e io sol uno\r\n\r\nm’apparecchiava a sostener la guerra\r\nsì del cammino e sì de la pietate,\r\nche ritrarrà la mente che non erra.', '94.jpg', 1, 0, 197, 65),
(95, 'Inferno III', 'Terzo canto prima cantica', '2022-07-29', '’Per me si va ne la città dolente,\r\nper me si va ne l\'etterno dolore,\r\nper me si va tra la perduta gente.\r\n\r\nGiustizia mosse il mio alto fattore;\r\nfecemi la divina podestate,\r\nla somma sapïenza e ’l primo amore.', '95.jpg', 0, 0, 197, 65),
(96, 'Inferno IV', 'Quarto canto prima cantica', '2022-07-29', '’Per me si va ne la città dolente,\r\nper me si va ne l\'etterno dolore,\r\nper me si va tra la perduta gente.\r\n\r\nGiustizia mosse il mio alto fattore;\r\nfecemi la divina podestate,\r\nla somma sapïenza e ’l primo amore.', '96.jpg', 1, 0, 197, 65),
(97, 'Inferno V', 'Canto quinto prima cantica', '2022-07-29', 'Così discesi del cerchio primaio\r\ngiù nel secondo, che men loco cinghia\r\ne tanto più dolor, che punge a guaio.\r\n\r\nStavvi Minòs orribilmente, e ringhia:\r\nessamina le colpe ne l’intrata;\r\ngiudica e manda secondo ch’avvinghia.', '97.jpg', 1, 0, 197, 65),
(98, 'Purgatorio I', 'Primo canto seconda cantica', '2022-07-29', 'Per correr miglior acque alza le vele\r\nomai la navicella del mio ingegno,\r\nche lascia dietro a sé mar sì crudele;\r\n\r\ne canterò di quel secondo regno\r\ndove l’umano spirito si purga\r\ne di salire al ciel diventa degno.', '98.jpg', 1, 4, 197, 65),
(99, 'Sulle poesie della Vita Nova', 'Considerazioni intorno ai componimenti poetici del prosimetro', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '99.jpg', 1, 0, 198, 65),
(100, 'Sulla prosa della Vita Nova', 'Considerazioni intorno alla prosa della Vita Nova', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '100.png', 1, 0, 198, 65),
(101, 'I Trattato', 'Proemio e introduzione', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', 'default.png', 0, 0, 199, 65),
(102, 'II Trattato', 'Tra prosa e poesia', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', 'default.png', 0, 0, 199, 65),
(103, 'Tra lingua latina e volgare', 'Considerazione sulla questione della lingua', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '103.jpg', 0, 0, 200, 65),
(104, 'Prima giornata', 'Le prime dieci novelle', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '104.jpg', 1, 3, 201, 66),
(105, 'La giovinezza', 'I primi anni del padre della lingua italiana', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '105.jpg', 1, 4, 202, 65),
(106, 'Prima della morte di Laura', 'Parte I dell\\\'opera', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '106.jpg', 1, 3, 203, 67),
(107, 'Dopo la morte di Laura', 'Parte II dell\\\'opera', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '107.jpg', 3, 0, 203, 67),
(108, 'Saggio critico sulla Commedia', 'Studio su trama e stile del capolavoro dantesco', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '108.jpg', 2, 3.75, 197, 67),
(109, 'Biografia di Romolo', 'Fondatore della città di Roma', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '109.png', 2, 3.5, 204, 67),
(110, 'Biografia di Numa Pompilio', 'Secondo re di Roma', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum non nunc eget pellentesque. Nullam dolor est, viverra eu imperdiet vitae, finibus euismod magna. Fusce mattis, risus at cursus facilisis, lacus ante accumsan magna, sed mattis tortor nisi non neque. Nunc eget purus leo.', '110.jpg', 0, 3, 204, 67),
(111, 'La maturità', 'Gli anni della maturità', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et libero iaculis, ornare nunc vitae, sollicitudin orci. Fusce lorem enim, placerat sed interdum a, maximus a sem. Fusce faucibus felis leo, sed eleifend ex dapibus ut. Vestibulum vulputate, dolor eget hendrerit dapibus, lorem ante sodales turpis, sit amet ornare eros purus sit amet velit. Aliquam dapibus in ligula at consequat.', '111.jpg', 1, 4, 202, 66),
(112, 'Gli ultimi anni', 'Gli ultimi anni della vita, dell\\\'esilio', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et libero iaculis, ornare nunc vitae, sollicitudin orci. Fusce lorem enim, placerat sed interdum a, maximus a sem. Fusce faucibus felis leo, sed eleifend ex dapibus ut. Vestibulum vulputate, dolor eget hendrerit dapibus, lorem ante sodales turpis, sit amet ornare eros purus sit amet velit. Aliquam dapibus in ligula at consequat.', '112.jpg', 0, 0, 202, 67),
(113, 'Il sabato del villaggio', 'Idillio del 1829, Recanati', '2022-07-29', 'La donzelletta vien dalla campagna,\nIn sul calar del sole,\nCol suo fascio dell’erba; e reca in mano\nUn mazzolin di rose e di viole,\nOnde, siccome suole,\nOrnare ella si appresta\nDimani, al dì di festa, il petto e il crine.\nSiede con le vicine\nSu la scala a filar la vecchierella,\nIncontro là dove si perde il giorno;', '113.jpg', 1, 4, 208, 69),
(114, 'L\\\'infinito', 'Idillio del 1829, Recanati', '2022-07-29', 'Sempre caro mi fu quest’ermo colle,\r\nE questa siepe, che da tanta parte\r\nDell’ultimo orizzonte il guardo esclude.\r\nMa sedendo e mirando, interminati\r\nSpazi di là da quella, e sovrumani\r\nSilenzi, e profondissima quiete\r\nIo nel pensier mi fingo; ove per poco\r\nIl cor non si spaura.', '114.jpg', 2, 4.5, 208, 69),
(115, 'A Silvia', 'Idillio del 1828, Pisa', '2022-07-29', 'Silvia, rimembri ancora\r\nQuel tempo della tua vita mortale,\r\nQuando beltà splendea\r\nNegli occhi tuoi ridenti e fuggitivi,\r\nE tu, lieta e pensosa, il limitare\r\nDi gioventù salivi?', '115.jpg', 1, 3, 208, 69),
(116, 'La quiete dopo la tempesta', 'Idillio del 1831, Recanati', '2022-07-29', 'Passata è la tempesta:\r\nodo augelli far festa, e la gallina,\r\ntornata in su la via,\r\nche ripete il suo verso. Ecco il sereno\r\nrompe lá da ponente, alla montagna:\r\nsgombrasi la campagna,\r\ne chiaro nella valle il fiume appare.\r\nOgni cor si rallegra, in ogni lato\r\nrisorge il romorio,\r\ntorna il lavoro usato.', '116.jpg', 1, 3.5, 208, 69),
(117, 'Alla luna', 'Idillio del 1819, Recanati', '2022-07-29', 'O graziosa luna, io mi rammento       \r\nChe, or volge l\'anno, sovra questo colle\r\nIo venia pien d\'angoscia a rimirarti:\r\nE tu pendevi allor su quella selva\r\nSiccome or fai, che tutta la rischiari.', '117.jpg', 3, 3.5, 208, 69),
(118, 'Dialogo della natura e di un islandese', 'Racconto filosofico', '2022-07-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et libero iaculis, ornare nunc vitae, sollicitudin orci. Fusce lorem enim, placerat sed interdum a, maximus a sem. Fusce faucibus felis leo, sed eleifend ex dapibus ut. Vestibulum vulputate, dolor eget hendrerit dapibus, lorem ante sodales turpis, sit amet ornare eros purus sit amet velit. Aliquam dapibus in ligula at consequat.', '118.jpg', 0, 0, 209, 69),
(119, 'Lavandare', 'Poesia del 1891', '2022-07-30', 'Nel campo mezzo grigio e mezzo nero\r\nresta un aratro senza buoi che pare\r\ndimenticato, tra il vapor leggero.\r\n\r\nE cadenzato dalla gora viene\r\nlo sciabordare delle lavandare\r\ncon tonfi spessi e lunghe cantilene:\r\n\r\nIl vento soffia e nevica la frasca,\r\ne tu non torni ancora al tuo paese!\r\nquando partisti, come son rimasta!\r\ncome l’aratro in mezzo alla maggese.', '119.jpg', 1, 4.5, 210, 70),
(120, 'X Agosto', 'Poesia in memoria del padre, 1891', '2022-07-30', 'San Lorenzo, io lo so perché tanto\r\ndi stelle per l\'aria tranquilla\r\narde e cade, perché sì gran pianto\r\nnel concavo cielo sfavilla.\r\n \r\nRitornava una rondine al tetto:\r\nl\'uccisero: cadde tra spini:\r\nella aveva nel becco un insetto:\r\nla cena de\' suoi rondinini.', '120.jpg', 2, 3.5, 210, 70),
(121, 'Il gelsomino notturno', 'Poesia del 1903', '2022-07-30', 'E s\'aprono i fiori notturni\r\n     nell\'ora che penso a\' miei cari.\r\n     Sono apparse in mezzo ai viburni\r\n     le farfalle crepuscolari.\r\n     Da un pezzo si tacquero i gridi:\r\n     là sola una casa bisbiglia.', '121.jpg', 0, 0, 211, 70),
(122, 'I limoni', 'Poesia del 1925', '2022-07-30', 'Ascoltami, i poeti laureati\r\nsi muovono soltanto fra le piante\r\ndai nomi poco usati: bossi ligustri o acanti.\r\nIo, per me, amo le strade che riescono agli erbosi\r\nfossi dove in pozzanghere\r\nmezzo seccate agguantano i ragazzi\r\nqualche sparuta anguilla:', '122.jpg', 1, 0, 212, 71),
(123, 'Spesso il male di vivere ho incontrato', 'Poesia del 1925', '2022-07-30', 'Spesso il male di vivere ho incontrato\r\nera il rivo strozzato che gorgoglia\r\nera l’incartocciarsi della foglia\r\nriarsa, era il cavallo stramazzato.', '123.jpg', 1, 3, 212, 71),
(124, 'Meriggiare pallido e assorto', 'Poesia del 1925', '2022-07-30', 'Meriggiare pallido e assorto\r\npresso un rovente muro d’orto,\r\nascoltare tra i pruni e gli sterpi\r\nschiocchi di merli, frusci di serpi.\r\n\r\nNelle crepe del suolo o su la veccia\r\nspiar le file di rosse formiche\r\nch’ora si rompono ed ora s’intrecciano\r\na sommo di minuscole biche.', '124.jpg', 1, 0, 212, 71),
(125, 'La capra', 'Poesia del 1912', '2022-07-30', 'Ho parlato a una capra.\r\n\r\nEra sola sul prato, era legata.\r\n\r\nSazia d’erba, bagnata\r\n\r\ndalla pioggia, belava.\r\n\r\nQuell’uguale belato era fraterno\r\n\r\nal mio dolore. Ed io risposi, prima\r\n\r\nper celia, poi perché il dolore è eterno,\r\n\r\nha una voce e non varia.\r\n\r\nQuesta voce sentiva\r\n\r\ngemere in una capra solitaria.\r\n\r\nIn una capra dal viso semita\r\n\r\nsentiva querelarsi ogni altro male,\r\n\r\nogni altra vita.', '125.jpg', 0, 0, 214, 73),
(126, 'Mio padre è stato per me l\\\'assassino', 'Poesia del 1923', '2022-07-30', 'Mio padre è stato per me “l’assassino”;\r\n\r\nfino ai vent’anni che l’ho conosciuto.\r\n\r\nAllora ho visto ch’egli era un bambino,\r\n\r\ne che il dono ch’io ho da lui l’ho avuto.\r\n\r\n \r\n\r\nAveva in volto il mio sguardo azzurrino,\r\n\r\nun sorriso, in miseria, dolce e astuto.\r\n\r\nAndò sempre pel mondo pellegrino;\r\n\r\npiù d’una donna l’ha amato e pasciuto.', '126.jpg', 0, 0, 214, 73),
(127, 'Ulisse', 'Poesia del 1946', '2022-07-30', 'Nella mia giovinezza ho navigato\r\nlungo le coste dalmate. Isolotti\r\na fior d’onda emergevano, ove raro\r\nun uccello sostava intento a prede,\r\ncoperti d’alghe, scivolosi, al sole\r\nbelli come smeraldi.', '127.jpg', 0, 0, 214, 73),
(128, 'Città vecchia', 'Poesia del 1912', '2022-07-30', 'Spesso, per ritornare alla mia casa\r\nprendo un\'oscura via di città vecchia.\r\nGiallo in qualche pozzanghera si specchia\r\nqualche fanale, e affollata è la strada.\r\n\r\nQui tra la gente che viene che va\r\ndall\'osteria alla casa o al lupanare\r\ndove son merci ed uomini il detrito\r\ndi un gran porto di mare,\r\nio ritrovo, passando, l\'infinito\r\nnell\'umiltà.', '128.png', 0, 0, 214, 73),
(129, 'Amai', 'Poesia del 1946', '2022-07-30', 'Amai trite parole che non uno\r\nosava. M’incantò la rima fiore\r\namore,\r\nla più antica difficile del mondo.\r\nAmai la verità che giace al fondo,\r\nquasi un sogno obliato, che il dolore\r\nriscopre amica. Con paura il cuore\r\nle si accosta, che più non l’abbandona.\r\nAmo te che mi ascolti e la mia buona\r\ncarta lasciata al fine del mio gioco.', '129.jpg', 0, 2, 214, 73),
(130, 'Un maestro di prosa e poesia', 'Il volgare, tra prosa e poesia', '2022-07-30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet orci auctor, elementum mi vitae, iaculis velit. Sed non elit et nunc semper commodo. Sed finibus lobortis mollis. Donec quis convallis mauris. Sed placerat vestibulum ligula, consequat pellentesque erat. Curabitur pretium sagittis justo, eget cursus quam tempus vel. Nulla ultricies eleifend tellus sed sollicitudin. Etiam ut risus accumsan, dictum velit eget, tempus magna', '130.jpg', 0, 4, 216, 65),
(131, 'Un maestro della prosa', 'L\\\'inventore dell\\\'italiano prosastico', '2022-07-30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet orci auctor, elementum mi vitae, iaculis velit. Sed non elit et nunc semper commodo. Sed finibus lobortis mollis. Donec quis convallis mauris. Sed placerat vestibulum ligula, consequat pellentesque erat. Curabitur pretium sagittis justo, eget cursus quam tempus vel. Nulla ultricies eleifend tellus sed sollicitudin. Etiam ut risus accumsan, dictum velit eget, tempus magna', '131.jpg', 0, 0, 216, 66),
(132, 'Il primo umanista italiano', 'L\\\'iniziatore dell\\\'umanesimo', '2022-07-30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet orci auctor, elementum mi vitae, iaculis velit. Sed non elit et nunc semper commodo. Sed finibus lobortis mollis. Donec quis convallis mauris. Sed placerat vestibulum ligula, consequat pellentesque erat. Curabitur pretium sagittis justo, eget cursus quam tempus vel. Nulla ultricies eleifend tellus sed sollicitudin. Etiam ut risus accumsan, dictum velit eget, tempus magna', '132.jpg', 0, 0, 216, 67),
(133, 'Lo smarrimento nella modernità', 'L\\\'analisi del Premio Nobel', '2022-07-30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet orci auctor, elementum mi vitae, iaculis velit. Sed non elit et nunc semper commodo. Sed finibus lobortis mollis. Donec quis convallis mauris. Sed placerat vestibulum ligula, consequat pellentesque erat. Curabitur pretium sagittis justo, eget cursus quam tempus vel. Nulla ultricies eleifend tellus sed sollicitudin. Etiam ut risus accumsan, dictum velit eget, tempus magna', '133.jpg', 0, 0, 217, 71),
(134, 'La lezione di Leopardi', 'Leopardi per l\\\'uomo comune', '2022-07-30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet orci auctor, elementum mi vitae, iaculis velit. Sed non elit et nunc semper commodo. Sed finibus lobortis mollis. Donec quis convallis mauris. Sed placerat vestibulum ligula, consequat pellentesque erat. Curabitur pretium sagittis justo, eget cursus quam tempus vel. Nulla ultricies eleifend tellus sed sollicitudin. Etiam ut risus accumsan, dictum velit eget, tempus magna', '134.jpeg', 0, 0, 217, 73);

-- --------------------------------------------------------

--
-- Struttura della tabella `sottotema`
--

CREATE TABLE `sottotema` (
  `IDsottotema` int(20) NOT NULL,
  `sottotema` varchar(30) NOT NULL,
  `macrotema` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `sottotema`
--

INSERT INTO `sottotema` (`IDsottotema`, `sottotema`, `macrotema`) VALUES
(1, 'Vegano', 6),
(2, 'Cani', 4),
(3, 'Gatti', 4),
(4, 'Lungometraggi', 1),
(5, 'Cortometraggi', 1),
(6, 'Registi', 1),
(7, 'Attori', 1),
(8, 'Vegetariano', 6),
(9, 'Per neonati', 6),
(10, 'Videogiochi', 3),
(11, 'Giochi da tavolo', 3),
(12, 'All\'aria aperta', 3),
(13, 'Libri', 5),
(14, 'Fumetti', 5),
(15, 'Saggistica', 5),
(16, 'Narrativa', 5),
(17, 'Uomini', 9),
(18, 'Donne', 9),
(19, 'Rock', 7),
(20, 'Pop', 7),
(21, 'Rap', 7),
(22, 'Calcio', 2),
(23, 'Tennis', 2),
(24, 'Telefonia', 8),
(25, 'Computer', 8),
(26, 'Programmazione', 8),
(27, 'Europa', 10),
(28, 'Americhe', 10),
(110, 'Lupa', 4),
(111, 'Lonza', 4),
(112, 'Leone', 4),
(113, 'Poesia', 5),
(114, 'Classici', 5),
(115, 'Prosa', 5),
(116, 'Oltretomba', 10),
(117, 'Biografia', 5),
(118, 'Gru', 4),
(119, 'Luna', 10),
(120, 'Seppia', 4),
(121, 'Capra', 4),
(122, 'Natura', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `stile`
--

CREATE TABLE `stile` (
  `IDstile` int(11) NOT NULL,
  `sfondo` varchar(63) NOT NULL,
  `font` varchar(255) NOT NULL,
  `premium` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `stile`
--

INSERT INTO `stile` (`IDstile`, `sfondo`, `font`, `premium`) VALUES
(1, 'sfondo1.png', '\'Times New Roman\', Times, serif', 0),
(2, 'sfondo2.png', 'Arial, Helvetica, sans-serif', 0),
(3, 'sfondo3.png', '\'Comic Sans MS\', \'Comic Sans\', cursive', 0),
(4, 'sfondo4.png', 'Arial Narrow, sans-serif', 1),
(5, 'sfondo5.png', 'American Typewriter, serif', 1),
(6, 'sfondo6.png', 'Verdana, sans-serif', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `tema`
--

CREATE TABLE `tema` (
  `IDtema` int(11) NOT NULL,
  `tema` varchar(31) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tema`
--

INSERT INTO `tema` (`IDtema`, `tema`) VALUES
(4, 'Animali'),
(1, 'Cinema'),
(6, 'Cucina'),
(3, 'Giochi'),
(5, 'Lettura'),
(9, 'Moda'),
(7, 'Musica'),
(2, 'Sport'),
(8, 'Tecnologia'),
(10, 'Viaggi');

-- --------------------------------------------------------

--
-- Struttura della tabella `temiblog`
--

CREATE TABLE `temiblog` (
  `IDblog` int(11) NOT NULL,
  `IDtema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `temiblog`
--

INSERT INTO `temiblog` (`IDblog`, `IDtema`) VALUES
(197, 110),
(197, 111),
(197, 112),
(197, 113),
(197, 114),
(197, 116),
(198, 18),
(198, 113),
(198, 114),
(198, 115),
(201, 16),
(201, 114),
(201, 115),
(201, 118),
(202, 115),
(202, 117),
(203, 27),
(203, 113),
(203, 114),
(204, 13),
(204, 115),
(204, 117),
(205, 16),
(205, 113),
(205, 114),
(205, 119),
(207, 113),
(207, 117),
(208, 22),
(208, 27),
(208, 113),
(208, 114),
(209, 13),
(209, 15),
(209, 114),
(209, 115),
(210, 113),
(210, 114),
(211, 113),
(211, 114),
(211, 117),
(212, 13),
(212, 113),
(212, 114),
(212, 120),
(214, 113),
(214, 117),
(214, 121),
(215, 13),
(215, 115),
(215, 117),
(216, 13),
(216, 15),
(216, 27),
(216, 113),
(216, 114),
(216, 115),
(217, 113),
(217, 114);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `IDutente` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(63) NOT NULL,
  `proPic` varchar(127) DEFAULT NULL,
  `dataNascita` date NOT NULL,
  `abbonato` tinyint(1) NOT NULL DEFAULT 0,
  `rinnovoAutomatico` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`IDutente`, `username`, `password`, `email`, `proPic`, `dataNascita`, `abbonato`, `rinnovoAutomatico`) VALUES
(65, 'Dante', '$2y$10$R44nEuYyOeHkyes61ihCL.RNzEHs2KaXJUCk2TtHhCGsyfklojdhS', 'dante@virgilio.it', '65.jpg', '1966-03-23', 1, 0),
(66, 'Boccaccio', '$2y$10$XY4qeXUVsJpKXI5z/Q5yIO90.JxQoBadv3ppvWp8i6JFVnq7YsS/O', 'boccaccio@gmail.com', '66.jpg', '1999-06-08', 0, 0),
(67, 'Petrarca', '$2y$10$pbqnZU5wGnPRRLUD2W936e4KGTGP89CWeDK3PKeVTQA4t61jna3jW', 'petrarca@gmail.com', '67.jpg', '1997-07-11', 0, 0),
(68, 'Ariosto', '$2y$10$zujLc5Odcd.NqA6/Ez.yi.Ot./gzb8xnXVZzXugdUxSKVEPpfOCOm', 'ariosto@gmail.com', '68.jpg', '1995-03-29', 0, 0),
(69, 'Leopardi', '$2y$10$yaMt9DuDwsrgi6h2T7RkweVFAi3aFrCnYwxSTtjMHz/CmQ5rfwqQi', 'leopardi@gmail.com', '69.jpg', '2014-10-29', 0, 0),
(70, 'Pascoli', '$2y$10$Y/5OM5SEpYd5TD4eyERZPuRIe7GwX3CuWEj//aOGAXlFFfkuFD9vm', 'pascoli@gmail.com', '70.jpg', '2007-03-30', 0, 0),
(71, 'Montale', '$2y$10$j1TB8Objomq1czEk9Eb0huRfq3jo.H7c8odR3eFDJQ8.zfuJ2fJji', 'montale@gmail.com', '71.jpg', '1995-07-30', 1, 1),
(73, 'Saba', '$2y$10$3d3v7KcHsW1QRPt4lQpEcOd70GrkfGAbWUset02gDeNCgO2oqDRl2', 'saba@gmail.com', '73.jpg', '1997-07-30', 0, 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `autore`
--
ALTER TABLE `autore`
  ADD PRIMARY KEY (`IDutente`,`IDblog`),
  ADD KEY `Autore_ibfk_1` (`IDblog`);

--
-- Indici per le tabelle `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`IDblog`),
  ADD UNIQUE KEY `titolo` (`titolo`),
  ADD KEY `Blog_ibfk_1` (`IDstile`);

--
-- Indici per le tabelle `coautore`
--
ALTER TABLE `coautore`
  ADD PRIMARY KEY (`IDautore`,`IDblog`),
  ADD KEY `Coautore_ibfk_2` (`IDblog`);

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`IDcommento`),
  ADD KEY `Commento_ibfk_1` (`IDpost`),
  ADD KEY `Commento_ibfk_2` (`IDutente`);

--
-- Indici per le tabelle `giudizio`
--
ALTER TABLE `giudizio`
  ADD PRIMARY KEY (`IDutente`,`IDpost`),
  ADD KEY `Giudizio_ibfk_1` (`IDpost`);

--
-- Indici per le tabelle `iscritto`
--
ALTER TABLE `iscritto`
  ADD PRIMARY KEY (`IDutente`,`IDblog`),
  ADD KEY `Iscritto_ibfk_2` (`IDblog`);

--
-- Indici per le tabelle `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`IDutente`,`IDcommento`),
  ADD KEY `Like_ibfk_2` (`IDcommento`);

--
-- Indici per le tabelle `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`IDpagamento`),
  ADD KEY `Pagamento_ibfk_1` (`IDutente`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`IDpost`),
  ADD KEY `Post_ibfk_2` (`IDutente`),
  ADD KEY `Post_ibfk_1` (`IDblog`);

--
-- Indici per le tabelle `sottotema`
--
ALTER TABLE `sottotema`
  ADD PRIMARY KEY (`IDsottotema`),
  ADD KEY `Sottotema_ibfk_2` (`macrotema`);

--
-- Indici per le tabelle `stile`
--
ALTER TABLE `stile`
  ADD PRIMARY KEY (`IDstile`);

--
-- Indici per le tabelle `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`IDtema`),
  ADD UNIQUE KEY `tema` (`tema`);

--
-- Indici per le tabelle `temiblog`
--
ALTER TABLE `temiblog`
  ADD PRIMARY KEY (`IDblog`,`IDtema`),
  ADD KEY `Temiblog_ibfk_2` (`IDtema`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`IDutente`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `blog`
--
ALTER TABLE `blog`
  MODIFY `IDblog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `IDcommento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT per la tabella `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `IDpagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `IDpost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT per la tabella `sottotema`
--
ALTER TABLE `sottotema`
  MODIFY `IDsottotema` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT per la tabella `stile`
--
ALTER TABLE `stile`
  MODIFY `IDstile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `tema`
--
ALTER TABLE `tema`
  MODIFY `IDtema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `IDutente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `autore`
--
ALTER TABLE `autore`
  ADD CONSTRAINT `Autore_ibfk_1` FOREIGN KEY (`IDblog`) REFERENCES `blog` (`IDblog`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Autore_ibfk_2` FOREIGN KEY (`IDutente`) REFERENCES `utente` (`IDutente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `Blog_ibfk_1` FOREIGN KEY (`IDstile`) REFERENCES `stile` (`IDstile`);

--
-- Limiti per la tabella `coautore`
--
ALTER TABLE `coautore`
  ADD CONSTRAINT `Coautore_ibfk_1` FOREIGN KEY (`IDautore`) REFERENCES `utente` (`IDutente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Coautore_ibfk_2` FOREIGN KEY (`IDblog`) REFERENCES `blog` (`IDblog`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `Commento_ibfk_1` FOREIGN KEY (`IDpost`) REFERENCES `post` (`IDpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Commento_ibfk_2` FOREIGN KEY (`IDutente`) REFERENCES `utente` (`IDutente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `giudizio`
--
ALTER TABLE `giudizio`
  ADD CONSTRAINT `Giudizio_ibfk_1` FOREIGN KEY (`IDpost`) REFERENCES `post` (`IDpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Giudizio_ibfk_2` FOREIGN KEY (`IDutente`) REFERENCES `utente` (`IDutente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `iscritto`
--
ALTER TABLE `iscritto`
  ADD CONSTRAINT `Iscritto_ibfk_1` FOREIGN KEY (`IDutente`) REFERENCES `utente` (`IDutente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Iscritto_ibfk_2` FOREIGN KEY (`IDblog`) REFERENCES `blog` (`IDblog`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `Like_ibfk_1` FOREIGN KEY (`IDutente`) REFERENCES `utente` (`IDutente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Like_ibfk_2` FOREIGN KEY (`IDcommento`) REFERENCES `commento` (`IDcommento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `Pagamento_ibfk_1` FOREIGN KEY (`IDutente`) REFERENCES `utente` (`IDutente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `Post_ibfk_1` FOREIGN KEY (`IDblog`) REFERENCES `blog` (`IDblog`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Post_ibfk_2` FOREIGN KEY (`IDutente`) REFERENCES `utente` (`IDutente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `sottotema`
--
ALTER TABLE `sottotema`
  ADD CONSTRAINT `Sottotema_ibfk_2` FOREIGN KEY (`macrotema`) REFERENCES `tema` (`IDtema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `temiblog`
--
ALTER TABLE `temiblog`
  ADD CONSTRAINT `Temiblog_ibfk_1` FOREIGN KEY (`IDblog`) REFERENCES `blog` (`IDblog`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Temiblog_ibfk_2` FOREIGN KEY (`IDtema`) REFERENCES `sottotema` (`IDsottotema`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
