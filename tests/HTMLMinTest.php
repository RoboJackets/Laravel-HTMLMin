<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Raza Mehdi <srmk@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HTMLMin\Tests\HTMLMin;

use PHPUnit\Framework\Attributes\DataProvider;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use HTMLMin\HTMLMin\HTMLMin;
use HTMLMin\HTMLMin\Minifiers\BladeMinifier;
use HTMLMin\HTMLMin\Minifiers\CssMinifier;
use HTMLMin\HTMLMin\Minifiers\HtmlMinifier;
use HTMLMin\HTMLMin\Minifiers\JsMinifier;
use Mockery;

/**
 * This is the htmlmin test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class HTMLMinTest extends AbstractTestBenchTestCase
{
    public static function methodProvider(): array
    {
        return [
            ['blade', 'getBladeMinifier'],
            ['css', 'getCssMinifier'],
            ['js', 'getJsMinifier'],
            ['html', 'getHtmlMinifier'],
        ];
    }

    #[DataProvider('methodProvider')]
    public function testMethods($method, $class): void
    {
        $htmlmin = $this->getHTMLMin();

        $htmlmin->$class()->shouldReceive('render')
            ->once()->andReturn('abc');

        $return = $htmlmin->$method('test');

        $this->assertSame('abc', $return);
    }

    protected function getHTMLMin()
    {
        $blade = Mockery::mock(BladeMinifier::class);
        $css = Mockery::mock(CssMinifier::class);
        $js = Mockery::mock(JsMinifier::class);
        $html = Mockery::mock(HtmlMinifier::class);

        return new HTMLMin($blade, $css, $js, $html);
    }
}
