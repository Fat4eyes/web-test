<?php

class ConnectionConfigSettings
{


    /**
     * @var string URL основного сервиса
     */
    public static $BASE_URL = "www.code-question.ru";


    public static $RUN_PROGRAM_URL = "/api/program/runProgram";

    /**
     * @var array Белый список IP  для пользования внешними модулями
     */
    public static $WHITE_LIST = ["127.0.0.1","192.168.0.100"];

}