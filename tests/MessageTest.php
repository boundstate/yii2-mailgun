<?php
namespace boundstate\mailgun\tests;

use boundstate\mailgun\Mailer;
use Yii;

final class MessageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $mailer = new Mailer();

        $this->mockApplication([
            'components' => [
                'mailer' => [
                    'class' => 'boundstate\mailgun\Mailer',
                    'key' => 'key-example',
                    'domain' => 'mg.example.com',
                ],
            ]
        ]);
    }

    public function testHtmlMessage(): void
    {
        $message = Yii::$app->mailer->compose('example', ['name' => 'John']);
        $html = $message->getMessageBuilder()->getMessage()['html'];

        $this->assertEquals($html, '<p>Hi John!</p>');
    }
}
