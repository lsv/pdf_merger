<?php

namespace App;

use App\Model\FileModel;
use setasign\Fpdi\PdfParser\PdfParser;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\StreamReader;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PdfVersionValidate
{

    public static function validate(FileModel $object, ExecutionContextInterface $context): void
    {
        if ($object->getUploadedFile()) {
            $streamer = StreamReader::createByFile($object->getUploadedFile());
            $parser = new PdfParser($streamer);
            try {
                [$major, $minor] = $parser->getPdfVersion();
                $version = $major . '.' . $minor;
                if (! version_compare($version, 1.4, '<=')) {
                    self::writeError('Only PDF versions less or equals 1.4 is supported', $object, $context);
                }
            } catch (PdfParserException $exception) {
                if (strpos($exception->getMessage(), 'https://www.setasign.com/fpdi-pdf-parser') !== false) {
                    self::writeError('Only PDF versions less or equals 1.4 is supported', $object, $context);
                } else {
                    self::writeError($exception->getMessage(), $object, $context);
                }
            }
        }
    }

    private static function writeError($msg, FileModel $object, ExecutionContextInterface $context): void
    {
        $context
            ->buildViolation(sprintf('%s - File: "%s"', $msg, $object->getUploadedFile()->getClientOriginalName()))
            ->addViolation();
    }

}