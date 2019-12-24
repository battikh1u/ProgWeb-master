<?php

interface Importer
{
    function import();

    function createTable();

    function __construct(mysqli $conn, array $data);
}