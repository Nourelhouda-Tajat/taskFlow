<?php
interface Commentable
{
    public function addComment(string $comment): void;
    public function getComments(): array;
}
?>