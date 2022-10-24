<?php
namespace Alura\pdo\Domain\Model;

class Photo
{

    private int $id;
    private string $name;
    private string $type;
    private string $path;
    private int $people_id;
    
    public function __construct(int $id,string $name,string $type, string $path, int $people_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->path = $path;
        $this->people_id = $people_id;
        
    }
    
//getters
    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getPeople_id()
    {
        return $this->people_id;
    }
}
    