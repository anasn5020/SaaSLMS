@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |  {{$course->title}}
@endsection
@section('og_image')
    {{getCourseImage($course->image)}}
@endsection
@section('meta_title')
    {{$course->meta_keywords}}
@endsection
@section('meta_description')
    {{$course->meta_description}}
@endsection



@section('mainContent')

    <script src="{{asset('public/frontend/infixlmstheme/js/pdf.min.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/pdfjs-viewer.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/zoom.js')}}"></script>
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/pdfjs-viewer.css')}}"/>

    <script>
        var pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = '{{asset('public/frontend/infixlmstheme/js/pdf.worker.min.js')}}';
    </script>
    <div class="w-100  h-100 pdfjs-viewer"
         style="border: none;min-height: 400px"></div>
    <script>
        let pdfViewer = new PDFjsViewer($('.pdfjs-viewer'), {
            setZoom: -1,
            maxImageSize: -1,
        });
        pdfViewer.loadDocument("{{asset($course->product->pdf)}}").then(function () {
            pdfViewer.setZoom('width');
        });
        enablePinchZoom(pdfViewer)
    </script>

@endsection

