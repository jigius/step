# Step - Simple sTream tExt Processor

This is the simple library for transforms text chunks printed out into standard output (STDOUT).

It has minimal memory consumtion.

Example of creating google's sitemap files:
```
<?php
use Jigius\Step\Processor as P;
use Jigius\Step\Processor\Repository\Local;
use Jigius\Step\ChunkInterface;

// Creating classes for later using by the processor
final class UrlChunk implements ChunkInterface
{
    ...
}

final class SitemapChunkPrinter implements P\Redirect\ChunkPrinterInterface
{
    ...
}

final class SitemapChunk implements ChunkInterface
{
    ...
}

// Creating `Processor` instance
(new P\WithRedirected(
    new P\WithResetOnException(
        new P\WithPersistedInto(
            new P\Limit\WithQuantityLimit(
                new P\Limit\WithLengthLimit(
                    new P\WithProlog(
                        new P\WithEpilog(
                            new P\Plain(),
                            <<< EOT
</urlset>
EOT,
                        ),
                        <<< EOT
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
EOT,
                    ),
                    50 * 1000 * 1000 /* ~50Mb  */
                ),
                50000
            ),
            new Local\Repository(
                sys_get_temp_dir(),
                new Local\Urn\SerialUrn("foo/sitemap{%NUM%}.xml.gz", 1),
                new Local\Printer\GzipedTextFilePrinter()
            )
        )
    ),
    new P\WithSupressed(
        new P\WithPersistedInto(
            new P\Limit\WithQuantityLimit(
                new P\Limit\WithLengthLimit(
                    new P\WithProlog(
                        new P\WithEpilog(
                            new P\Plain(),
                            <<< EOT
</sitemapindex>
EOT,
                            false
                        ),
                        <<< EOT
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
EOT,
                        false
                    ),
                    50 * 1000 * 1000 /* ~50Mb */
                ),
                50000
            ),
            new Local\Repository(
                sys_get_temp_dir(),
                new Local\Urn\StaticUrn("foo/sitemap.xml"),
                new Local\Printer\TextFilePrinter()
            ),
            false
        )
    ),
    new SitemapChunkPrinter()
))
/* Outputing the chunk */
->outputed(
    (new Url())
    ->withUrl(...)
    ->withLastmod(...)
    ->withPriority(...)
    ->withChangefreq(...)
)
/* Outputing the chunk */
->outputed(
    (new Url())
        ->withUrl(...)
        ->withLastmod(...)
        ->withPriority(...)
        ->withChangefreq(...)
)
/* Outputing chunks */
...
/* Finished */
->reset();
?>
```
