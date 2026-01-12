<?php 
class FeatureTask extends Task{
    public function calculateComplexity(): int{
        return (int) ($this->estimatedHours);
    }
    public function getRequiredSkills(): array{
        return ['programming'];
    }
}
?>