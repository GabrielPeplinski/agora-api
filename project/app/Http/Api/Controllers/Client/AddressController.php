<?php

namespace App\Http\Api\Controllers\Client;

use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Models\Address;
use App\Domains\Account\Strategies\CreateOrUpdateAddressStrategy;
use App\Http\Api\Request\Client\AddressRequest;
use App\Http\Api\Resources\Client\AddressResource;
use App\Http\Shared\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/client/address",
     *     operationId="Get Address",
     *     tags={"Address"},
     *     summary="Current User Address",
     *     description="Get current user address data",
     *     security={{"sanctum":{}}},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successfully retrieved current user address data",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="neighborhood", type="string", example="Centro"),
     *              @OA\Property(property="cityName", type="string", example="Guarapuava"),
     *              @OA\Property(property="stateAbbreviation", type="string", example="PR"),
     *              @OA\Property(property="zipCode", type="string", example="85010180"),
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Bad request")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ForbiddenResponseExample")
     *       )
     *    )
     * )
     */
    public function index()
    {
        $this->authorize('view', Address::class);

        if ($address = current_user()->address) {
            current_user()->load('address.city.state');

            return AddressResource::make($address);
        } else {
            return response()->json([
                'message' => 'Este usuario não possui endereco cadastrado.',
            ]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/client/address",
     *     operationId="Update or Create Address",
     *     tags={"Address"},
     *     summary="Update or Create Current User Address",
     *     description="Update or create current user address data",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                   type="string",
     *                   default="Centro",
     *                   description="Current user neighborhood name",
     *                   property="neighborhood"
     *               ),
     *              @OA\Property(
     *                  type="string",
     *                  default="Guarapuava",
     *                  description="Current user city name",
     *                  property="cityName"
     *              ),
     *              @OA\Property(
     *                  type="string",
     *                  default="PR",
     *                  description="Current user state abbreviation",
     *                  property="stateAbbreviation"
     *              ),
     *              @OA\Property(
     *                   type="string",
     *                   default="85010180",
     *                   description="Current user zip code",
     *                   property="zipCode"
     *               )
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Successfully registered user address",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="neighborhood", type="string", example="Centro"),
     *              @OA\Property(property="cityName", type="string", example="Guarapuava"),
     *              @OA\Property(property="stateAbbreviation", type="string", example="PR"),
     *              @OA\Property(property="zipCode", type="string", example="85010180"),
     *          )
     *      ),
     *
     *      @OA\Response(
     *           response=200,
     *           description="Successfully updated user address",
     *
     *           @OA\JsonContent(
     *
     *               @OA\Property(property="id", type="string", example="1"),
     *               @OA\Property(property="neighborhood", type="string", example="Centro"),
     *               @OA\Property(property="cityName", type="string", example="Guarapuava"),
     *               @OA\Property(property="stateAbbreviation", type="string", example="PR"),
     *               @OA\Property(property="zipCode", type="string", example="85010180"),
     *           )
     *       ),
     *
     *      @OA\Response(
     *           response=400,
     *           description="Bad request",
     *
     *           @OA\JsonContent(
     *
     *               @OA\Property(property="message", type="string", example="Bad request")
     *           )
     *       ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *
     *         @OA\JsonContent(ref="#/components/schemas/ForbiddenResponseExample")
     *       )
     *    )
     * )
     */
    public function createOrUpdate(AddressRequest $request): AddressResource
    {
        $this->authorize('update', Address::class);

        try {
            $data = AddressData::validateAndCreate($request->validated());

            $address = (new CreateOrUpdateAddressStrategy($data, current_user()))
                ->execute();

            return AddressResource::make($address);
        } catch (\Exception $exception) {
            throw new HttpException(500, $exception->getMessage());
        }
    }
}
