<?php
namespace Alura\pdo\Domain\Model;

class Photo
{

    private int $id;
    private int $people_id;
    private string $name;
    private string $type;
    
    public function __construct(int $id,int $people_id,string $name,string $type)
    {
        $this->id = $id;
        $this->people_id = $people_id;
        $this->name = $name;
        $this->type = $type;
        
        
    }
    
//getters
    public function getId()
    {
        return $this->id;
    }
    public function getPeople_id()
    {
        return $this->people_id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getType()
    {
        return $this->type;
    }

}
    