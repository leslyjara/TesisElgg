<style type="text/css">

.table{
width:100%;
border-collapse: collapse;
vertical-align: middle;  




}

.row{
    height: 50px;   
    border:  1px #D5D8DC ;
    border-bottom-style: solid;  
    margin: auto;
    padding: 50px;
}


/* Modal Content */
/* The Modal (background) */
.modal1 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 100; /* Sit on top */
  padding-top: 170px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  
}
/*

 background-color: #fefefe;
  margin: 15% auto; 
  padding: 20px;
  border: 1px solid #888;
  width: 80%; 
*/
.modal-content {
  background-color: #fefefe;
  padding: 20px; 
  margin:  auto; 
  border: 1px solid #888;
  width: 40%;
  height:auto ;
 /*  height: 70% ;  */
  overflow: auto; 
  
  
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


</style>

<?php

elgg_gatekeeper();

// get the entity
$group = elgg_extract('group', $vars);
$group = get_entity($group);
$site=get_entity($group->site_guid);

$vars['group']=$group->guid;

$select=elgg_view('select',$vars);//sleccionar tipo de pregunta
$vars['group']=$group->guid;
$vars['container']=$group->guid;
//$listPreguntas=elgg_view_form("questions/deleteQ",array(),$vars);

// MODAL
$modal= <<<___HTML
<div class"elgg-page elgg-page-default">
    <!-- Modal HTML embedded directly into document -->
    <div name="ex1" id="modal1" class="modal1">
        <div class='modal-content'>
            <div class='content2'>
                <span class="close">&times;</span>                   
                $select                 
            </div>       
        </div>
           
    </div>    
</div>

<!-- Link to open the modal -->
<p class="center" id='agregarPregunta'><a href="#ex1" rel="modal:open">Agregar pregunta.</a></p>

___HTML;

$content= $modal;

$content.= elgg_view_field([
  '#type' => 'hidden',     
  'name' =>'group',
  'id' =>'group',
  'value'=> $group->guid,
]);
$content.= elgg_view_field([
  '#type' => 'hidden',     
  'name' =>'container',
  'id' =>'container',
  'value'=> $group->guid,
]);
$content.= elgg_view_field([
  '#type' => 'hidden',     
  'name' =>'categoria',
  'id' =>'categoria',
  'value'=> $group->guid,
]);



//LISTAR PREGUNTAS,
$content.= "<div  id='view-form'> </div>";


$params = array(
    'title' => "Banco de preguntas",
    'content' => $content,
    //'filter' => '',
);

$body = elgg_view_layout('constent', $params);

echo elgg_view_page("Banco de preguntas", $body);
$sitio=elgg_get_site_url();
//echo $sitio;
echo <<<___HTML
    <script type='text/javascript' src='{$sitio}mod/questions/js/resources/questions/all.js'></script>
___HTML;



