<?php

define('BASE_NAMESPACE', 'Fool');

// расширения файлов через запятую для подгрузки функцией spl_autoload
//spl_autoload_extensions('.php');
// регистрации обработчиков при попытке доступа к классу
$reg = [
    BASE_NAMESPACE => 'src',
    BASE_NAMESPACE . '\\' . 'Resource'  => 'resource',
    BASE_NAMESPACE . '\\' . 'Test'      => 'test',
];
foreach ($reg as $namespace => $folder) {
    spl_autoload_register(function ($class) use ($namespace, $folder) {
        autoload($class, $namespace, $folder);
    });
}
/**
 * Автозагрузка класса с исходным пространством имен в директории
 *
 * @param $class
 * @param $baseNamespace
 * @param $src
 */
function autoload($class, $baseNamespace, $src) {
    $baseNamespace = $baseNamespace . '\\';
    // убираем название пакета (корень пространства имен)
    if (substr($class, 0, strlen($baseNamespace)) == $baseNamespace) {
        $class = substr($class, strlen($baseNamespace));
    }
    $directory = '';
    // пока в пространстве имен встречаем разделитель пространства имен
    while ($pos = strpos($class, '\\')) {
        // добавляем такую директорию и убираем ее из полного названия класса
        $directory .= substr($class, 0, $pos) . DIRECTORY_SEPARATOR;
        $class = substr($class, $pos + 1);
    }
    $load = dirname(__FILE__) . DIRECTORY_SEPARATOR . $src . DIRECTORY_SEPARATOR . $directory . $class;
    // подгрузка, аналог require_once
    //spl_autoload_extensions('.php');
    //spl_autoload($load);
    if (is_file($load . '.php')) {
        require_once $load . '.php';
    }
    //echo '<pre>' . $baseNamespace . ' ' . $class . ' - ' . $load . '</pre>';
}

########################################################################################################################
# Таким образом, при попытке обращения к классу Fool\Test\ExampleTest, автозагрузчик будет пытаться загрузить:
# 1) src\Test\ExampleTest.php
# 2) resource\Fool\Test\ExampleTest.php
# 3) test\ExampleClass.php