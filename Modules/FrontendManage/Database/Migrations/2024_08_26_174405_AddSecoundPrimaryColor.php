<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Modules\Appearance\Entities\ThemeCustomize;
use Modules\FrontendManage\Entities\FrontPage;

class AddSecoundPrimaryColor extends Migration
{
    public function up()
    {
        Schema::table('theme_customizes', function ($table) {

            if (!Schema::hasColumn('theme_customizes', 'gradient_color')) {
                $table->string('gradient_color')->nullable();
            }

            if (!Schema::hasColumn('theme_customizes', 'is_gradient')) {
                $table->boolean('is_gradient')->default(true);
            }

        });

       ThemeCustomize::query()
           ->where('id', 1)
           ->where('theme_id',1)
           ->update([
            'primary_color' => '#660AFB',
            'gradient_color' => '#BF37FF'
        ]);


    }


    public function addNewHomepage()
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

        FrontPage::updateOrCreate(
            ['slug' => 'home7'],
            [
                'name' => 'home7',
                'title' => 'Homepage v7',
                'sub_title' => '',
                'details' => $this->home7(),
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
    data-preview="' . themeAsset('img/snippets/preview/home/7.jpg') . '"

     data-aoraeditor-title="HomePage Default" data-aoraeditor-categories="Home Page">
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
        $html .= view(theme('snippets.components._home_page_course_section'))->render();
        $html .= '</div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';

        $html .= view(theme('snippets.components._home_page_testimonial_section'))->render();
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


    public function home7()
    {
        $html = '<div
    class="full-page"
    data-type="component-text"
    data-preview="' . themeAsset('img/snippets/preview/home/all_section.jpg') . '"

     data-aoraeditor-title="HomePage v7" data-aoraeditor-categories="Home Page">
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
