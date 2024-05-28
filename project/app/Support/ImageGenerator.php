<?php

namespace App\Support;

use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Support\Facades\Storage;

class ImageGenerator
{
    private string $base64String;
    private Solicitation $solicitation;
    private const DIRECTORY_PATH = 'solicitation/';

    public function __construct(string $base64String, Solicitation $solicitation)
    {
        $this->base64String = $base64String;
        $this->solicitation = $solicitation;
    }

    private function getSolicitationImageCount(): int
    {
        return ($this->solicitation->images()->count()) + 1;
    }

    public function saveSolicitationImage(): void
    {
        $imageData = base64_decode($this->base64String);

        $filename = $this->getSolicitationImageCount() . '.png'; // You can choose the appropriate extension

        $directoryPath = self::DIRECTORY_PATH . $this->solicitation->id;

        if (!Storage::exists($directoryPath)) {
            Storage::makeDirectory($directoryPath);
        }

        Storage::put($directoryPath . '/' . $filename, $imageData);
    }
}
