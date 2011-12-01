<style>
th{
   background:silver;
   padding:5px;
}
.index_no,.paper,.assignment,.push{
   width:100%;
   border:0px;
}

.push{
   width:30px;
   visibility:hidden;
}

.serial_no{
   background:silver;
   text-align:center;
}
.suggession{
   background:#a9D7F1;
}
.final{
   background:#C9D7F1;
}
.grade{
   background:#C9D7F1;
}
.gpv{
   background:#C9D7F1;
}

.ratio{
   width:200px;   
}

.shadow {
   -moz-background-clip:border;
   -moz-background-inline-policy:continuous;
   -moz-background-origin:padding;
   -moz-box-shadow:0 4px 8px #C8C8C8;
   background:#FFFFFF none repeat scroll 0 0;

   /*None mozilla*/
   -webkit-box-shadow: #C8C8C8 0px 4px 8px;
   -webkit-box-shadow: #C8C8C8 0px 4px 8px;
   /*None mozilla*/
}

.round,.ratio{
   -moz-border-radius-bottomleft:5px;
   -moz-border-radius-bottomright:5px;
   -moz-border-radius-topleft:5px;
   -moz-border-radius-topright:5px;

   border-bottom-left-radius: 5px 5px;
   border-bottom-right-radius: 5px 5px;
   border-top-left-radius: 5px 5px;
   border-top-right-radius: 5px 5px;

}

</style>
<script>
var total=100;
var paper_ratio;

function  set_ratio(id){
   obj=document.getElementById(id);
   obj_val=obj.value;
   
   /*Validate number*/
   if(isNaN(obj_val)){
      /*Make invalid input red*/
      obj.style.background='red';
      alert('Please enter valid number!');
   }else{
      switch(id){
      case 'paper_rat':
         obj2=document.getElementById('assig_rat');
         /*Reset Color*/
         obj.style.background='white';
         obj2.style.background='white';

         obj2.value=total-(obj_val*1);
         paper_ratio=obj_val*1;
      break;
      case 'assig_rat':
         obj2=document.getElementById('paper_rat');
         obj.style.background='white';
         obj2.style.background='white';
         obj2.value=total-(obj_val*1);
         paper_ratio=total-(obj_val*1);
      break;
      }      
   }
}
</script>
<!-- center total page -->
<center>
<div class=ratio style="width:800px;border:1px solid black;">
<br/>

<script>
//grades//
/*
0<=E<=19
20<=D-<=29
30<=D<=39
40<=D+<=44
45<=C-<=49
50<=C<=54
55<=C+<=59
60<=B-<=64
65<=B<=69
70<=B+<=74
75<=A-<=79
80<=A<=89
90<=A+<=100
*/
function get_grade(mark){
   if( 0<=mark && mark<=19){
      return "E";
   }else if(20<=mark && mark<=29){
      return "D-";
   }else if(30<=mark && mark<=39){
      return "D";
   }else if(40<=mark && mark<=44){
      return "D+";
   }else if(45<=mark && mark<=49){
      return "C-";
   }else if(50<=mark && mark<=54){
      return "C";
   }else if(55<=mark && mark<=59){
      return "C+";
   }else if(60<=mark && mark<=64){
      return "B-";
   }else if(65<=mark && mark<=69){
      return "B";
   }else if(70<=mark && mark<=74){
      return "B+";
   }else if(75<=mark && mark<=79){
      return "A-";
   }else if(80<=mark && mark<=89){
      return "A";
   }else if(90<=mark && mark<=100){
      return "A+";
   }
}

//GPV//
/*
A   4
A-   3.75
A+   4.25
B   3
B-   2.75
B+   3.25
C   2
C-   1.75
C+   2.25
D   1
D-   0.75
D+   1.25
E   0
MC   0
ab   0
AB   0
*/

function get_gpv(grade){
   switch(grade){
   case 'A':
      return 4;
   break;
   case 'A-':
      return    3.75;
   break;
   case 'A+':
      return    4.25;
   break;
   case 'B':
      return    3;
   break;
   case 'B-':
      return    2.75;
   break;
   case 'B+':
      return    3.25;
   break;
   case 'C':
      return    2;
   break;
   case 'C-':
      return    1.75;
   break;
   case 'C+':
      return    2.25;
   break;
   case 'D':
      return    1;
   break;
   case 'D-':
      return    0.75;
   break;
   case 'D+':
      return    1.25;
   break;
   case 'E':
      return    0;
   break;
   case 'MC':
      return    0;
   break;
   case 'ab':
      return    0;
   break;
   case 'AB':
      return    0;
   break;
   }
}

//suggestions//
/*
18   E   *******
19   E   *******
29   D-   *******
39   D    *******
44   D+   *******
49   C-   *******
54   C    *******
59   C+   *******
64   B-   *******
69   B    *******
74   B+   *******
79   A-   *******
89   A    *******
*/
function get_suggestion(mark){
   var retArray = new Array(4);

   switch(mark){
   case 18:   
      var grd=get_grade(20);
      var tarr= [20,grd,get_gpv(grd),20-18];
      return tarr;
   break;
   case 19:   
      var grd=get_grade(20);
      var tarr= [20,grd,get_gpv(grd),20-19];
      return tarr;
   break;
   case 29:   
      var grd=get_grade(30);
      var tarr= [30,grd,get_gpv(grd),30-29];
      return tarr;
   break;   
   case 39:   
      var grd=get_grade(40);
      var tarr= [40,grd,get_gpv(grd),40-39];
      return tarr;
   break;   
   case 44:   
      var grd=get_grade(45);
      var tarr= [45,grd,get_gpv(grd),45-44];
      return tarr;
   break;   
   case 49:   
      var grd=get_grade(50);
      var tarr= [50,grd,get_gpv(grd),50-49];
      return tarr;
   break;   
   case 54:   
      var grd=get_grade(55);
      var tarr= [55,grd,get_gpv(grd),55-54];
      return tarr;
   break;    
   case 59:   
      var grd=get_grade(60);
      var tarr= [60,grd,get_gpv(grd),60-59];
      return tarr;
   break;   
   case 64:   
      var grd=get_grade(65);
      var tarr= [65,grd,get_gpv(grd),65-64];
      return tarr;
   break;   
   case 69:   
      var grd=get_grade(70);
      var tarr= [70,grd,get_gpv(grd),70-69];
      return tarr;
   break;   
   case 74:   
      var grd=get_grade(75);
      var tarr= [75,grd,get_gpv(grd),75-74];
      return tarr;
   break;   
   case 79:   
      var grd=get_grade(80);
      var tarr= [80,grd,get_gpv(grd),80-79];
      return tarr;
   break;   
   case 89:   
      var grd=get_grade(90);
      var tarr= [90,grd,get_gpv(grd),90-89];
      return tarr;
   break;   
   default:
      return "";
   break;
   }
}

function calculate_marks(id){
   /*Extrac ration from paper_ratio field (with paper_ratio assig_ration can be generated)*/
   var paper_ratio=   (document.getElementById('paper_rat').value)*1;

   /*Marks of the paper text field object*/
   var obj_paper   =   document.getElementById('2:'+id);
   var mark_paper   =   obj_paper.value*1;

   /*Marks of the Assignment text field object*/
   var obj_assig   =   document.getElementById('3:'+id);
   var mark_assig   =   obj_assig.value*1;

   if(! isNaN(mark_paper) && ! isNaN(mark_assig)){
      obj_paper.title   =   mark_paper;
      /*Round the value automatically to remove decimal points*/
      obj_paper.value   =   Math.round(mark_paper); 

      obj_assig.title   =   mark_assig;
      /*Round the value automatically to remove decimal points*/
      obj_assig.value   =   Math.round(mark_assig);


      if((0 <= mark_paper && mark_paper <= 100) && (0 <= mark_assig && mark_assig <= 100)){
         obj_paper.style.background   =   'white';
         obj_assig.style.background   =   'white';

         /*objects for each column cell*/
         var obj_final      =   document.getElementById('4:'+id);
         var obj_grade      =   document.getElementById('5:'+id);
         var obj_gpv         =   document.getElementById('6:'+id);
         var obj_suggestion=   document.getElementById('7:'+id);
         var obj_push      =   document.getElementById('8:'+id);

         /*Calculate final marks*/
         var final_mark   =   mark_paper*((paper_ratio)/100) + mark_assig*((100-(paper_ratio))/100)
         obj_final.title=   final_mark;

         var sug          =   get_suggestion(final_mark);

         if (sug != ""){
            obj_push.style.visibility="visible";
            final_mark   =   Math.round(final_mark)+(obj_push.value*1);
            obj_suggestion.innerHTML=   sug[0]+"\t|\t"+sug[1]+"\t|\t"+sug[2];
            obj_push.title="Suggest: add "+sug[3];
         }else{
            obj_push.style.visibility="hidden";
            final_mark   =   Math.round(final_mark);
         }

         var grd          =   get_grade(final_mark)

         /*Setting values to the fields of the table*/
         obj_final.innerHTML      =   final_mark;
         obj_grade.innerHTML      =   grd;
         obj_gpv.innerHTML         =   get_gpv(grd);
      }else{
         if(!(0 <= mark_paper && mark_paper <= 100)){
            /*Making the text field red if the value is not in range*/
            obj_paper.style.background   =   'red';
            alert('Please enter valid number: Number not in range!');
         }
          if(!(0<=mark_assig && mark_assig<=100)){
            /*Making the text field red if the value is not in range*/
            obj_assig.style.background   =   'red';
            alert('Please enter valid number: Number not in range!');
         }
      }
   }else{
      if(isNaN(mark_paper)){
         obj_paper.style.background   =   'red';
         alert('Please enter valid number: Not a Number!');
      }
      else if(isNaN(mark_assig)){
         obj_assig.style.background   =   'red';
         alert('Please enter valid number: Not a Number!');
      }
   }
}

function calculate_all(){
   obj_num_rows=document.getElementById('num_rows')
   for( i=0;i<(obj_num_rows.value*1);i++){
      calculate_marks(i);
   }
}

/*AJAX*/
var XMLHttpRequestObject = false;

if (window.XMLHttpRequest){
   XMLHttpRequestObject = new XMLHttpRequest();
}else if(window.ActiveXobject){
   XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function getData(dataSource){
   if(XMLHttpRequestObject){
      XMLHttpRequestObject.open("GET",dataSource,true);
      XMLHttpRequestObject.send(null);
      XMLHttpRequestObject.onreadystatechange = function(){
         if(XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200){
            var resp=XMLHttpRequestObject.responseText;
            obj=document.getElementById('debug');
            obj.innerHTML=resp;
         }else{
            //alert('error');
         } 
      }
   }
}

/*AJAX*/

function populate_form(val){
   alert(val);   
}

</script>
<?php
/*database connection*/
function openDB(){
   $con=mysql_connect("localhost","root","letmein") or die("Could not connect database".mysql_error());
   $selDB=mysql_select_DB("ucsc") or die("Could not select database".mysql_error());
   if(!$selDB) $con = FALSE;
   return $con;
}

   $conn = openDB();
   $result = mysql_query("SELECT DISTINCT EmpNo,Name FROM employee",$conn);
   $first_ex_select="<select name=first_ex onchange='populate_form(this.value)'>";
   while($row = mysql_fetch_row($result)) {
      $first_ex_select.="<option value='".$row[0]."'>".$row[1]."</option>";
   }
   $first_ex_select.= "</select>";
?>
<form name=total_data method=GET>
<!-- Mark ratio -->
<table><tr><td >
<fieldset class=ratio ><legend>Marks ratio</legend>
<table>
<tr><td>Paper:</td><td><input type=text style='width:40px;' onchange="set_ratio('paper_rat')" id=paper_rat name=paper_rat value=<?php echo empty($_GET['paper_rat']) ? '""' : $_GET['paper_rat']; ?>>%</td></tr>
<tr><td>Assignment:</td><td><input type=text style='width:40px;' onchange="set_ratio('assig_rat')" id=assig_rat name=assig_rat value=<?php echo empty($_GET['assig_rat']) ? '""' : $_GET['assig_rat']; ?>>%</td></tr>
</table>
</fieldset>
</td><td rowspan=2>
<fieldset class=ratio  style="width:300"><legend>Paper</legend>
<table>
<tr><td>Name of the Examination:</td><td><input type=text style='width:40px;' ></td></tr>
<tr><td>Year of the Examination:</td><td><input type=text style='width:40px;' ></td></tr>
<tr><td>Batch:</td><td><input type=text style='width:40px;' ></td></tr>
<tr><td>Semester:</td><td><input type=text style='width:40px;'  ></td></tr>
<tr><td>Paper Name:</td><td><input type=text style='width:40px;'  ></td></tr>
<tr><td>Paper Code:</td><td><input type=text style='width:40px;' ></td></tr>
<tr><td>First Examiner:</td><td><?php echo $first_ex_select;?></td></tr>
<tr><td>Second Examiner:</td><td><input type=text style='width:40px;' ></td></tr>
<tr><td>Number of students:</td><td><input type=text style='width:40px;' name=rows id=rows value=<?php echo empty($_GET['rows']) ? '""' : $_GET['rows']; ?> ></td></tr>
</table>
</fieldset>
</td></tr><tr><td>
<fieldset class=ratio  style='width:400px;'><legend>Copy from Excel</legend>
<table>
<tr><td>
Copy data here (IndexNo,Paper Marks,Assignent Marks):
<textarea cols=25 rows=5 id=row_data name=raw_data  ><?php echo empty($_GET['raw_data']) ? '' : $_GET['raw_data']; ?></textarea>
</td><td>
<input type=button value="Fill The Table" onclick='fill_data()' >
<input type=button value="Calculate All" onclick='calculate_all()' >
<input type=button value=Upload onclick='upload_marks()'>
<input type=submit value="Apply Preferences" >
</td></tr></table>
</fieldset>
</td></tr></table>
</form>


<?php
$rows=$_GET['rows'];
if ( !empty($_GET['raw_data']) ){
   $lines=explode("\n",$_GET['raw_data']);
   $rows = sizeof($lines);
}
if ($rows <= 1){
   $rows=10;
}
echo "<input type=hidden value='$rows' id=num_rows>";
echo "<table border=1 cellpadding=0 cellspacing=0  style='border-collapse:collapse;border:1px solid black;font-size:11px;'>\n";
echo "<tr><th>SERIAL<br/>NO</th><th>INDEX NO</th><th>PAPER</th><th>ASSIGNMENT</th><th>FINAL</th><th>GRADE</th><th>GPV</th><th>SUGGESTION<br/>(mark\t|\tgrade\t|\tgpv)</th><th>PUSH</th></tr>";
if( $rows ){
    for ($i=0; $i<$rows; $i++){
      $index_no   =empty($_GET['1:'.$i]) ? '""' : $_GET['1:'.$i];
      $paper       =empty($_GET['2:'.$i]) ? '""' : $_GET['2:'.$i];
      $assignment   =empty($_GET['3:'.$i]) ? '""' : $_GET['3:'.$i];
      echo "<tr>
<td id='0:$i' class='serial_no' title='0:$i'>$i</td>
<td><input type=text id='1:$i' name='1:$i' class='index_no' title='1:$i' value=".$index_no. " ></td>
<td><input type=text id='2:$i' name='2:$i' class='paper' title='2:$i' value=".$paper. "  onchange='calculate_marks($i)'></td>
<td><input type=text id='3:$i' name='3:$i' class='assignment'  title='3:$i'  value=".$assignment." onchange='calculate_marks($i)'></td>
<td class='final'><div id='4:$i'  title='4:$i' ></div></td>
<td class='grade'><div id='5:$i'  title='5:$i' ></div></td>
<td class='gpv'><div id='6:$i'  title='6:$i' ></div></td>
<td class='suggestion'><div id='7:$i' title='7:$i' ></div></td>
<td><input type=text id='8:$i'  title='8:$i' class='push' onchange='calculate_marks($i)'></td>
</tr>";
   }
}else{
   echo "<tr>
<td><input type=text></td>
<td><input type=text></td>
<td><input type=text></td>
<td><input type=text></td>
<td><input type=text></td>
</tr>";
}
echo "</table>";
?>
<br/>
<div id=debug></div>
<script language=javascript>
function debug(info){
   obj_DBg=document.getElementById('debug')
   obj_DBg.innerHTML+=info+"<br/>";
}
function fill_data(){

   dataObj=document.getElementById('row_data')
   obj_num_rows=document.getElementById('num_rows')

   for( i=0;i<(obj_num_rows.value*1);i++){
      for( j=1;j<8;j++){
         cellObj=document.getElementById(j+':'+i).value='';
      }
   }

   data_value=dataObj.value
   //data_row_arr=String.split(data_value,"\n");
   data_row_arr=data_value.split("\n");
   for( i=0;i<data_row_arr.length;i++){
      //data_col_arr=String.split(data_row_arr[i],"\t");
      data_col_arr=data_row_arr[i].split("\t");
      for( j=0;j<data_col_arr.length;j++){
         cellObj=document.getElementById((j+1)+':'+i)
         cellObj.value=data_col_arr[j];
      }
   }
}
</script>
<div/>
</div>
</center>
<script>
calculate_all();
</script>
