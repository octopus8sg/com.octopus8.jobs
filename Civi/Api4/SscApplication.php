<?php
namespace Civi\Api4;

/**
 * SscApplication entity.
 *
 * Provided by the FIXME extension.
 *
 * @package Civi\Api4
 */
class SscApplication extends Generic\DAOEntity {
    public static function permissions() {
        return [
            'get' => [
                'view octopus8 jobs',
            ],
            'delete' => [
                'delete octopus8 jobs',
            ],
            'create' => [
                'edit octopus8 jobs',
            ],
            'update' => [
                'edit octopus8 jobs',
            ],
        ];
    }
}
