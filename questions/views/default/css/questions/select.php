<?php
?>
<!-- container Select question -->
.cont{
    border-radius: 10px;
    background: #e0e0e0;
    box-shadow:  5px 5px 5px #d0d0d0,
                -5px -5px 5px #f0f0f0;

}
.grids {
display: grid;
grid-template-columns: repeat(2, 1fr);
grid-template-rows: 1fr;
grid-column-gap: 14px;
grid-row-gap: 0px;
}

.div1 { grid-area: 1 / 1 / 3 / 3; }
.div2 { grid-area: 1 / 1 / 2 / 2; }
.div3 { grid-area: 1 / 2 / 2 / 3; }

<!-- view all, list questions -->


.table{

border-collapse: collapse;
vertical-align: middle;  
width:100%;
background-colore:red;




}

.row{
    height: 50px;   
    border:  1px #D5D8DC ;
    border-bottom-style: solid;  
    margin: auto;
    padding: 50px;
}


<!-- FORM QUE MUESTRA CADA PREGUNTA EN FORMULARIO-->
.title{
    float: left;
    width: 75%;
    text-align: left;
    box-sizing: border-box;
    padding: 14px;
    margin: auto;
   

}

.ftoggler{
    width: 100%;
    border: 1px solid #80B3FC;
    border-radius:5px;   
    box-shadow: 2px 3px 5px #EEF0F3;   
    
  
}
.cont{
    margin: 10px;
}
.Retroalimentacion{   
    margin: 2px;
    border-radius:5px; 
    padding: 14px;
    border: 1px solid;
    
}
.correcto{
    border: 1px solid green;
    background-color: rgba(156, 248, 124,0.4); /* Black w/ opacity */
}
.incorrecto{
    border: 1px solid red;
    background-color: rgba(247, 33, 33,0.4); /* Black w/ opacity */
}
.parcialCorrecto{
    border: 1px solid yellow;
    background-color: rgba(247, 220, 111,0.4); /* Black w/ opacity */
}



