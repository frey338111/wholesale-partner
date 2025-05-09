<?php
declare(strict_types=1);

namespace Wholesale\PartnerPortal\Reusable;

trait UrlTrait
{
    /**
     * Check if path is valid structure
     *
     * @param string $basePath
     * @param string $path
     *
     * @return bool
     */
    protected function isValidPath(string $basePath, string $path): bool
    {
        $base = \trim($basePath, '/');
        $input = \trim($path, '/');
        $escapedBase = \preg_quote($base, '#');
        $pattern = "#^{$escapedBase}(/[\w-]+)?/?$#";

        return (bool)\preg_match($pattern, $input);
    }

    /**
     * Extract slug from given position
     *
     * @param int    $pos
     * @param string $path
     *
     * @return string|null
     */
    protected function extractSlug(int $pos, string $path): ?string
    {
        $segments = \explode('/', \trim($path, '/'));

        return $segments[$pos] ?? null;
    }

    /**
     * Get save path of image inside media folder
     *
     * @return string
     */
    protected function getLogoImageSavePath(): string
    {
        return 'partnerlogo';
    }
}