<?php

namespace Tests;

class ThemeTest extends TestCase
{
    /**
     * Test view method.
     *
     * @return void
     */
    public function testView()
    {
        $path = config(['themes.path' => __DIR__.'/themes']);

        $response = $this->get('view');
        $response->assertViewHas('test');
    }

    /**
     * Test use method.
     *
     * @return void
     */
    public function testuse()
    {
        $path = config(['themes.path' => __DIR__.'/themes']);

        $response = $this->get('use');
        $response->assertViewHas('test');
    }

    /**
     * Test exists method.
     *
     * @return void
     */
    public function testExists()
    {
        $path = config(['themes.path' => __DIR__.'/themes']);

        $resultTrue = \Theme::exists('default');
        $resultFalse = \Theme::exists('notExistsTheme');

        $this->assertTrue($resultTrue);
        $this->assertFalse($resultFalse);
    }

    /**
     * Test info method.
     *
     * @return void
     */
    public function testInfo()
    {
        $path = config(['themes.path' => __DIR__.'/themes']);

        $result = \Theme::info('default');

        $this->assertEquals('Default theme', $result['theme_title']);
        $this->assertEquals('https://demowebsite.com', $result['theme_uri']);
    }
}
