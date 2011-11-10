USE attendance;

/*
LOAD DATA LOCAL INFILE 'attendance.csv'
INTO TABLE in_out
FIELDS TERMINATED BY ','
ENCLOSED by '''
LINES TERMINATED BY '\n'
(Event_Date,Event_Data_Str,Event_Time,Event_UserID,Event_Control,Event_FunctionCode,Event_TrType,Event_DateTime_Str,AutoNo,SYS_DATE);
*/

INSERT INTO in_out(Event_Date,Event_Data_Str,Event_Time,Event_UserID,Event_Control,Event_FunctionCode,Event_TrType,Event_DateTime_Str,SYS_DATE) 
values('','','','00000011','','','Granted(ID & FP)','2011-01-01 08:02:23','')
,('','','','00000011','','','Granted(ID & FP)','2011-01-01 16:02:23','')
