<style>
   select#hora,select#minuto {
      width: auto;
   }

</style>
<?php
// asegurarse que le usuario inicio sesion
gatekeeper();
//elgg_set_context('groups');
// set the title
$title = elgg_echo('actividad:newTask');
//guid del grupo
$guid = elgg_extract('group', $vars);
$group = get_entity($guid);//grupo entidad

$page = elgg_extract('page', $vars);

//acceso solo para miembros del grupo
elgg_group_gatekeeper(true, $guid);
$date = date('d/m/Y h:i:s a e');


//contexto grupo
elgg_set_page_owner_guid($group->guid);

//solo el admin de grupo puede crear actividad
if(elgg_get_logged_in_user_guid() == $group->getOwnerEntity()->guid ){
   
   $content = elgg_view_title($title);

   $form_vars = array('enctype' => 'multipart/form-data');

   $content.= elgg_view_form("actividad/actividadForm",  $form_vars,$vars); //vars= guid de grupo 

   //$content .= elgg_view_form("actividad/hora");

   // optionally, add the content for the sidebar
   $sidebar = " ";

   // layout the page
   $body = elgg_view_layout('two_sidebar', array(
      'content' => $content,
      'sidebar' => $sidebar
   ));

   echo elgg_view_page($title, $body);    


}else{
   register_error(elgg_echo('actividad:accessDenied'));
	forward(REFERER);
}

?>

<script type="text/javascript">


let FechaEstado =  document.getElementById("conFecha");
let fecha =  document.getElementById("fecha");
let hora =  document.getElementById("hora");
let minuto =  document.getElementById("minuto");


FechaEstado.addEventListener("change", (event) => {
   var valor =FechaEstado.value;
   if(valor == "off")  {
      fecha.disabled = true;
      hora.disabled = true;
      minuto.disabled = true;

      fecha.value = "";
      hora.value = "";
      minuto.value = "";
   } else{
      fecha.disabled = false;
      hora.disabled = false;
      minuto.disabled = false;
   }
});



</script>

