<?php
interface Prioritizable
{
    public function setPriority(string $priority): void;
    public function getPriority(): string;
}
?>