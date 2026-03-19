<?php

namespace Tests;

use App\HostelAllocator;
use PHPUnit\Framework\TestCase;

class HostelAllocatorTest extends TestCase
{
    private HostelAllocator $allocator;

    protected function setUp(): void
    {
        $this->allocator = new HostelAllocator();
    }

    public function testGenderSeparationCaseInsensitivity()
    {
        $rooms = [];
        $this->allocator->allocateRoom('Alice', 'F', 1, $rooms);
        $this->allocator->allocateRoom('Bob', 'm', 1, $rooms); // Lowercase 'm'

        $this->assertArrayHasKey('F-101', $rooms);
        $this->assertArrayHasKey('M-102', $rooms, "Lowercase 'm' should still map to 'M-' wing");
    }

    public function testFirstYearCapacity()
    {
        $rooms = [];
        $this->allocator->allocateRoom('S1', 'M', 1, $rooms);
        $this->allocator->allocateRoom('S2', 'M', 1, $rooms);
        $this->allocator->allocateRoom('S3', 'M', 1, $rooms);
        $this->allocator->allocateRoom('S4', 'M', 1, $rooms);
        $this->allocator->allocateRoom('S5', 'M', 1, $rooms);

        $this->assertCount(4, $rooms['M-101'], "First year room should cap at 4");
        $this->assertCount(1, $rooms['M-102']);
    }

    public function testSecondYearCapacity()
    {
        $rooms = [];
        $this->allocator->allocateRoom('S1', 'F', 2, $rooms);
        $this->allocator->allocateRoom('S2', 'F', 2, $rooms);
        $this->allocator->allocateRoom('S3', 'F', 2, $rooms);

        $this->assertCount(2, $rooms['F-101'], "Second year room should cap at 2");
        $this->assertCount(1, $rooms['F-102']);
    }

    public function testThirdYearCapacity()
    {
        $rooms = [];
        $this->allocator->allocateRoom('S1', 'M', 3, $rooms);
        $this->allocator->allocateRoom('S2', 'M', 3, $rooms);

        $this->assertCount(1, $rooms['M-101'], "Third year room should cap at 1 (Single)");
        $this->assertCount(1, $rooms['M-102']);
    }

    public function testStrictPrefixChecking()
    {
        $rooms = [
            'M-101' => ['John']
        ];
        
        $allocated = $this->allocator->allocateRoom('Alice', 'F', 1, $rooms);
        
        $this->assertStringStartsWith('F-', $allocated, "Female student should be in F- wing");
        $this->assertNotEquals('M-101', $allocated, "Female student should not be placed in M-101");
    }
}
