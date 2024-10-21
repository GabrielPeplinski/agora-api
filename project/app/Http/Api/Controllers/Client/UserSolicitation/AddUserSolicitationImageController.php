<?php

namespace App\Http\Api\Controllers\Client\UserSolicitation;

use App\Domains\Solicitation\Actions\UserSolicitation\AddUserSolicitationImageAction;
use App\Domains\Solicitation\Exceptions\CannotAddUserSolicitationImageException;
use App\Domains\Solicitation\Models\UserSolicitation;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AddUserSolicitationImageController extends Controller
{
    public function __invoke(Request $request, UserSolicitation $userSolicitation)
    {
        try {
            $mySolicitation = $userSolicitation->solicitation;

            $this->authorize('updateStatus', $mySolicitation);

            $uuid = Str::uuid();
            $fileContent = $request->getContent();
            $tempFilePath = sys_get_temp_dir()."/solicitation-$mySolicitation->id-$uuid";

            file_put_contents($tempFilePath, $fileContent);

            $file = new File($tempFilePath);

            app(AddUserSolicitationImageAction::class)
                ->execute($userSolicitation, $file);

            unlink($tempFilePath);
        } catch (CannotAddUserSolicitationImageException $exception) {
            throw ValidationException::withMessages([
                $exception->getMessage(),
            ]);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => $exception->getMessage(),
                ], 500);
        }
    }
}
