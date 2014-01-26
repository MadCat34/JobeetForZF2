<?php
namespace Front\Model;

class Job
{
    public $idJob;
    public $idCategory;
    public $type;
    public $company;
    public $logo;
    public $url;
    public $position;
    public $location;
    public $description;
    public $howToPlay;
    public $isPublic;
    public $isActivated;
    public $email;
    public $createdAt;
    public $updatedAt;

    public function exchangeArray($data)
    {
        $this->idJob = (isset($data['id_job'])) ? $data['id_job'] : null;
        $this->idCategory = (isset($data['id_category'])) ? $data['id_category'] : null;
        $this->idUser = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->type = (isset($data['type'])) ? $data['type'] : null;
        $this->company = (isset($data['company'])) ? $data['company'] : null;
        $this->logo = (isset($data['logo'])) ? $data['logo'] : null;
        $this->url = (isset($data['url'])) ? $data['url'] : null;
        $this->position = (isset($data['position'])) ? $data['position'] : null;
        $this->location = (isset($data['location'])) ? $data['location'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->howToPlay = (isset($data['how_to_play'])) ? $data['how_to_play'] : null;
        $this->isPublic = (isset($data['is_public'])) ? $data['is_public'] : null;
        $this->isActivated = (isset($data['is_activated'])) ? $data['is_activated'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->createdAt = (isset($data['created_at'])) ? $data['created_at'] : null;
        $this->updatedAt = (isset($data['updated_at'])) ? $data['updated_at'] : null;
    }
}
