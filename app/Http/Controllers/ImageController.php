<?php

namespace App\Http\Controllers;

use File;
use App\Http\Requests;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function convertview()
	{
		$conversionPath = session()->get('conversionPath');
		return view('post3/converter', compact('conversionPath'));
	}
	public function convertclear()
	{
        foreach(glob('../public/converter/pdf/*') as $file)
        {
            if(is_dir($file)) {
                recursiveRemoveDirectory($file);
            } else {
                unlink($file);
            }
        };
        foreach(glob('../public/converter/converted-full/*') as $file)
        {
            if(is_dir($file)) {
                recursiveRemoveDirectory($file);
            } else {
                unlink($file);
            }
        };
        foreach(glob('../public/converter/converted-thumbs/*') as $file)
        {
            if(is_dir($file)) {
                recursiveRemoveDirectory($file);
            } else {
                unlink($file);
            }
        };
		return redirect()->back();
	}
    public function convert(Request $request)
    {
        $files = $request->file('files');
        $destinationPath = './converter/pdf/';
        $conversionPath="";

        if (count($files) && !is_null($files) && is_array($files) && !is_null($files[0])) {
            if (!File::exists($destinationPath)) {
                $new_folder = File::makeDirectory($destinationPath);
            }
            foreach ($files as $index => $file) {
                $newFileName = $file->getClientOriginalName();

                $upload_success = $file->move($destinationPath, $file->getClientOriginalName());
                $extension = $file->getClientOriginalExtension();
                if ($upload_success) {

                    if(isPDF($extension)){
                        $conversionPath = './converter/converted-thumbs/'.basename($newFileName, '.'.$extension).'.jpg';
                        $pdf = new \Spatie\PdfToImage\Pdf($destinationPath.$newFileName);
                        $pdf->setOutputFormat('jpg')
                            ->resizeImage(200, 300)
                            ->saveImage($conversionPath);
                    }
                    if(isPDF($extension)){
                        $conversionPath = './converter/converted-full/'.basename($newFileName, '.'.$extension).'.jpg';
                        $pdf = new \Spatie\PdfToImage\Pdf($destinationPath.$newFileName);
                        $pdf->setOutputFormat('jpg')
                            ->saveImage($conversionPath);
                    }
                }

            }
        }
        // session()->put('conversionPath', $conversionPath);
        return redirect()->back();
    }
}
