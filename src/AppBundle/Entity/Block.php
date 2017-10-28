<?php

namespace AppBundle\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Block
 *
 * @ORM\Table(name="block")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BlockRepository")
 */
class Block
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=40, unique=true)
     */
    private $hash;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", unique=true)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="signature", type="string", length=130, unique=true)
     */
    private $signature;

    /**
     * @var int
     *
     * @ORM\Column(name="operationsCount", type="integer")
     */
    private $operationsCount;

    public function getId() : int
    {
        return $this->id;
    }

    public function setHash(string $hash) : Block
    {
        $this->hash = $hash;

        return $this;
    }

    public function getHash() : string
    {
        return $this->hash;
    }

    public function setCreatedAt(DateTimeInterface $createdAt) : Block
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt() : DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setSignature(string $signature) : Block
    {
        $this->signature = $signature;

        return $this;
    }

    public function getSignature() : string
    {
        return $this->signature;
    }

    public function setOperationsCount(int $operationsCount) : Block
    {
        $this->operationsCount = $operationsCount;

        return $this;
    }

    public function getOperationsCount() : int
    {
        return $this->operationsCount;
    }
}
