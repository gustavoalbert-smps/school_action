<?php
    namespace Alura\pdo\Domain\Model;

    class Photo
    {
        
        private int $id;
        private string $path;
        private $people_id;
        
        public function __construct(int $id, string $path, int $people_id)
        {
            $this->$id = $id;
            $this->$path = $path;
            $this->people_id = $people_id;
        }
        public function getPhotoId()
        {
            $this->$id;
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
    