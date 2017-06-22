<?php

namespace App;

class Icon
{
    public static function render($icon, $size = null)
    {
        $iconClasses = 'icon';
        if ($size != null) {
            $iconClasses .= ' is-' . $size;
        }

        return implode("", [
            '<span class="' . $iconClasses . '">',
            '<i class="fa fa-' . $icon . '"></i>',
            '</span>'
        ]);
    }
}