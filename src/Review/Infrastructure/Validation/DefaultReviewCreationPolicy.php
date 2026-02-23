<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Validation;

use App\Review\Domain\Service\ReviewCreationPolicy;
use App\Review\Domain\ValueObject\TenantId;
use App\Review\Domain\ValueObject\ProductSku;

/**
 * Class DefaultReviewCreationPolicy
 * @package App\Review\Infrastructure\Validation
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final class DefaultReviewCreationPolicy implements ReviewCreationPolicy
{
    public function ensureTenantExists(TenantId $tenantId): void
    {
        // TODO: Check tenant in DB or external Tenant service
        // throw TenantNotFoundException::withId($tenantId);
    }

    public function ensureProductExists(TenantId $tenantId, ProductSku $sku): void
    {
        // TODO: Check product catalog (API or DB)
        // throw ProductNotFoundException::withSku($sku);
    }
}
 