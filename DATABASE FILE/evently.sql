-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2025 at 07:16 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evently`
--

-- --------------------------------------------------------

--
-- Table structure for table `allusers`
--

CREATE TABLE `allusers` (
  `ID` int(200) NOT NULL,
  `Firstname` varchar(200) NOT NULL,
  `Lastname` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Phone` int(200) NOT NULL,
  `ProfilePic` varchar(200) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Postalcode` int(200) NOT NULL,
  `Vendortype` varchar(200) NOT NULL,
  `Userrole` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `allusers`
--

INSERT INTO `allusers` (`ID`, `Firstname`, `Lastname`, `Email`, `Phone`, `ProfilePic`, `Address`, `Postalcode`, `Vendortype`, `Userrole`, `Password`) VALUES
(1, 'Admin', '', 'admin@gmail.com', 701959699, '', '', 0, '', 'Admin', '$2y$10$aFxXq8uCYZDlHki9.WIFguztkMEGFopkF6OniIFL/b07Ba8fAN96O'),
(2, 'Shane', 'Perera', 'wpshaneperera@gmail.com', 701959699, '../img/userPP/IMG_6079.jpg', '383/2, Mudukatuwa, Marawila', 61210, '', 'User', '$2y$10$aFxXq8uCYZDlHki9.WIFguztkMEGFopkF6OniIFL/b07Ba8fAN96O'),
(5, 'Shamane', 'Perera', 'shamaneperera95@gmail.com', 779279945, '../img/userPP/WhatsApp Image 2025-01-26 at 21.24.35_b2a8ad26.jpg', 'Narahenpita - Nawala Road', 10010, '', 'User', '$2y$10$PcshOa3LwyvkGBQnBOoxm.2tl4qP5Eb6FjiecdIL0UZtPifL02DZi'),
(10, 'Zyntera', 'Hotels', 'zyntera0@gmail.com', 707367355, '../img/vendorPP/zyntera logo 1.png', '230/1, pahala karagahamuna, kadawatha', 500, 'Hotel', 'Vendor', '$2y$10$PeHJDkvsFdj37zuSXlMNIOtDYHoOnwaOkX1Y0zRUmCcFFaux6h5AO'),
(11, 'Dilshan', 'Photography', 'dilshan@gmail.com', 777843448, '../img/vendorPP/professional-photographer.jpg', 'kadawatha - kiribathgoda', 40090, 'Photographer', 'Vendor', '$2y$10$O4fnB.Enc1mSkMUuwcGV7.W.XbHTtRjcWAGqguLZ6Hkxm1P6Q0cLS'),
(12, 'Nipun', 'DJ', 'nipun@yahoo.com', 777843448, '../img/vendorPP/52845257_653061131794006_4272377327096168448_n-1.jpg', '325, Negombo', 90675, 'Dj_Artist', 'Vendor', '$2y$10$MyBToVx.HzfyDFcCrNvY0ODGFwPFPUn4ElGL3Q0Lz.ZCP0mZFQ0QC'),
(13, 'Lyons', 'Perera', 'lyonsperera@gmail.com', 701545699, '../img/userPP/header.jpg', '383/2, Mudukatuwa, Marawila', 21061, '', 'User', '$2y$10$g23v9Wk.3KA.Ga3GGn.9wehHm4OTNIFx3ZvEEcbM4zgL7Jv0udJvi');

-- --------------------------------------------------------

--
-- Table structure for table `eventimages`
--

CREATE TABLE `eventimages` (
  `ID` int(200) NOT NULL,
  `Image` varchar(200) NOT NULL,
  `Date` date NOT NULL,
  `VendorID` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eventimages`
--

INSERT INTO `eventimages` (`ID`, `Image`, `Date`, `VendorID`) VALUES
(23, '../img/eventimages/foto-davids-bridal.jpg', '2025-02-13', 10),
(24, '../img/eventimages/hotels-with-private-pool-uga-ulagalla1-4034.jpg', '2025-02-13', 10),
(25, '../img/eventimages/52845257_653061131794006_4272377327096168448_n-1.jpg', '2025-02-13', 10),
(26, '../img/eventimages/heritance-two-mob.jpg', '2025-02-13', 10),
(27, '../img/eventimages/Florist-shop.jpg', '2025-02-13', 10),
(28, '../img/eventimages/professional-photographer.jpg', '2025-02-13', 10);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `ID` int(200) NOT NULL,
  `Eventname` varchar(200) NOT NULL,
  `Eventtype` varchar(200) NOT NULL,
  `EventDate` date NOT NULL,
  `EventTime` varchar(200) NOT NULL,
  `Location` varchar(200) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `UserID` int(200) NOT NULL,
  `EventCreated` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`ID`, `Eventname`, `Eventtype`, `EventDate`, `EventTime`, `Location`, `Description`, `UserID`, `EventCreated`) VALUES
(19, 'Family Party', 'Party', '2025-04-17', '18:30', 'marawila', 'Location - Marawila Beach Hotel\r\nTime - 6:30 pm', 2, '2025-03-24 14:26:39'),
(20, 'My Wedding	', 'Wedding', '2025-05-20', '08:00', 'colombo', 'No Description', 2, '2025-03-24 14:31:32'),
(21, 'School Get together', 'Community Gatherings', '2025-04-25', '19:00', 'colombo', 'No description', 5, '2025-04-01 11:41:55'),
(22, 'My Birthday', 'Birthday Party', '2025-06-20', '17:00', 'Nuwara Eliya', 'No description', 13, '2025-04-10 13:01:49'),
(24, 'Singing Competition', 'Corporate Conferences', '2025-05-14', '16:30', 'Cinnamon Grand Colombo', 'No description', 2, '2025-04-10 22:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `hiredvendors`
--

CREATE TABLE `hiredvendors` (
  `ID` int(200) NOT NULL,
  `Packagename` varchar(200) NOT NULL,
  `Packagetype` varchar(200) NOT NULL,
  `Packageamount` int(200) NOT NULL,
  `HiredDate` date NOT NULL,
  `PackageID` int(200) NOT NULL,
  `UserID` int(200) NOT NULL,
  `VendorID` int(200) NOT NULL,
  `EventID` int(200) NOT NULL,
  `Status` varchar(200) NOT NULL,
  `PaymentStatus` varchar(200) NOT NULL,
  `PaidAmount` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hiredvendors`
--

INSERT INTO `hiredvendors` (`ID`, `Packagename`, `Packagetype`, `Packageamount`, `HiredDate`, `PackageID`, `UserID`, `VendorID`, `EventID`, `Status`, `PaymentStatus`, `PaidAmount`) VALUES
(29, 'Silver', 'Home Coming', 80000, '2025-03-26', 6, 2, 10, 19, 'Completed', 'Paid Full Payment', 80000),
(31, 'Gold 2', 'weddingssss', 250000, '2025-03-27', 1, 2, 10, 20, 'Completed', 'Pending', 0),
(32, 'Budget Wedding Package', 'Wedding', 250000, '2025-03-27', 13, 2, 12, 19, 'Accepted', 'Paid Full Payment', 250000),
(40, 'Gold 2', 'weddingssss', 250000, '2025-04-03', 1, 5, 10, 21, 'Rejected', 'Pending', 0),
(41, 'Gold 2', 'weddingssss', 250000, '2025-04-03', 1, 5, 10, 21, 'Accepted', 'Pending', 0),
(42, 'Budget Wedding Package', 'Wedding', 250000, '2025-04-08', 13, 2, 12, 20, 'Pending', 'Pending', 0),
(43, 'Birthday packages', 'Birthday Party', 25000, '2025-04-10', 9, 13, 10, 22, 'Accepted', 'Pending', 0),
(44, 'Package 01', 'Party Shoot', 35000, '2025-04-10', 14, 2, 11, 19, 'Accepted', 'Paid Full Payment', 35000),
(45, 'Package 01', 'Party Shoot', 35000, '2025-04-10', 14, 2, 11, 24, 'Pending', 'Pending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invitedguests`
--

CREATE TABLE `invitedguests` (
  `ID` int(200) NOT NULL,
  `InvitedEmails` varchar(1000) NOT NULL,
  `Subject` varchar(200) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Attachments` varchar(500) NOT NULL,
  `InvitedDate` date NOT NULL,
  `UserID` int(200) NOT NULL,
  `EventID` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invitedguests`
--

INSERT INTO `invitedguests` (`ID`, `InvitedEmails`, `Subject`, `Description`, `Attachments`, `InvitedDate`, `UserID`, `EventID`) VALUES
(7, 'shamaneperera95@gmail.com', 'hello', 'jhjhjh', '../img/Invitation_Attachments/1135w-vGbKGZCCJUo.png', '2025-04-01', 2, 19),
(10, 'zyntera0@gmail.com,wpshaneperera@gmail.com', 'wedding 12345', 'come to wedding', '../uploads/Invitation_Attachments/1743574046_1135w-vGbKGZCCJUo.png', '2025-04-02', 2, 19),
(12, 'wpshaneperera@gmail.com', 'Bithday Party', 'Come to Party', '../uploads/Invitation_Attachments/1743574398_party-invitation-flyer-purple-organic-boho-1-1-c8dccf27dc6e.png', '2025-04-02', 2, 19),
(13, 'wpshaneperera@gmail.com', 'Bithday Party', 'Its My 25th Birthday, Hope you come', '../uploads/Invitation_Attachments/1743582513_party-invitation-flyer-purple-organic-boho-1-1-c8dccf27dc6e.png', '2025-04-02', 2, 19),
(14, 'saminimunasinghe@gmail.com', 'Our Wedding', '😁😁😁😁', '../uploads/Invitation_Attachments/1743584713_wedding card.png', '2025-04-02', 2, 19),
(15, 'minuraperera74@gmail.com,himeshofficial7@gmail.com,chenithkithnuka12345@gmail.com,adeesha.abeykoon16@gmail.com', 'Wedding Invitation', 'With great joy and hearts full of love,\r\nwe, the families of Chukka & Chukki,\r\ninvite you to celebrate the union of their souls.\r\n\r\nJoin us as we celebrate their love,\r\nthe beginning of their lifelong journey together.\r\n\r\nWedding Ceremony\r\nDate: 15th Of May 2025\r\nTime: 9.00 AM\r\nVenue: America\r\n\r\nYour presence will add to the joy of the occasion.\r\nWe look forward to celebrating this joyous moment with you.\r\n\r\nWith love,\r\nThe Families of Chukka & Chukki\r\n', '../uploads/Invitation_Attachments/1743585235_wedding card.png', '2025-04-02', 2, 19),
(18, 'wpshaneperera@gmail.com', 'My Wedding', 'Hope you will participate my wedding. Date, Time and Location is mentioned in attached wedding card.\r\n\r\nThank You.', '../uploads/Invitation_Attachments/1744305635_wedding card.png', '2025-04-10', 2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `userreports`
--

CREATE TABLE `userreports` (
  `ID` int(200) NOT NULL,
  `VendorID` int(200) NOT NULL,
  `UserID` int(200) NOT NULL,
  `Reason` varchar(500) NOT NULL,
  `AddedDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userreports`
--

INSERT INTO `userreports` (`ID`, `VendorID`, `UserID`, `Reason`, `AddedDate`) VALUES
(6, 10, 2, 'Violation of Event Policies', '2025-04-01'),
(7, 10, 5, 'Harassment or Misconduct', '2025-04-01'),
(8, 10, 5, 'Fake Profiles or Impersonation', '2025-04-10'),
(9, 10, 13, 'Harassment or Misconduct', '2025-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `vendorpackages`
--

CREATE TABLE `vendorpackages` (
  `ID` int(200) NOT NULL,
  `Packagename` varchar(200) NOT NULL,
  `Packagetype` varchar(200) NOT NULL,
  `Amount` int(200) NOT NULL,
  `Details` varchar(5000) NOT NULL,
  `Date` date NOT NULL,
  `VendorID` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendorpackages`
--

INSERT INTO `vendorpackages` (`ID`, `Packagename`, `Packagetype`, `Amount`, `Details`, `Date`, `VendorID`) VALUES
(1, 'Gold 2', 'weddingssss', 250000, 'halooooooooo', '2025-01-31', 10),
(6, 'Silver', 'Home Coming', 80000, 'ssss', '2025-01-29', 10),
(9, 'Birthday packages', 'Birthday Party', 25000, 'lorem Ipsum56', '2025-01-30', 10),
(12, 'test 2', 'rrrr', 80000, 'No description', '2025-02-22', 10),
(13, 'Budget Wedding Package', 'Wedding', 250000, 'No Description', '2025-03-27', 12),
(14, 'Package 01', 'Party Shoot', 35000, 'No description', '2025-04-10', 11);

-- --------------------------------------------------------

--
-- Table structure for table `vendorreviews`
--

CREATE TABLE `vendorreviews` (
  `ID` int(200) NOT NULL,
  `UserID` int(200) NOT NULL,
  `VendorID` int(200) NOT NULL,
  `EventID` int(200) NOT NULL,
  `Rating` int(200) NOT NULL,
  `ReviewText` varchar(1000) NOT NULL,
  `AddedDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendorreviews`
--

INSERT INTO `vendorreviews` (`ID`, `UserID`, `VendorID`, `EventID`, `Rating`, `ReviewText`, `AddedDate`) VALUES
(1, 2, 10, 19, 5, 'Had an amazing time hosting our party at Zyntera Hotels. The venue was elegant, and the lighting and sound system made for a great party vibe. The only minor issue was that service at the bar was a bit slow at peak times, but overall, a fantastic experience. Would definitely book again!', '2025-04-01'),
(2, 2, 10, 20, 4, 'From planning to execution, Zyntera Hotels made our wedding stress-free and magical. The event coordinators were so helpful, ensuring every detail was in place. The catering was exceptional, and the rooms for our guests were comfortable. Highly recommend this hotel for a wedding!', '2025-04-01'),
(5, 2, 10, 19, 4, 'Great Service !!!', '2025-04-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allusers`
--
ALTER TABLE `allusers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `eventimages`
--
ALTER TABLE `eventimages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `hiredvendors`
--
ALTER TABLE `hiredvendors`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `invitedguests`
--
ALTER TABLE `invitedguests`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userreports`
--
ALTER TABLE `userreports`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vendorpackages`
--
ALTER TABLE `vendorpackages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vendorreviews`
--
ALTER TABLE `vendorreviews`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allusers`
--
ALTER TABLE `allusers`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `eventimages`
--
ALTER TABLE `eventimages`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `hiredvendors`
--
ALTER TABLE `hiredvendors`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `invitedguests`
--
ALTER TABLE `invitedguests`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `userreports`
--
ALTER TABLE `userreports`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vendorpackages`
--
ALTER TABLE `vendorpackages`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vendorreviews`
--
ALTER TABLE `vendorreviews`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
