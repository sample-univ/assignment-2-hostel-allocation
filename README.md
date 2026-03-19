# Assignment 2: Hostel Room Allocation (Troubleshoot & Fix)

Welcome to your second assessment! In this assignment, you need to fix a buggy PHP class used for hostel room allocation.

## Objective
The `HostelAllocator` class is designed to allocate rooms based on the following specific business rules:
1. **Gender Separation**: Male and Female students MUST be placed in different wings/buildings.
2. **Year-based Capacity**:
   - 1st-year students: 4 students per room.
   - 2nd-year students: 2 students per room.
   - 3rd-year students: 1 student per room (Single room).

## The Bug Report
The hostel administration has reported severe issues with the current system:
- It occasionally assigns 3rd-year students to shared rooms instead of single rooms.
- It sometimes over-allocates 2nd-year rooms (assigning 3 or 4 students to a 2-person room).
- Most critically, it has occasionally mixed genders in the same wing due to case-sensitivity or logic flaws.

## Your Task
1. Examine `src/HostelAllocator.php`.
2. Run the tests in `tests/HostelAllocatorTest.php` to see the failures.
3. Fix the bugs in `src/HostelAllocator.php` without changing the method signatures.
4. Ensure all PHPUnit tests pass.

## Running Tests
Run the following in your Codespace terminal:
```bash
./vendor/bin/phpunit tests
```
Do not modify the files inside the `tests/` directory. Your goal is to make the existing tests pass!
