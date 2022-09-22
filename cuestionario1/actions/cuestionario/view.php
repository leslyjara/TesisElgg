<?php

$group = get_input('group');
#$cuestionario = get_entity($group);

return elgg_redirect_response("questions/all/$group");