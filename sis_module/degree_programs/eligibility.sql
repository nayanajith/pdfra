use ucscsis;
CREATE TABLE bit_seligibility(
 `eligibility_id` int NOT NULL AUTO_INCREMENT,
 `eligibility_name` varchar(50) NOT NULL,
 `GPA1` double DEFAULT NULL,
 `GPA2` double DEFAULT NULL,
 `GPA3` double DEFAULT NULL,
 `GPA4` double DEFAULT NULL,
 `GPA` double DEFAULT NULL,
 `course_year1` text DEFAULT NULL,
 `course_year2` text DEFAULT NULL,
 `course_year3` text DEFAULT NULL,
 `course_year4` text DEFAULT NULL,
 `attendance` text DEFAULT NULL,
 `pre_eligibility` varchar(1000) DEFAULT NULL,
 `deleted` boolean DEFAULT false,
 `note` varchar(300) DEFAULT NULL,
 PRIMARY KEY (`eligibility_id`,`eligibility_name`)
);
