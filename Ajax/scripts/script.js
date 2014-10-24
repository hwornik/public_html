/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
   
    
    function allhide() {
        $(".aktuell").hide();
        $("#aktiviert").hide();
        $("#menuLine").hide();
        $("#submenuback").hide();
        $(".Chronikbutton1").hide();
        $(".Gamebutton1").hide();
        $(".Toolbutton1").hide();
        $(".Laufbutton1").hide();
        $(".Laufbutton2").hide();
        $(".Laufbutton3").hide();
    }
    
    $("#bloghover").click(function(){
        window.open('http://blog.wornik.eu');
    });
    
   $("#blog").mouseover(function(){
      $("#bloghover").show();
      });
    $("#bloghover").mouseleave(function(){
      $("#bloghover").hide();
    });
    
    $("#Wechsel").mouseover(function(){
      $("#Wechselhover").show();
      });
    $("#Wechselhover").mouseleave(function(){
      $("#Wechselhover").hide();
    });
    
    $("#dialog").dialog({ 
        autoOpen: false,
        position:  ['center','center'] ,
        width:'auto',
        height:'auto',
        resizable:false});
    
     $("#impressium").hover(function(){
      $("#dialog").dialog('open');
      },function(){
      $("#dialog").dialog("close");
    });
    

    $("#Laufen").hover(function(){
      $("#aktiviert").css({"left":'0px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    }); 
    
    $("#Tools").hover(function(){
      $("#aktiviert").css({"left":'100px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    }); 
    
    $("#Games").hover(function(){
      $("#aktiviert").css({"left":'200px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    }); 
    
    $("#Chronik").hover(function(){
      $("#aktiviert").css({"left":'300px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    });
    
    $("#Wissen").hover(function(){
      $("#aktiviert").css({"left":'400px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    });
    
    $("#Foren").hover(function(){
      $("#aktiviert").css({"left":'500px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    });
    
     $("#Foren").click(function(){
        allhide();
        $("#TextFeld").load('/Model/wissen.txt');
    });
    
     $("#Wissen").click(function(){
        allhide();
        $("#TextFeld").load('/Model/foren.txt');
    });
    
    $("#Chronik").click(function(){
        allhide();
        $("#menuLine").show();
        $("#TextFeld").load('/Model/chronik1.txt');
        $(".Chronikbutton1").css({"cursor":"pointer"});
        $(".Chronikbutton1").show();
        $(".aktuell").css({"left":'0px'});
        $(".aktuell").show();
        $("#submenuback").css({"background-color":"#FBC8FA"});
        $("#submenuback").show();

    });
    
    $("#Tools").click(function(){
        allhide();
        $("#menuLine").show();
        $("#TextFeld").load('/Model/tools1.txt');
        $(".Toolbutton1").css({"cursor":"pointer"});
        $(".Toolbutton1").show();
        $(".aktuell").css({"left":'0px'});
        $(".aktuell").show();
        $("#submenuback").css({"background-color":"#5C80EA"});
        $("#submenuback").show();

    });
    
    $("#Games").click(function(){
        allhide();
        $("#menuLine").show();
        $("#TextFeld").load('/Model/games1.txt');
        $(".Gamebutton1").css({"cursor":"pointer"});
        $(".Gamebutton1").show();
        $(".aktuell").css({"left":'0px'});
        $(".aktuell").show();
        $("#submenuback").css({"background-color":"#DC0767"});
        $("#submenuback").show();

    });
        var system="hallooooooo";
    
    $("#Laufen").click(function(){
        allhide();
        $("#menuLine").show();
        $("#TextFeld").load('/Model/sport.txt');
        $(".Laufbutton1").css({"cursor":"pointer"});
        $(".Laufbutton2").css({"cursor":"pointer"});
        $(".Laufbutton3").css({"cursor":"pointer"});
        $(".Laufbutton1").show();
        $(".Laufbutton2").show();
        $(".Laufbutton3").show();
        $(".aktuell").css({"left":'0px'});
        $(".aktuell").show();
        $("#submenuback").css({"background-color":"#F4D061"});
        $("#submenuback").show();
    });

    $(".Laufbutton1").click(function(){
        $("#TextFeld").load('/Model/sport.txt');
        $(".aktuell").css({"left":'0px'});
    });
    
    $(".Laufbutton2").click(function(){
        $("#TextFeld").load('/Model/training.txt');
        $(".aktuell").css({"left":'140px'});  
    });
    
    $(".Laufbutton3").click(function(){
        $("#TextFeld").load('/Model/trchronik.txt');
        $(".aktuell").css({"left":'280px'}); 
    });
    
    if(system.indexOf('Touch Screen User')>=0)
    {
        $('.Phone').hide();
        $('.Pc').show();
    }
    else
    {
        $('.Pc').hide();
        $('.Phone').show();
    }
    
    
    $('#Wechselhover').click(function(){
        if(system.indexOf('Touch Screen User')>=0)
        {
            window.open('/?switch=switch','_self');  
        }
        else
        {
            window.open('/?switch=Touch','_self');
        }
    });

});





