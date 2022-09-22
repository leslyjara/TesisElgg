<?php
/* visualiza la respuesta de alumno*/
//VISTA PROFESOR

// asegurarse que le usuario inicio sesion
gatekeeper();

// get the entity
$guid = elgg_extract('guid', $vars);
$respuesta = get_entity($guid);//RESPUESTA
$owner=get_entity($respuesta->owner_guid);
$actividad=get_entity($respuesta->actividad);



//contexto grupo
elgg_set_page_owner_guid((int)$actividad->guid_group);

$res= $respuesta->respuesta;

function obtenerIdVideo($url){
    $url_parseada   =   explode("=",$url);
    return $id  =   $url_parseada[1];
}
$video_id = "https://www.youtube-nocookie.com/embed/".obtenerIdVideo($res);


//crear frame de video
if($respuesta->tipoEntrega=='video'){
    // $content ="<a href='{$res}'>{$res}</a>";
    $html= <<<___HTML
       

        <div align="center"> 
        <iframe width=100% height="315" src= $video_id title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <br/><br/>
        
        
    ___HTML;



$content=$html;
}elseif($respuesta->tipoEntrega=='texto'){
    $content= $res;  
}elseif( $respuesta->tipoEntrega=='archivo'){
    
    $guidFile= $respuesta->respuesta;
    $file=get_entity($guidFile);
    if($file){
        $content = elgg_view_entity($file, array('full_view' => false, "group"=> 11));    
        //descargar archivo
        elgg_register_menu_item('title', array(
            'name' => 'download',
            'text' => elgg_echo('download'),
            'href' => elgg_get_download_url($file),
            'link_class' => 'elgg-button elgg-button-action',
        ));   

    }   
    

    
}

$labelNata = elgg_echo('actividad:grade');
$labelcomentario = elgg_echo('actividad:comment');
$labelCalificar = elgg_echo('actividad:rate');
$retroalimentacion= <<<___HTML
<br/><br/><br/>
<hr size="1px" color="silver" />
<div>$labelNata : $respuesta->nota</div>
<div>$labelcomentario: $respuesta->comentario</div>

___HTML;


$content.=$retroalimentacion;


$resource_vars['guid'] = $respuesta->guid;
$resource_vars['nota'] = $respuesta->nota;
$resource_vars['comentario'] = $respuesta->comentario;
$form=elgg_view_form("nota/nota",array(),$resource_vars);//guid de respuesta

$form=<<<___HTML
    <div id='form'>
    {$form}
    </div>
    <br/><br/><br/>
    <div align='center'>
        <button type='button' id='mostrarForm' >$labelCalificar </button>
    </div>

___HTML;

$content.= $form;



$sidebar =elgg_view('sidebar/options', array(
    'group' => $actividad->guid_group,
       
));


$params = array(
    'title' => $owner->name.' - '.$actividad->title,
    'content' => $content,
    'filter' => '',
    'sidear' => $sidebar,
);


$body = elgg_view_layout('content', $params);

echo elgg_view_page($actividad->title, $body);

?>

<script type="text/javascript">  

  $(document).ready(function(){
   
    //ocultar/mostrar formulario
   $("#form").hide();
    $("#mostrarForm").click(function(){
         //mostrar formulario de entrega
         $("#form").show();
         $("#mostrarForm").hide();
      });     
           
   });
</script>