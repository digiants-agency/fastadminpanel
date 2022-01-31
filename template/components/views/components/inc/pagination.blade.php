<?php if (!empty($pagination)): ?>
    
    @if ($showmore && isset($pagination['arrow_right']))
    
        <div class="show-more-wrapper" onclick="make_pagination(this, true); return false;">

            <x-inputs.button 
                type="empty center catalog" 
                :href="$pagination['link'].$pagination['separator'].'page='.$pagination['arrow_right']" 
            >
                {{ $fields['showmore'] }}
            </x-inputs.button>
        </div>
    @endif

    <div class="pagination-wrapper mb-100">
        <div class="container">
            <div class="pagination">
                
                <?php if (isset($pagination['arrow_left'])): ?>
                    <div class="pagination-btn-wrapper" onclick="make_pagination(this); return false;">
                        <a 
                            href="<?php echo ($pagination['link']) ?><?php echo ($pagination['arrow_left'] != 1) ? $pagination['separator'].'page='.$pagination['arrow_left'] : '' ?>" 
                            class="pagination-btn"
                        >
                            <svg class="pagination-arrow-left" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.90292 5.67074L8.44405 0.129616C8.62749 -0.0475487 8.91981 -0.0424621 9.09697 0.140979C9.26981 0.31993 9.26981 0.603615 9.09697 0.782538L3.88231 5.9972L9.09697 11.2119C9.27725 11.3922 9.27725 11.6845 9.09697 11.8648C8.91664 12.0451 8.62435 12.0451 8.44405 11.8648L2.90292 6.32366C2.72265 6.14333 2.72265 5.85105 2.90292 5.67074Z" fill="#333333"/>
                                <clipPath id="clip0_102_2474">
                                <rect width="12" height="12" fill="white" transform="matrix(-1 0 0 1 12 0)"/>
                                </clipPath>
                            </svg>
                                
                        </a>
                    </div>
                <?php endif; ?>
                <div class="pagination-btn-wrapper" onclick="make_pagination(this); return false;">
                    <a 
                        href="<?php echo ($pagination['link']) ?>" 
                        class="pagination-btn<?php if ($pagination['active'] == 1) echo ' active' ?>"
                    >
                        1
                    </a>
                </div>

                <?php if (isset($pagination['middle'])): ?>
                    <?php foreach ($pagination['middle'] as $item): ?>
                        <?php if ($item == -1): ?>
                            <div class="pagination-btn pagination-btn-empty">...</div>
                        <?php else: ?>
                        <div class="pagination-btn-wrapper" onclick="make_pagination(this); return false;">
                            <a 
                                href="<?php echo ($pagination['link']) ?><?php echo $pagination['separator'] ?>page=<?php echo $item ?>" 
                                class="pagination-btn<?php if ($pagination['active'] == $item) echo ' active' ?>"
                            >
                                <?php echo $item ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="pagination-btn-wrapper" onclick="make_pagination(this); return false;">
                    <a  
                        href="<?php echo ($pagination['link']) ?><?php echo $pagination['separator'] ?>page=<?php echo $pagination['last'] ?>" 
                        class="pagination-btn<?php if ($pagination['active'] == $pagination['last']) echo ' active' ?>"
                    >
                        <?php echo $pagination['last'] ?>
                    </a>
                </div>
                <?php if (isset($pagination['arrow_right'])): ?>
                    <div class="pagination-btn-wrapper" onclick="make_pagination(this); return false;">
                        <a 
                            href="<?php echo ($pagination['link']) ?><?php echo $pagination['separator'] ?>page=<?php echo $pagination['arrow_right'] ?>" 
                            class="pagination-btn"
                        >
                            <svg class="pagination-arrow-right" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.09708 5.67074L3.55595 0.129616C3.37251 -0.0475487 3.08019 -0.0424621 2.90303 0.140979C2.73019 0.31993 2.73019 0.603615 2.90303 0.782538L8.11769 5.9972L2.90303 11.2119C2.72275 11.3922 2.72275 11.6845 2.90303 11.8648C3.08336 12.0451 3.37565 12.0451 3.55595 11.8648L9.09708 6.32366C9.27735 6.14333 9.27735 5.85105 9.09708 5.67074Z" fill="#333333"/>
                                <clipPath id="clip0_102_2453">
                                    <rect width="12" height="12" fill="white"/>
                                </clipPath>
                            </svg>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
<?php endif; ?>


@desktopcss

<style>

    .pagination-wrapper {
        /* margin-top: -60px; */
    }

    .pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .pagination-btn {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 24px;
        color: var(--color-text);
        margin: 0 7.5px;
        background: var(--color-back-and-stroke);
        border-radius: 5px;
        transition: .3s;
        cursor: pointer;
    }

    .pagination-btn.active,
    .pagination-btn:hover {
        background-color: var(--color-second);
        color: var(--color-white);
    }

    .pagination-btn path {
        fill: var(--color-text);
        transition: .3s;
    }

    .pagination-btn:hover path {
        fill: var(--color-white);
    }

    .pagination-arrow-left,
    .pagination-arrow-right {
        width: 14px;
        height: 14px;
    }
</style>

@mobilecss

<style>

    .pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .pagination-btn {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 19px;
        color: var(--color-text);
        margin: 0 3.5px;
        background: var(--color-back-and-stroke);
        border-radius: 5px;
        cursor: pointer;
    }

    .pagination-btn.active {
        background-color: var(--color-second);
        color: var(--color-white);
    }

    .pagination-btn path {
        fill: var(--color-text);
    }

    .pagination-arrow-left,
    .pagination-arrow-right {
        width: 12px;
        height: 12px;
    }

</style>

@endcss

@js
<script>
     

    async function make_pagination(elm, showmore = false){

        let href = $(elm).child().attr('href')

        const response = await post(href, {}, true, true)

        if (response.success){
            
            if (showmore){
                
                html = $('#content-block').child().html()
                
                const elem = document.createElement('div');
                $(elem).addClass('showmore-content')
                $(elem).html(response.data.html)
                request_html = $(elem).child().html()
                elem.remove()
                
                $('#content-block').child().html(html + request_html)

            } else {
                $('#content-block').html(response.data.html)
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            $('#pagination').html(response.data.pagination)

            url = document.location.protocol + '//' + document.location.hostname + href
            history.pushState({}, '', url)


        } else {

        }

        return false

    }


</script>
@endjs
