<script type="text/x-template" id="template-content">
    <div class="content">
        <div class="content-title" v-text="menu_item.title"></div>
        <template-menu v-if="content == 'Edit table'"></template-menu>
        <template-languages v-else-if="content == 'Languages'"></template-languages>
        <template-index v-show="content == 'Index table'" ref="index"></template-index>
    </div>
</script>
    
<script src="/vendor/fastadminpanel/js/components/content.js"></script>