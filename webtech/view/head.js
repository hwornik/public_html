// Buttons
/*require(["dijit/form/Button", "dojo/dom", "dojo/domReady!","dojo/dom-construct"], function(Button, dom){
    // Create a button programmatically:
    var myButton = new Button({
          onClick: function(dom, domConstruct){
            // Do something:
           myDialog.show();
       }
    }, "buttonlogon").startup();
            });
            */
require(["dijit/form/Button", "dojo/dom", "dojo/domReady!"], function(Button, dom){
    // Create a button programmatically:
    var myButton = new Button({
          onClick: function(){
            // Do something:
            startRegistration();
        }
    }, "buttonregister").startup();
            });
require(["dijit/form/Button", "dojo/dom", "dojo/domReady!"], function(Button, dom){
    // Create a button programmatically:
    var myButton = new Button({
          onClick: function(){
            // Do something:
            restartRegistration();
        }
    }, "buttonreregister").startup();
            });
            
require(["dijit/form/CheckBox", "dojo/domReady!"], function(CheckBox){
    var checkBox = new CheckBox({
        name: "checkBox",
        value: "agreed",
        checked: false,
    }, "cookie").startup();
});

require(["dijit/form/TextBox", "dojo/domReady!"], function(TextBox){
    var myTextBox = new dijit.form.TextBox({
        name: "firstname",
        value: "" /* no or empty value! */,
        placeHolder: "username"
    }, "logon");
});   


require([ 
                'dojo/dom',
                'dojo/dom-construct',
                'dojo/fx',
                'dojo/domReady!'
        ], function (dom, domConstruct,fx) {
            var greetingNode = dom.byId('titel');
                fx.slideTo({node: greetingNode,top: 30,left: 200}).play();
}); 
    require(["dojo/parser", "dijit/form/DropDownButton", "dijit/TooltipDialog", "dijit/form/TextBox", "dijit/form/Button", "dojo/domReady!"],
    function(parser){
        parser.parse();
    });
        


    
    
    
