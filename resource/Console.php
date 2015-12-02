<?php

namespace Fool\Resource;

/**
 * Class Console Цветной вывод в консоли
 *
 * @url http://habrahabr.ru/post/119436/
 *
 * @package Fool\Resource
 */
class Console
{
    const BACKGROUND_RED    = "\033[41m";
    const BACKGROUND_YELLOW = "\033[43m";
    const BACKGROUND_GREEN  = "\033[42m";

    const COLOR_RED     = "\033[0;31m";
    const COLOR_YELLOW  = "\033[0;33m";
    const COLOR_GREEN   = "\033[0;32m";
    const COLOR_WHITE   = "\033[1;37m";

    const FULL_LINE = "\033[K";
    const CLEAR     = "\033[m";

    const TYPE_ERROR    = 'error';
    const TYPE_WARNING  = 'warning';
    const TYPE_SUCCESS  = 'success';

    /**
     * Вывести текст в терминал
     *
     * @param string        $text
     * @param string        $type
     * @param bool|false    $isBg
     * @param bool|true     $isFullLine
     */
    public static function echoColor($text, $type, $isBg = false, $isFullLine = true)
    {
        $output =  self::getColorText($text, $type, $isBg, $isFullLine);
        echo $isFullLine ? $output : $output . PHP_EOL;
    }

    /**
     * Сделать текст цветным
     *
     * @param string        $text
     * @param string        $type
     * @param bool|false    $isBg
     *
     * @return string
     */
    public static function textColor($text, $type, $isBg = false)
    {
        return self::getColorText($text, $type, $isBg, false);
    }

    /**
     * Получить цветной текст
     *
     * @param string    $text       Текст
     * @param string    $type       Тип цвета
     * @param bool      $isBg       Окрасить в цвет фон
     * @param bool      $isFullLine Окрасить фон до конца строки
     *
     * @return string
     */
    private static function getColorText($text, $type, $isBg, $isFullLine)
    {
        $background = '';
        $color = '';
        switch ($type) {
            case self::TYPE_SUCCESS:
                $background = self::BACKGROUND_GREEN;
                $color      = self::COLOR_GREEN;
                break;
            case self::TYPE_ERROR:
                $background = self::BACKGROUND_RED;
                $color      = self::COLOR_RED;
                break;
            case self::TYPE_WARNING:
                $background = self::BACKGROUND_YELLOW;
                $color      = self::COLOR_YELLOW;
                break;
        }
        $text = ($isBg ? $background . self::COLOR_WHITE : $color) . $text;

        if ($isBg && $isFullLine) {
            $text .= self::FULL_LINE . PHP_EOL;
        }

        return $text . self::CLEAR;
    }
}