<?php
function smarty_modifier_get_season($season)
{
    switch (intval($season)) {
        case 1:
            return 'Зимняя';

        case 2:
            return 'Летняя';

        case 3:
            return 'Всесезон';
    }
}

?>
