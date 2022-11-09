<?php

namespace Alura\Pdo\Domain\Model;

class Teacher extends People
{
    private ?int $id;
    protected ?int $peopleId;
    protected string $graduation;

    public function __construct(?int $id, int $peopleId, string $graduation ,string $name, string $gender, \DateTimeInterface $birthDate,int $isAdmin)
    {
        parent::__construct($peopleId, $name, $gender, $birthDate, $isAdmin);
        $this->id = $id;
        $this->peopleId = $peopleId;
        $this->graduation = $graduation;
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

    public function getGraduation()
    {
        return $this->graduation;
    }
}