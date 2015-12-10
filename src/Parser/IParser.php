<?php

namespace Cpeter\PhpCmsVersionChecker\Parser;

interface IParser {
    /**
     * @param $subject string
     * @param $options array
     * @return mixed
     */
    public function parse($subject, $options);
}