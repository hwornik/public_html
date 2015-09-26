<?php

class Footer {
    
    public function anfang() {
        print('<footer>');
    }
    
    public function ende() {
        
                print("<script> require([ 
                'dojo/dom',
                'dojo/dom-construct',
                'dojo/fx',
                'dojo/domReady!'
        ], function (dom, domConstruct,fx) {
            var greetingNode = dom.byId('titel');
                fx.slideTo({node: greetingNode,top: 30,left: 200}).play();
        });</script>'"); 
        print('<script>require(["dojo/parser", "dijit/DropDownMenu", "dijit/MenuItem", "dijit/MenuSeparator", "dijit/PopupMenuItem"]);</script>');
         print('</footer></body>
            </html>
                ');
    }
    
}
