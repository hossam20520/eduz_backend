<?php
namespace App\Http\Controllers;

use App\Models\Institution;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Area;
class InstitutionsController extends Controller
{

    //------------ GET ALL Institutions -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Institution::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $institutions = Institution::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $institutions->count();
        $institutions = $institutions->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();


            $areas = Area::where('deleted_at', '=', null )->get();


           $data = array();

            foreach ($institutions as $inst) {
 
                $item['id'] =  $inst->id;
                $item['ar_name'] =  $inst->ar_name;
                $item['en_name'] =  $inst->en_name;
                $item['banner'] =  $inst->banner;
                $item['image'] =  $inst->image;
                $item['slider'] =  $this->getImagesMulit($inst->slider);
                  
                                  
                // $item['images'] = [];
                // if ($inst->slider != '' && $inst->slider != 'no-image.png') {
                //     foreach (explode(',', $inst->slider) as $img) {
                //         $path = public_path() . '/images/institutions/' . $img;
                //         if (file_exists($path)) {
                //             $itemImg['name'] = $img;
                //             $type = pathinfo($path, PATHINFO_EXTENSION);
                //             $data = file_get_contents($path);
                //             $itemImg['path'] = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
                //             $item['images'][] = $itemImg;
                //         }
                //     }
                // } else {
                //     $item['images'] = [];
                // }


                $data[] = $item;
            }



 
 
    

            

        return response()->json([
            'countries' => $areas ,
            'institutions' => $data,
            'totalRows' => $totalRows,
        ]);

    }



    public function  getImagesMulit($inst){
                    $item['images'] = [];
                if ( $inst != '' && $inst != 'no-image.png') {
                    foreach (explode(',', $inst) as $img) {
                        $path = public_path() . '/images/institutions/' . $img;
                        if (file_exists($path)) {
                            $itemImg['name'] = $img;
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $itemImg['path'] = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
                            $item['images'][] = $itemImg;
                        }
                    }
                } else {
                    $item['images'] = [];
                }

                return $item['images'];
    }

    //---------------- STORE NEW Institution -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Institution::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $banner = $request->file('banner');

                $filenameBanner = rand(11111111, 99999999) . $banner->getClientOriginalName();
                $image_resize_banner = Image::make($banner->getRealPath());
                // $image_resize_banner->resize(200, 200);
                $image_resize_banner->save(public_path('/images/institutions/' .  $filenameBanner));


                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
                $image_resize = Image::make($image->getRealPath());
                // $image_resize->resize(200, 200);
                $image_resize->save(public_path('/images/institutions/' . $filename));

            } else {
                $filename = 'no-image.png';
                $filenameBanner = 'no-image.png';
            }

            $Institution = new Institution;

            $Institution->en_name = $request['en_name'];
            $Institution->ar_name = $request['ar_name'];
            $Institution->banner =$filenameBanner;

            
            $Institution->image = $filename;
            $Institution->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }



    public function updateImageMulti($name , $pathUrl , $ModelImage  , $request){
        if ($request[$name] === null) {

            if ($ModelImage  !== null) {
                foreach (explode(',', $Product->image) as $img) {
                    $pathIMG = public_path() . '/images/'.$pathUrl.'/'. $img;
                    if (file_exists($pathIMG)) {
                        if ($img != 'no-image.png') {
                            @unlink($pathIMG);
                        }
                    }
                }
            }
            $filename = 'no-image.png';
        } else {
            if ($ModelImage !== null) {
                foreach (explode(',', $ModelImage ) as $img) {
                    $pathIMG = public_path() . '/images/'.$pathUrl.'/'.$img;
                    if (file_exists($pathIMG)) {
                        if ($img != 'no-image.png') {
                            @unlink($pathIMG);
                        }
                    }
                }
            }
            $files = $request[$name];
            foreach ($files as $file) {
                $fileData =  base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path']));
                // $fileData->resize(200, 200);
                $name = rand(11111111, 99999999) . $file['name'];
                $path = public_path() . '/images/'.$pathUrl.'/';
                $success = file_put_contents($path . $name, $fileData);
                $images[] = $name;
            }
            $filename = implode(",", $images);
            return $filename;
        }
    }

     //---------------- UPDATE Institution -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Institution::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Institution = Institution::findOrFail($id);
             $currentImage = $Institution->image;
 
             // dd($request->image);
             if ($currentImage && $request->image != $currentImage) {
                 $image = $request->file('image');
                 $path = public_path() . '/images/institutions';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 
                 $image_resize->save(public_path('/images/institutions/' . $filename));
 
                 $InstitutionImage = $path . '/' . $currentImage;
                 if (file_exists($InstitutionImage)) {
                     if ($currentImage != 'no-image.png') {
                         @unlink($InstitutionImage);
                     }
                 }
             } else if (!$currentImage && $request->image !='null'){
                 $image = $request->file('image');
                 $path = public_path() . '/images/institutions';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
               
                 $image_resize->save(public_path('/images/institutions/' . $filename));
             }
 
             else {
                 $filename = $currentImage?$currentImage:'no-image.png';
             }


          



             $currentImage_banner = $Institution->banner;


             if ( $currentImage_banner && $request->banner !=  $currentImage_banner) {
                $banner = $request->file('banner');
                $path_banner = public_path() . '/images/institutions';
                $filename_banner = rand(11111111, 99999999) . $banner->getClientOriginalName();

                $image_resize_banner = Image::make($banner->getRealPath());
                // $image_resize->resize(200, 200);
                $image_resize_banner->save(public_path('/images/institutions/' . $filename_banner));

                $InstitutionImage_banner =  $path_banner. '/' . $currentImage;
                if (file_exists($InstitutionImage_banner)) {
                    if ($currentImage_banner != 'no-image.png') {
                        @unlink($InstitutionImage_banner);
                    }
                }
            } else if (!$currentImage_banner && $request->banner !='null'){
                $banner = $request->file('banner');
                $path_banner = public_path() . '/images/institutions';
                $filename_banner = rand(11111111, 99999999) . $banner->getClientOriginalName();

                $image_resize_banner = Image::make($banner->getRealPath());
                // $image_resize->resize(200, 200);
                $image_resize_banner->save(public_path('/images/institutions/' . $filename_banner));
            }

            else {
                $filename_banner = $currentImage_banner?$currentImage_banner:'no-image.png';
            }
 
            $slider = $this->updateImageMulti('images' ,  'institutions' , $Institution->slider , $request );
            
             Institution::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'en_name' => $request['en_name'],
                 'slider'=>  $slider,
                 'image' => $filename,
                 'banner' => $filename_banner
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Institution -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Institution::class);

        Institution::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Institution::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $institution_id) {
            Institution::whereId($institution_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

