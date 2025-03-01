<?php

namespace HTMLMin\Tests\HTMLMin\Functional;

use HTMLMin\HTMLMin\Compilers\MinifyCompiler;
use HTMLMin\Tests\HTMLMin\Functional\Provider\TestComponentsProvider;

final class ComponentsTest extends AbstractFunctionalTestCase
{
    /**
     * Get the required service providers.
     *
     * @return string[]
     */
    protected static function getRequiredServiceProviders(): array
    {
        return [TestComponentsProvider::class];
    }

    public function testUseComponents(): void
    {
        if (version_compare($this->app->version(), '7.0', '<')) {
            $this->markTestSkipped('Class components were released in Laravel version 7.0.0');
        }

        /** @var MinifyCompiler $minifyCompiler */
        $minifyCompiler = $this->app->make('view')
            ->getEngineResolver()
            ->resolve('blade')
            ->getCompiler();

        $this->assertArrayHasKey('test-component', $minifyCompiler->getClassComponentAliases());
    }
}

