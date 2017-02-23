<?php

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    public function testConstruct()
    {
        $initialData = [
            'foo1' => [
                'bar1-1' => null,
                'bar1-2' => [
                    'baa1' => 123
                ],
            ],
            'foo2' => [
                'bar2-1' => [
                    'baa2' => 'hoge',
                ],
                'bar2-2' => null
            ],
        ];

        $config = new Deveative\EasyForm\Config($initialData);
        $this->assertEquals($config->get(), [
            'foo1' => [
                'bar1-1' => null,
                'bar1-2' => [
                    'baa1' => 123
                ],
            ],
            'foo2' => [
                'bar2-1' => [
                    'baa2' => 'hoge',
                ],
                'bar2-2' => null
            ],
        ]);
    }

    public function testArrayDotNotation(){
        $config = new Deveative\EasyForm\Config();
        $this->assertEquals($config->get(), []);

        $config->set('foo.bar.baa', 'value');

        $this->assertEquals($config->get(),
            [
                'foo'=>[
                    'bar'=>[
                        'baa'=>'value'
                    ]
                ]
            ]
        );

        $this->assertEquals($config->get('foo'),
            [
                'bar'=>[
                    'baa'=>'value'
                ]
            ]
        );

        $this->assertEquals($config->get('foo.bar'),
            [
                'baa'=>'value'
            ]
        );

        $this->assertEquals($config->get('foo.bar.baa'), 'value');

    }
}
?>