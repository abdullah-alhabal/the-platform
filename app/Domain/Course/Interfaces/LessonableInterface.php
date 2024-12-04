<?php

namespace App\Domain\Course\Interfaces;

interface LessonableInterface
{
    public function lesson();
    public function getDuration(): int;
    public function getType(): string;
}
