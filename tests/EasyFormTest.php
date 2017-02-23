<?php

use PHPUnit\Framework\TestCase;
use Deveative\EasyForm;

class EasyFormTest extends TestCase
{
    protected $settings = [];
    protected $postData = [];

    public function setUp()
    {
        $this->settings=[
            'field' => [
                'lastname' => [
                    'type' => 'text',
                    'attr' => [
                        'id' => 'input_lastname',
                        'class' => 'input-text'
                    ]
                ],
                'firstname' => [
                    'attr' => [
                        'id' => 'input_firstname',
                        'class' => 'input-text'
                    ]
                ],
            ]
        ];

        $this->postData = [
            'lastname' => 'test_value!!',
            'dummy' => 'foobar!',
        ];
    }


    public function testNotExistFieldByMagicGetMethod()
    {
        $form = new EasyForm\EasyForm($this->settings, $this->postData);

        $this->assertNull($form->foonotexistfieldbar);
    }

    public function testGetValue()
    {
        // no postdate
        $form = new EasyForm\EasyForm($this->settings);

        $this->assertTrue($form->lastname instanceof EasyForm\Field\Text);
        $this->assertSame($form->lastname->value(), '');

        $this->assertTrue($form->firstname instanceof EasyForm\Field\Text);
        $this->assertSame($form->firstname->value(), '');


        // with postdate
        $form = new EasyForm\EasyForm($this->settings, $this->postData);

        $this->assertTrue($form->lastname instanceof EasyForm\Field\Text);
        $this->assertSame($form->lastname->value(), 'test_value!!');

        $this->assertTrue($form->firstname instanceof EasyForm\Field\Text);
        $this->assertSame($form->firstname->value(), '');
    }

    public function testGetHtml()
    {
        $form = new EasyForm\EasyForm($this->settings, $this->postData);

        $this->assertSame($form->lastname->getHtml(),
            '<input type="text" name="lastname" value="test_value!!" id="input_lastname" class="input-text">');

        $this->assertSame($form->firstname->getHtml(),
            '<input type="text" name="firstname" value="" id="input_firstname" class="input-text">');
    }

    public function testRenderField()
    {
        $form = new EasyForm\EasyForm($this->settings, $this->postData);
        ob_start();
        $form->lastname->render();
        $output=ob_get_clean();
        $this->assertSame($output,
            '<input type="text" name="lastname" value="test_value!!" id="input_lastname" class="input-text">');

        ob_start();
        $form->firstname->render();
        $output=ob_get_clean();
        $this->assertSame($output,
            '<input type="text" name="firstname" value="" id="input_firstname" class="input-text">');
    }

    public function testRenderFieldByMagicMethod()
    {
        $form = new EasyForm\EasyForm($this->settings, $this->postData);

        ob_start();
        $form->lastname();
        $output=ob_get_clean();
        $this->assertSame($output,
            '<input type="text" name="lastname" value="test_value!!" id="input_lastname" class="input-text">');

        ob_start();
        $form->firstname();
        $output=ob_get_clean();
        $this->assertSame($output,
            '<input type="text" name="firstname" value="" id="input_firstname" class="input-text">');

        ob_start();
        $form->notExistFieldNameFoo();
        $output=ob_get_clean();
        $this->assertSame($output, '');
    }

    public function testOpen()
    {
        $form = new EasyForm\EasyForm();

        // no arguments
        ob_start();
        $form->open();
        $output=ob_get_clean();

        $this->assertSame($output, '<form action="">');

        // with arguments
        ob_start();
        $form->open('/hoge/fuga');
        $output=ob_get_clean();

        $this->assertSame($output, '<form action="/hoge/fuga">');
    }

    public function testClose()
    {
        $form = new EasyForm\EasyForm();

        ob_start();
        $form->close();
        $output=ob_get_clean();

        $this->assertSame($output, '</form>');
    }

}
