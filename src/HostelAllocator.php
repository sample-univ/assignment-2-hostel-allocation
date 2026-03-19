<?php

namespace App;

use Exception;

class HostelAllocator
{
    /**
     * Allocates a room for a student.
     * 
     * @param string $studentName Name of the student
     * @param string $gender 'M' or 'F'
     * @param int $year 1, 2, or 3
     * @param array $currentRooms Existing room allocations
     * @return string The allocated room ID (e.g., 'M-101', 'F-205')
     */
    public function allocateRoom(string $studentName, string $gender, int $year, array &$currentRooms): string
    {
        // BUG 1: Case sensitive gender check might place 'm' in Female wing if not handled correctly
        $wingPrefix = ($gender == 'M') ? 'M-' : 'F-';
        
        // Determine capacity based on year
        // BUG 2: 3rd year is missing, defaults to 4, which violates 3rd year = 1 student rule
        $capacity = 4; 
        if ($year == 1) {
            $capacity = 4;
        } elseif ($year == 2) {
            // BUG 3: Typo/Logic error, allowing 3 instead of 2
            $capacity = 3; 
        }

        // Find an existing room in the correct wing with available capacity
        foreach ($currentRooms as $roomId => $occupants) {
            // BUG 4: strpos logic allows 'F-M-101' or similar edge cases, or just checks prefix poorly
            // We should strictly check startsWith, but let's use a simpler bug:
            // str_contains might mix up F-101 and M-1F-101, but let's just use str_starts_with incorrectly
            if (strpos($roomId, $wingPrefix) !== false) {
                if (count($occupants) < $capacity) {
                    $currentRooms[$roomId][] = $studentName;
                    return $roomId;
                }
            }
        }

        // Create a new room if none available
        $newRoomNumber = count($currentRooms) + 101;
        $newRoomId = $wingPrefix . $newRoomNumber;
        
        $currentRooms[$newRoomId] = [$studentName];
        return $newRoomId;
    }
}
