-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2018 at 06:54 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `activity_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_pub_faculties`
--

CREATE TABLE `book_pub_faculties` (
  `f_book_id` int(10) UNSIGNED NOT NULL,
  `ISBN` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authors` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_house` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_month` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_year` year(4) NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_pub_faculties`
--

INSERT INTO `book_pub_faculties` (`f_book_id`, `ISBN`, `faculty_id`, `book_name`, `authors`, `publication_house`, `publication_month`, `publication_year`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '978-0-12-381479-1', '6403658', 'Data Mining Concepts and Techniques', 'Kanu G. Patel, Micheline Kamber, Jian Pei', 'Pearson Education', '02', 2017, '2017-2018', 'odd', '1537951429.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `counselor_students`
--

CREATE TABLE `counselor_students` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `faculty_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `counselor_students`
--

INSERT INTO `counselor_students` (`sr_no`, `faculty_id`, `student_id`, `status`) VALUES
(1, '6403658', '15IT001', 1),
(2, '6403658', '15IT048', 1),
(3, '6403658', '15IT049', 1),
(4, '6403658', '15IT051', 1),
(5, '6403658', '15IT053', 1),
(6, '6403658', '15IT054', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `faculty_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_counselor` tinyint(4) NOT NULL DEFAULT '0',
  `department` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`faculty_id`, `name`, `email`, `contact_no`, `is_counselor`, `department`, `profile_image`, `password`, `is_verified`, `created_at`, `updated_at`) VALUES
('1226697', 'Darshak Gauravbhai Thakore', 'dgthakore@bvmengineering.ac.in', '7894563216', 0, 'Computer Engineering', NULL, '$2y$10$IURNKNR5BUS.3bRZJnST2OYDPAqBsfdWpA1zGy6nmk9pMBIlCWOfG', 1, '2018-09-25 12:03:27', '2018-09-25 12:04:06'),
('3865642', 'Ankit Mohanbhai Chovatiya', 'ankit@gmail.com', '8527419635', 0, 'Computer Engineering', NULL, '$2y$10$cJZKVGHUEud0bD3.S2YaFedUKIgzuHJrv/FKwWlydPKLS25g3dZQ6', 1, '2018-09-25 12:01:42', '2018-09-25 12:04:01'),
('4645370', 'Keyur Nayankumar Brahmbhatt', 'keyur.brahmbhatt@bvmengineering.ac.in', '9638527416', 0, 'Information Technology', NULL, '$2y$10$dVQnw7G8.65soZ..3b/3rOJUPfX3vWUoNe7LW3P2MwNA.gncCpxwq', 1, '2018-09-25 01:38:09', '2018-09-25 23:35:16'),
('6403658', 'Kanu G Patel', 'kanu.patel@bvmengineering.ac.in', '7418529635', 1, 'Information Technology', NULL, '$2y$10$7/tXprp.HZmuICQA4y69w.5gjMUSy1/lDVyDAQZCVAYX5MCvxGDyi', 1, '2018-09-25 01:35:22', '2018-09-25 23:36:27'),
('6466247', 'Zankhana H Shah', 'zankhana.shah@bvmengineering.ac.in', '9879275507', 0, 'Information Technology', NULL, '$2y$10$XgUUK52uOj.a4ADzjzmMQ.ik1FpghLtwvFb90PFTBMbuds.ba0pv.', 0, '2018-09-25 11:58:00', '2018-09-25 11:58:00'),
('7103270', 'Priyank N Bhojak', 'priyankbhojak@gmail.com', '9517538462', 0, 'Information Technology', NULL, '$2y$10$rkXd38sBakt4Wk./a5P/UuECQKlI8jNzuMV.d1ojB0EpCiydI6T/m', 1, '2018-09-25 11:47:22', '2018-09-25 23:35:17'),
('9350832', 'Nilesh B Prajapati', 'nilesh.prajapti@bvmengineering.ac.in', '8527419630', 0, 'Information Technology', NULL, '$2y$10$s.59sFutN87KGynMowgIt.jQvAmyd9PDzlE26icAJBAPa/dYfs8Ae', 1, '2018-09-25 11:57:09', '2018-09-25 23:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_attended_activities`
--

CREATE TABLE `faculty_attended_activities` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `faculty_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculty_attended_activities`
--

INSERT INTO `faculty_attended_activities` (`sr_no`, `faculty_id`, `type`, `topic`, `place`, `from_date`, `to_date`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '6403658', 'Seminar', 'Data mining and warehousing', 'G.H. PATEL Engineering College, Anand', '2018-09-04', '2018-09-04', '2018-2019', 'odd', '1537944000.pdf'),
(2, '6403658', 'Workshop', 'Internet Of Things', 'B.V.M. Engineering College, Anand', '2018-03-01', '2018-03-04', '2017-2018', 'even', '1537959891.pdf'),
(3, '9350832', 'Seminar', 'Seminar on Machine Learning', 'B.V.M. Engineering College, Anand', '2018-07-25', '2018-07-25', '2018-2019', 'odd', '1537960010.pdf'),
(4, '6403658', 'Expert Talk', 'Expert Talk on Artificial Intelligence', 'AIWorld Pvt Ltd, Mumbai', '2018-09-01', '2018-09-01', '2018-2019', 'odd', '1537961291.doc');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_organized_activities`
--

CREATE TABLE `faculty_organized_activities` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `faculty_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_of_activity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculty_organized_activities`
--

INSERT INTO `faculty_organized_activities` (`sr_no`, `faculty_id`, `type`, `title_of_activity`, `place`, `from_date`, `to_date`, `role`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '6403658', 'Seminar', 'Seminar on Algorithms & Data Structures', 'G.H. PATEL Engineering College, Anand', '2018-05-01', '2018-05-02', 'Presenter', '2017-2018', 'even', '1537944289.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `f_other_services`
--

CREATE TABLE `f_other_services` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `faculty_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_of_contribution` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `f_other_services`
--

INSERT INTO `f_other_services` (`sr_no`, `faculty_id`, `title_of_contribution`, `place`, `from_date`, `to_date`, `file`, `academic_year`, `academic_semester`) VALUES
(1, '6403658', 'MYSY Scholarship documents verifier', 'B.V.M. Engineering College, Anand', '2017-09-01', '2017-11-01', NULL, '2017-2018', 'odd');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_07_21_204608_create_students_table', 1),
(4, '2018_08_06_060330_create_faculties_table', 1),
(5, '2018_08_21_015232_create_counselor_students_table', 1),
(6, '2018_08_21_053904_create_student_organized_activities_table', 1),
(7, '2018_08_21_054310_create_student_attended_activities_table', 1),
(8, '2018_08_21_054750_create_f_other_services_table', 1),
(9, '2018_09_17_143649_create_training_internship_students_table', 1),
(10, '2018_09_21_201920_create_paper_pub_students_table', 1),
(11, '2018_09_21_201946_create_paper_pub_faculties_table', 1),
(12, '2018_09_21_203336_create_faculty_attended_activities_table', 1),
(13, '2018_09_21_203413_create_faculty_organized_activities_table', 1),
(14, '2018_09_21_203454_create_training_internship_faculties_table', 1),
(15, '2018_09_21_203529_create_book_pub_faculties_table', 1),
(16, '2018_09_21_203641_create_r_d_faculties_table', 1),
(17, '2018_09_23_182605_create_student_results_table', 1),
(18, '2018_09_26_085309_create_f_other_services_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `paper_pub_faculties`
--

CREATE TABLE `paper_pub_faculties` (
  `f_paper_id` int(10) UNSIGNED NOT NULL,
  `faculty_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ISSN` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ISBN` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DOI_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paper_title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conference_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `journal_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paper_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_or_presented` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `volume_and_issue` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_num` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `impact_factor` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publication_month` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_year` year(4) NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paper_pub_faculties`
--

INSERT INTO `paper_pub_faculties` (`f_paper_id`, `faculty_id`, `ISSN`, `ISBN`, `DOI_number`, `paper_title`, `conference_name`, `journal_name`, `paper_type`, `published_or_presented`, `volume_and_issue`, `page_num`, `impact_factor`, `publication_month`, `publication_year`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '6403658', '3568-9976', NULL, NULL, 'Automated Web Application Vulnerability Detection With Peneteration Testing', NULL, 'International Journal of Advance Research in Engineering, Science & Technology (IJAREST)', 'International', 'Published', 'Volume 3, Issue 6', '10-20', '4.123', '05', 2018, '2017-2018', 'odd', '1537951278.pdf'),
(2, '6403658', '3568-9875', '978-0-12-381479-2', '10.3352/jeehp.2015.10.3', 'CSRF Detection and Prevention in Web Application', NULL, 'International Journal of Advance Research in Engineering, Science & Technology (IJAREST)', 'International', 'Published and Presented', 'Volume 3, Issue 6', '10-20', '4.123', '02', 2014, '2014-2015', 'even', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paper_pub_students`
--

CREATE TABLE `paper_pub_students` (
  `s_paper_id` int(10) UNSIGNED NOT NULL,
  `student_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ISSN` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ISBN` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DOI_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paper_title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conference_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `journal_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paper_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_or_presented` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `volume_and_issue` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_num` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `impact_factor` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publication_month` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_year` year(4) NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paper_pub_students`
--

INSERT INTO `paper_pub_students` (`s_paper_id`, `student_id`, `ISSN`, `ISBN`, `DOI_number`, `paper_title`, `conference_name`, `journal_name`, `paper_type`, `published_or_presented`, `volume_and_issue`, `page_num`, `impact_factor`, `publication_month`, `publication_year`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '15IT054', '3568-9876', '978-0-12-381479-1', '10.3352/jeehp.2013.10.3', 'SQL Injection Detection and Prevention in Web Application', NULL, 'International Journal of Advance Research in Engineering, Science & Technology (IJAREST)', 'Published', '2', 'Volume 3, Issue 6', '10-20', '4.123', '05', 2016, '2015-2016', 'even', '1537943575.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r_d_faculties`
--

CREATE TABLE `r_d_faculties` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `faculty_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_letter_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `funding_agency` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PI` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CI` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `r_d_faculties`
--

INSERT INTO `r_d_faculties` (`sr_no`, `faculty_id`, `description`, `approval_letter_no`, `funding_agency`, `amount`, `PI`, `CI`, `from_date`, `to_date`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '6403658', 'Research on Web Scrapping', '9876543', 'Department of Electronics and Information Technology', '100000', 'Michael Maroney', 'Mason Lowance', '2016-06-01', '2018-06-01', '2017-2018', 'even', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enrollment_no` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admission_year` year(4) NOT NULL,
  `department` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admission_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `email`, `enrollment_no`, `contact_no`, `admission_year`, `department`, `admission_type`, `profile_image`, `password`, `is_verified`, `created_at`, `updated_at`) VALUES
('15EE014', 'Shubham Rameshbhai dabhi', 'srdabhi@gmail.com', '150080114058', '7894561230', 2015, 'Electrical Engineering', 'REGULAR', NULL, '$2y$10$HF8dY7QKl3NDE7wcZYg0l.v2S1wXV5ElWxDy.2yDJhzOnuSdSHjgm', 0, '2018-09-25 12:08:30', '2018-09-25 12:08:30'),
('15IT001', 'Raj K Ambani', 'rajambani@gmail.com', '150080116003', '8529637410', 2015, 'Information Technology', 'REGULAR', NULL, '$2y$10$8JVC.LQi33YiNrRUdTam/O2OvcGZVZNZBCX3AVczT9Qw/QR1KRx2e', 1, '2018-09-25 12:05:39', '2018-09-25 23:35:32'),
('15IT048', 'Raj K Kadhi', 'rajkadhi@gmail.com', '150080116046', '8527496351', 2015, 'Information Technology', 'REGULAR', NULL, '$2y$10$mDlIPkafekCHwvWa6nEd0epQ5GubrMiFj1hqzId5fMemwsjF69v1e', 1, '2018-09-25 12:09:25', '2018-09-25 23:35:30'),
('15IT049', 'Rahul M Mehta', 'rahulmehta@gmail.com', '150080116042', '7539514862', 2015, 'Information Technology', 'REGULAR', NULL, '$2y$10$0QsokFYjgthr5rzTphtpf.nJ0aY9fmDBvZQY2KSBuZNKwd.D2sEG2', 1, '2018-09-25 12:10:32', '2018-09-25 23:35:29'),
('15IT051', 'Brijesh Rameshbhai Lakkad', 'brijesh@gmail.com', '150080116057', '9865231470', 2015, 'Information Technology', 'REGULAR', NULL, '$2y$10$cTJBmibRJBm0pRpPXzG88utTEBGFyvRRJ8dwENbfR.l2zZSIWonea', 1, '2018-09-25 12:06:53', '2018-09-25 23:35:31'),
('15IT053', 'Mitul Girdharbhai Chovatiya', 'mitulgchovatiya@gmail.com', '150080116006', '7744556622', 2015, 'Information Technology', 'REGULAR', NULL, '$2y$10$npBEBUS6mCX7w.6if5cKm.WGJjWz7N.PciYOI5QTNoemCaA7aAbNm', 1, '2018-09-25 12:11:34', '2018-09-25 23:35:29'),
('15IT054', 'Nimesh Jayantibhai Vaghasiya', 'nimeshvaghasiya98@gmail.com', '150080116059', '7573883936', 2015, 'Information Technology', 'REGULAR', NULL, '$2y$10$0dYQg4p2t2KzWMKEAJGF3.Dxkfrr361Hm0uomG58EnwApwAjP6U8q', 1, '2018-09-25 01:44:25', '2018-09-25 23:35:34'),
('16IT001', 'Yash Rajeshbhai Sohagiya', 'yashsohagiya@gmail.com', '160083116001', '9876543001', 2016, 'Information Technology', 'REGULAR', NULL, '$2y$10$yer9fKzs7O314KzwFwY5i./BR5Xtnb543i4rpimiXTaFUv8YYlB.e', 1, '2018-09-25 12:12:50', '2018-09-25 23:35:28'),
('16IT604', 'Vinit Mohanbhai Dabhi', 'vinitdabhi6626@gmail.com', '160083116003', '8460371509', 2016, 'Information Technology', 'D2D', NULL, '$2y$10$K9as2bihsHbSrLXyyCSv2.N/sngwF3as1mNKFguR.uUOGo4YL5Hcm', 1, '2018-09-25 12:13:56', '2018-09-25 23:35:27'),
('17IT001', 'Neel Jayeshbhai Savani', 'neelsavani@gmail.com', '170083116001', '9876540001', 2017, 'Information Technology', 'REGULAR', NULL, '$2y$10$kxaw7TMmzMths04A1nq3LuznNg0ZugDHnnnD2uZPBYJGj2yRH/zX2', 1, '2018-09-25 12:29:54', '2018-09-25 23:35:25');

-- --------------------------------------------------------

--
-- Table structure for table `student_attended_activities`
--

CREATE TABLE `student_attended_activities` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `student_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_attended_activities`
--

INSERT INTO `student_attended_activities` (`sr_no`, `student_id`, `type`, `topic`, `place`, `from_date`, `to_date`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '15IT054', 'Workshop', 'Workshop on Android', 'B.V.M. Engineering College, Anand', '2018-09-03', '2018-09-09', '2018-2019', 'odd', '1537941431.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `student_organized_activities`
--

CREATE TABLE `student_organized_activities` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `student_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_of_activity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_organized_activities`
--

INSERT INTO `student_organized_activities` (`sr_no`, `student_id`, `type`, `title_of_activity`, `place`, `from_date`, `to_date`, `role`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '15IT054', 'Seminar', 'Seminar on Modern Web Development', 'B.V.M. Engineering College, Anand', '2018-09-01', '2018-09-01', 'Presenter', '2018-2019', 'odd', '1537941832.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `student_results`
--

CREATE TABLE `student_results` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `student_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spi_sem1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpi_sem1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spi_sem2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpi_sem2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spi_sem3` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpi_sem3` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spi_sem4` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpi_sem4` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spi_sem5` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpi_sem5` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spi_sem6` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpi_sem6` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spi_sem7` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpi_sem7` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spi_sem8` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpi_sem8` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_results`
--

INSERT INTO `student_results` (`sr_no`, `student_id`, `spi_sem1`, `cpi_sem1`, `spi_sem2`, `cpi_sem2`, `spi_sem3`, `cpi_sem3`, `spi_sem4`, `cpi_sem4`, `spi_sem5`, `cpi_sem5`, `spi_sem6`, `cpi_sem6`, `spi_sem7`, `cpi_sem7`, `spi_sem8`, `cpi_sem8`) VALUES
(1, '15IT054', '8.14', '8.14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `training_internship_faculties`
--

CREATE TABLE `training_internship_faculties` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `faculty_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `training_or_internship` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training_internship_faculties`
--

INSERT INTO `training_internship_faculties` (`sr_no`, `faculty_id`, `training_or_internship`, `title`, `place`, `from_date`, `to_date`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '6403658', 'Training', 'Internet Of Things', 'IOTWorld Pvt Ltd, Ahmedabad', '2018-06-01', '2018-06-30', '2017-2018', 'even', '1537950859.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `training_internship_students`
--

CREATE TABLE `training_internship_students` (
  `sr_no` int(10) UNSIGNED NOT NULL,
  `student_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `training_or_internship` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `academic_year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training_internship_students`
--

INSERT INTO `training_internship_students` (`sr_no`, `student_id`, `training_or_internship`, `title`, `place`, `from_date`, `to_date`, `academic_year`, `academic_semester`, `file`) VALUES
(1, '15IT054', 'Training', 'Laravel Framework with AngularJS and jQuery', 'Alphaved Pvt Ltd, Surat', '2018-06-01', '2018-06-15', '2017-2018', 'even', '1537942536.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `admin_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`admin_id`, `name`, `email`, `contact_no`, `department`, `profile_image`, `password`, `is_verified`, `created_at`, `updated_at`) VALUES
('8951614', 'Darshak Gauravbhai Thakore', 'dgthakore@bvmengineering.ac.in', '7894563216', 'Computer Engineering', NULL, '$2y$10$VFQmL49gf6Y7oIrYfkn9le7DfPj3rxXYpUiC8EiyrLe2KJ8GgPeJy', 0, '2018-09-25 12:03:27', '2018-09-25 12:03:27'),
('9134929', 'Keyur Nayankumar Brahmbhatt', 'keyur.brahmbhatt@bvmengineering.ac.in', '9638527416', 'Information Technology', NULL, '$2y$10$qNmAQTqaOpZPmeR6sWY6zOd9b.lxK3Ca1WuaNxZQWFxSIjtiPfWPS', 0, '2018-09-25 01:38:09', '2018-09-25 01:38:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_pub_faculties`
--
ALTER TABLE `book_pub_faculties`
  ADD PRIMARY KEY (`f_book_id`),
  ADD KEY `book_pub_faculties_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `counselor_students`
--
ALTER TABLE `counselor_students`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `counselor_students_faculty_id_foreign` (`faculty_id`),
  ADD KEY `counselor_students_student_id_foreign` (`student_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `faculties_email_unique` (`email`),
  ADD UNIQUE KEY `faculties_contact_no_unique` (`contact_no`);

--
-- Indexes for table `faculty_attended_activities`
--
ALTER TABLE `faculty_attended_activities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `faculty_attended_activities_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `faculty_organized_activities`
--
ALTER TABLE `faculty_organized_activities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `faculty_organized_activities_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `f_other_services`
--
ALTER TABLE `f_other_services`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `f_other_services_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paper_pub_faculties`
--
ALTER TABLE `paper_pub_faculties`
  ADD PRIMARY KEY (`f_paper_id`),
  ADD KEY `paper_pub_faculties_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `paper_pub_students`
--
ALTER TABLE `paper_pub_students`
  ADD PRIMARY KEY (`s_paper_id`),
  ADD KEY `paper_pub_students_student_id_foreign` (`student_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `r_d_faculties`
--
ALTER TABLE `r_d_faculties`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `r_d_faculties_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `students_email_unique` (`email`),
  ADD UNIQUE KEY `students_contact_no_unique` (`contact_no`);

--
-- Indexes for table `student_attended_activities`
--
ALTER TABLE `student_attended_activities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `student_attended_activities_student_id_foreign` (`student_id`);

--
-- Indexes for table `student_organized_activities`
--
ALTER TABLE `student_organized_activities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `student_organized_activities_student_id_foreign` (`student_id`);

--
-- Indexes for table `student_results`
--
ALTER TABLE `student_results`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `student_results_student_id_foreign` (`student_id`);

--
-- Indexes for table `training_internship_faculties`
--
ALTER TABLE `training_internship_faculties`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `training_internship_faculties_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `training_internship_students`
--
ALTER TABLE `training_internship_students`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `training_internship_students_student_id_foreign` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_contact_no_unique` (`contact_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_pub_faculties`
--
ALTER TABLE `book_pub_faculties`
  MODIFY `f_book_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `counselor_students`
--
ALTER TABLE `counselor_students`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faculty_attended_activities`
--
ALTER TABLE `faculty_attended_activities`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faculty_organized_activities`
--
ALTER TABLE `faculty_organized_activities`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `f_other_services`
--
ALTER TABLE `f_other_services`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `paper_pub_faculties`
--
ALTER TABLE `paper_pub_faculties`
  MODIFY `f_paper_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `paper_pub_students`
--
ALTER TABLE `paper_pub_students`
  MODIFY `s_paper_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `r_d_faculties`
--
ALTER TABLE `r_d_faculties`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_attended_activities`
--
ALTER TABLE `student_attended_activities`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_organized_activities`
--
ALTER TABLE `student_organized_activities`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_results`
--
ALTER TABLE `student_results`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `training_internship_faculties`
--
ALTER TABLE `training_internship_faculties`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `training_internship_students`
--
ALTER TABLE `training_internship_students`
  MODIFY `sr_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_pub_faculties`
--
ALTER TABLE `book_pub_faculties`
  ADD CONSTRAINT `book_pub_faculties_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `counselor_students`
--
ALTER TABLE `counselor_students`
  ADD CONSTRAINT `counselor_students_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`),
  ADD CONSTRAINT `counselor_students_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `faculty_attended_activities`
--
ALTER TABLE `faculty_attended_activities`
  ADD CONSTRAINT `faculty_attended_activities_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `faculty_organized_activities`
--
ALTER TABLE `faculty_organized_activities`
  ADD CONSTRAINT `faculty_organized_activities_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `f_other_services`
--
ALTER TABLE `f_other_services`
  ADD CONSTRAINT `f_other_services_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `paper_pub_faculties`
--
ALTER TABLE `paper_pub_faculties`
  ADD CONSTRAINT `paper_pub_faculties_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `paper_pub_students`
--
ALTER TABLE `paper_pub_students`
  ADD CONSTRAINT `paper_pub_students_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `r_d_faculties`
--
ALTER TABLE `r_d_faculties`
  ADD CONSTRAINT `r_d_faculties_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `student_attended_activities`
--
ALTER TABLE `student_attended_activities`
  ADD CONSTRAINT `student_attended_activities_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `student_organized_activities`
--
ALTER TABLE `student_organized_activities`
  ADD CONSTRAINT `student_organized_activities_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `student_results`
--
ALTER TABLE `student_results`
  ADD CONSTRAINT `student_results_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `training_internship_faculties`
--
ALTER TABLE `training_internship_faculties`
  ADD CONSTRAINT `training_internship_faculties_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `training_internship_students`
--
ALTER TABLE `training_internship_students`
  ADD CONSTRAINT `training_internship_students_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
