<?php
function smarty_modifier_get_season($season)
{
    switch (intval($season)) {
        case 1:
            return '������';

        case 2:
            return '������';

        case 3:
            return '��������';
    }
}

?>
