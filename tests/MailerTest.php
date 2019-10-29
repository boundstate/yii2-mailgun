<?php
namespace boundstate\mailgun\tests;

use Yii;

final class MailerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

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

    public function testGetMailgun(): void
    {
        $mailgun = Yii::$app->mailer->getMailgun();
        $this->assertInstanceOf(\Mailgun\Mailgun::class, $mailgun);
    }
}
