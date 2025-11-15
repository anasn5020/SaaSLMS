<div>
    <div class="pathway_section">

        <div class="">
            {{__('frontend.Date Enrolled')}} : {{showDate($enrolld->created_at)}}
        </div>
        @if ($enrolld->enrolled_by!=null)
            <div class="">
                {{__('frontend.Enrolled By')}} : {{@$enrolld->enrolledBy->name}}
            </div>
        @endif
        @if ($enrolld->pathway_id!=null)
            <div class="">
                {{__('frontend.Pathway')}} : {{@$enrolld->pathway->name}}
            </div>
        @endif
    </div>
</div>
