<?php 
class BugTask extends Task{
    public function calculateComplexity(): int{
        return (int) ($this->estimatedHours);
    }
    public function getRequiredSkills(): array{
        return ['debugging', 'testing'];
    }
}
?>