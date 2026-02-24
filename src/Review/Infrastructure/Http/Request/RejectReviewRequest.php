<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RejectReviewRequest
 * @package App\Review\Infrastructure\Http\Request
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class RejectReviewRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 10, max: 1000)]
        public string $reason = '',
    ) {}
}
 