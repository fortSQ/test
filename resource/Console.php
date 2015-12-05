<?php

// Вкл. строгую типизацию, исключение - TypeError
declare(strict_types = 1);

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

    /**
     * Вывести текст в терминал
     *
     * @param string        $text
     * @param string        $type
     * @param bool|false    $isBg
     * @param bool|true     $isFullLine
     */
    public static function echoColor(string $text, string $type, bool $isBg = false, bool $isFullLine = true)
    {
        $output = self::getColorText($text, $type, $isBg, $isFullLine);
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
    public static function textColor(string $text, string $type, bool $isBg = false): string
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
    private static function getColorText(string $text, string $type, bool $isBg, bool $isFullLine): string
    {
        $typeClass = self::getTypeByType($type);
        $text = ($isBg ? $typeClass->background . self::COLOR_WHITE : $typeClass->color) . $text;

        if ($isBg && $isFullLine) {
            $text .= self::FULL_LINE . PHP_EOL;
        }

        return $text . self::CLEAR;
    }

    /**
     * Получить класс по типу
     *
     * @param string $type Тип цвета
     *
     * @return Type
     */
    private static function getTypeByType(string $type): Type
    {
        $map = [
            Type::ERROR    => new Type(Type::ERROR, self::BACKGROUND_RED, self::COLOR_RED),
            Type::SUCCESS  => new Type(Type::SUCCESS, self::BACKGROUND_GREEN, self::COLOR_GREEN),
            Type::WARNING  => new Type(Type::WARNING, self::BACKGROUND_YELLOW, self::COLOR_YELLOW),
        ];
        return $map[$type];
    }
}

/**
 * Class Type Тип цвета
 *
 * @package Fool\Resource
 */
class Type
{
    const ERROR    = 'error';
    const WARNING  = 'warning';
    const SUCCESS  = 'success';

    public $background;
    public $color;

    public function __construct(string $type, string $background, string $color)
    {
        if (in_array($type, [self::ERROR, self::WARNING, self::SUCCESS])) {
            $this->background = $background;
            $this->color = $color;
        }
    }
}
