/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//http://diveintohtml5.info/storage.html
function supports_html5_storage() {
  try {
    return 'localStorage' in window && window['localStorage'] !== null;
  } catch (e) {
    return false;
  }
}

function checkStorage() {
    if(supports_html5_storage())
    {
        self.location.href="/webtech/index.php?storage=yes"
    }
    else
    {
        self.location.href="/webtech/index.php?storage=no"
    }
}

function hashit(data) {
    
    return CryptoJS.SHA256(data).toString();

}

function getLastDateInMonth(y, m){

        var d = new Date(y, m+1, 1);
        d.setTime(d.getTime() - 12*3600*1000);
        return d;
    }
    
/**
 * AES 
 * @param {type} x
 * @returns {CryptItem}
 */
function CryptItem(x) {
    
    this.wert= x;
    
    this.encrypt = function(k) {
        if(this.wert.length>0)
        {
            //return stringToHex(CryptoJS.AES.encrypt(this.wert, "Secret Passphrase"));
            return Aes.Ctr.encrypt(this.wert, k, 256);
        }
        else
        {
            return "";
        }
    }
    
    this.decrypt = function(k) {
        if(this.wert.length>0)
        {
            //CryptoJS.AES.decrypt(hexToString(this.wert), "Secret Passphrase");
            return Aes.Ctr.decrypt(this.wert, k, 256);//replace('/[:space:]+',''); //$str = preg_replace ( '/\s\s+/' , ' ' , $str );
        }
        else
        {
            return "";
        }
    }
    
}

function Person() {
    
    this.key ="";
    this.code="";
    this.angzname="";
    this.vname="";
    this.nname="";
    this.logon="";
    this.email="";
    this.email2="";
    this.ort="";
    this.str="";
    this.land="";
    this.passwt="";
    
    this.getKeyafillformReg = function() {
        var formatt =document.getElementsByTagName("input");
        this.key = formatt[2].value;
        this.code = formatt[3].value;
        this.angzname=new CryptItem(formatt[4].value);
        this.vname=new CryptItem(formatt[5].value);
        this.nname=new CryptItem(formatt[6].value);
        this.logon=new CryptItem(formatt[7].value);
        this.email=new CryptItem(formatt[8].value);
        this.email2=new CryptItem(formatt[9].value);
        this.strasse=new CryptItem(formatt[10].value);
        this.ort=new CryptItem(formatt[11].value);
        this.land=new CryptItem(formatt[12].value);

        formatt[4].value=this.angzname.decrypt(this.key );
        formatt[4].setAttribute("type", "text");
        formatt[5].value=this.vname.decrypt(this.key );
        formatt[5].setAttribute("type", "text");
        formatt[6].value=this.nname.decrypt(this.key );
        formatt[6].setAttribute("type", "text");
        formatt[7].value=this.logon.decrypt(this.key );
        formatt[7].setAttribute("type", "text");
        formatt[8].value=this.email.decrypt(this.key );
        formatt[8].setAttribute("type", "email");
        formatt[9].value=this.email2.decrypt(this.key );
        formatt[9].setAttribute("type", "email");
        formatt[10].value=this.strasse.decrypt(this.key );
        formatt[10].setAttribute("type", "text");
        formatt[11].value=this.ort.decrypt(this.key );
        formatt[11].setAttribute("type", "text");
        formatt[12].value=this.land.decrypt(this.key );
        formatt[12].setAttribute("type", "text");
       
    }

    this.logout = function() {
        alert('Passwort wurde geändert, Sie werden nun Ausgeloggt');
        var form = document.createElement("form");
        form.setAttribute("action", "?ende");
        form.setAttribute("method", "POST");
        document.body.appendChild(form);
        form.submit();
    }
    this.decryptEinstellungen = function() {

        var formatt =document.getElementsByTagName("input");
        this.key=localStorage.getItem("key");
        this.code = formatt[2].value;
        this.angzname=new CryptItem(formatt[3].value);
        this.vname=new CryptItem(formatt[4].value);
        this.nname=new CryptItem(formatt[5].value);
        this.email=new CryptItem(formatt[6].value);
        this.strasse=new CryptItem(formatt[7].value);
        this.ort=new CryptItem(formatt[8].value);
        this.land=new CryptItem(formatt[9].value);

        formatt[3].value=this.angzname.decrypt(this.key );
        formatt[3].setAttribute("type", "text");
        formatt[4].value=this.vname.decrypt(this.key );
        formatt[4].setAttribute("type", "text");
        formatt[5].value=this.nname.decrypt(this.key );
        formatt[5].setAttribute("type", "text");
        formatt[6].value=this.email.decrypt(this.key );
        formatt[6].setAttribute("type", "email");
        formatt[7].value=this.strasse.decrypt(this.key );
        formatt[7].setAttribute("type", "text");
        formatt[8].value=this.ort.decrypt(this.key );
        formatt[8].setAttribute("type", "text");
        formatt[9].value=this.land.decrypt(this.key );
        formatt[9].setAttribute("type", "text");
    }
    
    this.sendformReg = function() {
        if(!supports_html5_storage())
        {
            alert('Kann Daten nicht verschlüsseln, da local Storage deaktiviert ist');
            self.location.href="?storage=no";
            return;
        }
        var formatt =document.getElementsByTagName("input");
        var form = document.createElement("form");
        form.setAttribute("action", "?Register");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",this.code);
        form.appendChild(hiddenField);
        var cd = new CryptItem(this.key);
        hiddenField = document.createElement("input");
        var valid = CryptItem(this.key);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "key");
        hiddenField.setAttribute("value", cd.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.angzname= new CryptItem(formatt[4].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "angzname");
        hiddenField.setAttribute("value", this.angzname.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.vname= new CryptItem(formatt[5].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "vname");
        hiddenField.setAttribute("value", this.vname.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.nname= new CryptItem(formatt[6].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "nname");
        hiddenField.setAttribute("value", this.nname.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.logon= new CryptItem(formatt[7].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "logon");
        hiddenField.setAttribute("value", this.logon.enccrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.email= new CryptItem(formatt[8].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "email");
        hiddenField.setAttribute("value", this.email.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.email2= new CryptItem(formatt[9].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "email2");
        hiddenField.setAttribute("value", this.email2.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.strasse = new CryptItem(formatt[10].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "str");
        hiddenField.setAttribute("value", this.strasse.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.ort= new CryptItem(formatt[11].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "ort");
        hiddenField.setAttribute("value", this.ort.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.land = new CryptItem(formatt[12].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "land");
        hiddenField.setAttribute("value", this.land.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "captcha_code");
        hiddenField.setAttribute("value", formatt[13].value);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
    
    this.speichereEin = function()  {

        this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("input");
        this.code = formatt[2].value;
        var form = document.createElement("form");
        form.setAttribute("action", "?aendereEin");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",this.code);
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.angzname= new CryptItem(formatt[3].value);     
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "angzname");
        hiddenField.setAttribute("value", this.angzname.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.vname= new CryptItem(formatt[4].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "vname");
        hiddenField.setAttribute("value", this.vname.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.nname= new CryptItem(formatt[5].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "nname");
        hiddenField.setAttribute("value", this.nname.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.email= new CryptItem(formatt[6].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "email");
        hiddenField.setAttribute("value", this.email.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.strasse = new CryptItem(formatt[7].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "str");
        hiddenField.setAttribute("value", this.strasse.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.ort= new CryptItem(formatt[8].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "ort");
        hiddenField.setAttribute("value", this.ort.encrypt(this.key));
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        this.land = new CryptItem(formatt[9].value);
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "land");
        hiddenField.setAttribute("value", this.land.encrypt(this.key));
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
    
    this.sendformActivat = function() {
        var formatt =document.getElementsByTagName("input");
        this.code=new CryptItem(formatt[2].value);
        if(this.code.wert.length>0)
        {
            if(formatt[3].value === formatt[4].value)
            {
                if(formatt[3].value.length > 8 )
                {
                    
                    var hash = CryptoJS.SHA256(formatt[3].value);
                    this.passwt=new CryptItem(hash.toString());
                    var form = document.createElement("form");
                    form.setAttribute("action", "?actconfirm");
                    form.setAttribute("method", "POST"); 
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "code");
                    hiddenField.setAttribute("value", this.code.encrypt(this.code.wert));
                    form.appendChild(hiddenField);
                    hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "passwt");
                    hiddenField.setAttribute("value", this.passwt.encrypt(this.code.wert));
                    form.appendChild(hiddenField);
                    document.body.appendChild(form);
                    form.submit();
                    
                }
                else
                {
                    alert('Passwort zu kurz, mindestens 8 Zeichen nötig');
                }
            }
            else
            {
                alert('Passwörter stimmen nicht überein')
            }
        }
        else
        {
            alert('Aktivierungscode darf nicht leer sein')
        }
        
    }
    
    this.sendID = function() {
        if(!supports_html5_storage())
        {
            alert('Kann Daten nicht verschlüsseln, da local Storage deaktiviert ist kein Login möglich6');
            self.location.href="?storage=no";
            return;
        }
        var formatt1 = document.getElementById("cookie");
        var formatt = document.getElementById("logon");
        var form = document.createElement("form");
        form.setAttribute("action", "?Challenge");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "meins");
        hiddenField.setAttribute("value",hashit(formatt.value));
        form.appendChild(hiddenField);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "cookie");
        hiddenField.setAttribute("value",formatt1.checked);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
    
    this.compChallenge = function() {
        var formatt =document.getElementsByTagName("input");
        localStorage.removeItem("key");
        this.key = hashit(window.prompt("Bitte geben Sie das Passwort ein", ""));
        this.angzname=new CryptItem(formatt[0].value);
        var ciphertext = this.angzname.decrypt(this.key);
        var chall=parseInt(ciphertext);
        var teil=Math.pow(10,parseInt(chall/1000000000));
        var zahl2=chall%teil;
        var zahl1=chall + zahl2+1;
        var ziel = new CryptItem(zahl1.toString());
        var sendech=ziel.encrypt(this.key);
        localStorage.setItem("key",this.key);
        var form = document.createElement("form");
        form.setAttribute("action", "?check");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "chall");
        hiddenField.setAttribute("value",sendech);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
        
    }
    
    this.compChallengeCookie = function() {
        var formatt =document.getElementsByTagName("input");
        this.key=localStorage.getItem("key");
        if(this.key.length<2)
        {
            this.key = hashit(window.prompt("Bitte geben Sie das Passwort ein", ""));
            localStorage.setItem("key",this.key);
        }
        this.angzname=new CryptItem(formatt[0].value);
        var ciphertext = this.angzname.decrypt(this.key);
        var chall=parseInt(ciphertext);
        var teil=Math.pow(10,parseInt(chall/1000000000));
        var zahl2=chall%teil;
        var zahl1=chall + zahl2+1;
        var ziel = new CryptItem(zahl1.toString());
        sendech=ziel.encrypt(this.key);
        var form = document.createElement("form");
        form.setAttribute("action", "?check");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "chall");
        hiddenField.setAttribute("value",sendech);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
        
    }
    
    this.storeneuesPass = function() {
        
        var formatt =document.getElementsByTagName("input");
        this.key=localStorage.getItem("key");
        this.code = formatt[2].value;
        if(formatt[4].value === formatt[5].value)
        {
            if(formatt[4].value.length>8)
            {
                var oldpw = new CryptItem(hashit(formatt[3].value));
                var newpw = new CryptItem(hashit(formatt[4].value));
                var form = document.createElement("form");
                form.setAttribute("action", "?pasaender");
                form.setAttribute("method", "POST"); 
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "identifier");
                hiddenField.setAttribute("value",this.code);
                form.appendChild(hiddenField);
                hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "oldpw");
                hiddenField.setAttribute("value", oldpw.encrypt(this.key));
                form.appendChild(hiddenField);
                hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "newdpw");
                hiddenField.setAttribute("value", newpw.encrypt(this.key));
                form.appendChild(hiddenField);
                document.body.appendChild(form);
                form.submit();
            }
            else
            {
                alert('Passwort zu kurz, mindestens 8 Zeichen erforderlich');
            }
        }
        else
        {
            alert('Passwörter stimmen nicht überein');
        }
    }
    
    this.aenderePassw = function() {
        var formatt =document.getElementsByTagName("input");
        this.key=localStorage.getItem("key");
        this.code = formatt[2].value;
        var form = document.createElement("form");
        form.setAttribute("action", "?aenderePas");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "nachricht");
        hiddenField.setAttribute("value",'');
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
}

function Friends() {
    
    this.key ='';
    this.id='';
    this.wert='';
    this.text='';
    this.sucheFreunde = function () {
        this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("input");
        this.id= formatt[2].value;
        this.wert= new CryptItem(formatt[3].value);
        var form = document.createElement("form");
        form.setAttribute("action", "?showfriends");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",this.id);
        form.appendChild(hiddenField);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "search");
        hiddenField.setAttribute("value",this.wert.encrypt(this.key));
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
    
    this.decryptSearch = function() {
        this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("td");
        var x=formatt[0].firstChild;
        var i=0;
        var wert;
        while(i<formatt.length)
        {
            x=formatt[i].firstChild;
            if(x.nodeType==3)
            {
                wert=new CryptItem(x.nodeValue);
                x.nodeValue=wert.decrypt(this.key);
            }
            i++;
        }
    }
    
    this.sendAnfrage = function() {
        
        this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("input");
        this.id=formatt[2].value;
        var formatt =document.getElementsByTagName("td");
        var i=0,x;
        this.wert= new CryptItem('');
        while(i<formatt.length)
        {
            
            x=formatt[i].firstChild;
            if(x.nodeType==1)
            {
                if(x.checked)
                {
                    this.wert.wert=this.wert.wert+x.value+";";
                }
            }
            i++;
        }
        var formatt =document.getElementsByTagName("textarea");
        this.text= new CryptItem(formatt[0].value);
        var form = document.createElement("form");
        form.setAttribute("action", "?friendsanfrage");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",this.id);
        form.appendChild(hiddenField);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "friends");
        hiddenField.setAttribute("value",this.wert.wert);
        form.appendChild(hiddenField);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "text");
        hiddenField.setAttribute("value",this.text.encrypt(this.key));
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
    
    this.bestAnfrage = function() {
        
        this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("input");
        this.id=formatt[2].value;
        var formatt =document.getElementsByTagName("td");
        var i=0,x;
        this.wert= new CryptItem('');
        while(i<formatt.length)
        {
            
            x=formatt[i].firstChild;
            if(x.nodeType==1)
            {
                if(x.checked)
                {
                    this.wert.wert=this.wert.wert+x.value+";";
                }
            }
            i++;
        }
        var form = document.createElement("form");
        form.setAttribute("action", "?friendsbest");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",this.id);
        form.appendChild(hiddenField);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "bestat");
        hiddenField.setAttribute("value",this.wert.wert);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
    
    
}

function Nachricht() {
    
    this.text='';
    this.id='';
    this.key='';
    
    this.decodeNachricht = function() {

        this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("text");
        var x;
        var i=0;
        var wert;
        while(i<formatt.length)
        {
            x=formatt[i];
            this.wert = new CryptItem(x.innerHTML);
            x.innerHTML= this.wert.decrypt(this.key);
            i++;
        }
        
    }
    
    this.sendNachricht = function() {
       this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("input");
        this.id=formatt[2].value;
        var formatt =document.getElementsByName("artikel");
        //alert(this.id);
        var i=0,x;
        this.wert= new CryptItem('');
        while(i<formatt.length)
        {
            
            x=formatt[i];
            if(x.nodeType==1)
            {
                if(x.checked)
                {
                    this.wert.wert=x.value;
                }
            }
            i++;
        }
        var formatt =document.getElementsByTagName("textarea");
        this.text= new CryptItem(formatt[0].value);
        var form = document.createElement("form");
        form.setAttribute("action", "?nachricht");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",this.id);
        form.appendChild(hiddenField);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "pinnwand");
        hiddenField.setAttribute("value",this.wert.encrypt(this.key));
        form.appendChild(hiddenField);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "nachricht");
        hiddenField.setAttribute("value",this.text.encrypt(this.key));
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
    
    
}

function Termin() {
    
    this.key='';
    this.wert='';
    this.id='';
    this.text='';
   
    this.setDate = function() {

        var jetzt = new Date();
        document.getElementById("month").selectedIndex=jetzt.getMonth();
        document.getElementById("tag").selectedIndex=jetzt.getDate()-1;
        document.getElementById("year").value=jetzt.getFullYear();
        this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("text");
        var x;
        var i=0;
        var wert;
        while(i<formatt.length)
        {
            x=formatt[i];
            this.wert = new CryptItem(x.innerHTML);
            x.innerHTML= this.wert.decrypt(this.key);
            i++;
        }
    }

        this.vor = function() {
           
        var form = document.createElement("form");
        form.setAttribute("action", "?vor");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",'#');
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
        }
        
        this.zuruck = function() {
           
        var form = document.createElement("form");
        form.setAttribute("action", "?zuruck");
        form.setAttribute("method", "POST");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",'#');
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
        }

    
    this.sendDateTag = function()  {

        this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("input");
        this.id=formatt[2].value;
        var monat = document.getElementById("month").selectedIndex;
        var tag = document.getElementById("tag").selectedIndex+1;
        var jahr = document.getElementById("year").value;
        var formatt =document.getElementsByName("artikel");
        var i=0,x;
        if(tag>getLastDateInMonth(jahr,monat).getDate())
        {
            alert('Diesen Tag gibt es nicht');
            return;
        }
        else
        {
            this.wert= new CryptItem('');
            while(i<formatt.length)
            {

                x=formatt[i];
                if(x.nodeType==1)
                {
                    if(x.checked)
                    {
                        this.wert.wert=this.wert.wert+x.value+";";
                    }
                }
                i++;
            }
            tag= new CryptItem(tag.toString());
            monat= new CryptItem(monat.toString());
            jahr= new CryptItem(jahr.toString());
            var formatt =document.getElementsByName("offene");
            var offen=formatt[0].checked;
            var form = document.createElement("form");
            form.setAttribute("action", "?termintag");
            form.setAttribute("method", "POST"); 
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "identifier");
            hiddenField.setAttribute("value",this.id);
            form.appendChild(hiddenField);
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "offen");
            hiddenField.setAttribute("value",offen);
            form.appendChild(hiddenField);
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "teilnehmer");
            hiddenField.setAttribute("value",this.wert.wert);
            form.appendChild(hiddenField);
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "monat");
            hiddenField.setAttribute("value",monat.encrypt(this.key));
            form.appendChild(hiddenField);
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "tag");
            hiddenField.setAttribute("value",tag.encrypt(this.key));
            form.appendChild(hiddenField);
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "jahr");
            hiddenField.setAttribute("value",jahr.encrypt(this.key));
            form.appendChild(hiddenField);
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    this.decSelect = function() {
        
       this.key=localStorage.getItem("key");
        var formatt =document.getElementsByTagName("enctext");
        var x;
        var i=0;
        var wert;
        while(i<formatt.length)
        {
            x=formatt[i];
            this.wert = new CryptItem(x.innerHTML);
            x.innerHTML= this.wert.decrypt(this.key);
            i++;
        } 
    }
    
    this.terminbuchen = function()  {
        

        var formatt =document.getElementsByTagName("input");
        this.id=formatt[2].value;
        var von =formatt[3].value;
        var bis =formatt[4].value;
        var text=new CryptItem(formatt[5].value);
        var bem=new CryptItem(formatt[6].value);
        var re = /(\d\d\:\d\d)/;
        if(von.match(re) && bis.match(re) )
        {
            var von =von.split(':');
            var bis =bis.split(':');
            if(von[0]<0 && von[0]>24 && von[1]<0 && von[1]>60)
            {
                alert('Von Zeit im falschen Formatt');
            }
            else
            {
                if(bis[0]<0 && bis[0]>24 && bis[1]<0 && bis[1]>60)
                {
                    alert('Von Zeit im falschen Formatt');
                }
                else
                {
                    var anfang=new CryptItem((von[0]+von[1]).toString());
                    var ende=new CryptItem((bis[0]+bis[1]).toString());
                    if(anfang.wert<ende.wert)
                    {
   
                        var form = document.createElement("form");
                        form.setAttribute("action", "?terminbuchen");
                        form.setAttribute("method", "POST"); 
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", "identifier");
                        hiddenField.setAttribute("value",this.id);
                        form.appendChild(hiddenField);
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", "anfang");
                        hiddenField.setAttribute("value",anfang.encrypt(this.key));
                        form.appendChild(hiddenField);
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", "text");
                        hiddenField.setAttribute("value",text.encrypt(this.key));
                        form.appendChild(hiddenField);
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", "bem");
                        hiddenField.setAttribute("value",bem.encrypt(this.key));
                        form.appendChild(hiddenField);
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", "ende");
                        hiddenField.setAttribute("value",ende.encrypt(this.key));
                        form.appendChild(hiddenField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                    else
                    {
                        alert('Beginn muß vor dem Ende liegen');
                    }
                }
            }
        }
        else
        {
            alert('bitte Werte eintragen');
        }

    }
    
    this.terminbestaetigen = function() {
    
        var formatt2 =document.getElementsByTagName("input");
        this.id=formatt2[2].value;
        var formatt =document.getElementsByName("artikel");
        var i=0,x;
        this.wert= new CryptItem('');
        //this.text= new CryptItem('');
        while(i<formatt.length)
        {

            x=formatt[i];
            if(x.nodeType==1)
            {
                if(x.checked)
                {
                    this.wert.wert=this.wert.wert+x.value+";";
                    //this.text.wert=this.text.wert+formatt2[4+(i*2)].value+" ";
                }
            }
            i++;
        }
        var form = document.createElement("form");
        form.setAttribute("action", "?Termin=ok&terminannehmen=ok");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",this.id);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "nummer");
        hiddenField.setAttribute("value",this.wert.wert);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
    
    this.terminablehen = function() {
    
        var formatt2 =document.getElementsByTagName("input");
        this.id=formatt2[2].value;
        var formatt =document.getElementsByName("artikel");
        var i=0,x;
        this.wert= new CryptItem('');
        //this.text= new CryptItem('');
        while(i<formatt.length)
        {

            x=formatt[i];
            if(x.nodeType==1)
            {
                if(x.checked)
                {
                    this.wert.wert=this.wert.wert+x.value+";";
                    //this.text.wert=this.text.wert+formatt2[4+(i*2)].value+" ";
                }
            }
            i++;
        }
        var form = document.createElement("form");
        form.setAttribute("action", "?Termin=ok&terminablehnen=ok");
        form.setAttribute("method", "POST"); 
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "identifier");
        hiddenField.setAttribute("value",this.id);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "nummer");
        hiddenField.setAttribute("value",this.wert.wert);
        form.appendChild(hiddenField);
        document.body.appendChild(form);
        form.submit();
    }
}

person = new Person;
friends = new Friends;
nachricht = new Nachricht;
termin = new Termin;
