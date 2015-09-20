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
            domConstruct.place('<em> Dojo!</em>', greetingNode);
                fx.slideTo({
        node: greetingNode,
        top: 100,
        left: 200
    }).play();
        });
            </script>'");   
        print('</footer></body>
            </html>
                ');
    }
    
}
