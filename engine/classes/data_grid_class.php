<?php
class Data_grid(){
   public __construct(){
     d_r('dojox.widget.PlaceholderMenuItem');
     d_r('dojox.grid.EnhancedGrid');
     d_r("dojox.grid.enhanced.plugins.exporter.CSVWriter");
     d_r("dojox.grid.enhanced.plugins.Printer");
   }
   //type -> CSV,TABLE
   public function gen_data_grid($field_array,$csv_url_or_tableid,$key,$type,$title=''{
       $output.= "
        <script>
            //acction to perform when the user clicked on the grid
            function grid_clicked(e){
               var selectedValue = grid3.store.getValue(grid3.getItem(e.rowIndex),'".$key."');
               alert('selected cell Value is '+selectedValue);
            };

            //Expor the gird to csv and insert it in the textarea so the user can copy and paste
            function grid_to_csv(){
               info_dialog(
                  '<textarea cols=\"150\" rows=\"30\"id=\"output\"></textarea>',
                  '".$title."',
                  '<button onClick=\"dojo.byId('output').select()\">Select all</button>',
                  800,
                  600 
               );
               dijit.byId('grid').exportGrid(
                  'csv', 
                  function(str){
                     dojo.byId('output').value = str;
                  });
            };
            
            //style to be used when printing the grid
            var cssFiles = [
               '".CSS."/print_style.css'
            ];
            //Prit the grid 
            function grid_print(){
               dijit.byId('grid').printGrid({
                  title:'".$title."',
                  cssFiles: cssFiles
                  });
             }

            //Add two buttons to toolbar in order to  print the grid and export the grid to csv
            dojo.addOnLoad(function() {
               //reference to our toolbar
               var toolbar = dijit.byId('toolbar');

               var print_grid_btn=new dijit.form.Button({
                  iconClass:'dijitIcon dijitIconPrint',
                  label: 'Print Grid',
                  onClick:print_grid,
               });

               toolbar.addChild(print_grid_btn);


               var csv_grid_button=new dijit.form.Button({
                  iconClass:'dijitIcon dijitIconFunction',
                  label: 'CSV Grid',
                  onClick:grid_to_csv,
               });

               toolbar.addChild(csv_grid_button);
            }

         </script>";

      if($type == 'CSV'){
         d_r('dojox.data.CsvStore');
         $output.= "<span dojoType='dojox.data.CsvStore' jsId='store3' url='".$csv_url_or_tableid."'></span>";
      }else{
         d_r('dojox.data.HtmlTableStore');
         $output.= "<span dojoType='dojox.data.HtmlTableStore' tableId='".$csv_url_or_tableid."' jsId='gridStore'></span>";
      }
        $output.="<div dojoType='dijit.Menu' jsid='gridMenu' id='gridMenu' style='display: none;'>
            <div dojoType='dojox.widget.PlaceholderMenuItem' label='GridColumns'></div>
         </div>

         <table 
            dojoType    ='dojox.grid.EnhancedGrid' 
            jsId        ='grid3' 
            store       ='store3' 
            query       ='{ ".$key.": \"*\" }'
            rowsPerPage ='40' 
            clientSort  ='true' 
            style       ='width:100%;height:400px' 
            onClick     ='grid_clicked'
            rowSelector ='20px'
            columnReordering='true'
            headerMenu  ='gridMenu'
            plugins     ={printer: true,exporter: true}
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
