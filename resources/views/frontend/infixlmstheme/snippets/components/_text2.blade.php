<div data-type="component-nonExisting"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/text.png')}}"
     data-website="website01"
     data-blog="blog01" data-article="article01" data-tags="tag01,tag02"
     data-aoraeditor-title="Text block with dynamic content" data-aoraeditor-categories="Text;Dynamic component">
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro labore architecto fuga tempore omnis aliquid,
        rerum numquam deleniti ipsam earum velit aliquam deserunt, molestiae officiis mollitia accusantium suscipit
        fugiat esse magnam eaque cumque, iste corrupti magni? Illo dicta saepe, maiores fugit aliquid consequuntur aut,
        rem ex iusto dolorem molestias obcaecati eveniet vel voluptatibus recusandae illum, voluptatem! Odit est
        possimus nesciunt.</p>
    {{--    <div data-dynamic-href="snippets/dynamic_content.html"></div>--}}
    <div class="dynamicData" data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
</div>
