<?php
namespace CodeQuestionEngine;


class EngineGlobalSettings
{
    /**
     * Название папки, хранящей сборочные файлы, шелл-скрипты
     * Общая папка между виртуальным и реальным хостом
     */
    const CACHE_DIR = "temp_cache";


    /**
     * Название docker-образа операционной системы
     */
    const IMAGE_NAME = "baseimage-ssh";


    /**
     * имя шаблона шелл-скрипта, запускающего код на выполнение.
     * Инструкция по созданию новых шаблонов шелл-скриптов находится в документации
     * Для добавления поддержки нового языка добавьте название скрипта сюда
     * Пример шаблона шелл скрипта для языка С:
     *
     * gcc code.c 2> errors.txt -o
     * run
        Вместо строки run программа подставит необходимые данные для запуска кода
     */
    const SHELL_SCRIPT_NAME_ARRAY = [
        \Language::C => "run.sh",

        ];
}