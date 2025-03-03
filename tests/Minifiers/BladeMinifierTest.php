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

namespace HTMLMin\Tests\HTMLMin\Minifiers;

use PHPUnit\Framework\Attributes\DataProvider;
use GrahamCampbell\TestBench\AbstractTestCase;
use HTMLMin\HTMLMin\Minifiers\BladeMinifier;

/**
 * This is the blade minifier test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class BladeMinifierTest extends AbstractTestCase
{
    public function testRenderEnabled(): void
    {
        $blade = $this->getBladeMinifier();

        $return = $blade->render('test    123');

        $this->assertSame('test 123', $return);

        $return = $blade->render('test    <div></div>');

        $this->assertSame('test <div></div>', $return);
    }

    public static function tagProvider(): array
    {
        return [
            ['textarea'],
            ['pre'],
            ['code'],
        ];
    }

    #[DataProvider('tagProvider')]
    public function testRenderHtmlDisabled($tag): void
    {
        $blade = $this->getBladeMinifier();

        $return = $blade->render("test    <$tag></$tag>");

        $this->assertSame("test    <$tag></$tag>", $return);
    }

    public function testRenderCommentDisabled(): void
    {
        $blade = $this->getBladeMinifier();

        $return = $blade->render('test    <?php // foo');

        $this->assertSame('test    <?php // foo', $return);
    }

    #[DataProvider('tagProvider')]
    public function testRenderForced($tag): void
    {
        $blade = $this->getBladeMinifier(true);

        $return = $blade->render("test    <$tag></$tag>");

        $this->assertSame("test <$tag></$tag>", $return);
    }

    protected function getBladeMinifier($force = false, $ignorePaths = [])
    {
        return new BladeMinifier($force, $ignorePaths);
    }
}
