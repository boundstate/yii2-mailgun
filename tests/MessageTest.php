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
                    'key' => '801b0ee9ba59f340019da1c62a9f31df-816b23ef-3007ca87',
                    'domain' => 'sandbox475d21b1d2084dd5af26f3612111b476.mailgun.org',
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
            ->setTo('mpeters@boundstatesoftware.com')
            ->setFrom('test@example.com')
            ->setSubject('Test')
            ->setTestMode(true);

        $this->assertTrue($message->send());
    }
}
