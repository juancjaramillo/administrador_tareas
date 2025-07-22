<?php
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testTitleShouldNotBeEmpty()
    {
        $title = "Estudiar PHP";
        $this->assertNotEmpty($title);
    }

    public function testPriorityShouldBeValid()
    {
        $allowed = ['alta', 'media', 'baja'];
        $this->assertContains('media', $allowed);
    }

    public function testDueDateFormat()
    {
        $due = '2025-12-31';
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $due);
    }
}
