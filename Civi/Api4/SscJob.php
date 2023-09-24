<?php
namespace Civi\Api4;

/**
 * SscJob entity.
 *
 * Provided by the FIXME extension.
 *
 * @package Civi\Api4
 */
class SscJob extends Generic\DAOEntity {
    public static function permissions() {
        return [
            'get' => [
                VIEW_OCTOPUS_8_JOBS,
                EDIT_OCTOPUS_8_JOBS,
                APPLY_OCTOPUS_8_JOBS,
                DELETE_OCTOPUS_8_JOBS
            ],
            'delete' => [
                EDIT_OCTOPUS_8_JOBS,
                DELETE_OCTOPUS_8_JOBS
            ],
            'create' => [
                EDIT_OCTOPUS_8_JOBS,
            ],
            'update' => [
                EDIT_OCTOPUS_8_JOBS,
            ],
        ];
    }
}
