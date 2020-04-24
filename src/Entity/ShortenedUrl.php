<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShortenedUrlRepository")
 */
class ShortenedUrl
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expires_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @var LifetimeDuration|null
     */
    private $lifetime;

    public static function loadValidatorMetadata(ClassMetadata $classMetadata)
    {
        $classMetadata->addPropertyConstraint('url', new NotBlank());
        $classMetadata->addPropertyConstraint('url', new Url());
        $classMetadata->addPropertyConstraint('url', new Length([
            'max' => 10000 // всему есть предел, полагаю)
        ]));

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     * @throws \Exception
     */
    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expires_at;
    }

    /**
     * @param \DateTimeInterface|null $expires_at
     * @return $this
     */
    public function setExpiresAt(?\DateTimeInterface $expires_at): self
    {
        $this->expires_at = $expires_at;

        return $this;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return LifetimeDuration|null
     */
    public function getLifetime(): ?LifetimeDuration
    {
        return $this->lifetime;
    }

    /**
     * @param LifetimeDuration|null $lifetime
     */
    public function setLifetime(?LifetimeDuration $lifetime): void
    {
        $this->lifetime = $lifetime;
    }
}
