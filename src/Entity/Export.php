<?php

namespace App\Entity;

use App\Repository\ExportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExportRepository::class)
 */
class Export
{

    public $datetimeFrom, $datetimeTo, $local = [];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $export_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $export_datetime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $local_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExportName(): ?string
    {
        return $this->export_name;
    }

    public function setExportName(string $export_name): self
    {
        $this->export_name = $export_name;

        return $this;
    }

    public function getExportDatetime(): ?\DateTimeInterface
    {
        return $this->export_datetime;
    }

    public function setExportDatetime(\DateTimeInterface $export_datetime): self
    {
        $this->export_datetime = $export_datetime;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getLocalName(): ?string
    {
        return $this->local_name;
    }

    public function setLocalName(string $local_name): self
    {
        $this->local_name = $local_name;

        return $this;
    }
}
