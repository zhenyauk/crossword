<?php

namespace App\Transformers;

use App\Crossword;
use League\Fractal\TransformerAbstract;

class GameTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Crossword $crossword)
    {
        return [
            'game_title'=>$crossword->content,
            'height'=>$crossword->height,
            'width'=>$crossword->width,
            'level'=>$crossword->level,
            'fields'=>$crossword->crossword_definition,
        ];
    }
}
