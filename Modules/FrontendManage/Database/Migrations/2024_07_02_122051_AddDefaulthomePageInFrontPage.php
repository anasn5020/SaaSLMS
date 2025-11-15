<?php

use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\FrontPage;

class AddDefaulthomePageInFrontPage extends Migration
{
    public function up()
    {
        FrontPage::updateOrCreate(
            ['slug' => 'home0'],
            [
                'name' => 'home0',
                'title' => 'Homepage',
                'sub_title' => '',
                'details' => $this->home0(),
                'is_static' => 0,
                'status' => 1
            ]
        );
    }

    public function home0()
    {
        $html = '<div
    class="full-page"
    data-type="component-text"
    data-preview="' . themeAsset('img/snippets/preview/home/all_section.jpg') . '"

     data-aoraeditor-title="All Section" data-aoraeditor-categories="Home Page">
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_banner'))->render();
        $html .= '</div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
                   $html .= view(theme('snippets.components._home_page_category_section'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
                   $html .= view(theme('snippets.components._home_page_instructor_section'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
   $html .= view(theme('snippets.components._home_page_course_section'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
    $html .= view(theme('snippets.components._home_page_best_category_section'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
   $html .= view(theme('snippets.components._home_page_quiz_section'))->render();
        $html .= '</div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';

   $html .= view(theme('snippets.components._home_page_testimonial_section'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
   $html .= view(theme('snippets.components._home_sponsor'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
   $html .= view(theme('snippets.components._home_page_blog_section'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
   $html .= view(theme('snippets.components._home_page_become_instructor_section'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
   $html .= view(theme('snippets.components._home_page_how_to_buy'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
   $html .= view(theme('snippets.components._home_page_faq'))->render();
        $html .= '</div>
        </div>
    </div>

</div>';
        return $html;
    }

    public function down()
    {
        //
    }
}
