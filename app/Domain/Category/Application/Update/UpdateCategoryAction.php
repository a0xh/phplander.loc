<?php declare(strict_types=1);

namespace App\Domain\Category\Application\Update;

use App\Infrastructure\Controllers\Controller;
use App\Domain\Category\Infrastructure\CategoryRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use App\Domain\Category\Domain\{Category, CategoryRequest};
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\{Put, Where};
use Illuminate\Support\Collection;
use App\Application\Traits\MediaAction;

#[Where('{category:id}', '[0-9]+')]
final class UpdateCategoryAction extends Controller
{
    use MediaAction;

    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly UpdateCategoryResponder $categoryResponder
    ) {}

    #[Put('/admin/category/{category:id}/update', name: "admin.category.update")]
    public function __invoke(Category $category, CategoryRequest $categoryRequest): RedirectResponse
    {
        $categoryDto = literal($categoryRequest->formRequest());

        $updateMedia = $this->updateMedia($category->media, $categoryDto->getMedia());

        $data = collect([
            'title' => $categoryDto->getTitle(),
            'description' => $categoryDto->getDescription(),
            'slug' => $categoryDto->getSlug(),
            'keywords' => $categoryDto->getKeywords(),
            'category_id' => $categoryDto->getCategoryId(),
            'status' => $categoryDto->getStatus()
        ]);

        $updateCategory = $this->categoryRepository->updateCategory($category,
            $data->merge([
                'user_id' => $category->user_id,
                'media' => $updateMedia,
                'type' => $category->type
            ])->toArray()
        );

        $redirectTo = $this->categoryResponder->handle($updateCategory);

        return $redirectTo;
    }
}