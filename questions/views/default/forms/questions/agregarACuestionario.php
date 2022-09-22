<?php

$cuestionario= elgg_extract('cuestionario', $vars);



$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => ' center ',
   'value' => elgg_echo('agregar')  
));

elgg_set_form_footer($submit);