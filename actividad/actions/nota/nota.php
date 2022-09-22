<?php
//archivo para agregar calificacion a actividad

$nota= get_input('nota');
$comentario=get_input('comentario');
$guid= get_input('respuesta_guid');//guid de la actividad
$email= get_input('email');//email alumno
$titulo= get_input('titulo_actividad');

$user= elgg_get_logged_in_user_guid(); 
$user=get_entity($user);

//METADATOS DE OBJETO ENTREGA
$respuesta=get_entity($guid);
$respuesta->nota=$nota;
$respuesta->comentario=$comentario;
$blog_guid = $respuesta->save();

//------------
$propietario=get_entity($respuesta->owner_guid);

/*$subject = elgg_echo($user->name. elgg_echo(' ha comentado la actividad: '). $titulo, array(), $propietario->language);

// Summary of the notification
$summary = elgg_echo('Comentario a actividad ', array($user->name), $propietario->language);

$params = array(
        'object' => $respuesta->guid,
        'action' => 'create',
        'summary' => $summary,
        //'method'=>'email'
);
notify_user($propietario->guid, $user->guid, $subject, $params);
*/
//----------------------------------
$url = elgg_normalize_url("actividad/upload/83");
//http://localhost/elgg/actividad/upload/83

		$subject = elgg_echo('retroalimentacion', array(
			$propietario->name,
			$user->name
		), $propietario->language);

		$body = elgg_echo('comentario', array(
			$propietario->name,
			$user->name,
			$url,
		), $propietario->language);
		
		$params = [
			'action' => 'invite',
			'object' => $respuesta->guid,
		];

		// Send notification
		$result = notify_user($propietario->guid,$user->guid, $subject, $body);

		if ($result) {
			system_message(elgg_echo("notifocadp"));
		} else {
			register_error(elgg_echo("No notificado"));
		}
//----------------------------------


/*
//NOTIFICACION
$propietario=get_entity($respuesta->owner_guid);
$subject = $user->name. elgg_echo('ha comentado la actividad: '). $titulo;
notify_user($propietario->guid, $user->guid,$subject);
*/


if ($blog_guid) {
   system_message("calificación enviada."); 
   
  // forward($respuesta->getURL());
    
   
} else {
   register_error("error al enviar la calificación");
   forward(REFERER); // REFERER es una variable global que define la página anterior
}

