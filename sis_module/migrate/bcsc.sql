/*student info*/
use sis;

REPLACE INTO bict_student(index_no,initials,last_name,full_name,date_of_regist,date_of_graduation,date_of_birth,status,AL_index_no) SELECT IndexNo,Initials,Name,fullname,dreg,dgrad,dob,Status,IndexNo FROM courseadmin.csstudent;
/*marks*/
REPLACE INTO bict_marks(exam_id,index_no,course_id,assignment_mark,paper_mark,final_mark) SELECT examid,indexno,courseid,marks1,marks2,maks3 FROM courseadmin.csmarks;
REPLACE INTO bict_exam(exam_id) SELECT DISTINCT exam_id FROM bict_marks;
UPDATE bict_exam SET student_year=(LEFT(RIGHT(exam_id,2),1)), academic_year=(2000+LEFT(exam_id,2)), semester=RIGHT(exam_id,1);
REPLACE INTO bict_batch(batch_id,admission_year) SELECT  LEFT(exam_id,2),academic_year FROM bict_exam;
/*
INSERT INTO ucscsis.bit_marks(exam_id,index_no,course_id,assignment_mark,paper_mark,final_mark) SELECT examid,indexno,courseid,marks1,marks2,marks3 FROM courseadmin.bitmarks;

/*gpa*/
/*
REPLACE INTO bict_gpa(index_no,degree_class,GPV1,credits1,GPA1,GPV2,credits2,GPA2,GPV3,credits3,GPA3,GPV4,credits4,GPA4,GPV,GPA,credits) SELECT IndexNo,Tag,GPV1,credits1,GPA1,GPV2,credits2,GPA2,GPV3,credits3,GPA3,GPV4,credits4,GPA4,GPVT,GPAT,CreditsT FROM courseadmin.csgpv;
/*
INSERT INTO bict_gpa(index_no,degree_class,GPV1,credits1,GPA1,GPV2,credits2,GPA2,GPV3,credits3,GPA3,GPV4,credits4,GPA4,GPV,GPA,credits) SELECT IndexNo,Tag,GPV1,credits1,GPA1,GPV2,credits2,GPA2,GPV3,credits3,GPA3,GPV4,credits4,GPA4,GPVT,GPAT,CreditsT FROM courseadmin.iggpv;

/*courses*/
REPLACE INTO bict_course(course_id,student_year,semester,course_name,prerequisite,lecture_credits,practical_credits,maximum_students,compulsory,alt_course_id,offered_by,GPA_con) SELECT CourseId,SYear,Semester,CourseName,Prerequisite,Credits_L,Credits_P,MaxStudents,Compulsory,AltCourseId,OfferedBy,GPACon FROM courseadmin.courses where courseid like 'SCS%';
