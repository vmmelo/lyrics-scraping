<?php
namespace App;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\WebDriverDimension;

class Vagalume
{
    protected $driver;

    public function __construct()
    {
        $host = 'http://chrome:4444/wd/hub';
        $this->driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
        $size = new WebDriverDimension(1280, 2000);
        $this->driver->manage()->window()->setSize($size);
    }

    public function getLyrics($musicName)
    {
        $musicPageLink = '';
        if(!$musicName) {
            $this->closeBrowser();
            return false;
        }
        $urlSearch = $this->mountSearchUrl($musicName);
        $this->driver->get($urlSearch);
        $this->driver->navigate();
        $this->driver->wait(3);
        $gstitles = $this->driver->findElements(
            WebDriverBy::className('gs-title')
        );
        // percorre os elementos com a classe gs-title ate achar o primeiro que contem o link
        foreach($gstitles as $key => $gstitle){
            if($gstitle->getAttribute('href')){
                $musicPageLink = $gstitle->getAttribute('href');
                break;
            }
        }
        // finaliza se nao achou nenhum link da musica
        if(!$musicPageLink) {
            $this->closeBrowser();
            return false;
        }
echo $musicPageLink . '<br>';
echo $urlSearch;
        $this->driver->get($musicPageLink);
        $this->driver->wait(2);
        $lyric = $this->driver->findElement(
            WebDriverBy::id('lyrics')
        );
        $this->closeBrowser();
        dd($lyric->getText());
        return true;
    }

    public function mountSearchUrl ($musicName)
    {
        $queryMusic = str_replace(' ', '+', $musicName);
        return 'https://www.vagalume.com.br/search?q=' . $queryMusic;
    }

    function __destruct()
    {
        if ($this->driver) {
            $this->closeBrowser();
        }
    }

    protected function closeBrowser()
    {
        if (!$this->driver) {
            throw new Exception("The browser hasn't been initialized yet");
        }

        $this->driver->quit();
        $this->driver = null;
    }
}
