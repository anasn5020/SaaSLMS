<?php

namespace Modules\CourseSetting\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;

class CourseSeederTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();
        app()->setLocale('en');
//        1
        Course::create([
            'title' => 'MERN - Full Stack Web Development',
            'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'This advanced course in managerial accounting covers advanced topics such as cost behavior, budgeting, variance analysis, and strategic decision-making. It is designed for professionals aiming to deepen their understanding of managerial accounting principles.',
            'status' => 1,
            'category_id' => 1,
            'subcategory_id' => 6,
            'user_id' => 1,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'requirements' => 'Participants should have a basic understanding of accounting principles and financial statements. Familiarity with spreadsheets and financial software is recommended.',
            'outcomes' => 'Upon completion of this course, participants will be able to analyze complex cost behaviors, prepare comprehensive budgets, conduct variance analysis, and make strategic financial decisions.',
            'image' => 'public/frontend/infixlmstheme/img/course/1.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/1.jpg',
        ]);
//Course 2
        Course::create([
            'title' => 'Learn 3D In Blender Tutorial for Beginners',
             'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'An Entire MBA in 1 Course is an award-winning course designed to provide a comprehensive overview of business administration. It covers essential topics ranging from finance and marketing to operations and strategy, all condensed into one extensive course.',
            'status' => 1,
            'category_id' => 1,
            'subcategory_id' => 7,
            'user_id' => 2,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'reveune' => '50',
            'requirements' => 'Participants should have basic knowledge of business concepts and terminology.',
            'outcomes' => 'Upon completing this course, participants will gain a solid understanding of MBA-level business topics, enhancing their decision-making skills and strategic thinking abilities.',
            'image' => 'public/frontend/infixlmstheme/img/course/2.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/2.jpg',
        ]);
//Course 3
        Course::create([
            'title' => 'Learn WordPress Theme Development with WordPress',
             'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'Learn 3D modeling in Blender from scratch with this beginner-friendly course. Master fundamental techniques and create stunning 3D models for animations, games, and more.',
            'status' => 1,
            'category_id' => 2,
            'subcategory_id' => 8,
            'user_id' => 2,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'reveune' => '50',
            'requirements' => 'No prior experience required. A computer capable of running Blender is recommended.',
            'outcomes' => 'By the end of the course, you will be able to create 3D models, understand Blender\'s interface, and apply various modeling techniques effectively.',
            'image' => 'public/frontend/infixlmstheme/img/course/3.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/3.jpg',
        ]);

//        Course 4
        Course::create([
            'title' => 'Learn English in 30 Days',
             'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'Learn how to create stunning 3D environments using Blender, a powerful open-source software. This course covers essential techniques and tools for modeling, texturing, and rendering 3D scenes.',
            'status' => 1,
            'category_id' => 2,
            'subcategory_id' => 9,
            'user_id' => 2,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'reveune' => '50',
            'requirements' => 'No prior experience required. Familiarity with Blender interface is helpful.',
            'outcomes' => 'By the end of the course, you will be able to create detailed 3D environments, apply realistic textures, and render high-quality images and animations.',
            'image' => 'public/frontend/infixlmstheme/img/course/4.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/4.jpg',
        ]);
//Course 5
        Course::create([
            'title' => 'Mastering in Laravel',
             'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'Learn essential UI/UX design skills using Adobe XD. This course covers design principles, wireframing, prototyping, and collaboration techniques for creating user-friendly interfaces.',
            'status' => 1,
            'category_id' => 3,
            'subcategory_id' => 10,
            'user_id' => 2,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'reveune' => '50',
            'requirements' => 'No prior experience required. Basic familiarity with design concepts is beneficial.',
            'outcomes' => 'By the end of the course, you will be able to create interactive prototypes, understand user experience principles, and apply design best practices using Adobe XD.',
            'image' => 'public/frontend/infixlmstheme/img/course/5.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/5.jpg',
        ]);
//        Course 6
        Course::create([
            'title' => 'Mastering in Docker for Software Developers',
             'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'Learn the fundamentals of web design using HTML and CSS. This course covers essential concepts such as layout, styling, and responsiveness, enabling you to create visually appealing and functional websites.',
            'status' => 1,
            'category_id' => 3,
            'subcategory_id' => 11,
            'user_id' => 2,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'reveune' => '50',
            'requirements' => 'No prior experience required. Basic familiarity with computers and internet usage is recommended.',
            'outcomes' => 'By the end of the course, you will be able to design and develop static web pages using HTML and CSS, understand best practices for web design, and create responsive layouts.',
            'image' => 'public/frontend/infixlmstheme/img/course/6.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/6.jpg',
        ]);

        //        Course 7
        Course::create([
            'title' => 'Graphics Design for Beginners',
             'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'Explore the fundamentals of programming and mobile app development in this introductory course. Learn essential coding concepts and start building your own applications.',
            'status' => 1,
            'category_id' => 4,
            'subcategory_id' => 12,
            'user_id' => 2,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'reveune' => '50',
            'requirements' => 'No prior programming experience required. Basic understanding of computers and software applications recommended.',
            'outcomes' => 'By the end of the course, you will be able to write basic programs, understand programming logic, and develop simple mobile applications.',
            'image' => 'public/frontend/infixlmstheme/img/course/7.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/7.jpg',
        ]);

        //Course 8
        Course::create([
            'title' => 'Kickstart Your SQA Career',
             'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'Master iOS app development with Swift in this comprehensive course covering iOS 11. Learn to build fully functional mobile applications from scratch and publish them on the App Store.',
            'status' => 1,
            'category_id' => 5,
            'subcategory_id' => 14,
            'user_id' => 1,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'reveune' => '50',
            'requirements' => 'No prior programming experience required. A Mac computer with Xcode installed is recommended.',
            'outcomes' => 'By the end of the course, you will be able to develop iOS apps using Swift, understand iOS app architecture, and deploy apps to the App Store.',
            'image' => 'public/frontend/infixlmstheme/img/course/8.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/8.jpg',
        ]);

        //        Course 9
        Course::create([
            'title' => 'Mastering in Webflow ',
             'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'Become a proficient Python developer from scratch in 2020 with this comprehensive course. Learn Python fundamentals, advanced techniques, and practical applications in real-world projects.',
            'status' => 1,
            'category_id' => 5,
            'subcategory_id' => 13,
            'user_id' => 1,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'reveune' => '50',
            'requirements' => 'No prior programming experience required. Basic knowledge of computer usage is recommended.',
            'outcomes' => 'By the end of the course, you will be able to develop Python applications, understand Python libraries and frameworks, and apply Python in data analysis and web development.',
            'image' => 'public/frontend/infixlmstheme/img/course/9.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/9.jpg',
        ]);

        Course::create([
            'title' => 'Ethical Hacking Course',
             'duration' => rand(10, 30),
            'publish' => 1,
            'level' => rand(1, 3),
            'trailer_link' => 'https://www.youtube.com/watch?v=mlqWUqVZrHA',
            'host' => 'Youtube',
            'about' => 'Learn Laravel PHP framework from basics to advanced through practical projects. Master database integration, authentication, and complex application development with Laravel.',
            'status' => 1,
            'category_id' => 5,
            'subcategory_id' => 15,
            'user_id' => 1,
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
            'lang_id' => 19,
            'reveiw' => rand(1, 5),
            'total_enrolled' => 1,
            'reveune' => '50',
            'requirements' => 'Basic understanding of PHP programming language. Familiarity with web development concepts like HTML, CSS, and JavaScript.',
            'outcomes' => 'By the end of the course, you will be proficient in Laravel framework, capable of building scalable web applications, implementing RESTful APIs, and integrating third-party services.',
            'image' => 'public/frontend/infixlmstheme/img/course/10.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/course/10.jpg',
        ]);


//        course end




        Course::create([
            'quiz_id' => 1,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => 'PHP Programming Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/1.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/1.jpg',
            'type' => 2,
            'about' => 'Test your knowledge and skills in PHP programming with this comprehensive quiz. Covering topics from basic syntax to advanced features, this quiz will help you assess your proficiency in PHP.',
            'requirements' => 'Basic understanding of programming concepts.',
            'outcomes' => 'Gain a deeper understanding of PHP programming language. Identify areas of improvement in your PHP skills.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

        Course::create([
            'quiz_id' => 2,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => 'Python Programming Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/2.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/2.jpg',
            'type' => 2,
            'about' => 'This quiz tests your knowledge of Python programming language. Covering both fundamental and advanced topics, it\'s ideal for assessing your Python skills.',
            'requirements' => 'Basic understanding of programming concepts.',
            'outcomes' => 'Evaluate your Python programming proficiency. Identify strengths and weaknesses in Python programming.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

        Course::create([
            'quiz_id' => 3,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => 'HTML5 Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/3.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/3.jpg',
            'type' => 2,
            'about' => 'Assess your knowledge of HTML5 with this quiz. Covering tags, attributes, and best practices, this quiz will help you gauge your understanding of modern web development.',
            'requirements' => 'Basic understanding of HTML fundamentals.',
            'outcomes' => 'Enhance your proficiency in HTML5. Identify areas for improvement in HTML5 development.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

        Course::create([
            'quiz_id' => 1,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => 'CSS3 Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/4.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/4.jpg',
            'type' => 2,
            'about' => 'Test your knowledge of CSS3 with this comprehensive quiz. Covering selectors, properties, and advanced techniques, this quiz will help you evaluate your CSS skills.',
            'requirements' => 'Basic understanding of CSS fundamentals.',
            'outcomes' => 'Improve your understanding of CSS3. Identify areas to focus on for mastering CSS3 development.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

        Course::create([
            'quiz_id' => 2,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => 'jQuery Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/5.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/5.jpg',
            'type' => 2,
            'about' => 'Assess your knowledge of jQuery with this quiz. Covering selectors, events, and AJAX, this quiz will help you gauge your proficiency in using jQuery for web development.',
            'requirements' => 'Basic understanding of JavaScript and HTML.',
            'outcomes' => 'Evaluate your jQuery skills. Identify areas for improvement in jQuery development.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

        Course::create([
            'quiz_id' => 3,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => 'Laravel Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/6.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/6.jpg',
            'type' => 2,
            'about' => 'Test your knowledge of Laravel with this comprehensive quiz. Covering Laravel\'s features, Eloquent ORM, and Laravel ecosystem, this quiz will help you assess your Laravel proficiency.',
            'requirements' => 'Basic understanding of PHP and web development.',
            'outcomes' => 'Enhance your skills in Laravel development. Identify areas for further learning and improvement in Laravel.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

        Course::create([
            'quiz_id' => 1,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => '.NET Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/7.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/7.jpg',
            'type' => 2,
            'about' => 'Assess your knowledge of .NET framework with this quiz. Covering C#, ASP.NET, and .NET ecosystem, this quiz will help you evaluate your proficiency in .NET development.',
            'requirements' => 'Basic understanding of C# and web development concepts.',
            'outcomes' => 'Evaluate your skills in .NET development. Identify areas for improvement and further learning in .NET framework.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

        Course::create([
            'quiz_id' => 2,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => 'AutoCAD Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/8.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/8.jpg',
            'type' => 2,
            'about' => 'Test your knowledge of AutoCAD with this quiz. Covering CAD drawing, 3D modeling, and AutoCAD tools, this quiz will help you assess your proficiency in using AutoCAD software.',
            'requirements' => 'Basic understanding of CAD and design concepts.',
            'outcomes' => 'Enhance your skills in using AutoCAD software. Identify areas for improvement in CAD drawing and 3D modeling.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

        Course::create([
            'quiz_id' => 3,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => 'MBA Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/9.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/9.jpg',
            'type' => 2,
            'about' => 'Assess your knowledge of MBA concepts with this quiz. Covering business management, marketing, and finance, this quiz will help you evaluate your understanding of MBA principles.',
            'requirements' => 'Basic understanding of business and management principles.',
            'outcomes' => 'Evaluate your knowledge in MBA concepts. Identify areas for improvement and further learning in business management.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

        Course::create([
            'quiz_id' => 1,
            'user_id' => 1,
            'lang_id' => 19,
            'title' => 'Vue.js Quiz',
             'image' => 'public/frontend/infixlmstheme/img/quiz/10.jpg',
            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/10.jpg',
            'type' => 2,
            'about' => 'Test your knowledge of Vue.js framework with this quiz. Covering Vue.js components, Vue Router, and Vuex, this quiz will help you assess your proficiency in Vue.js development.',
            'requirements' => 'Basic understanding of JavaScript and web development concepts.',
            'outcomes' => 'Enhance your skills in Vue.js development. Identify areas for improvement and further learning in Vue.js framework.',
            'price' => rand(200, 500),
            'discount_price' => rand(100, 199),
        ]);

//        Course::create([
//            'quiz_id' => 2,
//            'user_id' => 1,
//            'lang_id' => 19,
//            'title' => 'React Quiz',
//             'image' => 'public/frontend/infixlmstheme/img/quiz/11.jpg',
//            'thumbnail' => 'public/frontend/infixlmstheme/img/quiz/11.jpg',
//            'type' => 2,
//            'about' => 'Assess your knowledge of React framework with this quiz. Covering React components, hooks, and state management, this quiz will help you evaluate your proficiency in React development.',
//            'requirements' => 'Basic understanding of JavaScript and HTML.',
//            'outcomes' => 'Evaluate your skills in React development. Identify areas for improvement and further learning in React framework.',
//            'price' => rand(200, 500),
//            'discount_price' => rand(100, 199),
//        ]);



        $categories = Category::all();
        foreach ($categories as $category) {
            $this->updateTotalCountForCategory($category);
        }


    }

    public function updateTotalCountForCategory($category)
    {

        $category->total_courses = count($category->courses);
        $category->total_quizzes = $category->QuizzesCount;
        $category->save();
    }

}
