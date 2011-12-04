<?php
class Data_grid(){
   public __construct(){
     d_r('dojox.data.CsvStore');
     d_r('dojox.widget.PlaceholderMenuItem');
   }
   //type -> CSV,TABLE
   public function gen_data_grid($field_array,$csv_url_or_tableid,$key,$type){
       $output.= "
            <script>
            function grid_clicked(e){
               var selectedValue = grid3.store.getValue(grid3.getItem(e.rowIndex),'".$key."');
               alert('selected cell Value is '+selectedValue);
            }
         </script>";

      if($type == 'CSV'){
         d_r('dojox.grid.DataGrid');
         $output.= "<span dojoType='dojox.data.CsvStore' jsId='store3' url='".$csv_url_or_tableid."'></span>";
      }else{
         d_r('dojox.data.HtmlTableStore');
         $output.= "<span dojoType='dojox.data.HtmlTableStore' tableId='".$csv_url_or_tableid."' jsId='gridStore'></span>";
      }
        $output.="<div dojoType='dijit.Menu' jsid='gridMenu' id='gridMenu' style='display: none;'>
            <div dojoType='dojox.widget.PlaceholderMenuItem' label='GridColumns'></div>
         </div>

         <table 
            dojoType='dojox.grid.DataGrid' 
            jsId='grid3' 
            store='store3' 
            query='{ ".$key.": \"*\" }'
            rowsPerPage='40' 
            clientSort='true' 
            style='width:100%;height:400px' 
            onClick='grid_clicked'
            rowSelector='20px'
            columnReordering='true'
            headerMenu='gridMenu'
         >
         <thead>
            <tr>";
            /*Set labels for the table header if available in fileds array*/
            foreach($field_array as $key => $label){
               $output.= "<th width='auto' field='$key'>$label</th>";
            }
            //<th width='auto' field='sex' cellType='dojox.grid.cells.Select' options='Male,Female' editable='true'>Sex</th>
            $output.= "</tr>
         </thead>
         </table>";
    }
}

?>
