<?php
/**
 * @var Kirby\Cms\File $image
 * @var string $sizes
 * @var string $srcset
 * @var string $title
 * @var string $class
 * @var string $caption
 */

use Kirby\Toolkit\Config;

if (!isset($title)) {
    $title = '';
}
if (!isset($sizes)) {
    $sizes = '';
}
if (!isset($class)) {
    $class = '';
}
if (!isset($caption)) {
    $caption = '';
}

if (!isset($srcset)) {
    throw new Exception('images: you need to add a srcset');
}

if (!isset($image)) {
    throw new Exception('images: image is not defined');
}

if (!($image instanceof Kirby\Cms\File)) {
    throw new Exception('images: image is not type of \Kirby\Cms\File');
};

$config = Config::get('thumbs.srcsets.' . $srcset);

if (!$config) {
    throw new Exception('images: srcset ' . $srcset . ' doesn\'t exist');
}

foreach ($avif = $config as $key => $value) {
    $avif[$key]['format'] = 'avif';
}

foreach ($webp = $config as $key => $value) {
    $webp[$key]['format'] = 'webp';
}
?>

<figure <?php e($class != '', 'class="' . $class . '"') ?> >
    <picture>
        <source
            srcset="<?= $image->srcset($avif) ?>"
            sizes="<?= $sizes ?>"
            type="image/avif"
        >
        <source
            srcset="<?= $image->srcset($webp) ?>"
            sizes="<?= $sizes ?>"
            type="image/webp"
        >
        <img
            alt="<?= $image->alt() ? $image->alt() : $title ?>"
            loading="lazy"
            src="<?= $image->resize(400)->url() ?>"
            srcset="<?= $image->srcset($srcset) ?>"
            sizes="<?= $sizes ?>"
            width="<?= $image->resize(400)->width() ?>"
            height="<?= $image->resize(400)->height() ?>"
        >
    </picture>

    <?php if ($caption != ''): ?>
        <figcaption><?= $caption ?></figcaption>
    <?php endif; ?>
</figure>
