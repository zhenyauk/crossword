<?php

namespace App\Transformers;

use App\GameSave;
use League\Fractal\TransformerAbstract;

class PuzzleTransform extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform( $crossword )
    {



        return  [
             $crossword->progress,
            //$crossword->id

        ];
    }
}
