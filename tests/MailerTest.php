<?php
namespace boundstate\mailgun\tests;

use boundstate\mailgun\Mailer;
use Yii;

final class MailerTest extends TestCase
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

    public function testInitializesMailgun(): void
    {
        $mailgun = Yii::$app->mailer->getMailgun();
        $this->assertInstanceOf(\Mailgun\Mailgun::class, $mailgun);
    }
}
