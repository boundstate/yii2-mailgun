<?php
namespace boundstate\mailgun;


use yii\base\NotSupportedException;
use yii\helpers\VarDumper;
use yii\mail\BaseMessage;
use Mailgun\Message\MessageBuilder;

/**
 * Message implements a message class based on Mailgun.
 */
class Message extends BaseMessage
{
    /**
     * @var MessageBuilder Mailgun message builder.
     */
    private $_messageBuilder;


    /**
     * @return MessageBuilder Mailgun message builder.
     */
    public function getMessageBuilder()
    {
        if (!is_object($this->_messageBuilder)) {
            $this->_messageBuilder = $this->createMessageBuilder();
        }

        return $this->_messageBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getCharset()
    {
        return 'utf8';
    }

    /**
     * @inheritdoc
     * @deprecated Mailgun only supports UTF8
     */
    public function setCharset($charset)
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['from']) ? $message['from'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setFrom($from)
    {
        $addresses = EmailAddress::parse($from);

        foreach ($addresses as $address) {
            $this->getMessageBuilder()->setFromAddress($address->email, $address->variables);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getReplyTo()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['h:reply-to']) ? $message['h:reply-to'] : null;
    }

    /**
     * @inheritdoc
     * @throws NotSupportedException if multiple addresses are provided (Mailgun only supports one)
     */
    public function setReplyTo($replyTo)
    {
        $addresses = EmailAddress::parse($replyTo);

        if (count($addresses) !== 1) {
            throw new NotSupportedException('Mailgun only supports one reply-to address');
        }

        $this->getMessageBuilder()->setReplyToAddress($addresses[0]->email, $addresses[0]->variables);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['to']) ? $message['to'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setTo($to)
    {
        $addresses = EmailAddress::parse($to);

        foreach ($addresses as $address) {
            $this->getMessageBuilder()->addToRecipient($address->email, $address->variables);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCc()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['cc']) ? $message['cc'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setCc($cc)
    {
        $addresses = EmailAddress::parse($cc);

        foreach ($addresses as $address) {
            $this->getMessageBuilder()->addCcRecipient($address->email, $address->variables);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBcc()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['bcc']) ? $message['bcc'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setBcc($bcc)
    {
        $addresses = EmailAddress::parse($bcc);

        foreach ($addresses as $address) {
            $this->getMessageBuilder()->addBccRecipient($address->email, $address->variables);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['subject']) ? $message['subject'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setSubject($subject)
    {
        $this->getMessageBuilder()->setSubject($subject);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTextBody($text)
    {
        $this->getMessageBuilder()->setTextBody($text);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHtmlBody($html)
    {
        $this->getMessageBuilder()->setHtmlBody($html);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attach($fileName, array $options = [])
    {
        $attachmentName = !empty($options['fileName']) ? $options['fileName'] : null;
        $this->getMessageBuilder()->addAttachment("@{$fileName}", $attachmentName);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attachContent($content, array $options = [])
    {
        $attachmentName = !empty($options['fileName']) ? $options['fileName'] : null;
        $message = $this->getMessageBuilder()->getMessage();

        if (!isset($message['attachment'])) {
            $message['attachment'] = [];
        }

        $message['attachment'][] = [
            'fileContent' => $content,
            'filename' => $attachmentName,
        ];
        $this->getMessageBuilder()->setMessage($message);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function embed($fileName, array $options = [])
    {
        $attachmentName = !empty($options['fileName']) ? $options['fileName'] : basename($fileName);
        $this->getMessageBuilder()->addInlineImage("@{$fileName}", $attachmentName);
        return 'cid:'.$attachmentName;
    }

    /**
     * @inheritdoc
     * @deprecated Embedding content is not supported by Mailgun.
     */
    public function embedContent($content, array $options = [])
    {
        throw new NotSupportedException('Embedding content is not supported');
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return VarDumper::dumpAsString($this->getMessageBuilder()->getMessage());
    }

    /**
     * Sets whether to send the message in test mode.
     * @param bool $enabled Mailgun will accept the message but will not send it. This is useful for testing purposes.
     * @return Message self reference.
     */
    public function setTestMode(bool $enabled): self {
        $this->getMessageBuilder()->setTestMode($enabled);

        return $this;
    }

    /**
     * Creates the Mailgun message builder.
     * @return MessageBuilder message builder.
     */
    protected function createMessageBuilder()
    {
        return new MessageBuilder;
    }
}
