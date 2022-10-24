<?php
namespace Alura\pdo\Domain\Model;

class Photo
{

    private int $id;
    private string $path;
    private int $people_id;
    
    public function __construct(int $id, string $path, int $people_id)
    {
        $this->id = $id;
        $this->path = $path;
        $this->people_id = $people_id;
    }
    
//getters
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
    