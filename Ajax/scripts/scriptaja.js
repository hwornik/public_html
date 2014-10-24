/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

       function doIt(was) {
 
            //erstellen des requests
            var req = null;
 
            try {
                req = new XMLHttpRequest();
            }
            catch (ms) {
                try {
                    req = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (nonms) {
                    try {
                        req = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch (failed) {
                        req = null;
                    }
                }
            }
 
            if (req == null) {
                alert("Error creating request object!");
            }
            //anfrage erstellen (GET, url ist localhost,
            //request ist asynchron
            var url = '/Model/start.txt';
            if(was=="sport")
            {
                    var url = '/Model/sport.txt';
            }
            if(was=="tools1")
            {
                    var url = '/Model/tools1.txt';
            }
            if(was=="training")
            {
                    var url = '/Model/training.txt';
            }
            if(was=="trchronik")
            {
                    var url = '/Model/trchronik.txt';
            }
            req.open("POST", url, true);
 
            //Beim abschliessen des request wird diese Funktion ausgeführt
            req.onreadystatechange = function() {
                switch (req.readyState) {
                    case 4:
                        if (req.status != 200) {
                            alert("Fehler:" + req.status);
                        } else {
                            //alert(req.responseText);
                            //schreibe die antwort in den div
                            //container mit der id content
                            var result = '<strong>'+req.responseText+'</strong>';
                            document.getElementById('TextFeld').innerHTML = result;
                        }
                        break;
 
                    default:
                        return false;
                        break;
                }
            };
 
            req.setRequestHeader("Content-Type",
                    "application/x-www-form-urlencoded");
            req.send(null);
        }
//dojo menu

 // Require dependencies
        require([
            "dijit/Menu",
            "dijit/MenuItem",
            "dijit/PopupMenuItem",
            "dojo/domReady!"
        ], function(Menu, MenuItem, PopupMenuItem){
            // create the Menu container
            var mainMenu = new Menu({
            }, "menu");
 
            // create Menu container and child MenuItems
            // for our sub-menu (no srcNodeRef; we will
            // add it under a PopupMenuItem)
            var taskMenu = new Menu({
                id: "taskMenu"
            });
 
            // define the task sub-menu items
            taskMenu.addChild( new MenuItem({
                id: "complete",
                label: "Mark as Complete"
            }) );
 
            taskMenu.addChild( new MenuItem({
                id: "cancel",
                label: "Cancel"
            }) );
 
            taskMenu.addChild( new MenuItem({
                id: "begin",
                label: "Begin"
            }) );
 
            // create and add main menu items
            mainMenu.addChild( new MenuItem({
                id: "Laufen",
                label: "Laufen"
            }) );
 
            mainMenu.addChild( new MenuItem({
                id: "view",
                label: "View"
            }) );
 
            // make task menu item open the sub-menu we defined above
            mainMenu.addChild( new PopupMenuItem({
                id: "task",
                label: "Task",
                popup: taskMenu
            }) );
 
            mainMenu.startup();
            taskMenu.startup();
        });
        
        //Tabkörper
        
        require(["dojo/ready", "dijit/layout/BorderContainer", "dijit/layout/ContentPane", "dijit/layout/TabContainer"], function(ready, BorderContainer, ContentPane, TabContainer){
        ready(function(){
        // create a BorderContainer as the top widget in the hierarchy
        var bc = new ContentPane({style: "height: 100%; width: 100%;"});

        // create a ContentPane as the left pane in the BorderContainer

        // create a TabContainer as the center pane in the BorderContainer,
        // which itself contains two children
        var tc = new TabContainer({region: "center"});
        var tab1 = new ContentPane({title: "Laufen",content: '<p id="laufen">hallo</p>'}),
        tab2 = new ContentPane({title: "Wissen",content: '<p id="wissen">hallo</p>'}),
        tab3 = new ContentPane({title: "Chronik",content: '<p id="chronik">hallo</p>'}),
        tab4 = new ContentPane({title: "Games",content: '<p id="ganes">hallo</p>'}),
        tab5 = new ContentPane({title: "Personal",content: '<p id="personal">hallo</p>'}),
        tab6 = new ContentPane({title: "Tools",content: '<p id="tools">hallo</p>'}),
        tab7 = new ContentPane({title: "Foren",content: '<p id="foren">hallo</p>'});
        tc.addChild( tab1 );
        tc.addChild( tab2 );
        tc.addChild( tab3 );
        tc.addChild( tab4 );
        tc.addChild( tab5 );
        tc.addChild( tab6 );
        tc.addChild( tab7 );
        bc.addChild(tc);

        // put the top level widget into the document, and then call startup()
        document.body.appendChild(bc.domNode);
        bc.startup();
    });
});