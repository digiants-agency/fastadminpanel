<div class="project-card">
    <div class="project-card-image-block">
        <a href="{{ route('projects', $project->slug, false) }}"><img src="{{ $project->image }}" alt="" class="project-card-image"></a>
        <x-elements.tag>
            {{ date_format( date_create($project->created_at), 'd.m.Y') }}
        </x-elements.tag>  
    </div>
    <div class="project-card-content">
        <a class="h4 color-text project-card-content-title" href="{{ route('projects', $project->slug, false) }}">{{ $project->title }}</a>
        <div class="main-text color-text project-card-content-desc">{!! $project->short_description !!}</div>
        <x-inputs.button type="empty" size="small" href="{{ route('projects', $project->slug, false) }}">
            {{ $fields['button_text'] }}
        </x-inputs.button>
    </div>
</div>


@desktopcss

<style>
    
    .project-card {
        margin-top: 30px;
        padding: 20px;
        padding-right: 65px;
        display: flex;
        align-items: center;
        background: var(--color-white);
        border: 2px solid var(--color-back-and-stroke);
        border-radius: 20px;
        transition: .3s;
    }
    
    .project-card:hover {
        box-shadow: 0px 4px 25px 2px #F4F4F4;
    }

    .project-card-image-block {
        width: 485px;
        height: 311px;
        position: relative;
        flex-shrink: 0;
        margin-right: 50px;
    }

    .project-card-image {
        width: 485px;
        height: 311px;
        object-fit: cover;
        border-radius: 15px;
    }

    .project-card-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .project-card-content-title {
        margin-bottom: 10px;
        transition: .3s;
    }

    .project-card-content-title:hover{
        color: var(--color-second);
    }

    .project-card-content-desc {
        margin-bottom: 30px;
    }
    
</style>

@mobilecss

<style>

    .project-card {
        margin-top: 20px;
        padding: 10px 10px 25px;
        background: var(--color-white);
        border: 2px solid var(--color-back-and-stroke);
        border-radius: 20px;
        transition: .3s;
    }

    .project-card-image-block {
        width: 100%;
        height: 264px;
        position: relative;
        flex-shrink: 0;
        margin-bottom: 10px;
    }

    .project-card-image {
        width: 100%;
        height: 264px;
        object-fit: cover;
        border-radius: 15px;
    }

    .project-card-content-title {
        margin-bottom: 8px;
    }

    .project-card-content-desc {
        margin-bottom: 46px;
    }

</style>

@endcss