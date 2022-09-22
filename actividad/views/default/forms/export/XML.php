<?php
$group =  elgg_extract('group', $vars);//guid de grupo
$dat =  elgg_extract('dat', $vars);//matriz con evaluaciones y notas


echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'group_guid',
    'value'=> $group,    
]);

echo elgg_view_field([
    '#type' => 'hidden',
    'name' => 'dat',
    'value'=> array($dat),    
]);

$submit = elgg_view_field(array(
    '#type' => 'submit',
    '#class' => 'elgg-foot',
    'value' => '<i class="fa fa-file"></i>  '.elgg_echo('XML'),
));



elgg_set_form_footer($submit);