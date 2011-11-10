<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr">
    
    <head>
        <style type="text/css">
            body, html { font-family:helvetica,arial,sans-serif; font-size:90%; }
        </style>
        <script src="../js/dojo/dojo.js"
        djConfig="parseOnLoad: true">
        </script>
        <script type="text/javascript">
            dojo.require("dijit.layout.ContentPane");
            dojo.require("dijit.layout.BorderContainer");
            dojo.require("dijit.layout.TabContainer");
            dojo.require("dijit.layout.AccordionContainer");
				
				dojo.require("dijit.MenuBar");
				dojo.require("dijit.PopupMenuBarItem");
				dojo.require("dijit.Menu");
				dojo.require("dijit.MenuItem");
				dojo.require("dijit.PopupMenuItem");
        </script>
        <link rel="stylesheet" type="text/css" href="../js/dijit/themes/claro/claro.css"
        />
        <style type="text/css">
            html, body { width: 100%; height: 100%; margin: 0; overflow:hidden; }
            #borderContainerTwo { width: 100%; height: 100%; }
        </style>
</head>
<body class="claro">
<div dojoType="dijit.layout.BorderContainer" style="width: 100%; height: 100%" gutters="true">
<div dojoType="dijit.layout.ContentPane" region="top" style="height:120px;">
	<div dojoType="dijit.layout.BorderContainer" style="width: 100%; height: 100%" gutters="true">
		<div dojoType="dijit.layout.ContentPane" region="top" >
			<div dojoType="dijit.MenuBar" id="navMenu" >
				<div dojoType="dijit.PopupMenuBarItem">
					<span>
					File
					</span>
					<div dojoType="dijit.Menu" id="fileMenu">
						<div dojoType="dijit.MenuItem" onClick="alert('file 1')">
						File #1
						</div>
						<div dojoType="dijit.MenuItem" onClick="alert('file 2')">
						File #2
						</div>
					</div>
				</div>
				<div dojoType="dijit.PopupMenuBarItem">
					<span>
						Edit
					</span>
					<div dojoType="dijit.Menu" id="editMenu">
						<div dojoType="dijit.MenuItem" onClick="alert('edit 1')">
						Edit #1
						</div>
						<div dojoType="dijit.MenuItem" onClick="alert('edit 2')">
						Edit #2
						</div>
					</div>
				</div>
			</div>
  <!-- end MenuBar -->

		</div>
  <!-- end top -->
      <div dojoType="dijit.layout.ContentPane" region="bottom" style="height:50px;">
		menu
		</div>
  <!-- end center -->
	</div>
  <!-- end bc -->
	</div>
  <!-- end top -->
   <div dojoType="dijit.layout.ContentPane" region="center">
	body
	</div>
  <!-- end center -->
   <div dojoType="dijit.layout.ContentPane" region="bottom">
status bar	
	</div>
  <!-- end bottom -->
</div>
<!-- end bc -->
</body>
</html>



