dependencies = {
	stripConsole: "normal",
	layers: [
		{
			name: "../dijit/ucscis.js",
			dependencies: [
				"dijit.layout.ContentPane",
            "dijit.layout.BorderContainer",
            "dijit.layout.TabContainer",
            "dijit.layout.AccordionContainer",
				"dijit.Dialog",
 	 	 	 	"dijit.MenuBar",
 	 	 	 	"dijit.PopupMenuBarItem",
 	 	 	 	"dijit.Menu",
 	 	 	 	"dijit.MenuItem",
 	 	 	 	"dijit.PopupMenuItem",
 	 	 	 	"dijit.Toolbar",
 	 	 	 	"dijit.Tree",
				"dijit.InlineEditBox",
				"dijit.TooltipDialog",
				"dijit.Tooltip",
				"dijit.form.TimeTextBox",
 	 	 	 	"dijit.form.ComboButton",
            "dijit.form.FilteringSelect",
            "dijit.form.ComboBox",
 	 	 	 	"dijit.form.RadioButton",
 	 	 	 	"dijit.form.CheckBox",
 	 	 	 	"dijit.form.TextBox",
 	 	 	 	"dijit.form.Textarea",
 	 	 	 	"dijit.form.DateTextBox",
 	 	 	 	"dijit.form.NumberSpinner",
            "dijit.form.HorizontalSlider",
 	 	 	 	"dijit.form.ValidationTextBox",
 	 	 	 	"dijit.form.Form",
            "dijit.form.Button",
				"dijit.ProgressBar"
			]
		},
		{
			name: "../dojo/ucscis.js",
			dependencies: [
 	 	 	 	"dojo.data.ItemFileReadStore",
 	 	 	 	"dojo.data.ItemFileWriteStore"
			]
		},
		{
			name: "../dojox/ucscis.js",
			dependencies: [
 	 	 	 	"dojox.grid.DataGrid",
 	 	 	 	"dojox.data.QueryReadStore",
            "dojox.form.PasswordValidator",
            "dojox.widget.PlaceholderMenuItem"
			]
		}
	],

	prefixes: [
		//[ "dojo", "../dojo" ],
		[ "dijit", "../dijit" ],
		[ "dojox", "../dojox" ]
	]
};
