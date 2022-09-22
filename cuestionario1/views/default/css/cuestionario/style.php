<?php ?>

*{
    font-family:'Arial', sans-serif;
}





.h1_add{
    background: rgba(0, 0, 0, 0.05);
    padding:    15px;
    margin:     5px;
    cursor:     pointer;
    border:     1px solid rgba(0, 0, 0, 0.5);
    border-radius:  10px;
    box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.5);
    transition: all 300ms;
}

.h1_add:hover{
    box-shadow: 3px 3px 3px 2px rgba(0, 0, 0, 0.5);
    transform:  translate(-1px, -1px);
}

.h1_add ul li{
    display:    inline-block;
}

.icono{
    float:      right;
    size:       150%;
}

.tablas{
    background: rgba(0, 0, 0, 0.04);
    padding:    5px;
    margin:     6px;
    margin-top: 10px;
    border-radius:  10px;
}

select {
    display:    block;
    cursor:     pointer;
    font-size:  16px;
    font-family:'Arial', sans-serif;
    font-weight:400;
    padding: 5px 17px 4px 10px;
    color:      #444;
    line-height:1.3;
    width:      200px;
    max-width:  100%; 
    box-sizing: border-box;
    border: 1px solid #aaa;
    box-shadow: 0 1px 0 1px rgba(0,0,0,.03);
    border-radius:  5px;
    background-color:   #fff;
    background-repeat:  no-repeat, repeat;
    background-position:right 8px top 50%, 0 0;
    background-size:    8px auto, 100%;
}

select::-ms-expand {
  display: none;
}
select:hover {
  border-color: #888;
}
select:focus {
  border-color: #aaa;
  box-shadow: 0 0 1px 3px rgba(59, 153, 252, .7);
  box-shadow: 0 0 0 3px -moz-mac-focusring;
  color: #222; 
  outline: none;
}

.titulo{
    margin:     3px;
    padding:    3px;
}






.agregar_pregunta{
    background-color:   #4787B8;
	color:#fff;    
    border:     none;
    padding:    16px;
    font-size:  15px;
    width:      180px;
    cursor:     pointer;
}

.div_agregar:hover .links_agregar{
    display:    block;
}

.links_agregar a{
    text-decoration:    none;
    display:    block;
    padding:    13px;
    color:#fff;  
}

.links_agregar{
    background-color:   #4787B8;
    width:      185px;
    display:    none;
}

.links_agregar a:hover{
    background-color:   #566573;
}

.div_agregar{
    position:   relative;
    width:      181px;
}





a.disabled {
  
  cursor: default;
  pointer-events: none;
  opacity: 0.6;
  background: rgba(200, 54, 54, 0.5);  
  background-color: #EDEDED;
  filter: alpha(opacity=50);
  zoom: 1;  
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";  
  -moz-opacity: 0.5; 
  -khtml-opacity: 0.5;

}


/* Dropdown menu */
.btnOptions {
 background-color: #FFFFFF;
  color: #7d7d7d;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}
.btnOptions:hover, .btnOptions:focus, .btnOptions:active{
  background-color: #FFFFFF;
}



.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #FFFFFF}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}








.modal1 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 100; /* Sit on top */
  padding-top: 2%; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  
}
.modal-content {
  position: relative;
  box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; -o-box-sizing: border-box;
  height: auto; 
  overflow: auto;
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}




.container_view{
    background:     rgba(0,0,0,0.2);
    border-radius:  5px;
    padding:        10px;
    margin:         10px 5px 10px 5px;
}



.table-questions{

border-collapse: collapse;
vertical-align: middle;  
width:100%;
}

.revisar {
	background-color:#7892c2;
	border-radius:42px;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	padding:8px 10px;
	text-decoration:none;
	text-shadow:0px 0px 0px #283966;
}
.revisar:hover {
	background-color:#476e9e;
    color:#ffffff;
    text-decoration:none;
}
.revisar:active {
	position:relative;
	top:1px;
    text-decoration:none;
}
.no-revisado {
	background-color:#ededed;
	border-radius:42px;
	display:inline-block;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
    color:#CCCCCC;
	padding:8px 10px;
	text-decoration:none;
}
.no-revisado:link{
    color:#CCCCCC;
    text-decoration:none;
}
.no-revisado:visited{
    color:#CCCCCC;
    text-decoration:none;
}
.no-revisado:hover{
    color:#CCCCCC;
    text-decoration:none;
}

.fix{
  position:fixed;
}



<!-- NAVBAR CUESTIONARIO -->
#menu {
	background: #FFFFFF;
	color: #FFF;
	height: 36px;
	padding-left: 18px;
	border-radius: 3px;
}
#menu ul, #menu li {
	margin: 0 auto;
	padding: 0;
	list-style: none
}
#menu ul {
	width: 100%;
}
#menu li {
	float:right;
	display: inline;
	position: relative;
}
#menu a {
	display: block;
	line-height: 36px;
	padding: 0 14px;
	text-decoration: none;
	color: #2D3047;
	font-size: 11px;
	text-transform: capitalize;
}
#menu a.dropdown-arrow:after {
	content: "\23F7";
	margin-left: 5px;
}
#menu li a:hover {
	color: #FFFFFF;
	background: #80B3FC;
}
#menu input {
	display: none;
	margin: 0;
	padding: 0;
	height: 36px;
	width: 100%;
	opacity: 0;
	cursor: pointer
}
#menu label {
	display: none;
	line-height: 36px;
	text-align: center;
	position: absolute;
	left: 35px
}
#menu label:before {
	font-size: 1.6em;
	content: "\2261"; 
	margin-left: 20px;
}
#menu ul.sub-menus{
	height: auto;
	overflow: hidden;
	width: 170px;
	background: #80B3FC;
	position: absolute;
	z-index: 99;
	display: none;
}
#menu ul.sub-menus li {
	display: block;
	width: 100%;
}
#menu ul.sub-menus a {
	color: #FFFFFF;
	font-size: 12px;
	text-transform: uppercase;
}
#menu li:hover ul.sub-menus {
	display: block
}
#menu ul.sub-menus a:hover{
	background: #4B80CF;
	color: #FFFFFF;
}
@media screen and (max-width: 800px){
	#menu {position:relative}
	#menu ul {background:#111;position:absolute;top:100%;right:0;left:0;z-index:3;height:auto;display:none}
	#menu ul.sub-menus {width:100%;position:static;}
	#menu ul.sub-menus a {padding-left:30px;}
	#menu li {display:block;float:none;width:auto;}
	#menu input, #menu label {position:absolute;top:0;left:0;display:block}
	#menu input {z-index:4}
	#menu input:checked + label {color:white}
	#menu input:checked + label:before {content:"\00d7"}
	#menu input:checked ~ ul {display:block}
}

<!-- FIN NAVBAR -->

<!-- PREGUNTAS ALEATORIO -->
* {
  box-sizing: border-box;
}

.header {
  border: 1px solid blue;
  padding: 15px;
}

.labelContainer {
  width: 25%;
  float: left;
  padding: 15px;
  /* border: 1px solid red; */
  text-align: right;
}

.inputContainer {
  width: 75%;
  float: left;
  padding: 15px;
  /* border: 1px solid red; */
  text-align: left;
}
form input[type="submit"]{
	width:25%;
	padding:15px 16px;
	margin-top:32px;
    border: 1px solid #D6DAE4;
	border-radius:5px;	
	color:#fff;
	background-color:#566573;
}
select{
	width:50%;
	padding:7px 16px;	
	border:1px solid #000;
	border-radius:5px;
    border: 1px solid #D6DAE4;
	
}
<!-- -->




<!-- List_Try -->


.cont-list-try{  
  width: 100%;
  position: relative;    
}
.borde{
  padding: 0px 10px 0px 10px;
  font-weight: bold;

}


.row_try {
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  -webkit-flex-direction: row;
  -ms-flex-direction: row;
  flex-direction: row;
  -webkit-flex-wrap: wrap;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -webkit-justify-content: space-between;
  -ms-flex-pack: justify;
  justify-content: space-between;
  -webkit-align-content: center;
  -ms-flex-line-pack: center;
  align-content: center;
  -webkit-align-items: flex-start;
  -ms-flex-align: start;
  align-items: flex-start;
 
}

.col_try {
  -webkit-order: 0;
  -ms-flex-order: 0;
  order: 0;
  -webkit-flex: 0 1 auto;
  -ms-flex: 0 1 auto;
  flex: 0 1 auto;
  -webkit-align-self: auto;
  -ms-flex-item-align: auto;
  align-self: auto;
}
