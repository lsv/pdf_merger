<?php

namespace App\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Assert\Callback({"App\PdfVersionValidate", "validate"})
 */
class FileModel
{

    /**
     * @var UploadedFile|null
     *
     * @Assert\NotBlank()
     * @Assert\File(
     *     mimeTypes={"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage="Please upload a valid PDF file",
     * )
     */
    private $uploadedFile;

    public function getUploadedFile(): ?UploadedFile
    {
        return $this->uploadedFile;
    }

    public function setUploadedFile(UploadedFile $uploadedFile): self
    {
        $this->uploadedFile = $uploadedFile;
        return $this;
    }

}