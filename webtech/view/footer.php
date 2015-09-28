<?php

class Footer {
    
    public function anfang() {
        print('<footer>');
    }
    
    public function ende() {
        //lade dojo elemente für den head
        print('<script src="//localhost/webtech/view/head.js"></script>');
         print('</footer></body>
            </html>
                ');
    }
    
}
