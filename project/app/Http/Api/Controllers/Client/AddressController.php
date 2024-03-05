<?php

namespace App\Http\Api\Controllers\Client;

use App\Domains\Account\Dtos\AddressData;
use App\Domains\Account\Strategies\CreateAddressStrategy;
use App\Http\Api\Request\Client\AddressRequest;
use App\Http\Api\Resources\Client\AddressResource;
use App\Http\Shared\Controllers\Controller;

class AddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/client/address",
     *     operationId="Get Address",
     *     tags={"Address"},
     *     summary="Current User Address",
     *     description="Get current user address data",
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
     *          response=401,
     *          description="Unauthorized",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     * )
     */
    public function index()
    {
        current_user()->load('address.city.state');

        $address = current_user()->address;

        return AddressResource::make($address);
    }

    /**
     * @OA\Put(
     *     path="/api/client/address",
     *     operationId="Update or Create Address",
     *     tags={"Address"},
     *     summary="Update or Create Current User Address",
     *     description="Update or create current user address data",
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
     *          response=400,
     *          description="Bad request",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Bad request")
     *          )
     *      ),
     * )
     */
    public function createOrUpdate(AddressRequest $request)
    {
        $data = AddressData::validateAndCreate([
            ...$request->validated(),
            'userId' => current_user()->id,
        ]);

        $address = (new CreateAddressStrategy($data))
            ->execute();

        return AddressResource::make($address);
    }
}
