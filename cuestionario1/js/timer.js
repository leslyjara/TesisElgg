//if (sessionStorage.getItem("is_reloaded")) alert('Reloaded!');
var group_guid= $('input:hidden[name=group]').val();
var cuestionario_guid= $('input:hidden[name=cuestionario]').val();
var sitio= $('input:hidden[name=sitio]').val();
var limite=parseInt($( "input[type=hidden][name=limite]" ).val());//duracion examen en minutos
var FechaTermino=$( "input[type=hidden][name=FechaTermino]" ).val();//
FechaTermino=new Date(FechaTermino);//objeto fecha de entrega
var dateInit= new Date();






var hAux=00;
var mAux=00;
var sAux=00;
h = Math.floor(limite/60);
m = limite%60;
s = 0;
var comp=true;

//muestra cronometro
var x = setInterval(function() {
  var now= new Date();
  if(FechaTermino== now){
    alert("El examan ha finalizado");
    //window.location.href = sitio+"cuestionario/reply/"+group_guid+"/"+cuestionario_guid;
    enviar(false);
    return false;
  }
  if(comp==true){
    if (s<0){m--;s=59;}
    if (m<0){h--;m=59;}
    if (h<0){h=0;}
  
    if (s<10){sAux="0"+s;}else{sAux=s;}
    if (m<10){mAux="0"+m;}else{mAux=m;}
    if (h<10){hAux="0"+h;}else{hAux=h;}
    document.getElementById("hms").innerHTML = hAux + ":" + mAux + ":" + sAux; 
    if (s<0){m--;s=59;}
    if (m<0){h--;m=59;}
    if (h<0){h=0;}

    s--;
    if(hAux=='00' && mAux=='00' && sAux=='00'){   
      document.getElementById("hms").innerHTML = hAux + ":" + mAux + ":" + sAux;   
      console.log('fin cuestionario');
      alert("fin cuestionario");
      //window.location.href = output.sitio+"cuestionario/reply/"+group_guid+"/"+cuestionario_guid;
      enviar(false);
      comp=false;
     
      
    
    }
  }else{
 // window.location.href = sitio+"cuestionario/reply/"+group_guid+"/"+cuestionario_guid;

  //return false;
  }

}, 1000);


