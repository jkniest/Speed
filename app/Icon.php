<?php

namespace App;

/**
 * This class represents a single icon. It is used inside custom blade directives to render a
 * font awesome icon into the view.
 *
 * @category Core
 * @package  Speed
 * @author   Jordan Kniest <contact@jkniest.de>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     https://jkniest.de
 */
class Icon
{
    /**
     * Convert a icon name (and optionally a size) into a bulma / font-awesome icon.
     *
     * @param string      $icon The icon string (font awesome)
     * @param string|null $size The optional size (bulma)
     *
     * @return string
     */
    public static function render(string $icon, $size = null)
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
