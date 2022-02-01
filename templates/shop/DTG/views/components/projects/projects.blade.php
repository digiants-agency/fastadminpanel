<div class="projects @if($button) mb-100 @endif">
    <div class="container-offset">
        <div class="h2 color-text">{{ $fields['title'] }}</div>
        
        <div class="projects-inner">
            @foreach ($projects as $project)
                <x-projects.project-card :project="$project" />
            @endforeach
        </div>

        @if ($button)
            <x-inputs.button type="center" href="{{ Lang::link($fields['button_link']) }}">
                {{ $fields['button_text'] }}
            </x-inputs.button>    
        @endif
    </div>
</div>


@desktopcss

<style>

    .projects-inner {
        display: flex;
        flex-wrap: wrap;
    }


    .project-card:last-child {
        margin-bottom: 30px;
    }
    
</style>

@mobilecss

<style>

    .project-card:last-child {
        margin-bottom: 25px;
    }

</style>

@endcss
