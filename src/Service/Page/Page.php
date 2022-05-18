<?php
declare(strict_types=1);

namespace App\Service\Page;

class Page
{

    protected bool   $showNavbar          = false;
    protected string $title               = '';
    protected string $h1                  = '';
    protected string $h2                  = '';
    protected array  $javaScriptVariables = [];

    /**
     * @return bool
     */
    public function isShowNavbar(): bool
    {

        return $this->showNavbar;
    }

    /**
     * @param bool $showNavbar
     *
     * @return Page
     */
    public function setShowNavbar(bool $showNavbar): Page
    {

        $this->showNavbar = $showNavbar;

        return $this;
    }

    /**
     * @return string
     */
    public function getH1(): string
    {

        return $this->h1;
    }

    /**
     * @param string $h1
     *
     * @return Page
     */
    public function setH1(string $h1): Page
    {

        $this->h1 = $h1;

        return $this;
    }

    /**
     * @return string
     */
    public function getH2(): string
    {

        return $this->h2;
    }

    /**
     * @param string $h2
     *
     * @return Page
     */
    public function setH2(string $h2): Page
    {

        $this->h2 = $h2;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {

        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Page
     */
    public function setTitle(string $title): Page
    {

        $this->title = $title;

        return $this;
    }

    /**
     * @return array
     */
    public function getJavaScriptVariables(): array
    {

        return $this->javaScriptVariables;
    }

    public function setFromArray(array $values): Page
    {

        $this->title               = $values['title'] ?? $this->title;
        $this->h1                  = $values['h1'] ?? $this->h1;
        $this->h2                  = $values['h2'] ?? $this->h2;
        $this->showNavbar          = $values['showNavbar'] ?? $this->showNavbar;
        $this->javaScriptVariables = $values['javaScriptVariables'] ?? $this->javaScriptVariables;

        return $this;
    }


}