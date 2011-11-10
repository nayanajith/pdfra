/*
 * All list of elements
 */
var obj_msg			=null;
var obj_data		=null;
var obj_assig_rat	=null;
var obj_assig_ab	=null;
var obj_assig_nc	=null;
var obj_paper_rat	=null;
var obj_paper_ab	=null;
var obj_paper_nc	=null;
var obj_status		=null;
var obj_num_rows	=null;
var obj_examiner	=null;
var obj_paper_code	=null;
var obj_spreadsheet	=null;

function init_element(){
 	obj_msg			=document.getElementById('msg');
 	obj_data		=document.getElementById('row_data');
 	obj_assig_rat	=document.getElementById('assig_rat');
 	obj_assig_ab	=document.getElementById('ab_assig_rat');
 	obj_assig_nc	=document.getElementById('nc_assig_rat');
 	obj_paper_rat	=document.getElementById('paper_rat');
 	obj_paper_ab	=document.getElementById('ab_paper_rat');
 	obj_paper_nc	=document.getElementById('nc_paper_rat');
 	obj_status		=document.getElementById('status_bar');
 	obj_num_rows	=document.getElementById('num_rows');
 	obj_examiner	=document.getElementById('examiner');
 	obj_paper_code	=document.getElementById('paper_code');
	obj_spreadsheet =document.getElementById('spreadsheet');
}

/*
 * Status update function - Update bottom status bar DIV
 */
function status(stat){
	obj_status.innerHTML=stat;
}

/*
 * Display messages at top of the page
 */
function message(msg){
	var interval=5000;  // Milliseconds between updates
	obj_msg.innerHTML="";
	obj_msg.innerHTML+="<div id=message class='shadow'>"+msg+"</div>";
	// setTimeout(get_ele('msg').innerHTML="",10000);
	// setTimeout(alert('aaa'),3000);
}

function clear_message(){
	obj_msg.innerHTML="";
}



/*--------------------------AJAX---------------------------------*/
var XMLHttpRequestObject = false;
if (window.XMLHttpRequest){
	XMLHttpRequestObject = new XMLHttpRequest();
}else if(window.ActiveXobject){
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function ajax_request(data_source,func){
	if(XMLHttpRequestObject){
		XMLHttpRequestObject.open("GET",data_source,true);
		XMLHttpRequestObject.send(null);
		XMLHttpRequestObject.onreadystatechange = function(){
			if(XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200){
				var resp=XMLHttpRequestObject.responseText;
				if(func != null){
					func(resp);
				}
			}else{
				// ;
			} 
		};
	}
}


/*-------------------------/AJAX-----------------------------------*/


// Grade ranges//
/*
 * 0<=E<=19 20<=D-<=29 30<=D<=39 40<=D+<=44 45<=C-<=49 50<=C<=54 55<=C+<=59
 * 60<=B-<=64 65<=B<=69 70<=B+<=74 75<=A-<=79 80<=A<=89 90<=A+<=100
 */
/*
 * param mark: int/float value return grade: eg E, D-,
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

// GPV values//
/*
 * A 4 A- 3.75 A+ 4.25 B 3 B- 2.75 B+ 3.25 C 2 C- 1.75 C+ 2.25 D 1 D- 0.75 D+
 * 1.25 E 0 MC 0 ab 0 AB 0
 */

/*
 * param grade: string grade value such as A, A-, B-, B, B+ Return the GPV value
 * as number
 */
function get_gpv(grade){
	switch(grade){
	case 'A':
		return 4;
	break;
	case 'A-':
		return 	3.75;
	break;
	case 'A+':
		return 	4.25;
	break;
	case 'B':
		return 	3;
	break;
	case 'B-':
		return 	2.75;
	break;
	case 'B+':
		return 	3.25;
	break;
	case 'C':
		return 	2;
	break;
	case 'C-':
		return 	1.75;
	break;
	case 'C+':
		return 	2.25;
	break;
	case 'D':
		return 	1;
	break;
	case 'D-':
		return 	0.75;
	break;
	case 'D+':
		return 	1.25;
	break;
	case 'E':
		return 	0;
	break;
	case 'MC':
		return 	0;
	break;
	case 'ab':
		return 	0;
	break;
	case 'AB':
		return 	0;
	break;
	}
}

// suggestions//
/*
 * 18 E ******* 19 E ******* 29 D- ******* 39 D ******* 44 D+ ******* 49 C-
 * ******* 54 C ******* 59 C+ ******* 64 B- ******* 69 B ******* 74 B+ *******
 * 79 A- ******* 89 A *******
 */

/*
 * return array of suggestions @param cur: current mark @param sug: suggested
 * mark return: array of suggestions
 */
function get_suggestion_array(cur,sug){
 var grd	=	get_grade(sug);
	var tarr	=	[sug,grd,get_gpv(grd),sug-cur];
	return  	tarr;
}

/*
 * Generate suggestions for a special occurenc of marks @param mark: current
 * mark of the student return : array of suggestions
 */
function get_suggestion(mark){
	switch(mark){
	case 18:	
		return get_suggestion_array(18,20);
	break;
	case 19:	
		return get_suggestion_array(19,20);
	break;
	case 29:	
		return get_suggestion_array(29,30);
	break;	
	case 39:	
		return get_suggestion_array(39,40);
	break;	
	case 44:	
		return get_suggestion_array(44,45);
	break;	
	case 49:	
		return get_suggestion_array(49,50);
	break;	
	case 54:	
		return get_suggestion_array(54,55);
	break; 	
	case 59:	
		return get_suggestion_array(59,60);
	break;	
	case 64:	
		return get_suggestion_array(64,65);
	break;	
	case 69:	
		return get_suggestion_array(69,70);
	break;	
	case 74:	
		return get_suggestion_array(74,75);
	break;	
	case 79:	
		return get_suggestion_array(79,80);
	break;	
	case 89:	
		return get_suggestion_array(89,90);
	break;	
	default:
		return "";
	break;
	}
}

/*
 * Change background color of an element
 */
function set_bg(ele,color){
	if(ele){
		ele.style.background=color;
	}else{
		return false;
	}
}


/*
 * Change text color of an element
 */
function set_tc(ele,color){
	if(ele){
		ele.style.color=color;
	}else{
		return false;
	}
}

/*
 * Set marking ration for Paper and Assignment @param id: the id of last edited
 * text field
 */
var total=100;
var paper_ratio;
function  set_ratio(){
	/* Element paper_rat or assig_rat */
	var assig_val=obj_assig_rat.value;
	var paper_val=obj_paper_rat.value;
	
	if(assig_val == "" && paper_val == ""){
		alert("Please set ratio for Paper and Assignments");
		return false;
	}else if(assig_val!=""){
		if(isNaN(assig_val)){
			set_bg(obj_assig,'red');
			alert('Please enter valid number!');
			return false;
		}else{
			set_bg(obj_assig_rat,'white');
			set_bg(obj_paper_rat,'white');
			obj_paper_rat.value=(total-(assig_val*1));
			return true;
		}
	}else if(paper_val!=""){
		if(isNaN(paper_val)){
			set_bg(obj_paper_rat,'red');
			alert('Please enter valid number!');
			return false;
		}else{
			set_bg(obj_paper_rat,'white');
			set_bg(obj_assig_rat,'white');
			obj_assig_rat.value=(total-(paper_val*1));
			return true;
		}	
	}
}

/*
 * Check AB assignment of paper and assignemnt IF AB is checked; students are
 * allow to absent the one CHECKED but the finalmarks will calculated from the
 * rest
 */

function set_ab(id){
	if(id == 'ab_paper_rat'){
		if(obj_paper_ab.checked == true){
			obj_assig_ab.checked = false;
		}
	}else{
		if(obj_assig_ab.checked == true){
			obj_paper_ab.checked = false;
		}
	}
}

/*
 * Check NC state IF NC is checked, students are allow not to complete the one
 * CHECKED but the final will be calculated from the rest
 */

function set_nc(id){
	if(id == 'nc_paper_rat'){
		if(obj_paper_nc.checked == true){
			obj_assig_nc.checked = false;
		}
	}else{
		if(obj_assig_nc.checked == true){
			obj_paper_nc.checked = false;
		}
	}
}

/*
 * Validata marks
 */
function validate(obj,subject){
	var mark=obj.value;
	if(isNaN(mark)){
		mark=mark.toUpperCase();
		if (mark == "AB" || mark == "NC"){
			obj.title	=	mark;// set cell title to previous value
			obj.value	=	mark; // set cell value to formatted value
			set_tc(obj, "blue");
			if(subject == 'paper'){
				if( obj_paper_ab.checked == true || obj_paper_nc.checked == true){
					return -1;
				}else{
					return mark;
				}
			}else{
				if(obj_assig_ab.checked == true || obj_assig_nc.checked == true){
					return -1;
				}else{
				    return mark;
				}
			}
			set_bg(obj, "white");
		}
	}else if(mark*1 >= 0 || mark*1 <= 100){
		set_bg(obj, "white");
		obj.title	=	mark; // set previous value to title
		obj.value	=	Math.round(mark*1); // round the marks
		return mark;
	}else{
		set_bg(obj, "red"); // on error make the cell background red
		return false;
	}
}
/*
 * Calculate the Final Grade GPV and Suggestion for a individual student
 */

function calculate_marks(id){
	
	status("Calculating...");
	/*
	 * Extrac ratio from paper_ratio field (with paper_ratio assig_ration can be
	 * generated)
	 */
	var paper_ratio	=(obj_paper_rat.value);
	
	if(!set_ratio()){
		return;
	}else{
		paper_ratio=paper_ratio*1;
	}

	/* Marks of the paper text field object */
	var obj_paper	=	document.getElementById('2:'+id);
	var mark_paper = "";
	if(obj_paper){
		mark_paper	=validate(obj_paper,"paper");
	}

	/* Marks of the Assignment text field object */
	var obj_assig	=	document.getElementById('3:'+id);
	var mark_assig = "";
	if(obj_assig){
		mark_assig	=validate(obj_assig,"assig");
	}
	
	if(mark_paper != false && mark_assig != false){
		var obj_final	=	document.getElementById('4:'+id);
		var obj_grade	=	document.getElementById('5:'+id);
		var obj_gpv		=	document.getElementById('6:'+id);
		var obj_suggestion=	document.getElementById('7:'+id);
		var obj_push	=	document.getElementById('8:'+id);
		
		obj_final.innerHTML		=	'';
		obj_grade.innerHTML		=	'';
		obj_gpv.innerHTML		=	'';
		
		set_tc(obj_final,"");
		set_tc(obj_grade,"");
		set_tc(obj_gpv,"");
		
		var final_mark	=	"";
		var sug = "";
		var grd = "";
		var gpv = "";
		
		obj_suggestion.innerHTML="";	
		if(mark_paper == "AB"|| mark_assig == "AB"){
			final_mark = "AB";
			grd = 0;
			gpv = 0;
			set_tc(obj_final,"blue");
		}else if( mark_paper == "NC" || mark_assig == "NC"){
			final_mark = "NC";
			grd = 0;
			gpv = 0;
			set_tc(obj_final,"blue");
		}else{
			if(mark_paper == -1){
				final_mark=mark_assig*((100-(paper_ratio))/100);
			}else if(mark_assig == -1){
				final_mark=mark_paper*((paper_ratio)/100);
			}else{
				final_mark=mark_paper*((paper_ratio)/100) + mark_assig*((100-(paper_ratio))/100);
			}
			
			obj_final.title=	final_mark;

			/* Get suggestions */
			sug	=	get_suggestion(final_mark);
			if (sug != ""){// If there are suggestions make the PUSH field
							// visible and ready to submit
				obj_push.style.visibility="visible";
				/* Final maks are rounded */
				final_mark	=	Math.round(final_mark)+(obj_push.value*1);
				obj_suggestion.innerHTML=	sug[0]+"\t|\t"+sug[1]+"\t|\t"+sug[2];
				obj_push.title="Suggest: add "+sug[3];
			}else{
				obj_push.style.visibility="hidden";
				set_bg(obj_push, "white");
				final_mark	=	Math.round(final_mark);
			}
			grd	=	get_grade(final_mark);
			gpv = 	get_gpv(grd);
		}
		
		/* Setting values to the fields of the table */
		obj_final.innerHTML		=	final_mark;
		obj_grade.innerHTML		=	grd;
		obj_gpv.innerHTML		=	gpv;
	}
}	
	
	



function calculate_all(){
	status("Calculating all...");
	if(!set_ratio()){
		return;
	}

	for( i=1;i<=(obj_num_rows.value*1);i++){
		calculate_marks(i);
	}
}
/*--------------------------DATA EXTRACTION-----------------------*/
/*
 * Extract data from paper detail form return : url formatted string
 */
var paper_array=new Array(
		"paper_rat",
		"assig_rat",
		"name_of_exam",
		"year_of_exam",
		"batch",		  
		"semester",	  
		"paper_name",  
		"paper_code",  
		"examiner1",
		"examiner2",
		"num_of_stude"
	);

function extract_paper_detail(){
	var data_url="detail=true&";
	for ( var i in paper_array) {
		var id=paper_array[i];
		status(id);
		var obj=document.getElementById(id);
		if(obj && obj.value){
			var data = obj.value;
			data_url+=id+"="+obj.value+"&";
		}
	}
	// status(data_url);
	return data_url;
}

/*
 * Extract spreadsheet data @param start : Starting row of the table (min: 1)
 * @param end : End row fothe table to be fetch data (max: number of columns)
 * return : url formatted string
 */
function extract_spreadsheet(){
	obj_num_rows=document.getElementById('num_rows');
	var rows	=(obj_num_rows.value)*1;
	var cols=[1,2,3,8];
	var data_url="rows="+rows+"&";
	
	for ( var i = 0; i < rows; i++) {
		for (j in cols) {
			var id =j+":"+i; 
			var obj=document.getElementById(id);
			if(obj &&  obj.value){
				var data = obj.value;
				data_url+=id+"="+obj.value+"&";
			}
		}
	}
	// status(data_url);
	return data_url;
}


/* Auto saving at given intervel */
var sync = {
    interval: 30000,          // Milliseconds between updates
    timer: null,              // Return value of setInterval( )
    target: "sync_data.php",  // Target php file to proccess data

    /* Start the animation */
    start: function( ) {
         sync.timer  = setInterval(sync.update, sync.interval);
    },

    /* Stop the animation */
    stop: function( ) {
    	clearInterval(sync.timer);
    },

    /* Syncronize data. Invoked by setInterval( ) */
    update: function( ) {
    	message("Auto Saving...");
    	ajax_request(sync.target+"?"+extract_spreadsheet(),message);
    	ajax_request(sync.target+"?"+extract_paper_detail(),message);
    }
};

/* Manually saving the data */
function save_changes( ) {
	message("Saving...");
   	ajax_request(sync.target+"?"+extract_spreadsheet(),message);
   	ajax_request(sync.target+"?"+extract_paper_detail(),message);
}

/*--------------------------/DATA EXTRACTION-----------------------*/


function populate_form(val){
	alert(val);	
}

/*
 * Delay for a number of milliseconds
 */
function sleep(delay)
{
    var start = new Date().getTime();
    while (new Date().getTime() < start + delay);
}

/*
 * 
 */

function fill_data(){
	var answer=confirm("If you press OK it will overwrite the data in the table with the data in paste box");
	if(answer){
		data_value=obj_data.value;
		data_row_arr=data_value.split("\n");
		
		/* Update number of rows of the table */
		var rows=data_row_arr.length;
		if(rows > 10){
			ajax_request("spreadsheet.php?expand=true&rows="+rows,expand_table);
		}else{
			expand_table(false);
		}
	}
}

function expand_table(data){	
	data_value=obj_data.value;
	data_row_arr=data_value.split("\n");
	
	if(data != false){
		obj_spreadsheet.innerHTML=data;
	}else if(data_value == "Paste Here"){
		return;
	}
	
	for( i=1;i<=data_row_arr.length;i++){
		data_col_arr=data_row_arr[i-1].split("\t");
		for( j=1;j<=data_col_arr.length;j++){
			cellObj=document.getElementById(j+':'+i);
			if(cellObj)	cellObj.value=data_col_arr[j-1];
		}
	}
}

/*
 * Clean local data
 */



function clean_result(){
	var rows=1*(obj_num_rows.value);
	for( i=1;i<=rows;i++){
		for( j=4;j<8;j++){
			if(document.getElementById(j+':'+i).value){
				document.getElementById(j+':'+i).value='';
			}else{
				document.getElementById(j+':'+i).innerHTML='';
			}
		}
	}
}

function clean_content(){
	var answer=confirm("If you press OK it will clean all the data locally");
	if(answer){
		var rows=1*(obj_num_rows.value);
		for( i=1;i<=rows;i++){
			for( j=1;j<8;j++){
				if(document.getElementById(j+':'+i).value){
					document.getElementById(j+':'+i).value='';
				}else{
					document.getElementById(j+':'+i).innerHTML='';
				}
			}
		}
	}
}

/*
 * Load marks from remote server if available
 */
function revert_marks(){
	ajax_request("spreadsheet.php",expand_table);
}


function upload_marks(){
	var report="" +
			"Number of Student\t:"+obj_num_rows.value+"\n"+
			"Examiner\t\t\t:Examiner-"+obj_examiner.value+"\n"+
			"Paper\t\t\t:"+obj_paper_code.value+"\n"+
			"Paper ratio\t\t:"+obj_paper.value+"\n"+
			"Assignment ratio\t:"+obj_assig.value;
	confirm(report);
}
