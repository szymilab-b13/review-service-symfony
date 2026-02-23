<?php declare(strict_types=1);

namespace App\Review\Domain\Service;

use App\Review\Domain\ValueObject\TenantId;
use App\Review\Domain\ValueObject\ProductSku;

/**
 * Interface ReviewCreationPolicy
 * @package App\Review\Domain\Service
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
interface ReviewCreationPolicy
{
    /** @throws \DomainException if tenant is invalid */
    public function ensureTenantExists(TenantId $tenantId): void;

    /** @throws \DomainException if product is invalid */
    public function ensureProductExists(TenantId $tenantId, ProductSku $sku): void;
}