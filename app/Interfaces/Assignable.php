<?php
interface Assignable
{
    public function assignTo(int $userId): void;
    public function unassign(): void;
}

?>