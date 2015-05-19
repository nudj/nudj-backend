<?php namespace App\Utility\Transformers;


class SkillTransformer extends Transformer {

    public function transformMap($item, $column) {

        switch($column) {
            case 'id':
                return (string) $item->id;

            case 'name':
                return (string) $item->name;

        }

    }

}