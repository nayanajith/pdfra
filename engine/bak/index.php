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

				dojo.require("dojo.data.ItemFileReadStore");
				dojo.require("dijit.Tree");
        </script>
        <link rel="stylesheet" type="text/css" href="../js/dijit/themes/claro/claro.css"
        />
        <style type="text/css">
            html, body { width: 100%; height: 100%; margin: 0; overflow:hidden; }
            #borderContainerTwo { width: 100%; height: 100%; }
				body
				{
				background-image:url('bodyBg.gif');
				background-repeat:repeat-x;
				}
        </style>
    </head>
    
    <body class="claro">
   	<div dojoType="dijit.layout.BorderContainer" style="width: 100%; height: 100%; background-image:testBg.gif;"  gutters="true" liveSplitters="true">
            <div dojoType="dijit.layout.ContentPane" region="top" gutter="false" >
					<!-- bannar -->
					<img src="ucsc-logo.jpg" width=60px style='float:left'/><h1>University of colombo School of Computing</h1>
            </div>
            <div dojoType="dijit.layout.ContentPane" region="leading"  splitter="true" minSize="20" style="width: 200px;">
					<!-- left menu/tree/accrodian -->
					<!--
                <div dojoType="dijit.layout.AccordionContainer" minSize="20" style="width: 200px;"id="leftAccordion" region="leading" splitter="true">
                    <div dojoType="dijit.layout.AccordionPane" title="One fancy Pane">
                    </div>
                    <div dojoType="dijit.layout.AccordionPane" title="Another one">
                    </div>
                    <div dojoType="dijit.layout.AccordionPane" title="Even more fancy" selected="true">
                    </div>
                    <div dojoType="dijit.layout.AccordionPane" title="Last, but not least">
                    </div>
                </div>
					 -->
                <!-- end AccordionContainer -->

  					<div dojoType="dojo.data.ItemFileReadStore" jsId="continentStore" url="countries.json">
        			</div>
        			<div dojoType="dijit.tree.ForestStoreModel" jsId="continentModel" store="continentStore"
        				query="{type:'continent'}" rootId="continentRoot" rootLabel="Continents"
        				childrenAttrs="children">
        			</div>
        			<div dojoType="dijit.Tree" id="mytree2" model="continentModel" showRoot="false">
       			</div>

            </div>
            <div dojoType="dijit.layout.ContentPane" region="center" style="padding:0px;" >
					<div dojoType="dijit.layout.BorderContainer" style="width: 100%; height: 100%; padding:0px;" gutters="true">
						<div dojoType="dijit.layout.ContentPane" region="top" style="height:100px; padding:0px;">
						<!-- menubar and menu -->
							<div dojoType="dijit.layout.BorderContainer" style="width: 100%; height: 100%; padding:0px;" gutters="false">
								<div dojoType="dijit.layout.ContentPane" region="top" style=" padding:0px;">
								<!-- menu bar -->
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
							<!--Menu-->
							menu
							</div>
  							<!-- end center -->
						</div>
  						<!-- end bc -->
					</div>
  					<!-- end top -->
   			<div dojoType="dijit.layout.ContentPane" region="center">
				<!-- body -->
				body
				</div>
  				<!-- end center -->
   			<div dojoType="dijit.layout.ContentPane" region="bottom"  >
				<!-- status bar -->
				status bar					
				</div>
			</div>
		</div>
         <div dojoType="dijit.layout.ContentPane" region="trailing" splitter="true">
			<!-- right menu -->
          Trailing pane
         </div>
         <div dojoType="dijit.layout.ContentPane" region="bottom" style="height:20px;">
			<!-- footer -->
				<h1>ABOUT University of colombo School of Computing</h1>
         </div>
		</div>
	</body>
</html>
