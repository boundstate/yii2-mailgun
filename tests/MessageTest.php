<?php
namespace boundstate\mailgun\tests;

use Yii;

final class MessageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockApplication([
            'components' => [
                'mailer' => [
                    'class' => 'boundstate\mailgun\Mailer',
                    'key' => getenv('MAILGUN_KEY'),
                    'domain' => getenv('MAILGUN_DOMAIN'),
                ],
            ]
        ]);
    }

    public function testCompose(): void
    {
        $message = Yii::$app->mailer->compose('example', ['name' => 'John']);
        $html = $message->getMessageBuilder()->getMessage()['html'];

        $this->assertEquals($html, '<p>Hi John!</p>');
    }

    public function testSend(): void
    {
        $message = Yii::$app->mailer->compose('example', ['name' => 'John'])
            ->setTo(getenv('TEST_RECIPIENT'))
            ->setFrom('test@example.com')
            ->setSubject('Test')
            ->setTestMode(true);

        $this->assertTrue($message->send());
    }
}
