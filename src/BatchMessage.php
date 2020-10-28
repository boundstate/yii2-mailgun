<?php
namespace boundstate\mailgun;


use Yii;
use Mailgun\Message\BatchMessage as BatchMessageBuilder;
use yii\base\Exception;

/**
 * BatchMessage implements a message class based on Mailgun.
 */
class BatchMessage extends Message
{
    /**
     * @var Mailer the mailer instance that created this message.
     * For independently created messages this is `null`.
     */
    public $mailer;

    /**
     * @var BatchMessageBuilder Mailgun batch message.
     */
    private $_batchMessageBuilder;

    /**
     * @return BatchMessageBuilder Mailgun message builder.
     */
    public function getMessageBuilder()
    {
        if (!is_object($this->_batchMessageBuilder)) {
            $this->_batchMessageBuilder = $this->createMessageBuilder();
        }

        return $this->_batchMessageBuilder;
    }

    /**
     * Send any remaining recipients still in the buffer.
     */
    public function finalize() {
        $this->$this->getMessageBuilder()->finalize();
    }

    /**
     * Creates the Mailgun message builder.
     * @return BatchMessageBuilder message builder.
     * @throws Exception if mailer is not an instance of Mailer (i.e. independently created messages)
     */
    protected function createMessageBuilder()
    {
        if (!($this->mailer instanceof Mailer)) {
            throw new Exception('BatchMessage must be created from the Mailgun Mailer');
        }
        return $this->mailer->getMailgun()->messages()->getBatchMessage($this->mailer->domain, false);
    }
}
