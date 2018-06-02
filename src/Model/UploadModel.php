<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class UploadModel
{

    /**
     * @var FileModel[]|ArrayCollection
     *
     * @Assert\Valid()
     *
     * @Assert\Count(
     *     min="2",
     *     minMessage="Atleast 2 PDF files should be added",
     * )
     */
    private $files;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    /**
     * @return FileModel[]|ArrayCollection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param FileModel[] $files
     *
     * @return $this
     */
    public function setFiles(array $files): self
    {
        $this->files = $files;
        return $this;
    }

    public function reset(): void
    {
        $this->files = new ArrayCollection();
    }

}