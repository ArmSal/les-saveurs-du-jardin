<?php

namespace App\Entity;

use App\Repository\CleaningTaskItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CleaningTaskItemRepository::class)]
#[ORM\Table(name: 'cleaning_task_item')]
class CleaningTaskItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: CleaningTask::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?CleaningTask $cleaningTask = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(options: ["default" => true])]
    private bool $completed = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCleaningTask(): ?CleaningTask
    {
        return $this->cleaningTask;
    }

    public function setCleaningTask(?CleaningTask $cleaningTask): static
    {
        $this->cleaningTask = $cleaningTask;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): static
    {
        $this->completed = $completed;
        return $this;
    }
}
