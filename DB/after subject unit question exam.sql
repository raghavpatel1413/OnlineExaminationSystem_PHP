-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2018 at 06:21 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_examination_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_name` varchar(25) DEFAULT NULL,
  `admin_email` varchar(50) DEFAULT NULL,
  `admin_login_pwd` varchar(40) DEFAULT NULL,
  `admin_hash` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_name`, `admin_email`, `admin_login_pwd`, `admin_hash`) VALUES
('admin', 'admin@admin.com', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '64e1b8d34f425d19e1ee2ea7236d3028');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `course_details` varchar(500) DEFAULT NULL,
  `course_total_sem` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`course_id`, `course_name`, `course_details`, `course_total_sem`, `department_id`) VALUES
(1, 'Int. M.Sc.IT', 'Integrated Master of Science in Information Technology', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(50) DEFAULT NULL,
  `department_details` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`department_id`, `department_name`, `department_details`) VALUES
(1, 'BMIIT', 'Babu Madhav Institute of Information Technology'),
(2, 'CGPIT', 'Chhotubhai Gopalbhai Patel Institute of Technology');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_director`
--

CREATE TABLE `tbl_director` (
  `director_id` int(11) NOT NULL,
  `director_name` varchar(50) DEFAULT NULL,
  `director_email` varchar(50) DEFAULT NULL,
  `director_cno` bigint(20) DEFAULT NULL,
  `director_address` varchar(500) DEFAULT NULL,
  `director_gender` varchar(6) DEFAULT NULL,
  `director_dob` date DEFAULT NULL,
  `director_login_pwd` varchar(40) DEFAULT NULL,
  `director_hash` varchar(32) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_director`
--

INSERT INTO `tbl_director` (`director_id`, `director_name`, `director_email`, `director_cno`, `director_address`, `director_gender`, `director_dob`, `director_login_pwd`, `director_hash`, `department_id`) VALUES
(1, 'DR. JITENDRA NASRIWALA', 'jvnasriwala@mailinator.com', 9825518405, 'Surat', 'male', '1987-01-04', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '5d33b5aa6376cea1aadfed3c0f59b2fe', 1),
(2, 'Purvi H. Tandel', 'purvi.tandel@mailinator.com', 9879746432, 'Surat', 'female', '2018-05-03', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '2cc79d96fa9256245c11f4fb5a84fe4b', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_equestion_attempted`
--

CREATE TABLE `tbl_equestion_attempted` (
  `eqa_id` int(11) NOT NULL,
  `equestion_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `exam_student_id` int(11) DEFAULT NULL,
  `isright` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_equestion_attempted`
--

INSERT INTO `tbl_equestion_attempted` (`eqa_id`, `equestion_id`, `option_id`, `exam_student_id`, `isright`) VALUES
(1, 1, 3, 1, 1),
(2, 2, 7, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_equestion_inputed`
--

CREATE TABLE `tbl_equestion_inputed` (
  `eqi_id` int(11) NOT NULL,
  `equestion_id` int(11) DEFAULT NULL,
  `answer_desc` varchar(250) DEFAULT NULL,
  `exam_student_id` int(11) DEFAULT NULL,
  `isright` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_equestion_inputed`
--

INSERT INTO `tbl_equestion_inputed` (`eqi_id`, `equestion_id`, `answer_desc`, `exam_student_id`, `isright`) VALUES
(1, 3, '1972', 1, 1),
(2, 4, 'b', 1, 1),
(3, 5, '10L', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam`
--

CREATE TABLE `tbl_exam` (
  `exam_id` int(11) NOT NULL,
  `exam_date_create` date DEFAULT NULL,
  `exam_date_start` date DEFAULT NULL,
  `exam_start_time` time DEFAULT NULL,
  `exam_total_time` time DEFAULT NULL,
  `exam_total_marks` int(11) DEFAULT NULL,
  `exam_passing_marks` int(11) DEFAULT NULL,
  `faculty_by_subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_exam`
--

INSERT INTO `tbl_exam` (`exam_id`, `exam_date_create`, `exam_date_start`, `exam_start_time`, `exam_total_time`, `exam_total_marks`, `exam_passing_marks`, `faculty_by_subject_id`) VALUES
(1, '2018-05-04', '2018-05-04', '21:41:00', '00:12:00', 9, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam_question`
--

CREATE TABLE `tbl_exam_question` (
  `equestion_id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_exam_question`
--

INSERT INTO `tbl_exam_question` (`equestion_id`, `exam_id`, `question_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam_student`
--

CREATE TABLE `tbl_exam_student` (
  `exam_student_id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `student_by_course_id` int(11) DEFAULT NULL,
  `obtained_marks` int(11) DEFAULT NULL,
  `exam_start_time` time DEFAULT NULL,
  `exam_end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_exam_student`
--

INSERT INTO `tbl_exam_student` (`exam_student_id`, `exam_id`, `student_by_course_id`, `obtained_marks`, `exam_start_time`, `exam_end_time`) VALUES
(1, 1, 1, 9, '21:43:00', '21:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faculty`
--

CREATE TABLE `tbl_faculty` (
  `faculty_id` int(11) NOT NULL,
  `faculty_fname` varchar(25) DEFAULT NULL,
  `faculty_mname` varchar(25) DEFAULT NULL,
  `faculty_lname` varchar(25) DEFAULT NULL,
  `faculty_email` varchar(50) DEFAULT NULL,
  `faculty_cno` bigint(20) DEFAULT NULL,
  `faculty_gender` varchar(6) DEFAULT NULL,
  `faculty_dob` date DEFAULT NULL,
  `faculty_address` varchar(500) DEFAULT NULL,
  `faculty_login_pwd` varchar(40) DEFAULT NULL,
  `faculty_hash` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_faculty`
--

INSERT INTO `tbl_faculty` (`faculty_id`, `faculty_fname`, `faculty_mname`, `faculty_lname`, `faculty_email`, `faculty_cno`, `faculty_gender`, `faculty_dob`, `faculty_address`, `faculty_login_pwd`, `faculty_hash`) VALUES
(1, 'Preeti', 'P', 'Bhatt', 'preeti.bhatt@mailinator.com', 1234567890, 'female', '1991-01-01', 'Navsari', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '9b6887b3ce4e76985f7c7828fd100aef'),
(2, 'Sandip', '.', 'Delwadkar', 'sandip.delwadkar@mailinator.com', 1234567890, 'male', '1983-02-10', 'Bardoli', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '0a38b4a8af744eef7a90226b636f0866'),
(3, 'Hardik', 'A', 'Vyas', 'hardik.vyas@mailinator.com', 1234567890, 'male', '1983-01-04', 'Bardoli', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', 'd3892d0036671eda4528c09e4d2fe3fa'),
(4, 'Bhumika', '.', 'Patel', 'bhumika.patel@mailinator.com', 1234567890, 'female', '1988-02-03', 'Surat', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '519cf74cf8d86c8b4bdd2b2d58f2f403'),
(5, 'Manish', 'H', 'Vala', 'manish.vala@mailinator.com', 1234567890, 'male', '1985-02-06', 'Bardoli', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '68e1424c9dbd976129895a9955714d30'),
(6, 'Sandip', 'J', 'Naik', 'sapanjnaik@mailinator.com', 9879288610, 'male', '1988-02-10', 'Navsari', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '1c6371453547238f6da380d217e5954e'),
(7, 'JUHI', '.', 'Patel', 'juhipatel@mailinator.com', 1234567890, 'female', '1987-02-04', 'Bardoli', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '370c8ec3d34063cae89a8e847354c951'),
(8, 'Hinal', 'v', 'Shah', 'hinal.vshah@mailinator.com', 1234567890, 'female', '1994-02-18', 'Surat', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', 'c7957bc1a7179fd02292d9f5fbd57979');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faculty_subject`
--

CREATE TABLE `tbl_faculty_subject` (
  `faculty_by_subject_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_faculty_subject`
--

INSERT INTO `tbl_faculty_subject` (`faculty_by_subject_id`, `faculty_id`, `subject_code`) VALUES
(1, 1, 60010109),
(2, 2, 60010310),
(3, 3, 60010308);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_option`
--

CREATE TABLE `tbl_option` (
  `option_id` int(11) NOT NULL,
  `option_desc` varchar(500) DEFAULT NULL,
  `option_correct` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_option`
--

INSERT INTO `tbl_option` (`option_id`, `option_desc`, `option_correct`, `question_id`) VALUES
(1, 'C Programming and Techniques', 0, 1),
(2, 'Thinking in C', 0, 1),
(3, 'The C Programming Language', 1, 1),
(4, 'Learn C Step By Step', 0, 1),
(5, 'C Programming for Scientist', 0, 1),
(6, 'Stanford Lab', 0, 2),
(7, 'AT&T Bell Laboratory', 1, 2),
(8, '1972', 1, 3),
(9, 'b', 1, 4),
(10, '10L', 1, 5),
(11, 'Error', 1, 6),
(12, '11', 0, 6),
(13, 'Error', 1, 7),
(14, 'Successfully compile', 0, 7),
(15, 'int main(int argc, char *argv[])', 1, 8),
(16, 'int char main(int argc, *argv)', 0, 8),
(17, 'None of the above', 0, 8),
(18, 'Which of the following true about FILE *fp', 0, 9),
(19, 'FILE is a structure and fp is a pointer to the structure of FILE type', 1, 9),
(20, 'FILE is a stream', 0, 9),
(21, 'FILE is a buffered stream', 0, 9),
(22, 'No one', 0, 9),
(23, 'all above', 0, 9),
(24, 'depend on compiler', 0, 9),
(25, 'depend on hardware', 0, 9),
(26, 'depend of os', 0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question`
--

CREATE TABLE `tbl_question` (
  `question_id` int(11) NOT NULL,
  `question_desc` varchar(500) DEFAULT NULL,
  `question_level` int(11) DEFAULT NULL,
  `question_marks` int(11) DEFAULT NULL,
  `question_type` int(11) DEFAULT NULL,
  `subject_code` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_question`
--

INSERT INTO `tbl_question` (`question_id`, `question_desc`, `question_level`, `question_marks`, `question_type`, `subject_code`, `unit_id`) VALUES
(1, 'Dennis Was Author of Famous Programming Book _________ .', 1, 1, 1, 60010109, 1),
(2, 'C Programming was created at ______ by Dennis Ritchie.', 1, 1, 1, 60010109, 1),
(3, 'C Programming was created in Year _______ .', 1, 1, 2, 60010109, 1),
(4, 'Many features of C were derived from an earlier language called _____.', 1, 1, 2, 60010109, 1),
(5, 'What will be the output of following program ?\r\n#include <stdio.h>\r\nint main()\r\n{\r\n    int a=10;\r\n    if(10L == a)\r\n        printf(\"10L\");\r\n    else if(10==a)\r\n        printf(\"10\");\r\n    else\r\n        printf(\"0\");\r\n    return 0;\r\n}', 1, 5, 2, 60010109, 2),
(6, '# include <stdio.h>\r\nint main()\r\n{\r\n   int i = 0;\r\n   for (i=0; i<20; i++)\r\n   {\r\n     switch(i)\r\n     {\r\n       case 0:\r\n         i += 5;\r\n       case 1:\r\n         i += 2;\r\n       case 5:\r\n         i += 5;\r\n       default:\r\n         i += 4;\r\n         break;\r\n     }\r\n     printf(i);\r\n   }\r\n   return 0;\r\n}', 3, 5, 1, 60010109, 3),
(7, '#include <stdio.h>\r\n \r\nint main()\r\n{\r\n    int arr[5];\r\n    // Assume base address of arr is 2000 and size of integer is 32 bit\r\n    printf(\"%u %u\", arr + 1, &arr + 1);\r\n \r\n    return 0;\r\n} ', 2, 10, 1, 60010109, 4),
(8, 'According to ANSI specification, how to declare main () function with command-line arguments?', 1, 2, 1, 60010109, 5),
(9, 'Which of the following true about FILE *fp', 1, 7, 1, 60010109, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sem`
--

CREATE TABLE `tbl_sem` (
  `sem_id` int(11) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `sem_year` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sem`
--

INSERT INTO `tbl_sem` (`sem_id`, `semester`, `sem_year`) VALUES
(1, 1, 2018),
(2, 2, 2018),
(3, 3, 2018),
(4, 4, 2018),
(5, 5, 2018),
(6, 6, 2018),
(7, 7, 2018),
(8, 8, 2018),
(9, 9, 2018),
(10, 10, 2018);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `student_id` int(11) NOT NULL,
  `student_enroll_no` bigint(20) DEFAULT NULL,
  `student_fname` varchar(25) DEFAULT NULL,
  `student_mname` varchar(25) DEFAULT NULL,
  `student_lname` varchar(25) DEFAULT NULL,
  `student_gender` varchar(6) DEFAULT NULL,
  `student_dob` date DEFAULT NULL,
  `student_email` varchar(50) DEFAULT NULL,
  `student_address` varchar(500) DEFAULT NULL,
  `student_login_pwd` varchar(40) DEFAULT NULL,
  `student_hash` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`student_id`, `student_enroll_no`, `student_fname`, `student_mname`, `student_lname`, `student_gender`, `student_dob`, `student_email`, `student_address`, `student_login_pwd`, `student_hash`) VALUES
(1, 201506100110025, 'Raghav ', 'S', 'Patel', 'male', '1997-08-21', 'raghavpatel1413@mailinator.com', 'Dindoli, Surat.', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', 'c39d991f3a2ab0eb572c4dfa8d5250fa'),
(2, 201506100110033, 'Jaymin', 'J', 'Patel', 'male', '2018-05-04', 'jayminjpatel@mailinator.com', 'Surat', 'af21e6b1f23ee9356b4b0d8addf13e9a59750718', '5c71183eb7628d77baeb14234ec318a4');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_by_course`
--

CREATE TABLE `tbl_student_by_course` (
  `student_by_course_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `sem_id` int(11) DEFAULT NULL,
  `student_div` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student_by_course`
--

INSERT INTO `tbl_student_by_course` (`student_by_course_id`, `course_id`, `student_id`, `sem_id`, `student_div`) VALUES
(1, 1, 1, 1, 'A'),
(2, 1, 2, 3, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE `tbl_subject` (
  `subject_code` int(11) NOT NULL,
  `subject_name` varchar(50) DEFAULT NULL,
  `subject_details` varchar(500) DEFAULT NULL,
  `total_unit` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `sem_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`subject_code`, `subject_name`, `subject_details`, `total_unit`, `course_id`, `sem_id`) VALUES
(60010109, 'Fundamentals of Programming', 'To introduce the fundamentals of programming concepts, methodology and enforce logical thinking, to design and develop algorithm along with familiarity with problem solving techniques.\r\n', 5, 1, 1),
(60010110, 'Mathematics for Computer Applications', 'To introduce the need of database systems, data modelling and database designing, and to make use of SQL for efficient storage and retrieval of data\r\n', 6, 1, 1),
(60010111, 'Computer Fundamentals and Organization', 'To understand the fundamentals of computer organization, memory organization and working of devices.', 6, 1, 1),
(60010112, 'Mathematics for Computer Applications', 'To provide foundation of data representation, to understand its logical implementation and to teach mathematical concepts to understand their applications in computer domain.', 6, 1, 1),
(60010113, 'PROFESSIONAL COMMUNICATION', 'To develop communication and employability skills of the students to face the present competitive world.\r\n', 1, 1, 1),
(60010209, 'Relational Data Base Management System', 'Relational Data Base Management System', 5, 1, 2),
(60010210, 'Object Oriented Programming', '060010210 â€“ CC5 Object Oriented Programming', 6, 1, 2),
(60010211, 'Digital Electronics', '060010211 -CC6 Digital Electronics', 6, 1, 2),
(60010212, 'Advanced Mathematics for Computer Applications', '060010212 -DSE2 Advanced Mathematics for Computer Applications', 6, 1, 2),
(60010213, 'Environmental Studies', '060010213 -AECC2 Environmental Studies', 6, 1, 2),
(60010308, 'Data Structures', 'This course strives to strengthen student ability to solve problems computationally by utilizing an understanding of algorithm analysis and various Data Structures like Stack, Queue, Linked list, tree, and Sorting & searching methods.', 6, 1, 3),
(60010309, 'Microprocessor Programming and Interfacing', 'The course provides depth knowledge about 8086 processor architecture & itâ€™s working, assembly language programming, memory interfacing & peripheral devices.', 6, 1, 3),
(60010310, 'Computer Networks', 'The objective of this course is to provide concrete fundamental concepts of computer networking and brief knowledge of mechanisms and protocols used for communication over the network.', 6, 1, 3),
(60010311, 'Operating Systems', 'To familiarized with the knowledge of processes, memory management, I/O, scheduling algorithm and file systems of an operating system.', 6, 1, 3),
(60010312, 'Software Engineering', 'To provide concepts, methodologies, techniques and tools essential for systemâ€™s analysts and designers to successfully develop information systems using object-oriented modeling and methodology..', 6, 1, 3),
(60010408, 'GUI Programming', 'To provide fundamentals of .NET framework, C# language and to introduce development of rich windows form applications with event driven programming model.', 6, 1, 4),
(60010409, 'Java Programming', 'To make student develop Java program using object oriented concepts namely classes and object, inheritance, polymorphism, interface, package, String class, collections and exception handling. ', 6, 1, 4),
(60010410, 'Linux and Shell Programming', 'To provide basic concept and skill to work in LINUX/UNIX environment with comprehensive capability to develop and customize LINUX/UNIX shell programs.\r\n', 6, 1, 4),
(60010411, 'Fundamental of Operating System', 'To acquaint the fundamental knowledge of Cyber security, be familiar with various security attacks and mechanisms, digital forensics and career in cyber security. ', 6, 1, 4),
(60010412, 'Fundamentals of Computer Networks', 'To enable students to become familiar with basics of telecommunication system & satellite communication', 6, 1, 4),
(60010507, 'Advanced Java', 'To understand and develop GUI based application and web based application using threaded class, AWT controls, Swing controls and server side technologies. ', 6, 1, 5),
(60010508, 'Web Development using MVC', 'To provide in-depth knowledge of developing dynamic, secure and rich web application in conjunction with event handling, state management and data access using MVC architecture.', 6, 1, 5),
(60010509, 'Information Security ', 'To understand basic terminologies of Information security, correlate symmetric key cryptography and public key cryptography, usage of hash function and study basics of authentication methods and authorization.', 6, 1, 5),
(60010510, 'Programming in Python', 'To understand the basic concepts of Python programming, use its standard libraries, explore and use its extensible modules.', 6, 1, 5),
(60010511, 'Multimedia Applications', 'To study the multimedia concepts and technologies and to enable the student to develop their creativity', 6, 1, 5),
(60010606, 'Web Development using Java Frameworks', 'To make the students understand the role and importance of Java Framework.', 6, 1, 6),
(60010607, 'Software Project Management', 'To enable students to learn Capability Maturity Model, relate CMM with project processes and examining various stages in the life cycle of a typical software project.', 6, 1, 6),
(60010608, 'Introduction of Mobile Application Development', '060010608-SEC3 Introduction of Mobile Application Development', 6, 1, 6),
(60010709, 'Wireless Networks', 'To understand fundamental concept of wireless networks and wireless sensor networks, WSN protocols, and provides hands on experience for simulation of protocols.', 6, 1, 7),
(60010710, 'Java Framework', 'To make the students understand MVC design pattern using Java framework with the usage of tag libraries, various result types, Hibernate and Spring', 6, 1, 7),
(60010711, 'Software Testing', 'To provide the knowledge of testing and its techniques, to trace errors, bugs or defects and to determine user acceptability using testing tools, so as to ensure that the test plan meets and maintains the business and user requirements as stated in the system.', 6, 1, 7),
(60010712, 'Algorithm Analysis and Design', 'To create analytical skills to design and analyze complexity of algorithms and build up solutions to real world problems.', 6, 1, 7),
(60010809, 'Internet of Things', 'To provide a comprehensive understanding of the IoT. IoT concepts and applications, IoT technologies, prototyping, designing and utilize it to implement IoT solutions.', 6, 1, 8),
(60010810, 'Mobile Application Development', 'To develop an understanding of mobile operating system and how to design, develop, and deploy Android based applications for mobile devices.', 6, 1, 8),
(60010811, 'Content Management Systems', 'To provide in-depth knowledge of creation and management of dynamic and responsive content management system using PHP, CodeIgniter and WordPress.', 6, 1, 8),
(60010906, 'Advanced Mobile Application Development', 'To acquaint the students with the concepts of high end android and hybrid based mobile application development. Able to develop location, Bluetooth, network, Wi-Fi, sensors based applications.', 6, 1, 9),
(60010907, 'Machine Learning', 'To exploit and practice machine learning theory and models.', 6, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit`
--

CREATE TABLE `tbl_unit` (
  `unit_id` int(11) NOT NULL,
  `unit_index` int(11) DEFAULT NULL,
  `unit_name` varchar(50) DEFAULT NULL,
  `unit_details` varchar(500) DEFAULT NULL,
  `subject_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_unit`
--

INSERT INTO `tbl_unit` (`unit_id`, `unit_index`, `unit_name`, `unit_details`, `subject_code`) VALUES
(1, 1, 'Introduction of Computers, Logic and Structure', 'Introduction of Computers, Logic and Structure', 60010109),
(2, 2, 'The Program Planning Process and Making Decisions', 'The Program Planning Process and Making Decisions', 60010109),
(3, 3, 'Looping and Control Breaks', 'Looping and Control Breaks', 60010109),
(4, 4, 'Arrays', 'Arrays', 60010109),
(5, 5, 'Methods', 'Methods', 60010109),
(6, 6, 'Derived Types and File Handling', 'Derived Types and File Handling', 60010109);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `tbl_director`
--
ALTER TABLE `tbl_director`
  ADD PRIMARY KEY (`director_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `tbl_equestion_attempted`
--
ALTER TABLE `tbl_equestion_attempted`
  ADD PRIMARY KEY (`eqa_id`),
  ADD KEY `equestion_id` (`equestion_id`),
  ADD KEY `option_id` (`option_id`),
  ADD KEY `exam_student_id` (`exam_student_id`);

--
-- Indexes for table `tbl_equestion_inputed`
--
ALTER TABLE `tbl_equestion_inputed`
  ADD PRIMARY KEY (`eqi_id`),
  ADD KEY `equestion_id` (`equestion_id`),
  ADD KEY `exam_student_id` (`exam_student_id`);

--
-- Indexes for table `tbl_exam`
--
ALTER TABLE `tbl_exam`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `faculty_by_subject_id` (`faculty_by_subject_id`);

--
-- Indexes for table `tbl_exam_question`
--
ALTER TABLE `tbl_exam_question`
  ADD PRIMARY KEY (`equestion_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `tbl_exam_student`
--
ALTER TABLE `tbl_exam_student`
  ADD PRIMARY KEY (`exam_student_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `student_by_course_id` (`student_by_course_id`);

--
-- Indexes for table `tbl_faculty`
--
ALTER TABLE `tbl_faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `tbl_faculty_subject`
--
ALTER TABLE `tbl_faculty_subject`
  ADD PRIMARY KEY (`faculty_by_subject_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `subject_code` (`subject_code`);

--
-- Indexes for table `tbl_option`
--
ALTER TABLE `tbl_option`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `tbl_sem`
--
ALTER TABLE `tbl_sem`
  ADD PRIMARY KEY (`sem_id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tbl_student_by_course`
--
ALTER TABLE `tbl_student_by_course`
  ADD PRIMARY KEY (`student_by_course_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `sem_id` (`sem_id`);

--
-- Indexes for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  ADD PRIMARY KEY (`subject_code`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `sem_id` (`sem_id`);

--
-- Indexes for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  ADD PRIMARY KEY (`unit_id`),
  ADD KEY `subject_code` (`subject_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_director`
--
ALTER TABLE `tbl_director`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_equestion_attempted`
--
ALTER TABLE `tbl_equestion_attempted`
  MODIFY `eqa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_equestion_inputed`
--
ALTER TABLE `tbl_equestion_inputed`
  MODIFY `eqi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_exam`
--
ALTER TABLE `tbl_exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_exam_question`
--
ALTER TABLE `tbl_exam_question`
  MODIFY `equestion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_exam_student`
--
ALTER TABLE `tbl_exam_student`
  MODIFY `exam_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_faculty`
--
ALTER TABLE `tbl_faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_faculty_subject`
--
ALTER TABLE `tbl_faculty_subject`
  MODIFY `faculty_by_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_option`
--
ALTER TABLE `tbl_option`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_question`
--
ALTER TABLE `tbl_question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_sem`
--
ALTER TABLE `tbl_sem`
  MODIFY `sem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_student_by_course`
--
ALTER TABLE `tbl_student_by_course`
  MODIFY `student_by_course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD CONSTRAINT `tbl_course_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `tbl_department` (`department_id`);

--
-- Constraints for table `tbl_director`
--
ALTER TABLE `tbl_director`
  ADD CONSTRAINT `tbl_director_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `tbl_department` (`department_id`);

--
-- Constraints for table `tbl_equestion_attempted`
--
ALTER TABLE `tbl_equestion_attempted`
  ADD CONSTRAINT `tbl_equestion_attempted_ibfk_1` FOREIGN KEY (`equestion_id`) REFERENCES `tbl_exam_question` (`equestion_id`),
  ADD CONSTRAINT `tbl_equestion_attempted_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `tbl_option` (`option_id`),
  ADD CONSTRAINT `tbl_equestion_attempted_ibfk_3` FOREIGN KEY (`exam_student_id`) REFERENCES `tbl_exam_student` (`exam_student_id`);

--
-- Constraints for table `tbl_equestion_inputed`
--
ALTER TABLE `tbl_equestion_inputed`
  ADD CONSTRAINT `tbl_equestion_inputed_ibfk_1` FOREIGN KEY (`equestion_id`) REFERENCES `tbl_exam_question` (`equestion_id`),
  ADD CONSTRAINT `tbl_equestion_inputed_ibfk_2` FOREIGN KEY (`exam_student_id`) REFERENCES `tbl_exam_student` (`exam_student_id`);

--
-- Constraints for table `tbl_exam`
--
ALTER TABLE `tbl_exam`
  ADD CONSTRAINT `tbl_exam_ibfk_1` FOREIGN KEY (`faculty_by_subject_id`) REFERENCES `tbl_faculty_subject` (`faculty_by_subject_id`);

--
-- Constraints for table `tbl_exam_question`
--
ALTER TABLE `tbl_exam_question`
  ADD CONSTRAINT `tbl_exam_question_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `tbl_exam` (`exam_id`),
  ADD CONSTRAINT `tbl_exam_question_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `tbl_question` (`question_id`);

--
-- Constraints for table `tbl_exam_student`
--
ALTER TABLE `tbl_exam_student`
  ADD CONSTRAINT `tbl_exam_student_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `tbl_exam` (`exam_id`),
  ADD CONSTRAINT `tbl_exam_student_ibfk_2` FOREIGN KEY (`student_by_course_id`) REFERENCES `tbl_student_by_course` (`student_by_course_id`);

--
-- Constraints for table `tbl_faculty_subject`
--
ALTER TABLE `tbl_faculty_subject`
  ADD CONSTRAINT `tbl_faculty_subject_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `tbl_faculty` (`faculty_id`),
  ADD CONSTRAINT `tbl_faculty_subject_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `tbl_subject` (`subject_code`);

--
-- Constraints for table `tbl_option`
--
ALTER TABLE `tbl_option`
  ADD CONSTRAINT `tbl_option_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `tbl_question` (`question_id`);

--
-- Constraints for table `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD CONSTRAINT `tbl_question_ibfk_1` FOREIGN KEY (`subject_code`) REFERENCES `tbl_subject` (`subject_code`),
  ADD CONSTRAINT `tbl_question_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `tbl_unit` (`unit_id`);

--
-- Constraints for table `tbl_student_by_course`
--
ALTER TABLE `tbl_student_by_course`
  ADD CONSTRAINT `tbl_student_by_course_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `tbl_course` (`course_id`),
  ADD CONSTRAINT `tbl_student_by_course_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `tbl_student` (`student_id`),
  ADD CONSTRAINT `tbl_student_by_course_ibfk_3` FOREIGN KEY (`sem_id`) REFERENCES `tbl_sem` (`sem_id`);

--
-- Constraints for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  ADD CONSTRAINT `tbl_subject_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `tbl_course` (`course_id`),
  ADD CONSTRAINT `tbl_subject_ibfk_2` FOREIGN KEY (`sem_id`) REFERENCES `tbl_sem` (`sem_id`);

--
-- Constraints for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  ADD CONSTRAINT `tbl_unit_ibfk_1` FOREIGN KEY (`subject_code`) REFERENCES `tbl_subject` (`subject_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
