<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\ELibrary\Entities\Ebook;
use Modules\ELibrary\Entities\EbookAccess;
use Modules\ELibrary\Repositories\Interfaces\EbookRepositoryInterface;
use Modules\Group\Entities\GroupMember;
use Modules\MyClass\Entities\LmsClass;

class Elibrary extends Component
{
    private $ebookRepository;

    public function __construct(
        EbookRepositoryInterface $ebookRepository
    )
    {
        $this->ebookRepository = $ebookRepository;
    }

    public function render()
    {
        $student_id = auth()->user()->id;
        $ebook_ids = $this->ebookRepository->haveAccess($student_id);
        $ebooks = Ebook::whereIn('id', $ebook_ids)->get();
        return view(theme('components.elibrary'), compact('ebooks'));
    }
}
