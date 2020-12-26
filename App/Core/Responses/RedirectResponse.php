<?php


namespace App\Core\Responses;

use App\Config\Configuration;

class RedirectResponse extends Response
{
    private string $redirectUrl;

    /**
     * RedirectResponse constructor.
     * @param string $redirectUrl
     */
    public function __construct(string $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    public function generate()
    {
        if(!Configuration::DEBUG_QUERY) {
            header("Location: " . $this->redirectUrl);
        } else {
            echo 'In SQL debug mode you have to <a href="' . $this->redirectUrl . '">follow redirect</a> manually."';
        }
    }
}