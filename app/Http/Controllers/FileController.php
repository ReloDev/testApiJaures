<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class FileController extends Controller
{

    /**
 * @OA\Post(
 *     path="/api/users/addUserFile/{filecode}",
 *     summary="Ajouter un fichier pour un utilisateur",
 *     description="Cette fonction permet de télécharger des fichiers pour un utilisateur à l'aide d'un code de fichier spécifique.",
 *     operationId="addUserFile",
 *     tags={"Authentication"},
 *     @OA\Parameter(
 *         name="filecode",
 *         in="path",
 *         description="Code unique du fichier",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Fichiers à télécharger",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="files",
 *                     type="array",
 *                     @OA\Items(type="string", format="binary")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Fichier ajouté avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="string",
 *                 example="file add successfuly"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Message d'erreur"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Données de validation invalides",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Les fichiers sont requis."
 *             )
 *         )
 *     )
 * )
 */

    public function addUserFile(Request $request, $filecode){
        try{

            $request->validate([
                'files' => ['required']
            ]);

            $service = new Service();

            $service->uploadFiles($request,$filecode,'user');

            return response()->json([
                'data' =>'file add successfuly'
            ]);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ],500);
        }
    }
}
