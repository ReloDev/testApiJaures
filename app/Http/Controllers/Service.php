<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Admin;
use App\Models\AttributeGroup;
use App\Models\Category;
use App\Models\Client;
use App\Models\Commission;
use App\Models\CommissionWallet;
use App\Models\Country;
use App\Models\DeliveryAgency;
use App\Models\File;
use App\Models\Person;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as F ;
use Ramsey\Uuid\Uuid;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Service extends Controller
{
    public function generateRandomAlphaNumeric($length,$class,$colonne) {
        $bytes = random_bytes(ceil($length * 3 / 4));
        $randomS =  substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $length);

        $exist = $class->where($colonne,$randomS)->first();
        while($exist){
            $randomS =  substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $length);
        }

        return $randomS;
    }

    public function generateUid($class){
        $ulid = Uuid::uuid1();
        $uid = $ulid->toString();
        $exist = $class->where('uid',$uid)->first();
            while($exist){
                $uid =  $ulid->toString();
            }
        return $uid;
    }

    public function checkFile(Request $request){
        try {
            if(!$request->hasFile('files')){
                return response()->json([
                    'message' =>'the field file is required'
                ],404);
            }
        } catch (\Exception $th) {

        }
    
    }

    public function validateFile( $file){
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif','JPEG','JPG','PNG','GIF'];
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception('Veuillez télécharger une image (jpeg, jpg, png, gif)');
        }
        $errorcheckImageSize = $this->checkImageSize($file);
        if($errorcheckImageSize){
            return $errorcheckImageSize;
        }
    }

    public function uploadFiles(Request $request, $randomString,$location){
        foreach($request->file('files') as $photo){
            $errorUploadFiles = $this->validateFile($photo);
            $this->storeFile($photo, $randomString, $location);

            if($errorUploadFiles){
                return $errorUploadFiles;
            }

            // return 1;
        }
    }



    private function storeFile( $photo, $randomString, $location){
        try {

            $db = DB::connection()->getPdo();

            $size = filesize($photo);
            $ulid = Uuid::uuid1();
            $ulidPhoto = $ulid->toString();
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photoPath = $photo->move(public_path("image/$location"), $photoName);
            $photoUrl = url("/image/$location/" . $photoName);
            $type = $photo->getClientOriginalExtension();
            $locationFile = $photoUrl;
            $referencecode = $randomString;
            $filename = md5(uniqid()) . '.' . $type;
            $uid = $ulidPhoto;
            $q = "INSERT INTO files (filename, type, location, size, referencecode, uid,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $db->prepare($q);
            $stmt->bindParam(1, $filename);
            $stmt->bindParam(2, $type);
            $stmt->bindParam(3, $locationFile);
            $stmt->bindParam(4,  $size);
            $stmt->bindParam(5,  $referencecode);
            $stmt->bindParam(6,  $uid);
            $stmt->bindParam(7,  $created_at);
            $stmt->bindParam(8,  $updated_at);
            $stmt->execute();

        } catch (Exception $e) {
           return response()->json([
            'error' => $e->getMessage()
           ]);
        }
    }

    public function checkImageSize ($photo){
        if(filesize($photo) >= 2097152){
            return response()->json([
                'message' =>'The image size exceeds what is normally required (< 2mo)',
                'size' =>filesize($photo)
            ]);
        }
    }

    public function validateDoc( $file){
        $allowedExtensions = ['pdf', 'doc', 'docx', 'pptx','PDF', 'DOC', 'DOX', 'PPTX'];
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception('Veuillez télécharger un document valide (pdf, doc, pptx, dox)');
        }
    }

    public function validateZip( $file){

        $allowedExtensions = [
            'zip',  'zipx',  '7z','rar','tar','tar.gz'   
        ];
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception('Veuillez télécharger un bon fichier zippé (zip, zipx, rar, tar)');
        }
    }

    public function uploadDocs(Request $request, $randomString,$location){
        foreach($request->file('files') as $photo){
            $this->validateDoc($photo);
            $this->storeFile($photo, $randomString, $location);
        }
    }

    public function uploadZipFile(Request $request, $randomString,$location){
        foreach($request->file('files') as $photo){
            $this->validateZip($photo);
            $this->storeFile($photo, $randomString, $location);
        }
    }


    public function removeFile($uid){
        try {

            if(!File::whereUid($uid)->first()){
                return response()->json([
                    'message' =>'File not found'
                ]);
            }

            $file = File::whereUid($uid)->first();

            $oldProfilePhotoUrl = $file->location;
            if ($oldProfilePhotoUrl) {
                $parsedUrl = parse_url($oldProfilePhotoUrl);
                $oldProfilePhotoPath = public_path($parsedUrl['path']);
                if (F::exists($oldProfilePhotoPath)) {
                    F::delete($oldProfilePhotoPath);
                }
            }

            if($file->deleted == true){
                return response()->json([
                    'message' => 'This file is already removed'
                ]);
            }

            File::whereUid($uid)->update([
                'deleted' => true,
                'updated_at' => now()
            ]);

            return response()->json([
                'message' => 'remove successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

   
}
