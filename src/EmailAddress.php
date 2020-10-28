<?php
namespace boundstate\mailgun;

/**
 * Represents a normalized email address.
 */
class EmailAddress
{
    /**
     * Normalizes input as an array of email address objects.
     * @param string|array $input email address or array of addresses
     * Supports providing name in addition to email address using format: `[email => name]`.
     * Also supports providing variables using format: `[email => variables]`.
     * @return EmailAddress[]
     */
    static function parse($input) {
        if (!is_array($input)) {
            return [new EmailAddress($input)];
        }

        $emails = [];
        foreach ($input as $key => $value) {
            if (is_numeric($key)) {
                $email = $value;
                $variables = [];
            } else {
                $email = $key;
                $variables = is_array($value) ? $value : ['full_name' => $value];
            }
            $emails[] = new EmailAddress($email, $variables);
        }

        return $emails;
    }

    /**
     * @var string email address.
     */
    public $email;

    /**
     * @param array $variables {
     *     @var string $id If used with BatchMessage
     *     @var string $full_name
     *     @var string $first
     *     @var string $last
     * }
     */
    public $variables;

    function __construct(string $email, array $variables = []) {
        $this->email = $email;
        $this->variables = $variables;
    }
}
