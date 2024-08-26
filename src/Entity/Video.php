<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Traits\Timestampable;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[ORM\Table(name: 'videos')]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['videos.index'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['videos.index'])]
    private ?string $title = null;

    #[ORM\Column(length: 500)]
    #[Groups(['videos.index'])]
    private ?string $videoLink = null;

    #[Groups(['videos.show'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    use Timestampable;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getVideoLink(): ?string
    {
        return $this->videoLink;
    }

    public function setVideoLink(string $videoLink): static
    {
        $this->videoLink = $videoLink;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getEmbedUrl(): string
    {
        return $this->convertToEmbedUrl($this->videoLink);
    }

    private function convertToEmbedUrl(string $url): string
    {
        $regex = '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^"&?\/\s]{11})/';
        if (preg_match($regex, $url, $matches) && isset($matches[1])) {
            return sprintf('https://www.youtube.com/embed/%s', $matches[1]);
        }
        return $url;
    }
}
