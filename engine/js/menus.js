var _currentMenu = "";

// construct the menu bar by concatinating DIV section name attributes 
// with the calss name aMenus. 
function constructMenu(){
    var i = 0;
    var _menu_items = [];
    var _menus = "<table><tr>";

    $(".aMenu").each(function(index){
	 _menu_items[i] = $(this).attr('id');
	 _menus += "<td class=menuBarItem onClick=\"_changeMenu('"+_menu_items[i]+"')\">"+$(this).attr('name')+"</td>";
         $("#"+_menu_items[i]).hide();
         i++;
    });
    // if user is logged in add logout button
    if($("#loginMenu").length == 0){
      _menus += "<td class=menuBarItem onClick=\"_logout()\">Logout</td>";
    }

     _menus +="</tr></table>";
    
     //alert(_menus);
     $("#menuBarDiv").html(_menus);
     _currentMenu = _menu_items[0];
     // if login errors occur show the login section again
     if($("#error").length > 0){
       _currentMenu = _menu_items[1];
     }
     $("#"+_currentMenu).show();

}
 

function _changeMenu(menuName) {
    $("#"+_currentMenu).hide();
    $("#"+menuName).show();
    _currentMenu = menuName;
    
}

function _logout(){
   $("#logOut").submit();
}
 