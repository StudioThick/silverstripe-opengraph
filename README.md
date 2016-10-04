# SilverStripe OpenGraph extension

This module is a work in progress. Bug reports or feature requests welcome.

This module adds a `getOpenGraph` method to the Page class to be used in
templates. Calling `$OpenGraph` in a template will return a series of 
automatically generated tags corresponding to the standard open graph 
attributes.

- `og:title`: from `$Title`
- `og:type`: hardcoded to `"website"`
- `og:image`: absolute URL. tries `$HeroImage`, `$PostImage`, `$Image`, then `$FeaturedImage`
- `og:image:width`: width, as `og:image`
- `og:image:height`: height, as `og:image`
- `og:url`: absolute URL of page (`Director::protocolAndHost() . $this->Link`)
- `og:description`: from `$MetaDescription`
- `og:locale`: from `i18n::get_locale()`
- `og:site_name`: from `$SiteConfig.Title`

- `og:determiner`: unused
- `og:locale:alternate`: unused
- `og:audio`: unused
- `og:video`: unused

All of the above can be overridden in `Page.php` or a given subclass according
to the naming convention `getOpenGraph_attribute`, with `og` removed and `:`s 
replaced with spaces. For example, `getOpenGraph_image_width()`.

To override the image selection behaviour (for example, to return a static
image, or to return a field that is not in the list that the extension searches
for), simply implement `getOpenGraphImage()` to return a SilverStripe Image
object.

## Installation

Install via `composer require studiothick/silverstripe-opengraph`.

## Usage

Example:

```html
<head>
    <title>$SiteConfig.Title | $Title</title>

    $OpenGraph

</head>
```

