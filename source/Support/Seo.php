<?php

namespace Source\Support;
use CoffeeCode\Optimizer\Optimizer;

class Seo{

    /*** @var*/
    protected $optimizer;

    /**
     * Seo constructor.
     * @param string $schema
     */
    public function __construct(string $schema = "article")
    {
        $this->optimizer = new Optimizer();
        $this->optimizer->openGraph(CONF_SITE_NAME, CONF_SITE_LANG, $schema)
        ->twitterCard(CONF_SOCIAL_TWITTER_CREATOR, CONF_SOCIAL_TWITTER_PUBLISHER, CONF_SITE_DOMAIN)
        ->publisher(CONF_SOCIAL_FB_PAGE, CONF_SOCIAL_FB_AUTHOR)
        ->facebook(CONF_SOCIAL_FB_APPID);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->optimizer->data()->$name;
    }


    /**
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $image
     * @param bool $follow
     * @return string
     */
    public function render(string $title, string $description, string $url, string $image, bool $follow = true): string
    {
        return $this->optimizer->optimize($title, $description, $url, $image, $follow)->render();
    }


    /**
     * @return Optimizer
     */
    public function optimizer():Optimizer
    {
        return $this->optimizer;
    }

    /**
     * @param string|null $title
     * @param string|null $desc
     * @param string|null $url
     * @param string|null $image
     * @return object|null
     */
    public function data(?string $title, ?string $desc, ?string $url, ?string $image)
    {
        return $this->optimizer->data($title, $desc, $url, $image);
    }

}
