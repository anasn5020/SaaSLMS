<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Entities\LessonFile;

class CreateLessonFilesTable extends Migration
{
    public function up()
    {

        Schema::table('lessons', function ($table) {
            if (!Schema::hasColumn('lessons', 'file_id')) {
                $table->integer('file_id')->nullable();
            }
        });
        Schema::create('lesson_files', function (Blueprint $table) {
            $table->id();
            $table->integer('lesson_id');
            $table->text('link')->nullable();
            $table->float('version')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('size')->nullable();
            $table->text('type')->nullable();
            $table->text('scorm_title')->nullable();
            $table->text('scorm_version')->nullable();
            $table->text('scorm_identifier')->nullable();
            $table->timestamps();
        });

        $lessons = Lesson::all();
        foreach ($lessons as $lesson) {
            if ($this->selfHosted($lesson->host)) {
                LessonFile::create([
                    'lesson_id' => $lesson->id,
                    'link' => $lesson->video_url,
                    'version' => 1,
                    'updated_by' => $lesson->course->user_id,
                    'size' => $lesson->file_size,
                    'scorm_title' => $lesson->scorm_title,
                    'scorm_version' => $lesson->scorm_version,
                    'scorm_identifier' => $lesson->scorm_identifier,
                    'type' => $lesson->host,

                ]);
            }

        }
    }

    public function down()
    {
        Schema::dropIfExists('lesson_files');
    }

    public function selfHosted($type)
    {
        $self = ['Self', 'SCORM', 'XAPI', 'PowerPoint', 'Excel', 'Text', 'Word', 'PDF', 'Image', 'Zip'];
        if (in_array($type, $self)) {
            return true;
        } else {
            return false;
        }
    }
}
