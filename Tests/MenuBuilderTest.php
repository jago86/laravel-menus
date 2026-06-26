<?php

namespace Nwidart\Menus\Tests;

use Illuminate\Config\Repository;

use Nwidart\Menus\MenuBuilder;
use Nwidart\Menus\MenuItem;
use PHPUnit\Framework\Attributes\Test;

class MenuBuilderTest extends BaseTestCase
{
    #[Test]
    public function it_makes_a_menu_item()
    {
        $builder = new MenuBuilder('main', app(Repository::class));

        self::assertInstanceOf(MenuItem::class, $builder->url('hello', 'world'));
    }
}
