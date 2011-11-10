USE courseadmin;

SELECT g.IndexNo,s.fullname,g.GPAT,
IF(g.GPAT>3.5,'First Class',IF(g.GPAT>3.25,'Second Class Upper',IF(g.GPAT>3,'Second Class',IF(g.GPAT>2,'Pass','Fail')))) AS class 
FROM itgpv AS g,itstudent AS s 
WHERE g.IndexNo=s.IndexNo AND g.IndexNo LIKE '06%' AND g.GPV4>0  AND  g.Tag = 'D'
ORDER BY g.GPAT DESC;
