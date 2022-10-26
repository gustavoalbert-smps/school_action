<?php
namespace Alura\pdo\Domain\Model;

class Photo
{

    private int $id;
    private string $name;
    private string $type;
    private int $people_id;
    
    public function __construct(int $id,string $name,string $type, int $people_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->people_id = $people_id;
        
    }
    
//getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getPeople_id()
    {
        return $this->people_id;
    }
}
    