/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

    
    $("#areainformatik").hover(function(){
      $("#areainformatik").css({"background-color":'black'});
      },function(){
      $("#areainformatik").css({"background-color":'#9A3AF9'});
    }); 
    
    $("#areapsychologie").hover(function(){
      $("#areapsychologie").css({"background-color":'black'});
      },function(){
      $("#areapsychologie").css({"background-color":'#9A3AF9'});
    }); 
    
    $("#areametaphysik").hover(function(){
      $("#areametaphysik").css({"background-color":'black'});
      },function(){
      $("#areametaphysik").css({"background-color":'#9A3AF9'});
    });
    
    $("#areainformatik").click(function(){
        window.open('http://wikiinfo.wornik.eu')
    });
    
    $("#areapsychologie").click(function(){
        window.open('http://wikipsy.wornik.eu')
    });
    
    $("#areametaphysik").click(function(){
            window.open('http://wikimph.wornik.eu')
        });
}); 

