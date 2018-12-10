<?php

namespace App\Http\Controllers;

use Input;
use DB;
use Excel;
use Illuminate\Http\Request;

class ImportController extends Controller
{

        
    public function index()
    {
        return view('import.import');
    }

    /*
    * Import csv file
    */
    public function importCrossword(Request $request){
        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            //dd($data);
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    $insert[] = [
                        'id' => intval($value->id),
                        'user_id' => 1,
                        'content' => $value->content,
                        'width' => intval($value->width),
                        'height' => intval($value->height),
                        'level' => intval($value->level),
                        'helps' => intval($value->helps),
                        'price' => intval($value->price),
                        'difficulty_level' => intval($value->locked_by),
                        'goal_time' => 2500,

                    ];
                }
                if(!empty($insert)){
                    if (DB::table('crosswords')->insert($insert)){
                        return "OK";
                    }
                    dd('some errors in '.  __FILE__);
                }
            }
        }

    }

    /**
     * Import FIELDS
     */

    public function fields()
    {
        return view('import.importfields');
    }


    public function importFields(Request $request){

        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {

            })->get();

            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {

                    if($value->horizontal == 'TRUE'){

                        $insert[] = [
                            'id' => intval($value->id),
                            'crossword_id' => $value->crossword_id,
                            'question' => $value->question,
                            'definition_type' => $value->definition_type,
                            'meta' => $value->meta,
                            'level' => intval($value->level),
                            'sindex' => intval($value->sindex),
                            'horizontal' =>  "T",
                            'solution' => $value->solution,
                            'media_file_name' => $value->media_file_name,
                            'media_content_type' => $value->media_content_type,
                            'media_file_size' => $value->media_file_size,
                            'media_remote_url' => $value->media_remote_url,
                            'media_updated_at' => $value->media_updated_at,


                        ];

                    }else{
                        $insert[] = [
                            'id' => intval($value->id),
                            'crossword_id' => $value->crossword_id,
                            'question' => $value->question,
                            'definition_type' => $value->definition_type,
                            'meta' => $value->meta,
                            'level' => intval($value->level),
                            'sindex' => intval($value->sindex),
                            'horizontal' =>  "F",
                            'solution' => $value->solution,
                            'media_file_name' => $value->media_file_name,
                            'media_content_type' => $value->media_content_type,
                            'media_file_size' => $value->media_file_size,
                            'media_remote_url' => $value->media_remote_url,
                            'media_updated_at' => $value->media_updated_at,


                        ];
                    }

                }
                if(!empty($insert)){
                    if (DB::table('crossword_definitions')->insert($insert)){
                        return "OK";
                    }
                    dd('some errors in '.  __FILE__);
                }
            }
        }

    }


}
