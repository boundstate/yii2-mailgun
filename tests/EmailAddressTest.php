<?php
namespace boundstate\mailgun\tests;

use boundstate\mailgun\EmailAddress;

final class EmailAddressTest extends TestCase
{
    public function testParseString(): void
    {
        $addresses = EmailAddress::parse('jon@example.com');
        $this->assertCount(1, $addresses);
        $this->assertInstanceOf(EmailAddress::class, $addresses[0]);
        $this->assertEquals('jon@example.com', $addresses[0]->email);
        $this->assertEquals([], $addresses[0]->variables);
    }

    public function testParseSimpleArray(): void
    {
        $addresses = EmailAddress::parse(['jake@example.com', 'sally@example.com']);
        $this->assertCount(2, $addresses);
        $this->assertInstanceOf(EmailAddress::class, $addresses[0]);
        $this->assertEquals('jake@example.com', $addresses[0]->email);
        $this->assertEquals([], $addresses[0]->variables);
        $this->assertEquals('sally@example.com', $addresses[1]->email);
        $this->assertEquals([], $addresses[1]->variables);
    }

    public function testParseArrayWithNames(): void
    {
        $addresses = EmailAddress::parse([
            'jake@example.com' => 'Jake',
            'sally@example.com' => 'Sally'
        ]);
        $this->assertCount(2, $addresses);
        $this->assertInstanceOf(EmailAddress::class, $addresses[0]);
        $this->assertEquals('jake@example.com', $addresses[0]->email);
        $this->assertEquals(['full_name' => 'Jake'], $addresses[0]->variables);
        $this->assertEquals('sally@example.com', $addresses[1]->email);
        $this->assertEquals(['full_name' => 'Sally'], $addresses[1]->variables);
    }

    public function testParseArrayWithVariables(): void
    {
        $addresses = EmailAddress::parse([
            'jake@example.com' => ['full_name' => 'Jake', 'id' => 5],
            'sally@example.com' => ['full_name' => 'Sally', 'id' => 6]
        ]);
        $this->assertCount(2, $addresses);
        $this->assertInstanceOf(EmailAddress::class, $addresses[0]);
        $this->assertEquals('jake@example.com', $addresses[0]->email);
        $this->assertEquals(['full_name' => 'Jake', 'id' => 5], $addresses[0]->variables);
        $this->assertEquals('sally@example.com', $addresses[1]->email);
        $this->assertEquals(['full_name' => 'Sally', 'id' => 6], $addresses[1]->variables);
    }
}
