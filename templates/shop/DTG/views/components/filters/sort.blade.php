<div class="sort">
    <div class="sort-title h5 color-text">
        {{ $fields['title'] }}:
    </div>
    <x-inputs.select :items="$fields['sort_items']" :current="$sort" action="make_sort(this)" />
</div>

@desktopcss
<style>
    
    .sort {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .sort-title {
        margin-right: 20px;
    }

</style>
@mobilecss
<style>
    
    .sort {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .sort-title {
        margin-right: 20px;
        display: none;
    }

</style>
@endcss

@js
<script>
    
    async function make_sort(elm){
        let href = window.location.href.split('?')[0] + '?sort=' + $(elm).data('href')
        
        const response = await post(href, {is_sort: true}, true, true)

        if (response.success){
            
            
            $('#content-block').html(response.data.html)

            $('#pagination').html(response.data.pagination)

            $('#sort').html(response.data.sort)

            history.pushState({}, '', href)

            $('.callback-form input[name="link"]').val(href)

            window.scrollTo({ top: 0, behavior: 'smooth' });

        } else {

        }

        return false



    }

</script>
@endjs