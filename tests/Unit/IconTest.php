<?php

namespace Tests\Unit;

use App\Icon;
use Tests\TestCase;

class IconTest extends TestCase
{
    /** @test */
    public function it_can_return_the_html_for_an_icon()
    {
        // When: We try to render a icon (fa-user)
        $html = Icon::render('user');

        // Then: The correct html markup should be returned
        $expected = '<span class="icon"><i class="fa fa-user"></i></span>';

        $this->assertEquals($expected, $html);
    }

    /** @test */
    public function it_can_return_html_for_a_small_icon()
    {
        // When: We try to render a small icon (fa-bell)
        $html = Icon::render('bell', 'small');

        // Then: The correct html markup should be returned
        $expected = '<span class="icon is-small"><i class="fa fa-bell"></i></span>';

        $this->assertEquals($expected, $html);
    }
}
