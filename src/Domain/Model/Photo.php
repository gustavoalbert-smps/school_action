<?php
    namespace Alura\pdo\Domain\Model;

    class Photo
    {
    
        protected string $path;
        protected int $people_id;
        
        public function __construct(string $path, int $people_id)
        {
            $this->$path = $path;
            $this->people_id = $people_id;
        }

        public function getPath()
        {
            $this->$path;
        }
        public function getPhotoPeopleId()
        {
            $this->$people_id;
        }
    }
    