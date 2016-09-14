<?php
/**
 * Created by PhpStorm.
 * User: huynguyen
 * Date: 9/10/16
 * Time: 9:58 AM
 */

namespace App\Logic\Image;

use App\Exceptions\ApplicationException;
use App\SeoOption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Image as Image;
use League\Flysystem\Exception;
use Webpatser\Uuid\Uuid as UUID;
use Illuminate\Support\Facades\DB as DB;
use DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class ImageRepository
{
    public function upload($form_data, $group = null, $base64 = false)
    {
        if(!$base64) {
            $validator = Validator::make($form_data, Image::$rules, Image::$messages);

            if ($validator->fails()) {

                return Response::json([
                    'error' => true,
                    'message' => $validator->messages()->first(),
                    'code' => 400
                ], 400);

            }
        }

        $photo = $form_data['file'];
        if($base64) {
            $filename_path = md5(time().uniqid()).".jpg";
            $photo = explode(',', $photo);
            $decoded=base64_decode($photo[1]);
            file_put_contents(Config::get('images.base64').$filename_path, $decoded);
            $photo = new UploadedFile(Config::get('images.base64').$filename_path, $filename_path);

        }
        $originalName = $photo->getClientOriginalName();
        $extension = $photo->getClientOriginalExtension();
        $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);

        $filename = $this->sanitize($originalNameWithoutExt);
        $allowed_filename = $this->createUniqueFilename( $filename, $extension );
        $width = getimagesize($photo)[0];
        $height = getimagesize($photo)[1];
        $uploadSuccess1 = $this->original( $photo, $allowed_filename.'.'.$extension );

        $uploadSuccess2 = $this->medium( $photo, $allowed_filename.'.'.$extension );

        $uploadSuccess3 = $this->low( $photo, $allowed_filename.'.'.$extension );

        if( !$uploadSuccess1 || !$uploadSuccess2 || !$uploadSuccess3 ) {

            throw new ApplicationException(500, 'Server error while uploading');
//            return Response::json([
//                'error' => true,
//                'message' => 'Server error while uploading',
//                'code' => 500
//            ], 500);

        }
            $image = new Image;

            $seo = new SeoOption;
            $seo->seo_id = Uuid::generate(5,'image_file_seo_id'.microtime(true).uniqid(), Uuid::NS_DNS);
            $seo->meta = $originalNameWithoutExt;
            $seo->keywords = $originalNameWithoutExt;
            $seo->created_at = new DateTime;
            $seo->updated_at = new DateTime;
            $seo->save();
            $image->file_id  = $allowed_filename;
            $image->original_name  = $originalNameWithoutExt;
            $image->seo_id = $seo->id;
            $image->extension = $extension;
            $image->width = $width;
            $image->height = $height;
            $image->order =  DB::raw('(select ifnull(max(g.order), 0) + 1 from `file` as g)');
            $image->created_at = new DateTime;
            $image->updated_at = new DateTime;
            $image->save();
            if($group){
                $fileGroup = [
                    'file_id' => $image->id,
                    'group_id' => $group,
                    'created_at' =>  new DateTime,
                    'updated_at' => new DateTime
                ];
                DB::table('file_group')->insert($fileGroup);
            }



        $image = Image::where('file_id','=', $allowed_filename)->first();
        return Response::json([
            'error' => false,
            'code'  => 200,
            'image' => $image
        ], 200);

    }

    public function createUniqueFilename( $filename, $extension )
    {
//        $full_size_dir = Config::get('images.full_size');
//        $full_image_path = $full_size_dir . $filename . '.' . $extension;
//
//        if ( File::exists( $full_image_path ) )
//        {
//            // Generate token for image
//            $imageToken = substr(sha1(mt_rand()), 0, 5);
//            return $filename . '-' . $imageToken . '.' . $extension;
//        }

        return  Uuid::generate(5,'image_file'.microtime(true).uniqid(), Uuid::NS_DNS);
    }

    /**
     * Optimize Original Image
     * @param $photo
     * @param $filename
     * @return \Intervention\Image\Image
     */
    public function original( $photo, $filename )
    {
        $manager = new ImageManager();
        $image = $manager->make( $photo )->save(Config::get('images.full_size') . $filename );

        return $image;
    }

    /**
     * Create Medium From Original
     * @param $photo
     * @param $filename
     * @return \Intervention\Image\Image
     */
    public function medium( $photo, $filename )
    {
        $manager = new ImageManager();
        $width = getimagesize($photo)[0] / 1.5;
        $height = getimagesize($photo)[1] / 1.5;
        $image = $manager->make( $photo )->resize($width, $height, function ($constraint) {
           // $constraint->aspectRatio();
        })
            ->save( Config::get('images.medium_size')  . $filename );

        return $image;
    }

    /**
     * Create Low From Original
     * @param $photo
     * @param $filename
     * @return \Intervention\Image\Image
     */
    public function low( $photo, $filename )
    {
        $manager = new ImageManager();
        $width = getimagesize($photo)[0] / 3;
        $height = getimagesize($photo)[1] / 3;
        $image = $manager->make( $photo )->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })
            ->save( Config::get('images.low_size')  . $filename );

        return $image;
    }

    /**
     * Delete Image From Session folder, based on original filename
     * @param $originalFilename
     * @return Response
     * @throws ApplicationException
     */
    public function delete($fileId)
    {

        $full_size_dir = Config::get('images.full_size');
        $medium_size_dir = Config::get('images.medium_size');
        $low_size_dir = Config::get('images.low_size');

        $sessionImage = Image::where('file_id', '=', $fileId)->first();


        if(empty($sessionImage))
        {
            throw new ApplicationException(400, 'Invalid Request');

        }

        $full_path1 = $full_size_dir . $sessionImage->filename;
        $full_path2 = $medium_size_dir . $sessionImage->filename;
        $full_path3 = $low_size_dir . $sessionImage->filename;

        if ( File::exists( $full_path1 ) )
        {
            File::delete( $full_path1 );
        }

        if ( File::exists( $full_path2 ) )
        {
            File::delete( $full_path2 );
        }

        if ( File::exists( $full_path3 ) )
        {
            File::delete( $full_path3 );
        }

        if(!empty($sessionImage))
        {
            $sessionImage->delete();
        }

        return response([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen($output_file, "wb");

        $data = explode(',', $base64_string);

        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);

        return $output_file;
    }
}