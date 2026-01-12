<?php 
class MaintenanceTask extends Task{
    public function calculateComplexity(): int{
        return (int) ($this->estimatedHours);
    }
    public function getRequiredSkills(): array{
        return ['maintenance'];
    }
}
?>