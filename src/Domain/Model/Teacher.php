<?php

namespace Alura\Pdo\Domain\Model;

class Teacher extends People
{
    private ?int $id;
    protected ?int $peopleId;

    public function __construct(?int $id, int $peopleId, string $name, string $gender, \DateTimeInterface $birthDate,int $isAdmin)
    {
        parent::__construct($peopleId, $name, $gender, $birthDate, $isAdmin);
        $this->id = $id;
        $this->peopleId = $peopleId;
    }

//getters
    public function getId()
    {
        return $this->id;
    }
    
    public function getPeopleId()
    {
        return $this->peopleId;
    }
}