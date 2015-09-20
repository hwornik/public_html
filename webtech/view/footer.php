<?php

class Footer {
    
    public function anfang() {
        print('<footer>');
    }

        public function ende() {
                print("<script> require([ 'dojo/dom',
            'dojo/dom-construct'
        ], function (dom, domConstruct) {
            var greetingNode = dom.byId('titel');
            domConstruct.place('<em> Dojo!</em>', greetingNode);
        });
            </script>'");   
        print('</footer></body>
            </html>
                ');
    }
    
}
