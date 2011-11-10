<html>
<head>
<title>Auto Completer Combo</title>
<style type="text/css">
@import "../js/dojo/resources/dojo.css";

@import "../js/dijit/themes/claro/claro.css";
</style>

<script type="text/javascript" src="../js/dojo/dojo.js"
	djConfig="parseOnLoad: true"></script>

<!-- combo box -->
<script type="text/javascript">
        dojo.require("dojo.parser");
        dojo.require("dijit.form.FilteringSelect");
        dojo.require("dijit.form.RadioButton");
        dojo.require("dijit.form.CheckBox");
        dojo.require("dijit.form.TextBox");
        dojo.require("dijit.form.Textarea");
        dojo.require("dijit.form.DateTextBox");
        dojo.require("dijit.form.NumberSpinner");
        dojo.require("dijit.form.HorizontalSlider");
        dojo.require("dijit.form.Button");
        
        dojo.require("dijit.layout.ContentPane");
        dojo.require("dijit.layout.StackContainer");

        dojo.require("dijit.InlineEditBox");
        dojo.require("dijit.Menu");
        dojo.require("dijit.Dialog");
        dojo.require("dijit.Toolbar");
        dojo.require("dijit.ProgressBar");
        dojo.require("dijit.Tooltip");
        dojo.require("dijit.layout.AccordionContainer");
		  dojo.require("dijit.Tree");
		  dojo.require("dijit.ColorPalette");
		  dojo.require("dijit.Editor");
        dojo.require("dijit.TitlePane");

        dojo.require("dojo.data.ItemFileReadStore");
        
        dojo.require("dojox.widget.ColorPicker");
      </script>
</head>

<body class="claro">
<!-- _______________________________________________________________________ -->
<h2>Auto Completer Combo box</h2>
<select dojoType="dijit.form.FilteringSelect" name="sname"
	autocomplete="false" value="Vinod">
	<option value="Vinod">Vinod</option>
	<option value="Vikash">Vikash</option>
	<option value="Deepak">Deepak</option>
	<option value="DeepakSir">Deepak Sir</option>
	<option value="Arun">Arun</option>
	<option value="Amar">Amar</option>
	<option value="Aman">Aman</option>
</select>


<!-- _______________________________________________________________________ -->
<h2>Radio button</h2>
<input dojoType="dijit.form.RadioButton" id="val1" name="group1"
	checked="checked" value="Programmer" type="radio" />
<label for="val1"> Programmer </label>
<input dojotype="dijit.form.RadioButton" id="val2" name="group1"
	value="Designer" type="radio" />
<label for="val2"> Designer </label>
<input dojotype="dijit.form.RadioButton" id="val3" name="group1"
	value="Developer" type="radio" />
<label for="val3"> Developer </label>




<!-- _______________________________________________________________________ -->
<h2>Check box</h2>
<input id="cb" dojotype="dijit.form.CheckBox" name="developer"
	checked="checked" value="on" type="checkbox" />
<label for="cb"> Are you a Developer </label>




<!-- _______________________________________________________________________ -->
<h2>Edit Please:</h2>
<p id="areaEditable" dojoType="dijit.InlineEditBox" renderAsHtml="true"
	autoSave="false"><textarea dojoType="dijit.form.Textarea">
        vinod
   </textarea></p>


<!-- _______________________________________________________________________ -->
<h2>Date:</h2>
<input type="text" name="date1" id="date1" value="2005-12-30"
	dojoType="dijit.form.DateTextBox" required="true" />
<label for="date1"> Drop down Date box. Click inside to display the
calendar. </label>



<!-- _______________________________________________________________________ -->
<h2>Number spinner:</h2>
<input dojoType="dijit.form.NumberSpinner" value="0" smallDelta="1"
	constraints="{min:0,max:1550,places:0}" maxlength="20"
	id="integerspinner2">




<!-- _______________________________________________________________________ -->
<h2>horizontalSlider</h2>
<div id="horizontalSlider" dojoType="dijit.form.HorizontalSlider"
	value="5" minimum="-10" maximum="10" discreteValues="11"
	intermediateChanges="true"
	onChange="dojo.byId('horizontalSlider').value = arguments[0];"
	handleSrc="preciseSliderThumb.png"></div>



<!-- _______________________________________________________________________ -->
<h2>TabContainer</h2>
<button id="previous" onClick="dijit.byId('mainTabContainer').back()"><<-Previous</button>
<button id="next" onClick="dijit.byId('mainTabContainer').forward()">
Next->></button>
<div id="mainTabContainer" dojoType="dijit.layout.StackContainer"
	style="width: 90%; border: 1px solid #9b9b9b; height: 10em; margin: 0.5em 0 0.5em 0; padding: 0.5em;">
<p id="Page1" dojoType="dijit.layout.ContentPane" label="Intro">Page
First</p>

<p id="Page2" dojoType="dijit.layout.ContentPane">Page Second.</p>
<p id="Page3" dojoType="dijit.layout.ContentPane">Page Third.</p>
</div>


<!-- _______________________________________________________________________ -->
<h2>TabContainer2</h2>
<script type="text/javascript">
    dojo.require("dijit.layout.TabContainer");
    dojo.require("dijit.layout.ContentPane");
    dojo.addOnLoad(function() {
        var tc = new dijit.layout.TabContainer({
            style: "height: 100%; width: 100%;"
        },
        "tc1-prog");

        var cp1 = new dijit.layout.ContentPane({
            title: "Food",
            content: "We offer amazing food"
        });
        tc.addChild(cp1);

        var cp2 = new dijit.layout.ContentPane({
            title: "Drinks",
            content: "We are known for our drinks."
        });
        tc.addChild(cp2);

        tc.startup();
    });
</script>
<div style="width: 350px; height: 290px">
    <div id="tc1-prog">
    </div>
</div>
<!-- _______________________________________________________________________ -->

<h2>Creating DropDownButtons</h2>
<div dojoType="dijit.form.ComboButton" onclick="save_function">
    <span>File</span>
            <div dojoType="dijit.Menu" id="saveMenu" 
   toggle="fade" style="display: none;">
                <div dojoType="dijit.MenuItem"
                     iconClass="dijitEditorIcon dijitEditorIconSave" 
    onclick="save_function">
                    Save
                </div>
                <div dojoType="dijit.MenuItem" onclick="save_as_function">
                    Save As
                </div>
            </div>
        </div>
<div dojoType="dijit.form.DropDownButton">
            <span>Edit</span>
            <div dojoType="dijit.Menu" id="Edit">
                <div dojoType="dijit.MenuItem" label="Copy"
                        onclick="call_function('copy');"></div>
                <div dojoType="dijit.MenuItem" label="Cut" 
                        onclick="call_function('cut');"></div>
                <div dojoType="dijit.MenuItem" label="Paste"
                        onclick="call_function('paste');"></div>
            </div>
        </div>

  
<br><br><br><br><br><br>  
<h1>Submenu</h1>
        <style>
        .myIcon {
           background-image:
              url
(http://o.aolcdn.com/dojo/1.0.0/dijit/themes/tundra/images/checkmark.gif);
           background-position: -16px 0px;
           width: 16px;
           height: 16px;
        }
        </style>
       
        <div dojoType="dijit.Menu" id="submenu1"
                 contextMenuForWindow="true">
                <div dojoType="dijit.MenuItem" iconClass="myIcon"
                     onClick="alert('Hello world');">Enabled Item</div>
                <div dojoType="dijit.PopupMenuItem" id="submenu2">
                    <span>Submenu</span>
                    <div dojoType="dijit.Menu">
                                <div dojoType="dijit.MenuItem"
                                     onClick="alert('Submenu 1!')">
Submenu Item One</div>
                                <div dojoType="dijit.MenuItem"
                                     onClick="alert('Submenu 2!')">
Submenu Item Two</div>
                    </div>
                </div>
        </div>
        
<!-- _______________________________________________________________________ -->
<h2>TooltipDialog</h2>
  <div dojoType="dijit.form.DropDownButton">
      <span>Login Form</span>
      <div dojoType="dijit.TooltipDialog" id="dialog1" 
title="Login Form" execute="checkPw(arguments[0]);">
        <table>
          <tr>
          <td><label for="name" title="User name">
   Username</label></td>
              <td><input dojoType="dijit.form.TextBox" 
   type="text" name="oldpw"></td>
          </tr>
          <tr>
              <td><label for="loc">Password: </label></td>
              <td><input dojoType="dijit.form.TextBox" 
   type="password" name="newpw"></td>
          </tr>
          <tr>
              <td><label for="desc">Confirm Password: </label></td>
              <td><input dojoType="dijit.form.TextBox" 
  type="password" name="confirmpw"></td>
          </tr>
          <tr>
              <td colspan="2" align="center">
                  <button dojoType="dijit.form.Button"
 type="submit">Login</button></td>
          </tr>
        </table>
      </div>
  </div>
  
  
  
<!-- _______________________________________________________________________ -->
<h2>Toolbar</h2>
    <div id="toolbar1" dojoType="dijit.Toolbar">

    <div dojoType="dijit.form.Button" id="toolbar1.cut" 
iconClass="dijitEditorIcon dijitEditorIconCut" showLabel="false">Cut</div>
    <div dojoType="dijit.form.Button" id="toolbar1.copy" 
iconClass="dijitEditorIcon dijitEditorIconCopy" showLabel="false">Copy</div>
    <div dojoType="dijit.form.Button" id="toolbar1.paste" 
iconClass="dijitEditorIcon dijitEditorIconPaste" showLabel="false">Paste</div>
      
      <!-- The following adds a line between toolbar sections-->
      <span dojoType="dijit.ToolbarSeparator"></span>

      <div dojoType="dijit.form.ToggleButton" id="toolbar1.bold" 
iconClass="dijitEditorIcon dijitEditorIconBold" showLabel="false">Bold</div>
      <div dojoType="dijit.form.ToggleButton" id="toolbar1.italic" 
iconClass="dijitEditorIcon dijitEditorIconItalic" showLabel="false">Italic</div>
   </div>
   
<!-- _______________________________________________________________________ -->
<h2>ProgressBar</h2>
<script type="text/javascript">
function download(){
    // Split up bar into 5% segments
    numParts = Math.floor(100/5);
    jsProgress.update({ maximum: numParts, progress:0 });
    for (var i=0; i<=numParts; i++){
        // This plays update({progress:0}) at 1nn milliseconds,
        // update({progress:1}) at 2nn milliseconds, etc.
        setTimeout("jsProgress.update({ progress: " + i + " })",(i+1)*100 + 
Math.floor(Math.random()*100));

    }
}
</script>
    <div dojoType="dijit.ProgressBar" style="width:800px"
         jsId="jsProgress" id="downloadProgress"></div>
    <input type="button" value="Start" onclick="download();" />
    
    
    
<!-- _______________________________________________________________________ -->
<h2>ToolTip</h2>
            <span id="site1">Roseindia.net</span>
        <div dojoType="dijit.Tooltip" connectId="site1" 
label="This is a software developement company!">
        </div><br><br><br>
    <span id="site2">Newstrackindia.com</span>
        <div dojoType="dijit.Tooltip" connectId="site2" 
label="This is a news publishing site!">
        </div>
        
        
<!-- _______________________________________________________________________ -->

<h2>Simple Tree:</h2>
<script type="text/javascript">

</script>
        <div dojoType="dojo.data.ItemFileReadStore"
             url="tree.txt" jsid="popStore" />
        <div dojoType="dijit.Tree" store="popStore" 
labelAttr="sname" label="Tree"></div>



<!-- _______________________________________________________________________ -->
<h2>AccordionContainer</h2>
 <div dojoType="dijit.layout.AccordionContainer" duration="80"
                style="margin-right: 10px; width: 500px; height: 200px;">

        <div dojoType="dijit.layout.AccordionPane" selected="true" title="Benefits of Dojo">
                        <p >Benefits of Dojo: Associative arrays, Loosely typed variables, 
Regular expressions, Objects and classes, Highly evolved date, math, and string libraries, 
W3C DOM support in the Dojo.</p >
                </div>
       
                <div dojoType="dijit.layout.AccordionPane" title="Introduction to Dojo">
                     <p>This tips is light towards people with some JavaScript knowledge, 
priestly used another JavaScript (Ajax) framework before, now have a real need to use some of
 the features found in dojo.</p>
                </div>
       
                <div dojoType="dijit.layout.AccordionPane" title="WebSite for Dojo Tutorial">
                   <p>If you want to learn dojo. Please go the following url and read the dojo 
tutorials with running examples.
           URL: www.roseindia.net/dojo/</p>
                </div>
        </div>
        
        
<!-- _______________________________________________________________________ -->
<h2>ColorPalette</h2>
<div dojoType="dijit.ColorPalette" onChange="myColorPalette"></div>


<!-- _______________________________________________________________________ -->
<h2>ColorPicker</h2>
<div id="colorPicker" dojoType="dojox.widget.ColorPicker"></div>


<!-- _______________________________________________________________________ -->
<h2>Editor</h2>
<textarea name="field" dojoType="dijit.Editor">   
      This tips is light towards people with some JavaScript knowledge, priestly used
 another JavaScript (Ajax) framework before, now have a real need to use some of the 
features found in dojo. In this tips, learn about the dojo and its directory structure. 
The purpose of this tips, for a new user learn to dojo then you need to know about the 
what is dojo and its directory structure.
    </textarea>
    
<!-- _______________________________________________________________________ -->
<h2>FilteringSelect</h2>
<select dojoType="dijit.form.FilteringSelect" name="countryName" autocomplete="true"
        value="sel">
                <option value="sel" selected="selected">Austria</option>
                <option value="1" >Australia</option>
                <option value="2" >Canada</option>
                <option value="3" >Germany</option>
        <option value="4" >Japan</option>
                <option value="5" >United Kingdom</option>
                <option value="6" >United States of America</option>
        <option value="7" >Afghanistan</option>
                <option value="8" >Albania</option>
                <option value="9" >Algeria</option>
        <option value="10" >American Samoa</option>
                <option value="11" >Andorra</option>
                <option value="12" >Angola</option>
        </select>
        
        
    
<!-- _______________________________________________________________________ -->
<h2>Google Search</h2>
<script type="text/javascript">
dojo.require("dojox.data.GoogleSearchStore");

function doSearch() {
  var queryString = dojo.byId("searchText").value;
  var store = new dojox.data.GoogleWebSearchStore();
  var list = dojo.byId("searchOutput");

//Clean up previous searches text
  while(list.firstChild){
    list.removeChild(list.firstChild);
  }
  
  store.fetch({query:{text: queryString},count: 25,onComplete: function(items, request) {
//Print out the search results as an unordered list
  var delay = 0;
  dojo.forEach(items, function(item){
    var li = document.createElement("li");
    li.innerHTML = "<a href=\"" + store.getValue(item, "url")  + "\">" + 
store.getValue(item, "title") + "</a>";
    dojo.style(li, "opacity", "0");
    list.appendChild(li);

  //Fade in the results.
    delay += 500;
    dojo.fadeIn({node:li}).play(delay);          
  });
}
});
}
</script>
<table border="1" cellpadding="0" cellspacing="0" width="600" align="center">
<tr>
<td valign="top" align="CENTER">
<b>Enter your search text:</b>
<input type="text" size="20" value="" id="searchText"/>
<div dojoType="dijit.form.Button" onclick="doSearch();">
  <b>Search</b>
</div>
</td>
</tr>
<tr>
<td valign="top">
<ul id="searchOutput" class="link-list"></ul>
</td>
</tr>
</tr>
</table>




<!-- _______________________________________________________________________ -->
<h2>Dialog</h2>
 <div id="dialogOne" dojoType="dijit.Dialog" title="My Dialog Title">
            <div dojoType="dijit.layout.TabContainer" style="width: 200px; height: 300px;">
                <div dojoType="dijit.layout.ContentPane" title="foo">
                    Content of Tab "foo"
                </div>
                <div dojoType="dijit.layout.ContentPane" title="boo">
                    Hi, I'm Tab "boo"
                </div>
            </div>
        </div>
        <p>
            When pressing this button the dialog will popup:
        </p>
        <button id="buttonOne" dojoType="dijit.form.Button" type="button">
            Show me!
            <script type="dojo/method" event="onClick" args="evt">
                // Show the Dialog:
                dijit.byId("dialogOne").show();
            </script>
        </button>
        <!-- NOTE: the following script tag is not intended for usage in real
        world!! it is part of the CodeGlass and you should just remove it when
        you use the code -->
        <script type="text/javascript">
            dojo.addOnLoad(function() {
                if (document.pub) {
                    document.pub();
                }
            });
        </script>
        
<!-- _______________________________________________________________________ -->
<h2>TitlePane</h2>

<div dojoType="dijit.TitlePane" title="<b>Welcome to Roseindia 
Dojo Tutorial</b>">
           
      This tips is light towards people with some JavaScript knowledge,
 priestly used another JavaScript (Ajax) framework before, now have a real 
need to use some of the features found in dojo. In this tips, learn about 
the dojo and its directory structure. The purpose of this tips, for a new 
user learn to dojo then you need to know about the what is dojo and its 
directory structure.

        </div>

</body>
</html>
