<?php

use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\HeaderMenu;

class AddNewHomePageAndThemeUpdate extends Migration
{
    public function up()
    {
        $this->addNewHomepage();
        $this->addHeaderMenu();
        UpdateGeneralSetting('header_style', 2);
        UpdateGeneralSetting('footer_style', 2);
    }

    public function addHeaderMenu()
    {
        $page = FrontPage::where('slug', 'home7')->first();

        if ($page) {
            $item = [
                'type' => $page->is_static ? 'Static Page' : 'Dynamic Page',
                'title' => $page->title,
                'element_id' => $page->id,
                'link' => url($page->slug),
                'parent_id' => 1,
                'position' => 999,
                'show' => 0,
                'is_newtab' => 0,
                'mega_menu' => 0,
                'mega_menu_column' => 2,
            ];
            HeaderMenu::create($item);
        }
    }

    public function addNewHomepage()
    {

        FrontPage::updateOrCreate(
            ['slug' => '/'],
            [
                'name' => 'home0',
                'title' => 'Homepage',
                'sub_title' => '',
                'details' => $this->home7(),
                'is_static' => 0,
                'status' => 1
            ]
        );

        FrontPage::updateOrCreate(
            ['slug' => 'home0'],
            [
                'name' => 'home0',
                'title' => 'Homepage',
                'sub_title' => '',
                'details' => $this->home7(),
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
                'details' => $this->home0(),
                'is_static' => 0,
                'status' => 1
            ]
        );
    }

    public function home7()
    {
        $html = '<div
    class="full-page"
    data-type="component-text"
    data-preview="' . themeAsset('img/snippets/preview/home/7.jpg') . '"
    data-aoraeditor-title="HomePage Default" data-aoraeditor-categories="Home Page">
       <link rel="stylesheet" href="'.themeAsset('css/sections/homepage_v7.css').'">
        <style>
            :root {
                --system_primary_gredient1: #660AFB;
                --system_primary_gredient2: #BF37FF;
                --system_primary_color: linear-gradient(77.16deg, var(--system_primary_gredient1) 13.44%, var(--system_primary_gredient2) 87.24%);
                --system_secendary_color: #1F2B40;
                --fontFamily1: "Plus Jakarta Sans", sans-serif;
                --fontFamily2: "Inter", sans-serif;
            }

        </style>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_banner_v7'))->render();
        $html .= '</div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_featured_section_v7'))->render();
        $html .= '</div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_category_section_v7'))->render();
        $html .= '</div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';

        $html .= view(theme('snippets.components._home_page_course_section_v7'))->render();
        $html .= '</div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_client_section_v7'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_testimonial_section_v7'))->render();
        $html .= '</div>
    </div>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_latest_course_section_v7'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_instructor_section_v7'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_faq_section_v7'))->render();
        $html .= '</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_page_cta_section_v7'))->render();
        $html .= '</div>
        </div>
    </div>

</div>';
        return $html;
    }


    public function home0()
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
