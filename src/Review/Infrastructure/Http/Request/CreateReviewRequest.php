<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateReviewRequest
 * @package App\Review\Infrastructure\Http\Request
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class CreateReviewRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $tenantId = '',

        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 64)]
        public string $productSku = '',

        #[Assert\NotBlank]
        #[Assert\Range(min: 1, max: 50)]
        public int $rating = 0,

        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 255)]
        public string $title = '',

        #[Assert\NotBlank]
        #[Assert\Length(min: 10, max: 5000)]
        public string $body = '',

        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 100)]
        public string $authorName = '',

        /** @var string[] */
        #[Assert\All([new Assert\Type('string')])]
        public array $tags = [],
    ) {}
}
 