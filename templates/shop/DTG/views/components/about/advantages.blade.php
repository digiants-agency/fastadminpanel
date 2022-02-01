<div class="advantages mb-100">
    <div class="container">
        <div class="advantages-inner">
            <div class="h2 color-text advantages-title">{{ $fields['title'] }}</div>
            <div class="advantages-items">
                @foreach ($fields['advantages'] as $advantage)
                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="{{ $advantage[2] }}" srcset="/images/lazy.svg" alt="" class="advantages-icon-image">
                        </div>
                        <div class="advantages-content">
                            <div class="h5 color-text advantages-item-title">{{ $advantage[0] }}</div>
                            <div class="main-text color-text advantages-item-desc">{{ $advantage[1] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


@desktopcss

<style>
    
    .advantages-title {
        text-align: center
    }

    .advantages-items{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 40px;
        margin-bottom: -30px;

    }

    .advantages-item{
        width: 290px;
        margin: 0 29px;
        margin-bottom: 30px;
    }

    .advantages-icon {
        position: relative;
        z-index: 1;
        width: 100px;
        height: 100px;
        background: var(--color-second);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .advantages-icon-image {
        width: 50px;
        height: 50px;
    }

    .advantages-content {
        background: #FFFFFF;
        box-shadow: 0px 4px 25px 2px #F4F4F4;
        border-radius: 20px;
        padding: 65px 17px 30px;
        position: relative;
        z-index: 0;
        margin-top: -50px;
        height: calc(100% - 50px);
    }

    .advantages-item-title,
    .advantages-item-desc {
        text-align: center
    }

    .advantages-item-title{
        margin-bottom: 10px;
    }

</style>

@mobilecss
<style>
    
    .advantages-title {
        text-align: center
    }

    .advantages-items{
        margin-top: 35px;
    }

    .advantages-item{
        width: 100%;
        margin-bottom: 35px;
    }

    .advantages-item:last-child {
        margin-bottom: 0;
    }

    .advantages-icon {
        position: relative;
        z-index: 1;
        width: 80px;
        height: 80px;
        background: var(--color-second);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .advantages-icon-image {
        width: 40px;
        height: 40px;
    }

    .advantages-content {
        background: #FFFFFF;
        box-shadow: 0px 4px 25px 2px #F4F4F4;
        border-radius: 20px;
        padding: 55px 20px 25px;
        position: relative;
        z-index: 0;
        margin-top: -40px;
        height: calc(100% - 40px);
    }

    .advantages-item-title,
    .advantages-item-desc {
        text-align: center
    }

    .advantages-item-title{
        margin-bottom: 10px;
        font-weight: 500;
    }

</style>
@endcss
