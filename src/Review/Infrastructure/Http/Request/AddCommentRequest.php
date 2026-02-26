<?php declare(strict_types=1);

namespace App\Review\Infrastructure\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Class AddCommentRequest
 * @package App\Review\Infrastructure\Http\Request
 * @author Tomasz Bielecki <bieleckitomasz94@gmail.com>
 */
final readonly class AddCommentRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        public string $authorName,

        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 2000)]
        public string $content,
    ) {}
}
 