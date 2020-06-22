<?php
namespace App;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;

class Vagalume
{
    public function getLyrics($musicName) {

        $queryMusic = str_replace(' ', '+', $musicName);
        $url = 'https://google.com'; // definindo a url como a do google
        $host = 'http://chrome:4444/wd/hub'; // Host default
        $driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
        $driver->get($url); // realizando uma requisição HTTP get na $url

        $pesquisa = $driver->findElement(     //método findElement encontra um elemento do html
            WebDriverBy::name('q')     //WebDriverBy::id definimos aqui o id do elemento
        )->sendKeys('Dia dos Namorados'); //método sendKeys "digita" na barra de pesquisa

        $pesquisa->sendKeys(array(WebDriverKeys::ENTER)); //método sendKeys enviando um ENTER na pesquisa
        dd($driver->getPageSource());
        return true;
    }
}
