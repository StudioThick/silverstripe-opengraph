<?php

class OpenGraphExtension extends DataExtension {

    public static $keys = array(
        'title',
        'type',
        'image',
        'image:width',
        'image:height',
        'url',
        'description',

        'determiner',
        'locale',
        'locale:alternate',
        'site_name',
        'audio',
        'video'
    );

    private function getCanonicalURL($url) {
        return Director::protocolAndHost() . $url;
    }

    public function getOpenGraph_type() {
        return 'website';
    }

    public function getOpenGraph_locale() {
        return i18n::get_locale();
    }

    public function getOpenGraph_description() {
        return $this->owner->MetaDescription;
    }

    public function getOpenGraph_site_name() {
        return SiteConfig::current_site_config()->Title;
    }

    public function getOpenGraphImage() {
        $page = $this->owner->data();
        $tries = array('HeroImage', 'PostImage', 'Image');
        foreach($tries as $t) {
            $i = $page->hasOneComponent($t);
            if($i) {
                return $page->getComponent($t);
            }
        }
        return null;
    }
    
    public function getOpenGraph_image_height() {
        $im = $this->owner->getOpenGraphImage();
        if($im && $im->exists()) {
            return $im->Height;
        }
    }
    
    public function getOpenGraph_image_width() {
        $im = $this->owner->getOpenGraphImage();
        if($im && $im->exists()) {
            return $im->Width;
        }
    }
    
    public function getOpenGraph_image() {
        $im = $this->owner->getOpenGraphImage();
        if($im && $im->exists()) {
            return $this->getCanonicalURL($im->URL);
        }
    }

    public function getOpenGraph_title() {
        return $this->owner->Title;
    }

    public function getOpenGraph_url() {
        $page = $this->owner;
        return $this->getCanonicalUrl($page->XML_val('Link'));
    }

    public function getOpenGraph_determiner() {
        return null;
    }

    public function getOpenGraph_audio() {
        return null;
    }

    public function getOpenGraph_video() {
        return null;
    }

    public function getOpenGraph_locale_alternate() {
        return null;
    }

    public function getOpenGraph() {
        $tags = '';
        foreach(OpenGraphExtension::$keys as $k) {
            $key = str_replace(':', '_', $k);
            $action = "getOpenGraph_$key";
            $val = $this->owner->$action();
            if($val) {
                $val = Convert::raw2att($val);
                $tags .= "<meta name=\"og:$k\" content=\"$val\" />\n";
            }
        }
        return $tags;
    }

}
