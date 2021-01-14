<?php

if (!class_exists("DatabaseException")) {
    class DatabaseException extends Exception
    {
        const ERROR_CONSTRAINT = 1451;
    }
}
