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
        $(".Gamebutton2").hide();
        $(".Gamebutton3").hide();
        $(".Toolbutton1").hide();
        $(".Laufbutton1").hide();
        $(".Laufbutton2").hide();
        $(".Laufbutton3").hide();
    }
    
   
    $("#bloghover").click(function(){
        window.open('http://blog.wornik.eu')
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
      $("#aktiviert").css({"left":'150px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    }); 
    
    $("#Games").hover(function(){
      $("#aktiviert").css({"left":'300px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    }); 
    
    $("#Chronik").hover(function(){
      $("#aktiviert").css({"left":'450px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    });
    
    $("#Wissen").hover(function(){
      $("#aktiviert").css({"left":'600px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    });
    
    $("#Schach").hover(function(){
      $("#aktiviert").css({"left":'750px'}); 
      $("#aktiviert").show();
      },function(){
      $("#aktiviert").hide();
    });
    
     $("#Schach").click(function(){
        allhide();
        $("#TextFeld").load('/Model/foren.txt');
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
        $("#submenuback").css({"background-color":"lightblue"});
        $("#submenuback").show();

    });
    
    $("#Games").click(function(){
        allhide();
        $("#menuLine").show();
        $("#TextFeld").load('/Model/wissen.txt');
        $(".Gamebutton1").css({"cursor":"pointer"});
        $(".Gamebutton2").css({"cursor":"pointer"});
        $(".Gamebutton3").css({"cursor":"pointer"});
        $(".Gamebutton1").show();
        $(".Gamebutton2").show();
        $(".Gamebutton3").show();
        $(".aktuell").css({"left":'0px'});
        $(".aktuell").show();
        $("#submenuback").css({"background-color":"#DC8407"});
        $("#submenuback").show();

    });
    
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

    $("#Schach").click(function(){
        allhide();
        $("#TextFeld").load('/Model/wissen.txt');
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
    
        $(".Gamebutton1").click(function(){
        $("#TextFeld").load('/Model/wissen.txt');
        $(".aktuell").css({"left":'0px'}); 
    });
    
    $(".Gamebutton2").click(function(){
        $("#TextFeld").load('/Model/partien.txt');
        $(".aktuell").css({"left":'140px'});    });
    
    $(".Gamebutton3").click(function(){    
        $("#TextFeld").load('/Model/archiv.txt');
        $(".aktuell").css({"left":'320px'});
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



/* Katzen slideshow */
// Michou ***********************************************
// Open the Modal
function openModal() {
  document.getElementById('myModal').style.display = "block";
}

// Close the Modal
function closeModal() {
  document.getElementById('myModal').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}

// Merlin ***********************************************
// Open the Modal
function openModal2() {
  document.getElementById('myModal2').style.display = "block";
}

// Close the Modal
function closeModal2() {
  document.getElementById('myModal2').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides2(n) {
  showSlides2(slideIndex += n);
}

// Thumbnail image controls
function currentSlide2(n) {
  showSlides2(slideIndex = n);
}

function showSlides2(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides2");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption2");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}



