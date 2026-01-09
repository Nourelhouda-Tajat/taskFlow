<?php

abstract class Task
{
    protected ?int $id;
    protected string $title;
    protected string $description;
    protected int $projectId;
    protected int $assigneeId;
    protected int $reporterId;
    protected string $priority; 
    protected string $status;   
    protected float $estimatedHours;
    protected ?float $actualHours;
    protected DateTime $dueDate;
    protected DateTime $createdAt;
    protected ?DateTime $updatedAt;

    public function __construct( $id, $title, $description, $projectId, $assigneeId, $reporterId, $priority, $status, $estimatedHours, $actualHours, $dueDate) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->projectId = $projectId;
        $this->assigneeId = $assigneeId;
        $this->reporterId = $reporterId;
        $this->priority = $priority;
        $this->status = $status;
        $this->estimatedHours = $estimatedHours;
        $this->actualHours = $actualHours;
        $this->dueDate = $dueDate;
        $this->createdAt = new DateTime();
        $this->updatedAt = null;
    }

 
    abstract public function calculateComplexity();
    abstract public function getRequiredSkills();
}
