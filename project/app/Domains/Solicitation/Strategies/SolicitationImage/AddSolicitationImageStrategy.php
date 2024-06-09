<?php

namespace App\Domains\Solicitation\Strategies\SolicitationImage;

use App\Domains\Solicitation\Actions\SolicitationImage\CreateSolicitationImageAction;
use App\Domains\Solicitation\Dtos\SolicitationImageData;
use App\Domains\Solicitation\Models\Solicitation;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AddSolicitationImageStrategy
{
    private const BASE_PATH = 'solicitations/';

    public function execute(Solicitation $solicitation, File $tempImageFile, $isCoverImage = false)
    {
        DB::beginTransaction();

        try {
            Storage::put(self::BASE_PATH . $solicitation->id, $tempImageFile);

            $solicitationImageDto = $this->generateSolicitationImageDto($solicitation, $tempImageFile, $isCoverImage);
            Log::info('Solicitation Image DTO: ' . json_encode($solicitationImageDto));

            app(CreateSolicitationImageAction::class)
                ->execute();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            throw $error;
        }
    }

    private function generateSolicitationImageDto(Solicitation $solicitation, File $tempImageFile, $isCoverImage = false): SolicitationImageData
    {
        return SolicitationImageData::from([
            'solicitationId' => $solicitation->id,
//            'fileName' => $tempImageFile->getClientOriginalName(),
            'filePath' => $tempImageFile->getPath(),
            'isCoverImage' => $isCoverImage,
        ]);
    }
}
