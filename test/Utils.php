<?php

namespace Athens\Core\Test;

use Athens\Core\Row\RowBuilder;
use Athens\Core\Field\Field;
use Athens\Core\Row\RowInterface;

class Utils
{

    const INT_FIELD_NAME = "FirstField";
    const STRING_FIELD_NAME = "SecondField";

    /**
     * @return RowInterface[]
     * @throws \Exception
     */
    public static function makeRows()
    {
        $rows = [];
        for ($i = 0; $i < 100; $i++) {
            $rows[] = RowBuilder::begin()
                ->addWritable(
                    new Field([], [], "literal", "a literal field", rand(1, 100)), Utils::INT_FIELD_NAME, Utils::INT_FIELD_NAME
                )
                ->addWritable(
                    new Field([], [], "literal", "a literal field", (string)rand()), Utils::STRING_FIELD_NAME, Utils::STRING_FIELD_NAME
                )
                ->build();
        }
        return $rows;
    }

    /**
     * Takes a small sample from the given rows' int fields and produces the median of that sample.
     *
     * Useful for finding an int field that is neither the greatest nor smallest among the rows.
     *
     * @param RowInterface[] $rows
     * @return int
     */
    public static function sampleMedianIntField(array $rows)
    {
        $rand_keys = array_rand($rows, 5);

        $vals = array_map(
            function ($key) use ($rows) {
                return $rows[$key]->getWritableBearer()->getWritableByHandle(Utils::INT_FIELD_NAME)->getInitial();
            },
            $rand_keys
        );

        sort($vals);
        return ($vals[2]);
    }

    /**
     * Find the difference between two arrays of objects.
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function arrayDiffObjects(array $array1, array $array2)
    {
        return array_udiff(
            $array1,
            $array2,
            function ($a, $b) {
                return strcmp(spl_object_hash($a), spl_object_hash($b));
            }
        );
    }
}
