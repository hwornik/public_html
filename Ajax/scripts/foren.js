/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
     $("#areainfo").hover(function(){
      $("#areainfo").css({"background-color":'darkgreen'});
      },function(){
      $("#areainfo").css({"background-color":'#00cf00'});
    });
    
    $("#areapsycho").hover(function(){
      $("#areapsycho").css({"background-color":'darkgreen'});
      },function(){
      $("#areapsycho").css({"background-color":'#00cf00'});
    });
    
    $("#areawindows").hover(function(){
      $("#areawindows").css({"background-color":'darkgreen'});
      },function(){
      $("#areawindows").css({"background-color":'#00cf00'});
    });
    
    $("#arealaufen").hover(function(){
      $("#arealaufen").css({"background-color":'darkgreen'});
      },function(){
      $("#arealaufen").css({"background-color":'#00cf00'});
    });
    
    $("#arealinux").hover(function(){
      $("#arealinux").css({"background-color":'darkgreen'});
      },function(){
      $("#arealinux").css({"background-color":'#00cf00'});
    });
    
    $("#areainfo").click(function(){
        window.open('http://infostud.wornik.eu')
    });
    
    $("#areapsycho").click(function(){
        window.open('http://psystud.wornik.eu')
    });
    
    $("#arealaufen").click(function(){
        window.open('http://laufen.wornik.eu')
    });
    
    $("#arealinux").click(function(){
        window.open('http://linux.wornik.eu')
    });
    
    $("#areawindows").click(function(){
        window.open('http://windows.wornik.eu')
    });
    
});