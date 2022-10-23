<?php

namespace Alura\Pdo\Domain\Model;

class SchoolClass 
{
    private ?int $id;
    private string $year;
    private string $identifier;
    private string $shift;
    
    public function __construct(?int $id, string $year, string $identifier, string $shift)
    {
        $this->id = $id;
        $this->year = $year;
        $this->identifier = $identifier;
        $this->shift = $shift;
    }

//getters    
    public function getId()
    {
        return $this->id;
    }
    
    public function getYear(): string
    {
        return $this->year;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
   
    public function getShift(): string
    {
        return $this->shift;
    }
}