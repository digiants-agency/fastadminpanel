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
                
                <?php if (isset($pagination['arrow_first'])): ?>
                    <div class="pagination-btn-wrapper" onclick="make_pagination(this); return false;">
                        <a 
                            href="<?php echo ($pagination['link']) ?>" 
                            class="pagination-btn"
                        >
                            <svg class="pagination-arrow-left" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.59855 6.61582L13.074 0.158317C13.2861 -0.0531316 13.6296 -0.0527762 13.8414 0.15941C14.0531 0.37157 14.0525 0.715252 13.8403 0.926865L7.75034 7.00002L13.8405 13.0732C14.0527 13.2848 14.0532 13.6283 13.8416 13.8404C13.7355 13.9468 13.5964 14 13.4573 14C13.3185 14 13.18 13.9472 13.074 13.8415L6.59855 7.3842C6.49636 7.28254 6.43902 7.14418 6.43902 7.00002C6.43902 6.85587 6.49653 6.71767 6.59855 6.61582Z" fill="#333333"/>
                                <path d="M1.59855 6.61582L8.07396 0.158317C8.28612 -0.0531316 8.62961 -0.0527762 8.84141 0.15941C9.05305 0.37157 9.05251 0.715252 8.84032 0.926865L2.75034 7.00002L8.84054 13.0732C9.0527 13.2848 9.05324 13.6283 8.84163 13.8404C8.73546 13.9468 8.59636 14 8.45726 14C8.31852 14 8.17997 13.9472 8.07399 13.8415L1.59855 7.3842C1.49636 7.28254 1.43902 7.14418 1.43902 7.00002C1.43902 6.85587 1.49653 6.71767 1.59855 6.61582Z" fill="#333333"/>
                            </svg>         
                        </a>
                    </div>
                <?php endif; ?>

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
                <?php if (isset($pagination['arrow_last'])): ?>
                    <div class="pagination-btn-wrapper" onclick="make_pagination(this); return false;">
                        <a 
                            href="<?php echo ($pagination['link']) ?><?php echo $pagination['separator'] ?>page=<?php echo $pagination['arrow_last'] ?>" 
                            class="pagination-btn"
                        >
                            <svg class="pagination-arrow-right" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.40145 6.61582L1.92604 0.158317C1.71388 -0.0531316 1.37039 -0.0527762 1.15859 0.15941C0.946947 0.37157 0.947494 0.715252 1.15968 0.926865L7.24966 7.00002L1.15946 13.0732C0.947303 13.2848 0.946756 13.6283 1.15837 13.8404C1.26454 13.9468 1.40364 14 1.54274 14C1.68148 14 1.82003 13.9472 1.92601 13.8415L8.40145 7.3842C8.50364 7.28254 8.56098 7.14418 8.56098 7.00002C8.56098 6.85587 8.50347 6.71767 8.40145 6.61582Z" fill="#333333"/>
                                <path d="M13.4015 6.61582L6.92604 0.158317C6.71388 -0.0531316 6.37039 -0.0527762 6.15859 0.15941C5.94695 0.37157 5.94749 0.715252 6.15968 0.926865L12.2497 7.00002L6.15946 13.0732C5.9473 13.2848 5.94676 13.6283 6.15837 13.8404C6.26454 13.9468 6.40364 14 6.54274 14C6.68148 14 6.82003 13.9472 6.92601 13.8415L13.4015 7.3842C13.5036 7.28254 13.561 7.14418 13.561 7.00002C13.561 6.85587 13.5035 6.71767 13.4015 6.61582Z" fill="#333333"/>
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

@startjs
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
